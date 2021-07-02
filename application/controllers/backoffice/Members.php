<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Members extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        ($this->session->userdata('roles_id') ? '' : redirect('backoffice/dashboard'));

        $this->load->model(array('M_members', 'M_settings', 'M_banks','M_permainans', 'M_clients'));
        $this->load->library(array('form_validation'));

        $this->roles_id = $this->session->userdata('roles_id');
        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/members/';
    }

    function index()
    {
        $data = array(
                    'roles_id'  => $this->roles_id,
                    'clients'   => $this->M_clients->get_all_clients(),
                    'title'     => 'Daftar Data Member',
                    'contents'  => $this->contents . 'v_index',
                );

        $this->load->view($this->layouts, $data);
    }

    function members_json()
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $requestData    = $_REQUEST;
        $fetch          = $this->M_members->fetch_data_members($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
        
        $totalData      = $fetch['totalData'];
        $totalFiltered  = $fetch['totalFiltered'];
        $query          = $fetch['query'];

        $data   = array();
        $nomor  = 1;
        foreach($query->result() as $row)
        { 
            $nestedData = array(); 

            $option = '';
            $checkbox = '';           

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
                                '.($row->nama_client ? '<br>'.$row->nama_client : '').'
                                ';
            $nama_bank      = $row->nomor_rekening_bank .'
                                <br>' .$row->nama_bank . '
                                <br>'.$row->nama_rekening_bank;

            $created_at = '-';
            if($row->created_at){
                $created_at = date('d M Y', strtotime($row->created_at));
                $created_at .= '<br>';
                $created_at .= date('H:i:s', strtotime($row->created_at));
            }

            $option = '<div class="btn-group">
                            <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cogs"></i>
                            </button>
                            <div class="dropdown-menu">';

            $option .= '<a href="javascript:;" class="dropdown-item btn-detail-deposit text-info" data-url="'.base_url('backoffice/members/detail-deposit/' . encode($row->kode_member)).'" title="Detail Deposit">
                            <strong>
                                <i class="fa fa-cloud-download mr-2"></i> Histori Deposit
                            </strong>
                        </a>
                        <a href="javascript:;" class="dropdown-item btn-detail-withdraw text-primary" data-url="'.base_url('backoffice/members/detail-withdraw/' . encode($row->kode_member)).'" title="Detail Withdraw">
                            <strong>
                                <i class="fa fa-cloud-upload mr-2"></i> Histori Withdraw
                            </strong>
                        </a>';   

            if($row->flag_delete == 'N'){    

                if($this->roles_id == 1){

                    $option .= '<div class="dropdown-divider"></div>';

                    $option .= '<a class="dropdown-item text-dark" href="'.base_url('backoffice/members/edit/' . encode($row->id)).'">
                                    <strong>
                                        <i class="fa fa-edit mr-2"></i> Ubah Data
                                    </strong>
                                </a>
                                <a href="javascript:;" class="dropdown-item text-danger btn-delete" data-url="'.base_url('backoffice/members/delete/' . encode($row->id)).'">
                                    <strong>
                                        <i class="fa fa-trash-o mr-2"></i> Hapus Data
                                    </strong>
                                </a>';
                }

                $checkbox .= '<input type="checkbox" class="posting" name="posting[]" value="'.$row->id.'">';

            } else {
                if($this->roles_id == 1){
                    $option .= '<div class="dropdown-divider"></div>';
                    $option .= '<a class="dropdown-item text-primary btn-restore" href="javascript:;" data-url="'.base_url('backoffice/members/restore/' . encode($row->id)).'" >
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
            $nestedData[]   = number_format($row->nominal_saldo);
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

    function edit($id = null)
    {
        if(!$id){
            $this->session->set_flashdata('warning', 'Data tidak tersedia!');
            redirect('backoffice/members');
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
                redirect('backoffice/members');
            }

            $data = array(
                'edit'          => $edit,
                'banks'         => $this->M_banks->get_all_banks(),
                'permainans'    => $this->M_permainans->get_all_permainans(),
                'clients'       => $this->M_clients->get_all_clients(),
                'title'         => 'Ubah Member',
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

            redirect('backoffice/members');
        }
    }

    function detail_deposit($kode_member)
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $kode_member = decode($kode_member);

        $data = array(
                    'kode_member'  => $kode_member,
                );

        $this->load->view($this->contents . 'v_detail_deposit', $data);

    }

    function detail_withdraw($kode_member)
    {
        (!$this->input->is_ajax_request() ? show_404() : '');

        $kode_member = decode($kode_member);

        $data = array(
                    'kode_member'  => $kode_member,
                );

        $this->load->view($this->contents . 'v_detail_withdraw', $data);

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

    function export_excel(){
        $members      = $this->M_members->export_data_members();
        $spreadsheet    = new Spreadsheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

        $sheet = $spreadsheet->getActiveSheet(0)->setTitle("LAPORAN DATA MEMBER");

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
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(25);

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Member');
        $sheet->setCellValue('C1', 'Waktu Daftar');
        $sheet->setCellValue('D1', 'Nama Member');
        $sheet->setCellValue('E1', 'Nominal Saldo');
        $sheet->setCellValue('F1', 'Nomor HP');
        $sheet->setCellValue('G1', 'Email');
        $sheet->setCellValue('H1', 'Nama Permainan');
        $sheet->setCellValue('I1', 'Nama Bank');
        $sheet->setCellValue('J1', 'Nomor Rekening Bank');
        $sheet->setCellValue('K1', 'Nama Rekening Bank');
        $sheet->setCellValue('L1', 'Nomor Refferal');
        $sheet->setCellValue('M1', 'Nama Client');
        $sheet->setCellValue('N1', 'Status Register');
        $sheet->setCellValue('O1', 'Status Datetime');
        $sheet->setCellValue('P1', 'Status Data');

        $spreadsheet->getActiveSheet()->getStyle('A1:P1')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:P1')->applyFromArray($styleTableHeader);

        $i = 2;
        $nomor = 0;
        if($members){
            foreach($members as $row_members){

                $nomor++;
                $kode_member            = $row_members->kode_member;
                $created_at             = ($row_members->created_at ? date('d M Y, H:i:s', strtotime($row_members->created_at)) : '-');
                $nominal_saldo          = $row_members->nominal_saldo;
                $nama_lengkap           = $row_members->nama_lengkap;
                $no_hp                  = $row_members->no_hp;
                $email                  = $row_members->email;
                $nama_permainan         = $row_members->nama_permainan;
                $nama_bank              = $row_members->nama_bank;
                $nomor_rekening_bank    = $row_members->nomor_rekening_bank;
                $nama_rekening_bank     = $row_members->nama_rekening_bank;
                $nomor_referral         = $row_members->nomor_referral;
                $nama_client            = $row_members->nama_client;
                $flag_status            = $row_members->flag_status;
                $flag_delete            = $row_members->flag_delete;
                $delete_at              = ($row_members->delete_at ? date('d M Y, H:i:s', strtotime($row_members->delete_at)) : '');
                $rejected_at            = ($row_members->rejected_at ? date('d M Y, H:i:s', strtotime($row_members->rejected_at)) : '');
                $accepted_at            = ($row_members->accepted_at ? date('d M Y, H:i:s', strtotime($row_members->accepted_at)) : '');
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
                $sheet->setCellValueExplicit('E' . $i, $nominal_saldo,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $sheet->setCellValueExplicit('F' . $i, $no_hp,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('G'.$i, $email);
                $sheet->setCellValue('H'.$i, $nama_permainan);
                $sheet->setCellValue('I'.$i, $nama_bank);
                $sheet->setCellValueExplicit('J' . $i, $nomor_rekening_bank,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('K'.$i, $nama_rekening_bank);
                $sheet->setCellValueExplicit('L' . $i, $nomor_referral,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('M'.$i, $nama_client);
                $sheet->setCellValue('N'.$i, $status);
                $sheet->setCellValue('O'.$i, $status_time);
                $sheet->setCellValue('P'.$i, $status_data);

                $spreadsheet->getActiveSheet()->getStyle('A'.$i.':P'.$i)->getAlignment()->setWrapText(true);

                if($flag_delete == 'Y'){
                    $spreadsheet->getActiveSheet()->getStyle('A'.$i.':P'.$i)->applyFromArray($styleTableBodyDelete);
                } else {
                    $spreadsheet->getActiveSheet()->getStyle('A'.$i.':P'.$i)->applyFromArray($styleTableBodyNonDelete);
                }

                $i++;
            }
        }

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Daftar Member - '.date('dMY_His').'.xlsx"');
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
