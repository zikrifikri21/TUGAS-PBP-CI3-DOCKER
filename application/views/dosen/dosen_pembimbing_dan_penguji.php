<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<section class="container">
    <div class="row">
        <div class="col-md-12 card">
            <span class="font-weight-bold mt-3 ml-3"><i class="fas fa-filter"></i>Filter:</span>
            <div class="card-body row">
                <?php if (!empty(auth('tbl_user_level_id')) && auth('tbl_user_level_id') === "3") { ?>
                    <div class="col-md-6">
                        <select class="form-control" id="nama_jurusan" name="nama_jurusan" onchange="filterByProdi()">
                            <option value="">Semua Prodi</option>
                            <?php foreach ($jurusan as $j): ?>
                                <option value="<?= $j['nama_jurusan'] ?>"><?= $j['nama_jurusan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php } ?>
                <form action="<?= base_url('dosen-pembimbing-dan-penguji'); ?>" method="get" class="col-md-6 input-group">
                    <select class="custom-select" id="tahun" name="tahun">
                        <option value="">Semua Tahun</option>
                        <?php
                        $now = date('Y');
                        $tahun_selected = (isset($_GET['tahun'])) ? $_GET['tahun'] : $tahun_selected;
                        for ($i = 0; $i < 5; $i++) {
                            $year = $now - $i;
                            $selected = ($year == $tahun_selected) ? 'selected' : '';
                            echo '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
                        }
                        ?>
                    </select>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary btn-sm">Filter Tahun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if (!empty(auth('tbl_user_level_id')) && auth('tbl_user_level_id') === 2) { ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <span id="total-dosen">Total Dosen Prodi</span>
                        <h1 id="total-dosen-value">
                            <?php
                            echo count($data);
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="card">
        <div class="card-body">
            <?php
            if (auth('tbl_user_level_id') == "3") {
                $dosen   = null;
                $jurusan = null;
                $namaJurusan = null;
            } else {
                $dosen   = DosenFhil::table()->where(['tbl_user_id' => auth('id')])->first();
                $jurusan = Jurusan::table()->where('id', auth('jurusan_id'))->first();
                $namaJurusan = $jurusan ? $jurusan->nama_jurusan : null;
            }
            $dosenPembimbingPenguji = Collection::make($data)
                ->when(auth('tbl_user_level_id') == "4" && !empty($dosen), function ($collect) use ($dosen) {
                    return $collect->filter(function ($item) use ($dosen) {
                        return $item->id === $dosen->id;
                    });
                })
                ->when(auth('tbl_user_level_id') == "2", function ($collect) use ($namaJurusan) {
                    return $collect->filter(function ($item) use ($namaJurusan) {
                        return $item->nama_jurusan === $namaJurusan;
                    });
                })->map(function ($item) {
                    return [
                        'nama_dosen'          => $item->nama_dosen,
                        'nama_jurusan'        => $item->nama_jurusan,
                        'jumlah_pembimbing_1' => $item->jumlah_pembimbing_1,
                        'jumlah_pembimbing_2' => $item->jumlah_pembimbing_2,
                        'jumlah_uji1'         => $item->jumlah_uji1,
                        'jumlah_uji2'         => $item->jumlah_uji2,
                        'jumlah_uji3'         => $item->jumlah_uji3,
                        'total_bimbingan'     => $item->total_bimbingan,
                        'total_pengujian'     => $item->total_pengujian,
                    ];
                })->all();
            ?>
            <table id="datatable" class="table table-striped table-sm table-responsive" style="width:100%">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th rowspan="2" style="font-size: x-small;">Nama Dosen</th>
                        <th rowspan="2" style="font-size: x-small;">Nama Jurusan</th>
                        <th colspan="2" style="font-size: x-small;">Menjadi Pembimbing</th>
                        <th colspan="3" style="font-size: x-small;">Menjadi Penguji</th>
                        <th colspan="2" style="font-size: x-small;">Total</th>
                    </tr>
                    <tr>
                        <th style="font-size: x-small;">ke-1</th>
                        <th style="font-size: x-small;">ke-2</th>
                        <th style="font-size: x-small;">ke-1</th>
                        <th style="font-size: x-small;">ke-2</th>
                        <th style="font-size: x-small;">ke-3</th>
                        <th style="font-size: x-small;">Bimbingan</th>
                        <th style="font-size: x-small;">Penguji</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php foreach ($dosenPembimbingPenguji as $d): ?>
                        <tr>
                            <td><?= $d->nama_dosen ?></td>
                            <td><?= $d->nama_jurusan ?></td>
                            <td><?= $d->jumlah_pembimbing_1 ?></td>
                            <td><?= $d->jumlah_pembimbing_2 ?></td>
                            <td><?= $d->jumlah_uji1 ?></td>
                            <td><?= $d->jumlah_uji2 ?></td>
                            <td><?= $d->jumlah_uji3 ?></td>
                            <td><?= $d->total_bimbingan ?></td>
                            <td><?= $d->total_pengujian ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": []
                }],
                "order": [
                    [2, "desc"]
                ]
            });
        });

        function filterByProdi() {
            var nama_jurusan = document.getElementById('nama_jurusan').value;
            var table = $('#datatable').DataTable();
            table.search(nama_jurusan).draw();
            var countindDosen = table.rows({
                search: 'applied'
            }).count();
            var totalDosen = document.getElementById('total-dosen');
            totalDosen.innerHTML = "Total Dosen " + (nama_jurusan ? nama_jurusan : "Semua Prodi");
            var totalDosenValue = document.getElementById('total-dosen-value');
            totalDosenValue.innerHTML = countindDosen;
        }
    </script>
</section>