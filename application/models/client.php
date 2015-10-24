<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends M_Model {

	public function __construct() {
            parent::__construct();
            $this->table = 'clients';
        }
        /*
         * 
         * Add a client. return client database-id if succeed. false if not.
         */
	public function add($client, $company)
	{
            $q = $this->db->get_where('clients',array('company_id'=>$company->db_id));
            $id = $company->db_id.'0000'.($q->num_rows()+1);
            if($this->db->set(array_merge($client,array('client_id'=>$id)))->insert('clients')) 
                return $id;
            else return false;
	}
        public function get_client($company,$client_id) {
            return $this->db->get_where($this->table,array('company_id'=>$company->db_id,'client_id'=>$client_id,'deleted'=>'0'))->row();
        }
        public function get_all($company,$c,$limit = '30',$start='',$end='') {
            $this->db->order_by('client_id',$c);
            if($limit!='') $this->db->limit($limit);
            return $this->db->get_where('clients',array('company_id'=>$company->db_id,'deleted'=>'0'))->result();
        }
        public function get_all_array($company,$c,$limit = '30',$start='',$end='') {
            $this->db->order_by('client_id',$c);
            if($limit!='') $this->db->limit($limit);
            return $this->db->get_where('clients',array('company_id'=>$company->db_id,'deleted'=>'0'))->result_array();
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
        public function get_clients_like($company,$string,$limit) {
            $this->db->where(array('company_id'=>$company->db_id,'deleted'=>'0'));
            $this->db->like('name',$string);
            $this->db->or_like('contact_name',$string);
            $this->db->or_like('client_id',$string);
            $this->db->from($this->table);
            $this->db->limit($limit);
            $q = $this->db->get();
            return $q->result();
        }
}

?>