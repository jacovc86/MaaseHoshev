<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends M_Model {

	public function __construct() {
            parent::__construct();
            $this->table = 'invoices';
        }
        #Add an invoice. return invoice database-id if succeed. false if not.
	public function add($invoice,$company,$client_id)
	{
            $q = $this->db->get_where($this->table,array('company_id'=>$company->db_id,'client_id'=>$client_id));
            $id = $company->db_id.'000'.($q->num_rows()+1);
            if($this->db->set(array_merge($invoice,array('invoice_id'=>$id)))->insert($this->table)) 
                return $id;
            else return false;
	}
        public function get($company,$client_id) {
            return $this->db->get_where('clients',array('company_id'=>$company->db_id,'client_id'=>$client_id,'deleted'=>'0'))->row();
        }
        public function get_all($company,$c,$limit = '',$start='',$end='') {
            $this->db->order_by('client_id',$c);
            return $this->db->get_where('clients',array('company_id'=>$company->db_id,'deleted'=>'0'))->result();
        }
        public function update($client,$id) {
            $this->db->where('db_id',$id);
            return $this->db->update('clients',$client);
        }
	public function get_contacts($company,$client_id) {
            return $this->db->get_where('client_contacts',array('client_id'=>$client_id,'company_id'=>$company->db_id))->result();
        }
        public function add_contact($company,$client_id,$contact_data) {
            if($this->db->set(array_merge($contact_data,array('client_id'=>$client_id,'company_id'=>$company->db_id)))->insert('client_contacts')) 
                    return $this->db->insert_id();
            else return false;
            
        }
        public function client_active($company,$client_id) {
            $c = $this->db->get_where('clients',array('company_id'=>$company->db_id,'client_id'=>$client_id),1)->row();
            return $c->active!=0;
        }
        public function delete_client($company,$client_id) {
            $this->db->where(array('company_id'=>$company->db_id,'client_id'=>$client_id));
            return $this->db->update('clients',array('deleted'=>'1'));
        }
        public function delete_contact($company,$contact_id) {
            return $this->db->delete('client_contacts',array('company_id'=>$company->db_id,'db_id'=>$contact_id));
        }
}

?>