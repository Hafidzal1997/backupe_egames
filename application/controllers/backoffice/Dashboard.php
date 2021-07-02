<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(!$this->session->userdata('roles_id')){
            redirect('auth/login');
        }

        $this->load->model(array('M_members', 'M_deposits', 'M_withdraws', 'M_notifikasi', 'M_clients'));
        $this->load->library(array('pagination'));

        $this->roles_id = $this->session->userdata('roles_id');
        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/dashboard/';
    }

    function index()
    {
        $data = array(
                    'clients'       => $this->M_clients->get_all_clients(),
                    'title'         => 'Dashboard',
                    'contents'      => $this->contents . 'v_index',
                );

        $this->load->view($this->layouts, $data);
    }

    function notifikasi(){
        
        $this->M_notifikasi->update_notifikasi_sudah_dibaca();

        $config['base_url']         = base_url('backoffice/dashboard/notifikasi');
        $config['total_rows']       = $this->M_notifikasi->get_total_notifikasi();
        $config['per_page']         = 25;
        $config["uri_segment"]      = 4;
        $config["num_links"]        = floor($config["total_rows"] / $config["per_page"]);
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4) ? $this->uri->segment(4)  : 0);

        $data = array(
                    'nomor'         => $page,
                    'notifikasi'    => $this->M_notifikasi->get_pagination_notifikasi($config["per_page"], $page),
                    'pagination'    => $this->pagination->create_links(),
                    'title'         => 'Notifikasi',
                    'contents'      => $this->contents . 'v_notifikasi',
                );

        $this->load->view($this->layouts, $data);
    }

    function ajax_notifikasi_sidebar(){
        (!$this->input->is_ajax_request() ? show_404() : '');

        $notif_waiting_registers            = notif_waiting_registers();
        $notif_waiting_deposits             = notif_waiting_deposits();
        $notif_waiting_withdraws            = notif_waiting_withdraws();
        $notif_waiting_deposits_hari_ini    = notif_waiting_deposits_hari_ini();
        $notif_waiting_withdraws_hari_ini   = notif_waiting_withdraws_hari_ini();

        $response = array(
                        'success'                           => true,
                        'notif_waiting_registers'           => $notif_waiting_registers,
                        'notif_waiting_deposits'            => $notif_waiting_deposits,
                        'notif_waiting_withdraws'           => $notif_waiting_withdraws,
                        'notif_waiting_deposits_hari_ini'   => $notif_waiting_deposits_hari_ini,
                        'notif_waiting_withdraws_hari_ini'  => $notif_waiting_withdraws_hari_ini,
                    );
        echo json_encode($response);
    }

    function ajax_notifikasi_topbar(){
        (!$this->input->is_ajax_request() ? show_404() : '');

        $notifikasi_belum_dibaca =  notifikasi_belum_dibaca();

        echo $notifikasi_belum_dibaca;
    }

    function ajax_notifikasi_topbar_panel(){
        (!$this->input->is_ajax_request() ? show_404() : '');

        $notif_top_panel =  notif_top_panel();

        echo $notif_top_panel;
    }

    function notifikasi_after_submit(){
        (!$this->input->is_ajax_request() ? show_404() : '');

        $current_datetime   = date('Y-m-d H:i:s');
        $mulai              = date('Y-m-d H:i:s', strtotime('-15 seconds',strtotime($current_datetime)));
        $selesai            = date('Y-m-d H:i:s', strtotime('+5 seconds',strtotime($current_datetime)));

        $eforms     = $this->M_notifikasi->get_notifikasi_after_submit($mulai, $selesai);
        $response   = array();
        if($eforms){
            $response['status'] = TRUE;
            $notifikasi = array();
            foreach($eforms as $row){

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
                
                $title      = 'New '.$row->tipe;
                $text       = '<div class="btn-detail-notifikasi" data-url="'.$url_detail.'" style="cursor:pointer;margin-top:-20px;">
                                    '.$row->tipe.' telah disubmit dengan '.($row->kode_member ? ' kode member <strong class="text-white" style="text-decoration:underline;">'.$row->kode_member.'</strong>' : ' nama <strong class="text-white" style="text-decoration:underline;">'.$row->nama_lengkap .'</strong>').'
                                </div>
                                ';

                $data = array();
                $data['title'] = $title;
                $data['text'] = $text;

                $notifikasi[] = $data;
            }
            $response['data'] = $notifikasi;
        } else {
            $response['status'] = FALSE;
        }

        echo json_encode($response);
    }

    function ajax_summary_dashboard(){
        $filter_tanggal             = $this->input->post('filter_tanggal');
        $tanggal_awal               = $this->input->post('tanggal_awal');
        $tanggal_akhir              = $this->input->post('tanggal_akhir');
        $clients_id                 = $this->input->post('clients_id');

        $tanggal_awal               = str_replace('/', '-', $tanggal_awal);
        $tanggal_akhir              = str_replace('/', '-', $tanggal_akhir);

        $tanggal_awal               = date('Y-m-d', strtotime($tanggal_awal));
        $tanggal_akhir              = date('Y-m-d', strtotime($tanggal_akhir));

        $total_member_disetujui     = $this->M_members->get_total_all_members_accepted_summary_dashboard($clients_id, $filter_tanggal, $tanggal_awal, $tanggal_akhir);
        $total_withdraw_disetujui   = $this->M_withdraws->get_total_all_withdraws_accepted_summary_dashboard($clients_id, $filter_tanggal, $tanggal_awal, $tanggal_akhir);
        $total_deposit_disetujui    = $this->M_deposits->get_total_all_deposits_accepted_summary_dashboard($clients_id, $filter_tanggal, $tanggal_awal, $tanggal_akhir);
        $total_member_terdaftar     = $this->M_members->get_total_all_members_summay_dashboard($clients_id, $filter_tanggal, $tanggal_awal, $tanggal_akhir);

        $response = array(
                'status'                    => true,
                'total_member_disetujui'    => $total_member_disetujui,
                'total_withdraw_disetujui'  => $total_withdraw_disetujui,
                'total_deposit_disetujui'   => $total_deposit_disetujui,
                'total_member_terdaftar'    => $total_member_terdaftar,
            );

        echo json_encode($response);
    }
}
