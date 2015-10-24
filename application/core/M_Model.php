<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Model extends CI_Model {
    public $table;
    public function __construct()
    {	
            parent::__construct();
    }
    public function get($cond) {
        if(is_array($cond)) {
            return $this->db->get_where($this->table,$cond)->row();
        }
        return $this->db->get_where($this->table,array('db_id'=>$cond))->row();
    }
    public function get_all() {
        return $this->db->get($this->table)->result();
    }
}
