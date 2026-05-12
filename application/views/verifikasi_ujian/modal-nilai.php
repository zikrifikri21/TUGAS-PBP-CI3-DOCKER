<?php
$roles = [
    'pembimbing' => [
        'label' => 'Pembimbing',
        'count' => 2,
    ],
    'uji' => [
        'label' => 'Penguji',
        'count' => 3,
    ],
];
?>
<div class="modal fade" id="nilai-ujian" tabindex="-1" role="dialog" aria-labelledby="nilai-ujianLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nilai-ujianLabel">Nilai Ujian</h5>
                <button class="close" type="button" data-dismiss="modal">
                    <span>×</span>
                </button>
            </div>

            <form action="<?= base_url('penilaian-ujian-mahasiswa/nilai-staf'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="nilai-ujian-staf">
                    <?php foreach ($roles as $key => $role): ?>
                        <?php for ($i = 1; $i <= $role['count']; $i++): ?>
                            <div class="form-group">
                                <label for="<?= $key ?>nama_<?= $i ?>">
                                    <?= $role['label'] ?> <?= $i ?>
                                </label>
                                <input type="text" class="form-control mb-1"
                                    id="<?= $key ?>nama_<?= $i ?>"
                                    readonly>
                                <input type="number" class="form-control" placeholder="Masukkan Nilai"
                                    name="nilai_<?= $key ?>_<?= $i ?>"
                                    id="nilai_<?= $key ?>_<?= $i ?>" min="0" max="100" required>
                                <input type="hidden" name="<?= $key ?>_<?= $i ?>" id="<?= $key ?>_<?= $i ?>">
                            </div>
                        <?php endfor; ?>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Simpan</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#nilai-ujian').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var id = button.data('id');
            var ujian = button.data('ujian');
            console.log(ujian);
            $('#nilai-ujian-staf').val(id);

            if (ujian) {
                //hidden
                $('#pembimbing_1').val(ujian.pembimbing_1.id);
                $('#pembimbing_2').val(ujian.pembimbing_2.id);
                $('#uji_1').val(ujian.uji1.id);
                $('#uji_2').val(ujian.uji2.id);
                $('#uji_3').val(ujian.uji3.id);

                //show
                $('#pembimbingnama_1').val(ujian.pembimbing_1.nama_dosen);
                $('#pembimbingnama_2').val(ujian.pembimbing_2.nama_dosen);
                $('#ujinama_1').val(ujian.uji1.nama_dosen);
                $('#ujinama_2').val(ujian.uji2.nama_dosen);
                $('#ujinama_3').val(ujian.uji3.nama_dosen);
            }
        });
    });
</script>
