<?php
$ses_roles  = $this->session->userdata('roles_id');
$ses_foto   = $this->session->userdata('foto');
$ses_nama   = $this->session->userdata('nama');
$jam        = date('H');

if($ses_foto && file_exists('./uploads/foto/' . $ses_foto)){
    $avatar = base_url('uploads/foto/' . $ses_foto);
} else {
    $avatar = base_url('assets/backoffice/assets/images/default.png');
}

if($jam >= 18){
    $salam = 'Selamat Malam,';
} else if($jam >= 15){
    $salam = 'Selamat Sore,';
} else if($jam >= 11){
    $salam = 'Selamat Siang,';
} else {
    $salam = 'Selamat Pagi,';
}
?>

<div class="navbar nav_title" style="border: 0;">
    <a href="<?php echo base_url('backoffice/dashboard');?>" class="site_title">
        <i class="fa fa-gamepad"></i> <span>E-Games</span>
    </a>
</div>
<div class="clearfix"></div>

<div class="profile clearfix">
    <div class="profile_pic">
        <img src="<?php echo $avatar;?>" alt="<?php echo $ses_nama;?>" class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span><?php echo $salam; ?></span>
        <h2><?php echo $ses_nama;?></h2>
    </div>
</div>
<br />
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Navigation Menu</h3>
        <ul class="nav side-menu">

            <li class="<?php echo (in_array($this->uri->segment(2), array('', 'dashboard')) ? 'active' : '');?>">
                <a href="<?php echo base_url('backoffice/dashboard');?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>

            <?php if($ses_roles == 1){?>

                <li class="<?php echo (in_array($this->uri->segment(2), array('transaksi-deposits', 'transaksi-withdraws')) ? 'active' : '');?>">
                    <a>
                        <i class="fa fa-exchange"></i> Transaksi <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu" style="<?php echo (in_array($this->uri->segment(2), array('transaksi-deposits', 'transaksi-withdraws')) ? 'display:block;' : '');?>">
                        <li class="<?php echo (in_array($this->uri->segment(2), array('transaksi-deposits')) ? 'current-page' : '');?>">
                            <a href="<?php echo base_url('backoffice/transaksi-deposits');?>">
                                Deposit
                                <span class="badge badge-pill badge-warning pull-right notif-waiting-deposits" title="Waiting Confirmation"><?php echo notif_waiting_deposits();?></span>
                            </a>
                        </li>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('transaksi-withdraws')) ? 'current-page' : '');?>">
                            <a href="<?php echo base_url('backoffice/transaksi-withdraws');?>">
                                Withdraw
                                <span class="badge badge-pill badge-warning pull-right notif-waiting-withdraws" title="Waiting Confirmation"><?php echo notif_waiting_withdraws(); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'registers')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/registers');?>">
                        <i class="fa fa-users"></i> Register
                        <span class="badge badge-pill badge-warning pull-right notif-waiting-registers" title="Waiting Confirmation"><?php echo notif_waiting_registers(); ?></span>
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'deposits')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/deposits');?>">
                        <i class="fa fa-money"></i> Deposit
                        <span class="badge badge-pill badge-warning pull-right notif-waiting-deposits-hari-ini" title="Waiting Confirmation"><?php echo notif_waiting_deposits_hari_ini();?></span>
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'withdraws')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/withdraws');?>">
                        <i class="fa fa-money"></i> Withdraw
                        <span class="badge badge-pill badge-warning pull-right notif-waiting-withdraws-hari-ini" title="Waiting Confirmation"><?php echo notif_waiting_withdraws_hari_ini(); ?></span>
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'members')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/members');?>">
                        <i class="fa fa-user"></i> Member
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'Soal')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/Soal');?>">
                        <i class="fa fa-th-list"></i> Form
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'clients')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/clients');?>">
                        <i class="fa fa-institution"></i> Clients
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('permainans', 'permainans-categories')) ? 'active' : '');?>">
                    <a>
                        <i class="fa fa-gamepad"></i> Permainan <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu" style="<?php echo (in_array($this->uri->segment(2), array('permainans-categories', 'permainans')) ? 'display:block;' : '');?>">
                        <li class="<?php echo (in_array($this->uri->segment(2), array('permainans-categories')) ? 'current-page' : '');?>">
                            <a href="<?php echo base_url('backoffice/permainans-categories');?>">
                                Kategori Permainan
                            </a>
                        </li>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('permainans')) ? 'current-page' : '');?>">
                            <a href="<?php echo base_url('backoffice/permainans');?>">
                                Daftar Permainan
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'banks')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/banks');?>">
                        <i class="fa fa-bank"></i> Bank
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'users')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/users');?>">
                        <i class="fa fa-users"></i> User
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'roles')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/roles');?>">
                        <i class="fa fa-sitemap"></i> Role
                    </a>
                </li>
            <?php } else { ?>
                <li class="<?php echo (in_array($this->uri->segment(2), array('transaksi-deposits', 'transaksi-withdraws')) ? 'active' : '');?>">
                    <a>
                        <i class="fa fa-exchange"></i> Transaksi <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu" style="<?php echo (in_array($this->uri->segment(2), array('transaksi-deposits', 'transaksi-withdraws')) ? 'display:block;' : '');?>">
                        <li class="<?php echo (in_array($this->uri->segment(2), array('transaksi-deposits')) ? 'current-page' : '');?>">
                            <a href="<?php echo base_url('backoffice/transaksi-deposits');?>">
                                Deposit
                                <span class="badge badge-pill badge-warning pull-right notif-waiting-deposits" title="Waiting Confirmation"><?php echo notif_waiting_deposits();?></span>
                            </a>
                        </li>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('transaksi-withdraws')) ? 'current-page' : '');?>">
                            <a href="<?php echo base_url('backoffice/transaksi-withdraws');?>">
                                Withdraw
                                <span class="badge badge-pill badge-warning pull-right notif-waiting-withdraws" title="Waiting Confirmation"><?php echo notif_waiting_withdraws(); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'registers')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/registers');?>">
                        <i class="fa fa-users"></i> Register
                        <span class="badge badge-pill badge-warning pull-right notif-waiting-registers" title="Waiting Confirmation"><?php echo notif_waiting_registers(); ?></span>
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'deposits')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/deposits');?>">
                        <i class="fa fa-money"></i> Deposit
                        <span class="badge badge-pill badge-warning pull-right notif-waiting-deposits-hari-ini" title="Waiting Confirmation"><?php echo notif_waiting_deposits_hari_ini();?></span>
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'withdraws')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/withdraws');?>">
                        <i class="fa fa-money"></i> Withdraw
                        <span class="badge badge-pill badge-warning pull-right notif-waiting-withdraws-hari-ini" title="Waiting Confirmation"><?php echo notif_waiting_withdraws_hari_ini(); ?></span>
                    </a>
                </li>
                <li class="<?php echo (in_array($this->uri->segment(2), array('', 'members')) ? 'active' : '');?>">
                    <a href="<?php echo base_url('backoffice/members');?>">
                        <i class="fa fa-user"></i> Member
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>