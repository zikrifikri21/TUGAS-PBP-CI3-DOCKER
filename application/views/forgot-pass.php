<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password TVRI</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background:linear-gradient(-180deg, #015799, #152776);">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="<?php echo base_url(); ?>assets/login/images/123.jpg" alt="IMG">
                </div>

                <!-- <form class="login100-form validate-form"> -->

                <?php echo form_open('C_auth/forgotpass', 'class="login100-form validate-form"'); ?>
                <span class="login100-form-title">
                    Lupa Password
                </span>
                <p class="text-muted text-center">Password akan di kirimkan ke email yang terdaftar, Silahkan masukkan email Anda untuk melakukan reset password.</p>
                <?php $notif = $this->session->flashdata('notif') ?>
                <p class="m-auto pb-1"><span class="d-flex justify-content-center alert-danger mb-2" style="border-radius: 7px;"><?= $notif ?></span></p>

                <div class="wrap-input100 validate-input" data-validate="Valid User is required">
                    <input class="input100" type="email" id="email" name="email" placeholder="Email" required>
                    <span class="focus-input100" style="color:rgba(0,0,255,0.5);"></span>
                    <span class="symbol-input100" style="color:rgba(0,0,255,0.5);">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn" style="background-color:#152776;">
                        Login
                    </button>
                </div>

                <div class="text-center p-t-12">
                    <span class="txt1">
                        Kembali ke
                    </span>
                    <a class="txt2" href="<?= base_url() ?>C_auth">
                        Login
                    </a>
                </div>
                <?= form_close() ?>
                </form>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="<?php echo base_url(); ?>assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url(); ?>assets/login/vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url(); ?>assets/login/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url(); ?>assets/login/vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>
