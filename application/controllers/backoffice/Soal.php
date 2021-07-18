<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soal extends CI_Controller {

	public function __construct(){
        parent::__construct();

        ($this->session->userdata('roles_id') ? '' : redirect('backoffice/dashboard'));

        $this->load->model(array('M_withdraws','M_forms', 'M_banks','M_permainans', 'M_members', 'M_deposits', 'M_settings' ,'M_clients'));
        $this->load->library(array('form_validation'));

        $this->roles_id = $this->session->userdata('roles_id');
        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/soal/';
        
		// parent::__construct();
		// if (!$this->ion_auth->logged_in()){
		// 	redirect('auth');
		// }else if ( !$this->ion_auth->is_admin() && !$this->ion_auth->in_group('dosen') ){
		// 	show_error('Hanya Administrator dan dosen yang diberi hak untuk mengakses halaman ini, <a href="'.base_url('dashboard').'">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		// }
		// $this->load->library(['datatables', 'form_validation']);// Load Library Ignited-Datatables
		// $this->load->helper('my');// Load Library Ignited-Datatables
		// $this->load->model('Master_model', 'master');
		// $this->load->model('Soal_model', 'soal');
		// $this->form_validation->set_error_delimiters('','');
	}

	public function output_json($data, $encode = true)
	{
        if($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    function index()
    {
        
        $data = array(
                    'roles_id'  => $this->roles_id,
                    'clients'   => $this->M_forms->getAll(),
                    'title'     => 'Formulir',
                    'contents'  => $this->contents . 'add',
                );

        $this->load->view($this->layouts, $data);
    }
    
    function manageforms()
    {        
        $data = array(
            'title'     => 'Tambah Form',
            'contents'  => $this->contents . 'manageforms',
        );

        $this->load->view($this->layouts, $data);

    }

    function form()
    {        
        $data = array(
            'title'     => 'OKE',
            'contents'  => $this->contents . 'form',
        );

        $this->load->view($this->layouts, $data);

    }

    






    function save_form(){
        extract($_POST);
        $resp = array();
        $loop = true;
        $code = $form_code;
        if(empty($form_code)){
            while($loop == true){
                $code=mt_rand(0,9999999999);
                $code = sprintf("%'.09d",$code);
                $chk = $this->conn->query("SELECT * FROM `form_list` where form_code = '$code' ")->num_rows;
                if($chk <= 0)
                    break;
            }
        }
        $fname = $code.".html";
        $create_form = file_put_contents("../forms/".$fname,$form_data);
        if(!$create_form){
            $resp['status'] = 'failed';
            $resp['error'] = 'error occured while saving the form';
            return json_encode($resp);
            exit;
        }
        $data = " form_code = '$code' ";
        $data .= ", title = '$title' ";
        $data.= ", description = '$description' ";
        $data.= ", fname = '$fname' ";

        if(empty($form_code))
            $save_form = $this->conn->query("INSERT INTO `form_list` set $data ");
        else
            $save_form = $this->conn->query("UPDATE `form_list` set $data where form_code = '$form_code' ");
        if($save_form){
            $resp['status'] = 'success';
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);

    }
    function save_response(){
        extract($_POST);
        $data = " form_code = '$form_code' ";
        $rl_insert = $this->conn->query("INSERT INTO response_list set $data ");
        if($rl_insert){
            $rl_id = $this->conn->insert_id;
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
            return json_encode($resp);
            exit;
        }
        $data = "";
        if(isset($_POST['q'])){
            foreach($_POST['q'] as $k => $v){
                if(!empty($data)) $data .= ",";
                if(!is_array($_POST['q'][$k])){
                    $data .= " ('$rl_id','$k','$v') ";
                }else{
                    $ans = implode(", ",$_POST['q'][$k]);
                    $data .= " ('$rl_id','$k','$ans') ";
                }
            }
        }
        if(isset($_FILES['q']['tmp_name'])){
            foreach($_FILES['q']['tmp_name'] as $k => $v){
                if(!empty($data)) $data .= ",";
                if(!empty($_FILES['q']['tmp_name'][$k])){
                    $fname = time()."_".$_FILES['q']['name'][$k];
                    $move = move_uploaded_file($_FILES['q']['tmp_name'][$k],"../uploads/".$fname);
                    if($move){
                        $data .= " ('$rl_id','$k','$fname') ";
                    }
                }
            }
        }

        $save_resp = $this->conn->query("INSERT INTO `responses` (rl_id,meta_field,meta_value) VALUES $data");
        if($save_resp){
            $resp['status'] = 'success';
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }
    function delete_form(){
        extract($_POST);
        $rl_id = $this->conn->query("SELECT * FROM `response_list` where form_code = '$form_code'");
        $rl_id = $rl_id->num_rows > 0 ? $rl_id->fetch_array()['id'] : '';
        $del = $this->conn->query("DELETE FROM `form_list` where form_code = '$form_code'");
        $del1 = $this->conn->query("DELETE FROM `response_list` where form_code = '$form_code'");
        if($rl_id > 0)
        $del2 = $this->conn->query("DELETE FROM `responses` where rl_id = '$rl_id'");
        if(isset($this->conn->err)){
            $resp['status'] = 'failed';
            $resp['err'] = $this->conn->err;
        }else{
            unlink('../forms/'.$form_code.'.html');
            $resp['status'] = 'success';
        }
        return json_encode($resp);
    }

}