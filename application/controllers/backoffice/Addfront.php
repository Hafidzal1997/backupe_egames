<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addfront extends CI_Controller {

	public function __construct(){
        parent::__construct();

        ($this->session->userdata('roles_id') ? '' : redirect('backoffice/dashboard'));

        $this->load->model(array('M_withdraws', 'M_banks','M_permainans', 'M_members', 'M_deposits', 'M_settings' ,'M_clients'));
        $this->load->library(array('form_validation'));

        $this->roles_id = $this->session->userdata('roles_id');
        $this->layouts  = 'layouts/v_backoffice';
        $this->contents = 'backoffice/addfront/';
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

    // public function index()
	// {
    //     $user = $this->ion_auth->user()->row();
	// 	$data = [
	// 		'user' => $user,
	// 		'judul'	=> 'Soal',
	// 		'subjudul'=> 'Bank Soal'
    //     ];
        
    //     if($this->ion_auth->is_admin()){
    //         //Jika admin maka tampilkan semua matkul
    //         $data['matkul'] = $this->master->getAllMatkul();
    //     }else{
    //         //Jika bukan maka matkul dipilih otomatis sesuai matkul dosen
    //         $data['matkul'] = $this->soal->getMatkulDosen($user->username);
    //     }

	// 	$this->load->view('_templates/dashboard/_header.php', $data);
	// 	$this->load->view('soal/data');
	// 	$this->load->view('_templates/dashboard/_footer.php');
    // }
    function index()
    {
        $data = array(
                    'roles_id'  => $this->roles_id,
                    'clients'   => $this->M_clients->get_all_clients(),
                    'title'     => 'Form User',
                    'contents'  => $this->contents . 'add',
                );

        $this->load->view($this->layouts, $data);
    }
    
    public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'Soal',
            'subjudul'  => 'Edit Soal',
            'soal'      => $this->soal->getSoalById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('soal/detail');
		$this->load->view('_templates/dashboard/_footer.php');
    }
    
    public function add()
	{
        $user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'Soal',
            'subjudul'  => 'Buat Soal'
        ];

        if($this->ion_auth->is_admin()){
            //Jika admin maka tampilkan semua matkul
            $data['dosen'] = $this->soal->getAllDosen();
        }else{
            //Jika bukan maka matkul dipilih otomatis sesuai matkul dosen
            $data['dosen'] = $this->soal->getMatkulDosen($user->username);
        }

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('soal/add');
		$this->load->view('_templates/dashboard/_footer.php');
    }
    
    function manageforms()
    {        
        $this->form_validation->set_rules('nama', 'Nama Client', 'trim|required|xss_clean|callback__cek_nama_client');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            
        $this->form_validation->set_message('required', '{field} wajib diisi!');
        $this->form_validation->set_message('is_unique', '{field} sudah tersedia!');

        if($this->form_validation->run() == FALSE){
            
            $data = array(
                'title'     => 'Tambah Clients',
                'contents'  => $this->contents . 'manageforms',
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

    public function edit($id)
	{
		$user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'Soal',
            'subjudul'  => 'Edit Soal',
            'soal'      => $this->soal->getSoalById($id),
        ];
        
        if($this->ion_auth->is_admin()){
            //Jika admin maka tampilkan semua matkul
            $data['dosen'] = $this->soal->getAllDosen();
        }else{
            //Jika bukan maka matkul dipilih otomatis sesuai matkul dosen
            $data['dosen'] = $this->soal->getMatkulDosen($user->username);
        }

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('soal/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data($id=null, $dosen=null)
	{
		$this->output_json($this->soal->getDataSoal($id, $dosen), false);
    }

    public function validasi()
    {
        if($this->ion_auth->is_admin()){
            $this->form_validation->set_rules('dosen_id', 'Dosen', 'required');
        }
        // $this->form_validation->set_rules('soal', 'Soal', 'required');
        // $this->form_validation->set_rules('jawaban_a', 'Jawaban A', 'required');
        // $this->form_validation->set_rules('jawaban_b', 'Jawaban B', 'required');
        // $this->form_validation->set_rules('jawaban_c', 'Jawaban C', 'required');
        // $this->form_validation->set_rules('jawaban_d', 'Jawaban D', 'required');
        // $this->form_validation->set_rules('jawaban_e', 'Jawaban E', 'required');
        $this->form_validation->set_rules('jawaban', 'Kunci Jawaban', 'required');
        $this->form_validation->set_rules('bobot', 'Bobot Soal', 'required|max_length[2]');
    }

    public function file_config()
    {
        $allowed_type 	= [
            "image/jpeg", "image/jpg", "image/png", "image/gif",
            "audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav",
            "video/mp4", "application/octet-stream"
        ];
        $config['upload_path']      = FCPATH.'uploads/bank_soal/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif|mpeg|mpg|mpeg3|mp3|wav|wave|mp4';
        $config['encrypt_name']     = TRUE;
        
        return $this->load->library('upload', $config);
    }
    
    public function save()
    {
        $method = $this->input->post('method', true);
        $this->validasi();
        $this->file_config();

        
        if($this->form_validation->run() === FALSE){
            $method==='add'? $this->add() : $this->edit();
        }else{
            $data = [
                'soal'      => $this->input->post('soal', true),
                'jawaban'   => $this->input->post('jawaban', true),
                'bobot'     => $this->input->post('bobot', true),
            ];
            
            $abjad = ['a', 'b', 'c', 'd', 'e'];
            
            // Inputan Opsi
            foreach ($abjad as $abj) {
                $data['opsi_'.$abj]    = $this->input->post('jawaban_'.$abj, true);
            }

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $img_src = FCPATH.'uploads/bank_soal/';
                $getsoal = $this->soal->getSoalById($this->input->post('id_soal', true));
                
                $error = '';
                if($key === 'file_soal'){
                    if(!empty($_FILES['file_soal']['name'])){
                        if (!$this->upload->do_upload('file_soal')){
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File Soal Error');
                            exit();
                        }else{
                            if($method === 'edit'){
                                if(!unlink($img_src.$getsoal->file)){
                                    show_error('Error saat delete gambar <br/>'.var_dump($getsoal), 500, 'Error Edit Gambar');
                                    exit();
                                }
                            }
                            $data['file'] = $this->upload->data('file_name');
                            $data['tipe_file'] = $this->upload->data('file_type');
                        }
                    }
                }else{
                    $file_abj = 'file_'.$abjad[$i];
                    if(!empty($_FILES[$file_abj]['name'])){    
                        if (!$this->upload->do_upload($key)){
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File Opsi '.strtoupper($abjad[$i]).' Error');
                            exit();
                        }else{
                            if($method === 'edit'){
                                if(!unlink($img_src.$getsoal->$file_abj)){
                                    show_error('Error saat delete gambar', 500, 'Error Edit Gambar');
                                    exit();
                                }
                            }
                            $data[$file_abj] = $this->upload->data('file_name');
                        }
                    }
                    $i++;
                }
            }
                
            if($this->ion_auth->is_admin()){
                $pecah = $this->input->post('dosen_id', true);
                $pecah = explode(':', $pecah);
                $data['dosen_id'] = $pecah[0];
                $data['matkul_id'] = end($pecah);
            }else{
                $data['dosen_id'] = $this->input->post('dosen_id', true);
                $data['matkul_id'] = $this->input->post('matkul_id', true);
            }

            if($method==='add'){
                //push array
                $data['created_on'] = time();
                $data['updated_on'] = time();
                //insert data
                $this->master->create('tb_soal', $data);
            }else if($method==='edit'){
                //push array
                $data['updated_on'] = time();
                //update data
                $id_soal = $this->input->post('id_soal', true);
                $this->master->update('tb_soal', $data, 'id_soal', $id_soal);
            }else{
                show_error('Method tidak diketahui', 404);
            }
            redirect('soal');
        }
    }

    public function delete()
    {
        $chk = $this->input->post('checked', true);
        
        // Delete File
        foreach($chk as $id){
            $abjad = ['a', 'b', 'c', 'd', 'e'];
            $path = FCPATH.'uploads/bank_soal/';
            $soal = $this->soal->getSoalById($id);
            // Hapus File Soal
            if(!empty($soal->file)){
                if(file_exists($path.$soal->file)){
                    unlink($path.$soal->file);
                }
            }
            //Hapus File Opsi
            $i = 0; //index
            foreach ($abjad as $abj) {
                $file_opsi = 'file_'.$abj;
                if(!empty($soal->$file_opsi)){
                    if(file_exists($path.$soal->$file_opsi)){
                        unlink($path.$soal->$file_opsi);
                    }
                }
            }
        }

        if(!$chk){
            $this->output_json(['status'=>false]);
        }else{
            if($this->master->delete('tb_soal', $chk, 'id_soal')){
                $this->output_json(['status'=>true, 'total'=>count($chk)]);
            }
        }
    }







    // public function __construct(){
	// 	parent::__construct();
	// }
	public function __destruct(){
		parent::__destruct();
	}
    public function save_form(){
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
    public function save_response(){
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
    public function delete_form(){
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