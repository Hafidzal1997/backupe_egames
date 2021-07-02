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
                                <label class="control-label col-md-3">Nama Client</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama');?>">
                                    <?php echo form_error('nama', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Alamat</label>
                                <div class="col-md-9 col-sm-9">
                                    <textarea name="alamat" class="form-control" rows="4"><?php echo set_value('alamat');?></textarea>
                                    <?php echo form_error('alamat', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="email" class="form-control" name="email" value="<?php echo set_value('email');?>">
                                    <?php echo form_error('email', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">No. Telepon</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="number" class="form-control" name="nomor_telepon" value="<?php echo set_value('nomor_telepon');?>">
                                    <?php echo form_error('nomor_telepon', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">No. Telepon 2</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="number" class="form-control" name="nomor_telepon2" value="<?php echo set_value('nomor_telepon2');?>">
                                    <?php echo form_error('nomor_telepon2', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Foto</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="file" class="form-control" name="foto" value="<?php echo set_value('foto');?>" accept=".png, .jpg, .jpeg">
                                    <?php echo form_error('foto', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Nama PIC</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" name="nama_pic" value="<?php echo set_value('nama_pic');?>">
                                    <?php echo form_error('nama_pic', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Email PIC</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="email" class="form-control" name="email_pic" value="<?php echo set_value('email_pic');?>">
                                    <?php echo form_error('email_pic', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">No. HP/Telepon PIC</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="number" class="form-control" name="nomor_hp_pic" value="<?php echo set_value('nomor_hp_pic');?>">
                                    <?php echo form_error('nomor_hp_pic', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9 col-sm-9">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                    <a href="<?php echo base_url('backoffice/clients');?>" class="btn btn-secondary">
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