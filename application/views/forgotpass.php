<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMAWA Fakultas Kehutanan Dan Ilmu Lingkungan</title>
    <meta name="title" content="SIMAWA Fakultas Kehutanan Dan Ilmu Lingkungan" />
    <meta name="description" content="Aplikasi Ujian Mahasiswa Fakultas Kehutanan Dan Lingkungan Universitas Halu Oleo" />

    <!-- GOOGLE Index -->
    <meta name="google-site-verification" content="T6gVVcJrqFf3RQEbOAoVS-0fvvsauJJdSkeniH0x4gE" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://simawa.fhil.uho.ac.id/" />
    <meta property="og:title" content="SIMAWA Fakultas Kehutanan Dan Ilmu Lingkungan" />
    <meta property="og:description" content="Aplikasi Ujian Mahasiswa Fakultas Kehutanan Dan Lingkungan Universitas Halu Oleo" />
    <meta property="og:image" content="<?= base_url('assets/img/og_image.png') ?>" />

    <!-- X (Twitter) -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://simawa.fhil.uho.ac.id/" />
    <meta property="twitter:title" content="SIMAWA Fakultas Kehutanan Dan Ilmu Lingkungan" />
    <meta property="twitter:description" content="Aplikasi Ujian Mahasiswa Fakultas Kehutanan Dan Lingkungan Universitas Halu Oleo" />
    <meta property="twitter:image" content="<?= base_url('assets/img/og_image.png') ?>" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/icons/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/icons/favicon-16x16.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('assets/icons/apple-touch-icon.png') ?>">
    <link rel="manifest" href="<?= base_url('assets/icons/site.webmanifest') ?>">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #234d20 0%, #00964b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: float 20s linear infinite;
            opacity: 0.3;
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
            }

            100% {
                transform: translateY(-100px) translateX(100px);
            }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .left-side {
            background: linear-gradient(135deg, #234d20 0%, #00964b 100%);
            padding: 60px 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .left-side::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .welcome-text {
            position: relative;
            z-index: 1;
        }

        .welcome-text h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            animation: slideInLeft 0.8s ease-out;
        }

        .welcome-text p {
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.95;
            animation: slideInLeft 0.8s ease-out 0.2s both;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .decorative-icon {
            position: absolute;
            font-size: 150px;
            opacity: 0.1;
            bottom: -30px;
            right: -30px;
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .right-side {
            padding: 60px 50px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #234d20 0%, #00964b 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(35, 77, 32, 0.3);
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .logo-circle i {
            font-size: 35px;
            color: white;
        }

        .form-title {
            color: #234d20;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-subtitle {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group-custom i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #00964b;
            font-size: 18px;
            z-index: 2;
        }

        .form-control-custom {
            width: 100%;
            padding: 15px 20px 15px 55px;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #00964b;
            box-shadow: 0 0 0 4px rgba(0, 150, 75, 0.1);
            transform: translateY(-2px);
        }

        .form-control-custom::placeholder {
            color: #999;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #234d20 0%, #00964b 100%);
            border: none;
            border-radius: 50px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(35, 77, 32, 0.3);
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(35, 77, 32, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .forgot-password {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .forgot-password a {
            color: #00964b;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: #234d20;
            text-decoration: underline;
        }

        .feature-icons {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
            position: relative;
            z-index: 1;
        }

        .feature-item {
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        .feature-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .feature-item:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feature-item i {
            font-size: 40px;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .feature-item p {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        @media (max-width: 991px) {
            .left-side {
                padding: 40px 30px;
                text-align: center;
            }

            .welcome-text h1 {
                font-size: 2rem;
            }

            .decorative-icon {
                display: none;
            }

            .feature-icons {
                margin-top: 30px;
            }
        }

        @media (max-width: 767px) {
            .right-side {
                padding: 40px 30px;
            }

            body {
                padding: 10px;
            }

            .login-card {
                border-radius: 15px;
            }
        }
    </style>

</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="row no-gutters">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="left-side"
                        style="background-image: url('<?= base_url('assets/img/bg-login.jpg'); ?>'); background-size: cover; background-position: center; width: 100%; height: 100%;">
                        <div class="welcome-text" style="position: absolute; bottom: 20px; left: 20px; right: 20px; text-align: start;">
                            <h1>SIMAWA</h1>
                            <p>Sistem Manajemen Aplikasi Mahasiswa</p>
                            <p style="margin-top: 20px;">Fakultas Kehutanan dan Ilmu Lingkungan</p>
                        </div>
                        <div class="decorative-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="right-side">
                        <div class="logo-section">
                            <div class="logo-circle">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h2 class="form-title">Lupa Password</h2>
                            <p class="form-subtitle">Silakan masukkan Email atau No. HP dan NIM Anda yang terdaftar di SIMAWA untuk reset password</p>
                        </div>
                        <?= form_error('notif', '<small class="text-danger pl-3">', '</small>'); ?>

                        <form action="<?= base_url('C_auth/forgotpass'); ?>" method="post">
                            <?= $this->session->flashdata('notif'); ?>
                            <div class="input-group-custom">
                                <i class="fas fa-at"></i>
                                <input type="text"
                                    class="form-control-custom"
                                    name="email_or_phone"
                                    id="email"
                                    placeholder="Email atau No. HP"
                                    required>
                            </div>
                            <div class="input-group-custom">
                                <i class="fas fa-id-card"></i>
                                <input type="text"
                                    class="form-control-custom"
                                    name="nim"
                                    id="nim"
                                    placeholder="NIM"
                                    required>
                            </div>

                            <button type="submit" class="btn-login">
                                <i class="fas fa-sign-in-alt"></i> Lupa Password
                            </button>

                            <div class="forgot-password">
                                Ke halaman<a href="C_auth/forgotpass">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
