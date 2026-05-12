<?php $authNamaLevel = auth()['nama_level']; ?>
<div class="modal fade" id="sp<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Draft Surat Penunjukan Pembimbing</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <?php echo form_open_multipart("C_verifikasi_ujian/upload_file") ?>
            <div class="modal-body">
                <?php if ($authNamaLevel === 'Staf Jurusan') { ?>
                    <div class="bg-info p-2 rounded-top">
                        <p class="text-white text-center">"Pastikan Anda sudah mengisi Data Ujian"</p>
                    </div>
                <?php } ?>
                <embed src="<?php echo base_url() . 'C_draft/sp/' . $key->id ?>" frameborder="0" width="100%" height="600px">
                <?php if (
                    $authNamaLevel === 'Staf Jurusan' &&
                    uri_string() !== 'C_ujian/monitoring'
                ) { ?>
                    <div class="form-group">
                        <label for="text-input" class=" form-control-label">Nomor Surat</label>
                        <input type="text" class="form-control" name="no_sp" required value="<?php echo $key->no_sp ?>" id="form-no-surat-sp-<?= $key->id ?>">
                        <input type="hidden" class="form-control" name="id" value="<?php echo $key->id ?>">
                    </div>
                    <div class="form-group ">
                        <label>PLH/PLT (optional)</label>
                        <select id="plh-plt-<?= $key->id ?>" class="form-control" name="plh_plt_sp">
                            <option value="">.:: Pilih ::.</option>
                            <option value="PLH" <?php if ($key->plh_plt_sp == 'PLH') echo 'selected'; ?>>PLH</option>
                            <option value="PLT" <?php if ($key->plh_plt_sp == 'PLT') echo 'selected'; ?>>PLT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="text-input" class=" form-control-label">Yang Bertanda Tangan (optional jika plh/plt)</label><br>
                        <select id="ttd-sp" class="form-control select2 js-example-basic-single js-states" style="width: 100%;" name="ttd_sp">
                            <option value="">.:: Pilih Dosen ::.</option>
                            <?php foreach ($dosen as $keys) {
                                if ($key->ttd_sp == $keys->id) {
                            ?>
                                    <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                    </div>
                    <script>
                        function cekPLH() {
                            let val = $('#plh-plt-<?= $key->id ?>').val();
                            if (val === 'PLH' || val === 'PLT') {
                                $('#ttd-sp').prop('required', true);
                            } else {
                                $('#ttd-sp').prop('required', false);
                            }
                        }

                        // cek saat pertama kali halaman dimuat
                        cekPLH();

                        // cek saat dropdown berubah
                        $('#plh-plt-<?= $key->id ?>').on('change', cekPLH);
                    </script>
                <?php } ?>
            </div>
            <?php if (
                $authNamaLevel === 'Staf Jurusan' &&
                uri_string() !== 'C_ujian/monitoring'
            ) { ?>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="btn-kirim-sp-<?= $key->id ?>">
                        <?= ($key->status_putusan === 'terkirim' && !empty($key->no_sp)) ? 'Perbarui dan Kirim ke Prodi' : 'Kirim ke Prodi'; ?>
                    </button>
                    <script>
                        $(document).ready(function() {
                            //disable btn-kirim-sp-<?= $key->id ?> when form-no-surat-sp-<?= $key->id ?> is empty
                            $('#btn-kirim-sp-<?= $key->id ?>').prop('disabled', true);
                            $('#form-no-surat-sp-<?= $key->id ?>').on('input', function() {
                                if ($(this).val() != '') {
                                    $('#btn-kirim-sp-<?= $key->id ?>').prop('disabled', false);
                                } else {
                                    $('#btn-kirim-sp-<?= $key->id ?>').prop('disabled', true);
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