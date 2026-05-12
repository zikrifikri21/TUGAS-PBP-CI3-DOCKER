  <div class="panel-header bg-primary-gradient">
      <div class="page-inner py-2">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
              <div>
                  <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                  <h5 class="text-white op-7 mb-2">Bpk/Ibu/Sdr(i) <?php echo $this->session->userdata('nama_pengguna') ?> Selamat Datang</h5>
              </div>
              <!-- <div class="ml-md-auto py-2 py-md-0">
                      <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
                      <a href="#" class="btn btn-secondary btn-round">Add Customer</a>
                  </div> -->
          </div>
      </div>
  </div>
  <div class="page-inner">
      <?php
        if ($this->session->flashdata('input')) { ?>
          <?php echo alert('sufee-alert alert with-close alert-success alert-dismissible fade show', 'Pesan', $this->session->flashdata('input')) ?>
      <?php } else if ($this->session->flashdata('edit')) { ?>
          <?php echo alert('sufee-alert alert with-close alert-warning alert-dismissible fade show', 'Pesan', $this->session->flashdata('edit')) ?>
      <?php } else if ($this->session->flashdata('delete')) { ?>
          <?php echo alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Pesan', $this->session->flashdata('delete')) ?>
      <?php } ?>
      <div class="row">
          <?php if ($this->session->userdata('tbl_user_level_id') == 1) : ?>
              <?php
                echo " ";
                ?>
          <?php elseif ($this->session->userdata('tbl_user_level_id') == 2 or $this->session->userdata('tbl_user_level_id') == 3) : ?>
              <?php
                $auth = $this->session->userdata();
                $mahasiswa = Mahasiswa::table()->when(!empty($auth['jurusan_id']), function ($query) use ($auth) {
                    $query->where(['jurusan_id' => $auth['jurusan_id']]);
                })->get();
                $dosen = DosenFhil::table()->when(!empty($auth['jurusan_id']), function ($query) use ($auth) {
                    $query->where(['homebase' => $auth['jurusan_id']]);
                })->get();
                ?>
              <div class="col-md-4">
                  <a href="<?php echo base_url('C_mahasiswa'); ?>">
                      <div class="card card-stats card-round">
                          <div class="card-body ">
                              <div class="row align-items-center">
                                  <div class="col-icon">
                                      <div class="icon-big text-center icon-primary bubble-shadow-small">
                                          <i class="flaticon-users"></i>
                                      </div>
                                  </div>
                                  <div class="col col-stats ml-3 ml-sm-0">
                                      <div class="numbers">
                                          <p class="card-category">Total Mahasiswa</p>
                                          <h4 class="card-title">
                                              <?= count($mahasiswa); ?>
                                          </h4>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </a>
              </div>

              <div class="col-md-4">
                  <a href="<?php echo base_url('C_dosen'); ?>">
                      <div class="card card-stats card-round">
                          <div class="card-body ">
                              <div class="row align-items-center">
                                  <div class="col-icon">
                                      <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                          <i class="flaticon-users"></i>
                                      </div>
                                  </div>
                                  <div class="col col-stats ml-3 ml-sm-0">
                                      <div class="numbers">
                                          <p class="card-category">Total Dosen</p>
                                          <h4 class="card-title">
                                              <?= count($dosen); ?>
                                          </h4>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </a>
              </div>
              <?php if ($this->session->userdata('tbl_user_level_id') == '2') : ?>
                  <div class="col-md-4">
                      <a href="<?php echo base_url('C_verifikasi_ujian/filter?jenis_ujian=proposal'); ?>">
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
                                              <p class="card-category">Total Pengajuan Proposal</p>
                                              <h4 class="card-title"><?php
                                                                        $option = array(
                                                                            'table' => 'ujian',
                                                                            'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                                            'where' => array('ujian.jenis_ujian' => 'proposal')
                                                                        );
                                                                        if ($this->session->userdata('tbl_user_level_id') == 2) {
                                                                            $option['where'] = array('ujian.jenis_ujian' => 'proposal', 'mahasiswa.jurusan_id' => $this->session->userdata('jurusan_id'));
                                                                        }

                                                                        echo count($this->m_default->fetch_data($option));
                                                                        ?></h4>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
                  <div class="col-md-4">
                      <a href="<?php echo base_url('C_verifikasi_ujian/filter?jenis_ujian=hasil'); ?>">
                          <div class="card card-stats card-round">
                              <div class="card-body">
                                  <div class="row align-items-center">
                                      <div class="col-icon">
                                          <div class="icon-big text-center icon-warning bubble-shadow-small">
                                              <i class="flaticon-success"></i>
                                          </div>
                                      </div>
                                      <div class="col col-stats ml-3 ml-sm-0">
                                          <div class="numbers">
                                              <p class="card-category">Total Pengajuan Hasil</p>
                                              <h4 class="card-title"><?php
                                                                        $option = array(
                                                                            'table' => 'ujian',
                                                                            'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                                            'where' => array('ujian.jenis_ujian' => 'hasil')
                                                                        );
                                                                        if ($this->session->userdata('tbl_user_level_id') == 2) {
                                                                            $option['where'] = array('ujian.jenis_ujian' => 'hasil', 'mahasiswa.jurusan_id' => $this->session->userdata('jurusan_id'));
                                                                        }
                                                                        echo count($this->m_default->fetch_data($option));
                                                                        ?></h4>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
              <?php endif; ?>
              <div class="col-md-4">
                  <a href="<?php if ($this->session->userdata('tbl_user_level_id') == '2')
                                echo base_url('C_verifikasi_ujian/filter?jenis_ujian=skripsi');
                            else echo base_url('C_ujian/monitoring') ?>">
                      <div class="card card-stats card-round">
                          <div class="card-body">
                              <div class="row align-items-center">
                                  <div class="col-icon">
                                      <div class="icon-big text-center icon-danger bubble-shadow-small">
                                          <i class="flaticon-success"></i>
                                      </div>
                                  </div>
                                  <div class="col col-stats ml-3 ml-sm-0">
                                      <div class="numbers">
                                          <p class="card-category">Total Pengajuan <?php auth('tbl_user_level_id') == 2 ? 'Skripsi' : 'Ujian'; ?></p>
                                          <h4 class="card-title"><?php
                                                                    $option = array(
                                                                        'table' => 'ujian',
                                                                        'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                                        'where' => array('ujian.jenis_ujian' => 'skripsi')
                                                                    );
                                                                    if ($this->session->userdata('tbl_user_level_id') == 2) {
                                                                        $option['where'] = array('ujian.jenis_ujian' => 'skripsi', 'mahasiswa.jurusan_id' => $this->session->userdata('jurusan_id'));
                                                                    }
                                                                    echo count($this->m_default->fetch_data($option));
                                                                    ?></h4>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </a>
              </div>
              <div class="col-md-4">
                  <?php
                    $stafAkademik   = 3;
                    $stafJurusan    = 2;
                    $isStafAkademik = auth('tbl_user_level_id') == $stafAkademik;
                    ?>
                  <a href="<?= base_url($isStafAkademik ? 'C_sk_dekan/ujian' : 'C_verifikasi_ujian') ?>">
                      <div class="card card-stats card-round">
                          <div class="card-body">
                              <div class="row align-items-center">
                                  <div class="col-icon">
                                      <div class="icon-big text-center icon-info bubble-shadow-small">
                                          <i class="flaticon-file"></i>
                                      </div>
                                  </div>
                                  <div class="col col-stats ml-3 ml-sm-0">
                                      <div class="numbers">
                                          <p class="card-category">
                                              <?= $isStafAkademik ? 'Menunggu SK Dekan' : 'Ujian Belum Selesai'; ?>
                                          </p>
                                          <h4 class="card-title">
                                              <?php
                                                $isAkhiriUjian = $isStafAkademik ? 1 : 0;
                                                $dataUjian     = Ujian::table();
                                                $dataUjian     = $dataUjian->where(['akhiri_ujian' => $isAkhiriUjian])->get() ?? [];
                                                ?>
                                              <?= count($dataUjian); ?>
                                          </h4>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </a>
              </div>
              <!-- <div class="col-md-4">
                  <a href="<?php echo base_url(); ?>C_monitoring_rapat">
                      <div class="card card-stats card-round">
                          <div class="card-body">
                              <div class="row align-items-center">
                                  <div class="col-icon">
                                      <div class="icon-big text-center icon-success bubble-shadow-small">
                                          <i class="flaticon-graph"></i>
                                      </div>
                                  </div>
                                  <div class="col col-stats ml-3 ml-sm-0">
                                      <div class="numbers">
                                          <p class="card-category">Sales</p>
                                          <h4 class="card-title">$ 1,345</h4>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </a>
              </div>
               -->

          <?php elseif ($this->session->userdata('tbl_user_level_id') == 4) : ?>
              <div class="col-md-4">
                  <div class="card card-stats card-round">
                      <div class="card-body">
                          <div class="row align-items-center">
                              <div class="col-icon">
                                  <div class="icon-big text-center icon-warning bubble-shadow-small">
                                      <i class="flaticon-success"></i>
                                  </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                  <div class="numbers">
                                      <p class="card-category">Total Membimbing</p>
                                      <h4 class="card-title">
                                          <?php
                                            $dosen = $this->m_default->fetch_data(array(
                                                'table' => 'dosen',
                                                'where' => array('tbl_user_id' => $this->session->userdata('id')),
                                                'single' => true
                                            ));

                                            if (!$dosen) {
                                                echo 0;
                                            } else {
                                                $option = array(
                                                    'table' => 'ujian',
                                                    'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                    'where' => "(ujian.jenis_ujian = 'proposal' or ujian.jenis_ujian = 'hasil')
                                                        and (ujian.pembimbing_1 = '$dosen->id' or ujian.pembimbing_2 = '$dosen->id')",
                                                    'group' => 'mahasiswa.id'
                                                );

                                                $belum = $this->m_default->fetch_data($option) ?? [];

                                                $option['where'] = "(ujian.jenis_ujian = 'skripsi')
                                                    and (ujian.pembimbing_1 = '$dosen->id' or ujian.pembimbing_2 = '$dosen->id')";

                                                $selesai = $this->m_default->fetch_data($option) ?? [];

                                                $selisih = [];
                                                foreach ($belum as $bel) {
                                                    $found = false;
                                                    foreach ($selesai as $sel) {
                                                        if ($sel->mahasiswa_id == $bel->mahasiswa_id) {
                                                            $found = true;
                                                            break;
                                                        }
                                                    }
                                                    if (!$found) $selisih[] = $bel;
                                                }

                                                echo count($selisih);
                                            }
                                            ?>

                                      </h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="card card-stats card-round">
                      <div class="card-body">
                          <div class="row align-items-center">
                              <div class="col-icon">
                                  <div class="icon-big text-center icon-danger bubble-shadow-small">
                                      <i class="flaticon-success"></i>
                                  </div>
                              </div>
                              <div class="col col-stats ml-3 ml-sm-0">
                                  <div class="numbers">
                                      <p class="card-category">Total Menguji</p>
                                      <h4 class="card-title">
                                          <?php
                                            $dosen = $this->m_default->fetch_data(array(
                                                'table' => 'dosen',
                                                'where' => array('tbl_user_id' => $this->session->userdata('id')),
                                                'single' => true
                                            ));

                                            if (!$dosen) {
                                                echo 0;
                                            } else {
                                                $option = array(
                                                    'table' => 'ujian',
                                                    'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                    'where' => "(ujian.jenis_ujian = 'proposal' or ujian.jenis_ujian = 'hasil')
                                                        and (ujian.uji1 = '$dosen->id' or ujian.uji2 = '$dosen->id' or ujian.uji3 = '$dosen->id')",
                                                    'group' => 'mahasiswa.id'
                                                );

                                                $belum = $this->m_default->fetch_data($option) ?? [];

                                                $option['where'] = "(ujian.jenis_ujian = 'skripsi')
                                                    and (ujian.uji1 = '$dosen->id' or ujian.uji2 = '$dosen->id' or ujian.uji3 = '$dosen->id')";

                                                $selesai = $this->m_default->fetch_data($option) ?? [];

                                                $selisih = [];
                                                foreach ($belum as $bel) {
                                                    $found = false;
                                                    foreach ($selesai as $sel) {
                                                        if ($sel->mahasiswa_id == $bel->mahasiswa_id) {
                                                            $found = true;
                                                            break;
                                                        }
                                                    }
                                                    if (!$found) $selisih[] = $bel;
                                                }

                                                echo count($selisih);
                                            }
                                            ?>

                                      </h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-md-4">
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
                                      <p class="card-category">Total Selesai Ujian</p>
                                      <h4 class="card-title">
                                          <?php
                                            $dosen = $this->m_default->fetch_data(array(
                                                'table' => 'dosen',
                                                'where' => array('tbl_user_id' => $this->session->userdata('id')),
                                                'single' => true
                                            ));

                                            if (!$dosen) {
                                                echo 0;
                                            } else {
                                                $option = array(
                                                    'table' => 'ujian',
                                                    'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                                                    'where' => "ujian.jenis_ujian = 'skripsi'
                                                        and ujian.hari_ujian < '" . date('Y-m-d') . "'
                                                        and (ujian.pembimbing_1 = '$dosen->id'
                                                            or ujian.pembimbing_2 = '$dosen->id'
                                                            or ujian.uji1 = '$dosen->id'
                                                            or ujian.uji2 = '$dosen->id'
                                                            or ujian.uji3 = '$dosen->id')"
                                                );

                                                $hasil = $this->m_default->fetch_data($option) ?? [];
                                                echo count($hasil);
                                            }
                                            ?>

                                      </h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

          <?php elseif ($this->session->userdata('tbl_user_level_id') == 5) : ?>
              <?php include __DIR__ . '/dashboard_mhs.php' ?>
          <?php else : ?>
              <?= " "; ?>
          <?php endif ?>
      </div>
  </div>
