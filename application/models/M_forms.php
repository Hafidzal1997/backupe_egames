<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_forms extends CI_Model {

    private $table = "form_list";
 
    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
}
