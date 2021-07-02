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
                                <label class="control-label col-md-3">Kode Bank</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" name="kode_bank" value="<?php echo (set_value('kode_bank') ? set_value('kode_bank') : $edit->kode_bank);?>">
                                    <?php echo form_error('kode_bank', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Nama Bank</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" name="nama_bank" value="<?php echo (set_value('nama_bank') ? set_value('nama_bank') : $edit->nama_bank);?>">
                                    <?php echo form_error('nama_bank', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Status</label>
                                <div class="col-md-9 col-sm-9">
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="flag_active" id="flag_active_y" value="Y" <?php echo ($edit->flag_active == 'Y' ? 'checked' : '');?>>
                                            <label class="form-check-label" for="flag_active_y">Aktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="flag_active" id="flag_active_n" value="N" <?php echo ($edit->flag_active == 'N' ? 'checked' : '');?>>
                                            <label class="form-check-label" for="flag_active_n">Tidak Aktif</label>
                                        </div>
                                    </div>  
                                    <?php echo form_error('flag_active', '<br><span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9 col-sm-9">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                    <a href="<?php echo base_url('backoffice/banks');?>" class="btn btn-secondary">
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