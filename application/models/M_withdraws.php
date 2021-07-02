<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_withdraws extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function fetch_data_withdraws($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
    {
        $where                  = "";
        $clients_id             = $this->input->post('clients_id');
        $kode_member            = $this->input->post('kode_member');
        $flag_status            = $this->input->post('flag_status');
        $flag_delete            = $this->input->post('flag_delete');

        $filter_created_at      = $this->input->post('filter_created_at');
        $created_at_awal        = $this->input->post('created_at_awal');
        $created_at_akhir       = $this->input->post('created_at_akhir');

        $filter_accepted_at     = $this->input->post('filter_accepted_at');
        $accepted_at_awal       = $this->input->post('accepted_at_awal');
        $accepted_at_akhir      = $this->input->post('accepted_at_akhir');

        $filter_rejected_at     = $this->input->post('filter_rejected_at');
        $rejected_at_awal       = $this->input->post('rejected_at_awal');
        $rejected_at_akhir      = $this->input->post('rejected_at_akhir');
        

        if($kode_member){
            $where .= " AND t1.kode_member = '".$kode_member."' ";
        }

        if($clients_id){
            $where .= " AND t4.clients_id = '".$clients_id."' ";
        }

        if($flag_status){
            $where .= " AND t1.flag_status = '".$flag_status."' ";
        }

        if(!$flag_delete){
            $where .= " AND t1.flag_delete = 'N' ";
        }

        if($filter_created_at){
            $created_at_awal = date('Y-m-d', strtotime(str_replace('/', '-', $created_at_awal)));
            $created_at_akhir = date('Y-m-d', strtotime(str_replace('/', '-', $created_at_akhir)));

            $where .= " AND (DATE(t1.created_at) BETWEEN '".$created_at_awal."' AND '".$created_at_akhir."') ";
        }

        if($filter_accepted_at){
            $accepted_at_awal = date('Y-m-d', strtotime(str_replace('/', '-', $accepted_at_awal)));
            $accepted_at_akhir = date('Y-m-d', strtotime(str_replace('/', '-', $accepted_at_akhir)));

            $where .= " AND (DATE(t1.accepted_at) BETWEEN '".$accepted_at_awal."' AND '".$accepted_at_akhir."') ";
        }

        if($filter_rejected_at){
            $rejected_at_awal = date('Y-m-d', strtotime(str_replace('/', '-', $rejected_at_awal)));
            $rejected_at_akhir = date('Y-m-d', strtotime(str_replace('/', '-', $rejected_at_akhir)));

            $where .= " AND (DATE(t1.rejected_at) BETWEEN '".$rejected_at_awal."' AND '".$rejected_at_akhir."') ";
        }

        $sql = "
            SELECT 
                (@row:=@row+1) AS nomor
                , t1.id
                , t1.kode_member
                , t1.permainans_id
                , t1.banks_id
                , t1.nomor_rekening_bank
                , t1.nama_rekening_bank
                , t1.jumlah_withdraw
                , t1.flag_delete
                , t1.created_at
                , t1.accepted_at
                , t1.rejected_at
                , t1.flag_status
                , t2.nama_permainan
                , t3.nama_bank
                , t4.nama_lengkap
                , t4.no_hp
                , t4.email
                , t5.nama as nama_client
                , t5.alamat as alamat_client
            FROM 
                withdraws AS t1 
            JOIN permainans as t2 ON t1.permainans_id = t2.id
            JOIN banks as t3 ON t1.banks_id = t3.id
            LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                AND t1.clients_id = t4.clients_id
            LEFT JOIN clients as t5 ON t4.clients_id = t5.id
                AND t1.clients_id = t5.id
                , (SELECT @row := 0) r 
            WHERE 1=1 
                ".$where."
        ";
        
        $data['totalData'] = $this->db->query($sql)->num_rows();
        
        if( ! empty($like_value))
        {
            $jumlah_withdraw = $like_value;
            $jumlah_withdraw = str_replace(',', '', $jumlah_withdraw);
            $jumlah_withdraw = str_replace('.', '', $jumlah_withdraw);
            
            $sql .= " AND (
                        t1.id LIKE '%".$this->db->escape_like_str($like_value)."%' 
                        OR t1.kode_member LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nomor_rekening_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_rekening_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.jumlah_withdraw LIKE '%".$this->db->escape_like_str($jumlah_withdraw)."%'
                        OR t2.nama_permainan LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t3.nama_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.created_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.accepted_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.rejected_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t4.nama_lengkap LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t4.no_hp LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t4.email LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t5.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t5.alamat LIKE '%".$this->db->escape_like_str($like_value)."%'
                    ) ";
        }
        
        $data['totalFiltered']  = $this->db->query($sql)->num_rows();
        
        $columns_order_by = array( 
            0 => 'nomor',
            1 => 't1.id',
            2 => 't1.kode_member',
            3 => 't1.created_at',
            4 => 't1.jumlah_withdraw',
            5 => 't2.nama_permainan',
            6 => 't3.nama_bank',
            7 => 't1.flag_status',
        );
        
        $sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
        $sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
        
        $data['query'] = $this->db->query($sql);
        return $data;
    }

    function export_data_withdraws(){
        $where                  = "";
        $clients_id             = $this->input->post('clients_id');
        $kode_member            = $this->input->post('kode_member');
        $flag_status            = $this->input->post('flag_status');
        $flag_delete            = $this->input->post('flag_delete');

        $filter_created_at      = $this->input->post('filter_created_at');
        $created_at_awal        = $this->input->post('created_at_awal');
        $created_at_akhir       = $this->input->post('created_at_akhir');

        $filter_accepted_at     = $this->input->post('filter_accepted_at');
        $accepted_at_awal       = $this->input->post('accepted_at_awal');
        $accepted_at_akhir      = $this->input->post('accepted_at_akhir');

        $filter_rejected_at     = $this->input->post('filter_rejected_at');
        $rejected_at_awal       = $this->input->post('rejected_at_awal');
        $rejected_at_akhir      = $this->input->post('rejected_at_akhir');
        

        if($kode_member){
            $where .= " AND t1.kode_member = '".$kode_member."' ";
        }

        if($clients_id){
            $where .= " AND t4.clients_id = '".$clients_id."' ";
        }

        if($flag_status){
            $where .= " AND t1.flag_status = '".$flag_status."' ";
        }

        if(!$flag_delete){
            $where .= " AND t1.flag_delete = 'N' ";
        }

        if($filter_created_at){
            $created_at_awal = date('Y-m-d', strtotime(str_replace('/', '-', $created_at_awal)));
            $created_at_akhir = date('Y-m-d', strtotime(str_replace('/', '-', $created_at_akhir)));

            $where .= " AND (DATE(t1.created_at) BETWEEN '".$created_at_awal."' AND '".$created_at_akhir."') ";
        }

        if($filter_accepted_at){
            $accepted_at_awal = date('Y-m-d', strtotime(str_replace('/', '-', $accepted_at_awal)));
            $accepted_at_akhir = date('Y-m-d', strtotime(str_replace('/', '-', $accepted_at_akhir)));

            $where .= " AND (DATE(t1.accepted_at) BETWEEN '".$accepted_at_awal."' AND '".$accepted_at_akhir."') ";
        }

        if($filter_rejected_at){
            $rejected_at_awal = date('Y-m-d', strtotime(str_replace('/', '-', $rejected_at_awal)));
            $rejected_at_akhir = date('Y-m-d', strtotime(str_replace('/', '-', $rejected_at_akhir)));

            $where .= " AND (DATE(t1.rejected_at) BETWEEN '".$rejected_at_awal."' AND '".$rejected_at_akhir."') ";
        }

        $sql = "
            SELECT 
                (@row:=@row+1) AS nomor
                , t1.id
                , t1.kode_member
                , t4.nama_lengkap
                , t4.no_hp
                , t4.email
                , t4.created_at as created_at_member
                , t1.permainans_id
                , t1.banks_id
                , t1.nomor_rekening_bank
                , t1.nama_rekening_bank
                , t1.jumlah_withdraw
                , t1.flag_delete
                , t1.delete_at
                , t1.created_at
                , t1.accepted_at
                , t1.rejected_at
                , t1.flag_status
                , t2.nama_permainan
                , t3.nama_bank
                , t5.nama as nama_client
                , t5.alamat as alamat_client
            FROM 
                withdraws AS t1 
            JOIN permainans as t2 ON t1.permainans_id = t2.id
            JOIN banks as t3 ON t1.banks_id = t3.id
            LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                AND t1.clients_id = t4.clients_id
            LEFT JOIN clients as t5 ON t4.clients_id = t5.id
                AND t1.clients_id = t5.id
                , (SELECT @row := 0) r 
            WHERE 1=1 
                ".$where."
            ORDER BY t1.created_at ASC, t1.kode_member ASC
        ";
        
        return $this->db->query($sql)->result();
    }

    function get_total_all_withdraws_waiting()
    {
        $current_date = date('Y-m-d');

        $this->db->where('DATE(created_at) <', $current_date);
        $this->db->where('flag_delete', 'N');
        $this->db->where('flag_status', 'W');
        return $this->db->count_all_results('withdraws');
    }

    function get_total_all_withdraws_waiting_today()
    {
        $current_date = date('Y-m-d');

        $this->db->where('DATE(created_at)', $current_date);
        $this->db->where('flag_delete', 'N');
        $this->db->where('flag_status', 'W');
        return $this->db->count_all_results('withdraws');
    }

    function get_all_sum_withdraws_by_kode_member($kode_member, $clients_id)
    {
        $this->db->select_sum('t1.total_withdraw');
        $this->db->where('t1.kode_member', $kode_member);
        $this->db->where('t1.clients_id', $clients_id);
        $this->db->where('t1.flag_status', 'A');
        $this->db->where('t1.flag_delete', 'N');
        $this->db->from('withdraws as t1');

        $query  = $this->db->get();
        $total  = 0;
        if($query->num_rows() > 0){
            $row    = $query->row();
            $total  = $row->total_withdraw;
        }
        return $total;
    }

    function get_total_all_withdraws_accepted()
    {
        $this->db->select_sum('t1.total_withdraw');
        $this->db->where('t1.flag_delete', 'N');
        $this->db->where('t1.flag_status', 'A');
        $this->db->from('withdraws as t1');

        $query = $this->db->get();
        $total = 0;
        if($query->num_rows() > 0){
            $row    = $query->row();
            $total  = $row->total_withdraw;
        }

        return $total;
    }

    function get_total_all_withdraws_accepted_summary_dashboard($clients_id = null, $filter_tanggal = null, $tanggal_awal = null, $tanggal_akhir = null)
    {
        $where = '';

        if($filter_tanggal && $tanggal_awal && $tanggal_akhir){
            $where .= " AND (DATE(t1.created_at) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."') ";
        }

        if($clients_id){
            $where .= " AND t1.clients_id = '".$clients_id."' ";
        }

        $sql = "SELECT SUM(t1.total_withdraw) as total
                FROM withdraws as t1
                WHERE t1.flag_delete = 'N'
                    AND t1.flag_status = 'A'
                    ".$where."
                ";
        $query = $this->db->query($sql);
        $total = 0;

        if($query->num_rows() > 0){
            $row    = $query->row();
            $total  = ($row->total ? $row->total : 0);
        }

        return $total;
    }

    function get_all_withdraws()
    {
        return $this->db->get('withdraws')->result();
    }

    function get_withdraws_by($data)
    {
        return $this->db->get_where('withdraws', $data);
    }

    function get_withdraws_by_id($id)
    {
        $sql = "SELECT 
                t1.*
                , t4.nama_lengkap
                , t4.no_hp
                , t4.email
                , t4.created_at as created_at_member
                , t2.nama_permainan
                , t3.nama_bank
                , t5.nama as nama_client
                , t5.alamat as alamat_client
            FROM 
                withdraws AS t1 
            JOIN permainans as t2 ON t1.permainans_id = t2.id
            JOIN banks as t3 ON t1.banks_id = t3.id
            LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                AND t1.clients_id = t4.clients_id
            LEFT JOIN clients as t5 ON t4.clients_id = t5.id
                AND t1.clients_id = t5.id
            WHERE t1.flag_delete = 'N'
                AND t1.id = '".$id."' ";
        return $this->db->query($sql)->row();
    }

    function update_batch_withdraws_by($column, $data)
    {
        return $this->db->update_batch('withdraws', $data, $column); 
    }

    function update_withdraws_by_id($id, $data)
    {
        return $this->db->update('withdraws', $data, array('id' => $id));
    }

    function add_withdraws($data)
    {
        $this->db->insert('withdraws', $data);
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
        return $this->db->delete('withdraws', array('id' => $id));
    }

    function fetch_data_withdraws_hari_ini($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
    {
        $tanggal_hari_ini   = date('Y-m-d');
        $where              = " AND (DATE(t1.created_at) BETWEEN '".$tanggal_hari_ini."' AND '".$tanggal_hari_ini."') ";

        $clients_id         = $this->input->post('clients_id');
        $kode_member        = $this->input->post('kode_member');
        $flag_status        = $this->input->post('flag_status');
        $flag_delete        = $this->input->post('flag_delete');        

        if($kode_member){
            $where .= " AND t1.kode_member = '".$kode_member."' ";
        }

        if($clients_id){
            $where .= " AND t4.clients_id = '".$clients_id."' ";
        }

        if($flag_status){
            $where .= " AND t1.flag_status = '".$flag_status."' ";
        }

        if(!$flag_delete){
            $where .= " AND t1.flag_delete = 'N' ";
        }

        $sql = "
            SELECT 
                (@row:=@row+1) AS nomor
                , t1.id
                , t1.kode_member
                , t1.permainans_id
                , t1.banks_id
                , t1.nomor_rekening_bank
                , t1.nama_rekening_bank
                , t1.jumlah_withdraw
                , t1.flag_delete
                , t1.created_at
                , t1.accepted_at
                , t1.rejected_at
                , t1.flag_status
                , t2.nama_permainan
                , t3.nama_bank
                , t4.nama_lengkap
                , t4.no_hp
                , t4.email
                , t5.nama as nama_client
                , t5.alamat as alamat_client
            FROM 
                withdraws AS t1 
            JOIN permainans as t2 ON t1.permainans_id = t2.id
            JOIN banks as t3 ON t1.banks_id = t3.id
            LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                AND t1.clients_id = t4.clients_id
            LEFT JOIN clients as t5 ON t4.clients_id = t5.id
                AND t1.clients_id = t5.id
                , (SELECT @row := 0) r 
            WHERE 1=1 
                ".$where."
        ";
        
        $data['totalData'] = $this->db->query($sql)->num_rows();
        
        if( ! empty($like_value))
        {
            $jumlah_withdraw = $like_value;
            $jumlah_withdraw = str_replace(',', '', $jumlah_withdraw);
            $jumlah_withdraw = str_replace('.', '', $jumlah_withdraw);
            
            $sql .= " AND (
                        t1.id LIKE '%".$this->db->escape_like_str($like_value)."%' 
                        OR t1.kode_member LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nomor_rekening_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_rekening_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.jumlah_withdraw LIKE '%".$this->db->escape_like_str($jumlah_withdraw)."%'
                        OR t2.nama_permainan LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t3.nama_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.created_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.accepted_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.rejected_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t4.nama_lengkap LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t4.no_hp LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t4.email LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t5.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t5.alamat LIKE '%".$this->db->escape_like_str($like_value)."%'
                    ) ";
        }
        
        $data['totalFiltered']  = $this->db->query($sql)->num_rows();
        
        $columns_order_by = array( 
            0 => 'nomor',
            1 => 't1.id',
            2 => 't1.kode_member',
            3 => 't1.created_at',
            4 => 't1.jumlah_withdraw',
            5 => 't2.nama_permainan',
            6 => 't3.nama_bank',
            7 => 't1.flag_status',
        );
        
        $sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
        $sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
        
        $data['query'] = $this->db->query($sql);
        return $data;
    }

    function export_data_withdraws_hari_ini(){
        $tanggal_hari_ini   = date('Y-m-d');
        $where              = " AND (DATE(t1.created_at) BETWEEN '".$tanggal_hari_ini."' AND '".$tanggal_hari_ini."') ";

        $clients_id         = $this->input->post('clients_id');
        $kode_member        = $this->input->post('kode_member');
        $flag_status        = $this->input->post('flag_status');
        $flag_delete        = $this->input->post('flag_delete');
        

        if($kode_member){
            $where .= " AND t1.kode_member = '".$kode_member."' ";
        }

        if($clients_id){
            $where .= " AND t4.clients_id = '".$clients_id."' ";
        }

        if($flag_status){
            $where .= " AND t1.flag_status = '".$flag_status."' ";
        }

        if(!$flag_delete){
            $where .= " AND t1.flag_delete = 'N' ";
        }

        $sql = "
            SELECT 
                (@row:=@row+1) AS nomor
                , t1.id
                , t1.kode_member
                , t4.nama_lengkap
                , t4.no_hp
                , t4.email
                , t4.created_at as created_at_member
                , t1.permainans_id
                , t1.banks_id
                , t1.nomor_rekening_bank
                , t1.nama_rekening_bank
                , t1.jumlah_withdraw
                , t1.flag_delete
                , t1.delete_at
                , t1.created_at
                , t1.accepted_at
                , t1.rejected_at
                , t1.flag_status
                , t2.nama_permainan
                , t3.nama_bank
                , t5.nama as nama_client
                , t5.alamat as alamat_client
            FROM 
                withdraws AS t1 
            JOIN permainans as t2 ON t1.permainans_id = t2.id
            JOIN banks as t3 ON t1.banks_id = t3.id
            LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                AND t1.clients_id = t4.clients_id
            LEFT JOIN clients as t5 ON t4.clients_id = t5.id
                AND t1.clients_id = t5.id
                , (SELECT @row := 0) r 
            WHERE 1=1 
                ".$where."
            ORDER BY t1.created_at ASC, t1.kode_member ASC
        ";
        
        return $this->db->query($sql)->result();
    }
}
