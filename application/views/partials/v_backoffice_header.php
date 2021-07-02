<?php
$ses_foto = $this->session->userdata('foto');
if($ses_foto && file_exists('./uploads/foto/' . $ses_foto)){
    $avatar = base_url('uploads/foto/' . $ses_foto);
} else {
    $avatar = base_url('assets/backoffice/assets/images/default.png');
}
?>
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $avatar;?>" alt=""><?php echo $this->session->userdata('nama');?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('backoffice/profiles');?>">
                            Profil Saya
                        </a>
                        <a class="dropdown-item" href="<?php echo base_url('backoffice/profiles/edit-password');?>">
                            Ubah Password
                        </a>
                        <a class="dropdown-item btn-logout" href="javascript:void(0)">
                            <i class="fa fa-sign-out pull-right"></i> Log Out
                        </a>
                    </div>
                </li>
                <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green badge-notif-topbar"><?php echo notifikasi_belum_dibaca();?></span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                        
                        <?php echo notif_top_panel(); ?>

                        <li class="nav-item nav-item-footer">
                            <div class="text-center">
                                <a class="dropdown-item" href="<?php echo base_url('backoffice/dashboard/notifikasi');?>">
                                    <strong>Lihat Semua Notifikasi</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>