<div class="page-title">
    <div class="title_left">
        <h3><small><?php echo $title;?></small></h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-9">
                        <form action="<?php echo current_url();?>" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="password_lama">
                                    Password Lama
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="password" class="form-control" name="password_lama" id="password_lama">
                                    <?php echo form_error('password_lama', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="password">
                                    Password Baru
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="password" class="form-control" name="password" id="password">
                                    <?php echo form_error('password', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="konfirmasi_password">
                                    Konfirmasi Password Baru
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password">
                                    <?php echo form_error('konfirmasi_password', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9 col-sm-9">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Perbarui Password
                                    </button>
                                    <a href="<?php echo base_url('backoffice/profiles');?>" class="btn btn-secondary">
                                        <i class="fa fa-reply"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>