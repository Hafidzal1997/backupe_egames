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
                                <label class="control-label col-md-3" for="kode_member">
                                    Kode Member
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" id="kode_member" name="kode_member" value="<?php echo (set_value('kode_member') ? set_value('kode_member') : $edit->kode_member);?>">
                                    <?php echo form_error('kode_member', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>                            
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="jumlah_withdraw">
                                    Jumlah Withdraw
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" id="jumlah_withdraw" name="jumlah_withdraw" value="<?php echo (set_value('jumlah_withdraw') ? set_value('jumlah_withdraw') : $edit->jumlah_withdraw);?>">
                                    <input type="hidden" name="id" value="<?php echo encode($edit->id);?>">
                                    <?php echo form_error('jumlah_withdraw', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="permainans_id">
                                    Nama Permainan
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <select name="permainans_id" class="form-control">
                                        <option value="">- Pilih Nama Permainan -</option>
                                        <?php
                                        if($permainans){
                                            foreach($permainans as $row_permainans){
                                                $selected = ((set_value('permainans_id') ? set_value('permainans_id') : $edit->permainans_id) == $row_permainans->id ? 'selected' : '');
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
                                        <option value="">- Pilih Nama Bank -</option>
                                        <?php
                                        if($banks){
                                            foreach($banks as $row_banks){
                                                $selected = ((set_value('banks_id') ? set_value('banks_id') : $edit->banks_id) == $row_banks->id ? 'selected' : '');
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
                                    <input type="number" class="form-control" id="nomor_rekening_bank" name="nomor_rekening_bank" value="<?php echo (set_value('nomor_rekening_bank') ? set_value('nomor_rekening_bank') : $edit->nomor_rekening_bank);?>">
                                    <?php echo form_error('nomor_rekening_bank', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3" for="nama_rekening_bank">
                                    Nama Rekening Bank
                                </label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" id="nama_rekening_bank" name="nama_rekening_bank" value="<?php echo (set_value('nama_rekening_bank') ? set_value('nama_rekening_bank') : $edit->nama_rekening_bank);?>">
                                    <?php echo form_error('nama_rekening_bank', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9 col-sm-9">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                    <a href="<?php echo base_url('backoffice/withdraws');?>" class="btn btn-secondary">
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