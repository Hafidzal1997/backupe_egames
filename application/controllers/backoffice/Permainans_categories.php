<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permainans_categories extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        ($this->session->userdata('roles_id') == 1 ? '' : redirect('backoffice/dashboard'));

        $this->load->model(array('M_permainans_categories'));
        $this->load->library(array('form_validation'));

        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/permainans_categories/';
    }

    function index()
    {
        $data = array(
                    'title'     => 'Daftar Kategori Permainan',
                    'contents'  => $this->contents . 'v_index',
                );

        $this->load->view($this->layouts, $data);
    }

    function permainans_categories_json()
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $requestData    = $_REQUEST;
        $fetch          = $this->M_permainans_categories->fetch_data_permainans_categories($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
        
        $totalData      = $fetch['totalData'];
        $totalFiltered  = $fetch['totalFiltered'];
        $query          = $fetch['query'];

        $data   = array();
        $nomor  = 1;
        foreach($query->result() as $row)
        { 
            $nestedData = array(); 

            $option = '<a href="'.base_url('backoffice/permainans_categories/edit/' . encode($row->id)).'" class="btn btn-warning btn-sm text-white" title="Ubah Data">
                            <i class="fa fa-edit"></i>
                        </a>';
            $option .= '<a href="javascript:;" class="btn btn-danger btn-sm btn-delete" data-url="'.base_url('backoffice/permainans_categories/delete/' . encode($row->id)).'" title="Hapus Data">
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
            $nestedData[]   = $row->nama_kategori_permainan;
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
        $this->form_validation->set_rules('nama_kategori_permainan', 'Kategori Permainan', 'trim|required|xss_clean|callback__cek_nama_kategori_permainan');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');
        $this->form_validation->set_message('is_unique', '{field} sudah tersedia!');

        if($this->form_validation->run() == FALSE){
            
            $data = array(
                'title'     => 'Tambah Kategori Permainan',
                'contents'  => $this->contents . 'v_add',
            );

            $this->load->view($this->layouts, $data);

        } else {

            $insert = array(
                'nama_kategori_permainan'   => $this->input->post('nama_kategori_permainan'),
                'created_at'                => date('Y-m-d H:i:s'),
                'created_by'                => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_permainans_categories->add_permainans_categories($insert);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   

                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/permainans-categories');
        }
    }

    function _cek_nama_kategori_permainan(){
        $data = array(
                    'nama_kategori_permainan'   => $this->input->post('nama_kategori_permainan')
                    , 'flag_delete'             => 'N'
                );
        $total = $this->M_permainans_categories->get_permainans_categories_by($data);
        
        if($total->num_rows() > 0){
            $this->form_validation->set_message('_cek_nama_kategori_permainan', 'Data sudah tersedia');
            return false;
        } else {
            return true;
        }
    }

    function edit($id = null)
    {
        if(!$id){
            $this->session->set_flashdata('warning', 'Data tidak tersedia!');
            redirect('backoffice/permainans-categories');
        }

        $id = decode($id);
        
        $this->form_validation->set_rules('nama_kategori_permainan', 'Kategori Permainan', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');

        if($this->form_validation->run() == FALSE){
            
            $edit = $this->M_permainans_categories->get_permainans_categories_by_id($id);

            if(!$edit){
                $this->session->set_flashdata('warning', 'Data tidak tersedia!');
                redirect('backoffice/permainans-categories');
            }

            $data = array(
                'edit'      => $edit,
                'title'     => 'Ubah Kategori Permainan',
                'contents'  => $this->contents . 'v_edit',
            );

            $this->load->view($this->layouts, $data);

        } else {
            
            $update = array(
                'nama_kategori_permainan'   => $this->input->post('nama_kategori_permainan'),
                'flag_active'               => $this->input->post('flag_active'),
                'updated_at'                => date('Y-m-d H:i:s'),
                'updated_by'                => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_permainans_categories->update_permainans_categories_by_id($id, $update);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   

                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/permainans-categories');
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
            $this->M_permainans_categories->update_batch_permainans_categories_by('id', $update);
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

        $this->M_permainans_categories->update_permainans_categories_by_id($id, $update);

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
