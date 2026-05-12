<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tambah Data ujian</h4>
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
                <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen ujian</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tambah ujian</a>
            </li>
        </ul>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Input Data Ujian</h4>
            </div>
            <form action="<?php echo $action; ?>" id="myForm" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="card-body card-block">
                    <div class="form-group row">
                        <div class="col col-md-3"><label>Jenis Ujian</label></div>
                        <div class="col col-md-9">
                            <select required class="form-control" name="jenis_ujian">
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
                            <textarea class="form-control" name="judul" id="judulInput" cols="30" rows="6" required="required" oninput="cekJudul()"><?php echo $judul; ?></textarea>
                            <small class="form-text text-muted"><?php echo form_error('title') ?></small>
                            <pre id="hasil" class="border rounded px-4 pb-3 mt-2" style="display: none;"></pre>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">IPK Sementara (cth. 3.60)</label></div>
                        <div class="col-12 col-md-9">
                            <input name="ipk_sementara"
                                id="ipk_sementara"
                                class="form-control"
                                type="number"
                                step="0.01"
                                min="1.00"
                                max="4.00"
                                placeholder="IPK Sementara"
                                required
                                value="<?= $ipk_sementara ?>">
                            <small class="form-text text-muted"><?php echo form_error('ipk_sementara') ?></small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?php if (uri_string() === 'c_ujian/create') { ?>
                        <input name="mahasiswa_id" class="form-control" type="hidden" value="<?php echo $mahasiswa->id; ?>">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i> Submit
                        </button>
                    <?php } else { ?>
                        <input name="id" class="form-control" type="hidden" value="<?php echo $id; ?>">
                        <input name="mahasiswa_id" class="form-control" type="hidden" value="<?php echo $mahasiswa->id; ?>">
                        <button onclick="cekJudul()" type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i>Submit
                        </button>
                    <?php } ?>
                    <a href="<?php echo site_url('c_ujian') ?>" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#ipk_sementara').on('input', function() {
        let val = this.value;
        if (val === '' || val === '.') return;
        if (!/^\d*\.?\d*$/.test(val)) {
            this.value = val.slice(0, -1);
            return;
        }
        if (val.includes('.')) {
            let [intPart, decPart] = val.split('.');
            if (decPart.length > 2) {
                this.value = intPart + '.' + decPart.slice(0, 2);
                return;
            }
        }
        let num = parseFloat(val);
        if (num > 4) {
            this.value = '4';
            return;
        }
        if (num < 1 && !val.endsWith('.')) {
            this.value = '1';
            return;
        }
    });
</script>
<?php if (uri_string() === 'c_ujian/create') { ?>
    <?php $ujian_json = json_encode($ujian); ?>
    <script>
        const judulInput = document.getElementById("judulInput");
        const hasilElement = document.getElementById("hasil");
        const submitButton = document.querySelector("#myForm button[type='submit']");
        const judulSkripsi = <?php echo $ujian_json; ?>;

        function levenshtein(a, b) {
            const matrix = [];
            const lenA = a.length;
            const lenB = b.length;
            for (let i = 0; i <= lenB; i++) {
                matrix[i] = [i];
            }
            for (let j = 0; j <= lenA; j++) {
                matrix[0][j] = j;
            }
            for (let i = 1; i <= lenB; i++) {
                for (let j = 1; j <= lenA; j++) {
                    if (b.charAt(i - 1) === a.charAt(j - 1)) {
                        matrix[i][j] = matrix[i - 1][j - 1];
                    } else {
                        matrix[i][j] = Math.min(
                            matrix[i - 1][j - 1] + 1,
                            matrix[i][j - 1] + 1,
                            matrix[i - 1][j] + 1
                        );
                    }
                }
            }
            return matrix[lenB][lenA];
        }

        function similarity(a, b) {
            if (!a || !b) return 0;
            const distance = levenshtein(a.toLowerCase(), b.toLowerCase());
            const maxLen = Math.max(a.length, b.length);
            if (maxLen === 0) return 1;
            return (1 - distance / maxLen);
        }

        function cekJudul() {
            const input = judulInput.value;
            const threshold = 0.7;
            if (input.trim() === '') {
                hasilElement.style.display = "none";
                if (submitButton) submitButton.disabled = false;
                return;
            }

            const hasilPerbandingan = judulSkripsi.map(j => {
                const judulDatabase = j.judul;
                return {
                    judul: judulDatabase,
                    similarity: similarity(input, judulDatabase).toFixed(2)
                };
            }).sort((a, b) => b.similarity - a.similarity);

            const mirip = hasilPerbandingan.filter(h => h.similarity >= threshold);

            let outputText = "";

            if (mirip.length > 0) {
                outputText += "⚠️ Judul yang memiliki kemiripan tinggi:\n";
                mirip.forEach(h => {
                    outputText += `- ${h.judul} (Kemiripan: ${Math.round(h.similarity * 100)}%)\n`;
                });
                if (submitButton) submitButton.disabled = true;
            } else {
                outputText += "✅ Aman! Tidak ditemukan judul yang terlalu mirip.";
                if (submitButton) submitButton.disabled = false;
            }

            hasilElement.innerText = outputText;
            hasilElement.style.display = "block";
        }

        document.addEventListener("DOMContentLoaded", function() {
            cekJudul();
        });
    </script>
<?php } ?>
