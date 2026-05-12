<style>
    .verification-card {
        max-width: 600px;
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background-color: #ffffff;
    }

    .card-header-success {
        background-color: #28a745;
        /* Green for success */
        color: white;
        padding: 25px;
        text-align: center;
        font-size: 1.8rem;
        border-bottom: none;
    }

    .card-header-fail {
        background-color: #dc3545;
        /* Red for failure */
        color: white;
        padding: 25px;
        text-align: center;
        font-size: 1.8rem;
        border-bottom: none;
    }

    .card-body {
        padding: 40px;
    }

    .icon-large {
        font-size: 3.5rem;
        margin-bottom: 20px;
    }

    .text-success-custom {
        color: #28a745;
    }

    .text-fail-custom {
        color: #dc3545;
    }

    .detail-item {
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .detail-item strong {
        display: inline-block;
        min-width: 150px;
        color: #495057;
    }

    .back-button {
        margin-top: 30px;
    }

    .animation-fade-in {
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .apalah {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<?php if (!zsession('id')): ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<?php endif; ?>
<div class="container mt-5 apalah">
    <div class="verification-card animation-fade-in">
        <!-- Contoh: Status Verifikasi Berhasil -->
        <div class="card-header-success">
            <i class="fas fa-check-circle icon-large"></i>
            <h3>Dokumen Valid!</h3>
        </div>
        <!-- Contoh: Status Verifikasi Gagal
            <div class="card-header-fail">
                <i class="fas fa-times-circle icon-large"></i>
                <h3>Verifikasi Gagal</h3>
            </div>
            -->

        <div class="card-body">
            <p class="lead text-center mb-4">
                Dokumen yang Anda pindai telah berhasil diverifikasi.
                <!-- Untuk gagal: Dokumen yang Anda pindai tidak dapat diverifikasi. -->
            </p>

            <h4 class="mb-3">Detail Verifikasi:</h4>
            <div class="detail-item">
                <strong><i class="fas fa-file-alt"></i> Nama Dokumen:</strong>
                <span>Laporan Akhir Proyek Smart City</span>
            </div>
            <div class="detail-item">
                <strong><i class="fas fa-barcode"></i> ID Dokumen:</strong>
                <span>DOC-20230911-00123</span>
            </div>
            <div class="detail-item">
                <strong><i class="fas fa-calendar-alt"></i> Tanggal Verifikasi:</strong>
                <span>11 September 2023, 14:35 WIB</span>
            </div>
            <div class="detail-item">
                <strong><i class="fas fa-user-shield"></i> Dikeluarkan Oleh:</strong>
                <span>Departemen Ilmu Lingkungan, Universitas Kendari</span>
            </div>
            <div class="detail-item">
                <strong><i class="fas fa-link"></i> Tautan Dokumen Asli:</strong>
                <span><a href="<?= zurl('C_auth') ?>">Lihat Dokumen Asli</a></span>
            </div>

            <!-- Pesan tambahan jika verifikasi gagal -->
            <!--
                <div class="alert alert-danger mt-4" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Peringatan!</h5>
                    <p>QR Code tidak valid atau dokumen telah diubah. Harap hubungi pihak yang mengeluarkan dokumen.</p>
                    <hr>
                    <p class="mb-0">Kode Error: QR-INVALID-DATA</p>
                </div>
                -->

            <div class="text-center back-button">
                <a href="javascript:history.back()" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <!-- Atau, tautan ke halaman utama jika ada -->
                <!-- <a href="/" class="btn btn-outline-secondary btn-lg ml-3">
                <i class="fas fa-home"></i> Halaman Utama
            </a> -->
            </div>
        </div>
    </div>
</div>
