<?php $authNamaLevel = auth()['nama_level'];  ?>
<div class="modal fade" id="st<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Draft Surat Tugas</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <?php echo form_open_multipart("C_verifikasi_ujian/upload_file", ['id' => 'form-st-' . $key->id]) ?>
            <div class="modal-body">
                <?php if ($authNamaLevel === 'Staf Jurusan') { ?>
                    <div class="bg-info p-2 rounded-top">
                        <p class="text-white text-center">"Pastikan Anda sudah mengisi Data Ujian"</p>
                    </div>
                <?php } ?>
                <embed src="<?php echo base_url() . 'C_draft/st/' . $key->id ?>" frameborder="0" width="100%" height="600px">
                <?php if (auth('nama_level') == 'Staf Jurusan' && uri_string() !== 'C_ujian/monitoring') { ?>
                    <div class="form-group">
                        <label for="form-no-surat-st-<?= $key->id ?>" class="form-control-label">Nomor Surat</label>
                        <input type="text" class="form-control" name="no_st" required value="<?php echo $key->no_st ?>" id="form-no-surat-st-<?= $key->id ?>">
                        <input type="hidden" class="form-control" name="id" value="<?php echo $key->id ?>">
                    </div>
                    <div class="form-group ">
                        <label>PLH/PLT (optional)</label>
                        <select class="form-control" name="plh_plt_st">
                            <option value="">.:: Pilih ::.</option>
                            <option <?php if ($key->plh_plt_st == 'PLH') echo 'selected'; ?>>PLH</option>
                            <option <?php if ($key->plh_plt_st == 'PLT') echo 'selected'; ?>>PLT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="text-input" class=" form-control-label">Yang Bertanda Tangan (optional jika plh/plt)</label><br>
                        <select class="form-control select2 js-example-basic-single js-states" style="width: 100%;" name="ttd_st">
                            <option value="">.:: Pilih Dosen ::.</option>
                            <?php foreach ($dosen as $keys) {
                                if ($key->ttd_st == $keys->id) {
                            ?>
                                    <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                    </div>
                <?php } ?>
            </div>
            <?php if (auth('nama_level') == 'Staf Jurusan' && uri_string() !== 'C_ujian/monitoring') { ?>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btn-kirim-st-<?= $key->id ?>" type="submit">
                        <?= ($key->status_putusan === 'terkirim' && !empty($key->no_st)) ? 'Perbarui dan Kirim ke Prodi' : 'Kirim ke Prodi'; ?>
                    </button>
                    <script>
                        $(document).ready(function() {
                            $('#btn-kirim-st-<?= $key->id ?>').prop('disabled', true);
                            $('#form-no-surat-st-<?= $key->id ?>').on('input', function() {
                                if ($(this).val() != '') {
                                    $('#btn-kirim-st-<?= $key->id ?>').prop('disabled', false);
                                } else {
                                    $('#btn-kirim-st-<?= $key->id ?>').prop('disabled', true);
                                }
                            });
                        })
                    </script>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                </div>
            <?php } ?>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
