<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_roles extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function fetch_data_roles($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
    {
        $sql = "
            SELECT 
                (@row:=@row+1) AS nomor
                , t1.id
                , t1.roles
            FROM 
                roles AS t1 
                , (SELECT @row := 0) r 
            WHERE 1=1 
                AND t1.flag_delete = 'N'
        ";
        
        $data['totalData'] = $this->db->query($sql)->num_rows();
        
        if( ! empty($like_value))
        {
            $sql .= " AND (
                        t1.id LIKE '%".$this->db->escape_like_str($like_value)."%' 
                        OR t1.roles LIKE '%".$this->db->escape_like_str($like_value)."%'
                    ) ";
        }
        
        $data['totalFiltered']  = $this->db->query($sql)->num_rows();
        
        $columns_order_by = array( 
            0 => 'nomor',
            1 => 't1.id',
            2 => 't1.roles',
        );
        
        $sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
        $sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
        
        $data['query'] = $this->db->query($sql);
        return $data;
    }

    function get_all_roles(){
        return $this->db->get('roles')->result();
    }

    function get_roles_by_id($id)
    {
        return $this->db->get_where('roles', array('id' => $id, 'flag_delete' => 'N'))->row();
    }

    function update_roles_by_id($id, $data)
    {
        return $this->db->update('roles', $data, array('id' => $id));
    }

    function add_roles($data)
    {
        $this->db->insert('roles', $data);
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
        return $this->db->delete('roles', array('id' => $id));
    }
}
