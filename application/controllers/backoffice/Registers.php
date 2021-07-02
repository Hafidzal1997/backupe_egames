<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Registers extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        ($this->session->userdata('roles_id') ? '' : redirect('backoffice/dashboard'));

        $this->load->model(array('M_members', 'M_settings', 'M_banks','M_permainans' ,'M_clients'));
        $this->load->library(array('form_validation'));

        $this->roles_id = $this->session->userdata('roles_id');
        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/registers/';
    }

    function index()
    {
        $data = array(
                    'clients'   => $this->M_clients->get_all_clients(),
                    'roles_id'  => $this->roles_id,
                    'title'     => 'Daftar Data Register',
                    'contents'  => $this->contents . 'v_index',
                );

        $this->load->view($this->layouts, $data);
    }

    function registers_json()
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $requestData    = $_REQUEST;
        $fetch          = $this->M_members->fetch_data_registers($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
        
        $totalData      = $fetch['totalData'];
        $totalFiltered  = $fetch['totalFiltered'];
        $query          = $fetch['query'];

        $data   = array();
        $nomor  = 1;
        foreach($query->result() as $row)
        { 
            $nestedData = array(); 

            $option = '<div class="btn-group">
                            <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cogs"></i>
                            </button>
                            <div class="dropdown-menu">';
            $checkbox = '';

            if($row->flag_status == 'A'){
                $flag_status = '<div class="text-center text-success font-weight-bold">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                    ACCEPTED
                                    <br>
                                    <small>
                                        '.date('d M Y', strtotime($row->accepted_at)).'
                                        <br>
                                        '.date('H:i:s', strtotime($row->accepted_at)).'
                                    </small>
                                </div>';
            } else if($row->flag_status == 'W'){
                $flag_status = '<div class="text-center text-warning font-weight-bold">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                    WAITING
                                </div>';

                if($row->flag_delete == 'N'){                    
                    $option .= '<a href="javascript:;" class="dropdown-item text-success btn-accept" data-url="'.base_url('backoffice/registers/accept/' . encode($row->id)).'" title="Accept Data">
                                    <strong>
                                        <i class="fa fa-check mr-2"></i> Accept
                                    </strong>
                                </a>
                                <a href="javascript:;" class="dropdown-item text-danger btn-reject" data-url="'.base_url('backoffice/registers/reject/' . encode($row->id)).'" title="Reject Data">
                                    <strong>
                                        <i class="fa fa-times mr-2"></i> Reject
                                    </strong>
                                </a>
                                <div class="dropdown-divider"></div>';
                }

            } else {
                $flag_status = '<div class="text-center text-danger font-weight-bold">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                    REJECTED
                                    <br>
                                    <small>
                                        '.date('d M Y', strtotime($row->rejected_at)).'
                                        <br>
                                        '.date('H:i:s', strtotime($row->rejected_at)).'
                                    </small>
                                </div>';
                $option .= '<a href="javascript:;" class="dropdown-item text-success btn-accept" data-url="'.base_url('backoffice/registers/accept/' . encode($row->id)).'" title="Restore to Accept Data">
                                <strong>
                                    <i class="fa fa-check mr-2"></i> Accept
                                </strong>
                            </a>
                            <div class="dropdown-divider"></div>';
            }
            

            $no_hp = $row->no_hp;
            if($this->roles_id != 1){
                $no_hp = encode_phone_number($no_hp, 4);
            }

            $email = $row->email;
            if($this->roles_id != 1){
                $email = encode_email($email, 4);
            }

            $nama_lengkap   = '<strong class="text-primary">
                                '.$row->nama_lengkap . '</strong>
                                <br>' . $no_hp . '
                                <br>
                                <small>' . $email . '</small>
                                '.($row->nama_client ? '<br>' . $row->nama_client : '').'
                                ';
            $nama_bank      = $row->nomor_rekening_bank .'<br>' .$row->nama_bank . '<br>'.$row->nama_rekening_bank;

            $created_at = '-';
            if($row->created_at){
                $created_at = date('d M Y', strtotime($row->created_at));
                $created_at .= '<br>';
                $created_at .= date('H:i:s', strtotime($row->created_at));
            }

            if($row->flag_delete == 'N'){    
                if($this->roles_id == 1){
                    $option .= '<a href="'.base_url('backoffice/registers/edit/' . encode($row->id)).'" class="dropdown-item text-dark" title="Ubah Data">
                                    <strong>
                                        <i class="fa fa-edit"></i> Ubah Data
                                    </strong>
                                </a>
                                <a href="javascript:;" class="dropdown-item text-danger btn-delete" data-url="'.base_url('backoffice/registers/delete/' . encode($row->id)).'" title="Hapus Data">
                                    <strong>
                                        <i class="fa fa-trash-o"></i> Hapus Data
                                    </strong>
                                </a>';
                }

                $checkbox .= '<input type="checkbox" class="posting" name="posting[]" value="'.$row->id.'">';
            } else {

                if($this->roles_id == 1){  

                    $option .= '<a href="javascript:;" class="dropdown-item text-primary btn-restore" data-url="'.base_url('backoffice/registers/restore/' . encode($row->id)).'" title="Restore Data">
                                    <strong>
                                        <i class="fa fa-mail-forward mr-2"></i> Restore Data
                                    </strong>
                                </a>';
                }
            }

            $option .= '</div></div>';

            $nestedData[]   = $nomor++;
            $nestedData[]   = $checkbox;
            $nestedData[]   = $row->kode_member;
            $nestedData[]   = $created_at;
            $nestedData[]   = $nama_lengkap;
            $nestedData[]   = $row->nama_permainan;
            $nestedData[]   = $nama_bank;
            $nestedData[]   = $flag_status;
            $nestedData[]   = $option;
            $nestedData[]   = $row->flag_delete;

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
        if($this->input->post('no_hp')){
            $this->form_validation->set_rules('no_hp', 'Nomor HP', 'trim|required|xss_clean|callback__cek_no_hp');
        } else {
            $this->form_validation->set_rules('no_hp', 'Nomor HP', 'trim|required|xss_clean');
        }

        if($this->input->post('email')){
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback__cek_email');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        }

        $this->form_validation->set_rules('clients_id', 'Nama client', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nama_lengkap', 'Nama lengkap', 'trim|required|xss_clean');
        $this->form_validation->set_rules('permainans_id', 'Nama permainan', 'trim|required|xss_clean');
        $this->form_validation->set_rules('banks_id', 'Nama bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nomor_rekening_bank', 'Nomor rekening bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nama_rekening_bank', 'Nama rekening bank', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');
        $this->form_validation->set_message('is_unique', '{field} sudah tersedia!');
        $this->form_validation->set_message('valid_email', '{field} tidak valid!');

        if($this->form_validation->run() == FALSE){
            
            $data = array(
                'banks'         => $this->M_banks->get_all_banks(),
                'permainans'    => $this->M_permainans->get_all_permainans(),
                'clients'       => $this->M_clients->get_all_clients(),
                'title'         => 'Tambah Pendaftaran',
                'contents'      => $this->contents . 'v_add',
            );

            $this->load->view($this->layouts, $data);

        } else {

            $insert = array(
                'clients_id'            => $this->input->post('clients_id'),
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

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   
                
                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/registers');
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

    function edit($id = null)
    {
        if(!$id){
            $this->session->set_flashdata('warning', 'Data tidak tersedia!');
            redirect('backoffice/registers');
        }

        $id = decode($id);
        
        $this->form_validation->set_rules('clients_id', 'Nama client', 'trim|required|xss_clean');
        $this->form_validation->set_rules('no_hp', 'Nomor HP', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('nama_lengkap', 'Nama lengkap', 'trim|required|xss_clean');
        $this->form_validation->set_rules('permainans_id', 'Nama permainan', 'trim|required|xss_clean');
        $this->form_validation->set_rules('banks_id', 'Nama bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nomor_rekening_bank', 'Nomor rekening bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nama_rekening_bank', 'Nama rekening bank', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');
        $this->form_validation->set_message('is_unique', '{field} sudah tersedia!');
        $this->form_validation->set_message('valid_email', '{field} tidak valid!');

        if($this->form_validation->run() == FALSE){
            
            $edit = $this->M_members->get_members_by_id($id);

            if(!$edit){
                $this->session->set_flashdata('warning', 'Data tidak tersedia!');
                redirect('backoffice/registers');
            }

            $data = array(
                'edit'          => $edit,
                'banks'         => $this->M_banks->get_all_banks(),
                'permainans'    => $this->M_permainans->get_all_permainans(),
                'clients'       => $this->M_clients->get_all_clients(),
                'title'         => 'Ubah Pendaftaran',
                'contents'      => $this->contents . 'v_edit',
            );

            $this->load->view($this->layouts, $data);

        } else {
            
            $update = array(
                'clients_id'            => $this->input->post('clients_id'),
                'kode_member'           => $this->input->post('kode_member'),
                'kode_member_prefixs'   => $this->input->post('kode_member_prefixs'),
                'nama_lengkap'          => $this->input->post('nama_lengkap'),
                'no_hp'                 => $this->input->post('no_hp'),
                'email'                 => $this->input->post('email'),
                'permainans_id'         => $this->input->post('permainans_id'),
                'banks_id'              => $this->input->post('banks_id'),
                'nomor_rekening_bank'   => $this->input->post('nomor_rekening_bank'),
                'nama_rekening_bank'    => $this->input->post('nama_rekening_bank'),
                'nomor_referral'        => $this->input->post('nomor_referral'),
                'updated_at'            => date('Y-m-d H:i:s'),
                'updated_by'            => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_members->update_members_by_id($id, $update);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                $this->session->set_flashdata('error', 'Data gagal disimpan!');
            } else {
                $this->db->trans_commit();   
                
                $this->session->set_flashdata('success', 'Data berhasil disimpan!');             
            }

            redirect('backoffice/registers');
        }
    }

     function detail($id = null)
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $id = decode($id);

        $edit = $this->M_members->get_members_by_id($id);

        if($edit->flag_read == 'N'){
            $update = array(
                'flag_read'     => 'Y',
                'read_at'       => date('Y-m-d H:i:s'),
                'read_by'       => $this->session->userdata('id'),
            );

            $this->db->trans_start();

            $this->M_members->update_members_by_id($id, $update);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();            
            }
        }

        $data = array(
            'edit' => $edit,
        );

        $this->load->view($this->contents . 'v_detail', $data);
    }

    function detail_append($id = null)
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $id = decode($id);

        $edit = $this->M_members->get_members_by_id($id);

        $data = array(
            'edit' => $edit,
        );

        $this->load->view($this->contents . 'v_detail_append', $data);
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
            $this->M_members->update_batch_members_by('id', $update);
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
        
        $this->M_members->update_members_by_id($id, $update);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode(array('status' => false));

        } else {
            $this->db->trans_commit();   

            echo json_encode(array('status' => true));          
        }
    }

    function restore($id)
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $id = decode($id);

        $update = array(
                    'flag_delete'   => 'N',
                    'restore_at'    => date('Y-m-d H:i:s'),
                    'restore_by'    => $this->session->userdata('id'),
                );
        
        $this->db->trans_start();
        
        $this->M_members->update_members_by_id($id, $update);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode(array('status' => false));

        } else {
            $this->db->trans_commit();   

            echo json_encode(array('status' => true));          
        }
    }

    function accept($id)
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $id = decode($id);

        $edit = $this->M_members->get_members_by_id($id);

        $kode = $this->M_members->generate_kode_member($edit->clients_id);

        if($kode['status']){
            $kode_member            = $kode['kode_member'];
            $kode_member_prefixs    = $kode['kode_member_prefixs'];

            $update = array(
                        'kode_member'           => $kode_member,
                        'kode_member_prefixs'   => $kode_member_prefixs,
                        'flag_status'           => 'A',
                        'accepted_at'           => date('Y-m-d H:i:s'),
                        'accepted_by'           => $this->session->userdata('id'),
                        'rejected_at'           => null,
                        'rejected_by'           => null,
                    );

            $update_clients = array(
                        'kode_member_last'  => $kode_member,
                        'updated_at'        => date('Y-m-d H:i:s'),
                        'updated_by'        => $this->session->userdata('id'),
                    );
            
            $this->db->trans_start();
            
            $this->M_members->update_members_by_id($id, $update);
            $this->M_clients->update_clients_by_id($edit->clients_id, $update_clients);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();

                echo json_encode(array('status' => 0));

            } else {
                $this->db->trans_commit();   

                echo json_encode(array('status' => 1));          
            }
        } else {
            echo json_encode(array('status' => 2));
        }
    }

    function reject($id)
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $id = decode($id);

        $update = array(
                    'flag_status'   => 'R',
                    'rejected_at'    => date('Y-m-d H:i:s'),
                    'rejected_by'    => $this->session->userdata('id'),
                );
        
        $this->db->trans_start();
        
        $this->M_members->update_members_by_id($id, $update);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode(array('status' => false));

        } else {
            $this->db->trans_commit();   

            echo json_encode(array('status' => true));          
        }
    }

    function export_excel(){
        $registers      = $this->M_members->export_data_registers();
        $spreadsheet    = new Spreadsheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

        $sheet = $spreadsheet->getActiveSheet(0)->setTitle("LAPORAN DATA REGISTER");

        /* 
        |-----------------------------------------------------------------------------
        | STYLE
        |-----------------------------------------------------------------------------
        */


        $styleTableHeader = [
            'font' => [
                'bold' => true,
                'size' => 11,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'BDD7EE',
                ],
                'endColor' => [
                    'argb' => 'BDD7EE',
                ],
            ],
        ];

        $styleTableBodyNonDelete = [
            'font' => [
                'bold' => false,
                'size' => 12,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $styleTableBodyDelete = [
            'font' => [
                'bold' => false,
                'size' => 12,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'e87c87',
                ],
                'endColor' => [
                    'argb' => 'e87c87',
                ],
            ],
        ];

        /* 
        |-----------------------------------------------------------------------------
        | HEADER
        |-----------------------------------------------------------------------------
        */ 
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(9);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(45);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(25);

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Member');
        $sheet->setCellValue('C1', 'Waktu Daftar');
        $sheet->setCellValue('D1', 'Nama Member');
        $sheet->setCellValue('E1', 'Nomor HP');
        $sheet->setCellValue('F1', 'Email');
        $sheet->setCellValue('G1', 'Nama Permainan');
        $sheet->setCellValue('H1', 'Nama Bank');
        $sheet->setCellValue('I1', 'Nomor Rekening Bank');
        $sheet->setCellValue('J1', 'Nama Rekening Bank');
        $sheet->setCellValue('K1', 'Nomor Refferal');
        $sheet->setCellValue('L1', 'Nama Client');
        $sheet->setCellValue('M1', 'Status Register');
        $sheet->setCellValue('N1', 'Status Datetime');
        $sheet->setCellValue('O1', 'Status Data');

        $spreadsheet->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:O1')->applyFromArray($styleTableHeader);

        $i = 2;
        $nomor = 0;
        if($registers){
            foreach($registers as $row_registers){

                $nomor++;
                $kode_member            = $row_registers->kode_member;
                $created_at             = ($row_registers->created_at ? date('d M Y, H:i:s', strtotime($row_registers->created_at)) : '-');
                $nama_lengkap           = $row_registers->nama_lengkap;
                $no_hp                  = $row_registers->no_hp;
                $email                  = $row_registers->email;
                $nama_permainan         = $row_registers->nama_permainan;
                $nama_bank              = $row_registers->nama_bank;
                $nomor_rekening_bank    = $row_registers->nomor_rekening_bank;
                $nama_rekening_bank     = $row_registers->nama_rekening_bank;
                $nomor_referral         = $row_registers->nomor_referral;
                $nama_client            = $row_registers->nama_client;
                $flag_status            = $row_registers->flag_status;
                $flag_delete            = $row_registers->flag_delete;
                $delete_at              = ($row_registers->delete_at ? date('d M Y, H:i:s', strtotime($row_registers->delete_at)) : '');
                $rejected_at            = ($row_registers->rejected_at ? date('d M Y, H:i:s', strtotime($row_registers->rejected_at)) : '');
                $accepted_at            = ($row_registers->accepted_at ? date('d M Y, H:i:s', strtotime($row_registers->accepted_at)) : '');
                $status                 = '-';
                $status_time            = '-';

                if($flag_status == 'R'){
                    $status_time    = $rejected_at;
                    $status         = 'Rejected';
                } else if($flag_status == 'A'){
                    $status_time = $accepted_at;
                    $status         = 'Accepted';
                } else if($flag_status == 'W'){
                    $status         = 'Waiting';
                }

                if($flag_delete == 'Y'){
                    $status_data = "Delete\n" . $delete_at;
                } else {
                    $status_data = 'Active';
                }

                $sheet->setCellValue('A'.$i, $nomor);
                $sheet->setCellValue('B'.$i, $kode_member);
                $sheet->setCellValue('C'.$i, $created_at);
                $sheet->setCellValue('D'.$i, $nama_lengkap);
                $sheet->setCellValueExplicit('E' . $i, $no_hp,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('F'.$i, $email);
                $sheet->setCellValue('G'.$i, $nama_permainan);
                $sheet->setCellValue('H'.$i, $nama_bank);
                $sheet->setCellValueExplicit('I' . $i, $nomor_rekening_bank,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('J'.$i, $nama_rekening_bank);
                $sheet->setCellValueExplicit('K' . $i, $nomor_referral,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('L'.$i, $nama_client);
                $sheet->setCellValue('M'.$i, $status);
                $sheet->setCellValue('N'.$i, $status_time);
                $sheet->setCellValue('O'.$i, $status_data);

                $spreadsheet->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getAlignment()->setWrapText(true);

                if($flag_delete == 'Y'){
                    $spreadsheet->getActiveSheet()->getStyle('A'.$i.':O'.$i)->applyFromArray($styleTableBodyDelete);
                } else {
                    $spreadsheet->getActiveSheet()->getStyle('A'.$i.':O'.$i)->applyFromArray($styleTableBodyNonDelete);
                }

                $i++;
            }
        }

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Daftar Register - '.date('dMY_His').'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
