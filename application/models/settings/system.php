<?php


class System extends M_Model {
    public function System() {
        parent::__construct();
        $this->table = 'settings_system';
    }
    public function save($username,$data) {
        $this->db->where('username',$username);
        return $this->db->update($this->table,$data);
    }
    
}

?>
