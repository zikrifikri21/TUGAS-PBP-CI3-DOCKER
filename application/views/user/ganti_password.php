
<section class="section">
    <div class="section-header">
        <h1>Ganti Passowrd</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url()?>C_user">Managemen User</a></div>
            <!-- <div class="breadcrumb-item"><a href="#">Manajemen User</a></div> -->
            <div class="breadcrumb-item">Ganti Password</div>
        </div>
        </div>
        <!-- <div class="alert alert-success" role="alert">
        </div> -->
        <div class="section-body">

            <!-- <div class="col-lg-12"> -->
            <!-- <div class="card">
                <div class="card-header">
                <strong>Input Data</strong> USER
            </div> -->

            <div class="card">
                
                <div class="card-header">
                    <h4>Menu Penggantian Password</h4>
                </div>
                <div class="card-body card-block">
                <?= $this->session->flashdata('message'); ?>
                <form action="<?= base_url('C_user/change_pass'); ?>" method="post">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                        <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="new_password1">New Password</label>
                        <input type="password" class="form-control" id="new_password1" name="new_password1">
                        <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="new_password2">Repeat Password</label>
                        <input type="password" class="form-control" id="new_password2" name="new_password2">
                        <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</section>