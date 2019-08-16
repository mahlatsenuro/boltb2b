<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_Model extends CI_Model
{
    
    /**
     * @method type get_addresss(type $paramName) get address of a user
     * @param int $user_id id of the logged in user
     * @return array array of addresses
     * called from address/index
     */
    public function get_address($user_id, $unique_id = '', $type)
    {
        $query = $this->db->select('id, address_id, contact_id, company_name, street, location_type, suburb_id, suburb_name, town_id, town_name, zip_code, full_name, phone, cellphone, unique')
                      ->from('address')->where('user_id', $user_id)->where('type', $type);
                
        if ( !empty($unique_id) )
        {
            $query->where('unique', $unique_id);
        }
                
        $query = $query->get(); 
        
        if ($query->num_rows() > 0)
        {
            return !empty($unique_id) ? $query->row() : $query->result();
        }
        return FALSE;
    }
    
    /**
     * @method type create_addresss(type $paramName) to create a new address
     * @param 1 $user_id id of the logged in user
     * @param 2 $address_id id of the address
     * @return type Description
     */
    
    public function create_address($user_id, $unique_id = '')
    {
        $name        = $this->input->post('name');
        $address1    = $this->input->post('address1');
        $address2    = $this->input->post('address2');
        $town        = $this->input->post('town');
        
        $state       = $this->input->post('state');
        $pincode     = $this->input->post('pincode');
        $phone       = $this->input->post('phone');
        $info        = $this->input->post('info');

        $data        = array(
            
            'name'          => $name,
            'user_id'       => $user_id,
            'address_line1' => $address1,
            'address_line2' => $address2,
            'town'          => $town,
            'state'         => $state,
            'pincode'       => $pincode,
            'phone'         => $phone,
            'additional'    => $info, 
        );
        if (empty($unique_id))
        {
            $unique         = strtolower(preg_replace('/\s+/', '-', $name).'-'.uniqid('addr-'));
            $data['unique'] = $unique;
            
            $this->db->insert('address', $data);
            return $this->db->insert_id();
        }
        else
        {
            $this->db->where(array('unique' => $unique_id, 'user_id' => $user_id));
            return $this->db->update('address', $data);
        }
        
    }
    
    /**
     * @method type remove_addresss(type $paramName) to remove selected address from the user list
     * @param1  int $user_id
     * @param2  int $unique_id id of address to remove
     * @return boolean TRUE/FALSE
     * Called from address/remove_address
     */
    public function remove_address($user_id, $unique_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('unique' , $unique_id);
        return $this->db->delete('address');
    }
    
    /**
     * @method get_collect_from_address to get admin collect from address
     * 
     */
    public function get_collect_from_address()
    {
       $query = $this->db->select('id, company_name, street, location_type, suburb_id, town_id, zip_code, full_name, phone, cellphone, email, address_id, free_delivery_above')->from('address_delivery')->get();
       
       if ($query->num_rows() > 0)
           return $query->row();
       return FALSE;
       
    }
    
    /**
     * @method To create a new address from where delivery has to be taken 
     * @param type $id
     */
    public function create_new_deliver_to($id, $data)
    {
        if(empty($id))
        {    
            $data['unique'] = strtolower(preg_replace('/\s+/', '_', $data['full_name']).uniqid('-addr-'));
            
            $this->db->insert('address', $data);
            return $this->db->insert_id();
        }
        else
        {
            $this->db->where('unique', $id);
            if($this->db->update('address', $data))
                return $id;
            return FALSE;
        }    
    }
    
    
    /**
     * @method To create a new address from where delivery has to be taken 
     * @param type $id
     */
    public function create_new_deliver_from($id, $data)
    {
        if(empty($id))
        {    
            $this->db->insert('address_delivery', $data);
            return $this->db->insert_id();
        }
        else
        {
            $this->db->where('id', $id);
            if($this->db->update('address_delivery', $data))
                return $id;
            return FALSE;
        }    
    }
}
    
    
    