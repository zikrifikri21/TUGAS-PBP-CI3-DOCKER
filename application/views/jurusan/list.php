<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data Jurusan</h4>
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
                <a href="#">Manajemen Jurusan</a>
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
                    <h4>Data Jurusan</h4>
                </div>
                <div class="col-lg-8">
                    <?php if ($this->session->userdata('tbl_user_level_id') != '2') {
                        echo   anchor(site_url('c_jurusan/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-primary btn-sm float-right"');
                    }
                    ?>
                </div>
            </div>
            <div class="card-body card-block">
                <div class="table-responsive">
                    <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                        <table id="mytable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Nama Jurusan</th>
                                    <th>Ketua Jurusan</th>
                                    <th>Sekretaris Jurusan</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($jurusan) {
                                    $no = 1;
                                    foreach ($jurusan as $key) { ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $key->nama_jurusan ?></td>
                                            <td><?php echo $key->nama_ketua ?></td>
                                            <td><?php echo $key->nama_sekretaris ?></td>
                                            <td>
                                                <a href="<?php echo site_url('c_jurusan/update/' . $key->id) ?>" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                                <?php if ($this->session->userdata('tbl_user_level_id') != '2') { ?>
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#jurusanRemoveModal<?php echo $key->id ?>">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                <?php } ?>

                                            </td>
                                        </tr>

                                        <!-- jurusan Modal Remove-->
                                        <div class="modal fade" id="jurusanRemoveModal<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hapus jurusan</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <?php echo form_open("c_jurusan/delete") ?>
                                                    <div class="modal-body">
                                                        Apakah anda yakin akan menghapus data jurusan <b><?php echo $key->nama_jurusan ?></b> ?
                                                        <input type="hidden" class="form-control" name="id" value="<?php echo $key->id ?>">
                                                        <input type="hidden" class="form-control" name="nama_jurusan" value="<?php echo $key->nama_jurusan ?>">
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