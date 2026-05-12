<?php
$dosen = DosenFhil::table()->where(['tbl_user_id' => auth('id')])->first();
?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Penilaian Ujian Mahasiswa</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Penilaian Ujian</a>
            </li>
        </ul>
    </div>

    <div class="section-body">

        <?= validation_error('nilai');  ?>
        <?= validation_error('ujian_id');  ?>
        <?= validation_error('penilai_id');  ?>
        <div class="card">
            <div class="card-header row">
                <div class="col-lg-4">
                    <h4>Data Mahasiswa Ujian</h4>
                </div>
            </div>
            <div class="card-body card-block">
                <div class="table-responsive">
                    <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                        <table id="dosenTable" class="table table-sm table-responsive-sm table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Mahasiswa</th>
                                    <th>Judul Ujian</th>
                                    <th>Jurusan</th>
                                    <th width="40px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- modal penilaian -->
            <div class="modal fade" id="penilaian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Penilaian Ujian</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="<?= site_url('penilaian-ujian-mahasiswa/submit') ?>" method="POST">
                            <div class="modal-body">
                                <div id="penilaianContent"></div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" type="submit">Nilai</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modal surat penunjukan pembimbing -->
            <div class="modal fade" id="surat-penunjukan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Draft Surat Penunjukan Pembimbing</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="surat-penunjukanContent">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal surat tugas -->
            <div class="modal fade" id="surat-tugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Draft Surat Tugas</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="surat-tugasContent"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal berita acara -->
            <div class="modal fade" id="surat-berita-acara" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Draft Berita Acara</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="surat-beritaAcaraContent"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dosenTable').DataTable({
            "processing": true,
            "serverSide": true,
            "paging": true,
            "searching": true,
            "ajax": {
                "url": "<?= site_url('penilaian-ujian-mahasiswa/data') ?>",
                "type": "GET",
                "data": function(d) {
                    return {
                        page: (d.start / d.length) + 1,
                        per_page: d.length,
                        search: d.search.value,
                        draw: d.draw,
                        order_column: d.order[0].column,
                        order_dir: d.order[0].dir
                    };
                }
            },
            "columns": [{
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "mahasiswa.nama_mahasiswa",
                    "render": function(data, type, row) {
                        const namaMhs = row.mahasiswa?.nama_mahasiswa ?? '-';
                        const nimMhs = row.mahasiswa?.nim ?? '-';
                        return `
                        <div class="pt-2">
                        <h6 class="mb-0 font-weight-bold">NAMA : ${namaMhs}</h6>
                        <p>NIM : ${nimMhs}</p>
                        </div>
                        `
                    }
                },
                {
                    "data": "judul",
                    "render": function(data, type, row) {
                        return row.judul ?? '-';
                    }
                },
                {
                    "data": "jurusan.nama_jurusan",
                    "render": function(data, type, row) {
                        return row.jurusan?.nama_jurusan ?? '-';
                    }
                },
                {
                    "data": null,
                    "searchable": false,
                    "orderable": false,
                    "render": function(data, type, row) {
                        return `
                        <button class="btn btn-sm btn-success btn-penilaian mb-1"
                                data-toggle="modal"
                                data-target="#penilaian"
                                data-penilaian='${JSON.stringify(row)}'>
                            Tanda Tangan Beserta Penilaian
                        </button>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button class="btn btn-sm btn-secondary btn-penunjukan"
                                    data-toggle="modal"
                                    data-target="#surat-penunjukan"
                                    data-id='${JSON.stringify(row)}'>
                                Surat Penunjukan
                            </button>
                            <button class="btn btn-sm btn-warning btn-tugas"
                                    data-toggle="modal"
                                    data-target="#surat-tugas"
                                    data-id='${JSON.stringify(row)}'>
                                Surat Tugas
                            </button>
                            <button class="btn btn-sm btn-primary btn-berita-acara"
                                    data-toggle="modal"
                                    data-target="#surat-berita-acara"
                                    data-id='${JSON.stringify(row)}'>
                                Berita Acara
                            </button>
                        </div>
                        `;
                    }
                }
            ]
        });

        //modal surat penunjukan
        $(document).on('click', '.btn-penunjukan', function() {
            const penunjukan = $(this).data('id');
            const penunjukanId = parseInt(penunjukan.id);
            $('#surat-penunjukanContent').html(`
                <embed src="<?= base_url('C_draft/sp/') ?>${penunjukanId}" frameborder="0" width="100%" height="600px">
            `);
        });
        $(document).on('click', '.btn-tugas', function() {
            const penunjukan = $(this).data('id');
            const penunjukanId = parseInt(penunjukan.id);
            $('#surat-tugasContent').html(`
                <embed src="<?= base_url('C_draft/st/') ?>${penunjukanId}" frameborder="0" width="100%" height="600px">
            `);
        });
        $(document).on('click', '.btn-berita-acara', function() {
            const beritaAcara = $(this).data('id');
            const beritaAcaraId = parseInt(beritaAcara.id);
            $('#surat-beritaAcaraContent').html(`
                <embed src="<?= base_url('C_draft/ba/') ?>${beritaAcaraId}" frameborder="0" width="100%" height="600px">
            `);
        });

        //modal penilaian
        $(document).on('click', '.btn-penilaian', function() {
            const penilaian = $(this).data('penilaian');
            const dosenId = <?= $dosen->id; ?>;
            $('#penilaianContent').html(`
                <input type="hidden" name="ujian_id" value="${penilaian.id}">
                <input type="hidden" name="penilai_id" value="${dosenId}">
                <div class="form-group mb-3">
                    <label for="nilai">Nilai</label>
                    <input type="number" class="form-control" id="nilai" name="nilai" required>
                    <small class="form-text text-muted">Masukkan nilai (0-100). Dengan memberi nilai, Anda mengonfirmasi bahwa anda sudah mengikuti ujian</small>
                </div>
            `);
        });

    });
</script>