<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Tambah Data Menu</h4>
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
        <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen Menu</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Tambah Menu</a>
      </li>
    </ul>
  </div>
  <div class="section-body">

    <div class="card">

      <div class="card-header">
        <h4>Input Data MENU</h4>
      </div>
      <div class="card-body card-block">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Title</label></div>
            <div class="col-12 col-md-9"><input name="title" id="title" placeholder="Title" class="form-control" type="text" value="<?php echo $title; ?>"><small class="form-text text-muted"><?php echo form_error('title') ?></small></div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">URL</label></div>
            <div class="col-12 col-md-9"><input name="url" id="url" placeholder="Link URL" class="form-control" type="text" value="<?php echo $url; ?>"><small class="form-text text-muted"><?php echo form_error('url') ?></small></div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Icon</label></div>
            <div class="col-12 col-md-9"><input name="icon" id="icon" placeholder="Icon" class="form-control" type="text" value="<?php echo $icon; ?>"><small class="form-text text-muted"><?php echo form_error('icon') ?></small></div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="selectSm" class=" form-control-label">Is Main Menu</label></div>
            <div class="col-12 col-md-9">
              <select name="is_main_menu" class="form-control-sm form-control">
                <option value="0">Main Menu</option>
                <?php
                $menu = $this->db->get('tbl_menu')->result();
                foreach ($menu as $m) {
                  echo "<option value='$m->id' ";
                  echo $m->id == $is_main_menu ? 'selected' : '';
                  echo ">" .  strtoupper($m->title) . "</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Is Aktif</label></div>
            <div class="col-12 col-md-9"><?php echo form_dropdown('is_aktif', array('y' => 'AKTIF', 'n' => 'TIDAK'), $is_aktif, array('class' => 'form-control')) ?><small class="form-text text-muted"><?php echo form_error('is_aktif') ?></small></div>
          </div>

      </div>
      <div class="card-footer">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <button type="submit" class="btn btn-primary btn-sm">
          <i class="fa fa-dot-circle-o"></i><?php echo $button ?>
        </button>
        <a href="<?php echo site_url('C_menu') ?>" class="btn btn-danger btn-sm">
          <i class="fa fa-ban"></i> Kembali
        </a>
      </div>
      </form>
    </div>
  </div>
</div>
</section>