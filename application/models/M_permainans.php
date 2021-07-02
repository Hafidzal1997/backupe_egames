<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_permainans extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function fetch_data_permainans($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
    {
        $flag_active                = $this->input->post('flag_active');
        $permainans_categories_id   = $this->input->post('permainans_categories_id');
        $where                      = "";

        if($flag_active){
            $where .= " AND t1.flag_active = '".$flag_active."' ";
        }

        if($permainans_categories_id){
            $where .= " AND t1.permainans_categories_id = '".$permainans_categories_id."' ";
        }

        $sql = "
            SELECT 
                (@row:=@row+1) AS nomor
                , t1.id
                , t1.nama_permainan
                , t1.flag_active
                , t2.nama_kategori_permainan
            FROM 
                permainans AS t1 
            JOIN permainans_categories as t2 ON t1.permainans_categories_id = t2.id
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
                        OR t1.nama_permainan LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.flag_active LIKE '%".$this->db->escape_like_str($like_value)."%'
                    ) ";
        }
        
        $data['totalFiltered']  = $this->db->query($sql)->num_rows();
        
        $columns_order_by = array( 
            0 => 'nomor',
            1 => 't1.id',
            2 => 't1.nama_permainan',
            3 => 't1.nama_kategori_permainan',
            4 => 't1.flag_active',
        );
        
        $sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
        $sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
        
        $data['query'] = $this->db->query($sql);
        return $data;
    }

    function get_all_permainans()
    {
        $this->db->select('t1.*');
        $this->db->where('t1.flag_delete', 'N');
        $this->db->where('t1.flag_active', 'Y');
        $this->db->from('permainans as t1');
        $this->db->order_by('t1.nama_permainan', 'ASC');

        return $this->db->get()->result();
    }

    function get_permainans_by($data)
    {
        return $this->db->get_where('permainans', $data);
    }

    function get_permainans_by_id($id)
    {
        return $this->db->get_where('permainans', array('id' => $id, 'flag_delete' => 'N'))->row();
    }

    function update_batch_permainans_by($column, $data)
    {
        return $this->db->update_batch('permainans', $data, $column); 
    }

    function update_permainans_by_id($id, $data)
    {
        return $this->db->update('permainans', $data, array('id' => $id));
    }

    function add_permainans($data)
    {
        $this->db->insert('permainans', $data);
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
        return $this->db->delete('permainans', array('id' => $id));
    }
}
