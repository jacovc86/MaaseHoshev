<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends M_Model {

	public function __construct() {
            parent::__construct();
            $this->table = 'users';
        }
	public function login($username, $password)
	{
		$q = $this->db->get_where('users',array('username'=>$username,'password'=>$password),1);
		if($q->num_rows()==1) return $q->row();
		else return false;
	}
	public function register_company($company,$superuser) {
            if($this->db->set($company)->insert('companies')) {
                $company_id = $this->db->insert_id();
		if($this->db->set(array_merge($superuser,array('level'=>'1','company_id'=>$company_id)))->insert('users')) {
                    $user_id = $this->db->insert_id();
                    $this->db->where('db_id',$company_id);
                    $this->db->update('companies',array('super_user'=>$user_id));
                    mkdir("media/data/clients/$company_id");
                    mkdir("media/data/clients/$company_id/images");
                    return true;
                }
            }
            else return false;
	}
        public function get_company_by_superuser($username) {
            $company_id = $this->db->get_where('users',array('username'=>$username))->row()->company_id;
            return $this->db->get_where('companies',array('db_id'=>$company_id))->row();
            
        }
        public function get_user_by_id($user_id) {
            return $this->get_where($this->table,array('db_id'=>$user_id))->row();
        }
        public function get_user_by_username($username) {
            return $this->db->get_where($this->table,array('username'=>$username))->row();
        }
         
        public function update_user($username,$update_data) {
            $this->db->where('username',$username);
            $this->db->update('users',$update_data);
        }
        public function get_users_by_company($company_id) {
            return $this->db->get_where('users',array('company_id'=>$company_id))->result();
        }
        public function add_user($user) {
            return $this->db->set($user)->insert($this->table);
        }
}

?>