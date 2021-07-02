<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        ($this->session->userdata('roles_id') == 1 ? '' : redirect('backoffice/dashboard'));
         
        $this->load->model(array('M_roles', 'M_users'));
        $this->load->library(array('form_validation', 'upload'));

        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/users/';
    }

    function index()
    {
        $data = array(
                    'roles'         => $this->M_roles->get_all_roles(),
                    'title'         => 'Daftar User',
                    'contents'      => $this->contents . 'v_index',
                );

        $this->load->view($this->layouts, $data);
    }

    function users_json()
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $requestData    = $_REQUEST;
        $fetch          = $this->M_users->fetch_data_users($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
        
        $totalData      = $fetch['totalData'];
        $totalFiltered  = $fetch['totalFiltered'];
        $query          = $fetch['query'];

        $data   = array();
        $nomor  = 1;
        foreach($query->result() as $row)
        { 
            $nestedData = array(); 

            $option = '<a href="'.base_url('backoffice/users/edit/' . encode($row->id)).'" class="btn btn-warning btn-sm text-white" title="Ubah Data">
                            <i class="fa fa-edit"></i>
                        </a>';
            $option .= '<a href="javascript:;" class="btn btn-danger btn-sm btn-delete" data-url="'.base_url('backoffice/users/delete/' . encode($row->id)).'" title="Hapus Data">
                            <i class="fa fa-trash-o"></i>
                        </a>';

            if($row->flag_active == 'Y'){
                $flag_active = '<span class="badge badge-success">Aktif</span>';
            } else {
                $flag_active = '<span class="badge badge-danger">Tidak Aktif</span>';
            }

            $checkbox = '<input type="checkbox" class="posting" name="posting[]" value="'.$row->id.'">';

            $nestedData[]   = $nomor++;
            $nestedData[]   = $checkbox;
            $nestedData[]   = $row->nama;
            $nestedData[]   = $row->email;
            $nestedData[]   = $row->roles;
            $nestedData[]   = $flag_active;
            $nestedData[]   = $option;

            $data[] = $nestedData;
        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    function add()
    {        
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('roles_id', 'Nama role', 'trim|required');
            
        $this->form_validation->set_message('required', '%s wajib diisi!');
        $this->form_validation->set_message('valid_email', '%s tidak valid!');
        $this->form_validation->set_message('is_unique', '%s sudah tersedia!');
        $this->form_validation->set_message('min_length', '%s minimal %s karakter!');

        if($this->form_validation->run() == FALSE){
            
            $data = array(
                'role'      => $this->M_roles->get_all_roles(),
                'title'     => 'Tambah User',
                'contents'  => $this->contents . 'v_add',
            );

            $this->load->view($this->layouts, $data);

        } else {

            $foto = null;

            if (!empty($_FILES['foto']['name'])){

                $config['upload_path']      = './uploads/foto/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';     
                $config['file_name']        = url_title(strtolower($this->input->post('email')));

                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')){
                    $upload = $this->upload->data();
                    $foto   = $upload['file_name'];

                    $this->compress_foto($foto);
                } 
            }

            $insert = array(
                'email'         => $this->input->post('email'),
                'password'      => sha1($this->input->post('password')),
                'nama'          => $this->input->post('nama'),
                'foto'          => $foto,
                'roles_id'      => $this->input->post('roles_id'),
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by'    => $this->session->userdata('id'),
            );

            $this->db->trans_start();
            
            $this->M_users->add_users($insert);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   

                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/users');
        }
    }

    function edit($id = null){

        if(!$id){
            $this->session->set_flashdata('warning', 'Data tidak tersedia!');
            redirect('backoffice/users');
        }

        $id = decode($id);
        
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('roles_id', 'Nama role', 'trim|required|xss_clean');

        if($this->input->post('password')){
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|xss_clean');
        }
            
        $this->form_validation->set_message('required', '%s wajib diisi!');
        $this->form_validation->set_message('valid_email', '%s tidak valid!');
        $this->form_validation->set_message('is_unique', '%s sudah tersedia!');
        $this->form_validation->set_message('min_length', '%s minimal %s karakter!');


        if($this->form_validation->run() == FALSE){
            
            $edit = $this->M_users->get_users_by_id($id);

            if(!$edit){
                $this->session->set_flashdata('warning', 'Data tidak tersedia!');
                redirect('backoffice/users');
            }

            $data = array(
                'edit'      => $edit,
                'role'      => $this->M_roles->get_all_roles(),
                'title'     => 'Ubah User',
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
                'email'         => $this->input->post('email'),
                'nama'          => $this->input->post('nama'),
                'foto'          => $foto,
                'roles_id'      => $this->input->post('roles_id'),
                'flag_active'   => $this->input->post('flag_active'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'updated_by'    => $this->session->userdata('id'),
            );

            if($this->input->post('password')){
                $update = array_merge($update, array('password' => sha1($this->input->post('password'))));
            }

            $this->db->trans_start();

            $this->M_users->update_users_by_id($id, $update);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   
                
                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/users');
        }
    }

    function delete_all(){
        (!$this->input->is_ajax_request() ? show_404() : '');

        $posting    = $this->input->post('posting');
        $update     = array();

        if($posting){
            foreach($posting as $key => $id){
                $update[] = array(
                                'id'           => $id,
                                'flag_delete'  => 'Y',
                                'delete_at'    => date('Y-m-d H:i:s'),
                                'delete_by'    => $this->session->userdata('id'),
                            );
            }
        }

        $this->db->trans_start();

        if($update){
            $this->M_users->update_batch_users_by('id', $update);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode(array('status' => false));

        } else {
            $this->db->trans_commit();   

            echo json_encode(array('status' => true));          
        }
    }
    function delete($id){

        (!$this->input->is_ajax_request() ? show_404() : '');

        $id = decode($id);

        $update = array(
                    'flag_delete'   => 'Y',
                    'delete_at'    => date('Y-m-d H:i:s'),
                    'delete_by'    => $this->session->userdata('id'),
                );

        $this->db->trans_start();

        $this->M_users->update_users_by_id($id, $update);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode(array('status' => false));

        } else {
            $this->db->trans_commit();   

            echo json_encode(array('status' => true));          
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
