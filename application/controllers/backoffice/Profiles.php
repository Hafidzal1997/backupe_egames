<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profiles extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        ($this->session->userdata('roles_id') ? '' : redirect('backoffice/dashboard'));

        $this->load->model(array('M_users'));
        $this->load->library(array('form_validation', 'upload'));

        $this->users_id = $this->session->userdata('id');
        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/profiles/';
    }

    function index()
    {
        $edit = $this->M_users->get_users_by_id($this->users_id);
        if(!$edit){
            $this->session->set_flashdata('warning', 'Data tidak tersedia!');
            redirect('backoffice/dashboard');
        }

        $data = array(
                    'edit'      => $edit,
                    'title'     => 'Profil Saya',
                    'contents'  => $this->contents . 'v_index',
                );

        $this->load->view($this->layouts, $data);
    }

    function edit()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[3]|xss_clean');
        
        $this->form_validation->set_message('required', '%s wajib diisi!');
        $this->form_validation->set_message('valid_email', '%s tidak valid!');
        $this->form_validation->set_message('is_unique', '%s sudah tersedia!');
        $this->form_validation->set_message('min_length', '%s minimal %s karakter!');


        if($this->form_validation->run() == FALSE){
            
            $edit = $this->M_users->get_users_by_id($this->users_id);

            if(!$edit){
                $this->session->set_flashdata('warning', 'Data tidak tersedia!');
                redirect('backoffice/dashboard');
            }

            $data = array(
                'edit'      => $edit,
                'title'     => 'Ubah Profil',
                'contents'  => $this->contents . 'v_edit',
            );

            $this->load->view($this->layouts, $data);

        } else {
            
            $foto = $this->input->post('foto_old');

            if (!empty($_FILES['foto']['name'])){

                $config['upload_path']      = './uploads/foto/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';     
                $config['file_name']        = url_title(strtolower($this->input->post('email')));

                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')){

                    if(file_exists('./uploads/foto/' . $foto)){
                        @unlink('./uploads/foto/' . $foto);
                    }

                    $upload = $this->upload->data();
                    $foto   = $upload['file_name'];

                    $this->compress_foto($foto);
                } 
            }

            $update = array(
                'nama'          => $this->input->post('nama'),
                'foto'          => $foto,
                'updated_at'    => date('Y-m-d H:i:s'),
                'updated_by'    => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_users->update_users_by_id($this->users_id, $update);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   

                $this->session->set_userdata('nama', $update['nama']);
                $this->session->set_userdata('foto', $update['foto']);
                
                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/profiles');
        }
    }

    function edit_password()
    {
        $this->form_validation->set_rules('password_lama', 'Password lama', 'trim|min_length[3]|required|xss_clean|callback__cek_password_lama');
        $this->form_validation->set_rules('password', 'Password baru', 'trim|min_length[3]|required|xss_clean');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi password baru', 'trim|min_length[3]|required|xss_clean|matches[password]');

        $this->form_validation->set_message('required', '%s wajib diisi!');
        $this->form_validation->set_message('valid_email', '%s tidak valid!');
        $this->form_validation->set_message('is_unique', '%s sudah tersedia!');
        $this->form_validation->set_message('min_length', '%s minimal %s karakter!');

        if($this->form_validation->run() == FALSE){            
            $data = array(
                        'title'     => 'Ubah Password',
                        'contents'  => $this->contents . 'v_edit_password',
                    );

            $this->load->view($this->layouts, $data);
        } else {
            $update = array(
                'password'      => sha1($this->input->post('password')),
                'updated_at'    => date('Y-m-d H:i:s'),
                'updated_by'    => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_users->update_users_by_id($this->users_id, $update);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   
                
                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/profiles');
        }
    }

    function _cek_password_lama(){
        $edit = $this->M_users->get_users_by_id($this->users_id);
        $password_lama_db   = @$edit->password;
        $password_lama_input= sha1($this->input->post('password_lama'));

        if($password_lama_input == $password_lama_db){
            return true;
        } else {
            $this->form_validation->set_message('_cek_password_lama', 'Password lama anda salah!');
            return false;
        }
    }

     function compress_foto($filename){
        
        $config_manip = array(
          'image_library'   => 'gd2',
          'source_image'    => './uploads/foto/' . $filename,
          'new_image'       => './uploads/foto/',
          'maintain_ratio'  => TRUE,
          'width'           => 240,
          'height'          => 240,
      );
   
      $this->load->library('image_lib', $config_manip);
      if (!$this->image_lib->resize()) {
          echo $this->image_lib->display_errors();
      }
   
      $this->image_lib->clear();
    }
}