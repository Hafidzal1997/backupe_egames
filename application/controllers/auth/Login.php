<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->helper(array('captcha'));
        $this->load->library(array('form_validation'));
        $this->load->model(array('M_users'));
    }    

    function error_404(){
        $this->load->view('frontoffice/sites/v_404_error');
    }

    public function index()
    {
        if($this->session->userdata('roles_id')){

            redirect('backoffice/dashboard', 'location');

        } else {
            $this->do_login();
        }
    }

    public function do_login(){
        $this->form_validation->set_rules('param1', 'Email', 'trim|required|xss_clean|callback__check_logged_in');
        $this->form_validation->set_rules('param2', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('param3', 'Captcha', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');

        if($this->form_validation->run() == FALSE){

            $captcha = $this->_generate_captcha();

            $data = array(
                        'title'     => 'Login',
                        'captcha'   => $captcha['image'],
                    );
            $this->load->view('auth/login/v_index', $data);
        } else {

            $this->_delete_captcha();

            redirect('auth/login', 'location');
        }
    }

    public function _check_logged_in(){
        $param1 = $this->input->post('param1');
        $param2 = sha1($this->input->post('param2'));
        $param3 = $this->input->post('param3');
        $kode   = @$this->session->userdata('captcha_login')['word'];

        if($kode == $param3){

            $row = $this->M_users->get_login($param1, $param2);

            if($row){
                
                if($row->flag_active == 'Y'){

                    $this->session->set_userdata('logged_in', true);
                    $this->session->set_userdata('id', $row->id);
                    $this->session->set_userdata('email', $row->email);
                    $this->session->set_userdata('password', $row->password);
                    $this->session->set_userdata('nama', $row->nama);
                    $this->session->set_userdata('foto', $row->foto);
                    $this->session->set_userdata('roles_id', $row->roles_id);

                    return TRUE;
                } else {
                    $this->form_validation->set_message('_check_logged_in', 'MAAF! AKUN ANDA TIDAK AKTIF! HUBUNGI ADMINISTRATOR!');
                    return FALSE;
                }
            } else {

                $this->form_validation->set_message('_check_logged_in', 'MAAF! PERIKSA KEMBALI AKUN ANDA!');
                return FALSE;
            }
        } else {
            $this->form_validation->set_message('_check_logged_in', 'MAAF! PERIKSA KEMBALI KODE CAPTCHA!');
            return FALSE;
        }
    }

    public function request_code(){
        (!$this->input->is_ajax_request() ? show_404() : '');

        $captcha = $this->_generate_captcha();

        echo $captcha['image'];
    }

    public function _generate_captcha(){

        $this->_delete_captcha();
        
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
                                'grid'      => array(255,255,255)
                            )
        );

        $captcha = create_captcha($captcha_config);

        $this->session->unset_userdata('captcha_login');
        $this->session->set_userdata('captcha_login', $captcha);

        return $captcha;
    }

    public function _delete_captcha(){
        $captcha_login = $this->session->userdata('captcha_login');
        if($captcha_login){

            $path = './assets/captcha/' . $captcha_login['time'] . '.jpg';

            if(is_file($path)){
                @unlink($path);
            }
        }
    }

    public function do_logout(){
        $array_items = array('logged_in', 'id', 'email', 'password', 'nama', 'foto', 'roles_id');

        $this->session->unset_userdata($array_items);

        redirect('auth/login');
    }
}
