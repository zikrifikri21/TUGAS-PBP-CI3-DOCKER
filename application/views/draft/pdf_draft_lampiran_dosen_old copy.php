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
             <!-- <br> -->
             <!-- <center>
                 <img style="margin-top: -70px" src="<?php echo base_url("./upload/kop/fakultas.png"); ?>" alt="" height="613px" width="2480px">
             </center> -->
             <h3 style="text-align:center;">
                 LAMPIRAN SURAT KEPUTUSAN DEKAN FAKULTAS KEHUTANAN DAN ILMU LINGKUNGAN UNIVERSITAS HALU OLEO
             </h3>



             <table style="border:1px; font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                 <tr>
                     <td style="padding-left: 0.1em; padding-right:3em; padding-bottom:0.5em; vertical-align: top;">
                         Nomor
                     </td>
                     <td style="vertical-align: top;">:</td>
                     <td>
                         <?= $sk->no_sk ?>
                     </td>
                 </tr>
                 <tr>
                     <td style="padding-left: 0.1em; padding-right:3em; padding-bottom:0.5em; vertical-align: top;">
                         Tanggal
                     </td>
                     <td style="vertical-align: top;">:</td>
                     <td>
                         <?= indonesiaDate($sk->tgl_sk) ?>
                     </td>
                 </tr>
                 <tr>
                     <td style="padding-left: 0.1em; padding-right:3em; padding-bottom:0.5em; vertical-align: top;">
                         Tentang
                     </td>
                     <td style="vertical-align: top;">:</td>
                     <td>
                         Pengangkatan Dosen Pembimbing <?= ucwords($sk->jenis_ujian) ?> Penelitian Mahasiswa Fakultas Kehutanan dan Ilmu Lingkungan UHO
                     </td>
                 </tr>

             </table>
             <br><br>
             <table border="1" style="width:100%; font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                 <tr>
                     <td style="width: 25px;">No.</td>
                     <td style="text-align: center;width: 13em;">Nama Mahasiswa/NIM</td>
                     <td style="text-align: center;width: 11em;">Jurusan</td>
                     <td style="text-align: center; width: 25em;">Dosen Pembimbing</td>
                     <td style="text-align: center;">Judul Skripsi</td>
                 </tr>
                 <tr>
                     <td style="vertical-align: top;">1.</td>
                     <td style="vertical-align: top;"><?= $sk->nama_mahasiswa . '<br>' . $sk->nim ?></td>
                     <td style="vertical-align: top;"><?= $sk->nama_jurusan ?></td>
                     <td style="vertical-align: top;">
                         1.
                         <?php foreach ($dosen as $keys) {
                                if ($sk->pembimbing_1 == $keys->id)
                                    echo $keys->nama_dosen;
                            }
                            ?>
                         <br>
                         2.
                         <?php foreach ($dosen as $keys) {
                                if ($sk->pembimbing_2 == $keys->id)
                                    echo $keys->nama_dosen;
                            }
                            ?>
                         <br>
                     </td>
                     <td style="vertical-align: top;"><?= $sk->judul ?></td>
                 </tr>
             </table>

             <br>
             <br>
             <table border="" style="font-family: Arial; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height:1;">
                 <tbody>
                     <tr>
                         <td style="padding-left: 65em;">
                             Ditetapkan di &nbsp;&nbsp;&nbsp;&nbsp;: Kendari <br>
                             Pada Tanggal &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo indonesiaDate($sk->tgl_sk) ?><br>
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
                         <td style="padding-left: 65em;">
                             <?= $nama_ttd ?>
                         </td>
                     </tr>
                     <tr>
                         <td style="padding-left: 65em; ">
                             NIP. <?= $nip_ttd ?>
                         </td>
                     </tr>

                 </tbody>
             </table>

         </section>
     </div>
 </body>

 </html>
