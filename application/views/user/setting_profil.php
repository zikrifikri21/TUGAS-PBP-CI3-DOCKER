<section class="section">
    <div class="section-header">
        <h1>Setting Profil</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Setting Profil</div>
        </div>
    </div>
    <!-- <div class="alert alert-success" role="alert">
        </div> -->
    <div class="section-body">

        <!-- <div class="col-lg-12"> -->
        <!-- <div class="card">
                <div class="card-header">
                <strong>Input Data</strong> USER
            </div> -->

        <div class="card">

            <div class="card-header">
                <h4>Setting Profil</h4>
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

                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" class="form-control" name="nip" id="nip" placeholder="" value="<?php echo $nip; ?>" />
                        <small><?php echo form_error('nip') ?></small>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="" value="<?php echo $email; ?>" />
                        <small><?php echo form_error('email') ?></small>
                    </div>

                    <div class="form-group" id="unit_kerja">
                        <label>Unit Kerja</label>
                        <select class="form-control" name="tbl_unit_kerja_id_unit_kerja" id="unitkerjaselect2">
                            <option value="">.:: Pilih Unit Kerja ::.</option>
                            <?php foreach ($unit_kerja as $keys) {
                                if ($tbl_unit_kerja_id_unit_kerja == $keys->id_unit_kerja) {
                            ?>
                                    <option value="<?php echo $keys->id_unit_kerja ?>" selected><?php echo $keys->nama_unit_kerja ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $keys->id_unit_kerja ?>"><?php echo $keys->nama_unit_kerja ?></option>
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
</section>

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