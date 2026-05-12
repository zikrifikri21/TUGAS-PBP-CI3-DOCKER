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
                 SURAT TUGAS UJIAN <?php echo strtoupper($ujian->jenis_ujian) ?>
             </h3>
             <h3 style="text-align:center;">
                 <span>Nomor : <?php echo $ujian->no_st ?></span>
             </h3>
             <p style="margin-left: 25px; margin-right: 50px;">Dekan Fakultas Kehutanan dan Ilmu Lingkaran Universitas Halu Oleo Menugaskan Kepada :</p>
             <table border="1" style="width:100%; font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                 <tr>
                     <td style="width: 25px;">No.</td>
                     <td style="text-align: center;">Nama</td>
                     <td style="text-align: center;">Keterangan</td>
                 </tr>
                 <tr>
                     <td>1</td>
                     <td>
                         <?= $ujian->ketua ? $ujian->ketua->nama_dosen : '';
                            ?>
                     </td>
                     <td>Ketua</td>
                 </tr>
                 <tr>
                     <td>2</td>
                     <td>
                         <?= $ujian->sekretaris ? $ujian->sekretaris->nama_dosen : '';
                            ?>
                     </td>
                     <td>Sekretaris</td>
                 </tr>
                 <tr>
                     <td>3</td>
                     <td>
                         <?= $ujian->anggota_1 ? $ujian->anggota_1->nama_dosen : '';
                            ?>
                     </td>
                     <td>Anggota</td>
                 </tr>
                 <tr>
                     <td>4</td>
                     <td>
                         <?= $ujian->anggota_2 ? $ujian->anggota_2->nama_dosen : '';
                            ?>
                     </td>
                     <td>Anggota</td>
                 </tr>
                 <tr>
                     <td>5</td>
                     <td>
                         <?= $ujian->anggota_3 ? $ujian->anggota_3->nama_dosen : '';
                            ?>
                     </td>
                     <td>Anggota</td>
                 </tr>
             </table>
             <p style="margin-left: 25px; margin-right: 50px;">Untuk Menjadi Panitia Ujian <?php echo ucwords(strtoupper($ujian->jenis_ujian)) ?> Penelitian Mahasiswa :</p>
             <div class="div" style="padding-left: 4em;">
                 <table style="border:0px; font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em;">
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
                             <?=
                                $ujian->jurusan->nama_jurusan;
                                // $nama_jurusan = '';
                                // $ketua_jurusan = '';
                                // foreach ($jurusan as $keys) {
                                //     if ($ujian->jurusan_id == $keys->id) {
                                //         $nama_jurusan = $keys->nama_jurusan;
                                //         $ketua_jurusan = $keys->ketua_jurusan;
                                //         echo $keys->nama_jurusan;
                                //     }
                                // }

                                ?>
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
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; font-weight: bold;">
                             Pembimbing 1
                         </td>
                         <td>:</td>
                         <td style="font-weight: bold">
                             <?= $ujian->pembimbing_1->nama_dosen ?? ''; ?>

                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; font-weight:bold;">
                             Pembimbing 2
                         </td>
                         <td>:</td>
                         <td style="font-weight: bold">
                             <?= $ujian->pembimbing_2->nama_dosen ?? ''; ?>
                         </td>
                     </tr>

                 </table>
             </div>

             <p style="margin-left: 25px; margin-right: 50px;">Yang Insya Allah akan dilaksanakan pada :</p>
             <div class="div" style="padding-left: 4em;">
                 <table style="border:0px; font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 7em; padding-bottom:0.5em;">
                             Hari/Tanggal
                         </td>
                         <td>:</td>
                         <td>
                             <?php
                                $day = date('D', strtotime($ujian->hari_ujian));
                                $dayList = array(
                                    'Sun' => 'Minggu',
                                    'Mon' => 'Senin',
                                    'Tue' => 'Selasa',
                                    'Wed' => 'Rabu',
                                    'Thu' => 'Kamis',
                                    'Fri' => 'Jumat',
                                    'Sat' => 'Sabtu'
                                );
                                echo $dayList[$day] . ', ' . indonesiaDate($ujian->hari_ujian) ?>
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 7em; padding-bottom:0.5em;">
                             Jam
                         </td>
                         <td>:</td>
                         <td>
                             <?php echo $ujian->jam_ujian ?>
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 7em; padding-bottom:0.5em;">
                             Tempat
                         </td>
                         <td>:</td>
                         <td>
                             <?php echo $ujian->tempat_ujian ?>
                         </td>
                     </tr>

                 </table>
             </div>

             <table border="" style="font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                 <tbody>
                     <tr>
                         <td rowspan="7" style="padding-right: 2em; vertical-align: bottom;">
                             <?php if ($ujian->status_putusan === 'verifikasi') { ?>
                                 <?php $verifikasi = zurl('verifikasi-qrcode/' . $ujian->id); ?>
                                 <?= ZQrcode::get('assets/img/uho.png', $verifikasi, 'M', 3, 2) ?>
                             <?php } ?>
                         </td>
                         <td style="padding-left: 25em;">
                             Kendari, <?php echo indonesiaDate(date('Y-m-d')) ?>
                         </td>
                     </tr>
                     <br><br>

                     <?php
                        // $nip_ttd = '';
                        // $nama_ttd = '';
                        // if (!empty($ujian->ttd_st))
                        //     $ketua_jurusan = $ujian->ttd_st;
                        // foreach ($dosen as $keys) {

                        //     if ($ketua_jurusan == $keys->id) {
                        //         $nama_ttd = $keys->nama_dosen;
                        //         $nip_ttd = $keys->nip;
                        //     }
                        // }
                        ?>
                     <tr>
                         <td style="padding-left: 25em;">
                             a.n Dekan
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 25em;">
                             <?php if (!empty($ujian->plh_plt_st)) echo $ujian->plh_plt_st; ?>
                             Ketua Jurusan <?= $ujian->jurusan->nama_jurusan; ?>
                         </td>
                     </tr>

                     <br><br><br><br><br><br>
                     <?php
                        $nama_ttd = $ujian->ttd_st ? $ujian->jurusan->sekretaris_jurusan->nama_dosen : $ujian->jurusan->ketua_jurusan->nama_dosen;
                        $nip_ttd = $ujian->ttd_st ? $ujian->jurusan->sekretaris_jurusan->nip : $ujian->jurusan->ketua_jurusan->nip;
                        $ttd = $ujian->ttd_st ? $ujian->jurusan->sekretaris_jurusan->ttd_dosen : $ujian->jurusan->ketua_jurusan->ttd_dosen;
                        ?>

                     <tr>
                         <td style="padding-left: 25em; text-decoration: underline;">
                             <?php if ($ujian->status_putusan === 'verifikasi') { ?>
                                 <?= ZQrcode::get('assets/img/uho.png', $nama_ttd, 'M', 2, 0) ?>
                             <?php } ?>
                             <br>
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 25em; ">
                             <?= $nama_ttd ?>
                             NIP. <?= $nip_ttd ?>
                         </td>
                     </tr>

                 </tbody>
             </table>

         </section>
     </div>
 </body>

 </html>
