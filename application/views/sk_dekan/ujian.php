<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola SK Dekan</h4>
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
                <a href="#">Manajemen SK</a>
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
                    <h4>SK Dekan Ujian</h4>
                </div>
                <div class="col-lg-8">
                    <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#tambah">
                        <i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data
                    </a>

                    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Ujian</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <?php echo form_open("C_sk_dekan/create_ujian", array('method' => 'get')) ?>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label>Jenis Ujian</label>
                                        <select required class="form-control" name="jenis_ujian">
                                            <option value="">.:: Pilih Jenis Ujian ::.</option>
                                            <option>proposal</option>
                                            <option>hasil</option>
                                            <option>skripsi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body card-block">
                <div class="table-responsive">
                    <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                        <table id="mytable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th width="100px">Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($sk_dekan) {
                                    $no = 1;
                                    foreach ($sk_dekan as $key) { ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $key->no_sk ?></td>
                                            <td><?= $key->tgl_sk ?></td>
                                            <td>
                                                <?php $status = $key->status_putusan ?>
                                                <?php
                                                switch ($status) {
                                                    case 'v0':
                                                        echo '
                                                            <span class="badge badge-danger mb-1">Dikembalikan</span>
                                                            <button class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#catatan-' . $key->id . '"
                                                            >Lihat Catatan</button>
                                                            ';
                                                        break;
                                                    case 'v1':
                                                        echo '<span class="badge badge-info">Diproses WD1</span>';
                                                        break;
                                                    case 'v2':
                                                        echo '<span class="badge badge-warning">Menunggu Dekan</span>';
                                                        break;
                                                    case 'v3':
                                                        echo '<span class="badge badge-success">Selesai</span>';
                                                        break;
                                                    default:
                                                        echo '<span class="badge badge-warning">Menunggu</span>';
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#konsideran<?php echo $key->id ?>">
                                                    Draft Konsideran
                                                </a>
                                                <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#lampiran<?php echo $key->id ?>">
                                                    Draft Lampiran
                                                </a>
                                                <?php if (!$key->status_putusan || $key->status_putusan == 'v0') { ?>
                                                    <a href="<?php echo site_url('C_sk_dekan/update_ujian/' . $key->id . '?jenis_ujian=' . $key->jenis_ujian) ?>" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#ujianRemoveModal<?php echo $key->id ?>">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <!-- modal lihat catatan -->
                                        <div class="modal fade" id="catatan-<?= $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Catatan</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p style="text-align: center;"><?= $key->catatan ?></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="konsideran<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Draft Konsideran</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <?php echo form_open_multipart("C_sk_dekan/upload_file_ujian") ?>
                                                    <div class="modal-body">
                                                        <embed src="<?php echo base_url() . 'C_draft/sk_dekan_konsideran_ujian/' . $key->id ?>" frameborder="0" width="100%" height="600px">
                                                        <!-- <div class="form-group">
                                                            <label for="text-input" class=" form-control-label">Upload Ulang File Berisi TTD (Scan PDF)</label>
                                                            <br> <span class="text-red">file sebelumnya: </span><a href="<?php echo base_url() . "upload/sk/" . $key->upload_konsideran; ?>" target="_blank"><?php echo $key->upload_konsideran; ?></a>
                                                            <input type="file" class="form-control" name="upload_konsideran" accept=".pdf">
                                                        </div> -->
                                                        <input type="hidden" class="form-control" name="id" value="<?= $key->id ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" type="submit">Kirim Ke WD1</button>
                                                        <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button> -->

                                                    </div>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="lampiran<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Draft Lampiran</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <?php echo form_open_multipart("C_sk_dekan/upload_file_ujian") ?>
                                                    <div class="modal-body">
                                                        <embed src="<?php echo base_url() . 'C_draft/sk_dekan_lampiran_ujian/' . $key->id ?>" frameborder="0" width="100%" height="600px">
                                                        <!-- <div class="form-group">
                                                            <label for="text-input" class=" form-control-label">Upload Ulang File Berisi TTD (Scan PDF)</label>
                                                            <br> <span class="text-red">file sebelumnya: </span><a href="<?php echo base_url() . "upload/sk/" . $key->upload_lampiran; ?>" target="_blank"><?php echo $key->upload_lampiran; ?></a>
                                                            <input type="file" class="form-control" name="upload_lampiran" accept=".pdf">
                                                        </div> -->
                                                        <input type="hidden" class="form-control" name="id" value="<?= $key->id ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" type="submit">Kirim Ke WD1</button>
                                                        <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button> -->

                                                    </div>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>

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
                                                    <?php echo form_open("C_sk_dekan/delete_ujian") ?>
                                                    <div class="modal-body">
                                                        Apakah anda yakin akan menghapus SK Dekan dengan nomor : <b><?php echo $key->no_sk ?></b> ?<br>
                                                        <span style="color:red"> Semua nama mahasiswa yang telah diinput akan ikut terhapus</span>
                                                        <input type="hidden" class="form-control" name="id" value="<?php echo $key->id ?>">
                                                        <input type="hidden" class="form-control" name="no_sk" value="<?php echo $key->no_sk ?>">
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


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#mytable').DataTable({
            "lengthChange": true,
            "searching": true,
        });
    });
</script>
