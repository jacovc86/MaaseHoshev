<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends M_Controller {

    public $company,$user;
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form','html','url'));
        $this->load->library('form_validation');
        $this->load->model('client');
        array_push($this->data['scripts'],'Clients');
    }
    public function index()
    {
            redirect('clients/view','refresh');
    }
    public function new_client() {
        $this->data['title'] = 'לקוח חדש';
        $this->data['content'] = 'new/client';
        $this->load->view($this->template,$this->data);            
    }
    public function view() {
        if($this->input->get('cid')!='') {
            $client_id = $this->input->get('cid');
            $this->data['client'] = $this->client->get_client($this->the_company,$client_id);
            if(empty($this->data['client'])) $this->data['title'] = "לקוח לא קיים";
            else $this->data['title'] = "כרטיס לקוח ".$this->data['client']->name;
            if($this->input->get('tab')!='') {
                $this->data['tab'] = $this->input->get('tab');
                switch($this->data['tab']) {
                    case 'contacts':
                        $this->data['contacts'] = $this->client->get_contacts($this->the_company,$client_id);
                        $this->data['title'] = "כרטיס לקוח ".$this->data['client']->name." | אנשי קשר";
                    
                }
            }
            else $this->data['tab'] = 'details';
            $this->data['content'] = 'display/client/card';
        }
        else {
            $c = $this->input->get('c');
            if($this->input->get('l')!='all') $limit = $this->input->post('clients_limit');
            else $limit = '';
            if(empty($c)) $c = 'desc';
            $this->data['clients'] = $this->client->get_all($this->the_company,$c,$limit);
            if($this->input->get('l')!='all') $this->data['limit'] = $limit;
            else $this->data['limit'] = sizeof($this->data['clients']);
            $this->data['c'] = $c;
            $this->data['title'] = "רשימת לקוחות";
            $this->data['content'] = 'display/client/all_clients';
        }
        $this->load->view($this->template,$this->data);
    }
    public function save() {
        $client_data = array(
            'company_id'=>$this->the_user->company_id,
            'name'=>$this->input->post('client_name'),
            'id'=>$this->input->post('client_id'),
            'street'=>$this->input->post('client_street'),
            'st_number'=>$this->input->post('st_number'),
            'city'=>$this->input->post('city'),
            'mikud'=>$this->input->post('mikud'),
            'pob'=>$this->input->post('pob'),
            'contact_name'=>$this->input->post('contact_name'),
            'contact_phone'=>$this->input->post('contact_phone'),
            'contact_mobile'=>$this->input->post('contact_mobile'),
            'contact_fax'=>$this->input->post('contact_fax'),
            'contact_email'=>$this->input->post('contact_email'),
            'notes'=>$this->input->post('notes'),
            'date_created'=>date('d/m/y')
        );
        $rules = array(
                array('field'=>'client_name','label'=>'שם הלקוח','rules'=>"trim|is_unique[clients.name]|required|min_length[3]|xss_clean"),
                array('field'=>'client_id','label'=>'ת.ז. או ח.פ.','rules'=>"trim|is_unique[clients.id]|min_length[6]|xss_clean")
            );
        $this->form_validation->set_rules($rules);
        if(!$this->form_validation->run()) {
            $this->session->set_flashdata('failure',validation_errors(' | ',''));
            redirect('clients/new_client');
        }

        if($client_id = $this->client->add($client_data,$this->the_company)) {
            $this->session->set_flashdata('success','הלקוח נשמר בהצלחה');
            redirect("clients/view?cid=$client_id");
        }
        else {
            $this->session->set_flashdata('failure','הלקוח לא נשמר');
            redirect('clients/new_client');
        }
    }
    private function update_client_details($client_id,$db_id) {
        $client_data = array(
            'name'=>$this->input->post('client_name'),
            'id'=>$this->input->post('client_id'),
            'street'=>$this->input->post('client_street'),
            'st_number'=>$this->input->post('st_number'),
            'city'=>$this->input->post('city'),
            'mikud'=>$this->input->post('mikud'),
            'pob'=>$this->input->post('pob'),
            'contact_name'=>$this->input->post('contact_name'),
            'contact_phone'=>$this->input->post('contact_phone'),
            'contact_mobile'=>$this->input->post('contact_mobile'),
            'contact_fax'=>$this->input->post('contact_fax'),
            'contact_email'=>$this->input->post('contact_email'),
            'notes'=>$this->input->post('notes'),
        );
        $rules = array(array('field'=>'client_name','label'=>'שם הלקוח','rules'=>'trim|required|min_length[3]|xss_clean'));
        $this->form_validation->set_rules($rules);
        if(!$this->form_validation->run()) {
            $this->session->set_flashdata('failure',validation_errors(' | ',' '));
            redirect("clients/view?cid=$client_id");
        }
        
        if($this->client->update($client_data,$db_id)) {
            $this->session->set_flashdata('success','הלקוח עודכן בהצלחה');
            redirect("clients/view?cid=$client_id");
        }
        else {
            $this->session->set_flashdata('failure','הלקוח לא נשמר');
            redirect("clients/view?cid=$client_id");
        }
    }
    private function update_client_contacts($client_id,$db_id) {
        $contact_data = array(
            'name'=>$this->input->post('contact_name'),
            'phone'=>$this->input->post('contact_phone'),
            'mobile'=>$this->input->post('contact_mobile'),
            'fax'=>$this->input->post('contact_fax'),
            'email'=>$this->input->post('contact_email'),
        );
        $rules = array(array('field'=>'contact_name','label'=>'שם מלא','rules'=>'trim|required|min_length[3]|xss_clean'));
        $this->form_validation->set_rules($rules);
        if(!$this->form_validation->run()) {
            $this->session->set_flashdata('failure',validation_errors(' | ',' '));
            redirect("clients/view?cid=$client_id&tab=contacts");
        }
        if($this->client->add_contact($this->the_company,$client_id,$contact_data)) {
            $this->session->set_flashdata('success','הלקוח עודכן בהצלחה');
            redirect("clients/view?cid=$client_id&tab=contacts");
        }
        else {
            $this->session->set_flashdata('failure','הלקוח לא נשמר');
            redirect("clients/view?cid=$client_id&tab=contacts");
        }
    }
    public function update($tab = 'details') {
        $db_id = $this->input->post('db_id');
        $client_id = $this->input->post('the_id');
        switch($tab) {
            case 'details':
                $this->update_client_details($client_id,$db_id);
                break;
            case 'contacts':
                $this->update_client_contacts($client_id,$db_id);
                break;
            case 'default':
                $this->session->set_flashdata('failure','אירעה שגיאה, פרטי לקוח מסוג זה אינם קיימים');
                redirect('/','refresh');
        }
        
    }
    public function delete($client_id) {
        if(!$this->client->client_active($this->the_company,$client_id)) {
            if($this->client->delete_client($this->the_company,$client_id)) {
                $this->session->set_flashdata('success','הלקוח נמחק בהצלחה');
                redirect('clients/view','refresh');
            }
        }
        else {
            $this->session->set_flashdata('failure','לא ניתן למחוק לקוח פעיל');
            redirect('clients/view','refresh');
        }
    }
    public function delete_contact($contact_id, $client_id) { 
        if($this->client->delete_contact($this->the_company,$contact_id)) {
            $this->session->set_flashdata('success','איש קשר נמחק בהצלחה');
            redirect("clients/view?cid=$client_id&tab=contacts",'refresh');
        }
        else {
            $this->session->set_flashdata('failure',$this->db->_error_message());
        }
    }
    public function ajax() {
       if($this->input->post('security_key')!=$this->config->item('ajax_security')) {
            echo 'failure';
            return;
       }
       else {
            switch($this->input->post('action')) {
                case '':
                    echo 'failure';
                    return;
                case 'get_clients_by_first_letters':
                    echo $this->client->get_clients_like($this->the_company,$this->input->post('string'));
            }
        }
    }
}
?>