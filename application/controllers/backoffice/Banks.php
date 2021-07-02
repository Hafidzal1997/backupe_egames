<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banks extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        ($this->session->userdata('roles_id') == 1 ? '' : redirect('backoffice/dashboard'));

        $this->load->model(array('M_banks'));
        $this->load->library(array('form_validation'));

        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/banks/';
    }

    function index()
    {
        $data = array(
                    'title'     => 'Daftar Bank',
                    'contents'  => $this->contents . 'v_index',
                );

        $this->load->view($this->layouts, $data);
    }

    function banks_json()
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $requestData    = $_REQUEST;
        $fetch          = $this->M_banks->fetch_data_banks($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
        
        $totalData      = $fetch['totalData'];
        $totalFiltered  = $fetch['totalFiltered'];
        $query          = $fetch['query'];

        $data   = array();
        $nomor  = 1;
        foreach($query->result() as $row)
        { 
            $nestedData = array(); 

            $option = '<a href="'.base_url('backoffice/banks/edit/' . encode($row->id)).'" class="btn btn-warning btn-sm text-white" title="Ubah Data">
                            <i class="fa fa-edit"></i>
                        </a>';
            $option .= '<a href="javascript:;" class="btn btn-danger btn-sm btn-delete" data-url="'.base_url('backoffice/banks/delete/' . encode($row->id)).'" title="Hapus Data">
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
            $nestedData[]   = $row->kode_bank;
            $nestedData[]   = $row->nama_bank;
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
        if($this->input->post('nama_bank') && $this->input->post('kode_bank'))
        {
            $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required|xss_clean|callback__cek_nama_bank');
            $this->form_validation->set_rules('kode_bank', 'Kode Bank', 'trim|required|xss_clean|callback__cek_nama_bank');
        } else {
            $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required|xss_clean');
            $this->form_validation->set_rules('kode_bank', 'Kode Bank', 'trim|required|xss_clean');
        }
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');
        $this->form_validation->set_message('is_unique', '{field} sudah tersedia!');

        if($this->form_validation->run() == FALSE){
            
            $data = array(
                'title'     => 'Tambah Bank',
                'contents'  => $this->contents . 'v_add',
            );

            $this->load->view($this->layouts, $data);

        } else {

            $insert = array(
                'kode_bank'     => $this->input->post('kode_bank'),
                'nama_bank'     => $this->input->post('nama_bank'),
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by'    => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_banks->add_banks($insert);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   
                
                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/banks');
        }
    }

    function _cek_nama_bank(){
        $data = array(
                    'kode_bank'     => $this->input->post('kode_bank')
                    , 'nama_bank'   => $this->input->post('nama_bank')
                    , 'flag_delete' => 'N'
                );
        $total = $this->M_banks->get_banks_by($data);
        
        if($total->num_rows() > 0){
            $this->form_validation->set_message('_cek_nama_bank', 'Data sudah tersedia');
            return false;
        } else {
            return true;
        }
    }

    function edit($id = null)
    {
        if(!$id){
            $this->session->set_flashdata('warning', 'Data tidak tersedia!');
            redirect('backoffice/banks');
        }

        $id = decode($id);
        
        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('kode_bank', 'Kode Bank', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');

        if($this->form_validation->run() == FALSE){
            
            $edit = $this->M_banks->get_banks_by_id($id);

            if(!$edit){
                $this->session->set_flashdata('warning', 'Data tidak tersedia!');
                redirect('backoffice/banks');
            }

            $data = array(
                'edit'      => $edit,
                'title'     => 'Ubah Bank',
                'contents'  => $this->contents . 'v_edit',
            );

            $this->load->view($this->layouts, $data);

        } else {
            
            $update = array(
                'nama_bank'     => $this->input->post('nama_bank'),
                'kode_bank'     => $this->input->post('kode_bank'),
                'flag_active'   => $this->input->post('flag_active'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'updated_by'    => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_banks->update_banks_by_id($id, $update);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   
                
                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/banks');
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
            $this->M_banks->update_batch_banks_by('id', $update);
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
                    'flag_delete'   => 'Y',
                    'delete_at'    => date('Y-m-d H:i:s'),
                    'delete_by'    => $this->session->userdata('id'),
                );
        
        $this->db->trans_start();
        
        $this->M_banks->update_banks_by_id($id, $update);

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
