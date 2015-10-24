<?php


class Company extends M_Model{
    public function Company() {
        parent::__construct();
        $this->table = 'companies';
    }
    public function update_company($cond,$update_data) {
        if(is_array($cond)) {
            $this->db->where($cond);
        } else {
            $this->db->where('db_id',$cond);
        }
        $this->db->update($this->table,$update_data);
    }
}

?>
