<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelola Hak Akses</h4>
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
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url($this->uri->segment(1)) ?>">Manajemen Hak Akses</a>
            </li>
        </ul>
    </div>
    <div class="section-body">
        <?php echo alert('sufee-alert alert with-close alert-danger alert-dismissible fade show', 'Perhatian', 'Silahkan Cheklist Pada Menu Yang Akan Diberikan Akses') ?>

        <div class="card">
            <div class="card-header">
                <h4>Manajemen Menu</h4>
            </div>
            <div class="card-body card-block">
                <div style="padding-bottom: 10px;">
                    <table class="table table-bordered table-striped" id="mytable">
                        <thead>
                            <tr>
                                <th width="30px">No</th>
                                <th>Nama Modul</th>
                                <th width="100px">Beri Akses</th>
                            </tr>
                            <?php
                            $no = 1;
                            foreach ($menu as $m) {
                                echo "<tr>
                                    <td>$no</td>
                                    <td>$m->title</td>
                                    <td align='center'><input type='checkbox' " .  checked_akses($this->uri->segment(3), $m->id) . " onClick='kasi_akses($m->id)'></td>
                                    </tr>";
                                $no++;
                            }
                            ?>
                        </thead>
                        <!-- <tr><td></td><td colspan="2">
                                    <button type="submit" class="btn btn-danger btn-sm float-right">Simpan Perubahan</button>
                                </td></tr> -->

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    function kasi_akses(id_menu) {
        //alert(id_menu);
        var id_menu = id_menu;
        var level = '<?php echo $this->uri->segment(3); ?>';
        //alert(level);
        // Di ganti jadi jQuery.ajax baru bisa
        jQuery.ajax({
            url: "<?php echo base_url() ?>c_userlevel/kasi_akses_ajax",
            data: "id_menu=" + id_menu + "&level=" + level,
            success: function(html) {
                location.reload();
                //load();
                //alert('sukses');
            }
        });
    }
</script>