<div class="modal fade" id="ba<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Draft Berita Acara</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <?php echo form_open_multipart("C_verifikasi_ujian/upload_file") ?>
            <div class="modal-body">
                <embed src="<?php echo base_url() . 'C_draft/ba/' . $key->id ?>" frameborder="0" width="100%" height="600px">
                <?php if (
                    auth('nama_level') === 'Staf Jurusan' &&
                    uri_string() !== 'C_ujian/monitoring' &&
                    $key->jenis_ujian == 'skripsi'
                ) { ?>
                    <div class="form-group">
                        <label for="text-input" class=" form-control-label">Nilai Ujian</label>
                        <input type="hidden" class="form-control" name="id" value="<?php echo $key->id ?>">
                        <input type="text" class="form-control" name="nilai_ujian" value="<?php echo $key->nilai_ujian ?>">
                    </div>
                <?php } ?>
                <!-- sontent comment -->
            </div>
            <?php if (
                auth('nama_level') === 'Staf Jurusan' &&
                uri_string() !== 'C_ujian/monitoring' &&
                $key->jenis_ujian == 'skripsi'
            ) { ?>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">
                        Kirim ke Prodi
                    </button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                </div>
            <?php } ?>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- <div class="form-group">
        <label for="text-input" class=" form-control-label">Yang Bertanda Tangan (optional jika plh/plt)</label><br>
        <select class="form-control select2 js-example-basic-single js-states" style="width: 100%;" name="ttd_ba">
            <option value="">.:: Pilih Dosen ::.</option>
            <?php foreach ($dosen as $keys) {
                if ($key->ttd_ba == $keys->id) {
            ?>
                    <option value="<?php echo $keys->id ?>" selected><?php echo $keys->nama_dosen ?></option>
                <?php } else { ?>
                    <option value="<?php echo $keys->id ?>"><?php echo $keys->nama_dosen ?></option>
            <?php
                }
            } ?>
        </select>
    </div> -->
<!-- <div class="form-group">
        <label for="text-input" class=" form-control-label">Upload Ulang File Berisi TTD (Scan PDF)</label>
        <br> <span class="text-red">file sebelumnya: </span><a href="<?php echo base_url() . "upload/file/" . $key->upload_ba; ?>" target="_blank"><?php echo $key->upload_ba; ?></a>
        <input type="file" class="form-control" name="upload_ba" accept=".pdf">
        <input type="hidden" class="form-control" name="id" value="<?php echo $key->id ?>">
    </div> -->