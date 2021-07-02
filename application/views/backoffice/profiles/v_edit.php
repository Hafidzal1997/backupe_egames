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
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="email" class="form-control" name="email" value="<?php echo (set_value('email') ? set_value('email') : $edit->email);?>" readonly>
                                    <?php echo form_error('email', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Nama User</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" name="nama" value="<?php echo (set_value('nama') ? set_value('nama') : $edit->nama);?>">
                                    <?php echo form_error('nama', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Foto</label>
                                <div class="col-md-9 col-sm-9">
                                    <?php
                                    if(file_exists('./uploads/foto/' . $edit->foto) && $edit->foto){
                                        echo '<img src="'.base_url('uploads/foto/' . $edit->foto).'" class="img-thumbnail">';
                                    }
                                    ?>
                                    <input type="hidden" name="foto_old" value="<?php echo $edit->foto; ?>" placeholder="">
                                    <input type="file" class="form-control" name="foto" value="<?php echo set_value('foto');?>" accept=".png, .jpg, .jpeg">
                                    <?php echo form_error('foto', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9 col-sm-9">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Perbarui Profil
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