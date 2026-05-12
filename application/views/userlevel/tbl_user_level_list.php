<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data Level User</h4>
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
                <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen Level User</a>
            </li>
        </ul>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header row">
                <div class="col-md-3">
                    <h4 class="card-title">Level User</h4>
                </div>
                <div class="col-md-9">
                    <?php echo anchor(site_url('C_userlevel/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-primary btn-sm float-right"'); ?>
                </div>
            </div>
            <div class="card-body card-block">
                <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                    <table id="mytable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="30px">No</th>
                                <th>Nama Level</th>
                                <th width="200px">Action</th>
                            </tr>
                        </thead>

                    </table>
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
                "url": "C_userlevel/json",
                "type": "POST"
            },
            columns: [{
                    "data": "id",
                    "orderable": false
                }, {
                    "data": "nama"
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