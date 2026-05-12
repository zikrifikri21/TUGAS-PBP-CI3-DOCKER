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
                 SURAT PENUNJUKKAN DOSEN PEMBIMBING
             </h3>
             <h4 style="text-align:center; font-weight: normal;">
                 <span>Nomor : <?php echo $ujian->no_sp ?></span>
             </h4>
             <p style="margin-left: 0px; margin-right: 20px;">Dekan Fakultas Kehutanan dan Ilmu Lingkaran Universitas Halu Oleo. Dengan ini menunjuk dosen :</p>
             <table border="0" style="width:100%; font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                 <tr>
                     <td style="padding-left: 0.1em;">1.</td>
                     <td style=" padding-left: 0.1em; padding-right:  0.5em; padding-bottom:0.5em;">
                         Nama
                     </td>
                     <td>:</td>
                     <td style="font-weight: bold">
                         <?= $ujian->pembimbing_1->nama_dosen ?? ''; ?>
                     </td>
                 </tr>
                 <tr>
                     <td></td>
                     <td style=" padding-left: 0.1em; padding-right:  0.5em; padding-bottom:0.5em;">
                         NIP
                     </td>
                     <td>:</td>
                     <td>
                         <?= !empty($ujian->pembimbing_1) ? ((strlen($ujian->pembimbing_1->nip) < 18) ? '-' : $ujian->pembimbing_1->nip) : ''; ?>
                     </td>
                 </tr>
                 <tr>
                     <td></td>
                     <td style=" padding-left: 0.1em; padding-right:  0.5em; padding-bottom:0.5em;">
                         Pangkat/Golongan
                     </td>
                     <td>:</td>
                     <td>
                         <?= $ujian->pembimbing_1->pangkat ?? '-'; ?>
                     </td>
                 </tr>

                 <tr>
                     <td style="padding-left: 0.1em;">2.</td>
                     <td style=" padding-left: 0.1em; padding-right:  0.5em; padding-bottom:0.5em;">
                         Nama
                     </td>
                     <td>:</td>
                     <td style="font-weight: bold">
                         <?= $ujian->pembimbing_2->nama_dosen ?? ''; ?>
                     </td>
                 </tr>
                 <tr>
                     <td></td>
                     <td style=" padding-left: 0.1em; padding-right:  0.5em; padding-bottom:0.5em;">
                         NIP
                     </td>
                     <td>:</td>
                     <td>
                         <?= !empty($ujian->pembimbing_2) ? ((strlen($ujian->pembimbing_2->nip) < 18) ? '-' : $ujian->pembimbing_2->nip) : '';  ?>
                     </td>
                 </tr>
                 <tr>
                     <td></td>
                     <td style=" padding-left: 0.1em; padding-right:  0.5em; padding-bottom:0.5em;">
                         Pangkat/Golongan
                     </td>
                     <td>:</td>
                     <td>
                         <?= $ujian->pembimbing_2->pangkat ?? '-'; ?>
                     </td>
                 </tr>

             </table>
             <p style="margin-left: 0px; margin-right: 20px;">Untuk menjadi dosen pembimbing dalam penyusunan proposal, pelaksanaan penelitian dan penyusunan Skripsi kepada :</p>
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
                             <?= $ujian->jurusan->nama_jurusan ?>
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
                 </table>
             </div>

             <p style="margin-left: 0px; margin-right: 20px;">Demikian surat penunjukkan dosen pembimbing ini diberikan untuk dilaksanakan dengan penuh rasa tanggung jawab :</p>

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
                     <tr>
                         <td style="padding-left: 25em;">
                             a.n Dekan
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 25em;">
                             <?php if (!empty($ujian->plh_plt_sp)) echo $ujian->plh_plt_sp; ?>
                             Ketua Jurusan
                             <?= $ujian->jurusan->nama_jurusan; ?>
                         </td>
                     </tr>
                     <br><br>
                     <?php
                        $nama_ttd = $ujian->ttd_sp ? $ujian->jurusan->sekretaris_jurusan->nama_dosen : $ujian->jurusan->ketua_jurusan->nama_dosen;
                        $nip_ttd = $ujian->ttd_sp ? $ujian->jurusan->sekretaris_jurusan->nip : $ujian->jurusan->ketua_jurusan->nip;
                        $ttd = $ujian->ttd_sp ? $ujian->jurusan->sekretaris_jurusan->ttd_dosen : $ujian->jurusan->ketua_jurusan->ttd_dosen;
                        ?>
                     <tr>
                         <td style="padding-left: 25em; text-decoration: underline; text-align: center;">
                             <?php if ($ujian->status_putusan === 'verifikasi') { ?>
                                 <?= ZQrcode::get('assets/img/uho.png', $nama_ttd, 'M', 2, 0) ?>
                             <?php } ?>
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 25em; ">
                             <?= $nama_ttd; ?>
                             <br>
                             NIP. <?= $nip_ttd ?>
                         </td>
                     </tr>

                 </tbody>
             </table>

         </section>
     </div>
 </body>

 </html>