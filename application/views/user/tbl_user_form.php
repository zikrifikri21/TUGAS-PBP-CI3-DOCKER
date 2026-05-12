<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tambah Data User</h4>
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
                <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen User</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tambah User</a>
            </li>
        </ul>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Input Data USER</h4>
            </div>
            <div class="card-body card-block">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="hidden" class="form-control" name="id" id="id" placeholder="" value="<?php echo $id; ?>" />
                        <input type="text" class="form-control" name="nama_pengguna" id="nama_pengguna" placeholder="" value="<?php echo $nama_pengguna; ?>" />
                        <small><?php echo form_error('nama_pengguna') ?></small>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="" value="<?php echo $username; ?>" />
                        <small><?php echo form_error('username') ?></small>
                    </div>
                    <!-- <div class="form-group">
                        <label>NIP</label>
                        <input type="text" class="form-control" name="nip" id="nip" placeholder="" value="<?php echo $nip; ?>" />
                        <small><?php echo form_error('nip') ?></small>
                    </div> -->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="" value="<?php echo $email; ?>" />
                        <small><?php echo form_error('email') ?></small>
                    </div>
                    <div class="form-group">
                        <label>Password</label><br>
                        <span style="color:red">*Kosongkan jika tidak mau mengganti password</span>
                        <input type="text" class="form-control" name="password" id="password" placeholder="" value="<?php echo $password; ?>" />
                        <small><?php echo form_error('password') ?></small>
                    </div>
                    <div class="form-group">
                        <label>Level User</label>
                        <select required class="form-control" name="tbl_user_level_id" id="slct">
                            <option value="">.:: Pilih User Level ::.</option>
                            <?php foreach ($user_level as $keys) {
                                if ($keys->id != 1) {
                                    if ($tbl_user_level_id == $keys->id) {
                            ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama ?></option>
                            <?php }
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jurusan</label>
                        <select class="form-control" name="jurusan_id">
                            <option value="">.:: Pilih Jurusan ::.</option>
                            <?php foreach ($jurusan as $keys) {
                                if ($jurusan_id == $keys->id) {
                            ?>
                                    <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_jurusan ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_jurusan ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>No HP</label>
                        <input type="input" class="form-control" name="no_hp" id="no_hp" placeholder="" value="<?php echo $no_hp; ?>" />
                        <small><?php echo form_error('no_hp') ?></small>
                    </div>
                    <div class="form-group">
                        <label>Foto Profile</label>
                        <input type="file" name="picture_profile">
                        <small><?php echo form_error('picture_profile') ?></small>
                    </div>
                    <div class="form-group">
                        <label>Status Aktif</label>
                        <?php echo form_dropdown('is_aktif', array('y' => 'AKTIF', 'n' => 'TIDAK AKTIF'), $is_aktif, array('class' => 'form-control')); ?>
                        <!--<input type="text" class="form-control" name="is_aktif" id="is_aktif" placeholder="Is Aktif" value="<?php echo $is_aktif; ?>" />-->
                        </td>
                        <small><?php echo form_error('is_aktif') ?></small>
                    </div>
            </div>

            <div class="card-footer text-right">
                <a href="<?php echo site_url('C_user') ?>" class="btn btn-danger"><i class="fa fa-sign-out"></i> Kembali</a>
                <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
                <!-- <button class="btn btn-primary">Submit</button> -->
            </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- <script>
    $(document).ready(function() {
        var property = $(this).find(':selected').val();
        console.log(property);
        if (property == 3) {
            var target = $('#pegawai');
            target.css('display', 'block');
            $('#select2js').prop('required', true);
            // var target2 = $('#sk_nomor');
            // target2.css('display', 'block');
            // $('#req_sk_nomor').prop('required', true);
            var target3 = $('#unit_kerja');
            target3.css('display', 'none');
            // $('#req_sk_alasan').prop('required', false);
        } else if (property == 4) {
            var target = $('#pegawai');
            target.css('display', 'none');
            // $('#req_sk_surat_ttd').prop('required', true);
            // var target2 = $('#sk_nomor');
            // target2.css('display', 'block');
            // $('#req_sk_nomor').prop('required', true);
            var target3 = $('#unit_kerja');
            target3.css('display', 'block');
            $('#unitkerjaselect2').prop('required', false);
        } else {
            var target = $('#unit_kerja');
            target.css('display', 'none');
            var target2 = $('#pegawai');
            target2.css('display', 'none');
        }

    });
    $('#slct').on('change', function() {
        var property = $(this).find(':selected').val();
        console.log(property);
        if (property == 3) {
            var target = $('#pegawai');
            target.css('display', 'block');
            $('#select2js').prop('required', true);
            // var target2 = $('#sk_nomor');
            // target2.css('display', 'block');
            // $('#req_sk_nomor').prop('required', true);
            var target3 = $('#unit_kerja');
            target3.css('display', 'none');
            // $('#req_sk_alasan').prop('required', false);
        } else if (property == 4) {
            var target = $('#pegawai');
            target.css('display', 'none');
            // $('#req_sk_surat_ttd').prop('required', true);
            // var target2 = $('#sk_nomor');
            // target2.css('display', 'block');
            // $('#req_sk_nomor').prop('required', true);
            var target3 = $('#unit_kerja');
            target3.css('display', 'block');
            $('#unitkerjaselect2').prop('required', false);
        } else {
            var target = $('#unit_kerja');
            target.css('display', 'none');
            var target2 = $('#pegawai');
            target2.css('display', 'none');
        }
    });
</script> -->