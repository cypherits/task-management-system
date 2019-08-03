<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Bootstrap Dashboard by Bootstrapious.com</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/font-awesome/css/all.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/select2/css/select2.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/datetimepicker/css/datetimepicker.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/datatables/datatables.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>css/style.default.css" id="theme-stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>css/custom.css">
        <link rel="shortcut icon" href="<?= base_url('assets/') ?>img/favicon.ico">
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    </head>
    <body>
        <div class="page login-page">
            <div class="container">
                <div class="form-outer text-center d-flex align-items-center">
                    <div class="form-inner">
                        <div class="logo text-uppercase"><span>Task Management</span> <strong class="text-primary">System</strong></div>
                        <div class="alert alert-danger d-none">hello</div>
                        <form id="login-form" method="post" class="text-left" action="<?= base_url('auth/user_auth') ?>">
                            <div class="form-group-material">
                                <input id="username" type="text" name="username" placeholder="Please enter your username" class="input-material">
                                <!--<label for="login-username" class="label-material">Username</label>-->
                            </div>
                            <div class="form-group-material">
                                <input id="password" type="password" name="password" placeholder="Please enter your password" class="input-material">
                                <!--<label for="login-password" class="label-material">Password</label>-->
                            </div>
                            <div class="form-group text-center"><button id="login" class="btn btn-primary">Login</button>
                                <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                            </div>
                        </form><a href="#" class="forgot-pass">Forgot Password?</a>
                    </div>
                    <div class="copyrights text-center">
                        <p>Developed by <a href="https://www.facebook.com/azim.uddin.tipu" class="external">Azim Uddin</a></p>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url('assets/') ?>vendor/font-awesome/js/all.min.js"></script>
        <script src="<?= base_url('assets/') ?>vendor/select2/js/select2.min.js"></script>
        <script src="<?= base_url('assets/') ?>vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?= base_url('assets/') ?>vendor/moment/moment.min.js"></script>
        <script src="<?= base_url('assets/') ?>vendor/datetimepicker/js/datetimepicker.min.js"></script>
        <script src="<?= base_url('assets/') ?>vendor/ckeditor/ckeditor.js"></script>
        <script src="<?= base_url('assets/') ?>vendor/datatables/datatables.min.js"></script>
        <script src="<?= base_url('assets/') ?>js/front.js"></script>
        <script>
            var csrf = '<?= $this->security->get_csrf_hash() ?>';
            $(document).on('submit', '#login-form', function (e) {
                e.preventDefault();
                var username = $('#username').val();
                var password = $('#password').val();
                if (username == '' || password == '') {
                    $('.alert').html('Username And Password Required!').removeClass('d-none');
                    setTimeout(function () {
                        $('.alert').addClass('d-none');
                    }, 5000);
                    return false;
                }
                $.ajax({
                    method: 'POST',
                    url: '<?= base_url('auth/user_auth') ?>',
                    data: {
                        username: username,
                        password: password,
<?= $this->security->get_csrf_token_name() ?>: csrf
                    },
                    beforeSend: function () {
                        $('button').prop('disabled', true);
                    },
                    success: function (r) {
                        $('button').prop('disabled', false);
                        if (r.msg == 'ok') {
                            window.location.href = '<?= base_url() ?>';
                        } else {
                            csrf = r.csrf;
                            $('.alert').html(r.msg).removeClass('d-none');
                            setTimeout(function () {
                                $('.alert').addClass('d-none');
                            }, 5000);
                        }
                    }
                });
            });
        </script>
    </body>
</html>