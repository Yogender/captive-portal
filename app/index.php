<?php

$hostname = $_GET['hostname'];
$login_by = $_GET['login-by'];
$link_login = $_GET['link-login'];
$link_login_only = $_GET['link-login-only'];
$link_logout = $_GET['link-logout'];
$link_status = $_GET['link-status'];
$link_orig = $_GET['link-orig'];
$username = $_GET['username'];
$error = $_GET['error'];
$error_orig = $_GET['error-orig'];
$logged_in = $_GET['logged-in'];
$mac = $_GET['mac'];
$ip = $_GET['ip'];
$bytes_in_nice = $_GET['bytes-in-nice'];
$bytes_out_nice = $_GET['bytes-out-nice'];
$session_time_left = $_GET['session-time-left'];
$uptime = $_GET['uptime'];
$refresh_timeout = $_GET['refresh-timeout'];
$refresh_timeout_secs = $_GET['refresh-timeout-secs'];

$redirect_url = "https://events.91springboard.com";

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="A captive portal login page of 91springboard">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>91Springboard Captive Portal</title>

    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico'/>
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- build:css styles/vendor.css -->
    <!-- bower:css -->
    <link rel="stylesheet" href="bower_components/components-font-awesome/css/font-awesome.css"/>
    <!-- endbower -->
    <!-- endbuild -->

    <!-- build:css styles/main.css -->
    <link rel="stylesheet" href="styles/main.css">
    <!-- endbuild -->

    <!-- build:js scripts/vendor/modernizr.js -->
    <script src="/bower_components/modernizr/modernizr.js"></script>
    <!-- endbuild -->

    <script type="text/javascript">
        function get_host(url) {
            if (url)
                return url.replace(/^((\w+:)?\/\/[^\/]+\/?).*$/, '$1');
            return '';
        }

        var errorMessage, actionUrl, isUserLoggedIn, hostname = '<?php echo $hostname; ?>';
        <?php

        if(!empty($error)):
            echo "errorMessage = '$error';";
        endif;

        if($logged_in == "yes"):
            echo 'isUserLoggedIn = true;';
        else:
            echo 'isUserLoggedIn = false;';
        endif;

        ?>

    </script>

    <script type="text/html">

        <?php echo "Username= " . $username . "\n" ?>
        <?php echo "Error= " . $error . "\n" ?>
        <?php echo "Error-Orig= " . $error_orig . "\n" ?>
        <?php echo "Logged-In= " . $logged_in . "\n" ?>
        <?php echo "IP= " . $ip . "\n" ?>
        <?php echo "Login-By= " . $login_by . "\n" ?>
        <?php echo "Bytes-Down= " . $bytes_in_nice . "\n" ?>
        <?php echo "Bytes-Up= " . $bytes_out_nice . "\n" ?>
        <?php echo "Session-Time-Left= " . $session_time_left . "\n" ?>
        <?php echo "Uptime= " . $uptime . "\n" ?>
        <?php echo "Refresh-Time= " . $refresh_timeout . "\n" ?>
        <?php echo "Link-Status= " . $link_status . "\n" ?>
        <?php echo "Link-Orig= " . $link_orig . "\n" ?>
        <?php echo "Link-Login= " . $link_login . "\n" ?>
        <?php echo "Link-Logout= " . $link_logout . "\n" ?>
        <?php echo "Link-Login-Only= " . $link_login_only . "\n" ?>

    </script>
</head>
<body class="full">
<!--[if lt IE 10]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<div class="container">
    <div class="row ">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 login">
            <form id="userForm" name="userForm" action="#" role="form" data-toggle="validator" method="POST">

                <fieldset>

                    <legend class="legend">91springboard</legend>

                    <?php if($logged_in == "yes"): ?>

                        <div class="header">
                            <h3 class="text-muted text-center">Session Status</h3>
                        </div>

                        <div class="status-table">

                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>IP Address</td>
                                    <td> <?php echo $ip; ?></td>
                                </tr>
                                <tr>
                                    <td>Download Bytes</td>
                                    <td> <?php echo $bytes_in_nice; ?></td>
                                </tr>
                                <tr>
                                    <td>Upload Bytes</td>
                                    <td> <?php echo $bytes_out_nice; ?></td>
                                </tr>
                                <tr>
                                    <td>Uptime</td>
                                    <td> <?php echo $uptime; ?></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                        <div id="input-hidden-fields">
                            <input type="hidden" name="erase-cookie" value="on">
                        </div>

                        <div class="input form-group col-xs-12">
                            <button type="submit" name="submit" class="submit" title="Logout">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="feedback">
                        </div>

                        <div class="input form-group col-xs-12 change-password">
                            <button type="button" class="sbutton" data-toggle="modal"
                                    data-target="#change-password-modal" title="Change Login Password">Change Login
                                Password
                            </button>
                        </div>

                    <?php else: ?>
                        <div class="header">
                            <h3 class="text-muted text-center">Login</h3>
                        </div>

                        <div class="input form-group col-xs-12">
                            <span><i class="fa fa-envelope-o"></i></span>
                            <input type="text" id="emailField" name="username" placeholder="Email/Username"
                                <?php if(!empty($username)): echo 'value="' . $username . '""'; endif; ?> required/>
                        </div>

                        <div class="input form-group col-xs-12">
                            <input type="password" id="passwordField" name="password" placeholder="Password" required/>
                            <span><i class="fa fa-key"></i></span>
                        </div>

                        <div id="input-hidden-fields">
                            <input type="hidden" name="dst" value="<?php
                            if(!empty($redirect_url)):
                                echo $redirect_url;
                            elseif(!empty($link_orig)):
                                echo $link_orig;
                            else:
                                echo $link_status;
                            endif; ?>"/>
                            <input type="hidden" name="popup" value="true"/>
                        </div>

                        <div class="input form-group col-xs-12">
                            <input type="checkbox" id="terms" required checked>
                            <label for="terms">I accept the <a href="#">Terms of Service</a></label>
                        </div>

                        <div class="input form-group col-xs-12">
                            <button type="submit" class="submit input" title="Login">
                                <i class="fa fa-sign-in"></i>
                            </button>
                        </div>

                        <div class="feedback"></div>

                    <?php endif; ?>

                </fieldset>

            </form>

            <div class="footer">
                <p class="text-center">♥ from the 91springboard team</p>
            </div>

            <?php if( $logged_in == "yes"): ?>
                <div class="modal fade" id="change-password-modal" tabindex="-1" role="dialog"
                     aria-labelledby="mySmallModalLabel">
                    <div class="modal-dialog modal-sm">

                        <form id="changePasswordForm" action="#" name="changePasswordForm" role="form"
                              data-toggle="validator" method="POST" novalidate>

                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="gridSystemModalLabel">Change Your Login Password</h4>
                                </div>

                                <div class="modal-body">

                                    <div class="row">

                                        <div id="input-hidden-fields">
                                            <input type="hidden" name="username" value="<?php echo $username; ?>"/>
                                            <input type="hidden" name="submit"/>
                                        </div>

                                        <div class="input form-group col-xs-12">
                                            <input type="password" id="currentPasswordField" name="currentPassword"
                                                   placeholder="Current Password" required/>
                                            <div class="help-block with-errors"></div>
                                            <span><i class="fa fa-key"></i></span>
                                        </div>

                                        <div class="input form-group col-xs-12">
                                            <input type="password" id="newPasswordField" name="newPassword"
                                                   placeholder="New Password" required/>
                                            <div class="help-block with-errors"></div>
                                            <span><i class="fa fa-key"></i></span>
                                        </div>

                                        <div class="input form-group col-xs-12">
                                            <input type="password" id="confirmPasswordField" name="confirmPassword"
                                                   data-match="#newPasswordField"
                                                   data-match-error="Whoops, these don't match"
                                                   placeholder="Confirm Password" required/>
                                            <div class="help-block with-errors"></div>
                                            <span><i class="fa fa-key"></i></span>
                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="sbutton" onclick="resetPasswordForm()">Reset</button>
                                    <button type="button" class="sbutton" data-dismiss="modal">Close</button>
                                    <button type="submit" name="submit" class="sbutton">Confirm</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php if ( $logged_in == "yes"): ?>
    <div class="loader">
        <svg width='100px' height='100px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"
             preserveAspectRatio="xMidYMid" class="uil-default">
            <rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(0 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(30 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.08333333333333333s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(60 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.16666666666666666s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(90 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.25s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(120 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.3333333333333333s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(150 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.4166666666666667s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(180 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.5s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(210 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.5833333333333334s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(240 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.6666666666666666s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(270 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.75s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(300 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.8333333333333334s'
                         repeatCount='indefinite'/>
            </rect>
            <rect x='46.5' y='40' width='7' height='20' rx='10' ry='10' fill='#FF7052'
                  transform='rotate(330 50 50) translate(0 -30)'>
                <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.9166666666666666s'
                         repeatCount='indefinite'/>
            </rect>
        </svg>
    </div>
    <?php endif; ?>

</div>


<!-- build:js scripts/vendor.js -->
<!-- bower:js -->
<script src="bower_components/modernizr/modernizr.js"></script>
<script src="bower_components/jquery/dist/jquery.js"></script>
<script src="bower_components/bootstrap-validator/dist/validator.min.js"></script>
<!-- endbower -->
<!-- endbuild -->

<!-- build:js scripts/plugins.js -->
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/affix.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/alert.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/modal.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/transition.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/button.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/popover.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/carousel.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/scrollspy.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/collapse.js"></script>
<script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap/tab.js"></script>
<!-- endbuild -->

<!-- build:js scripts/main.js -->
<script src="scripts/main.js"></script>
<!-- endbuild -->
</body>
</html>
