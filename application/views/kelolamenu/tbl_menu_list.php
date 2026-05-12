<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data Menu</h4>
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
                <a href="#">Manajemen Menu</a>
            </li>
        </ul>
    </div>
    <?php if ($this->session->flashdata('message')) { ?>
        <?php echo alert('sufee-alert alert with-close alert-success alert-dismissible fade show', 'Pesan', $this->session->flashdata('message')) ?>
    <?php } ?>
    <!-- <div class="section-body">
        <div class="row">
            <div class="col-12 align-self-end">
                <div class="card-body small">
                    <?php echo form_open('C_menu/simpan_setting') ?>
                    <table class="table table-dark">
                        <tr>
                            <td width="250" style="color:white">Tampilkan Menu Berdasarkan Level</td>
                            <td>
                                <?php
                                echo form_dropdown('tampil_menu', array('ya' => 'YA', 'tidak' => 'TIDAK'), $setting['value'], array('class' => 'form-control'));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button></td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

    <div class="card">
        <div class="card-header row">
            <div class="col-md-3">
                <h4 class="card-title">DATA MENU</h4>
            </div>
            <div class="col-md-9">
                <?php echo anchor(site_url('C_menu/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-primary btn-sm float-right"'); ?>
            </div>
        </div>
        <div class="card-body card-block">
            <div id="bootstrap-data-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer small">
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="30px">No</th>
                                <th>Title</th>
                                <th>Url</th>
                                <th>Icon</th>
                                <th>Is Main Menu</th>
                                <th>Is Aktif</th>
                                <th width="100px">Action</th>
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
                "url": "C_menu/json",
                "type": "POST"
            },
            columns: [{
                    "data": "id",
                    "orderable": false
                }, {
                    "data": "title"
                }, {
                    "data": "url"
                }, {
                    "data": "icon"
                }, {
                    "data": "is_main_menu"
                }, {
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
</section>