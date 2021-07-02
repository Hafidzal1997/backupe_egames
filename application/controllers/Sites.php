<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends CI_Controller {

	function __construct(){
        parent::__construct();

        $this->load->helper(array('captcha'));
        $this->load->model(array('M_members', 'M_settings', 'M_banks', 'M_permainans', 'M_withdraws','M_deposits', 'M_clients'));
        $this->load->library(array('form_validation', 'upload'));

        $this->uploads_dir  = './uploads/eforms/';
        $this->layouts      = 'layouts/v_frontoffice';
        $this->contents     = 'frontoffice/sites/';
    }

    function index(){
        redirect('backoffice');
    }

    function form($param = null){
        ($param ? '' : show_404());

        $clients_1  = $this->M_clients->get_clients_by(array('link_form_register' => $param, 'flag_delete' => 'N', 'flag_active' => 'Y'))->row();
        $clients_2  = $this->M_clients->get_clients_by(array('link_form_deposit' => $param, 'flag_delete' => 'N', 'flag_active' => 'Y'))->row();
        $clients_3  = $this->M_clients->get_clients_by(array('link_form_withdraw' => $param, 'flag_delete' => 'N', 'flag_active' => 'Y'))->row();

        if($param == @$clients_1->link_form_register){
            
            $this->_form_register($clients_1);

        } else if($param == @$clients_2->link_form_deposit){


            
            $this->_form_deposit($clients_2);

        } else if($param == @$clients_3->link_form_withdraw){

            $this->_form_withdraw($clients_3);

        } else {
            show_404();
        }
    }

    /*
    | -------------------------------------------------------------------
    | FORM REGISTER
    | -------------------------------------------------------------------
    */
    function _form_register($clients){
        $link_redirect_register = @$clients->link_redirect_register;

        if($this->input->post('no_hp')){
            $this->form_validation->set_rules('no_hp', 'Nomor HP', 'trim|required|xss_clean');
        } else {
            $this->form_validation->set_rules('no_hp', 'Nomor HP', 'trim|required|xss_clean');
        }

        if($this->input->post('email')){
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        }

        if($this->input->post('kode_captcha')){
            $this->form_validation->set_rules('kode_captcha', 'Kode captcha', 'trim|required|xss_clean|callback__cek_kode_captcha_register');
        } else {
            $this->form_validation->set_rules('kode_captcha', 'Kode captcha', 'trim|required|xss_clean');
        }

        $this->form_validation->set_rules('nama_lengkap', 'Nama lengkap', 'trim|required|xss_clean');
        $this->form_validation->set_rules('permainans_id', 'Nama permainan', 'trim|required|xss_clean');
        $this->form_validation->set_rules('banks_id', 'Nama bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nomor_rekening_bank', 'Nomor rekening bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nama_rekening_bank', 'Nama rekening bank', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');
        $this->form_validation->set_message('is_unique', '{field} sudah tersedia!');
        $this->form_validation->set_message('valid_email', '{field} tidak valid!');

        if($this->form_validation->run() == FALSE){

            $captcha = $this->_generate_captcha_register();

            $data = array(
                        'banks'         => $this->M_banks->get_all_banks(),
                        'permainans'    => $this->M_permainans->get_all_permainans(),
                        'captcha'       => $captcha['image'],
                        'title'         => 'Formulir Pendaftaran',
                        'contents'      => $this->contents . 'v_form_register',
                    );
            $this->load->view($this->layouts, $data);
        } else {

            $this->_delete_captcha_register();

            $insert = array(
                'clients_id'            => @$clients->id,
                'nama_lengkap'          => $this->input->post('nama_lengkap'),
                'no_hp'                 => $this->input->post('no_hp'),
                'email'                 => $this->input->post('email'),
                'permainans_id'         => $this->input->post('permainans_id'),
                'banks_id'              => $this->input->post('banks_id'),
                'nomor_rekening_bank'   => $this->input->post('nomor_rekening_bank'),
                'nama_rekening_bank'    => $this->input->post('nama_rekening_bank'),
                'nomor_referral'        => $this->input->post('nomor_referral'),
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_members->add_members($insert);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disubmit!');

                redirect(current_url());
            } else {
                $this->db->trans_commit();   
                
                $this->session->set_flashdata('success', 'Data berhasil disubmit!');             
                
                if($link_redirect_register){
                    redirect($link_redirect_register);
                } else {
                    redirect(current_url());
                }
            }
        }
    }

    function _cek_no_hp(){
        $data = array(
                    'no_hp'         => $this->input->post('no_hp')
                    , 'flag_delete' => 'N'
                );
        $total = $this->M_members->get_members_by($data);
        
        if($total->num_rows() > 0){
            $this->form_validation->set_message('_cek_no_hp', 'Nomor HP sudah tersedia! Gunakan Nomor HP lain.');
            return false;
        } else {
            return true;
        }
    }

    function _cek_email(){
        $data = array(
                    'email'         => $this->input->post('email')
                    , 'flag_delete' => 'N'
                );
        $total = $this->M_members->get_members_by($data);
        
        if($total->num_rows() > 0){
            $this->form_validation->set_message('_cek_email', 'Email sudah tersedia! Gunakan Email lain.');
            return false;
        } else {
            return true;
        }
    }

    function _cek_kode_captcha_register(){
        $kode_captcha_input     = $this->input->post('kode_captcha');
        $kode_captcha_session   = @$this->session->userdata('captcha_register')['word'];
        
        if($kode_captcha_input == $kode_captcha_session){
            return true;
        } else {
            $this->form_validation->set_message('_cek_kode_captcha_register', 'Kode captcha salah!');
            return false;
        }
    }

    function _generate_captcha_register(){

        $this->_delete_captcha_register();
        
        $captcha_config = array(
            'font_path'     => APPPATH . "../assets/captcha/verdanab.ttf",
            'img_path'      => "./assets/captcha/",
            'img_url'       => base_url() . 'assets/captcha/',
            'img_width'     => 240,
            'img_height'    => 50,
            'word_length'   => 5,
            'font_size'     => 20,
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => array(
                                'background'=> array(255,255,255),
                                'border'    => array(255,255,255),
                                'text'      => array(0, 0, 0),
                                'grid'      => array(255,0,0)
                            )
        );

        $captcha = create_captcha($captcha_config);

        $this->session->unset_userdata('captcha_register');
        $this->session->set_userdata('captcha_register', $captcha);

        return $captcha;
    }

    function _delete_captcha_register(){
        $captcha_register = $this->session->userdata('captcha_register');
        if($captcha_register){

            $path = './assets/captcha/' . $captcha_register['time'] . '.jpg';

            if(is_file($path)){
                @unlink($path);
            }
        }
    }

    function ajax_register_captcha_code(){
        (!$this->input->is_ajax_request() ? show_404() : '');

        $captcha = $this->_generate_captcha_register();

        echo $captcha['image'];
    }

    /*
    | -------------------------------------------------------------------
    | FORM WITHDRAW
    | -------------------------------------------------------------------
    */
    function _form_withdraw($clients){
        $link_redirect_withdraw  = @$clients->link_redirect_withdraw;

        if($this->input->post('kode_member')){
            $this->form_validation->set_rules('kode_member', 'Kode member', 'trim|required|xss_clean');
        } else {
            $this->form_validation->set_rules('kode_member', 'Kode member', 'trim|required|xss_clean');
        }

        if($this->input->post('jumlah_withdraw')){
           $this->form_validation->set_rules('jumlah_withdraw', 'Jumlah withdraw', 'trim|required|xss_clean'); 
        } else {
            $this->form_validation->set_rules('jumlah_withdraw', 'Jumlah withdraw', 'trim|required|xss_clean'); 
        }
        
        $this->form_validation->set_rules('permainans_id', 'Nama permainan', 'trim|required|xss_clean');
        $this->form_validation->set_rules('banks_id', 'Nama bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nomor_rekening_bank', 'Nomor rekening bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nama_rekening_bank', 'Nama rekening bank', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');

        if($this->form_validation->run() == FALSE){
            
            $data = array(
                'banks'         => $this->M_banks->get_all_banks(),
                'permainans'    => $this->M_permainans->get_all_permainans(),
                'title'         => 'Formulir Withdraw',
                'contents'      => $this->contents . 'v_form_withdraw',
            );

            $this->load->view($this->layouts, $data);

        } else {

            $potongan_withdraw      = @$clients->potongan_withdraw;
            $biaya_lain_withdraw    = ($potongan_withdraw ? $potongan_withdraw : 0);
            $jumlah_withdraw        = $this->input->post('jumlah_withdraw');
            $jumlah_withdraw        = str_replace('.', '', $jumlah_withdraw);
            $jumlah_withdraw        = str_replace(',', '', $jumlah_withdraw);
            $total_withdraw         = $jumlah_withdraw + $biaya_lain_withdraw;

            $insert = array(
                'clients_id'            => @$clients->id,
                'kode_member'           => $this->input->post('kode_member'),
                'jumlah_withdraw'       => $jumlah_withdraw,
                'biaya_lain_withdraw'   => $biaya_lain_withdraw,
                'total_withdraw'        => $total_withdraw,
                'permainans_id'         => $this->input->post('permainans_id'),
                'banks_id'              => $this->input->post('banks_id'),
                'nomor_rekening_bank'   => $this->input->post('nomor_rekening_bank'),
                'nama_rekening_bank'    => $this->input->post('nama_rekening_bank'),
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_withdraws->add_withdraws($insert);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Form withdraw gagal disubmit!');

                redirect(current_url());
            } else {
                $this->db->trans_commit();   
                
                $this->session->set_flashdata('success', 'Form withdraw berhasil disubmit!');     

                if($link_redirect_withdraw){
                    redirect($$link_redirect_withdraw);
                } else {
                    redirect(current_url());
                }      
            }
        }
    }

    function _cek_kode_captcha_withdraw(){
        $kode_captcha_input     = $this->input->post('kode_captcha');
        $kode_captcha_session   = @$this->session->userdata('captcha_withdraw')['word'];
        
        if($kode_captcha_input == $kode_captcha_session){
            return true;
        } else {
            $this->form_validation->set_message('_cek_kode_captcha_withdraw', 'Kode captcha salah!');
            return false;
        }
    }

    function _generate_captcha_withdraw(){

        $this->_delete_captcha_withdraw();
        
        $captcha_config = array(
            'font_path'     => APPPATH . "../assets/captcha/verdanab.ttf",
            'img_path'      => "./assets/captcha/",
            'img_url'       => base_url() . 'assets/captcha/',
            'img_width'     => 240,
            'img_height'    => 50,
            'word_length'   => 5,
            'font_size'     => 20,
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => array(
                                'background'=> array(255,255,255),
                                'border'    => array(255,255,255),
                                'text'      => array(0, 0, 0),
                                'grid'      => array(255,0,0)
                            )
        );

        $captcha = create_captcha($captcha_config);

        $this->session->unset_userdata('captcha_withdraw');
        $this->session->set_userdata('captcha_withdraw', $captcha);

        return $captcha;
    }

    function _delete_captcha_withdraw(){
        $captcha_withdraw = $this->session->userdata('captcha_withdraw');
        if($captcha_withdraw){

            $path = './assets/captcha/' . $captcha_withdraw['time'] . '.jpg';

            if(is_file($path)){
                @unlink($path);
            }
        }
    }

    function ajax_withdraw_captcha_code(){
        (!$this->input->is_ajax_request() ? show_404() : '');

        $captcha = $this->_generate_captcha_withdraw();

        echo $captcha['image'];
    }

    /*
    | -------------------------------------------------------------------
    | FORM DEPOSIT
    | -------------------------------------------------------------------
    */
    function _form_deposit($clients){

        $link_redirect_deposit  = @$clients->link_redirect_deposit;

        if($this->input->post('kode_member')){
            $this->form_validation->set_rules('kode_member', 'Kode member', 'trim|required|xss_clean');
        } else {
            $this->form_validation->set_rules('kode_member', 'Kode member', 'trim|required|xss_clean');
        }
        $this->form_validation->set_rules('jumlah_deposit', 'Jumlah deposit', 'trim|required|xss_clean');
        $this->form_validation->set_rules('permainans_id', 'Nama permainan', 'trim|required|xss_clean');
        $this->form_validation->set_rules('banks_id', 'Nama bank', 'trim|required|xss_clean');
           
        $this->form_validation->set_message('required', '{field} wajib diisi!');

        if($this->form_validation->run() == FALSE){
            
            $data = array(
                'banks'         => $this->M_banks->get_all_banks(),
                'permainans'    => $this->M_permainans->get_all_permainans(),
                'title'         => 'Formulir Deposit',
                'contents'      => $this->contents . 'v_form_deposit',
            );

            $this->load->view($this->layouts, $data);

        } else {

            $jumlah_deposit = $this->input->post('jumlah_deposit');
            $jumlah_deposit = str_replace('.', '', $jumlah_deposit);
            $jumlah_deposit = str_replace(',', '', $jumlah_deposit);

            $insert = array(
                'clients_id'            => @$clients->id,
                'kode_member'           => $this->input->post('kode_member'),
                'jumlah_deposit'        => $jumlah_deposit,
                'permainans_id'         => $this->input->post('permainans_id'),
                'banks_id'              => $this->input->post('banks_id'),
                'nomor_rekening_bank'   => $this->input->post('nomor_rekening_bank'),
                'nama_rekening_bank'    => $this->input->post('nama_rekening_bank'),
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_deposits->add_deposits($insert);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Formulir deposit gagal disubmit!');

                redirect(current_url());
            } else {
                $this->db->trans_commit();   
                
                $this->session->set_flashdata('success', 'Formulir deposit berhasil disubmit!');             

                if($link_redirect_deposit){
                    redirect($link_redirect_deposit);
                } else {
                    redirect(current_url());
                }
            }
        }
    }

    function _cek_kode_captcha_deposit(){
        $kode_captcha_input     = $this->input->post('kode_captcha');
        $kode_captcha_session   = @$this->session->userdata('captcha_withdraw')['word'];
        
        if($kode_captcha_input == $kode_captcha_session){
            return true;
        } else {
            $this->form_validation->set_message('_cek_kode_captcha_deposit', 'Kode captcha salah!');
            return false;
        }
    }

    function _generate_captcha_deposit(){

        $this->_delete_captcha_deposit();
        
        $captcha_config = array(
            'font_path'     => APPPATH . "../assets/captcha/verdanab.ttf",
            'img_path'      => "./assets/captcha/",
            'img_url'       => base_url() . 'assets/captcha/',
            'img_width'     => 240,
            'img_height'    => 50,
            'word_length'   => 5,
            'font_size'     => 20,
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => array(
                                'background'=> array(255,255,255),
                                'border'    => array(255,255,255),
                                'text'      => array(0, 0, 0),
                                'grid'      => array(255,0,0)
                            )
        );

        $captcha = create_captcha($captcha_config);

        $this->session->unset_userdata('captcha_deposit');
        $this->session->set_userdata('captcha_deposit', $captcha);

        return $captcha;
    }

    function _delete_captcha_deposit(){
        $captcha_deposit = $this->session->userdata('captcha_deposit');
        if($captcha_deposit){

            $path = './assets/captcha/' . $captcha_deposit['time'] . '.jpg';

            if(is_file($path)){
                @unlink($path);
            }
        }
    }

    function ajax_deposit_captcha_code(){
        (!$this->input->is_ajax_request() ? show_404() : '');

        $captcha = $this->_generate_captcha_deposit();

        echo $captcha['image'];
    }
}
