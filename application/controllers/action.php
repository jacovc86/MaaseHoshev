<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends CI_Controller {

    public function __construct() {
            parent::__construct();
            $this->load->helper(array('form','html','url'));
            $this->load->library('form_validation');
            $this->load->helper('cookie');
            $this->lang->load('template',$this->config->item('language'));
    }
    public function login() {
        $this->load->model('user');
        if(($user = $this->user->login($this->input->post('username'),$this->input->post('password')))!==false) {
           
            $this->load->model('sesid');
            $userdata = $this->session->all_userdata();
            $this->sesid->push($userdata['session_id'],$user->db_id,$userdata['ip_address'],$userdata['user_agent']);
            $this->session->set_flashdata('success',$this->lang->line('hello').' '.$user->name.'. '.$this->lang->line('your_last_visit_was').' '.$user->last_visit); 
            $this->session->set_userdata('ses',array('user'=>$user,'company'=>$this->user->get_company_by_superuser($this->input->post('username'))));
            $this->user->update_user($user->username,array('last_visit'=>date('d/m/y H:i:s')));
            redirect('/','refresh');
        }
        else {
            $this->session->set_flashdata('failure',$this->lang->line('mal_username_or_password'));
            redirect('login','refresh');
        }
    }
    public function logout() {
        $this->session->unset_userdata('ses');
        $this->session->sess_destroy();
        redirect('','refresh');
    }
    public function register() {
        $this->load->model('user');

        $company = array(
                'business_name'=>$this->input->post('business_name'),
                'business_id'=>$this->input->post('business_id'),
                'address_st'=>$this->input->post('address_st'),
                'address_number'=>$this->input->post('address_number'),
                'address_city'=>$this->input->post('address_city'),
                'address_mikud'=>$this->input->post('address_mikud'),
                'address_pob'=>$this->input->post('address_pob')
        );
        $superuser = array(
                'name'=>$this->input->post('uname'),
                'id'=>$this->input->post('uid'),
                'username'=>$this->input->post('reg_username'),
                'email'=>$this->input->post('email'),
                'password'=>$this->input->post('reg_password')
        );
        $rules = array(
            array('field'=>'business_name','label'=>'שם החברה','rules'=>'trim|required|min_length[3]|xss_clean'),
            array('field'=>'business_id','label'=>'מספר עוסק','rules'=>'trim|required|xss_clean|min_length[7]|max_length[20]'),
            array('field'=>'address_st','label'=>'רחוב','rules'=>'trim|required|min_length[3]|xss_clean'),
            array('field'=>'address_number','label'=>'מספר בית','rules'=>'trim|xss_clean'),
            array('field'=>'address_city','label'=>'עיר','rules'=>'required|trim|xss_clean'),
            array('field'=>'address_mikud','label'=>'מיקוד','rules'=>'trim|xss_clean'),
            array('field'=>'address_pob','label'=>'ת.ד. (אם יש)','rules'=>'trim|xss_clean'),
            array('field'=>'uname','label'=>'שם מלא','rules'=>'trim|required|min_length[3]|xss_clean'),
            array('field'=>'uid','label'=>'תעודת זהות','rules'=>'trim|required|xss_clean|min_length[7]|max_length[9]'),
            array('field'=>'reg_username','label'=>'שם משתמש','rules'=>'trim|required||is_unique[users.username]|min_length[3]|xss_clean'),
            array('field'=>'email','label'=>'כתובת אימייל','rules'=>'required|is_unique[users.email]|valid_email|trim|xss_clean'),
            array('field'=>'reg_password','label'=>'סיסמא','rules'=>'required|minlength[6]'),
        );
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==FALSE) {
            $this->session->set_flashdata('failure','שגיאה במילוי טופס הרשמה | ------- '.validation_errors(' | ',' '));
            $this->session->set_flashdata('business_id_f',$company['business_id']);
            $this->session->set_flashdata('address_st_f',$company['address_st']);
            $this->session->set_flashdata('address_number_f',$company['address_number']);
            $this->session->set_flashdata('address_city_f',$company['address_city']);
            $this->session->set_flashdata('address_mikud_f',$company['address_mikud']);
            $this->session->set_flashdata('address_pob_f',$company['address_pob']);
            $this->session->set_flashdata('uname_f',$superuser['name']);
            $this->session->set_flashdata('uid_f',$superuser['id']);
            $this->session->set_flashdata('reg_username_f',$superuser['username']);
            $this->session->set_flashdata('email_f',$superuser['email']  );
            redirect('login?a=register','refresh');
        }
        else {
            if($this->user->register_company($company,$superuser)!==FALSE) {
                $user = $this->user->get_user_by_username($superuser['username']);
                $comp = $this->user->get_company_by_superuser($superuser['username']);
                $config['upload_path'] = "media/data/clients/$comp->client_id/images/";
                $config['allowed_types'] = "gif|png|jpg";
                $config['max_size'] = '1000';
                $config['max_width'] = '1024';
                $config['max_height'] = '512';
                $this->load->library('upload',$config);
                if(!$this->upload->do_upload('upload_logo')) {
                    $this->session->set_flashdata('failure','אין תמונת לוגו | '.$this->upload->display_errors());
                }
                else {
                    $upload_data = $this->upload->data();
                    $this->user->update_company($comp->client_id,array('logo'=>"media/data/clients/$comp->client_id/images/".    $upload_data['file_name']));
                }
                $user = $this->user->get_user_by_username($superuser['username']);
                $comp = $this->user->get_company_by_superuser($superuser['username']);
                $this->session->set_userdata('ses',array('user'=>$user,'company'=>$comp)); 
                $this->user->update_user($user->username,array('last_visit'=>date('d/m/y H:i:s')));
                $this->session->set_flashdata('success','ההרשמה הסתיימה בהצלחה, אנו נשמח לראות את החברה '.$company['business_name'].' משתמשת בשירותינו בעתיד.</br>תודה לך '.$superuser['name'].' שבחרת בנו');
                redirect('/','refresh');
            }
            else {
                $this->session->set_flashdata('failure','אירעה שגיאה בלתי צפויה בתהליך ההרשמה, אנא נסה שוב מאוחר יותר');
                redirect('login?a=register','refresh');
            }
        }
    }
}
