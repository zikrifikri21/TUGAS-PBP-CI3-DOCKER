<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Tambah Data Level</h4>
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
        <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen Level User</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Tambah Level</a>
      </li>
    </ul>
  </div>
  <div class="section-body">

    <!-- <div class="col-lg-12"> -->
    <!-- <div class="card">
                <div class="card-header">
                <strong>Input Data</strong> USER
            </div> -->

    <div class="card">

      <div class="card-header">
        <h4>Input Data Level</h4>
      </div>
      <div class="card-body card-block">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Nama Level</label>
            <input type="hidden" class="form-control" name="id" id="id" placeholder="" value="<?php echo $id; ?>" />
            <input type="text" class="form-control" name="nama" id="nama" placeholder="" value="<?php echo $nama; ?>" />
            <small><?php echo form_error('nama') ?></small>
          </div>


          <div class="card-footer text-right">
            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
            <a href="<?php echo site_url('C_userlevel') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
            <!-- <button class="btn btn-primary">Submit</button> -->
          </div>
        </form>
      </div>
    </div>
  </div>
</div>