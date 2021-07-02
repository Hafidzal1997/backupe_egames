<?php
$url_detail = base_url('backoffice/transaksi-withdraws/detail/' . encode($edit->id));
if($edit->flag_status == 'A'){
    $flag_status = '<div class="text-left text-success font-weight-bold">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                        ACCEPTED
                        <br>
                        <small>
                            '.date('d M Y', strtotime($edit->accepted_at)).'
                            <br>
                            '.date('H:i:s', strtotime($edit->accepted_at)).'
                        </small>
                    </div>';
} else if($edit->flag_status == 'W'){
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
                            '.date('d M Y', strtotime($edit->rejected_at)).'
                            <br>
                            '.date('H:i:s', strtotime($edit->rejected_at)).'
                        </small>
                    </div>';
}
echo '
    <li id="Withdraw_'. $edit->id.'">
        <div class="block">
            <div class="block_content">
                <h2 class="title">
                    <a>
                        Withdraw dengan '.($edit->kode_member ? ' kode member <strong class="text-dark btn-detail-notifikasi" data-url="'.$url_detail.'" style="cursor:pointer;text-decoration:underline;">'.$edit->kode_member.'</strong>' : ' nama <strong class="text-dark btn-detail-notifikasi" data-url="'.$url_detail.'" style="cursor:pointer;text-decoration:underline;">'.$edit->nama_lengkap .'</strong>').'
                    </a>
                </h2>
                <div class="byline">
                    <span>Disubmit </span> pada <strong class="text-success">'.($edit->created_at ? date('d M Y, H:i:s', strtotime($edit->created_at)) : '-').'</strong>
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
?>