<div class="modal fade" id="su-<?= $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selesaikan Ujian</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <?= form_open("C_verifikasi_ujian/selesaikan") ?>
            <div class="modal-body" style="text-align: center;">
                <input type="hidden" name="id" value="<?= $key->id ?>">
                <p>Apakah anda yakin ingin menyelesaikan ujian ini?</p>
                <div class="alert alert-warning">
                    <p class="font-weight-bold">pastikan proses ujian telah selesai dilaksanakan sebelum memverifikasi ujian ini telah selesai.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit">
                    Selesaikan Ujian
                </button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>