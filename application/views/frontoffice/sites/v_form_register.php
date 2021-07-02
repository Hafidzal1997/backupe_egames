<h4 class="pb-3 bg-info py-3">
    <?php echo $title;?>
</h4>
<div class="py-2 text-white mb-3 font-weight-bold text-left" style="font-size: 12px;">
    Silahkan isi formulir pendaftaran berikut ini dengan lengkap dan benar !
</div>
<form action="<?php echo current_url();?>" method="post">
    <?php
    if($this->session->flashdata('success')){
        echo '<div class="form-group text-left">
                <div class="alert alert-success font-weight-bold">
                    <i class="fa fa-check"></i> '.$this->session->flashdata('success').'
                </div>
            </div>';
    }

    if($this->session->flashdata('danger')){
        echo '<div class="form-group text-left">
                <div class="alert alert-danger font-weight-bold">
                    <i class="fa fa-times"></i> '.$this->session->flashdata('danger').'
                </div>
            </div>';
    }
    ?>

    <div class="form-group text-left">
        <label class="font-weight-bold" for="nama_lengkap">
            Nama <span style="color:red;">*</span>
        </label>
        <div>
            <input type="text" class="form-control" value="<?php echo set_value('nama_lengkap');?>" name="nama_lengkap" id="nama_lengkap" autocomplete="off" required>
            <?php echo form_error('nama_lengkap', '<strong class="text-danger">', '</strong>');?>
        </div>        
    </div>
    <div class="form-group text-left">
        <label class="font-weight-bold" for="no_hp">
            Nomor HP / WA <span style="color:red;">*</span>
        </label>
        <div>
            <input type="number" class="form-control" value="<?php echo set_value('no_hp');?>" name="no_hp" id="no_hp" autocomplete="off" required>
            <?php echo form_error('no_hp', '<strong class="text-danger">', '</strong>');?>
        </div>        
    </div>
    <div class="form-group text-left">
        <label class="font-weight-bold" for="email">
            Email <span style="color:red;">*</span>
        </label>
        <div>
            <input type="email" class="form-control" value="<?php echo set_value('email');?>" name="email" id="email" autocomplete="off" required>
            <?php echo form_error('email', '<strong class="text-danger">', '</strong>');?>
        </div>        
    </div>
    <div class="form-group text-left">
        <label class="font-weight-bold" for="banks_id">
            Nama Bank <span style="color:red;">*</span>
        </label>
        <div>
            <select name="banks_id" class="form-control" id="banks_id" required>
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
            <?php echo form_error('banks_id', '<strong class="text-danger">', '</strong>');?>
        </div>        
    </div>
    <div class="form-group text-left">
        <label class="font-weight-bold" for="nomor_rekening_bank">
            Nomor Rekening <span style="color:red;">*</span>
        </label>
        <div>
            <input type="number" class="form-control" value="<?php echo set_value('nomor_rekening_bank');?>" name="nomor_rekening_bank" id="nomor_rekening_bank"  autocomplete="off" required>
            <?php echo form_error('nomor_rekening_bank', '<strong class="text-danger">', '</strong>');?>
        </div>        
    </div>
    <div class="form-group text-left">
        <label class="font-weight-bold" for="nama_rekening_bank">
            Nama Rekening <span style="color:red;">*</span>
        </label>
        <div>
            <input type="text" class="form-control" value="<?php echo set_value('nama_rekening_bank');?>" name="nama_rekening_bank" id="nama_rekening_bank" autocomplete="off" required>
            <?php echo form_error('nama_rekening_bank', '<strong class="text-danger">', '</strong>');?>
        </div>        
    </div>    
    <div class="form-group text-left">
        <label class="font-weight-bold" for="nomor_referral">
            Referral
        </label>
        <div>
            <input type="text" class="form-control" value="<?php echo set_value('nomor_referral');?>" name="nomor_referral" id="nomor_referral" autocomplete="off">
            <?php echo form_error('nomor_referral', '<strong class="text-danger">', '</strong>');?>
        </div>        
    </div>
    <div class="form-group text-left">
        <label class="font-weight-bold" for="permainans_id">
            Permainan <span style="color:red;">*</span>
        </label>
        <div>
            <select name="permainans_id" class="form-control" id="permainans_id" required>
                <option value="">- Pilih Permainan -</option>
                <?php
                if($permainans){
                    foreach($permainans as $row_permainans){
                        $selected = ((set_value('permainans_id') ? set_value('permainans_id') : $edit->permainans_id) == $row_permainans->id ? 'selected' : '');
                        echo '<option value="'.$row_permainans->id.'" '.$selected.'>'.$row_permainans->nama_permainan.'</option>';
                    }
                }
                ?>
            </select>
            <?php echo form_error('permainans_id', '<strong class="text-danger">', '</strong>');?>
        </div>        
    </div>
    <div class="form-group text-left">
        <label class="font-weight-bold" for="kode_captcha">
            Kode Captcha <span style="color:red;">*</span>
        </label>
        <div class="row">
            <div class="col-9">
                <div class="key-code">
                    <?php echo $captcha; ?>
                </div>
            </div>
            <div class="col-3">
                <div class="py-3">
                    <i title="KLIK DISINI UNTUK MENGUBAH KODE CAPTCHA" class="fa fa-refresh fa-2x request-code"  style="cursor:pointer;"></i>
                </div>
            </div>
        </div>
        <div>
            <input type="text" name="kode_captcha" id="kode_captcha" class="form-control" autocomplete="off" required>
            <?php echo form_error('kode_captcha', '<strong class="text-danger">', '</strong>');?>
        </div>
    </div>
    <div class="form-group text-left">
        <div class="form-check mb-2">
            <label class="form-check-label">
                <input value="1" type="checkbox" class="form-check-input" name="value" onchange="document.getElementById('btn-submit').disabled = !this.checked;">Saya telah berusia lebih dari 18 tahun, telah membaca, dan menerima syarat dan ketentuan yang dipasang di situs ini.
            </label>
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-info btn-block" id="btn-submit" type="submit" name="submit" value="submit" disabled>
            Submit
        </button>
    </div>
    <div class="clearfix"></div>
</form>
<script>
    $(".request-code").click(function(){
        $(".request-code").css({WebkitTransform:"rotate(340deg)"});
        $(".request-code").css({"-moz-transform":"rotate(340deg)"});
        $.ajax({
            url:"<?php echo base_url('sites/ajax-register-captcha-code');?>",
            type:"GET",
            success:function(reponse){
                $(".key-code").html(reponse);
                $(".request-code").css({WebkitTransform:"rotate(0deg)"});
                $(".request-code").css({"-moz-transform":"rotate(0deg)"});
            },error:function(e,t,o){
                console.log(t,o);
            }
        });
    });
</script>