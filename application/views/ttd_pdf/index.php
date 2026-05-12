<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Tanda Tangan PDF</h4>
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
                <a href="/C_home">Dashboard</a>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="font-weight-light my-2"><i class="fas fa-qrcode"></i> Unggah Tanda Tangan Verifikasi PDF</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 border-right">
                                <form action="<?= base_url('ttd-pdf/store'); ?>" method="POST" enctype="multipart/form-data">
                                    <h4 class="mb-3">Pilih File Tanda Tangan</h4>
                                    <p class="text-muted">Silakan unggah gambar Tanda Tangan yang akan digunakan sebagai verifikator pada dokumen PDF Anda.</p>
                                    <div class="form-group mb-4">
                                        <label for="qrCodeFile" class="form-label d-block">
                                            <i class="fas fa-upload"></i> Pilih Gambar Tanda Tangan
                                        </label>
                                        <input type="file" class="form-control-file border p-2 rounded" id="qrCodeFile" name="ttd_pdf_file"
                                            accept="image/jpeg, image/png, image/jpg">
                                        <small class="form-text text-muted">Hanya file gambar (JPG, PNG, JPEG) yang diizinkan dan ukuran maksimal 2 MB.</small>
                                        <?php if ($msg = $this->session->flashdata('error')): ?>
                                            <div class="alert alert-danger mt-3">
                                                <?= is_array($msg) ? implode('<br>', $msg) : $msg ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($msg = $this->session->flashdata('success')): ?>
                                            <div class="alert alert-danger mt-3">
                                                <?= is_array($msg) ? implode('<br>', $msg) : $msg ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block mt-4"><i class="fas fa-check-circle"></i> Unggah Tanda Tangan</button>
                                </form>
                            </div>
                            <div class="col-md-6 d-flex flex-column justify-content-between">
                                <div>
                                    <h4 class="mb-3">Pratinjau Tanda Tangan</h4>
                                    <div class="text-center mb-3 p-3 border rounded bg-light">
                                        <img src="<?= $data; ?>" alt="Tanda Tangan Preview" class="img-fluid rounded" id="qrCodePreview" style="max-height: 200px; object-fit: contain;">
                                        <p class="text-muted mt-2 small">Gambar Tanda Tangan yang terakhir diunggah.</p>
                                    </div>
                                    <div class="alert alert-info" role="alert">
                                        <i class="fas fa-info-circle"></i> Setelah diunggah, Tanda Tangan ini akan otomatis terintegrasi ke dalam dokumen PDF.
                                    </div>
                                </div>
                                <div>
                                    <small class="text-muted">Pastikan Tanda T  angan yang diunggah resmi.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center small">
                        Sistem Verifikasi Dokumen Digital
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('qrCodeFile').addEventListener('change', function(event) {
                const [file] = event.target.files;
                if (file) {
                    document.getElementById('qrCodePreview').src = URL.createObjectURL(file);
                }
            });
        </script>
    </div>
</div>
