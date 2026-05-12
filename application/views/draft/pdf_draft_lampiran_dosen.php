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
                <td><?= isset($sk->no_sk) ? $sk->no_sk : '/UN29.16/PK/2025' ?></td>
            </tr>
            <tr>
                <td class="label-head">Tentang</td>
                <td class="sep-head">:</td>
                <td>Penetapan Panitia Seminar <?= ucwords($sk->jenis_ujian) ?> Penelitian Mahasiswa Fakultas Kehutanan dan Ilmu Lingkungan UHO</td>
            </tr>
        </table>

        <br>

        <!-- MAIN DATA TABLE -->
        <table class="main-table">
            <!-- Nama -->
            <tr>
                <td class="col-label">Nama Mahasiswa</td>
                <td>: <?= isset($sk->nama_mahasiswa) ? $sk->nama_mahasiswa : '' ?></td>
            </tr>
            <!-- NIM -->
            <tr>
                <td class="col-label">NIM</td>
                <td>: <?= isset($sk->nim) ? $sk->nim : '' ?></td>
            </tr>
            <!-- Prodi -->
            <tr>
                <td class="col-label">Program Studi</td>
                <td>: <?= isset($sk->nama_jurusan) ? $sk->nama_jurusan : '' ?></td>
            </tr>
            <!-- Judul -->
            <tr>
                <td class="col-label">Judul Skripsi</td>
                <td>: <?= isset($sk->judul) ? $sk->judul : '' ?></td>
            </tr>
            <!-- Pembimbing -->
            <tr>
                <?php
                $pembimbing1 = DosenFhil::table()->where('id', $sk->pembimbing_1)->first();
                $pembimbing2 = DosenFhil::table()->where('id', $sk->pembimbing_2)->first();
                ?>
                <td class="col-label">Pembimbing</td>
                <td>:
                    <!-- Menggunakan Margin-left agar nomor urut lurus di bawah titik dua -->
                    <div style="margin-left: 10px; display: inline-block; vertical-align: top;">
                        1. <?= isset($pembimbing1) ? $pembimbing1->nama_dosen : '' ?><br>
                        2. <?= isset($pembimbing2) ? $pembimbing2->nama_dosen : '' ?>
                    </div>
                </td>
            </tr>
            <!-- Panitia Penguji -->
            <tr>
                <td class="col-label">Panitia Penguji</td>
                <td style="padding: 0;">
                    <!-- Tabel di dalam Tabel untuk merapikan Ketua/Sekretaris/Anggota -->
                    <table class="panitia-table" style="width: 100%; margin: 5px 8px;">
                        <?php
                        $ketua = DosenFhil::table()->where('id', $sk->ketua)->first();
                        ?>
                        <tr>
                            <td style="width: 10px;">:</td>
                            <td class="label-panitia">Ketua</td>
                            <td style="width: 10px;">:</td>
                            <td><?= isset($ketua) ? $ketua->nama_dosen : '' ?></td>
                        </tr>
                        <tr>
                            <?php
                            $sekretaris = DosenFhil::table()->where('id', $sk->sekretaris)->first();
                            ?>
                            <td></td>
                            <td class="label-panitia">Sekretaris</td>
                            <td>:</td>
                            <td><?= isset($sekretaris) ? $sekretaris->nama_dosen : '' ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="label-panitia">Anggota</td>
                            <td>:</td>
                            <td>
                                <table style="width: 100%; margin-top: -3px;">
                                    <tr>
                                        <?php
                                        $anggota1 = DosenFhil::table()->where('id', $sk->anggota_1)->first();
                                        ?>
                                        <td style="width: 15px;">1.</td>
                                        <td><?= isset($anggota1) ? $anggota1->nama_dosen : '' ?></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        $anggota2 = DosenFhil::table()->where('id', $sk->anggota_2)->first();
                                        ?>
                                        <td>2.</td>
                                        <td><?= isset($anggota2) ? $anggota2->nama_dosen : '' ?></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        $anggota3 = DosenFhil::table()->where('id', $sk->anggota_3)->first();
                                        ?>
                                        <td>3.</td>
                                        <td><?= isset($anggota3) ? $anggota3->nama_dosen : '' ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- FOOTER / SIGNATURE SECTION -->
        <?php
        $dekan = DosenFhil::table()->where('id', $sk->ttd_dekan)->first();
        ?>
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
                        <td><?= indonesiaDate($sk->tgl_sk); ?></td>
                    </tr>
                </table>

                <div style="margin-top: 10px;">Dekan,</div>

                <br><br>
                <?php if (!empty($sk->status_putusan) && $sk->status_putusan == 'v3') { ?>
                    <?= ZQrcode::get('assets/img/uho.png', $dekan->nama_dosen, 'M', 2, 0) ?>
                <?php } ?>
                <br><br>

                <!-- Nama Dekan -->
                <div style="font-weight: bold;"><?= isset($dekan->nama_dosen) ? $dekan->nama_dosen : '' ?></div>
                <div>NIP. <?= isset($dekan->nip) ? $dekan->nip : '' ?></div>
            </div>
            <!-- Clearfix agar float aman -->
            <div style="clear: both;"></div>
        </div>

    </div>

</body>

</html>