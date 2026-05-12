<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Monitoring Data Dosen</h4>
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
                <a href="#">Monitoring Dosen</a>
            </li>
        </ul>
    </div>
    <?php
    if ($this->session->flashdata('input')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-success alert-dismissible fade show', 'Pesan', $this->session->flashdata('input')) ?>
    <?php } else if ($this->session->flashdata('edit')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-warning alert-dismissible fade show', 'Pesan', $this->session->flashdata('edit')) ?>
    <?php } else if ($this->session->flashdata('delete')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Pesan', $this->session->flashdata('delete')) ?>
    <?php } ?>

    <div class="section-body">
        <div class="card">
            <div class="card-header row">
                <div class="col-lg-4">
                    <h4>Monitoring Dosen</h4>
                </div>
            </div>
            <div class="card-body card-block">
                <div class="table-responsive">
                    <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                        <table id="mytable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Nama</th>
                                    <th>Homebase</th>
                                    <th>Status</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($dosen) {
                                    $no = 1;
                                    foreach ($dosen as $key) { ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $key->nama_dosen ?></td>
                                            <td><?php echo $key->nama_jurusan ?></td>
                                            <td><?php echo $key->status ?></td>
                                            <td>
                                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#pembimbing<?php echo $key->id ?>">
                                                    Sebagai Pembimbing
                                                    <?php
                                                    $option = array(
                                                        'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
                                                        'table' => 'ujian',
                                                        'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                        'where' => "(ujian.jenis_ujian = 'proposal' or ujian.jenis_ujian = 'hasil') and ( ujian.pembimbing_1 = '" . $key->id . "' or ujian.pembimbing_2 = '" . $key->id . "')",
                                                        'order' => array('ujian.id' => 'desc'),
                                                        'group' => 'mahasiswa.id'
                                                    );
                                                    $belum = $this->m_default->fetch_data($option);

                                                    $option = array(
                                                        'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
                                                        'table' => 'ujian',
                                                        'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                        'where' => "(ujian.jenis_ujian = 'skripsi') and ( ujian.pembimbing_1 = '" . $key->id . "' or ujian.pembimbing_2 = '" . $key->id . "')",
                                                        'order' => array('ujian.id' => 'desc'),
                                                        'group' => 'mahasiswa.id'
                                                    );
                                                    $selesai = $this->m_default->fetch_data($option);

                                                    $bimbingan_dosen = [];
                                                    foreach ($belum as $bel) {
                                                        foreach ($selesai as $sel) {
                                                            if ($sel->mahasiswa_id != $bel->mahasiswa_id)
                                                                $bimbingan_dosen[] = $bel;
                                                        }
                                                    }
                                                    echo '(' . count($bimbingan_dosen) . ')';
                                                    ?>
                                                </a>
                                                <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#penguji<?php echo $key->id ?>">
                                                    Seabagi Penguji
                                                    <?php
                                                    $option = array(
                                                        'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
                                                        'table' => 'ujian',
                                                        'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                        'where' => "(ujian.jenis_ujian = 'proposal' or ujian.jenis_ujian = 'hasil') and (ujian.uji1 = '" . $key->id . "' or ujian.uji2 = '" . $key->id . "' or ujian.uji3 = '" . $key->id . "')",
                                                        'order' => array('ujian.id' => 'desc'),
                                                        'group' => 'mahasiswa.id'
                                                    );

                                                    $belum = $this->m_default->fetch_data($option);

                                                    $option = array(
                                                        'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
                                                        'table' => 'ujian',
                                                        'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                        'where' => "(ujian.jenis_ujian = 'skripsi') and (ujian.uji1 = '" . $key->id . "' or ujian.uji2 = '" . $key->id . "' or ujian.uji3 = '" . $key->id . "')",
                                                        'order' => array('ujian.id' => 'desc'),
                                                        'group' => 'mahasiswa.id'
                                                    );

                                                    $selesai = $this->m_default->fetch_data($option);

                                                    $penguji_dosen = [];
                                                    foreach ($belum as $bel) {
                                                        foreach ($selesai as $sel) {
                                                            if ($sel->mahasiswa_id != $bel->mahasiswa_id)
                                                                $penguji_dosen[] = $bel;
                                                        }
                                                    }

                                                    echo '(' . count($penguji_dosen) . ')';
                                                    ?>
                                                </a>

                                            </td>
                                        </tr>

                                        <div class="modal fade" id="pembimbing<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">List Bimbingan</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-1" style="font-weight: bold;">No.</div>
                                                            <!-- <div class="col-md-3" style="font-weight: bold;">Jenis Ujian</div> -->
                                                            <div class="col-md-4" style="font-weight: bold;">Nama Mahasiswa</div>
                                                            <div class="col-md-7" style="font-weight: bold;">Judul</div>
                                                            <?php if ($bimbingan_dosen) {
                                                                $no = 1;
                                                                foreach ($bimbingan_dosen as $bim) {
                                                            ?>
                                                                    <div class="col-md-1"><?= $no; ?></div>
                                                                    <!-- <div class="col-md-3"><?= strtoupper($bim->jenis_ujian) ?></div> -->
                                                                    <div class="col-md-4"><?= $bim->nama_mahasiswa ?></div>
                                                                    <div class="col-md-7"><?= $bim->judul ?></div>
                                                                    <!-- <div class="col-md-4"><?= indonesiaDate($bim->hari_ujian) . ' ' . $bim->jam_ujian; ?></div> -->
                                                            <?php $no++;
                                                                }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="penguji<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">List Penguji</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-1" style="font-weight: bold;">No.</div>
                                                            <!-- <div class="col-md-3" style="font-weight: bold;">Jenis Ujian</div> -->
                                                            <div class="col-md-4" style="font-weight: bold;">Nama Mahasiswa</div>
                                                            <!-- <div class="col-md-4" style="font-weight: bold;">Waktu Ujian</div><br> -->
                                                            <div class="col-md-7" style="font-weight: bold;">Judul</div><br>
                                                            <?php if ($penguji_dosen) {
                                                                $no = 1;
                                                                foreach ($penguji_dosen as $bim) {
                                                            ?>
                                                                    <div class="col-md-1"><?= $no; ?></div>
                                                                    <!-- <div class="col-md-3"><?= strtoupper($bim->jenis_ujian) ?></div> -->
                                                                    <div class="col-md-4"><?= $bim->nama_mahasiswa ?></div>
                                                                    <div class="col-md-7"><?= $bim->judul ?></div>
                                                                    <!-- <div class="col-md-4"><?= indonesiaDate($bim->hari_ujian) . ' ' . $bim->jam_ujian; ?></div> -->
                                                            <?php $no++;
                                                                }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- End Looping -->


                                <?php $no++;
                                    }
                                } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#mytable').DataTable({
            "lengthChange": true,
            "searching": true,
        });
    });
</script>