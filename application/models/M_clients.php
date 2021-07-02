<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_clients extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function fetch_data_clients($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
    {
        $flag_active    = $this->input->post('flag_active');
        $where          = "";

        if($flag_active){
            $where .= " AND t1.flag_active = '".$flag_active."' ";
        }

        $sql = "
            SELECT 
                (@row:=@row+1) AS nomor
                , t1.*
            FROM 
                clients AS t1 
                , (SELECT @row := 0) r 
            WHERE 1=1 
                AND t1.flag_delete = 'N'
                ".$where."
        ";
        
        $data['totalData'] = $this->db->query($sql)->num_rows();
        
        if( ! empty($like_value))
        {
            $sql .= " AND (
                        t1.id LIKE '%".$this->db->escape_like_str($like_value)."%' 
                        OR t1.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.alamat LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.email LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nomor_telepon LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nomor_telepon2 LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_pic LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nomor_hp_pic LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.flag_active LIKE '%".$this->db->escape_like_str($like_value)."%'
                    ) ";
        }
        
        $data['totalFiltered']  = $this->db->query($sql)->num_rows();
        
        $columns_order_by = array( 
            0 => 'nomor',
            1 => 't1.id',
            2 => 't1.nama',
            3 => 't1.alamat',
            4 => 't1.flag_active',
        );
        
        $sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
        $sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
        
        $data['query'] = $this->db->query($sql);
        return $data;
    }

    function get_all_clients()
    {
        $this->db->select('t1.*');
        $this->db->where('t1.flag_delete', 'N');
        $this->db->where('t1.flag_active', 'Y');
        $this->db->from('clients as t1');
        $this->db->order_by('t1.nama', 'ASC');

        return $this->db->get()->result();
    }

    function get_clients_by($data)
    {
        return $this->db->get_where('clients', $data);
    }

    function get_clients_by_id($id)
    {
        return $this->db->get_where('clients', array('id' => $id, 'flag_delete' => 'N'))->row();
    }

    function update_batch_clients_by($column, $data)
    {
        return $this->db->update_batch('clients', $data, $column); 
    }

    function update_clients_by_id($id, $data)
    {
        return $this->db->update('clients', $data, array('id' => $id));
    }

    function add_clients($data)
    {
        $this->db->insert('clients', $data);
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
        return $this->db->delete('clients', array('id' => $id));
    }
}
