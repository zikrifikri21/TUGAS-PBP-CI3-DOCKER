<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tambah SK Dekan</h4>
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
                <a href="<?php echo base_url($this->uri->segment(1) . '/ujian') ?>">Manajemen SK</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tambah SK Ujian</a>
            </li>
        </ul>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Input SK Ujian</h4>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nomor Surat</label></div>
                        <div class="col-12 col-md-9">
                            <input name="no_sk" placeholder="Nomor Surat" class="form-control" type="text" required="required" value="<?php echo $no_sk; ?>">
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tanggal SK</label></div>
                        <div class="col-12 col-md-9">
                            <input name="tgl_sk" placeholder="IPK Sementara" class="form-control" type="date" required="required" value="<?php echo $tgl_sk; ?>">
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-3"><label>PLH/PLT (optional)</label></div>
                        <div class="col col-md-9">
                            <select class="form-control" name="plh_plt">
                                <option value="">.:: Pilih ::.</option>
                                <option <?php if ($plh_plt == 'PLH') echo 'selected'; ?>>PLH</option>
                                <option <?php if ($plh_plt == 'PLT') echo 'selected'; ?>>PLT</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Yang Bertanda Tangan<br> (optional jika plh/plt)</label></div>
                        <div class="col-12 col-md-9">
                            <select class="form-control select2 js-example-basic-single js-states" style="width: 100%;" name="sk_ujian_ttd">
                                <option value="">.:: Pilih Dosen ::.</option>
                                <?php foreach ($dosen as $keys) {
                                    if ($sk_ujian_ttd == $keys->id) {
                                ?>
                                        <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen . ' - ' . $keys->jabatan_akademik ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen . ' - ' . $keys->jabatan_akademik ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>



                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label>Mahsasiswa</label>
                        </div>
                        <div class="col col-md-9">
                            <div class="mb-2">
                                <button type="button" id="select_all" class="btn btn-sm btn-primary">
                                    Pilih semua
                                </button>
                                <button type="button" id="unselect_all" class="btn btn-sm btn-secondary">
                                    Hapus semua
                                </button>
                            </div>

                            <select required class="form-control select2" multiple name="ujian_id[]" id="ujian_id">
                                <?php foreach ($ujian as $keys): ?>
                                    <option value="<?= $keys->id ?>"
                                        <?= !empty($ujian_id) && in_array($keys->id, array_column($ujian_id, 'ujian_id')) ? 'selected' : '' ?>>
                                        <?= $keys->nama_mahasiswa . ' - ' . $keys->jenis_ujian ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <input name="id" class="form-control" type="hidden" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i>Submit
                    </button>
                    <a href="<?php echo site_url('C_sk_dekan/ujian') ?>" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#select_all').on('click', function() {
        let allValues = [];

        $('#ujian_id option').each(function() {
            allValues.push($(this).val());
        });

        $('#ujian_id').val(allValues).trigger('change');
    });

    $('#unselect_all').on('click', function() {
        $('#ujian_id').val(null).trigger('change');
    });
</script>
