<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Data Profil</h4>
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
        <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen Profil</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Profil</a>
      </li>
    </ul>
  </div>

  <div class="section-body">
    <div class="card">

      <div class="card-header">
        <h4>Edit Profil</h4>
      </div>
      <form action="<?php echo site_url('c_user/action_change_data_pegawai'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="card-body card-block">
          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nama </label></div>
            <div class="col-12 col-md-9"><input name="nama_pengguna" placeholder=" Nama" class="form-control" type="text" required="required" value="<?php echo $user->nama_pengguna; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
          </div>

          <?php if ($this->session->userdata('tbl_user_level_id') == 5) { ?>
            <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class=" form-control-label">NIM</label></div>
              <div class="col-12 col-md-9"><input name="nim" placeholder="NIM" class="form-control" type="text" value="<?php echo $user->nim; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
            </div>

            <div class="row form-group" id="jurusan">
              <div class="col col-md-3">
                <label>Jurusan</label>
              </div>
              <div class="col-12 col-md-9">
                <select class="form-control" name="jurusan_id">
                  <option value="">.:: Pilih Jurusan ::.</option>
                  <?php foreach ($jurusan as $keys) {
                    if ($user->jurusan_id == $keys->id) {
                  ?>
                      <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_jurusan ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_jurusan ?></option>
                  <?php }
                  } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <div class="col col-md-3"><label>Status</label></div>
              <div class="col col-md-9">
                <select class="form-control" name="status">
                  <option value="">.:: Pilih Status ::.</option>
                  <option <?php if ($user->status == 'aktif') echo 'selected'; ?>>aktif</option>
                  <option <?php if ($user->status == 'tidak aktif') echo 'selected'; ?>>tidak aktif</option>
                </select>
              </div>
            </div>
          <?php } elseif ($this->session->userdata('tbl_user_level_id') == 4) { ?>
            <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class=" form-control-label">NIP</label></div>
              <div class="col-12 col-md-9"><input name="nip" placeholder="NIP" class="form-control" type="text" value="<?php echo $user->nip; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
            </div>

            <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class=" form-control-label">NIDN</label></div>
              <div class="col-12 col-md-9"><input name="nidn" placeholder="NIDN" class="form-control" type="text" value="<?php echo $user->nidn; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
            </div>

            <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class=" form-control-label">Jabatan Akademik</label></div>
              <div class="col-12 col-md-9"><input name="jabatan_akademik" placeholder="jabatan akademik" class="form-control" type="text" value="<?php echo $user->jabatan_akademik; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
            </div>
            <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class=" form-control-label">TMT Jabatan Akademik</label></div>
              <div class="col-12 col-md-9"><input name="tmt_akademik" placeholder="TMT jabatan akademik" class="form-control" type="date" value="<?php echo $user->tmt_akademik; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
            </div>

            <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class=" form-control-label">Pangkat</label></div>
              <div class="col-12 col-md-9"><input name="pangkat" placeholder="Pangkat" class="form-control" type="text" value="<?php echo $user->pangkat; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
            </div>

            <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class="form-control-label">TMT Pangkat</label></div>
              <div class="col-12 col-md-9"><input name="pangkat_tmt" placeholder="TMT Pangkat" class="form-control" type="date" value="<?php echo $user->pangkat_tmt; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
            </div>

            <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class=" form-control-label">Pendidikan Terakhir</label></div>
              <div class="col-12 col-md-9"><input name="pendidikan_terakhir" placeholder="Pendidikan Terakhir" class="form-control" type="text" value="<?php echo $user->pendidikan_terakhir; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
            </div>

            <div class="form-group row">
              <div class="col col-md-3"><label>Homebase</label></div>
              <div class="col col-md-9">
                <select class="form-control" name="homebase">
                  <option value="">.:: Pilih Homebase ::.</option>
                  <?php foreach ($jurusan as $keys) {
                    if ($user->homebase == $keys->id) {
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
                <select class="form-control" name="status">
                  <option value="">.:: Pilih Status ::.</option>
                  <option <?php if ($user->status == 'aktif') echo 'selected'; ?>>aktif</option>
                  <option <?php if ($user->status == 'tidak aktif') echo 'selected'; ?>>tidak aktif</option>
                  <option <?php if ($user->status == 'tugas belajar') echo 'selected'; ?>>tugas belajar</option>
                </select>
              </div>
            </div>
          <?php } else { ?>
            <div class="row form-group" id="jurusan">
              <div class="col col-md-3">
                <label>Jurusan</label>
              </div>
              <div class="col-12 col-md-9">
                <select class="form-control" name="jurusan_id">
                  <option value="">.:: Pilih Jurusan ::.</option>
                  <?php foreach ($jurusan as $keys) {
                    if ($user->jurusan_id == $keys->id) {
                  ?>
                      <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_jurusan ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_jurusan ?></option>
                  <?php }
                  } ?>
                </select>
              </div>
            </div>
          <?php } ?>

          <hr>
          <div class="row form-group">
            <div class="col col-md-3">
              <label for="text-input" class=" form-control-label">Foto </label>
            </div>
            <div class="col-12 col-md-9">
              <span class="text-red">file sebelumnya: </span><a href="<?php echo base_url() . "assets/foto_profil/" . $user->picture_profile; ?>" target="_blank"><?php echo $user->picture_profile; ?></a>
              <input type="file" class="form-control" placeholder="" name="picture_profile" accept=".png, .jpeg, .jpg">
              <input type="hidden" class="form-control" name="id" required="required" value="<?php echo $user->id; ?>">
            </div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Email </label></div>
            <div class="col-12 col-md-9"><input name="email" placeholder="" class="form-control" type="email" required="required" value="<?php echo $user->email; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nomor HP </label></div>
            <div class="col-12 col-md-9"><input name="no_hp" placeholder="" class="form-control" type="text" required="required" value="<?php echo $user->no_hp; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Username </label></div>
            <div class="col-12 col-md-9"><input name="username" placeholder="" class="form-control" type="text" required="required" value="<?php echo $user->username; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Password </label></div>
            <div class="col-12 col-md-9"><input name="password" placeholder="Kosongkan bila tidak mau merubah password" class="form-control" type="text"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa fa-dot-circle-o"></i>Update
          </button>

        </div>
      </form>

    </div>
  </div>
</div>