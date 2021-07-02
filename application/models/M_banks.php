<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_banks extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function fetch_data_banks($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
    {
        $flag_active    = $this->input->post('flag_active');
        $where          = "";

        if($flag_active){
            $where .= " AND t1.flag_active = '".$flag_active."' ";
        }

        $sql = "
            SELECT 
                (@row:=@row+1) AS nomor
                , t1.id
                , t1.kode_bank
                , t1.nama_bank
                , t1.flag_active
            FROM 
                banks AS t1 
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
                        OR t1.kode_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama_bank LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.flag_active LIKE '%".$this->db->escape_like_str($like_value)."%'
                    ) ";
        }
        
        $data['totalFiltered']  = $this->db->query($sql)->num_rows();
        
        $columns_order_by = array( 
            0 => 'nomor',
            1 => 't1.id',
            2 => 't1.kode_bank',
            3 => 't1.nama_bank',
            4 => 't1.flag_active',
        );
        
        $sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
        $sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
        
        $data['query'] = $this->db->query($sql);
        return $data;
    }

    function get_all_banks()
    {
        $this->db->select('t1.*');
        $this->db->where('t1.flag_delete', 'N');
        $this->db->where('t1.flag_active', 'Y');
        $this->db->from('banks as t1');
        $this->db->order_by('t1.nama_bank', 'ASC');

        return $this->db->get()->result();
    }

    function get_banks_by($data)
    {
        return $this->db->get_where('banks', $data);
    }

    function get_banks_by_id($id)
    {
        return $this->db->get_where('banks', array('id' => $id, 'flag_delete' => 'N'))->row();
    }

    function update_batch_banks_by($column, $data)
    {
        return $this->db->update_batch('banks', $data, $column); 
    }

    function update_banks_by_id($id, $data)
    {
        return $this->db->update('banks', $data, array('id' => $id));
    }

    function add_banks($data)
    {
        $this->db->insert('banks', $data);
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
        return $this->db->delete('banks', array('id' => $id));
    }
}
