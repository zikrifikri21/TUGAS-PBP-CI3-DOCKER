<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tambah Data Bukti Dukung</h4>
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
                <a href="<?php echo base_url('C_bukti_dukung/id/' . $this->uri->segment(3)) ?>">Manajemen Bukti Dukung</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tambah Bukti Dukung</a>
            </li>
        </ul>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Input Data Bukti Dukung</h4>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="card-body card-block">
                    <?= validation_errors(); ?>
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class="form-control-label">Nama Bukti Dukung</label></div>
                        <div class="col-12 col-md-9">
                            <input name="nama_lampiran" placeholder="Nama Bukti Dukung"
                                class="form-control <?= has_error('nama_lampiran') ? 'is-invalid' : '' ?>" type="text"
                                required value="<?= $nama_lampiran; ?>">
                            <small class="form-text text-muted"> <?= validation_error('nama_lampiran'); ?></small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class="form-control-label">File</label></div>
                        <div class="col-12 col-md-9">
                            <input name="file" placeholder="File Bukti Dukung"
                                id="file_input"
                                class="form-control <?= has_error('file') ? 'is-invalid' : '' ?>"
                                type="file" value="<?= $file; ?>">
                            <?php if ($file) { ?>
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> file sebelumnya</button>
                            <?php } ?>
                            <small class="form-text text-muted">
                                (Format file yang diizinkan: pdf, doc, docx, jpg, png, jpeg, maksimal ukuran file 2MB)
                            </small>
                            <small class="form-text text-muted"><?= validation_error('file'); ?></small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="link-derive" class="form-control-label">
                                Link File
                                <br>
                                <span class="text-muted" style="font-size: x-small;">
                                    (Jika Bukti Dukung diGoogle Drive)
                                </span>
                            </label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input placeholder="Link Bukti Dukung Google Drive"
                                id="link-derive"
                                name="link_drive"
                                class="form-control <?= has_error('link_drive') ? 'is-invalid' : ''; ?>"
                                type="text" value="<?= $link_drive ?? ''; ?>">
                            <small class="form-text text-muted">Masukkan link Google Drive yang dapat diakses publik.</small>
                            <small class="form-text text-muted"><?= validation_error('link_drive'); ?></small>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input name="id" class="form-control" type="hidden" value="<?php echo $id; ?>">
                    <input type="hidden" class="form-control" name="ujian_id" value="<?php echo $this->uri->segment(3); ?>">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i>Submit
                    </button>
                    <a href="<?php echo site_url('c_bukti_dukung/id/' . $this->uri->segment(3)) ?>" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Kembali
                    </a>
                </div>
            </form>


        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#file_input').on('change', function() {
            const file = this.files[0];
            const maxSize = 2 * 1024 * 1024;

            if (file) {
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran file terlalu besar!',
                        text: 'Maksimal adalah 2MB. File Anda: ' + (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                    });
                    $(this).val('');
                    return false;
                }

                const allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg'];
                const fileName = file.name;
                const fileExtension = fileName.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExtension)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format file tidak diizinkan!',
                        text: 'Hanya format berikut yang diizinkan: ' + allowedExtensions.join(', ')
                    });
                    $(this).val('');
                    return false;
                }
            }
        });
    });
</script>