<h4 class="pb-3 bg-info py-3">
    <?php echo $title;?>
</h4>
<div class="py-2 text-white mb-3 font-weight-bold text-left" style="font-size: 12px;">
    Mohon Anda mengisi data dengan benar untuk memudahkan kami mengecek form withdraw yang Anda kirim.
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
        <label class="font-weight-bold" for="kode_member">
            Kode Member <span style="color:red;">*</span>
        </label>
        <div>
            <input type="text" class="form-control" value="<?php echo set_value('kode_member');?>" name="kode_member" id="kode_member" autocomplete="off" required>
            <?php echo form_error('kode_member', '<strong class="text-danger">', '</strong>');?>
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
            <input type="number" class="form-control" value="<?php echo set_value('nomor_rekening_bank');?>" name="nomor_rekening_bank" id="nomor_rekening_bank" autocomplete="off" required>
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
        <label class="font-weight-bold" for="jumlah_withdraw">
            Jumlah Withdraw <span style="color:red;">*</span> 
            <small><br>(Misalnya: 100000) </small>
        </label>
        <div>
            <input type="number" class="form-control" value="<?php echo set_value('jumlah_withdraw');?>" name="jumlah_withdraw" id="jumlah_withdraw" autocomplete="off" required>
            <?php echo form_error('jumlah_withdraw', '<strong class="text-danger">', '</strong>');?>
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
    <div class="form-group">
        <button class="btn btn-info btn-block" id="btn-submit" type="submit" name="submit" value="submit">
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
            url:"<?php echo base_url('sites/ajax-withdraw-captcha-code');?>",
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