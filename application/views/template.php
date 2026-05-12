<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMAWA Fakultas Kehutanan Dan Ilmu Lingkungan</title>
    <meta name="title" content="SIMAWA Fakultas Kehutanan Dan Ilmu Lingkungan" />
    <meta name="description" content="Aplikasi Ujian Mahasiswa Fakultas Kehutanan Dan Lingkungan Universitas Halu Oleo" />

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

    <!-- Fonts and icons -->
    <script src="<?= base_url(); ?>assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['<?= base_url(); ?>assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/atlantis.min.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/demo.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>vendors/font-awesome/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="<?= base_url(); ?>" class="logo">
                    <img src="<?= base_url(); ?>assets/img/logo_white.png" height="70" alt="navbar brand" class="navbar-brand">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

                <div class="container-fluid">
                    <div class="collapse" id="search-nav">
                        <form class="navbar-left navbar-form nav-search mr-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control">
                            </div>
                        </form>
                    </div>
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <?php if (empty($this->session->userdata('picture_profile'))) : ?>
                                        <img alt="image" src="<?php echo base_url('assets/foto_profil/default_img.jpg'); ?>" class="avatar-img rounded-circle" alt="image">
                                    <?php else : ?>
                                        <img alt="image" src="<?php echo base_url(); ?>assets/foto_profil/<?php echo $this->session->userdata('picture_profile'); ?>" class="avatar-img rounded-circle" alt="image">
                                    <?php endif ?>
                                    <!-- <img src="<?= base_url(); ?>assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle"> -->
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                <!-- <img src="<?= base_url(); ?>assets/img/profile.jpg" alt="image profile" class="avatar-img rounded"> -->
                                                <?php if (empty($this->session->userdata('picture_profile'))) : ?>
                                                    <img alt="image" src="<?= base_url('assets/foto_profil/default_img.jpg'); ?>" class="avatar-img rounded" alt="image">
                                                <?php else : ?>
                                                    <img alt="image" src="<?php echo base_url(); ?>assets/foto_profil/<?php echo $this->session->userdata('picture_profile'); ?>" class="avatar-img rounded" alt="image">
                                                <?php endif ?>
                                            </div>
                                            <div class="u-text">
                                                <h4><?php echo $this->session->userdata('nama_pengguna'); ?></h4>
                                                <p class="text-muted"><?php echo $this->session->userdata('email'); ?></p>
                                                <a href="<?php echo base_url(); ?>C_user/change_data_pegawai/<?php echo $this->session->userdata('id'); ?>" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <!-- <a class="dropdown-item" href="#">My Profile</a>
										<a class="dropdown-item" href="#">My Balance</a>
										<a class="dropdown-item" href="#">Inbox</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#">Account Setting</a>
										<div class="dropdown-divider"></div> -->
                                        <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal" href="#">Logout</a>
                                    </li>

                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <?php if (empty($this->session->userdata('picture_profile'))) : ?>
                                <img alt="image" src="<?= base_url('assets/foto_profil/default_img.jpg'); ?>" class="avatar-img rounded-circle" alt="image">
                            <?php else : ?>
                                <img alt="image" src="<?= base_url('assets/foto_profil/' . $this->session->userdata('picture_profile')); ?>" class="avatar-img rounded-circle" alt="image">
                            <?php endif ?>
                        </div>
                        <div class="info">

                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    <?php echo $this->session->userdata('nama_pengguna'); ?>
                                    <span class="user-level">
                                        <?php $dosen = DosenFhil::table()->where(['tbl_user_id' => auth('id')])->first(); ?>
                                        <?= $dosen ? $dosen->jabatan_akademik : ''; ?>
                                    </span>
                                    <!-- <span class="caret"></span> -->
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <!-- <div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="#profile">
											<span class="link-collapse">My Profile</span>
										</a>
									</li>
									<li>
										<a href="#edit">
											<span class="link-collapse">Edit Profile</span>
										</a>
									</li>
									<li>
										<a href="#settings">
											<span class="link-collapse">Settings</span>
										</a>
									</li>
								</ul>
							</div> -->
                        </div>
                    </div>
                    <ul class="nav nav-primary">

                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Menu Aplikasi</h4>
                        </li>

                        <?php

                        // chek settingan tampilan menu
                        $setting = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();
                        if ($setting['value'] == 'ya') {
                            // cari level user
                            $tbl_user_level_id = $this->session->userdata('tbl_user_level_id');
                            $sql_menu = "SELECT * from tbl_menu WHERE id in(select tbl_menu_id from tbl_hak_akses where tbl_user_level_id='$tbl_user_level_id') and is_main_menu=0 and is_aktif='Y' ORDER BY id";
                        } else {
                            $sql_menu = "select * from tbl_menu where is_aktif='Y' and is_main_menu=0 ORDER BY tbl_menu_id";
                        }

                        // echo "<li class='menu-header'>Main Menu</li>";

                        // print_r($cek_atasan);die;
                        $main_menu = $this->db->query($sql_menu)->result();

                        foreach ($main_menu as $menu) {
                            // chek is have sub menu
                            $this->db->where('is_main_menu', $menu->id);
                            $this->db->where('is_aktif', 'y');
                            $submenu = $this->db->get('tbl_menu');
                            if ($submenu->num_rows() > 0) {
                                // display sub menu
                                echo "<li class='nav-item'>
									<a data-toggle='collapse' href='#$menu->id' class='collapsed' aria-expanded='false'>
									<i class='fas fa-" . $menu->icon . "'></i><span class='sub-item'>" . ucwords($menu->title) . "</span>	<span class='caret'></span>
									</a>
									<div class='collapse' id='$menu->id'>
									<ul class='nav nav-collapse'>";
                                foreach ($submenu->result() as $sub) {
                                    echo "<li>" . anchor($sub->url, $sub->title) . "</li>";
                                }
                                echo " </ul>
								</div>
                                </li>";
                            } else {
                                // display main menu
                                echo "<li class='nav-item'>";
                                echo anchor($menu->url, "<i class='fas fa-" . $menu->icon . "'></i><span>" . ucwords($menu->title) . "</span> ");
                                echo "</li>";
                            }
                        }
                        ?>
                        <?php
                        $wd = User::table()->with('dosen')->where(['id' => auth('id')])->first();
                        $isWd = false;
                        if ($wd && $wd->dosen) {
                            $isWd = $wd->dosen->jabatan_akademik === 'wd1';
                        }
                        $isKajur = false;
                        if ($wd && $wd->dosen) {
                            $isKajur = $wd->dosen->jabatan_akademik === 'kajur';
                        }
                        ?>
                        <?php if ($isWd) { ?>
                            <li class="nav-item">
                                <a data-toggle="collapse" href="#sk-dekan" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-desktop"></i>
                                    <span>Verifikasi SK</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="sk-dekan">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="<?= base_url('C_sk_dekan/dosen');  ?>">
                                                <i class="fas fa-user"></i>
                                                <span>SK Dosen</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url('verifikasi-sk');  ?>">
                                                <i class="fas fa-file"></i>
                                                <span>SK Ujian</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>
                        <?php if ($isKajur) { ?>
                            <li class="nav-item">
                                <a href="<?= base_url('C_verifikasi_ujian'); ?>">
                                    <i class="fas fa-desktop"></i>
                                    <span>Verifikasi Ujian</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                <?php
                echo $contents;
                ?>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright m-auto">
                        <p>&copy; <?= date('Y'); ?> FHIL UHO — Design by <a href="https://inovasitech.com/" target="_blank">ITECH</a></p>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" jika Anda yakin untuk keluar dari sesi ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>C_auth/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="<?= base_url(); ?>assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('.select2').select2({
                width: 'resolve',
                theme: "classic"
            });
            // $('.select2').css('max-height', '300px');

            //Date picker
            // $('.datepicker').datepicker({
            // 	autoclose: true,
            // 	format: 'yyyy-mm-dd'
            // })

        });
    </script>

    <script src="<?= base_url(); ?>assets/js/core/popper.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?= base_url(); ?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?= base_url(); ?>assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


    <!-- Chart JS -->
    <script src="<?= base_url(); ?>assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="<?= base_url(); ?>assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="<?= base_url(); ?>assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="<?= base_url(); ?>assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="<?= base_url(); ?>assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="<?= base_url(); ?>assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

    <!-- Sweet Alert -->
    <script src="<?= base_url(); ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- SIMAWA JS -->
    <script src="<?= base_url(); ?>assets/js/atlantis.min.js"></script>
</body>

</html>
