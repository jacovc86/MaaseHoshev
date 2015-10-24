<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends M_Model {

	
	public function login($username, $password)
	{
		$q = $this->db->get_where('users',array('username'=>$username,'password'=>$password),1);
		if($q->num_rows()==1) return $q->result();
		else return false;
	}
	public function register_company($company,$superuser) {
		return $this->db->set(array_merge($superuser,array('level'=>'1')))->insert('users');
	}
}

?>