<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update extends CI_Controller {
    public $company,$user;
    public function __construct() {
            parent::__construct();
            $this->load->helper(array('form','html','url'));
            $this->load->library('form_validation');
            $this->xml = new DOMDocument('1.0','utf-8');
            $this->xml->formatOutput = true;
            $userdata = $this->session->userdata('ses');
            $this->user = $userdata['user'];
            $this->company = $userdata['company'];
    }
    public function client() {
        
    }
}
