<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data Pengguna</h4>
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
                <a href="#">Manajemen User</a>
            </li>
        </ul>
    </div>
    <?php
    if ($this->session->flashdata('message')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-success alert-dismissible fade show', 'Pesan', $this->session->flashdata('message')) ?>
    <?php } ?>
    <div class="section-body">
        <style>
            .button {
                display: inline-block;
                border-radius: 7px;
                border: none;
                background: #015799;
                color: white;
                font-family: inherit;
                text-align: center;
                font-size: 13px;
                box-shadow: -2px 11px 7px -9px rgba(158, 158, 158, 0.66);
                -webkit-box-shadow: -2px 11px 7px -9px rgba(158, 158, 158, 0.66);
                -moz-box-shadow: -2px 11px 7px -9px rgba(158, 158, 158, 0.66) #152776;
                width: 10em;
                padding: -4em;
                transition: all 0.4s;
                cursor: pointer;
            }

            .button span {
                cursor: pointer;
                display: inline-block;
                position: relative;
                transition: 0.4s;
            }

            .button span:after {
                content: 'Data';
                position: absolute;
                opacity: 0;
                top: 0;
                right: -20px;
                transition: 0.7s;
            }

            .button:hover span {
                padding-right: 2.90em;
            }

            .button:hover span:after {
                opacity: 4;
                right: 3px;
            }
        </style>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-3">
                            <h4 class="card-title">Data Pengguna</h4>
                        </div>
                        <div class="col-md-9">
                            <?php echo anchor(site_url('C_user/create'), '<button class="button btn-sm float-right"><span><i class="fa fa-plus"></i> Tambah</span></button>'); ?>
                        </div>
                    </div>
                    <div class="card-body card-block">
                        <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small  table-responsive">
                            <table id="mytable" class="display table table-bordered table-striped table-hover">
                                <thead class="small">
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Handphone</th>
                                        <!-- <th>Unit Kerja</th> -->
                                        <th>Level User</th>
                                        <th>Status</th>
                                        <th width="150px">Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };

            var t = $("#mytable").dataTable({
                initComplete: function() {
                    var api = this.api();
                    $('#mytable_filter input')
                        .off('.DT')
                        .on('keyup.DT', function(e) {
                            if (e.keyCode == 13) {
                                api.search(this.value).draw();
                            }
                        });
                },
                oLanguage: {
                    sProcessing: "loading..."
                },
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "C_user/json",
                    "type": "POST"
                },
                columns: [{
                        "data": "id",
                        "orderable": false
                    },
                    {
                        "data": "nama_pengguna"
                    },
                    {
                        "data": "username"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "no_hp"
                    },
                    {
                        "data": "nama"
                    },
                    {
                        "data": "is_aktif"
                    },
                    {
                        "data": "action",
                        "orderable": false,
                        "className": "text-center"
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                }
            });
        });
    </script>
</div>