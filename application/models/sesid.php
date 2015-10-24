<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sesid extends M_Model {

	public function __construct() {
            parent::__construct();
            $this->table = 'clients';
        }
        /*
         * 
         * Add a client. return client database-id if succeed. false if not.
         */
	public function push($sid,$user_id,$ip_address,$user_agent) {
            $this->db->set(array(
               'session_id'=>$sid,
               'user_id'=>$user_id,
               'user_ip'=>$ip_address,
               'user_agent'=>$user_agent,
               'time_stamp'=>time()
            ))->insert('sessions');
        }
}

?>