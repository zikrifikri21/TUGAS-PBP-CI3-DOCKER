<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Verifikasi Data ujian</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= base_url() ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url($this->uri->segment(1)) ?>">Verifikasi ujian</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Verifikasi ujian</a>
            </li>
        </ul>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Verifikasi Data Ujian</h4>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="card-body card-block">
                    <div class="form-group row">
                        <div class="col col-md-3"><label>Jenis Ujian</label></div>
                        <div class="col col-md-9">
                            <select disabled required class="form-control" name="jenis_ujian">
                                <option value="">.:: Pilih Jenis Ujian ::.</option>
                                <option <?php if ($jenis_ujian == 'proposal') echo 'selected'; ?>>proposal</option>
                                <option <?php if ($jenis_ujian == 'hasil') echo 'selected'; ?>>hasil</option>
                                <option <?php if ($jenis_ujian == 'skripsi') echo 'selected'; ?>>skripsi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Judul</label></div>
                        <div class="col-12 col-md-9">
                            <textarea disabled class="form-control" name="judul" id="" cols="30" rows="4" required="required"><?php echo $judul; ?></textarea>
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">IPK Sementara (cth. 3.60)</label></div>
                        <div class="col-12 col-md-9">
                            <input disabled name="ipk_sementara" placeholder="IPK Sementara" class="form-control" type="text" required="required" value="<?php echo $ipk_sementara; ?>">
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <div class="col col-md-6">
                            <label>Pembimbing 1</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="pembimbing_1" id="pembimbing_1">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if (isset($pembimbing_1) && $pembimbing_1 == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>

                        </div>
                        <div class="col col-md-6">
                            <label>Ketua</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="ketua" id="ketua">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if (isset($ketua) && $ketua == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-6">
                            <label>Pembimbing 2</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="pembimbing_2" id="pembimbing_2">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if (isset($pembimbing_2) && $pembimbing_2 == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>

                        </div>
                        <div class="col col-md-6">
                            <label>Sekretaris</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="sekretaris">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if ($sekretaris == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-6">
                            <label>Penguji 1</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="uji1">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if ($uji1 == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>

                        </div>
                        <div class="col col-md-6">
                            <label>Anggota</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="anggota_1">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if ($anggota_1 == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-6">
                            <label>Penguji 2</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="uji2">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if ($uji2 == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>

                        </div>
                        <div class="col col-md-6">
                            <label>Anggota</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="anggota_2">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if ($anggota_2 == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-6">
                            <label>Penguji 3</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="uji3">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if ($uji3 == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col col-md-6">
                            <label>Anggota</label>
                            <select required class="form-control select2 js-example-basic-single js-states" name="anggota_3">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if ($anggota_3 == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tanggal Ujian</label></div>
                        <div class="col-12 col-md-9">
                            <input name="hari_ujian" placeholder="Tanggal" class="form-control" type="date" required="required" value="<?php echo $hari_ujian; ?>">
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Jam Ujian</label></div>
                        <div class="col-12 col-md-9">
                            <input name="jam_ujian" placeholder="Jam" class="form-control" type="time" required="required" value="<?php echo $jam_ujian; ?>">
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tempat Ujian</label></div>
                        <div class="col-12 col-md-9">
                            <input name="tempat_ujian" placeholder="Tempat" class="form-control" type="text" required="required" value="<?php echo $tempat_ujian; ?>">
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input name="id" class="form-control" type="hidden" value="<?php echo $id; ?>">
                    <input name="mahasiswa_id" class="form-control" type="hidden" value="<?php echo $mahasiswa_id; ?>">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i>Submit
                    </button>
                    <a href="<?php echo site_url('c_verifikasi_ujian') ?>" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Kembali
                    </a>
                </div>
            </form>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    // function checkDuplicate() {
                    //     var pembimbing1 = $('#pembimbing_1').val();
                    //     var pembimbing2 = $('#pembimbing_2').val();
                    //     var ketua = $('#ketua').val();

                    //     if (ketua !== '' && (ketua === pembimbing1 || ketua === pembimbing2)) {
                    //         alert('Ketua tidak boleh sama dengan Pembimbing 1 atau Pembimbing 2.');
                    //         $('#ketua').val('').trigger('change');
                    //     }
                    // }

                    // $('#pembimbing_1').on('change', checkDuplicate);
                    // $('#pembimbing_2').on('change', checkDuplicate);
                    // $('#ketua').on('change', checkDuplicate);

                    function syncPengujiToAnggota(sourceName, targetName) {
                        $('select[name="' + sourceName + '"]').on('change', function() {
                            var nilaiPenguji = $(this).val();
                            var targetSelect = $('select[name="' + targetName + '"]');

                            targetSelect.val(nilaiPenguji);

                            targetSelect.trigger('change');
                        });
                    }

                    syncPengujiToAnggota('uji1', 'anggota_1');
                    syncPengujiToAnggota('uji2', 'anggota_2');
                    syncPengujiToAnggota('uji3', 'anggota_3');
                });
            </script>
        </div>
    </div>
</div>
