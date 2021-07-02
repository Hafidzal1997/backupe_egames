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
                <div class="form-group row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <?php
                        if($edit->foto && file_exists('./uploads/foto/' . $edit->foto)){
                            $avatar = base_url('uploads/foto/' . $edit->foto);
                        } else {
                            $avatar = base_url('assets/backoffice/assets/images/default.png');
                        }
                        ?>
                        <img src="<?php echo $avatar;?>" alt="<?php echo $edit->nama;?>" class="img-thumbnail" style="max-width: 240px;">
                    </div>
                </div>    
                <div class="form-group row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <h4>
                            <?php echo $edit->nama;?>
                        </h4>
                    </div>
                </div>  
                <div class="form-group row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <h6>
                            <?php echo $edit->email;?>
                        </h6>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <a class="btn btn-dark" href="<?php echo base_url('backoffice/profiles/edit');?>" title="KLIK DISINI UNTUK MENGUBAH PROFIL ANDA">
                            <i class="fa fa-edit"></i> Ubah Profil
                        </a>
                        <a class="btn btn-dark" href="<?php echo base_url('backoffice/profiles/edit-password');?>" title="KLIK DISINI UNTUK MENGUBAH PASSWORD ANDA">
                            <i class="fa fa-key"></i> Ubah Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
