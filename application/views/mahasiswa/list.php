<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data mahasiswa</h4>
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
                <a href="#">Manajemen mahasiswa</a>
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
        <div class="card">
            <div class="card-header row">
                <div class="col-lg-4">
                    <h4>Data mahasiswa</h4>
                </div>
                <!-- <div class="col-lg-8">
                    <?php echo anchor(site_url('c_mahasiswa/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-primary btn-sm float-right"'); ?>
                </div> -->
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
                                <p>Apakah Anda yakin ingin menarik data mahasiswa?</p>
                                <small>Data akan diambil dari aplikasi <b>SIAKAD UHO</b>, proses ini mungkin memerlukan waktu beberapa saat.</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" id="btnTarik">Ya, Tarik</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body card-block">
                    <div class="table-responsive">
                        <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                            <table id="mhsTable" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Jurusan</th>
                                        <th width="100px">Action</th>
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
                                <h5 class="modal-title" id="detailModalLabel">Detail Mahasiswa</h5>
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
                <!-- modal delete -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Hapus Data mahasiswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="<?= site_url('daftar-mahasiswa/delete') ?>">
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="delete_id">
                                    <p>Apakah Anda yakin ingin menghapus data mahasiswa <strong id="delete_name"></strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                </div>
                            </form>
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
        $('#mhsTable').DataTable({
            "processing": true,
            "serverSide": true,
            "paging": true,
            "searching": true,
            "ajax": {
                "url": "<?= site_url('daftar-mahasiswa/table') ?>",
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
                        return row.jurusan?.nama_jurusan ?? "-";
                    }
                },
                {
                    "targets": 4,
                    "orderable": false,
                    "render": function(data, type, row) {
                        return ` <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="btn btn-sm btn-primary btn-detail"
                                            data-toggle="modal"
                                            data-target="#detailModal"
                                            data-list='${JSON.stringify(row)}'>
                                        Detail
                                    </button>

                                    <button class="btn btn-sm btn-danger btn-delete"
                                            data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-id="${row.id}"
                                            data-name="${row.nama_pengguna}">
                                        Hapus
                                    </button>

                                </div>`
                    }
                }
            ]
        });
    });
    // Handle delete button click
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        $('#delete_id').val(id);
        $('#delete_name').text(name);
    });

    $(document).on('click', '.btn-detail', function() {
        const data = $(this).data('list');
        console.table(data);

        let detailHtml = `
            <p><strong>Nama:</strong> ${data.nama_pengguna}</p>
            <p><strong>NIM:</strong> ${data.username}</p>
            <p><strong>Jurusan:</strong> ${data.jurusan?.nama_jurusan ?? "-"}</p>
            <p><strong>No. HP:</strong> ${data.no_hp ?? "-"}</p>
            <p><strong>Email:</strong> ${data.email ?? "-"}</p>
        `;
        $('#detailContent').html(detailHtml);
    });


    document.getElementById("btnTarik").addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("loadingOverlay").style.display = "flex";
        fetch("<?= site_url('daftar-mahasiswa/aktifasi'); ?>", {
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
                } else {
                    alert("Data berhasil ditarik!");
                    $("#mhsTable").DataTable().ajax.reload();
                }
            })
            .catch(error => {
                document.getElementById("loadingOverlay").style.display = "none";
                alert("Terjadi kesalahan: " + error);
            });
    });
</script>