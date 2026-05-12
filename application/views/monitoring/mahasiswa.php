<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data ujian</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Monitoring Ujian</a>
            </li>
        </ul>
    </div>
    <?php
    if ($this->session->flashdata('input')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-success alert-dismissible fade show', 'Pesan', $this->session->flashdata('input')) ?>
    <?php } else if ($this->session->flashdata('edit')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-warning alert-dismissible fade show', 'Pesan', $this->session->flashdata('edit')) ?>
    <?php } else if ($this->session->flashdata('delete')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Pesan', $this->session->flashdata('delete')) ?>
    <?php } ?>

    <div class="section-body">
        <div class="card">
            <div class="card-header row">
                <div class="col-lg-4">
                    <h4>Monitoring Ujian</h4>
                </div>
                <div class="col-lg-8">
                </div>
            </div>
            <div class="card-body card-block">
                <div class="table-responsive">
                    <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                        <table id="mytable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="30px">No</th>
                                    <th rowspan="2">Jenis Ujian</th>
                                    <th rowspan="2">Mahasiswa</th>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Judul</th>
                                    <th rowspan="2">Jurusan</th>
                                    <th colspan="2" class="text-center" style="height: 5px !important;">Berkas</th>
                                </tr>
                                <tr class="text-center">
                                    <th style="height: 5px !important; width: fit-content;">Surat Ujian</th>
                                    <th style="height: 5px !important; width: fit-content;">SK Dekan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($ujian) {
                                    foreach ($ujian as $i => $key) { ?>
                                        <tr>
                                            <td><?= $i + 1; ?></td>
                                            <td><?= $key->jenis_ujian ?></td>
                                            <td>
                                                <?= $key->mahasiswa ? $key->mahasiswa->nama_mahasiswa : '' ?>
                                                <?= $key->mahasiswa ? $key->mahasiswa->nim : '' ?>
                                            </td>
                                            <td><?= $key->hari_ujian ? indonesiaDate($key->hari_ujian) : '-' ?></td>
                                            <td><?= $key->judul ?></td>
                                            <td><?= $key->mahasiswa->jurusan->nama_jurusan ?></td>
                                            <td>
                                                <?php $terverifikasi = $key->status_putusan === 'verifikasi'; ?>
                                                <?php if ($terverifikasi) { ?>
                                                    <button data-toggle="modal" data-target="#ba<?php echo $key->id ?>" class="btn btn-primary btn-sm">
                                                        Berita acara
                                                    </button>
                                                <?php } ?>

                                                <?php if ($terverifikasi) { ?>
                                                    <button data-toggle="modal" data-target="#st<?php echo $key->id ?>" class="btn btn-secondary btn-sm">
                                                        Surat Tugas Ujian
                                                    </button>
                                                <?php } ?>

                                                <?php if ($terverifikasi) { ?>
                                                    <button data-toggle="modal" data-target="#sp<?php echo $key->id ?>" class="btn btn-success btn-sm mt-1">
                                                        Surat Penunjukkan Pembimbing
                                                    </button>
                                                <?php } ?>
                                                <?php if (!$terverifikasi) { ?>
                                                    <button class="btn btn-danger btn-sm">
                                                        Belum Diverifikasi
                                                    </button>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($key->sk_dekan && $key->sk_dekan->status_putusan == 'v3') { ?>
                                                    <button data-toggle="modal" data-target="#sk-konsideran-<?php echo $key->id ?>" class="btn btn-primary btn-sm mb-1">
                                                        SK Dekan Konsideran Ujian
                                                    </button>
                                                    <button data-toggle="modal" data-target="#sk-lampiran-<?php echo $key->id ?>" class="btn btn-warning btn-sm mb-1">
                                                        SK Dekan Lampiran Ujian
                                                    </button>

                                                    <div class="modal fade" id="sk-konsideran-<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Draft Konsideran</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <embed src="<?php echo base_url() . 'C_draft/sk_dekan_konsideran_ujian/' . $key->id ?>" frameborder="0" width="100%" height="600px">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="sk-lampiran-<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Draft Lampiran</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <embed src="<?php echo base_url() . 'C_draft/sk_dekan_lampiran_ujian/' . $key->id ?>" frameborder="0" width="100%" height="600px">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <?php if ($key->ujian_has_sk_dekan_b && $key->ujian_has_sk_dekan_b->status_putusan == 'v3') { ?>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#dosen-konsideran-<?php echo $key->ujian_has_sk_dekan_b->id ?>">
                                                        SK Dekan Konsideran Dosen
                                                    </button>
                                                    <?php if (auth('tbl_user_level_id') == "4") { ?>
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#dosen-lampiran-<?php echo $key->ujian_has_sk_dekan_b->id ?>">
                                                            SK Dekan Lampiran Dosen
                                                        </button>
                                                    <?php } ?>
                                                    <div class="modal fade" id="dosen-konsideran-<?php echo $key->ujian_has_sk_dekan_b->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Draft Konsideran</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <embed src="<?php echo base_url() . 'C_draft/sk_dekan_konsideran_dosen/' . $key->ujian_has_sk_dekan_b->id ?>" frameborder="0" width="100%" height="600px">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="dosen-lampiran-<?php echo $key->ujian_has_sk_dekan_b->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Draft Lampiran</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <embed src="<?php echo base_url() . 'C_draft/sk_dekan_lampiran_dosen/' . $key->ujian_has_sk_dekan_b->id ?>" frameborder="0" width="100%" height="600px">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <?php if (
                                                    (empty($key->sk_dekan) || empty($key->sk_dekan->status_putusan))
                                                    &&
                                                    (empty($key->ujian_has_sk_dekan_b) || empty($key->ujian_has_sk_dekan_b->status_putusan))
                                                ) {
                                                    echo '<button class="btn btn-danger btn-sm">Belum Dibuat</button>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php include __DIR__ . './../verifikasi_ujian/modal-ba.php' ?>
                                        <?php include __DIR__ . './../verifikasi_ujian/modal-st.php' ?>
                                        <?php include __DIR__ . './../verifikasi_ujian/modal-sp.php' ?>
                                <?php }
                                } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#mytable').DataTable({
            "lengthChange": true,
            "searching": true,
        });
    });
</script>