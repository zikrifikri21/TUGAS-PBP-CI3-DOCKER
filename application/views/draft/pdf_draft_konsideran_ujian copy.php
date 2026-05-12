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
             <h3 style="text-align:center;">
                 KEPUTUSAN<br>DEKAN FAKULTAS KEHUTANAN DAN ILMU LINGKUNGAN<br>
                 <span>Nomor : <?php echo $sk->no_sk ?></span><br>
                 TENTANG
             </h3>

             <h3 style="text-align:center;">
                 PENETAPAN PANITIA UJIAN <?php echo strtoupper($sk->jenis_ujian) ?> PENELITIAN MAHASISWA<br>
                 FAKULTAS KEHUTANAN DAN ILMU LINGKUNGAN<br>
                 UNIVERSITAS HALU OLEO<br><br>
                 DEKAN FAKULTAS KEHUTANAN DAN ILMU LINGKUNGAN<br>
                 UNIVERSITAS HALU OLEO
             </h3>
             <br>


             <div class="div" style="padding-left: 0em;">
                 <table style="border:1px; font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">
                             Menimbang
                         </td>
                         <td style="vertical-align: top;">:</td>
                         <td style="vertical-align: top;">
                             a.
                         </td>
                         <td>
                             Bahwa dalam rangka penyelesaian studi mahasiswa Fakultas Kehutanan dan Ilmu Lingkungan Universitas Halu Oleo, mahasiswa di wajibkan menyusun skripsi.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; ">
                         </td>
                         <td></td>
                         <td>
                             b.
                         </td>
                         <td>
                             Bahwa sebelum dan setelah penelitian/penulisan karya ilmiah dilaksanakan perlu diseminarkan di hadapan dosen panitia seminar proposal.
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             c.
                         </td>
                         <td>
                             Bahwa untuk maksud tersebut di atas perlu ditetapkan dengan Surat Keputusan Dekan.
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">
                             Mengingat
                         </td>
                         <td style="vertical-align: top;">:</td>
                         <td style="vertical-align: top;">
                             1.
                         </td>
                         <td>
                             Undang-Undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             2.
                         </td>
                         <td>
                             Undang-Undang Nomor 14 Tahun 2005 tentang Guru dan Dosen.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             3.
                         </td>
                         <td>
                             Undang-Undang Nomor 12 Tahun 2012 tentang Pendidikan Tinggi.
                             Peraturan Presiden Republik Indonesia Nomor: 82 Tahun 2019 tentang Kementerian Pendidikan dan Kebudayaan.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             4.
                         </td>
                         <td>
                             Peraturan Pemerintah Nomor : 19 Tahun 2005 tentang standar pendidikan.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             5.
                         </td>
                         <td>
                             Peraturan Pemerintah Nomor : 37 Tahun 2009 tentang Dosen.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             6.
                         </td>
                         <td>
                             Peraturan Pemerintah Nomor : 66 Tahun 2010 tentang Pengelolaan dan Penyelenggaraan Pendidikan.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             7.
                         </td>
                         <td>
                             Keputusan Presiden Republik Indonesia Nomor : 37 tahun 1981 tentang Pendirian UHO.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             8.
                         </td>
                         <td>
                             Peraturan Menteri Pendidikan dan Kebudayaan Nomor 45 Tahun 2019 Tentang : Organisasi dan Tata Kerja Kementerian Pendidikan dan Kebudayaan.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             9.
                         </td>
                         <td>
                             Undang-Undang Nomor 14 Tahun 2005 tentang Guru dan Dosen.Peraturan Menteri Pendidikan dan Kebudayaan Nomor: 7 Tahun 2020 Tentang Pendirian, Perubahan, Pembubaran Perguruan Tinggi Negeri, dan Pendirian, Perubahan, Pencabutan Izin Perguruan Tinggi Swasta.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             10.
                         </td>
                         <td>
                             Peraturan Bersama Menteri Pendidikan Kebudayaan dan Kepala Badan Kepegawaian Negara Nomor : 4/VIII/PB/2014 tentang Jabatan Fungsional Dosen dan Angka Kreditnya.
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             11.
                         </td>
                         <td>
                             Undang-Undang Nomor 14 Tahun 2005 tentang Guru dan Dosen.Peraturan Menteri Pendidikan dan Kebudayaan Nomor: 92 Tahun 2014 tentang Petunjuk Teknis Pelaksanaan Penilaian Angka Kredit Jabatan Fungsional Dosen dan Angka Kreditnya.
                         </td>
                     </tr>



                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             12.
                         </td>
                         <td>
                             Peraturan Menteri Pendidikan dan Kebudayaan Nomor : 43 Tahun 2012 tentang Statuta Universitas Halu Oleo.
                         </td>
                     </tr>



                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             13.
                         </td>
                         <td>
                             Keputusan Menteri Pendidikan Kebudayaan RI Nomor : 149 Tahun 2014 tentang Organisasi Tata Kelola (OTK) Universitas Halu Oleo.
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             14.
                         </td>
                         <td>
                             Keputusan Kemendikbudristek RI Nomor : 43258/MPK.A/KP.07.00/2021 tentang pengangkatan Rektor Universitas Halu Oleo periode 2021-2025.
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:0.5em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             15.
                         </td>
                         <td>
                             Keputusan Rektor Universitas Halu Oleo Nomor : 2333/UN29/2022 tentang Pengangkatan Dekan Fakultas Kehutanan dan Ilmu Lingkungan Universitas Halu Oleo Periode 2022 – 2026.
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:1em; vertical-align: top;">

                         </td>
                         <td style="vertical-align: top;"></td>
                         <td style="vertical-align: top;">
                             16.
                         </td>
                         <td>
                             Peraturan Rektor Universitas Halu Oleo Nomor : 1/UN29/SK/PP/2019 Tanggal 25 Januari 2019 tentang Peraturan Akademik di Lingkungan Universitas Halu Oleo tahun 2019.
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:1em; vertical-align: top;">
                             Memperhatikan
                         </td>
                         <!-- <td style="vertical-align: top;"></td> -->
                         <td style="vertical-align: top;">
                             :
                         </td>
                         <td colspan="2">
                             Surat Tugas Ketua Jurusan Nomor: ????? Tentang Penugasan Ujian <?php echo ucwords($sk->jenis_ujian) ?>.
                         </td>
                     </tr>

                     <tr>
                         <td colspan="4" style="padding-left: 0.1em; padding-right: 5em; padding-bottom:1em; vertical-align: top; text-align: center;">
                             MEMUTUSKAN
                         </td>

                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:1em; vertical-align: top;">
                             Menetapkan
                         </td>
                         <!-- <td style="vertical-align: top;"></td> -->
                         <td style="vertical-align: top;">
                             :
                         </td>
                         <td colspan="2">

                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:1em; vertical-align: top;">
                             Pertama
                         </td>
                         <!-- <td style="vertical-align: top;"></td> -->
                         <td style="vertical-align: top;">
                             :
                         </td>
                         <td colspan="2">
                             Mengangkat mereka yang namanya tersebut dalam lampiran keputusan ini sebagai Panitia Ujian <?php echo ucwords($sk->jenis_ujian) ?> mahasiswa Fakultas Kehutanan dan Ilmu Lingkungan UHO.
                         </td>
                     </tr>

                     <tr>
                         <td style="padding-left: 0.1em; padding-right: 5em; padding-bottom:1em; vertical-align: top;">
                             Kedua
                         </td>
                         <!-- <td style="vertical-align: top;"></td> -->
                         <td style="vertical-align: top;">
                             :
                         </td>
                         <td colspan="2">
                             Keputusan ini mulai berlaku sejak tanggal ditetapkan, dan apabila dikemudian hari ternyata terdapat kekeliruan dalam keputusan ini, akan diadakan perbaikan sebagaimana mestinya
                         </td>
                     </tr>



                 </table>
             </div>

             <br>
             <br>
             <br>
             <table border="" style="font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                 <tbody>
                     <tr>
                         <td rowspan="7" style="padding-right: 2em; vertical-align: bottom;">

                         </td>
                         <td style="padding-left: 30em;">
                             Ditetapkan di &nbsp;&nbsp;&nbsp;&nbsp;: Kendari <br>
                             Pada Tanggal &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;<?php echo indonesiaDate(date('Y-m')) ?><br>
                             <?php if (!empty($sk->plh_plt)) echo $sk->plh_plt; ?> Dekan,
                         </td>
                     </tr>
                     <br><br>

                     <?php
                        $nip_ttd = '';
                        $nama_ttd = '';
                        foreach ($dosen as $keys) {
                            if ($sk->sk_ujian_ttd == $keys->id) {
                                $nama_ttd = $keys->nama_dosen;
                                $nip_ttd = $keys->nip;
                            } elseif ($keys->jabatan_akademik == 'Dekan') {
                                $nama_ttd = $keys->nama_dosen;
                                $nip_ttd = $keys->nip;
                            }
                        }
                        ?>

                     <br><br><br><br><br><br>

                     <tr>
                         <td style="padding-left: 30em;">
                             <?= $nama_ttd ?>
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 30em; ">
                             NIP. <?= $nip_ttd ?>
                         </td>
                     </tr>

                 </tbody>
             </table>

             <br>
             <br>
             <p style="font-style: normal;">Tembusan Yth :</p>
             <p style="font-style: italic;">
                 1. Rektor UHO (sebagai laporan) <br>
                 2. Kepala Biro Adm.Umum dan Keuangan <br>
                 3. Para Dosen Pembimbing<br>
                 4. Ketua Jurusan Kehutanan FHIL </p>

         </section>
         <?php if ($sk->status_putusan == 'verifikasi' or !empty($sk->status_putusan)) { ?>
             <?php $verifikasi = zurl('verifikasi-qrcode/' . $sk->id); ?>
             <?= ZQrcode::get('assets/img/uho.png', $verifikasi, 'M', 3, 2) ?>
         <?php } ?>
     </div>
 </body>

 </html>
