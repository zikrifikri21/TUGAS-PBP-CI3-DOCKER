<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data dosen</h4>
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
                <a href="#">Manajemen dosen</a>
            </li>
        </ul>
    </div>
    <?php
    if ($this->session->flashdata('input')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-success alert-dismissible fade show', 'Pesan', $this->session->flashdata('input')) ?>
    <?php } else if ($this->session->flashdata('edit')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-warning alert-dismissible fade show', 'Pesan', $this->session->flashdata('edit')) ?>
    <?php } else if ($this->session->flashdata('delete')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Pesan', $this->session->flashdata('delete')) ?>
    <?php } ?>
    <div id="loadingOverlay" style="display:none;position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); color:white; align-items:center; justify-content:center; z-index:9999; font-size:1.2rem;">
        <div style="text-align:center">
            <div class="spinner-border text-light" role="status"></div>
            <p class="mt-3">Mengambil data... Mohon tunggu.</p>
        </div>
    </div>
    <div class="section-body">
        <?php if (zflash('errors')) { ?>
            <?php echo alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Pesan', zflash('errors')) ?>
        <?php } else if (zflash('success')) { ?>
            <?php echo alert('sufee-alert alert with-close alert-success alert-dismissible fade show', 'Pesan', zflash('success')) ?>
        <?php } else if (zflash('error')) { ?>
            <?php echo alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Pesan', zflash('error')) ?>
        <?php } ?>
        <div class="card">
            <div class="card-header row">
                <div class="col-lg-4">
                    <h4>Data dosen</h4>
                    <?php echo anchor(site_url('c_dosen/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-success btn-sm float-left"'); ?>
                </div>

                <div class="col-lg-8">
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#confirm-tarik">
                        <i class="fa fa-wpforms" aria-hidden="true"></i> Tarik Data
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="confirm-tarik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menarik data dosen?</p>
                                <small>Data akan diambil dari aplikasi Aplikasi <b>SISTER</b>, proses ini mungkin memerlukan waktu beberapa saat</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" id="btnTarik">Ya, Tarik</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body card-block">
                <div class="table-responsive">
                    <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                        <table id="dosenTable" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIDN</th>
                                    <th>Home Base</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- modal detail -->
            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel">Detail Dosen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="detailContent"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addTTD" tabindex="-1" role="dialog" aria-labelledby="addTTDLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTTDLabel">Detail Dosen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="detailContentTTD"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Hapus Data Dosen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="<?= site_url('daftar-dosen/delete') ?>">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="delete_id">
                                <p>Apakah Anda yakin ingin menghapus data dosen <strong id="delete_name"></strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- add jabatan -->
            <div class="modal fade" id="addJabatan" tabindex="-1" role="dialog" aria-labelledby="addJabatanLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addJabatanLabel">Tambah Jabatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="jabatanContent"></div>
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
                "url": "<?= site_url('daftar-dosen/table') ?>",
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
                    "data": null
                },
                {
                    "data": "nama_pengguna"
                },
                {
                    "data": "username"
                },
                {
                    "data": "jurusan.nama_jurusan"
                },
                {
                    "data": null
                }
            ],
            "columnDefs": [{
                    "targets": 0,
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "targets": 3,
                    "render": function(data, type, row) {
                        const namaJurusan = row.dosen?.jurusan?.nama_jurusan ?? '-';
                        return `
                        <div>
                        <p class="mb-0">${namaJurusan}</p>
                        <span class="font-weight-bold text-primary">${row.dosen?.jabatan_akademik ?? '-'}</span>
                        </div>
                        `
                    }
                },
                {
                    "targets": 4,
                    "orderable": false,
                    "render": function(data, type, row) {
                        const transform = () => {
                            if (row.dosen === null) {
                                return {
                                    id: null,
                                    ttd_dosen: null
                                };
                            }
                            return {
                                id: row.dosen.id,
                                ttd_dosen: row.dosen?.ttd_dosen
                            };
                        }
                        return `
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button class="btn btn-sm btn-secondary btn-ttd"
                                    data-toggle="modal"
                                    data-target="#addTTD"
                                    data-ttd='${JSON.stringify(transform())}'>
                                Tambah TTD
                            </button>
                            <button class="btn btn-sm btn-success btn-jabatan rounded-right"
                                    data-toggle="modal"
                                    data-target="#addJabatan"
                                    data-jabatan="${encodeURIComponent(JSON.stringify(row))}">
                                Jabatan
                            </button>
                            <div class="dropdown ml-1">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item btn-detail"
                                    data-toggle="modal"
                                    data-target="#detailModal"
                                    data-list='${JSON.stringify({
                                        ...row,
                                        dosen: row.dosen ?? { nidn: '-', nip: '-', ttd_dosen: '' }
                                    })}' href="#">Detail</a>
                                    <a class="dropdown-item btn-edit" href="<?= base_url('C_dosen/update') ?>/${row.dosen?.id}">Edit</a>
                                    <a class="dropdown-item btn-delete"
                                    data-toggle="modal"
                                    data-target="#deleteModal"
                                    data-id="${row.id}" data-name="${row.nama_pengguna}" href="#">Hapus</a>
                                </div>
                            </div>
                        </div>
                        `;
                    }
                }
            ]
        });

        $(document).on('click', '.btn-jabatan', function() {
            var data_json = decodeURIComponent($(this).data('jabatan'));
            const obj = JSON.parse(data_json);

            let jabatanStruktural = '';
            if (obj.jurusan?.ketua_jurusan == obj.dosen?.id) {
                jabatanStruktural = 'kajur';
            } else if (obj.jurusan?.sekretaris_jurusan == obj.dosen?.id) {
                jabatanStruktural = 'sekjur';
            }
            const jabatanSaatIni = obj.dosen?.jabatan_akademik || jabatanStruktural || '';
            const jabatan = ['dekan', 'wd1', /** TODO: 'wd2', 'wd3',*/ 'kajur', 'sekjur'];

            var html = `
                <form method="post" action="<?= site_url('daftar-dosen/add-jabatan') ?>">
                    <input type="hidden" name="id" value="${obj.id}">
                    <input type="hidden" name="jurusan_id" value="${obj.jurusan?.id}">
                    <input type="hidden" name="dosen_id" value="${obj.dosen?.id}">
                    <div class="alert alert-info py-1">
                        Jabatan Terdeteksi: <strong>${jabatanSaatIni.toUpperCase()}</strong>
                    </div>

                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <select class="form-control" id="jabatan" name="jabatan">
                            <option value="">:: Pilih Jabatan ::.</option>
                            ${jabatan.map(j => {
                                const isSelected = (j === jabatanSaatIni) ? 'selected' : '';
                                return `<option value="${j}" ${isSelected}>${j.toUpperCase()}</option>`;
                            }).join('')}
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            `;
            $('#jabatanContent').html(html);
        });

        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#delete_id').val(id);
            $('#delete_name').text(name);
        });

        $('#dosenTable tbody').on('click', '.btn-detail', function() {
            var obj = JSON.parse($(this).attr('data-list'));

            var html = `
                <div class="row">
                    <div class="col-md-4">
                        <h5>Nama</h5>
                        <p>${obj.nama_pengguna}</p>
                    </div>
                    <div class="col-md-4">
                        <h5>NIDN</h5>
                        <p>${obj.dosen?.nidn ?? '-'}</p>
                    </div>
                    <div class="col-md-4">
                        <h5>NIP</h5>
                        <p>${obj.dosen?.nip ?? '-'}</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Home Base</h5>
                        <p>${obj.jurusan?.nama_jurusan ?? '-'}</p>
                    </div>
                    <div class="col-md-4">
                        <h5>TTD</h5>
                        <img src="<?= base_url('upload/ttd_dosen/'); ?>${obj.dosen?.ttd_dosen ?? ''}" alt="TTD" class="img-fluid">
                    </div>
                </div>
            `;

            $('#detailContent').html(html);
            $('#detailModal').modal('show');
        });
        $('#dosenTable tbody').on('click', '.btn-ttd', function() {
            var data = JSON.parse($(this).attr('data-ttd'));
            const imageOld = (data.ttd_dosen) ? `<img src="<?= base_url('upload/ttd_dosen/'); ?>${data.ttd_dosen}" alt="TTD Lama" class="img-fluid" width="180px" height="180px">` : '';
            var html = `
                <div class="row">
                    <div class="col-md-12">
                        <h5>Tambah TTD</h5>
                        <form action="<?= site_url("daftar-dosen/update/:id"); ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-4">
                                <label for="ttd">TTD</label>
                                <input type="file" name="file" class="form-control" required>
                                <label for="asd" class="form-group border">
                                ${imageOld}
                                </label>
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            `.replace(':id', data.id);

            $('#detailContentTTD').html(html);
            $('#addTTD').modal('show');
        });


    });

    document.getElementById("btnTarik").addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("loadingOverlay").style.display = "flex";
        fetch("<?= site_url('daftar-dosen/aktifasi'); ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("loadingOverlay").style.display = "none";
                let parsedMessage;
                try {
                    parsedMessage = JSON.parse(data.message);
                } catch (e) {
                    parsedMessage = {
                        message: data.message
                    };
                }
                if (parsedMessage.message === "Unauthenticated.") {
                    alert("Token invalid atau expired, lakukan penarikan data ulang");
                } else if (data.error) {
                    alert("Terjadi kesalahan saat menarik data dari 'SISTER'.");
                } else {
                    alert("Data berhasil ditarik!");
                    $("#dosenTable").DataTable().ajax.reload();
                }
            })
            .catch(error => {
                document.getElementById("loadingOverlay").style.display = "none";
                alert("Terjadi kesalahan: " + error);
            });
    });
</script>
