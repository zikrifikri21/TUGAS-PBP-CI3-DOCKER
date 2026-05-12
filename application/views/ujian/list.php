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
                <a href="<?= base_url('C_ujian') ?>">Manajemen ujian</a>
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
                    <h4>Data ujian</h4>
                </div>
                <div class="col-lg-8">
                    <?php echo anchor(site_url('c_ujian/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Pengajuan Ujian', 'class="btn btn-primary btn-sm float-right"'); ?>



                </div>
            </div>
            <div class="card-body card-block">
                <div class="table-responsive">
                    <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                        <table id="mytable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Jenis Ujian</th>
                                    <th>Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Judul</th>
                                    <th>Jurusan</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($ujian) {
                                    $no = 1;
                                    foreach ($ujian as $key) { ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $key->jenis_ujian ?></td>
                                            <td><?php echo $key->nama_mahasiswa ?></td>
                                            <td><?php echo $key->nim ?></td>
                                            <td><?php echo $key->judul ?></td>
                                            <td><?php echo $key->nama_jurusan ?></td>
                                            <td>
                                                <a href="<?php echo site_url('C_bukti_dukung/id/' . $key->id) ?>" class="btn btn-success btn-sm">
                                                    Bukti Dukung
                                                </a>
                                                <?php if ($key->status_putusan !== 'verifikasi') { ?>
                                                    <a href="<?php echo site_url('c_ujian/update/' . $key->id) ?>" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>
                                                    <?php if ($key->status_putusan !== 'terkirim' && empty($key->hari_ujian)) { ?>
                                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#ujianRemoveModal<?php echo $key->id ?>">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>

                                        <!-- ujian Modal Remove-->
                                        <div class="modal fade" id="ujianRemoveModal<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hapus ujian</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <?php echo form_open("c_ujian/delete") ?>
                                                    <div class="modal-body">
                                                        Apakah anda yakin akan menghapus data ujian <b><?php echo $key->nama_mahasiswa ?></b> ?<br>
                                                        <span style="color:red"> Semua bukti yang telah diupload akan ikut terhapus</span>
                                                        <input type="hidden" class="form-control" name="id" value="<?php echo $key->id ?>">
                                                        <input type="hidden" class="form-control" name="judul" value="<?php echo $key->judul ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-danger" type="submit">Hapus</button>
                                                        <?php echo form_close(); ?>
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- End Looping -->


                                <?php $no++;
                                    }
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