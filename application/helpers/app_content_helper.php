<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    if(!function_exists('encode')){        
        function encode($input) {
            return strtr(base64_encode($input), '+/=', '._-');
        }
    }

    if(!function_exists('decode')){        
        function decode($input) {
            return base64_decode(strtr($input, '._-', '+/='));
        }
    }

    if(!function_exists('encode_phone_number')){
        function encode_phone_number($phone_no, $total_hide = 3){
            $total_digit    = strlen($phone_no);
            $total_digit    = $total_digit - $total_hide;
            $split          = str_split($phone_no);
            $string         = "";

            for($i = 0; $i < $total_digit; $i++){
                $string .= $split[$i];
            }

            for($i = 0; $i < $total_hide; $i++){
                $string .= 'x';
            }
            return $string;
        }
    }

    if(!function_exists('encode_email')){        
        function encode_email($email, $total_hide = 3){
            $explode_email  = explode('@', $email);
            $username       = @$explode_email[0];
            $domain         = @$explode_email[1];

            $total_digit    = strlen($username);
            $total_digit    = $total_digit - $total_hide;
            $split          = str_split($username);
            $string         = "";

            for($i = 0; $i < $total_digit; $i++){
                $string .= $split[$i];
            }

            for($i = 0; $i < $total_hide; $i++){
                $string .= 'x';
            }

            $string .= '@' . $domain;
            return $string;
        }
    }

    if(!function_exists('notif_waiting_registers')){
        function notif_waiting_registers(){
            $CI=&get_instance();
            $CI->load->model('M_members');

            $total  = $CI->M_members->get_total_all_members_waiting();
            $result = ($total ? $total : '');
            
            return $result;
        }
    }

    if(!function_exists('notif_waiting_deposits')){
        function notif_waiting_deposits(){
            $CI=&get_instance();
            $CI->load->model('M_deposits');

            $total  = $CI->M_deposits->get_total_all_deposits_waiting();
            $result = ($total ? $total : '');
            
            return $result;
        }
    }

    if(!function_exists('notif_waiting_deposits_hari_ini')){
        function notif_waiting_deposits_hari_ini(){
            $CI=&get_instance();
            $CI->load->model('M_deposits');

            $total  = $CI->M_deposits->get_total_all_deposits_waiting_today();
            $result = ($total ? $total : '');
            
            return $result;
        }
    }

    if(!function_exists('notif_waiting_withdraws')){
        function notif_waiting_withdraws(){
            $CI=&get_instance();
            $CI->load->model('M_withdraws');

            $total  = $CI->M_withdraws->get_total_all_withdraws_waiting();
            $result = ($total ? $total : '');
            
            return $result;
        }
    }

    if(!function_exists('notif_waiting_withdraws_hari_ini')){
        function notif_waiting_withdraws_hari_ini(){
            $CI=&get_instance();
            $CI->load->model('M_withdraws');

            $total  = $CI->M_withdraws->get_total_all_withdraws_waiting_today();
            $result = ($total ? $total : '');
            
            return $result;
        }
    }

    if(!function_exists('notifikasi_belum_dibaca')){
        function notifikasi_belum_dibaca(){
            $CI=&get_instance();
            $CI->load->model('M_notifikasi');

            $total  = $CI->M_notifikasi->get_total_notifikasi_belum_dibaca();
            $result = ($total ? $total : '');
            
            return $result;
        }
    }

    if(!function_exists('notif_top_panel')){
        function notif_top_panel(){
            $CI=&get_instance();
            $CI->load->model('M_notifikasi');

            $notifikasi = $CI->M_notifikasi->get_last_notifikasi();
            $html       = '';

            if($notifikasi){
                foreach($notifikasi as $row){

                    if($row->tipe == 'Register'){
                        $url_detail = base_url('backoffice/registers/detail/' . encode($row->id));
                    } else if($row->tipe == 'Deposit'){
                        $url_detail = base_url('backoffice/deposits/detail/' . encode($row->id));
                    } else {
                        $url_detail = base_url('backoffice/withdraws/detail/' . encode($row->id));
                    }

                    $html .= '<li class="nav-item nav-item-remove btn-detail-notifikasi" data-url="'.$url_detail.'">
                                <a class="dropdown-item">
                                    <span class="image"><img src="'.base_url('assets/backoffice/assets/images/default.png').'" alt="Notifikasi" /></span>
                                    <span>
                                        <span>'.$row->tipe.'</span>
                                        <span class="time">'.date('d M Y, H:i:s', strtotime($row->created_at)).'</span>
                                    </span>
                                    <span class="message">
                                        '.$row->tipe.' telah disubmit dengan '.($row->kode_member ? ' kode member <strong class="text-dark" style="text-decoration:underline;">'.$row->kode_member.'</strong>' : ' nama <strong class="text-dark" style="text-decoration:underline;">'.$row->nama_lengkap .'</strong>').'
                                    </span>
                                </a>
                            </li>';
                }
            }

            return $html;
        }
    }