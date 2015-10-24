<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends M_Controller {

	public function Ajax() {
            parent::__construct();
            if($this->config->item('ajax_security')!==$this->input->post('ajax_security')) {
                die('No Access Allowed');
            }
        }
	public function index()
	{
		redirect('','refresh');
	}
	public function get_session_lifetime() {
            echo $this->config->item('sess_expiration');
	}
        public function query_clients() {
            $query = $this->input->post('query_key');
            $this->load->model('client');
            $clients = $this->client->get_clients_like($this->the_company,$query,5);       
            echo json_encode($clients);
        }   
}
?>