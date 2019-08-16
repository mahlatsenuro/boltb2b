<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_Model extends CI_Model
{
    
    
    /**
     * @method get_categories - get all categories available
     * @param int $id category id conditional
     * @return array with categories 
     * called from admin/categories index, new_category, exists, unique, 
     */
    
    public function get_categories($id = '', $by = ''){
        
        $query = "SELECT c.id as cid, c.name as cname, c.display_name as dname, c.parent_id as cparent, c.date as cdate, c.active, b.name as parent_name, c.in_menu, c.sort FROM `categories` as c LEFT JOIN categories as b on b.`id` = c.`parent_id`";
        
        if (empty($id))
        {            
            if ($id == '0')
            {
                $query .= ' WHERE c.parent_id = ? ORDER BY c.name ASC';
                $query = $this->db->query( $query, array(0) ); 
                
            }
            else {
               $query = $this->db->query( $query.' ORDER BY c.name ASC' );
            }
            
            if ($query->num_rows() > 0)
            {
                return $query->result();
            }
        }
        else
        {
            $query .= ' WHERE c.'.$by.' = ? ORDER BY c.name ASC';
            $query = $this->db->query( $query, array($id) );
            return $query->row();
        }
        return FALSE;
    }
    
    public function category_select()
    {
        $query = $this->db->query('SELECT id as cid, name as cname, parent_id FROM categories ORDER BY parent_id, name');
        
         $category = array(
            'categories' => array(),
            'parent_cats' => array()
        );
         
        $result = $query->result(); 
        
        //foreach($result as $row)
        //{
           // $category['categories'][$row['id']]    = $row;
           // $category['parent_cats'][$row['id']][] = $row['id'];
       // }
        
        return $result;
    }


    public function update_cates()
    {
       
        $categories = $this->input->post('cats'); 
        $data = array();
        $data['parent_id'] = $this->input->post('parent');
             
        foreach ($categories as $cats)
        {
            $this->db->where('id', $cats);
            $this->db->update('categories', $data); 
            //echo $this->db->last_query();
        }  
        return TRUE;
    }

        /**
     * @method type create_news(type $paramName) Create new category / Update if id exists
     * @return ID on success and false on failure!
     * called on update and create
     */
    
    public function create_new()
    {
        $id      = $this->input->post('category_id');
        $name    = $this->input->post('category_name');
        $dname   = $this->input->post('display_name');
        $parent  = $this->input->post('parent_category');
        $is_menu = $this->input->post('menu');
        $sort    = $this->input->post('sort');
        
        $data['name']           = $name;
        $data['display_name']   = $dname;
        $data['parent_id']      = $parent;
        $data['in_menu']        = isset($is_menu)&&$is_menu==1  ? 1 : 0;
        $data['sort']           = is_numeric($sort) ? $sort : 5;
        
        if (empty($id)) 
        {   
            $data['code'] = uniqid();
            $this->db->insert('categories', $data);
            return $this->db->insert_id();
        }
        else{ 
            $this->db->where('id', $id);
            $update = $this->db->update('categories', $data); 
            
            
            if ($update){
                return $id;
            }
            return FALSE;
        }

    }
    
    /**
     * @method type deletes(type $paramName) Delete an category
     * @param int $id Id of category to delete
     * @return boolean True on success False on failure
     */
    
    public function delete($id)
    {
        $this->db->where( 'id', $id );
        $this->db->or_where( 'parent_id', $id );
        return  $this->db->delete('categories'); 
    }
    
    public function remove_bulk(){
        $categories = $this->input->post('cats');
        
        $this->db->where_in("parent_id", $categories);
        $query = $this->db->select('id')->get('categories');
        
        if($query->num_rows() > 0){
            $result = $query->result();
            $ids    = array();
            foreach ($result as $re)
                $ids[] = $re->id;
            
            if(count($ids) > 0){
                $this->db->where_in('parent_id', $ids);
                $this->db->delete('categories');
            }
        }
        if(is_array($categories) && count($categories) > 0){
            $this->db->or_where_in('id', $categories);
            $this->db->or_where_in('parent_id', $categories);
            $this->db->delete('categories');
        }
        return TRUE;
    }

    public function deactivate($cat_id)
    {
        $this->db->where('id', $cat_id);
        return $this->db->update('categories', array('active' => 0));
    }
    
    public function activate($cat_id)
    {
        $this->db->where('id', $cat_id);
        return $this->db->update('categories', array('active' => 1));
    }
}


?>