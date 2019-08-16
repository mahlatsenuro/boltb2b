<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attributes_Model extends CI_Model{
    /**
     * @method get_attributes - get all attributes available
     * @param int $id attribute id conditional
     * @return array with attributes 
     * called from admin/attributes
     */
    public function get_attributes($id = '', $by = ''){
        $this->db->select('id, name,  type, date, system_name'); 
        if (!empty($id)):
            $this->db->where( $by, $id );
        endif;
        $query = $this->db->get('attributes');
        if (!empty($id)):
            return $query->row();
        endif;
        return $query->result();
    }
    
    public function get_attribute_groups($id = '', $by = ''){
        $this->db->select('id, name, date'); 
        if (!empty($id)):
            $this->db->where( $by, $id );
        endif;
        $query = $this->db->get('attribute_groups');
        if (!empty($id)):
            return $query->row();
        endif;
        return $query->result();
    }
    
    public function get_attribute_options($attribute_id){
        $query = $this->db->select('a.name as aname, a.system_name, o.id, o.name as oname, o.hex, o.sort')->from('attributes a')->join('attribute_options o', 'o.attribute_id = a.id')->where('a.id', $attribute_id)->order_by('o.sort', 'asc')->get();
        
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function get_attributes_existing($id){
        $this->db->where('attribute_id', $id);
        $query = $this->db->select('ao.name, ao.id, ao.hex, ao.sort, a.name as aname')->from('attribute_options ao')->join('attributes a', 'a.id = ao.attribute_id AND a.id = '.$id )->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE();
    }

    /**
     * @method type create_news(type $paramName) Create new attribute / Update if id exists
     * @return ID on success and false on failure!
     * called on update and create
     */
    public function create_new($type='size', $attribute_id=NULL){
        $id             = $attribute_id;
        $name           = $this->input->post('attribute_name');
        $option_values  = $this->input->post('attr_options');
        $option_sort    = $this->input->post('sort');
        $system_name    = $this->input->post('system_name');
        $data           = array();
        $data['name']           = $name;
        $data['system_name']    = $system_name;
        $ids            = $this->input->post('ids'); 
        
        if($type == 'colour'){
            $hex_values  = $this->input->post('hex');
        }
        
        if (empty($id)){
            $data['type']  = $type; 
            $data['index'] = strtolower( str_replace( ' ', '_', $name) ).'_'.  uniqid();
            $this->db->insert('attributes', $data);
            $attribute_id  = $this->db->insert_id();
            if($attribute_id){
                
                foreach ($option_values as $key => $option_val){
                    $options = array();
                    
                    if(empty($option_val)) continue;
                    
                    $options['attribute_id'] = $attribute_id;
                    $options['name']         = $option_val;
                    $options['sort']         = $option_sort[$key];
                    if($type == 'colour'){
                        if(!isset($hex_values[$key]) || empty($hex_values[$key]) || strpos($hex_values[$key], '#') === FALSE)
                            continue;
                        
                        $options['hex']      = $hex_values[$key];
                    }
                    $this->db->insert('attribute_options', $options);
                }
            }  
            return $attribute_id;
        }
        else{
            $this->db->where('id', $id);
            $update     = $this->db->update('attributes', $data); 
            $option_ids = $ids;
            
            /** Delete if not found in update page **/
            $this->db->where_not_in('id', $option_ids);
            $this->db->where('attribute_id', $attribute_id);
            $this->db->delete('attribute_options');
            
            foreach ($option_values as $key => $option_val){
                $options = array();

                if(empty($option_val)) continue;

                $options['attribute_id'] = $attribute_id;
                $options['name']         = $option_val;
                $options['sort']         = $option_sort[$key];
                if($type == 'colour'){
                    if(!isset($hex_values[$key]) || empty($hex_values[$key]) || strpos($hex_values[$key], '#') === FALSE)
                        continue;

                    $options['hex']      = $hex_values[$key];
                }
                if(isset($option_ids[$key]) && is_numeric($option_ids[$key])){ 
                    
                    $this->db->where('id', $option_ids[$key]);
                    $this->db->update('attribute_options', $options);
                }
                else{ 
                    $this->db->insert('attribute_options', $options);
                }
            }
            if ($update){
                return $id;
            }
            return FALSE;
        }
    }
    
    public function create_new_group($group_id=NULL){
        
        $group_name = $this->input->post('group_name');
        $members    = $this->input->post('members');
        $sorts      = $this->input->post('sort');        
        
        if(empty($group_id)){ 
            $data   = array('name' => $group_name);
            $result = $this->db->insert('attribute_groups', $data); 
            if($result){
                $group_id = $this->db->insert_id();
                
                foreach ($members as $key => $attr_id){
                    $member   = array();
                    if(empty($attr_id) || !is_numeric($attr_id))
                        continue;
                    
                    $member['group_id']     = $group_id;
                    $member['attribute_id'] = $attr_id;
                    $member['sort']         = $sorts[$key];
                    $this->db->insert('attribute_option_groups', $member);
                }
                return $group_id; 
            }
            return FALSE;
        }
        else{
            $data   = array('name' => $group_name);
            $this->db->where('id', $group_id);
            $result = $this->db->update('attribute_groups', $data); 
            
            foreach ($members as $key => $attr_id){
                $member   = array();
                if(empty($attr_id) || !is_numeric($attr_id))
                    continue;
                
                $this->db->where(array('group_id' => $group_id, 'attribute_id' => $attr_id));
                $query = $this->db->get('attribute_option_groups');
                
                if($query->num_rows() > 0){
                    $member['group_id']     = $group_id;
                    $member['attribute_id'] = $attr_id;
                    $member['sort']         = $sorts[$key];
                    $this->db->where(array('group_id' => $group_id, 'attribute_id' => $attr_id));
                    $this->db->update('attribute_option_groups', $member);
                }
                else{
                    $member['group_id']     = $group_id;
                    $member['attribute_id'] = $attr_id;
                    $member['sort']         = $sorts[$key];
                    $this->db->insert('attribute_option_groups', $member);
                }
            }
            
            $this->db->where('group_id', $group_id);
            $this->db->where_not_in('attribute_id', $members);
            $this->db->delete('attribute_option_groups');
            
            return $group_id; 
        }
    }

        /**
     * @method type deletes(type $paramName) Delete an attribute
     * @param int $id Id of attribute to delete
     * @return boolean True on success False on failure
     */
    
    public function delete($id)
    {
        return  $this->db->delete('attributes', array('id' => $id)); 
    }
    
    public function delete_group($id)
    {
        return  $this->db->delete('attribute_groups', array('id' => $id)); 
    }
    
    public function get_attribute_options_details($group_id = NULL){
        $query = $this->db->select('g.name as gname, o.attribute_id')->from('attribute_groups as g')->join('attribute_option_groups as o', 'o.group_id = g.id')->where('g.id', $group_id)->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
}