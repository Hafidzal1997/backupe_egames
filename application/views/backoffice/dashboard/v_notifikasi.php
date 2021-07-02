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
                <div class="dashboard-widget-content">
                    <ul class="list-unstyled timeline widget">
                        <?php
                        if($notifikasi){
                            foreach($notifikasi as $row){
                                if($row->flag_status == 'A'){
                                    $flag_status = '<div class="text-left text-success font-weight-bold">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                        </div>
                                                        ACCEPTED
                                                        <br>
                                                        <small>
                                                            '.date('d M Y', strtotime($row->accepted_at)).'
                                                            <br>
                                                            '.date('H:i:s', strtotime($row->accepted_at)).'
                                                        </small>
                                                    </div>';
                                } else if($row->flag_status == 'W'){
                                    $flag_status = '<div class="text-left text-warning font-weight-bold">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                        </div>
                                                        WAITING
                                                    </div>';
                                } else {
                                    $flag_status = '<div class="text-left text-danger font-weight-bold">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                        </div>
                                                        REJECTED
                                                        <br>
                                                        <small>
                                                            '.date('d M Y', strtotime($row->rejected_at)).'
                                                            <br>
                                                            '.date('H:i:s', strtotime($row->rejected_at)).'
                                                        </small>
                                                    </div>';
                                }
                                $nomor++;

                                $created_at = $row->created_at;
                                $created_at = date('Y-m-d', strtotime($created_at));
                                $curr_date  = date('Y-m-d');

                                if($row->tipe == 'Register'){
                                    
                                    $url_detail = base_url('backoffice/registers/detail/' . encode($row->id));

                                } else if($row->tipe == 'Deposit' && $created_at == $curr_date){

                                    $url_detail = base_url('backoffice/deposits/detail/' . encode($row->id));

                                } else if($row->tipe == 'Deposit'){

                                    $url_detail = base_url('backoffice/transaksi-deposits/detail/' . encode($row->id));

                                } else if($row->tipe == 'Withdraw' && $created_at == $curr_date){

                                    $url_detail = base_url('backoffice/withdraws/detail/' . encode($row->id));

                                } else {

                                    $url_detail = base_url('backoffice/transaksi-withdraws/detail/' . encode($row->id));
                                    
                                }

                                echo '
                                    <li id="'. $row->tipe .'_'. $row->id.'">
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>
                                                        '.$row->tipe.' dengan '.($row->kode_member ? ' kode member <strong class="text-dark btn-detail-notifikasi" data-url="'.$url_detail.'" style="cursor:pointer;text-decoration:underline;">'.$row->kode_member.'</strong>' : ' nama <strong class="text-dark btn-detail-notifikasi" data-url="'.$url_detail.'" style="cursor:pointer;text-decoration:underline;">'.$row->nama_lengkap .'</strong>').'
                                                    </a>
                                                </h2>
                                                <div class="byline">
                                                    <span>Disubmit </span> pada <strong class="text-success">'.($row->created_at ? date('d M Y, H:i:s', strtotime($row->created_at)) : '-').'</strong>
                                                </div>
                                                <p class="excerpt">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            '.$flag_status.'
                                                        </div>
                                                    </div>      
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    ';
                            }
                        } else {
                            echo '<center><i class="fa fa-smile-o fa-5x mb-2"></i><br>Tidak ada notifikasi</center>';
                        }
                        ?>
                    </ul>
                </div>          
                <div class="text-center">
                    <?php echo $pagination;?>
                </div>
            </div>
        </div>
    </div>
</div>