<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_notifikasi extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_total_notifikasi(){
        $sql = "SELECT xa.*
                FROM (
                    SELECT 'members' as tipe
                            , t1.id
                            , t1.kode_member
                            , t1.nama_lengkap
                            , t1.flag_read
                            , t1.read_at
                            , t1.read_by
                            , t1.created_at
                    FROM members as t1 
                    WHERE t1.flag_delete = 'N'

                    UNION ALL 
                    
                    SELECT
                        'deposits' as tipe
                        , t1.id
                        , t1.kode_member
                        , t4.nama_lengkap
                        , t1.flag_read
                        , t1.read_at
                        , t1.read_by
                        , t1.created_at
                    FROM 
                        deposits AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'
                    
                    UNION ALL 

                    SELECT
                        'withdraws' as tipe
                        , t1.id
                        , t1.kode_member
                        , t4.nama_lengkap
                        , t1.flag_read
                        , t1.read_at
                        , t1.read_by
                        , t1.created_at
                    FROM 
                        withdraws AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'

                ) as xa
                ORDER BY xa.created_at DESC 
                ";

        return $this->db->query($sql)->num_rows();
    }

    function get_pagination_notifikasi($limit, $offset){
        $sql = "SELECT xa.*
                FROM (
                    SELECT 'Register' as tipe
                            , t1.id
                            , t1.kode_member
                            , t1.nama_lengkap
                            , t1.flag_read
                            , t1.read_at
                            , t1.read_by
                            , t1.created_at
                            , t1.flag_status
                            , t1.accepted_at
                            , t1.rejected_at
                    FROM members as t1 
                    WHERE t1.flag_delete = 'N'

                    UNION ALL 
                    
                    SELECT
                        'Deposit' as tipe
                        , t1.id
                        , t1.kode_member
                        , t4.nama_lengkap
                        , t1.flag_read
                        , t1.read_at
                        , t1.read_by
                        , t1.created_at
                        , t1.flag_status
                        , t1.accepted_at
                        , t1.rejected_at
                    FROM 
                        deposits AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'
                    
                    UNION ALL 

                    SELECT
                        'Withdraw' as tipe
                        , t1.id
                        , t1.kode_member
                        , t4.nama_lengkap
                        , t1.flag_read
                        , t1.read_at
                        , t1.read_by
                        , t1.created_at
                        , t1.flag_status
                        , t1.accepted_at
                        , t1.rejected_at
                    FROM 
                        withdraws AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'

                ) as xa
                ORDER BY xa.created_at DESC 
                ";

        if($limit && $offset){
            $sql .= " LIMIT " . $offset .", " . $limit;
        } else {
            $sql .= " LIMIT " . $limit;
        }

        return $this->db->query($sql)->result();
    }

    function get_last_notifikasi(){
        $sql = "SELECT xa.*
                FROM (
                    SELECT 'Register' as tipe
                            , t1.id
                            , t1.kode_member
                            , t1.nama_lengkap
                            , t1.flag_read
                            , t1.read_at
                            , t1.read_by
                            , t1.created_at
                            , t1.flag_status
                            , t1.accepted_at
                            , t1.rejected_at
                    FROM members as t1 
                    WHERE t1.flag_delete = 'N'

                    UNION ALL 
                    
                    SELECT
                        'Deposit' as tipe
                        , t1.id
                        , t1.kode_member
                        , t4.nama_lengkap
                        , t1.flag_read
                        , t1.read_at
                        , t1.read_by
                        , t1.created_at
                        , t1.flag_status
                        , t1.accepted_at
                        , t1.rejected_at
                    FROM 
                        deposits AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'
                    
                    UNION ALL 

                    SELECT
                        'Withdraw' as tipe
                        , t1.id
                        , t1.kode_member
                        , t4.nama_lengkap
                        , t1.flag_read
                        , t1.read_at
                        , t1.read_by
                        , t1.created_at
                        , t1.flag_status
                        , t1.accepted_at
                        , t1.rejected_at
                    FROM 
                        withdraws AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'

                ) as xa
                ORDER BY xa.created_at DESC 
                LIMIT 5
                ";

        return $this->db->query($sql)->result();
    }

    function get_total_notifikasi_belum_dibaca(){
        $sql = "SELECT xa.*
                FROM (
                    SELECT 'members' as tipe
                            , t1.id
                    FROM members as t1 
                    WHERE t1.flag_delete = 'N'
                        AND t1.flag_read = 'N'
                    UNION ALL 
                    
                    SELECT
                        'deposits' as tipe
                        , t1.id
                    FROM 
                        deposits AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'
                        AND t1.flag_read = 'N'
                    
                    UNION ALL 

                    SELECT
                        'withdraws' as tipe
                        , t1.id
                    FROM 
                        withdraws AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'
                        AND t1.flag_read = 'N'

                ) as xa 
                ";

        return $this->db->query($sql)->num_rows();
    }

    function update_notifikasi_sudah_dibaca(){
        $read_at = date('Y-m-d H:i:s');
        $read_by = $this->session->userdata('id');

        $sql = "UPDATE members
                    SET flag_read = 'Y'
                        , read_at = '".$read_at."'
                        , read_by = '".$read_by."'
                WHERE flag_delete = 'N'
                    AND flag_read = 'N'
                ";
        $this->db->query($sql);

        $sql = "UPDATE deposits
                    SET flag_read = 'Y'
                        , read_at = '".$read_at."'
                        , read_by = '".$read_by."'
                WHERE flag_delete = 'N'
                    AND flag_read = 'N'
                ";
        $this->db->query($sql);

        $sql = "UPDATE withdraws
                    SET flag_read = 'Y'
                        , read_at = '".$read_at."'
                        , read_by = '".$read_by."'
                WHERE flag_delete = 'N'
                    AND flag_read = 'N'
                ";
        $this->db->query($sql);
    }

    function get_notifikasi_after_submit($waktu_awal, $waktu_akhir){
        $sql = "SELECT xa.*
                FROM (
                    SELECT 'Register' as tipe
                            , t1.id
                            , t1.kode_member
                            , t1.nama_lengkap
                            , t1.flag_read
                            , t1.read_at
                            , t1.read_by
                            , t1.created_at
                            , t1.flag_status
                            , t1.accepted_at
                            , t1.rejected_at
                    FROM members as t1 
                    WHERE t1.flag_delete = 'N'
                        AND t1.flag_notifikasi = 'N'

                    UNION ALL 
                    
                    SELECT
                        'Deposit' as tipe
                        , t1.id
                        , t1.kode_member
                        , t4.nama_lengkap
                        , t1.flag_read
                        , t1.read_at
                        , t1.read_by
                        , t1.created_at
                        , t1.flag_status
                        , t1.accepted_at
                        , t1.rejected_at
                    FROM 
                        deposits AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'
                        AND t1.flag_notifikasi = 'N'
                    
                    UNION ALL 

                    SELECT
                        'Withdraw' as tipe
                        , t1.id
                        , t1.kode_member
                        , t4.nama_lengkap
                        , t1.flag_read
                        , t1.read_at
                        , t1.read_by
                        , t1.created_at
                        , t1.flag_status
                        , t1.accepted_at
                        , t1.rejected_at
                    FROM 
                        withdraws AS t1 
                    JOIN permainans as t2 ON t1.permainans_id = t2.id
                    JOIN banks as t3 ON t1.banks_id = t3.id
                    LEFT JOIN members as t4 ON t1.kode_member = t4.kode_member
                        AND t1.clients_id = t4.clients_id
                    WHERE t1.flag_delete = 'N'
                        AND t1.flag_notifikasi = 'N'

                ) as xa
                WHERE 1=1
                    AND xa.created_at BETWEEN '".$waktu_awal."' AND '".$waktu_akhir."'
                ORDER BY xa.created_at DESC 
                ";

        $result = $this->db->query($sql)->result();

        $sql = "UPDATE members
                    SET flag_notifikasi = 'Y'
                WHERE flag_delete = 'N'
                    AND flag_read = 'N'
                    AND created_at BETWEEN '".$waktu_awal."' AND '".$waktu_akhir."'
                ";
        $this->db->query($sql);

        $sql = "UPDATE deposits
                    SET flag_notifikasi = 'Y'
                WHERE flag_delete = 'N'
                    AND flag_read = 'N'
                    AND created_at BETWEEN '".$waktu_awal."' AND '".$waktu_akhir."'
                ";
        $this->db->query($sql);

        $sql = "UPDATE withdraws
                    SET flag_notifikasi = 'Y'
                WHERE flag_delete = 'N'
                    AND flag_read = 'N'
                    AND created_at BETWEEN '".$waktu_awal."' AND '".$waktu_akhir."'
                ";
        $this->db->query($sql);

        return $result;
    }
}