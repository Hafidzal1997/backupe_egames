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
                                <label class="control-label col-md-3" for="clients_id">
                                    Nama Client
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <select name="clients_id" class="form-control">
                                        <option value="">- Pilih Client -</option>
                                        <?php
                                        if($clients){
                                            foreach($clients as $row_clients){
                                                $selected = (set_value('clients_id') == $row_clients->id ? 'selected' : '');
                                                echo '<option value="'.$row_clients->id.'" '.$selected.'>'.$row_clients->nama.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php echo form_error('clients_id', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="nama_lengkap">
                                    Nama Lengkap
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo set_value('nama_lengkap');?>">
                                    <?php echo form_error('nama_lengkap', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="no_hp">
                                    Nomor HP
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="number" class="form-control" id="no_hp" name="no_hp" value="<?php echo set_value('no_hp');?>">
                                    <?php echo form_error('no_hp', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="email">
                                    Email
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email');?>">
                                    <?php echo form_error('email', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="permainans_id">
                                    Nama Permainan
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <select name="permainans_id" class="form-control">
                                        <option value="">- Pilih Permainan -</option>
                                        <?php
                                        if($permainans){
                                            foreach($permainans as $row_permainans){
                                                $selected = (set_value('permainans_id') == $row_permainans->id ? 'selected' : '');
                                                echo '<option value="'.$row_permainans->id.'" '.$selected.'>'.$row_permainans->nama_permainan.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php echo form_error('permainans_id', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="banks_id">
                                    Nama Bank
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <select name="banks_id" class="form-control">
                                        <option value="">- Pilih Bank -</option>
                                        <?php
                                        if($banks){
                                            foreach($banks as $row_banks){
                                                $selected = (set_value('banks_id') == $row_banks->id ? 'selected' : '');
                                                echo '<option value="'.$row_banks->id.'" '.$selected.'>'.$row_banks->nama_bank.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php echo form_error('banks_id', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="nomor_rekening_bank">
                                    Nomor Rekening Bank
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="number" class="form-control" id="nomor_rekening_bank" name="nomor_rekening_bank" value="<?php echo set_value('nomor_rekening_bank');?>">
                                    <?php echo form_error('nomor_rekening_bank', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="nama_rekening_bank">
                                    Nama Rekening Bank
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" id="nama_rekening_bank" name="nama_rekening_bank" value="<?php echo set_value('nama_rekening_bank');?>">
                                    <?php echo form_error('nama_rekening_bank', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="nomor_referral">
                                    Nomor Referral
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" id="nomor_referral" name="nomor_referral" value="<?php echo set_value('nomor_referral');?>">
                                    <?php echo form_error('nomor_referral', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9 col-sm-9">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                    <a href="<?php echo base_url('backoffice/registers');?>" class="btn btn-secondary">
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