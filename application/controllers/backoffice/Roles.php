<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        ($this->session->userdata('roles_id') == 1 ? '' : redirect('backoffice/dashboard'));

        $this->load->model(array('M_roles'));
        $this->load->library(array('form_validation'));

        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/roles/';
    }

    function index()
    {
        $data = array(
                    'title'     => 'Daftar Role',
                    'contents'  => $this->contents . 'v_index',
                );

        $this->load->view($this->layouts, $data);
    }

    function roles_json()
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $requestData    = $_REQUEST;
        $fetch          = $this->M_roles->fetch_data_roles($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
        
        $totalData      = $fetch['totalData'];
        $totalFiltered  = $fetch['totalFiltered'];
        $query          = $fetch['query'];

        $data   = array();
        $nomor  = 1;
        foreach($query->result() as $row)
        { 
            $nestedData = array(); 

            $option = '<a href="'.base_url('backoffice/roles/edit/' . encode($row->id)).'" class="btn btn-warning btn-sm text-white" title="Ubah Data">
                            <i class="fa fa-edit"></i>
                        </a>';
                        
            // $option .= '<a href="javascript:;" class="btn btn-danger btn-sm btn-delete" data-url="'.base_url('backoffice/roles/delete/' . encode($row->id)).'" title="Hapus Data">
            //                 <i class="fa fa-trash-o"></i>
            //             </a>';

            $nestedData[]   = $nomor++;
            $nestedData[]   = $row->id;
            $nestedData[]   = $row->roles;
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
        $this->form_validation->set_rules('roles', 'Nama role', 'trim|required|xss_clean|is_unique[roles.roles]');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');
        $this->form_validation->set_message('is_unique', '{field} sudah tersedia!');

        if($this->form_validation->run() == FALSE){
            
            $data = array(
                'title'     => 'Tambah Role',
                'contents'  => $this->contents . 'v_add',
            );

            $this->load->view($this->layouts, $data);

        } else {

            $insert = array(
                'roles'      => $this->input->post('roles'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_roles->add_roles($insert);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   
                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/roles');
        }
    }

    function edit($id = null)
    {
        if(!$id){
            $this->session->set_flashdata('warning', 'Data tidak tersedia!');
            redirect('backoffice/roles');
        }

        $id = decode($id);
        
        $this->form_validation->set_rules('roles', 'Nama role', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');

        if($this->form_validation->run() == FALSE){
            
            $edit = $this->M_roles->get_roles_by_id($id);

            if(!$edit){
                $this->session->set_flashdata('warning', 'Data tidak tersedia!');
                redirect('backoffice/roles');
            }

            $data = array(
                'edit'      => $edit,
                'title'     => 'Ubah Role',
                'contents'  => $this->contents . 'v_edit',
            );

            $this->load->view($this->layouts, $data);

        } else {
            
            $update = array(
                'roles'      => $this->input->post('roles'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_roles->update_roles_by_id($id, $update);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   

                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/roles');
        }
    }

    function delete($id)
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $id = decode($id);

        $this->db->trans_start();
        
        $this->M_roles->delete_by_id($id);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode(array('status' => false));

        } else {
            $this->db->trans_commit();   

            echo json_encode(array('status' => true));          
        }
    }
}
