<?php
$dosenJabatan = DosenFhil::table()->where('tbl_user_id', auth('id'))->first();
?>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-2">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Verifikasi SK</h2>
                <h5 class="text-white op-7 mb-2">Halaman Verifikasi Surat Keterangan Dekan</h5>
            </div>
        </div>
    </div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Verifikasi SK</div>
                </div>
                <?= validation_error('status_putusan'); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Tanggal SK</th>
                                            <th>Nomor SK</th>
                                            <th>Jenis Ujian</th>
                                            <th>Status</th>
                                            <th>Surat Ujian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- modal verifikasi -->
                            <div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Verifikasi SK</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <?= form_open('verifikasi-sk/verifikasi'); ?>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" id="id">
                                            <h5 class="p-4" style="font-weight: bold; text-align: center;">Apakah anda yakin ingin memverifikasi SK ini?</h5>
                                            <?php if ($dosenJabatan->jabatan_akademik == "wd1") { ?>
                                                <div class="form-group">
                                                    <label for="status_putusan">Status Putusan</label>
                                                    <select name="status_putusan" id="status_putusan" class="form-control">
                                                        <option value="v2">Diterima</option>
                                                        <option value="v0">Kembalikan Dengan Catatan</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="catatan-tolakan" style="display: none;">
                                                    <label for="catatan">Catatan Pengembalian SK</label>
                                                    <textarea name="catatan" id="catatan" class="form-control" placeholder="Masukkan Catatan Penolakan."></textarea>
                                                </div>
                                            <?php } else { ?>
                                                <input type="hidden" name="status_putusan" value="v3">
                                            <?php } ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary" id="verifikasi">
                                                <?= auth('tbl_user_level_id' == "8") ? "Verifikasi" : "Kirim Ke Dekan"; ?>
                                            </button>
                                        </div>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- modal konsideran -->
                            <div class="modal fade" id="konsideranModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Konsideran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="surat-konsideranContent"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal lampiran -->
                            <div class="modal fade" id="lampiranModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Lampiran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="surat-lampiranContent"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(document).ready(function() {
        $('#status_putusan').on('change', function() {
            if ($(this).val() == 'v0') {
                $('#catatan-tolakan').slideDown();
                $('#verifikasi').text('Kembalikan');
            } else {
                $('#catatan-tolakan').slideUp();
                $('#verifikasi').text('Kirim Ke Dekan');
            }
        });
    })
</script>
<script>
    $(document).ready(function() {
        $('#add-row').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('verifikasi-sk/data') ?>",
                "type": "GET",
                "data": function(d) {
                    var order = d.order ? d.order[0] : undefined;
                    return {
                        page: (d.start / (d.length || 0)) + 1,
                        per_page: d.length || 0,
                        search: d.search.value,
                        draw: d.draw,
                        order_column: order ? order.column : undefined,
                        order_dir: order ? order.dir : undefined
                    };
                },
                "error": function(e) {
                    console.log(e.responseText);
                },
                "dataType": "json"
            },
            "columns": [{
                    "data": null,
                    "targets": 0,
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "no_sk"
                },
                {
                    "data": "tgl_sk"
                },
                {
                    "data": "ujian.jenis_ujian",
                    "orderable": false
                },
                {
                    "data": "status_putusan",
                    "render": function(data, type, row) {
                        if (data == 'v1') {
                            return '<span class="badge badge-info">Diproses</span>';
                        } else {
                            return '<span class="badge badge-warning">Menuggu</span>';
                        }
                    }
                },
                {
                    "data": null,
                    "searchable": false,
                    "orderable": false,
                    "render": function(data, type, row) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary btn-konsideran"
                                data-toggle="modal"
                                data-target="#konsideranModal"
                                data-id="${row.id}">Konsideran</button>
                                <button class="btn btn-sm btn-secondary btn-lampiran"
                                data-toggle="modal"
                                data-target="#lampiranModal"
                                data-id="${row.id}">Lampiran</button>
                            </div>
                        `;
                    }
                },
                {
                    "data": null,
                    "searchable": false,
                    "orderable": false,
                    "render": function(data, type, row) {
                        return `<button class="btn btn-sm btn-success btn-verifikasi"
                        data-toggle="modal"
                        data-target="#deleteModal"
                        data-id="${row.id}"
                        data-nama="${row.nama}">Verifikasi</button>`;
                    }
                },
            ]
        });
        //modal konsideran
        $(document).on('click', '.btn-konsideran', function() {
            const konsideranId = $(this).data('id');
            $('#surat-konsideranContent').html(`
                <embed src="<?= base_url('C_draft/sk_dekan_konsideran_ujian/') ?>${konsideranId}" frameborder="0" width="100%" height="600px">
            `);
        });
        //modal lampiran
        $(document).on('click', '.btn-lampiran', function() {
            const lampiranId = $(this).data('id');
            $('#surat-lampiranContent').html(`
                <embed src="<?= base_url('C_draft/sk_dekan_lampiran_ujian/') ?>${lampiranId}" frameborder="0" width="100%" height="600px">
            `);
        });
        // modal verifikasi
        $(document).on('click', '.btn-verifikasi', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            $('#id').val(id);
            $('#verifikasiModal').modal('show');
        });
    })
</script>
