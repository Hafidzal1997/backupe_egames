<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        ($this->session->userdata('roles_id') == 1 ? '' : redirect('backoffice/dashboard'));

        $this->load->model(array('M_clients'));
        $this->load->library(array('form_validation', 'upload'));

        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/clients/';
    }

    function index()
    {
        $data = array(
                    'title'     => 'Daftar Clients',
                    'contents'  => $this->contents . 'v_index',
                );

        $this->load->view($this->layouts, $data);
    }

    function clients_json()
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $requestData    = $_REQUEST;
        $fetch          = $this->M_clients->fetch_data_clients($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
        
        $totalData      = $fetch['totalData'];
        $totalFiltered  = $fetch['totalFiltered'];
        $query          = $fetch['query'];

        $data   = array();
        $nomor  = 1;
        foreach($query->result() as $row)
        { 
            $nestedData = array(); 

            $option = '<a href="'.base_url('sites/' . $row->link_form_register).'" target="_blank" class="btn btn-dark btn-sm text-white" title="Link Register">
                            <i class="fa fa-files-o"></i>
                        </a>';

            $option .= '<a href="'.base_url('sites/' . $row->link_form_deposit).'" target="_blank" class="btn btn-dark btn-sm text-white" title="Link Deposit">
                            <i class="fa fa-cloud-download"></i>
                        </a>';

            $option .= '<a href="'.base_url('sites/' . $row->link_form_withdraw).'" target="_blank" class="btn btn-dark btn-sm text-white" title="Link Withdraw">
                            <i class="fa fa-cloud-upload"></i>
                        </a>';

            $option .= '<a href="'.base_url('backoffice/clients/edit/' . encode($row->id)).'" class="btn btn-warning btn-sm text-white" title="Ubah Data">
                            <i class="fa fa-edit"></i>
                        </a>';
            $option .= '<a href="javascript:;" class="btn btn-danger btn-sm btn-delete" data-url="'.base_url('backoffice/clients/delete/' . encode($row->id)).'" title="Hapus Data">
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
            $nestedData[]   = $row->alamat;
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
        $this->form_validation->set_rules('nama', 'Nama Client', 'trim|required|xss_clean|callback__cek_nama_client');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');
        $this->form_validation->set_message('is_unique', '{field} sudah tersedia!');

        if($this->form_validation->run() == FALSE){
            
            $data = array(
                'title'     => 'Tambah Clients',
                'contents'  => $this->contents . 'v_add',
            );

            $this->load->view($this->layouts, $data);

        } else {

            $foto = null;

            if (!empty($_FILES['foto']['name'])){

                $config['upload_path']      = './uploads/foto/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';     
                $config['file_name']        = url_title(strtolower($this->input->post('nama'))) .'-'. rand(100, 999);

                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')){
                    $upload = $this->upload->data();
                    $foto   = $upload['file_name'];

                    $this->compress_foto($foto);
                } 
            }

            $insert = array(
                'nama'                      => $this->input->post('nama'),
                'alamat'                    => $this->input->post('alamat'),
                'email'                     => $this->input->post('email'),
                'nomor_telepon'             => $this->input->post('nomor_telepon'),
                'nomor_telepon2'            => $this->input->post('nomor_telepon2'),
                'nama_pic'                  => $this->input->post('nama_pic'),
                'nomor_hp_pic'              => $this->input->post('nomor_hp_pic'),
                'email_pic'                 => $this->input->post('email_pic'),
                'foto'                      => $foto,

                'kode_member_number_digits' => 3,
                'kode_member_prefixs'       => 'ABCDEFG',
                'link_form_deposit'         => substr(encode(rand(1000, 9999)), 0, 5),
                'link_form_register'        => substr(encode(rand(1000, 9999)), 0, 5),
                'link_form_withdraw'        => substr(encode(rand(1000, 9999)), 0, 5),
                'link_redirect_deposit'     => null,
                'link_redirect_register'    => null,
                'link_redirect_withdraw'    => null,
                'potongan_withdraw'         => 0,

                'created_at'                => date('Y-m-d H:i:s'),
                'created_by'                => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_clients->add_clients($insert);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   

                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/clients');
        }
    }

    function _cek_nama_client(){
        $data = array(
                    'nama'          => $this->input->post('nama')
                    , 'alamat'      => $this->input->post('alamat')
                    , 'flag_delete' => 'N'
                );
        $total = $this->M_clients->get_clients_by($data);
        
        if($total->num_rows() > 0){
            $this->form_validation->set_message('_cek_nama_client', 'Data sudah tersedia');
            return false;
        } else {
            return true;
        }
    }

    function edit($id = null)
    {
        if(!$id){
            $this->session->set_flashdata('warning', 'Data tidak tersedia!');
            redirect('backoffice/clients');
        }

        $id = decode($id);
        
        $this->form_validation->set_rules('nama', 'Nama Client', 'trim|required|xss_clean');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');

        if($this->form_validation->run() == FALSE){
            
            $edit = $this->M_clients->get_clients_by_id($id);

            if(!$edit){
                $this->session->set_flashdata('warning', 'Data tidak tersedia!');
                redirect('backoffice/clients');
            }

            $data = array(
                'edit'      => $edit,
                'title'     => 'Ubah Client',
                'contents'  => $this->contents . 'v_edit',
            );

            $this->load->view($this->layouts, $data);

        } else {
            
            $foto = $this->input->post('foto_old');

            if (!empty($_FILES['foto']['name'])){

                $config['upload_path']      = './uploads/foto/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';     
                $config['file_name']        = url_title(strtolower($this->input->post('email'))) .'_' . rand(100,999);

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
                'nama'                      => $this->input->post('nama'),
                'alamat'                    => $this->input->post('alamat'),
                'email'                     => $this->input->post('email'),
                'nomor_telepon'             => $this->input->post('nomor_telepon'),
                'nomor_telepon2'            => $this->input->post('nomor_telepon2'),
                'nama_pic'                  => $this->input->post('nama_pic'),
                'nomor_hp_pic'              => $this->input->post('nomor_hp_pic'),
                'email_pic'                 => $this->input->post('email_pic'),
                'foto'                      => $foto,
                'flag_active'               => $this->input->post('flag_active'),
                
                'kode_member_number_digits' => $this->input->post('kode_member_number_digits'),
                'kode_member_prefixs'       => $this->input->post('kode_member_prefixs'),
                'link_form_deposit'         => $this->input->post('link_form_deposit'),
                'link_form_register'        => $this->input->post('link_form_register'),
                'link_form_withdraw'        => $this->input->post('link_form_withdraw'),
                'link_redirect_deposit'     => $this->input->post('link_redirect_deposit'),
                'link_redirect_register'    => $this->input->post('link_redirect_register'),
                'link_redirect_withdraw'    => $this->input->post('link_redirect_withdraw'),

                'updated_at'                => date('Y-m-d H:i:s'),
                'updated_by'                => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_clients->update_clients_by_id($id, $update);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   

                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/clients');
        }
    }

    function delete_all()
    {
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
            $this->M_clients->update_batch_clients_by('id', $update);
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

    function delete($id)
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $id = decode($id);

        $update = array(
                    'flag_delete'  => 'Y',
                    'delete_at'    => date('Y-m-d H:i:s'),
                    'delete_by'    => $this->session->userdata('id'),
                );
        
        $this->db->trans_start();

        $this->M_clients->update_clients_by_id($id, $update);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode(array('status' => false));

        } else {
            $this->db->trans_commit();   

            echo json_encode(array('status' => true));          
        }
    }

    function compress_foto($filename)
    {        
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

    function generate_link()
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $string = rand(1000, 9999);
        $link   = encode($string);
        $link   = substr($link, 0, 5);

        echo json_encode(array('status' => true, 'link' => $link));
    }
}
