<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manufacture_Model extends CI_Model
{
    
    
    /**
     * @method get_attributes - get all manufactures available
     * @param int $id manufacture id conditional
     * @return array with manufactures 
     * called from admin/manufactures
     */
    
    public function get_manufactures($id = '', $by = ''){
        
        $this->db->select('id, name, date, details'); 
         
        if (!empty($id)):
            $this->db->where( $by, $id );
        endif;
        
        $query = $this->db->get('manufacturer');
        
        if (!empty($id)):
            return $query->row();
        endif;
        
        return $query->result();
        
    }
    
    
    /**
     * @method type create_news(type $paramName) Create new manufacture / Update if id exists
     * @return ID on success and false on failure!
     * called on update and create
     */
    
    public function create_new()
    {
        $id         = $this->input->post('manufacturer_id');
        $name       = $this->input->post('name');
        $details    = $this->input->post('details');
        
        $data['name']       = $name;
        $data['details']    = $details;
        
        if (empty($id)) 
        {
            $data['index'] = strtolower( str_replace( ' ', '-', $name) ).uniqid('-manu-');
            $this->db->insert('manufacturer', $data);
            
            return $this->db->insert_id();
        }
        else{
            $this->db->where('id', $id);
            $update = $this->db->update('manufacturer', $data); 
            
            if ($update){
                return $id;
            }
            return FALSE;
        }

    }
    
    /**
     * @method type deletes(type $paramName) Delete an manufacturer
     * @param int $id Id of manufacturer to delete
     * @return boolean True on success False on failure
     */
    
    public function delete($id)
    {
        return  $this->db->delete('manufacturer', array('id' => $id)); 
    }
    
}