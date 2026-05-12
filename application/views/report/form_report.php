<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Data Report</h4>
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
                <a href="<?= base_url('C_report') ?>">Manajemen Report</a>
            </li>
        </ul>
    </div>
    <div class="section-body">
        <div class="card">

            <div class="card-header">
                <h4>Report Ujian</h4>
            </div>
            <form action="<?php echo site_url('C_report/report_excel') ?>" method="post" enctype="multipart/form-data" class="form-horizontal" target="_blank">
                <div class="card-body card-block">

                    <div class="row form-group">
                        <div class="col col-md-2">
                            <label for="text-input" class=" form-control-label">Mulai Tanggal</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <input name="mulai" class="form-control" type="date" data-provide="datepicker" required="required">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-2">
                            <label for="text-input" class=" form-control-label">Sampai Tanggal</label>
                        </div>

                        <div class="col-12 col-md-10">
                            <input name="selesai" class="form-control" type="date" data-provide="datepicker" required="required">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-2"><label>Jenis Ujian</label></div>
                        <div class="col col-md-10">
                            <select class="form-control" name="jenis_ujian">
                                <option value="">Semua</option>
                                <option>proposal</option>
                                <option>hasil</option>
                                <option>skripsi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm" name="button" value="rekap">
                        Rekap Excel
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
