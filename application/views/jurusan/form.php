<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Tambah Data Jurusan</h4>
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
        <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen Jurusan</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Tambah Jurusan</a>
      </li>
    </ul>
  </div>
  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Input Data jurusan</h4>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="card-body card-block">
          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nama Jurusan</label></div>
            <div class="col-12 col-md-9"><input name="nama_jurusan" placeholder="jurusan Nama" class="form-control" type="text" required="required" value="<?php echo $nama_jurusan; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
          </div>


          <div class="form-group row">
            <div class="col col-md-3"><label>Ketua Jurusan</label></div>
            <div class="col-12 col-md-9">
              <select required class="form-control select2 js-example-basic-single js-states" name="ketua_jurusan">
                <option value="">.:: Pilih Dosen ::.</option>
                <?php foreach ($dosen as $keys) {
                  if ($ketua_jurusan == $keys->id) {
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
            <div class="col col-md-3"><label>Sekretaris Jurusan</label></div>
            <div class="col-12 col-md-9">
              <select required class="form-control select2 js-example-basic-single js-states" name="sekretaris_jurusan">
                <option value="">.:: Pilih Dosen ::.</option>
                <?php foreach ($dosen as $keys) {
                  if ($sekretaris_jurusan == $keys->id) {
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
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa fa-dot-circle-o"></i>Submit
          </button>
          <a href="<?php echo site_url('c_jurusan') ?>" class="btn btn-danger btn-sm">
            <i class="fa fa-ban"></i> Kembali
          </a>
        </div>
      </form>


    </div>
  </div>
</div>