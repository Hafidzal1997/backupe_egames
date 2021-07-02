<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_settings extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_settings_by_id($settings_key)
    {
        $this->db->select('t1.settings_key, t1.settings_value');
        $this->db->where('t1.settings_key', $settings_key);
        $this->db->from('settings as t1');

        return $this->db->get()->row();
    }

    function update_batch_settings_by($column, $data)
    {
        return $this->db->update_batch('settings', $data, $column); 
    }

    function update_settings_by_id($settings_key, $data)
    {
        return $this->db->update('settings', $data, array('settings_key' => $settings_key));
    }

    function add_settings($data)
    {
        $this->db->insert('settings', $data);
        return $this->db->insert_id();
    }

    function delete_by_id($settings_key)
    {
        return $this->db->delete('settings', array('settings_key' => $settings_key));
    }
}