<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function fetch_data_users($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
    {
        $flag_active    = $this->input->post('flag_active');
        $roles_id       = $this->input->post('roles_id');
        $where          = "";

        if($flag_active){
            $where .= " AND t1.flag_active = '".$flag_active."' ";
        }


        if($roles_id){
            $where .= " AND t1.roles_id = '".$roles_id."' ";
        }
        
        $sql = "
            SELECT 
                (@row:=@row+1) AS nomor
                , t1.id
                , t1.email
                , t1.nama
                , t1.flag_active
                , t2.roles
            FROM 
                users AS t1 
            JOIN roles as t2 ON t1.roles_id = t2.id
                AND t2.flag_delete = 'N'
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
                        OR t1.email LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t1.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR t2.roles LIKE '%".$this->db->escape_like_str($like_value)."%'
                    ) ";
        }
        
        $data['totalFiltered']  = $this->db->query($sql)->num_rows();
        
        $columns_order_by = array( 
            0 => 'nomor',
            1 => 't1.nama',
            2 => 't1.email',
            3 => 't2.roles',
            4 => 't1.flag_active',
        );
        
        $sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
        $sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
        
        $data['query'] = $this->db->query($sql);
        return $data;
    }

    function get_login($email, $password)
    {
        $this->db->select('t1.*, t2.roles');
        $this->db->join('roles as t2' ,'t2.id = t1.roles_id AND t2.flag_delete = "N" ');
        $this->db->where('t1.email', $email);
        $this->db->where('t1.password', $password);
        $this->db->where('t1.flag_delete', 'N');
        $this->db->from('users as t1');

        return $this->db->get()->row();
    }

    function get_users_by_id($id)
    {
        $this->db->select('t1.*, t2.roles');
        $this->db->join('roles as t2' ,'t2.id = t1.roles_id');
        $this->db->where('t1.id', $id);
        $this->db->where('t1.flag_delete', 'N');
        $this->db->from('users as t1');

        return $this->db->get()->row();
    }

    function update_batch_users_by($column, $data)
    {
        return $this->db->update_batch('users', $data, $column); 
    }

    function update_users_by_id($id, $data)
    {
        return $this->db->update('users', $data, array('id' => $id));
    }

    function add_users($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    function delete_by_id($id)
    {
        return $this->db->delete('users', array('id' => $id));
    }
}
