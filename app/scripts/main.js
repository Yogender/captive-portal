"use strict";

function setFeedbackText(html_text) {
  $(".feedback").html(html_text);
}

function hideFeedback(){
  return $(".feedback").hide().animate({"opacity":"1"}, 400);
}

function showFeedback() {
  return $(".feedback").show().animate({"opacity":"1"}, 400);
}

function showLoader() {
  $(".submit i").removeAttr('class').addClass("fa fa-spin fa-spinner").css({"color":"#fff"});
}

function hideLoader() {
  $(".submit i").removeAttr('class').addClass("fa fa-long-arrow-right").css({"color":"#fff"});
}

function formSubmitSuccessActions(){
  $(".submit i").removeAttr('class').addClass("fa fa-check").css({"color":"#fff"});
  $(".submit").css({"background":"#2ecc71", "border-color":"#2ecc71"});
  setFeedbackText("login successful <br/>redirecting...");
  showFeedback().removeClass("error").css({"background": "#2ecc71"});;
  $("input").css({"border-color":"#2ecc71"});
}

function formSubmitErrorActions(){
  setFeedbackText("Either your username or password is wrong or <br/> device limit exceeded.");
  showFeedback().css({"background": "#E84946"}).before();
  $(".feedback").addClass("error").delay(3000).fadeOut('slow');
}

function formInValidActions(){
  setFeedbackText("You missed something <br/>or entered wrong value ...");
  showFeedback().css({"background": "#E84946"}).before();
  $(".feedback").addClass("error").delay(3000).fadeOut('slow');
}

function get_query_params() {
  var queryParams = {};
  if (location.href.indexOf("?") >= 0)
  {
    var query=location.href.split("?")[1];
    var params=query.split("&");
    for (var i = 0; i < params.length; i ++) {
      var value_pair=params[i].split("=");
      queryParams[value_pair[0]] = decodeURIComponent(value_pair[1]);
    }
  }
  return queryParams;
}

//get the IP addresses associated with an account
function getInternalIP(callback){
  var ip_dups = {};

  //compatibility for firefox and chrome
  var RTCPeerConnection = window.RTCPeerConnection
    || window.mozRTCPeerConnection
    || window.webkitRTCPeerConnection;
  var useWebKit = !!window.webkitRTCPeerConnection;

  //bypass naive webrtc blocking using an iframe
  if(!RTCPeerConnection){
    //NOTE: you need to have an iframe in the page right above the script tag
    //
    //<iframe id="iframe" sandbox="allow-same-origin" style="display: none"></iframe>
    //<script>...getIPs called in here...
    //
    var win = iframe.contentWindow;
    RTCPeerConnection = win.RTCPeerConnection
      || win.mozRTCPeerConnection
      || win.webkitRTCPeerConnection;
    useWebKit = !!win.webkitRTCPeerConnection;
  }

  //minimal requirements for data connection
  var mediaConstraints = {
    optional: [{RtpDataChannels: true}]
  };

  var servers = {iceServers: [{urls: "stun:stun.services.mozilla.com"}]};

  //construct a new RTCPeerConnection
  var pc = new RTCPeerConnection(servers, mediaConstraints);

  function handleCandidate(candidate){
    //match just the IP address
    var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/
    var ip_addr = ip_regex.exec(candidate)[1];

    //remove duplicates
    if(ip_dups[ip_addr] === undefined && Object.keys(ip_dups).length ==0)
      callback(ip_addr);

    ip_dups[ip_addr] = true;
  }

  //listen for candidate events
  pc.onicecandidate = function(ice){

    //skip non-candidate events
    if(ice.candidate)
      handleCandidate(ice.candidate.candidate);
  };

  //create a bogus data channel
  pc.createDataChannel("");

  //create an offer sdp
  pc.createOffer(function(result){

    //trigger the stun server request
    pc.setLocalDescription(result, function(){}, function(){});

  }, function(){});

  //wait for a while to let everything done
  setTimeout(function(){
    //read candidate info from local description
    var lines = pc.localDescription.sdp.split('\n');

    lines.forEach(function(line){
      if(line.indexOf('a=candidate:') === 0) {
        handleCandidate(line);
      }
    });
  }, 1000);
}


$(function() {

  console.log('Welcome to 91springboard Captive Portal Login Console');

  $( ".input" ).focusin(function() {
    $( this ).find( "span" ).animate({"opacity":"0"}, 200);
  });

  $( ".input" ).focusout(function() {
    $( this ).find( "span" ).animate({"opacity":"1"}, 300);
  });

  $('#userForm').validator('validate').on('submit', function (event) {
    if (event.isDefaultPrevented()) {
      // handle the invalid form
      formInValidActions();
    }
  });

  var queryParams = get_query_params();

  if(queryParams.res == "failed"){
    formSubmitErrorActions();

    delete queryParams.res;
    delete queryParams.auth;
  }

  var params_required = ["url", "proxy", "uip", "client_mac"];

  Object.keys(queryParams).forEach(function (param) {

    if (params_required.indexOf(param) > -1 ){
      console.log("Param '" + param + "' = " + queryParams[param]);
      $("<input type='hidden' value='' />").attr("name", param).attr("value", queryParams[param]).appendTo("#input-hidden-fields");
    }
  });

  $("#userForm").attr("action", "https://vsz.91springboard.com/submitForm");

  getInternalIP(function (ip) {
    console.log("Your internal IP ::  " + ip);
  });


}());
