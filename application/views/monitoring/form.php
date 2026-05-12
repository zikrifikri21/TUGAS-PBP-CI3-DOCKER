<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Tambah Data ujian</h4>
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
        <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen ujian</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Tambah ujian</a>
      </li>
    </ul>
  </div>
  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Input Data Ujian</h4>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="card-body card-block">
          <div class="form-group row">
            <div class="col col-md-3"><label>Jenis Ujian</label></div>
            <div class="col col-md-9">
              <select required class="form-control" name="jenis_ujian">
                <option value="">.:: Pilih Jenis Ujian ::.</option>
                <option <?php if ($jenis_ujian == 'proposal') echo 'selected'; ?>>proposal</option>
                <option <?php if ($jenis_ujian == 'hasil') echo 'selected'; ?>>hasil</option>
                <option <?php if ($jenis_ujian == 'skripsi') echo 'selected'; ?>>skripsi</option>
              </select>
            </div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Judul</label></div>
            <div class="col-12 col-md-9">
              <textarea class="form-control" name="judul" id="" cols="30" rows="6" required="required"><?php echo $judul; ?></textarea>
              <small class="form-text text-muted"><?php echo form_error('title') ?></small>
            </div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">IPK Sementara (cth. 3.60)</label></div>
            <div class="col-12 col-md-9">
              <input name="ipk_sementara" placeholder="IPK Sementara" class="form-control" type="text" required="required" value="<?php echo $ipk_sementara; ?>">
              <small class="form-text text-muted"><?php echo form_error('title') ?></small>
            </div>
          </div>

          <div class="form-group row">
            <div class="col col-md-3"><label>Pembimbing 1</label></div>
            <div class="col col-md-9">
              <select required class="form-control select2 js-example-basic-single js-states" name="pembimbing_1">
                <option value="">.:: Pilih Dosen ::.</option>
                <?php foreach ($dosen as $keys) {
                  if ($pembimbing_1 == $keys->id) {
                ?>
                    <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                <?php
                  }
                } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col col-md-3"><label>Pembimbing 2</label></div>
            <div class="col col-md-9">
              <select required class="form-control select2" name="pembimbing_2">
                <option value="">.:: Pilih Dosen ::.</option>
                <?php foreach ($dosen as $keys) {
                  if ($pembimbing_2 == $keys->id) {
                ?>
                    <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                <?php
                  }
                } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col col-md-3"><label>Penguji 1</label></div>
            <div class="col col-md-9">
              <select required class="form-control select2" name="uji1">
                <option value="">.:: Pilih Dosen ::.</option>
                <?php foreach ($dosen as $keys) {
                  if ($uji1 == $keys->id) {
                ?>
                    <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                <?php
                  }
                } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col col-md-3"><label>Penguji 2</label></div>
            <div class="col col-md-9">
              <select required class="form-control select2" name="uji2">
                <option value="">.:: Pilih Dosen ::.</option>
                <?php foreach ($dosen as $keys) {
                  if ($uji2 == $keys->id) {
                ?>
                    <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                <?php
                  }
                } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col col-md-3"><label>Penguji 3</label></div>
            <div class="col col-md-9">
              <select required class="form-control select2" name="uji3">
                <option value="">.:: Pilih Dosen ::.</option>
                <?php foreach ($dosen as $keys) {
                  if ($uji3 == $keys->id) {
                ?>
                    <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                <?php
                  }
                } ?>
              </select>
            </div>
          </div>

        </div>

        <div class="card-footer">
          <input name="id" class="form-control" type="hidden" value="<?php echo $id; ?>">
          <input name="mahasiswa_id" class="form-control" type="hidden" value="<?php echo $mahasiswa_id; ?>">
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa fa-dot-circle-o"></i>Submit
          </button>
          <a href="<?php echo site_url('c_ujian') ?>" class="btn btn-danger btn-sm">
            <i class="fa fa-ban"></i> Kembali
          </a>
        </div>
      </form>


    </div>
  </div>
</div>