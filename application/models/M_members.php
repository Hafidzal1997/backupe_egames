<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_members extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function fetch_data_members($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
    {
        $where                  = " ";
        $flag_delete            = $this->input->post('flag_delete');
        $kode_member            = $this->input->post('kode_member');
        $kode_member            = $this->input->post('kode_member');
        $clients_id             = $this->input->post('clients_id');

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
            $where .= " AND t1.clients_id = '".$clients_id."' ";
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
            SELECT t1.*
            FROM(
                SELECT 
                    (@row:=@row+1) AS nomor
                    , t1.id
                    , t1.clients_id
                    , t1.kode_member
                    , t1.nama_lengkap
                    , t1.no_hp
                    , t1.email
                    , t1.permainans_id
                    , t1.banks_id
                    , t1.nomor_rekening_bank
                    , t1.nama_rekening_bank
                    , t1.nomor_referral
                    , t1.flag_delete
                    , t1.created_at
                    , t1.accepted_at
                    , t1.rejected_at
                    , t1.flag_status
                    , t2.nama_permainan
                    , t3.nama_bank
                    , (IFNULL(t4.jumlah_deposit, 0) -  IFNULL(t5.jumlah_withdraw, 0)) as nominal_saldo
                    , t6.nama as nama_client
                    , t6.alamat as alamat_client
                FROM 
                    members AS t1 
                JOIN permainans as t2 ON t1.permainans_id = t2.id
                JOIN banks as t3 ON t1.banks_id = t3.id
                LEFT JOIN (
                    SELECT xa.kode_member
                        , (
                            CASE WHEN SUM(xa.jumlah_deposit) IS NULL THEN 0
                                ELSE SUM(xa.jumlah_deposit)
                            END 
                        ) as jumlah_deposit
                    FROM deposits as xa
                    WHERE xa.flag_delete = 'N'
                        AND xa.flag_status = 'A'
                    GROUP BY xa.kode_member
                ) as t4 ON t1.kode_member = t4.kode_member
                LEFT JOIN (
                    SELECT xa.kode_member
                        , (
                            CASE WHEN SUM(xa.total_withdraw) IS NULL THEN 0
                                ELSE SUM(xa.total_withdraw)
                            END 
                        ) as jumlah_withdraw
                    FROM withdraws as xa
                    WHERE xa.flag_delete = 'N'
                        AND xa.flag_status = 'A'
                    GROUP BY xa.kode_member
                ) as t5 ON t1.kode_member = t5.kode_member
                JOIN clients as t6 ON t1.clients_id = t6.id
                    AND t6.flag_delete = 'N'
                    , (SELECT @row := 0) r 
                WHERE 1=1
                    AND t1.flag_status = 'A'
            ) as t1
            WHERE 1=1
                ".$where."
        ";
        
        $data['totalData'] = $this->db->query($sql)->num_rows();
        
        if( ! empty($like_value))
        {
            $cari_nominal = $like_value;
            $cari_nominal = str_replace(',', '', $cari_nominal);
            $cari_nominal = str_replace('.', '', $cari_nominal);
            
            $sql .= " AND (
                        t1.id LIKE '%".$this->db->escape_like_str($like_value)."%' 
                        OR t1.kode_member LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_lengkap LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_client LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.no_hp LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.email LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nomor_rekening_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_rekening_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nomor_referral LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_permainan LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nominal_saldo LIKE '%".$this->db->escape_like_str($cari_nominal)."%'
                        OR DATE_FORMAT(t1.created_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.accepted_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.rejected_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                    ) ";
        }
        
        $data['totalFiltered']  = $this->db->query($sql)->num_rows();
        
        $columns_order_by = array( 
            0 => 'nomor',
            1 => 't1.id',
            2 => 't1.kode_member',
            3 => 't1.created_at',
            4 => 't1.nama_lengkap',
            5 => 't1.nama_permainan',
            6 => 't1.nama_bank',
            7 => 't1.flag_status',
        );
        
        $sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
        $sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
        
        $data['query'] = $this->db->query($sql);
        return $data;
    }
    function export_data_members(){
        $where                  = "";
        $flag_delete            = $this->input->post('flag_delete');
        $clients_id             = $this->input->post('clients_id');

        $filter_created_at      = $this->input->post('filter_created_at');
        $created_at_awal        = $this->input->post('created_at_awal');
        $created_at_akhir       = $this->input->post('created_at_akhir');

        $filter_accepted_at     = $this->input->post('filter_accepted_at');
        $accepted_at_awal       = $this->input->post('accepted_at_awal');
        $accepted_at_akhir      = $this->input->post('accepted_at_akhir');

        $filter_rejected_at     = $this->input->post('filter_rejected_at');
        $rejected_at_awal       = $this->input->post('rejected_at_awal');
        $rejected_at_akhir      = $this->input->post('rejected_at_akhir');
        
        if(!$flag_delete){
            $where .= " AND t1.flag_delete = 'N' ";
        }

        if($clients_id){
            $where .= " AND t1.clients_id = '".$clients_id."' ";
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
            SELECT t1.*
            FROM(
                SELECT 
                    (@row:=@row+1) AS nomor
                    , t1.id
                    , t1.kode_member
                    , t1.clients_id
                    , t1.nama_lengkap
                    , t1.no_hp
                    , t1.email
                    , t1.permainans_id
                    , t1.banks_id
                    , t1.nomor_rekening_bank
                    , t1.nama_rekening_bank
                    , t1.nomor_referral
                    , t1.flag_delete
                    , t1.created_at
                    , t1.accepted_at
                    , t1.rejected_at
                    , t1.delete_at
                    , t1.flag_status
                    , t2.nama_permainan
                    , t3.nama_bank
                    , (IFNULL(t4.jumlah_deposit, 0) -  IFNULL(t5.jumlah_withdraw, 0)) as nominal_saldo
                    , t6.nama as nama_client
                    , t6.alamat as alamat_client
                FROM 
                    members AS t1 
                JOIN permainans as t2 ON t1.permainans_id = t2.id
                JOIN banks as t3 ON t1.banks_id = t3.id
                LEFT JOIN (
                    SELECT xa.kode_member
                        , (
                            CASE WHEN SUM(xa.jumlah_deposit) IS NULL THEN 0
                                ELSE SUM(xa.jumlah_deposit)
                            END 
                        ) as jumlah_deposit
                    FROM deposits as xa
                    WHERE xa.flag_delete = 'N'
                        AND xa.flag_status = 'A'
                    GROUP BY xa.kode_member
                ) as t4 ON t1.kode_member = t4.kode_member
                LEFT JOIN (
                    SELECT xa.kode_member
                        , (
                            CASE WHEN SUM(xa.total_withdraw) IS NULL THEN 0
                                ELSE SUM(xa.total_withdraw)
                            END 
                        ) as jumlah_withdraw
                    FROM withdraws as xa
                    WHERE xa.flag_delete = 'N'
                        AND xa.flag_status = 'A'
                    GROUP BY xa.kode_member
                ) as t5 ON t1.kode_member = t5.kode_member
                JOIN clients as t6 ON t1.clients_id = t6.id
                    AND t6.flag_delete = 'N'
                    , (SELECT @row := 0) r 
                WHERE 1=1
                    AND t1.flag_status = 'A'
            ) as t1
            WHERE 1=1
                ".$where."
            ORDER BY t1.created_at ASC, t1.nama_lengkap ASC
        ";
        
        return $this->db->query($sql)->result();
    }

    function fetch_data_registers($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
    {
        $where                  = "";
        $flag_status            = $this->input->post('flag_status');
        $flag_delete            = $this->input->post('flag_delete');
        $kode_member            = $this->input->post('kode_member');
        $clients_id             = $this->input->post('clients_id');

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
            $where .= " AND t1.clients_id = '".$clients_id."' ";
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
                , t1.nama_lengkap
                , t1.no_hp
                , t1.email
                , t1.permainans_id
                , t1.banks_id
                , t1.nomor_rekening_bank
                , t1.nama_rekening_bank
                , t1.nomor_referral
                , t1.flag_delete
                , t1.created_at
                , t1.accepted_at
                , t1.rejected_at
                , t1.flag_status
                , t2.nama_permainan
                , t3.nama_bank
                , t4.nama as nama_client
                , t4.alamat as alamat_client
            FROM 
                members AS t1 
            JOIN permainans as t2 ON t1.permainans_id = t2.id
            JOIN banks as t3 ON t1.banks_id = t3.id
            JOIN clients as t4 ON t1.clients_id = t4.id
                AND t4.flag_delete = 'N'
                , (SELECT @row := 0) r 
            WHERE 1=1 
                ".$where."
        ";
        
        $data['totalData'] = $this->db->query($sql)->num_rows();
        
        if( ! empty($like_value))
        {
            $sql .= " AND (
                        t1.id LIKE '%".$this->db->escape_like_str($like_value)."%' 
                        OR t1.kode_member LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_lengkap LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.no_hp LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.email LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nomor_rekening_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_rekening_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nomor_referral LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t2.nama_permainan LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t3.nama_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.created_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.accepted_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR DATE_FORMAT(t1.rejected_at, '%d %b %Y %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%'
                    ) ";
        }
        
        $data['totalFiltered']  = $this->db->query($sql)->num_rows();
        
        $columns_order_by = array( 
            0 => 'nomor',
            1 => 't1.id',
            2 => 't1.kode_member',
            3 => 't1.created_at',
            4 => 't1.nama_lengkap',
            5 => 't2.nama_permainan',
            6 => 't3.nama_bank',
            7 => 't1.flag_status',
        );
        
        $sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
        $sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
        
        $data['query'] = $this->db->query($sql);
        return $data;
    }

    function export_data_registers(){
        $where                  = "";
        $flag_status            = $this->input->post('flag_status');
        $flag_delete            = $this->input->post('flag_delete');
        $clients_id             = $this->input->post('clients_id');

        $filter_created_at      = $this->input->post('filter_created_at');
        $created_at_awal        = $this->input->post('created_at_awal');
        $created_at_akhir       = $this->input->post('created_at_akhir');

        $filter_accepted_at     = $this->input->post('filter_accepted_at');
        $accepted_at_awal       = $this->input->post('accepted_at_awal');
        $accepted_at_akhir      = $this->input->post('accepted_at_akhir');

        $filter_rejected_at     = $this->input->post('filter_rejected_at');
        $rejected_at_awal       = $this->input->post('rejected_at_awal');
        $rejected_at_akhir      = $this->input->post('rejected_at_akhir');
        

        if($clients_id){
            $where .= " AND t1.clients_id = '".$clients_id."' ";
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
                , t1.nama_lengkap
                , t1.no_hp
                , t1.email
                , t1.permainans_id
                , t1.banks_id
                , t1.nomor_rekening_bank
                , t1.nama_rekening_bank
                , t1.nomor_referral
                , t1.flag_delete
                , t1.delete_at
                , t1.created_at
                , t1.accepted_at
                , t1.rejected_at
                , t1.flag_status
                , t2.nama_permainan
                , t3.nama_bank
                , t4.nama as nama_client
                , t4.alamat as alamat_client
            FROM 
                members AS t1 
            JOIN permainans as t2 ON t1.permainans_id = t2.id
            JOIN banks as t3 ON t1.banks_id = t3.id
            JOIN clients as t4 ON t1.clients_id = t4.id
                    AND t4.flag_delete = 'N'
                , (SELECT @row := 0) r 
            WHERE 1=1 
                ".$where."
            ORDER BY t1.created_at ASC, t1.nama_lengkap ASC
        ";
        
        return $this->db->query($sql)->result();
    }

    function generate_kode_member($clients_id){
        $response   = array();
        $clients    = $this->db->get_where('clients', array('id' => $clients_id))->row();

        $kode_member_prefixs        = @$clients->kode_member_prefixs;
        $kode_member_number_digits  = @$clients->kode_member_number_digits;

        if(!$kode_member_prefixs){
            $kode_member_prefixs = 'ABCDEFG';
        }

        if($kode_member_number_digits == '' OR $kode_member_number_digits == NULL){
            $kode_member_number_digits = 3;
        }

        $kode_member_prefixs_digits = strlen($kode_member_prefixs);

        $sql = "SELECT t1.kode_member
                        , t1.kode_member_prefixs
                FROM members as t1
                WHERE t1.flag_delete = 'N'
                    AND t1.clients_id = '".$clients_id."'
                    AND (t1.kode_member IS NOT NULL OR t1.kode_member != '')
                    AND t1.kode_member_prefixs = '".$kode_member_prefixs."'
                ORDER BY t1.accepted_at DESC
                LIMIT 1
                ";
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0){
            $row = $query->row();

            $kode_member_old            = $row->kode_member;
            $kode_member_prefixs_old    = $row->kode_member_prefixs;
            
            if($kode_member_old){
                $no_urut = (int) substr($kode_member_old, $kode_member_prefixs_digits, $kode_member_number_digits);
                $no_urut++;

                $number = sprintf("%0".$kode_member_number_digits."s", $no_urut);
                $kode_member_number_digits_new = strlen($number);

                if($kode_member_number_digits_new == $kode_member_number_digits){
                    $kode_member = $kode_member_prefixs . $number;
                    $response = array('status' => true, 'kode_member' => $kode_member, 'kode_member_prefixs' => $kode_member_prefixs);
                } else {
                    $kode_member = $kode_member_prefixs . $number;
                    $response = array('status' => false, 'kode_member' => $kode_member, 'kode_member_prefixs' => $kode_member_prefixs);
                }
            }

            // JIKA KODE MEMBERNYA KOSONG
            else {
                $number = '';
                for($i = 1; $i < $kode_member_number_digits; $i++){
                    $number .= "0";
                }

                if($kode_member_number_digits){
                    $number .= "1";
                }

                $kode_member = $kode_member_prefixs . $number;
            }

        } else {
            $number = '';
            for($i = 1; $i < $kode_member_number_digits; $i++){
                $number .= "0";
            }

            if($kode_member_number_digits){
                $number .= "1";
            }
            
            $kode_member = $kode_member_prefixs . $number;
            $response = array('status' => true, 'kode_member' => $kode_member, 'kode_member_prefixs' => $kode_member_prefixs);
        }

        return $response;
    }

    function get_total_all_members_waiting()
    {
        $this->db->where('flag_delete', 'N');
        $this->db->where('flag_status', 'W');
        return $this->db->count_all_results('members');
    }

    function get_total_all_members()
    {
        $this->db->where('flag_delete', 'N');
        return $this->db->count_all_results('members');
    }

    function get_total_all_members_accepted()
    {
        $this->db->where('flag_delete', 'N');
        $this->db->where('flag_status', 'A');
        return $this->db->count_all_results('members');
    }

    function get_all_members()
    {
        return $this->db->get('members')->result();
    }

    function get_members_by($data)
    {
        return $this->db->get_where('members', $data);
    }

    function get_members_by_id($id)
    {
        $sql = "SELECT 
                    (@row:=@row+1) AS nomor
                    , t1.*
                    , t2.nama_permainan
                    , t3.nama_bank
                    , t4.nama as nama_client
                    , t4.alamat as alamat_client
                FROM 
                    members AS t1 
                JOIN permainans as t2 ON t1.permainans_id = t2.id
                JOIN banks as t3 ON t1.banks_id = t3.id
                JOIN clients as t4 ON t1.clients_id = t4.id
                WHERE t1.flag_delete = 'N' 
                    AND t1.id = '".$id."'
                ";
        return $this->db->query($sql)->row();
    }

    function update_batch_members_by($column, $data)
    {
        return $this->db->update_batch('members', $data, $column); 
    }

    function update_members_by_id($id, $data)
    {
        return $this->db->update('members', $data, array('id' => $id));
    }

    function add_members($data)
    {
        $this->db->insert('members', $data);
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
        return $this->db->delete('members', array('id' => $id));
    }

    function get_total_all_members_accepted_summary_dashboard($clients_id = null, $filter_tanggal = null, $tanggal_awal = null, $tanggal_akhir = null)
    {
        $where = "";

        if($filter_tanggal && $tanggal_awal && $tanggal_akhir){
            $where .= " AND (DATE(t1.created_at) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."') ";
        }

        if($clients_id){
            $where .= " AND t1.clients_id = '".$clients_id."' ";
        }

        $sql = "SELECT COUNT(t1.id) as total
                FROM members as t1
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

    function get_total_all_members_summay_dashboard($clients_id = null, $filter_tanggal = null, $tanggal_awal = null, $tanggal_akhir = null)
    {
        $where = "";
        if($filter_tanggal && $tanggal_awal && $tanggal_akhir){
            $where .= " AND (DATE(t1.created_at) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."') ";
        }

        if($clients_id){
            $where .= " AND t1.clients_id = '".$clients_id."' ";
        }

        $sql = "SELECT COUNT(t1.id) as total
                FROM members as t1
                WHERE t1.flag_delete = 'N'
                    ".$where."
                ";
        $query  = $this->db->query($sql);
        $total  = 0;

        if($query->num_rows() > 0){
            $row    = $query->row();
            $total  = ($row->total ? $row->total : 0);
        }

        return $total;
    }
}
