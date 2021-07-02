<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsX extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        ($this->session->userdata('roles_id') == 1 ? '' : redirect('backoffice/dashboard'));
         
        $this->load->model(array('M_settings'));
        $this->load->library(array('form_validation'));

        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/settings/';
    }

    function index()
    {
        $this->form_validation->set_rules('link_form_register', 'Link form register', 'trim|required|xss_clean');
        $this->form_validation->set_rules('link_form_deposit', 'Link form deposit', 'trim|required|xss_clean');
        $this->form_validation->set_rules('link_form_withdraw', 'Link form withdraw', 'trim|required|xss_clean');

        $this->form_validation->set_rules('kode_member_number_digits', 'Digit Nomor', 'trim|required|xss_clean');
        $this->form_validation->set_rules('kode_member_prefixs', 'Prefix Kode', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '%s wajib diisi!');

        if($this->form_validation->run() == FALSE){
            
            $settings       = array();
            $array_settings = array(
                                'kode_member_number_digits'
                                , 'kode_member_prefixs'
                                , 'kode_member_last'

                                , 'link_form_register'
                                , 'link_form_deposit'
                                , 'link_form_withdraw'

                                , 'link_redirect_register'
                                , 'link_redirect_deposit'
                                , 'link_redirect_withdraw'
                            );

            if($array_settings){
                foreach($array_settings as $key){
                    $row = $this->M_settings->get_settings_by_id($key);

                    $settings[$key] = $row->settings_value;
                }
            }
            
            $data = array(
                'settings'  => $settings,
                'title'     => 'Settings',
                'contents'  => $this->contents . 'v_index',
            );

            $this->load->view($this->layouts, $data);

        } else {
            $update         = array();
            $array_settings = array(
                                'kode_member_number_digits'
                                , 'kode_member_prefixs'
                                
                                , 'link_form_register'
                                , 'link_form_deposit'
                                , 'link_form_withdraw'

                                , 'link_redirect_register'
                                , 'link_redirect_deposit'
                                , 'link_redirect_withdraw'
                            );

            if($array_settings){
                foreach($array_settings as $key){
                    $update[] = array(
                                    'settings_key'  => $key,
                                    'settings_value'=> $this->input->post($key),
                                    'updated_at'    => date('Y-m-d H:i:s'),
                                    'updated_by'    => $this->session->userdata('id'),
                                );
                }
            }

            $this->db->trans_start();

            if($update){
                $this->M_settings->update_batch_settings_by('settings_key', $update);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   
                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/settings');
        }
    }

    function generate_link()
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $string = rand(1000, 9999);
        $link   = encode($string);
        $link   = substr($link, 0, 5);

        echo json_encode(array('status' => true, 'link' => $link));
    }
}
