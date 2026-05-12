<div class="modal fade" id="setujui" tabindex="-1" role="dialog" aria-labelledby="setujuiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setujuiLabel">Setujui Surat</h5>
                <button class="close" type="button" data-dismiss="modal">
                    <span>×</span>
                </button>
            </div>

            <form action="<?= base_url('DekanWdController/verifikasi'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="setujui-surat">
                    <p>Apakah anda yakin ingin menyetujui surat ini?</p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Setujui</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#setujui').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            $(this).find('input[name="id"]').val(id);
        });
    });
</script>