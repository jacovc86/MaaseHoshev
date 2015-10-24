<?php


class Settings extends M_Controller{
    public function Settings() {
        parent::__construct();
        $this->lang->load('settings',$this->config->item('language'));
        $this->data['tab'] = $this->input->get('tab');
        switch($this->data['tab']) {
            case 'system':
            default:
                $this->system_settings_setup();
                break;
            case 'users':
                $this->users_settings_setup();
                break;
            case 'products':
                $this->products_settings_setup();
                break;
            case 'clients':
                $this->clients_settings_setup();
                break;
        }
    }
    public function index() {
        $this->data['title'] = $this->lang->line('settings_title');
        $this->data['content'] = 'settings/main';
        
        $this->load->view($this->template,$this->data); 
    }
    public function save() {
        if($this->input->post('post_security') !== $this->config->item('post_security'))
            redirect('settings');
        switch($this->input->post('form_type')) {
            case 'system':
            default:
                $this->save_system_form();
                break;
            case 'products':
                $this->save_products_form();
                break;
            case 'clients':
                $this->save_clients_form();
                break;
            
        }
        
    }
    function system_settings_setup() {
        $this->load->model('settings/system','settings');
        $this->data['system_settings'] = $this->settings->get(array('username'=>$this->the_user->username));
    }
    function users_settings_setup() {
        $this->load->model('user'); 
        $this->data['all_users'] = $this->user->get_users_by_company($this->the_company->db_id);
        
    }
    function products_settings_setup() {
        
    }
    function clients_settings_setup() {
        
    }
    function save_system_form() {
        $this->load->model('settings/system','settings');
        $system_settings = array(
            'session_time'      =>$this->input->post('settings_sestime')*60,
            'language'          =>$this->input->post('settings_language')
        );
        if($this->settings->save($this->the_user->username,$system_settings)) { 
            $this->lang->is_loaded = array();
            $this->lang->load('settings',$this->input->post('settings_language'));
            $this->session->set_flashdata('success',$this->lang->line('settings_saved_successfully'));
        }
        else {
            $this->session->set_flashdata('failure',$this->lang->line('error_saving_settings'));
        }
        redirect('settings?tab=system'); 
    }
    public function add_user() {
        if($this->input->post('post_security') !== $this->config->item('post_security'))
            redirect('settings?tab=users');
        $user = array(
            'name'          =>  $this->input->post('name'),
            'id'            =>  $this->input->post('id'),
            'username'      =>  $this->input->post('username'),
            'email'         =>  $this->input->post('email'),
            'password'      =>  $this->input->post('password'),
            'role'          =>  $this->input->post('role'),
            'level'         =>  $this->input->post('level'),
            'company_id'    =>  $this->the_company->db_id,
            'company_name'  =>  $this->the_company->business_name
        );
        $this->load->model('user');
        if($this->user->add_user($user)) {
            $this->load->model('settings/users','settings');
            $this->settings->init_user($user['username']);
            $this->session->set_flashdata('success',$this->lang->line('user_added_succesfully'));
        }
        else {
            $this->session->set_flashdata('failure',$this->lang->line('error_user_not_added'));
        }
        redirect('settings?tab=users');
    }
}

?>
