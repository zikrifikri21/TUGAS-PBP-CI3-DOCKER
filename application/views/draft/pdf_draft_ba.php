 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= $title; ?></title>

     <style>
         table {
             border-collapse: collapse;
         }

         table,
         th,
         td {
             /* border: 1px solid black; */
         }

         th,
         td {
             padding: 7px;
         }

         th {
             background-color: #4CAF50;
             color: white;
         }
     </style>

 </head>

 <body>
     <div id="container">
         <section>
             <br>
             <center>
                 <table>
                     <tr>
                         <td>
                             <img src="<?= zurl('/assets/img/uho.png'); ?>" width="80 " height="80">
                         </td>
                         <td>
                             <center>
                                 <font size="5">KEMENTERIAN PENDIDIKAN TINGGI,SAINS, DAN TEKNOLOGI</font><br>
                                 <font size="4">UNIVERSITAS HALU OLEO</font><br>
                                 <font size="4"><b>FAKULTAS KEHUTANAN DAN ILMU LINGKUNGAN</b></font><br>
                                 <font size="3">Kampus Hijau Bumi Tridharma Anduonohu, Jalan H.E.A Mokodompit
                                 </font><br>
                                 <font size="3">Telp-Fax. (0401) 3192511 Kendari 93232 </font><br>
                                 <font size="3">Laman <a href="https://fisip.uho.ac.id/"
                                         target="_blank">fhil@uho.ac.id</a></font>
                             </center>
                         </td>
                     </tr>
                 </table>
                 <hr style="border: 2px solid black">
             </center>
             <h3 style="text-align:center; text-decoration: underline;">
                 BERITA ACARA PELAKSANAAN UJIAN <?php echo strtoupper($ujian->jenis_ujian) ?>
             </h3>
             <h3 style="text-align:center;">
                 <span>Berdasarkan Surat Tugas Nomor : <?php echo $ujian->no_st ?></span>
             </h3>
             <?php
                function deskripsi($ujian)
                {
                    if (empty($ujian->hari_ujian)) {
                        return "";
                    }

                    $timestamp = strtotime($ujian->hari_ujian);

                    $dayList = array(
                        'Sun' => 'Minggu',
                        'Mon' => 'Senin',
                        'Tue' => 'Selasa',
                        'Wed' => 'Rabu',
                        'Thu' => 'Kamis',
                        'Fri' => 'Jumat',
                        'Sat' => 'Sabtu'
                    );
                    $hari = $dayList[date('D', $timestamp)];

                    $tanggal_angka = date('d', $timestamp);
                    $bulan_angka   = date('m', $timestamp);
                    $tahun_angka   = date('Y', $timestamp);

                    $tanggal_eja = ucwords(terbilang($tanggal_angka));
                    $bulan_nama  = get_bulan_indo($bulan_angka);
                    $tahun_eja   = ucwords(terbilang($tahun_angka));

                    $tempat_ujian = $ujian->tempat_ujian;
                    $jenis_ujian  = ucwords($ujian->jenis_ujian);

                    $text = sprintf(
                        "Pada Hari ini %s Tanggal %s Bulan %s Tahun %s. Bertempat %s Jurusan Kehutanan Fakultas Kehutanan dan Ilmu Lingkungan Universitas Halu Oleo Telah dilaksanakan Ujian %s Mahasiswa Atas Nama :",
                        $hari,
                        $tanggal_eja,
                        $bulan_nama,
                        $tahun_eja,
                        $tempat_ujian,
                        $jenis_ujian
                    );

                    return '<p style="margin-left: 0px; margin-right: 0px;">' . $text . '</p>';
                } ?>
             <?= deskripsi($ujian); ?>
             <div class="div" style="padding-left: 0em;">
                 <table style="border:0px; font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; ">
                             Nama
                         </td>
                         <td>:</td>
                         <td style="font-weight: bold">
                             <?php echo $ujian->mahasiswa->nama_mahasiswa ?>
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em;">
                             Stambuk
                         </td>
                         <td>:</td>
                         <td>
                             <?php echo $ujian->mahasiswa->nim ?>
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em;">
                             Jurusan
                         </td>
                         <td>:</td>
                         <td>
                             <?= $ujian->jurusan->nama_jurusan; ?>
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; ">
                             Judul Skripsi
                         </td>
                         <td>:</td>
                         <td style="line-height: 1.6;">
                             <?php echo $ujian->judul ?>
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; ">
                             IPK Sementara
                         </td>
                         <td>:</td>
                         <td style="line-height: 1.6;">
                             <?php echo $ujian->ipk_sementara ?>
                         </td>
                     </tr>

                     <?php
                        if (!empty($ujian->penilaian)) {
                            $sum   = 0;
                            $count = 0;
                            foreach ($ujian->penilaian as $value) {
                                $count++;
                                $sum += (int)$value->nilai;
                            }
                            $total = ($count > 0) ? $sum / $count : 0;
                            $total = number_format($total, 2, '.', '');
                            if ($total >= 81) {
                                $badge = 'A';
                            } elseif ($total >= 61) {
                                $badge = 'B';
                            } else {
                                $badge = 'Tidak Lulus';
                            }
                        }
                        ?>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; ">
                             Dengan Nilai
                         </td>
                         <td>:</td>
                         <td style="line-height: 1.6;">
                             <?php
                                if (auth('tbl_user_level_id') == 5) {
                                    if ($ujian->akhiri_ujian == 1) {
                                        echo $ujian->penilaian ? $total : '-';
                                    }
                                } else echo $ujian->penilaian ? $total : '-'; ?>
                         </td>
                     </tr>
                 </table>
             </div>
             <br>
             <table border="1" style="width:100%; font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                 <tr>
                     <td style="width: 25px;">No.</td>
                     <td style="text-align: center;">Nama</td>
                     <td style="text-align: center;">Keterangan</td>
                     <td style="text-align: center;">Tanda Tangan</td>
                 </tr>
                 <tr>
                     <td>1</td>
                     <td>
                         <?= $ujian->ketua ? $ujian->ketua->nama_dosen : ''; ?>
                     </td>
                     <td>Ketua</td>
                     <td>1.
                         <?php
                            if (!empty($ujian->penilaian) && !empty($ujian->ketua)) {
                                echo ZQrcode::get('assets/img/uho.png', $ujian->ketua->nip, 'M', 2, 0);
                                // echo '<img src="' . base_url('upload/ttd_dosen/' . $ujian->ketua->ttd_dosen) . '" alt="" width="80px">';
                            } ?>
                     </td>
                 </tr>
                 <tr>
                     <td>2</td>
                     <td>
                         <?= $ujian->sekretaris ? $ujian->sekretaris->nama_dosen : ''; ?>
                     </td>
                     <td>Sekretaris</td>
                     <td style="padding-left: 80px;">2.
                         <?php
                            if (!empty($ujian->penilaian) && !empty($ujian->sekretaris)) {
                                echo ZQrcode::get('assets/img/uho.png', $ujian->sekretaris->nip, 'M', 2, 0);
                                // echo '<img src="' . base_url('upload/ttd_dosen/' . $ujian->sekretaris->ttd_dosen) . '" alt="" width="80px">';
                            } ?>
                     </td>
                 </tr>
                 <tr>
                     <td>3</td>
                     <td>
                         <?= $ujian->anggota_1 ? $ujian->anggota_1->nama_dosen : ''; ?>
                     </td>
                     <td>Anggota</td>
                     <td>3.
                         <?php
                            if (!empty($ujian->penilaian) && !empty($ujian->anggota_1)) {
                                echo ZQrcode::get('assets/img/uho.png', $ujian->anggota_1->nip, 'M', 2, 0);
                                // echo '<img src="' . base_url('upload/ttd_dosen/' . $ujian->anggota_1->ttd_dosen) . '" alt="" width="80px">';
                            } ?>
                     </td>
                 </tr>
                 <tr>
                     <td>4</td>
                     <td>
                         <?= $ujian->anggota_2 ? $ujian->anggota_2->nama_dosen : ''; ?>
                     </td>
                     <td>Anggota</td>
                     <td style="padding-left: 80px;">4.
                         <?php
                            if (!empty($ujian->penilaian) && !empty($ujian->anggota_2)) {
                                echo ZQrcode::get('assets/img/uho.png', $ujian->anggota_2->nip, 'M', 2, 0);
                                // echo '<img src="' . base_url('upload/ttd_dosen/' . $ujian->anggota_2->ttd_dosen) . '" alt="" width="80px">';
                            } ?>
                     </td>
                 </tr>
                 <tr>
                     <td>5</td>
                     <td>
                         <?= $ujian->anggota_3 ? $ujian->anggota_3->nama_dosen : ''; ?>
                     </td>
                     <td>Anggota</td>
                     <td>5.
                         <?php
                            if (!empty($ujian->penilaian) && !empty($ujian->anggota_3)) {
                                echo ZQrcode::get('assets/img/uho.png', $ujian->anggota_3->nip, 'M', 2, 0);
                                // echo '<img src="' . base_url('upload/ttd_dosen/' . $ujian->anggota_3->ttd_dosen) . '" alt="" width="80px">';
                            } ?>
                     </td>
                 </tr>
             </table>
             <?php
                if (auth('tbl_user_level_id') == 5) {
                    if ($ujian->akhiri_ujian == 1) {
                        echo '<p style="margin-left: 25px;">Nilai Ujian : Angka = ' . $total ?? '' . '</p>';
                        echo '<p style="margin-left: 7.5em;"> Huruf = ' . $badge ?? '' . '</p>';
                    } else {
                        echo '<p style="margin-left: 25px;">Nilai Ujian : Angka = ......</p>';
                        echo '<p style="margin-left: 7.5em;"> Huruf = ......</p>';
                    }
                } else {
                    if ($ujian->penilaian) {
                        echo '<p style="margin-left: 25px;">Nilai Ujian : Angka = ' . $total ?? '' . '</p>';
                        echo '<p style="margin-left: 7.5em;"> Huruf = ' . $badge ?? '' . '</p>';
                    } else {
                        echo '<p style="margin-left: 25px;">Nilai Ujian : Angka = ......</p>';
                        echo '<p style="margin-left: 7.5em;"> Huruf = ......</p>';
                    }
                }
                ?>



             <table border="" style="font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                 <tbody>
                     <tr>
                         <td rowspan="7" style="padding-right: 2em; vertical-align: bottom;">
                             <?php if ($ujian->status_putusan === 'verifikasi') { ?>
                                 <?php $verifikasi = zurl('verifikasi-qrcode/' . $ujian->id); ?>
                                 <?= ZQrcode::get('assets/img/uho.png', $verifikasi, 'M', 2, 0) ?>
                             <?php } ?>
                         </td>
                         <td style="padding-left: 23em;">
                             Kendari, <?php echo indonesiaDate(date('Y-m-d')) ?>
                         </td>
                     </tr>
                     <br><br>
                     <tr>
                         <td style="padding-left: 23em;">
                             Mengetahui
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 23em;">
                             Ketua Panitia
                         </td>
                     </tr>

                     <br><br><br>

                     <?php if ($ujian->kajur) { ?>
                         <?php
                            $nama_ttd = $ujian->ttd_ba ? $ujian->sekretaris_ba->nama_dosen : $ujian->kajur->nama_dosen;
                            $nip_ttd = $ujian->ttd_ba ? $ujian->sekretaris_ba->nip : $ujian->kajur->nip;
                            ?>
                     <?php } else { ?>
                         <?php
                            $nama_ttd = $ujian->ttd_ba ? $ujian->sekretaris_ba->nama_dosen : $ujian->jurusan->ketua_jurusan->nama_dosen;
                            $nip_ttd = $ujian->ttd_ba ? $ujian->sekretaris_ba->nip : $ujian->jurusan->ketua_jurusan->nip;
                            ?>
                     <?php } ?>
                     <tr>
                         <td style="padding-left: 23em; text-decoration: underline;">
                             <?php if ($ujian->status_putusan === 'verifikasi') { ?>
                                 <?= ZQrcode::get('assets/img/uho.png', $nama_ttd, 'M', 2, 0) ?>
                             <?php } ?>
                             <br>
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 23em; ">
                             <?= $nama_ttd ?>
                             <br>
                             NIP. <?= $nip_ttd ?>
                         </td>
                     </tr>

                 </tbody>
             </table>

             <br>
             <br>
             <p style="font-style: italic;">Catatan :</p>
             <p style="font-style: italic;">*) Nilai 61 - 81 = B dan ≥ 81 = A </p>

         </section>
     </div>
 </body>

 </html>