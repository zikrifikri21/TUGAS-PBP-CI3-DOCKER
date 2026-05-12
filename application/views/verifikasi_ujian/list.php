<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data ujian</h4>
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
                <a href="#">Manajemen ujian</a>
            </li>
        </ul>
    </div>
    <?php
    if ($this->session->flashdata('input')) { ?>
        <?= alert('sufee-alert alert with-close alert-success alert-dismissible fade show', 'Pesan', $this->session->flashdata('input')) ?>
    <?php } else if ($this->session->flashdata('edit')) { ?>
        <?= alert('sufee-alert alert with-close alert-warning alert-dismissible fade show', 'Pesan', $this->session->flashdata('edit')) ?>
    <?php } else if ($this->session->flashdata('delete')) { ?>
        <?= alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Pesan', $this->session->flashdata('delete')) ?>
    <?php } ?>
    <?php if (validation_error('id')) { ?>
        <?= alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Pesan', validation_error('id')) ?>
    <?php } else { ?>
        <?= validation_errors(); ?>
    <?php } ?>

    <div class="section-body">
        <div class="card">
            <div class="card-header row">
                <div class="col-lg-4">
                    <h4>Data ujian</h4>
                </div>
                <div class="col-lg-8">
                    <a style="margin-right: 10px;" href="#" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#tambah">
                        <i class="fa fa-wpforms" aria-hidden="true"></i> Filter Data
                    </a>

                    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Ujian</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <?= form_open("C_verifikasi_ujian/filter", array('method' => 'get')) ?>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label>Jenis Ujian</label>
                                        <select required class="form-control" name="jenis_ujian">
                                            <option value="">.:: Pilih Jenis Ujian ::.</option>
                                            <option>proposal</option>
                                            <option>hasil</option>
                                            <option>skripsi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <?= form_close(); ?>
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body card-block">
                <div class="table-responsive">
                    <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                        <table id="mytable" class="table table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Mahasiswa</th>
                                    <th>Jenis Ujian</th>
                                    <th>Penilaian</th>
                                    <th>Judul</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th width="20%">Aksi</th>
                                    <th width="20%">Surat Draft</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($ujian) {
                                    $no = 1;
                                    foreach ($ujian as $key) { ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td>
                                                <?= $key->mahasiswa->nama_mahasiswa ?>
                                                <?= $key->mahasiswa->nim ?>
                                            </td>
                                            <td><?= $key->jenis_ujian ?></td>
                                            <td>
                                                <?php
                                                if (!empty($key->penilaian)) {
                                                    $sum = 0;
                                                    $count = 0;
                                                    foreach ($key->penilaian as $value) {
                                                        $count++;
                                                        $sum += (int)$value->nilai;
                                                    }
                                                    $total = ($count > 0) ? $sum / $count : 0;

                                                    if ($total >= 81) {
                                                        $badge = '<span class="badge badge-success">Lulus - Grade A</span>';
                                                    } elseif ($total >= 61) {
                                                        $badge = '<span class="badge badge-info">Lulus - Grade B</span>';
                                                    } else {
                                                        $badge = '<span class="badge badge-danger">Tidak Lulus</span>';
                                                    }
                                                    echo $badge;
                                                    echo '<div class="mt-1 small text-muted">';
                                                    echo '<i class="fa fa-star"></i> ' . number_format($total, 1) . ' | ';
                                                    echo '<i class="fa fa-users"></i> ' . $count;
                                                    echo '</div>';
                                                } else {
                                                    echo '<span class="badge badge-secondary">Belum Diinput</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?= $key->judul ?></td>
                                            <td><?= $key->jurusan->nama_jurusan ?></td>
                                            <td class="text-capitalize text-center">
                                                <span class="badge p-1 px-2 badge-<?= $key->status_putusan == '' ? 'danger' : 'success' ?> mb-1" data-toggle="tooltip" data-placement="top" title="Status pengajuan dokumen ujian">
                                                    <?= $key->status_putusan ? $key->status_putusan : 'Belum Verifikasi' ?>
                                                </span>
                                                <span class="badge p-1 px-2 badge-<?= $key->status_putusan == 0 ? 'danger' : 'success' ?>"
                                                    data-toggle="tooltip" data-placement="top" title="Status Berjalannya Ujian">
                                                    <?= $key->akhiri_ujian == 1 ? 'Selesai' : 'Belum Selesai' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group mb-1" role="group" aria-label="Basic example">
                                                    <?php if (auth('nama_level') == 'Staf Jurusan') { ?>
                                                        <a href="<?= site_url('C_verifikasi_ujian/update/' . $key->id) ?>" class="btn btn-danger btn-sm">
                                                            Data Ujian
                                                        </a>
                                                    <?php } ?>
                                                    <a href="<?= site_url('C_bukti_dukung/id/' . $key->id) ?>" class="btn btn-success btn-sm">
                                                        Bukti Dukung
                                                    </a>
                                                </div>
                                                <div class="btn-group mb-1" role="group" aria-label="Basic example">
                                                    <?php if ($key->status_putusan == 'verifikasi' && auth('nama_level') == 'Staf Jurusan') { ?>
                                                        <button data-toggle="tooltip" data-placement="top" title="Masukkan nilai ujian mahasiswa dari berita acara." class="btn btn-secondary btn-sm">
                                                            <span data-toggle="modal" data-target="#nilai-ujian"
                                                                data-id="<?= $key->id ?>"
                                                                data-ujian="<?= htmlspecialchars(json_encode($key, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>">
                                                                Masukkan nilai
                                                            </span>
                                                        </button>
                                                    <?php } ?>
                                                    <?php if ($key->penilaian && $key->akhiri_ujian == 0) { ?>
                                                        <button data-toggle="modal" data-target="#su-<?= $key->id ?>" class="btn btn-info btn-sm">
                                                            Selesaikan Ujain
                                                        </button>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (auth('nama_level') == 'Staf Jurusan') { ?>
                                                    <button data-toggle="modal" data-target="#sp<?= $key->id ?>" class="btn btn-info btn-sm">
                                                        Surat Penunjukkan Pembimbing
                                                    </button>
                                                <?php } else { ?>
                                                    <?php if ($key->no_sp) { ?>
                                                        <button data-toggle="modal" data-target="#sp<?= $key->id ?>" class="btn btn-info btn-sm">
                                                            Surat Penunjukkan Pembimbing
                                                        </button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-danger btn-sm">
                                                            No. Surat belum dibuat
                                                        </button>
                                                    <?php } ?>
                                                <?php } ?>

                                                <?php if (auth('nama_level') == 'Staf Jurusan') { ?>
                                                    <button data-toggle="modal" data-target="#st<?= $key->id ?>" class="btn btn-secondary btn-sm">
                                                        Surat Tugas Ujian
                                                    </button>
                                                <?php } else { ?>
                                                    <?php if ($key->no_st) { ?>
                                                        <button data-toggle="modal" data-target="#st<?= $key->id ?>" class="btn btn-secondary btn-sm">
                                                            Surat Tugas Ujian
                                                        </button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-danger btn-sm">
                                                            No. Surat belum dibuat
                                                        </button>
                                                    <?php } ?>
                                                <?php } ?>

                                                <button data-toggle="modal" data-target="#ba<?= $key->id ?>" class="btn btn-primary btn-sm">
                                                    Berita acara
                                                </button>
                                                <?php
                                                $wd = User::table()->with('dosen')->where(['id' => auth('id')])->first();
                                                $isKajur = false;
                                                if ($wd && $wd->dosen) {
                                                    $isKajur = $wd->dosen->jabatan_akademik === 'kajur';
                                                } ?>
                                                <?php if ($isKajur && $key->status_putusan == 'terkirim') { ?>
                                                    <button data-toggle="modal" data-target="#setujui"
                                                        data-id="<?= $key->id ?>"
                                                        class="btn btn-success btn-sm">
                                                        Setujui
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php include 'modal-ba.php' ?>
                                        <?php include 'modal-st.php' ?>
                                        <?php include 'modal-sp.php' ?>
                                        <?php include 'modal-su.php' ?>
                                <?php $no++;
                                    }
                                } ?>
                            </tbody>
                        </table>
                        <?php include 'modal-setuju.php' ?>
                        <?php include 'modal-nilai.php' ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#mytable').DataTable({
            "lengthChange": true,
            "searching": true,
        });
    });
</script>