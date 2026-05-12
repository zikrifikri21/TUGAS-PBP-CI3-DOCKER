<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lampiran SK Seminar Proposal</title>
    <style>
        /* Reset & Setup Halaman */
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .container {
            width: 100%;
            max-width: 210mm;
            /* A4 Width */
            margin: 0 auto;
            padding: 10mm;
            /* Padding margin kertas */
            box-sizing: border-box;
        }

        /* Helper Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        td {
            vertical-align: top;
            padding: 2px 5px;
        }

        /* Bagian Header (Lampiran, Nomor, Tentang) */
        .header-table td {
            padding-bottom: 5px;
        }

        .label-head {
            width: 80px;
        }

        .sep-head {
            width: 10px;
            text-align: center;
        }

        /* Bagian Tabel Utama (Bordered) */
        .main-table {
            margin-top: 10px;
            border: 1px solid black;
        }

        .main-table td {
            border: 1px solid black;
            padding: 5px 8px;
            /* Spacing dalam sel */
        }

        .col-label {
            width: 200px;
            /* Lebar kolom kiri */
        }

        .col-separator {
            /* Trik visual: Kolom ini digabung ke cell konten di border layout,
               tapi kita handle manual dengan text ": " di dalam data
               atau menggunakan layout 3 kolom jika perlu presisi.
               Di sini saya gunakan layout 2 kolom agar border vertikal tengah tegas. */
            width: 10px;
            border-left: none;
            border-right: none;
        }

        /* List Styling (1. 2. 3.) */
        ol {
            margin: 0;
            padding-left: 18px;
        }

        li {
            margin-bottom: 2px;
        }

        /* Nested Table untuk Panitia Penguji agar rapi */
        .panitia-table td {
            border: none;
            padding: 1px 0;
        }

        .label-panitia {
            width: 80px;
        }

        /* Bagian Tanda Tangan */
        .ttd-wrapper {
            margin-top: 40px;
        }

        .ttd-box {
            float: right;
            width: 46%;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER SECTION -->
        <table class="header-table">
            <tr>
                <td class="label-head">Lampiran</td>
                <td class="sep-head">:</td>
                <td>Surat Keputusan Dekan Fakultas Kehutanan dan Ilmu Lingkungan Universitas Halu Oleo</td>
            </tr>
            <tr>
                <td class="label-head">Nomor</td>
                <td class="sep-head">:</td>
                <td><?= isset($sk->sk_dekan) ? $sk->sk_dekan->no_sk : '' ?></td>
            </tr>
            <tr>
                <td class="label-head">Tentang</td>
                <td class="sep-head">:</td>
                <td>Penetapan Panitia Seminar <?= ucwords($sk->ujian->jenis_ujian) ?> Penelitian Mahasiswa Fakultas Kehutanan dan Ilmu Lingkungan UHO</td>
            </tr>
        </table>

        <br>

        <!-- MAIN DATA TABLE -->
        <table class="main-table">
            <!-- Nama -->
            <tr>
                <td class="col-label">Nama Mahasiswa</td>
                <td>: <?= isset($sk->ujian->mahasiswa) ? $sk->ujian->mahasiswa->nama_mahasiswa : '' ?></td>
            </tr>
            <!-- NIM -->
            <tr>
                <td class="col-label">NIM</td>
                <td>: <?= isset($sk->ujian->mahasiswa) ? $sk->ujian->mahasiswa->nim : '' ?></td>
            </tr>
            <!-- Prodi -->
            <tr>
                <td class="col-label">Program Studi</td>
                <td>: <?= isset($sk->ujian->mahasiswa->jurusan) ? $sk->ujian->mahasiswa->jurusan->nama_jurusan : '' ?></td>
            </tr>
            <!-- Judul -->
            <tr>
                <td class="col-label">Judul Skripsi</td>
                <td>: <?= isset($sk->ujian) ? $sk->ujian->judul : '' ?></td>
            </tr>
            <!-- Pembimbing -->
            <tr>
                <td class="col-label">Pembimbing</td>
                <td>:
                    <!-- Menggunakan Margin-left agar nomor urut lurus di bawah titik dua -->
                    <div style="margin-left: 10px; display: inline-block; vertical-align: top;">
                        1. <?= isset($sk->ujian->pembimbing_1) ? $sk->ujian->pembimbing_1->nama_dosen : '' ?><br>
                        2. <?= isset($sk->ujian->pembimbing_2) ? $sk->ujian->pembimbing_2->nama_dosen : '' ?>
                    </div>
                </td>
            </tr>
            <!-- Panitia Penguji -->
            <tr>
                <td class="col-label">Panitia Penguji</td>
                <td style="padding: 0;">
                    <!-- Tabel di dalam Tabel untuk merapikan Ketua/Sekretaris/Anggota -->
                    <table class="panitia-table" style="width: 100%; margin: 5px 8px;">
                        <tr>
                            <td style="width: 10px;">:</td>
                            <td class="label-panitia">Ketua</td>
                            <td style="width: 10px;">:</td>
                            <td><?= isset($sk->ujian->ketua) ? $sk->ujian->ketua->nama_dosen : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="label-panitia">Sekretaris</td>
                            <td>:</td>
                            <td>
                                <?= isset($sk->ujian->sekretaris) ? $sk->ujian->sekretaris->nama_dosen : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="label-panitia">Anggota</td>
                            <td>:</td>
                            <td>
                                <table style="width: 100%; margin-top: -3px;">
                                    <tr>
                                        <td style="width: 15px;">1.</td>
                                        <td>
                                            <?= isset($sk->ujian->anggota_1) ? $sk->ujian->anggota_1->nama_dosen : '' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>
                                            <?= isset($sk->ujian->anggota_2) ? $sk->ujian->anggota_2->nama_dosen : '' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>
                                            <?= isset($sk->ujian->anggota_3) ? $sk->ujian->anggota_3->nama_dosen : '' ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- FOOTER / SIGNATURE SECTION -->
        <div class="ttd-wrapper">
            <div class="ttd-box">
                <table>
                    <tr>
                        <td style="width: 100px;">Ditetapkan di</td>
                        <td>:</td>
                        <td>Kendari</td>
                    </tr>
                    <tr>
                        <td style="width: 110px;">Pada Tanggal</td>
                        <td>:</td>
                        <td><?= indonesiaDate($sk->sk_dekan->tgl_sk); ?></td>
                    </tr>
                </table>

                <div style="margin-top: 8px;">Dekan,</div>

                <br><br><br>
                <?php
                $nip_ttd = isset($sk->ujian->kajur) ? $sk->ujian->kajur->nip : '';
                $nama_ttd = isset($sk->ujian->kajur) ? $sk->ujian->kajur->nama_dosen : '';
                ?>
                <?php if ($sk->ujian->status_putusan === 'verifikasi') { ?>
                    <?= ZQrcode::get('assets/img/uho.png', $nama_ttd, 'M', 3, 0) ?>
                <?php } ?>
                <br>
                <!-- Nama Dekan -->
                <div style="font-weight: bold;">
                    <?= $nama_ttd; ?>
                </div>
                <div>NIP. <?= $nip_ttd; ?></div>
            </div>
            <!-- Clearfix agar float aman -->
            <div style="clear: both;"></div>
        </div>

    </div>

</body>

</html>
