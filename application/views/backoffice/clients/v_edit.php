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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-dark">
                                        <strong><i class="fa fa-info-circle mr-2"></i> Informasi Umum Client</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Nama Client</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" name="nama" value="<?php echo (set_value('nama') ? set_value('nama') : $edit->nama);?>">
                                    <?php echo form_error('nama', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Alamat</label>
                                <div class="col-md-9 col-sm-9">
                                    <textarea name="alamat" class="form-control" rows="4"><?php echo (set_value('alamat') ? set_value('alamat') : $edit->alamat);?></textarea>
                                    <?php echo form_error('alamat', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="email" class="form-control" name="email" value="<?php echo (set_value('email') ? set_value('email') : $edit->email);?>">
                                    <?php echo form_error('email', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">No. Telepon</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="number" class="form-control" name="nomor_telepon" value="<?php echo (set_value('nomor_telepon') ? set_value('nomor_telepon') : $edit->nomor_telepon);?>">
                                    <?php echo form_error('nomor_telepon', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">No. Telepon 2</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="number" class="form-control" name="nomor_telepon2" value="<?php echo (set_value('nomor_telepon2') ? set_value('nomor_telepon2') : $edit->nomor_telepon2);?>">
                                    <?php echo form_error('nomor_telepon2', '<span class="text-danger">', '</span>');?>
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
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-dark">
                                        <strong><i class="fa fa-user mr-2"></i> Informasi PIC Client</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Nama PIC</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="text" class="form-control" name="nama_pic" value="<?php echo (set_value('nama_pic') ? set_value('nama_pic') : $edit->nama_pic);?>">
                                    <?php echo form_error('nama_pic', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">Email PIC</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="email" class="form-control" name="email_pic" value="<?php echo (set_value('email_pic') ? set_value('email_pic') : $edit->email_pic);?>">
                                    <?php echo form_error('email_pic', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3">No. HP/Telepon PIC</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="number" class="form-control" name="nomor_hp_pic" value="<?php echo (set_value('nomor_hp_pic') ? set_value('nomor_hp_pic') : $edit->nomor_hp_pic);?>">
                                    <?php echo form_error('nomor_hp_pic', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-dark">
                                        <strong><i class="fa fa-cogs mr-2"></i> Pengaturan Link Form</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3 font-weight-bold" for="link_register_temp">
                                    Link Form Register
                                </label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="link_form_register_temp" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" id="btn_link_form_register">
                                                Generate Ulang Link
                                            </button>
                                            <a style="display: none;" class="btn btn-secondary" href="" id="link_form_register_url" title="Lihat Form" target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <small class="text-info font-weight-bold">SETELAH GENERATE ULANG, PASTIKAN ANDA HARUS MENYIMPAN DENGAN MENEKAN TOMBOL SIMPAN</small>

                                    <input type="hidden" id="link_form_register" name="link_form_register" value="<?php echo (set_value('link_form_register') ? set_value('link_form_register') : $edit->link_form_register);?>">
                                </div>
                            </div>
                            <div class="form-group row  mt-5 ">
                                <label class="control-label col-md-3 font-weight-bold" for="link_redirect_register">Redirect Link Setelah Submit</label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Masukkan LINK/URL" class="form-control" id="link_redirect_register" name="link_redirect_register" value="<?php echo (set_value('link_redirect_register') ? set_value('link_redirect_register') : $edit->link_redirect_register);?>">
                                    <small class="text-info font-weight-bold">KOSONGKAN, JIKA FORM TIDAK INGIN DI ALIHKAN/REDIRECT SETELAH SUBMIT</small>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group row ">
                                <label class="control-label col-md-3 font-weight-bold" for="link_form_deposit_temp">
                                    Link Form Deposit
                                </label>
                                <div class="col-md-9">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="link_form_deposit_temp" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" id="btn_link_form_deposit">
                                                Generate Ulang Link
                                            </button>
                                            <a  style="display: none;" class="btn btn-secondary" href="" id="link_form_deposit_url" title="Lihat Form" target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <small class="text-info font-weight-bold">SETELAH GENERATE ULANG, PASTIKAN ANDA HARUS MENYIMPAN DENGAN MENEKAN TOMBOL SIMPAN</small>

                                    <input type="hidden" id="link_form_deposit" name="link_form_deposit" value="<?php echo (set_value('link_form_deposit') ? set_value('link_form_deposit') : $edit->link_form_deposit);?>">
                                </div>
                            </div>
                            <div class="form-group row  mt-5 ">
                                <label class="control-label col-md-3 font-weight-bold" for="link_redirect_deposit">Redirect Link Setelah Submit</label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Masukkan LINK/URL" class="form-control" id="link_redirect_deposit" name="link_redirect_deposit" value="<?php echo (set_value('link_redirect_deposit') ? set_value('link_redirect_deposit') : $edit->link_redirect_deposit);?>">
                                    <small class="text-info font-weight-bold">KOSONGKAN, JIKA FORM TIDAK INGIN DI ALIHKAN/REDIRECT SETELAH SUBMIT</small>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group row ">
                                <label class="control-label col-md-3 font-weight-bold" for="link_form_withdraw_temp">
                                    Link Form Withdraw
                                </label>
                                <div class="col-md-9">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="link_form_withdraw_temp" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" id="btn_link_form_withdraw">
                                                Generate Ulang Link
                                            </button>
                                            <a style="display: none;" class="btn btn-secondary" href="" id="link_form_withdraw_url" title="Lihat Form" target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <small class="text-info font-weight-bold">SETELAH GENERATE ULANG, PASTIKAN ANDA HARUS MENYIMPAN DENGAN MENEKAN TOMBOL SIMPAN</small>

                                    <input type="hidden" id="link_form_withdraw" name="link_form_withdraw" value="<?php echo (set_value('link_form_withdraw') ? set_value('link_form_withdraw') : $edit->link_form_withdraw);?>">
                                </div>
                            </div>

                            <div class="form-group row mt-5 ">
                                <label class="control-label col-md-3 font-weight-bold" for="link_redirect_withdraw">Redirect Link Setelah Submit</label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Masukkan LINK/URL" class="form-control" id="link_redirect_withdraw" name="link_redirect_withdraw" value="<?php echo (set_value('link_redirect_withdraw') ? set_value('link_redirect_withdraw') : $edit->link_redirect_withdraw);?>">
                                    <small class="text-info font-weight-bold">KOSONGKAN, JIKA FORM TIDAK INGIN DI ALIHKAN/REDIRECT SETELAH SUBMIT</small>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-dark">
                                        <strong><i class="fa fa-cogs mr-2"></i> Pengaturan Kode Member</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3 font-weight-bold" for="kode_member_last">Kode Member Terakhir</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="kode_member_last" name="kode_member_last" value="<?php echo (set_value('kode_member_last') ? set_value('kode_member_last') : $edit->kode_member_last);?>" disabled>
                                    <?php echo form_error('kode_member_last', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row ">
                                <label class="control-label col-md-3 font-weight-bold" for="kode_member_prefixs">Prefix Kode Member</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="kode_member_prefixs" name="kode_member_prefixs" value="<?php echo (set_value('kode_member_prefixs') ? set_value('kode_member_prefixs') : $edit->kode_member_prefixs);?>" onkeyup="generate_kode_member()" onchange="generate_kode_member()">
                                    <?php echo form_error('kode_member_prefixs', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="control-label col-md-3 font-weight-bold" for="kode_member_number_digits">Jumlah Digit Counter Kode Member</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" id="kode_member_number_digits" name="kode_member_number_digits" value="<?php echo (set_value('kode_member_number_digits') ? set_value('kode_member_number_digits') : $edit->kode_member_number_digits);?>" min="0" onkeyup="generate_kode_member()" onchange="generate_kode_member()">
                                    <?php echo form_error('kode_member_number_digits', '<span class="text-danger">', '</span>');?>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row ">
                                <label class="control-label col-md-3 font-weight-bold">Preview Generate Kode Member</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="kode_member" readonly="">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row ">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9 col-sm-9">
                                    <button type="submit" class="btn btn-success btn-submit">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                    <a href="<?php echo base_url('backoffice/clients');?>" class="btn btn-secondary btn-submit">
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

<script>
    function generate_kode_member(){
        var kode = $("#kode_member_prefixs").val();
        var digits = parseInt($("#kode_member_number_digits").val());

        for(var i = 0; i < (digits - 1); i++){
            kode = kode + "0";
        }

        if(digits){
            kode += "1";
        }

        $("#kode_member").val(kode);
    }
    generate_kode_member();

    var preventClose = 0;
    var preventCloseMessage = "ANDA TIDAK MENYIMPAN PERUBAHAN DATA";

    $(".form-control").on('keyup click', function() {
        contentChanged(true);
    });

    $("input, textarea, select").change(function() {
        contentChanged(true);
    });

    $(".btn-submit").on('click', function() {
        contentChanged(false);
    });

    function contentChanged(status){
        if (status == true){
            preventClose = 1;
        } else {
            preventClose = 0;
        }
    }

    window.onbeforeunload = function (e) {
        e = e || window.event;

        if(preventClose == 1){
            if (e) {
                e.returnValue = preventCloseMessage;
            }
            return preventCloseMessage;
        } else {
            return null;
        }
    };

    var link_url_form = "<?php echo base_url('sites/');?>";

    var link_form_register = link_url_form + $("#link_form_register").val();
    $("#link_form_register_temp").val(link_form_register);
    $("a#link_form_register_url").attr("href", link_form_register);

    var link_form_withdraw = link_url_form + $("#link_form_withdraw").val();
    $("#link_form_withdraw_temp").val(link_form_withdraw);
    $("a#link_form_withdraw_url").attr("href", link_form_withdraw);

    var link_form_deposit = link_url_form + $("#link_form_deposit").val();
    $("#link_form_deposit_temp").val(link_form_deposit);
    $("a#link_form_deposit_url").attr("href", link_form_deposit);

    $("#btn_link_form_register").on('click', function() {
        $("#btn_link_form_register").attr('disabled', true);
        $("#link_form_register_url").attr('disabled', true);
        $("a#link_form_register_url").attr("href", "javascript:;");

        $.ajax({
            url : "<?php echo base_url('backoffice/clients/generate-link');?>",
            type: 'GET',
            dataType: "JSON",
            success: function(response){
                if(response.status){
                    var link= response.link
                    var url = link_url_form + link;

                    $("#link_form_register_temp").val(url);
                    $("#link_form_register").val(link);

                    $("#btn_link_form_register").attr('disabled', false);
                    $("#link_form_register_url").attr('disabled', false);
                    $("a#link_form_register_url").attr("href", url);
                } else {
                    Swal.fire('Error!','Please Contact Administrator!', 'warning');

                    $("#btn_link_form_register").attr('disabled', false);
                    $("#link_form_register_url").attr('disabled', false);
                    $("a#link_form_register_url").attr("href", "javascript:;");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!',errorThrown, 'warning');
                $("#btn_link_form_register").attr('disabled', false);
                $("#link_form_register_url").attr('disabled', false);
                $("a#link_form_register_url").attr("href", "javascript:;");
            }
        });
    });

    $("#btn_link_form_withdraw").on('click', function() {
        $("#btn_link_form_withdraw").attr('disabled', true);
        $("#link_form_withdraw_url").attr('disabled', true);
        $("a#link_form_withdraw_url").attr("href", "javascript:;");

        $.ajax({
            url : "<?php echo base_url('backoffice/clients/generate-link');?>",
            type: 'GET',
            dataType: "JSON",
            success: function(response){
                if(response.status){
                    var link= response.link
                    var url = link_url_form + link;

                    $("#link_form_withdraw_temp").val(url);
                    $("#link_form_withdraw").val(link);

                    $("#btn_link_form_withdraw").attr('disabled', false);
                    $("#link_form_withdraw_url").attr('disabled', false);
                    $("a#link_form_withdraw_url").attr("href", url);
                } else {
                    Swal.fire('Error!','Please Contact Administrator!', 'warning');

                    $("#btn_link_form_withdraw").attr('disabled', false);
                    $("#link_form_withdraw_url").attr('disabled', false);
                    $("a#link_form_withdraw_url").attr("href", "javascript:;");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!',errorThrown, 'warning');
                $("#btn_link_form_withdraw").attr('disabled', false);
                $("#link_form_withdraw_url").attr('disabled', false);
                $("a#link_form_withdraw_url").attr("href", "javascript:;");
            }
        });
    });

    $("#btn_link_form_deposit").on('click', function() {
        $("#btn_link_form_deposit").attr('disabled', true);
        $("#link_form_deposit_url").attr('disabled', true);
        $("a#link_form_deposit_url").attr("href", "javascript:;");

        $.ajax({
            url : "<?php echo base_url('backoffice/clients/generate-link');?>",
            type: 'GET',
            dataType: "JSON",
            success: function(response){
                if(response.status){
                    var link= response.link
                    var url = link_url_form + link;

                    $("#link_form_deposit_temp").val(url);
                    $("#link_form_deposit").val(link);

                    $("#btn_link_form_deposit").attr('disabled', false);
                    $("#link_form_deposit_url").attr('disabled', false);
                    $("a#link_form_deposit_url").attr("href", url);
                } else {
                    Swal.fire('Error!','Please Contact Administrator!', 'warning');

                    $("#btn_link_form_deposit").attr('disabled', false);
                    $("#link_form_deposit_url").attr('disabled', false);
                    $("a#link_form_deposit_url").attr("href", "javascript:;");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!',errorThrown, 'warning');
                $("#btn_link_form_deposit").attr('disabled', false);
                $("#link_form_deposit_url").attr('disabled', false);
                $("a#link_form_deposit_url").attr("href", "javascript:;");
            }
        });
    });
</script>