<?php
$mahasiswa = $this->m_default->fetch_data(array('table' => 'mahasiswa', 'where' => array('tbl_user_id' => $this->session->userdata('id')), 'single' => true));

?>
<div class="col-md-4">
    <a href="<?php echo base_url('C_user/change_data_pegawai/') . $mahasiswa->tbl_user_id; ?>">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-danger bubble-shadow-small">
                            <i class="flaticon-user"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers">
                            <!-- <p class="card-category"></p> -->
                            <h4 class="card-title"><?php echo empty($mahasiswa->nim) ?  'Lengkapi Data Diri' : 'Data Profil' ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<?php

$option = array(
    'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
    'table' => 'ujian',
    'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
    'order' => array('ujian.id' => 'desc'),
    'where' => array('mahasiswa.tbl_user_id' => $this->session->userdata('id'), 'ujian.jenis_ujian' => 'proposal'),
    'single' => true
);

$ujian = $this->m_default->fetch_data($option);
if (!empty($ujian) and !empty($ujian->hari_ujian)) {
    $now = time();
    $your_date = strtotime($ujian->hari_ujian);
    $datediff = $now - $your_date;
    $hari = round($datediff / (60 * 60 * 24));

?>


    <div class="col-md-4">
        <a href="<?php echo base_url(); ?>C_ujian">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="flaticon-success"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Rentang Waktu Setelah Proposal</p>
                                <h4 class="card-title"><?= $hari ?> Hari</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php } ?>

<?php
// $mahasiswa = $this->m_default->fetch_data(array('table' => 'mahasiswa', 'where' => array('tbl_user_id' => $this->session->userdata('id')), 'single' => true));
$option = array(
    'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
    'table' => 'ujian',
    'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
    'order' => array('ujian.id' => 'desc'),
    'where' => array('mahasiswa.tbl_user_id' => $this->session->userdata('id'), 'ujian.jenis_ujian' => 'hasil'),
    'single' => true
);

$ujian = $this->m_default->fetch_data($option);
if (!empty($ujian) and !empty($ujian->hari_ujian)) {
    $now = time(); // or your date as well
    $your_date = strtotime($ujian->hari_ujian);
    $datediff = $now - $your_date;
    $hari = round($datediff / (60 * 60 * 24));

?>
    <div class="col-md-4">
        <a href="<?php echo base_url(); ?>C_ujian">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="flaticon-success"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Rentang Waktu Setelah Hasil</p>
                                <h4 class="card-title"><?= $hari ?> Hari</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php } ?>
