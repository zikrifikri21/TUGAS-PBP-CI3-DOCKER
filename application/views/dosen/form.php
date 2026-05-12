<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tambah Data dosen</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= base_url() ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen dosen</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tambah dosen</a>
            </li>
        </ul>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Input Data dosen</h4>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nama dosen</label></div>
                        <div class="col-12 col-md-9"><input name="nama_dosen" placeholder="dosen Nama" class="form-control" type="text" required="required" value="<?php echo $nama_dosen; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">NIP</label></div>
                        <div class="col-12 col-md-9"><input name="nip" placeholder="nip" class="form-control" type="text" value="<?php echo $nip; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">NIDN</label></div>
                        <div class="col-12 col-md-9"><input name="nidn" placeholder="nidn" class="form-control" type="text" value="<?php echo $nidn; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
                    </div>

                    <!-- <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Jabatan Akademik</label></div>
                        <div class="col-12 col-md-9"><input name="jabatan_akademik" placeholder="jabatan akademik" class="form-control" type="text" value="<?php echo $jabatan_akademik; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
                    </div> -->
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">TMT Jabatan Akademik</label></div>
                        <div class="col-12 col-md-9"><input name="tmt_akademik" placeholder="TMT jabatan akademik" class="form-control" type="date" value="<?php echo $tmt_akademik; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Pangkat</label></div>
                        <div class="col-12 col-md-9"><input name="pangkat" placeholder="Pangkat" class="form-control" type="text" value="<?php echo $pangkat; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class="form-control-label">TMT Pangkat</label></div>
                        <div class="col-12 col-md-9"><input name="pangkat_tmt" placeholder="TMT Pangkat" class="form-control" type="date" value="<?php echo $pangkat_tmt; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
                    </div>

                    <!-- <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Pendidikan Terakhir</label></div>
                        <div class="col-12 col-md-9"><input name="pendidikan_terakhir" placeholder="Pendidikan Terakhir" class="form-control" type="text" value="<?php echo $pendidikan_terakhir; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
                    </div> -->

                    <div class="form-group row">
                        <div class="col col-md-3"><label>Homebase</label></div>
                        <div class="col col-md-9">
                            <select required class="form-control" name="homebase">
                                <option value="">.:: Pilih Homebase ::.</option>
                                <?php foreach ($jurusan as $keys) {
                                    if ($homebase == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_jurusan ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_jurusan ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-3"><label>Status</label></div>
                        <div class="col col-md-9">
                            <select required class="form-control" name="status">
                                <option value="">.:: Pilih Status ::.</option>
                                <option <?php if ($status == 'aktif') echo 'selected'; ?>>aktif</option>
                                <option <?php if ($status == 'tidak aktif') echo 'selected'; ?>>tidak aktif</option>
                                <option <?php if ($status == 'tugas belajar') echo 'selected'; ?>>tugas belajar</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Username</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input name="tbl_user_id" placeholder="Username" class="form-control" type="hidden" required="required" value="<?php echo $tbl_user_id; ?>">
                            <input name="username" placeholder="Username" class="form-control" type="text" required="required" value="<?php echo $username; ?>">
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Password</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input name="password" placeholder="Password" class="form-control" type="text" value="<?php echo $password; ?>">
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input name="id" class="form-control" type="hidden" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i>Submit
                    </button>
                    <a href="<?php echo site_url('c_dosen') ?>" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Kembali
                    </a>
                </div>
            </form>


        </div>
    </div>
</div>
