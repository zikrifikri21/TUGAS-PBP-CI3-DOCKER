<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data Bukti Dukung</h4>
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
                <a href="<?php if ($this->session->userdata('tbl_user_level_id') == 5) echo base_url('C_ujian');
                            else echo base_url('C_verifikasi_ujian'); ?>">Manajemen Ujian</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Manajemen Bukti Dukung</a>
            </li>
        </ul>
    </div>
    <?php
    if ($this->session->flashdata('input')) { ?>
        <?= alert('sufee-alert alert with-close alert-success alert-dismissible fade show', 'Pesan', $this->session->flashdata('input')) ?>
    <?php } else if ($this->session->flashdata('edit')) { ?>
        <?= alert('sufee-alert alert with-close alert-warning alert-dismissible fade show', 'Pesan', $this->session->flashdata('edit')) ?>
    <?php } else if ($this->session->flashdata('delete')) { ?>
        <?= alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Pesan', $this->session->flashdata('delete')) ?>
    <?php } ?>

    <div class="section-body">
        <div class="card">
            <div class="card-header row">
                <div class="col-lg-4">
                    <h4>Data Bukti Dukung</h4>
                </div>
                <div class="col-lg-8">
                    <?php if ($this->session->userdata('tbl_user_level_id') == 5) { ?>
                        <?= anchor(site_url('c_bukti_dukung/create/' . $this->uri->segment(3)), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-primary btn-sm float-right"'); ?>
                    <?php } ?>
                </div>
            </div>
            <div class="card-body card-block">
                <div class="table-responsive">
                    <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                        <table id="mytable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th width="200px">Nama Bukti Dukung</th>
                                    <th>Link File</th>
                                    <th>Preview</th>
                                    <?php if ($this->session->userdata('tbl_user_level_id') == 5) { ?>
                                        <th width="100px">Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($bukti_dukung) {
                                    $no = 1;
                                    foreach ($bukti_dukung as $key) { ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $key->nama_lampiran ?></td>
                                            <td>
                                                <a href="<?= $key->file ? base_url('upload/bukti_dukung/' . $key->file) : '#' ?>"
                                                    target="_blank" rel="noopener noreferrer">
                                                    File: <?= $key->file ?? '-' ?>
                                                </a>
                                                <br>
                                                <a href="<?= $key->link_drive ?? '#' ?>" target="_blank" rel="noopener noreferrer">
                                                    Link Drive: <?= $key->link_drive ?? '-' ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if ($key->file) { ?>
                                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#bukti_dukungModal<?= $key->id ?>">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                <?php } else if ($key->link_drive) { ?>
                                                    <a href="<?= $key->link_drive ?>" target="_blank" rel="noopener noreferrer">Link Drive</a>
                                                <?php } ?>
                                            </td>
                                            <?php if ($this->session->userdata('tbl_user_level_id') == 5) { ?>
                                                <td>
                                                    <a href="<?= site_url('c_bukti_dukung/update/' . $key->ujian_id . '/' . $key->id) ?>" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#bukti_dukungRemoveModal<?= $key->id ?>">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                            <?php } ?>
                                        </tr>

                                        <!-- preview Modal -->
                                        <div class="modal fade" id="bukti_dukungModal<?= $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Preview Bukti Dukung</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe src="<?= $key->file ? base_url('upload/bukti_dukung/' . $key->file) : '#' ?>"
                                                            target="_blank" rel="noopener noreferrer" width="100%" height="600px">
                                                        </iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- bukti_dukung Modal Remove-->
                                        <div class="modal fade" id="bukti_dukungRemoveModal<?= $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Bukti Dukung</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <?= form_open("c_bukti_dukung/delete") ?>
                                                    <div class="modal-body">
                                                        Apakah anda yakin akan menghapus data Bukti Dukung <b><?= $key->nama_lampiran ?></b> ?
                                                        <input type="hidden" class="form-control" name="id" value="<?= $key->id ?>">
                                                        <input type="hidden" class="form-control" name="nama_lampiran" value="<?= $key->nama_lampiran ?>">
                                                        <input type="hidden" class="form-control" name="ujian_id" value="<?= $this->uri->segment(3) ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-danger" type="submit">Hapus</button>
                                                        <?= form_close(); ?>
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