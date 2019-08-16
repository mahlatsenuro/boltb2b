<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Sync {
    private $CI;

    function __construct() {
       $this->CI =& get_instance();
       $this->CI->load->database();
    }
    
    public function categories($product_id, $level1, $level2, $level3){ 
        
        if( empty($level1) || $level1 == 'NA')
            return;
        
        $level1 = trim($level1);
        $level2 = trim($level2);
        $level3 = trim($level3);
        
        
        $query = $this->CI->db->select('id')->from('categories')->where(array('name' => trim($level1), "parent_id" => 0))->get();
        if($query->num_rows() > 0){
            $level1s   = $query->row();
            $level1_id = $level1s->id;
        }
        else{
            $level1_id = $this->create_missing_cats($level1, 0); 
        }
        $this->create_cat_association($product_id, $level1_id);
        /**PARENT**/
        if( empty($level2) || $level2 == 'NA')
            return;
            
         
        /**PARENT**/
        $query = $this->CI->db->select('id')->from('categories')->where(array('name'=> $level2, 'parent_id' => $level1_id) )->get();
        if($query->num_rows() > 0){ 
            $level2s   = $query->row();
            $level2_id = $level2s->id;
        }
        else{
            $level2_id = $this->create_missing_cats($level2, $level1_id);
        }

        $this->create_cat_association($product_id, $level2_id);
        /**PARENT**/
         if( empty($level3) || $level3 == 'NA')
            return;
        /**PARENT**/
        $query = $this->CI->db->select('id')->from('categories')->where(array('name'=> $level3, "parent_id" => $level2_id))->get();
        if($query->num_rows() > 0){
            $level3s   = $query->row();
            $level3_id = $level3s->id;
        }
        else{
            $level3_id = $this->create_missing_cats($level3, $level2_id);
        }
        $this->create_cat_association($product_id, $level3_id);
        /**PARENT**/
        
        //$this->CI->db->where('product_id', $product_id);
        //$this->CI->db->where_not_in('category_id', array($level1_id, $level2_id, $level3_id));
        //$this->CI->db->delete('product_categories');
        
       // echo $this->CI->db->last_query();
       return;
    }
    
    public function create_missing_cats($cat_name, $parent=0){ 
        
        if($parent == 0)
            $insert = array('code' => uniqid('-code-'), 'parent_id' => $parent, 'name' => $cat_name, 'display_name' => $cat_name, 'active' => 1, 'in_menu' => 1);
        else
            $insert = array('code' => uniqid('-code-'), 'parent_id' => $parent, 'name' => $cat_name, 'display_name' => $cat_name, 'active' => 1, 'in_menu' => 1); 
                
        $result = $this->CI->db->insert('categories', $insert);
        //echo $this->CI->db->last_query();

        if($result)
            return $this->CI->db->insert_id();
        return FALSE;
    }
    
    public function create_cat_association($product_id, $category_id){
        $query = $this->CI->db->select('id')->from('product_categories')->where(array('product_id' => $product_id, 'category_id' => $category_id))->get();
        if($query->num_rows() > 0)
            return;
        
        return $this->CI->db->insert('product_categories', array('product_id' => $product_id, 'category_id' => $category_id ));
    }
    
    public function product_exist($field = 'id', $value=''){
        $query = $this->CI->db->where($field, $value)->get('products');
        if($query->num_rows() > 0){
            return $query->row()->id;
        }
        return FALSE;
    }
    
    public function create_product($data){
        $result = $this->CI->db->insert('products', $data);
        if($result){
            return $this->CI->db->insert_id();
        }
        return FALSE;
    }
    
    public function update_product($id, $data){
        $this->CI->db->where('id', $id);
        $result = $this->CI->db->update('products', $data);
        if($result){
            return $id;
        }
        return FALSE;
    }
    
    public function create_image($data){
        //echo $data['product_id']."\n";
        $this->CI->db->where('product_id', $data['product_id']);
        $query = $this->CI->db->get('images');
        if($query->num_rows() > 0){
            
            foreach ($query->result() as $image){
                if($image->featured == 1)
                    $data['featured'] = 0;
                if($image->image == $data['image'])
                    return $image->id;
                    
            }
            $result = $this->CI->db->insert('images', $data);
        }
        else{
            $result = $this->CI->db->insert('images', $data);
        }
        
        if($result){
            return $this->CI->db->insert_id();
        }
        return FALSE;
    }
    
    public function remove_product($ids){
        $this->CI->db->where('sync', 1);
        $this->CI->db->where_not_in('id', $ids);
        return $this->CI->db->delete('products');
    }
    
    public function create_manufacturer($product_id, $name){
        $manufacturer  = $this->CI->db->select("id, name")->from("manufacturer")->where("name", $name)->get();
        $existing_manu = $manufacturer->row();
        if($existing_manu){
            $manu_id = $existing_manu->id;
        }
        else{
            $insert     = array( 'name' => $name, 'index' => clean($name).uniqid()); 
            $this->CI->db->insert('manufacturer', $insert);
            $manu_id = $this->CI->db->insert_id();
        }
        
        if(is_numeric($manu_id)){
            
            $manufacturer  = $this->CI->db->select("id")->from("product_manufacurer")->where(array("product_id" => $product_id, "manufacturer_id" => $manu_id))->get();
            if(!$manufacturer->row()){
                $insert     = array( 'product_id' => $product_id, 'manufacturer_id' => $manu_id); 
                $this->CI->db->insert('product_manufacurer', $insert);
            }
        }
    }
    
    
    public function manage_attributes($product_id, $attribute_unique_id, $product_code, $attributes, $soh){
        
        $attribute_options_added = array();
        $attribute_names      = array_keys($attributes);
        $attribute_group_name = implode("_", $attribute_names);
        $attribute_group_name = clean($attribute_group_name)."_".$product_code;
        
        $this->CI->db->where('name', $attribute_group_name);
        $query = $this->CI->db->get('attribute_groups');
        if($query->num_rows() > 0){
            $attribute_group_id = $query->row()->id;
            
            $this->CI->db->where(array('product_id' => $product_id, 'group_id' => $attribute_group_id));
            $query = $this->CI->db->get('product_attributes');
            if($query->num_rows() > 0){
                $this->CI->db->where('id', $query->row()->id);
                $this->CI->db->update('product_attributes', array('product_id' => $product_id, 'group_id' => $attribute_group_id));
            }
            else{
                $this->CI->db->insert('product_attributes', array('product_id' => $product_id, 'group_id' => $attribute_group_id));
            }
            
        }
        else{
            $this->CI->db->insert('attribute_groups', array('name' => $attribute_group_name, 'date' => Date('Y-m-d')));
            $attribute_group_id = $this->CI->db->insert_id();
            
            $this->CI->db->where('product_id', $product_id);
            $this->CI->db->delete('product_attributes');
            
            $this->CI->db->insert('product_attributes', array('product_id' => $product_id, 'group_id' => $attribute_group_id));
        }
        
        $attribute_table_insert = array();
        $attribute_ids_array    = array();
        
        foreach ($attributes as $attribute_name => $attribute_value){
            
            $attribute_value          = trim($attribute_value);  
            $attribute_index          = clean($attribute_name).'_'.$product_code;
            
            $this->CI->db->where('index', $attribute_index);
            $query = $this->CI->db->get('attributes');
            if($query->num_rows() > 0){
                $attribute              = $query->row();
                $attribute_id           = $attribute->id;
            }
            else{
                
                $type = $attribute_name == 'color' ? 'color' : 'size';
                
                $this->CI->db->insert('attributes', array('index' => $attribute_index, 'type' => $type, 'name' => $attribute_name, 'system_name' => ucfirst($attribute_name), 'date' => Date('Y-m-d') ));
                $attribute_id = $this->CI->db->insert_id();  
            }
            
            
            
            if(isset($attribute_group_id) && isset($attribute_id)){
                $this->CI->db->where(array('group_id' => $attribute_group_id, 'attribute_id' => $attribute_id));
                $query = $this->CI->db->get('attribute_option_groups');
                if($query->num_rows() == 0){
                    $this->CI->db->insert('attribute_option_groups', array('group_id' => $attribute_group_id, 'attribute_id' => $attribute_id));
                }
            }
            
            $this->CI->db->where(array("attribute_id" => $attribute_id, 'name' => $attribute_value));
            $query = $this->CI->db->get('attribute_options');
            if($query->num_rows() > 0){
                $attribute_options_id = $query->row()->id;
                $this->CI->db->where("id", $attribute_options_id);
                $this->CI->db->update('attribute_options', array('name' => $attribute_value));
            }else{
                $this->CI->db->insert('attribute_options', array('name' => $attribute_value, 'attribute_id' => $attribute_id, 'sort' => rand(1,10)));
                $attribute_options_id = $this->CI->db->insert_id();
            }
            
            $attribute_ids_array['attribute'.(count($attribute_ids_array)+1)] = $attribute_options_id;
            $attribute_options_added[] = $attribute_options_id;
        }
        
        extract($attribute_ids_array);
        
        $where_array = array(
            'product_id' => $product_id, 
            'group_id' => $attribute_group_id
        );
        
        isset($attribute1) ? $where_array['attribute_id1'] = $attribute1 : 0;
        isset($attribute2) ? $where_array['attribute_id2'] = $attribute2 : 0;
        isset($attribute3) ? $where_array['attribute_id3'] = $attribute3 : 0;
        isset($attribute4) ? $where_array['attribute_id4'] = $attribute4 : 0;
        isset($attribute5) ? $where_array['attribute_id5'] = $attribute5 : 0;
        
        $this->CI->db->where($where_array);
        $query = $this->CI->db->get('stock_price_attributes');
        if($query->num_rows() == 0){
            $where_array['sku']             = $attribute_unique_id;
            $where_array['quantity']        = $soh;
            $where_array['min_quantity']    = 1;
            
            $this->CI->db->insert("stock_price_attributes", $where_array);
        }
        else{
            $attribute_price_id = $query->row()->id;
            $where_array['sku']             = $attribute_unique_id;
            $where_array['quantity']        = $soh;
            $where_array['min_quantity']    = 1;
            $this->CI->db->where('id', $attribute_price_id);
            $this->CI->db->update("stock_price_attributes", $where_array);
        }
        
        return $attribute_options_added;
        /*
        $attribute_ids = $attribute__option_ids = array();        
        foreach ($attribute_options as $key => $new_attribute){
            if($key > 4)
                break;
            if(empty($new_attribute))
                continue;
            
            $this->CI->db->where('index', $product_code.'-'.($key+1));
            $query = $this->CI->db->get('attributes');
            if($query->num_rows() > 0){
                $attribute              = $query->row();
                $attribute_id           = $attribute->id;
                if(!empty($new_attribute)){
                    $this->CI->db->where("name", $new_attribute);
                    $this->CI->db->where('attribute_id', $attribute_id);
                    $query              = $this->CI->db->get('attribute_options');
                    if($query->num_rows() == 0){
                        $this->CI->db->insert('attribute_options', array('sort' => ($key+1), 'attribute_id' => $attribute_id, 'name' => $new_attribute));
                        $attribute_option_id = $this->CI->db->insert_id();
                    }
                    else{
                        $attribute_option_id = $query->row()->id;
                    }
                }
            }
            else{
                $this->CI->db->insert('attributes', array('index' => $product_code.'-'.($key+1), 'type' => 'size', 'name' => 'Option '.($key+1), 'system_name' => trim($data->descr)." ".'Option '.($key+1), 'date' => Date('Y-m-d') ));
                $attribute_id = $this->CI->db->insert_id();  
                if(!empty($new_attribute)){
                    $this->CI->db->insert('attribute_options', array('sort' => ($key+1), 'attribute_id' => $attribute_id, 'name' => $new_attribute)); 
                    $attribute_option_id = $this->CI->db->insert_id();
                }
            }
            $attribute_ids[]         = $attribute_id; 
            $attribute__option_ids[] = $attribute_option_id; 
        }
        $this->CI->db->where('name', $product_code);
        $query = $this->CI->db->get('attribute_groups');
        if($query->num_rows() > 0){
            $attribute_group_id = $query->row()->id;
        }
        else{
            $this->CI->db->insert('attribute_groups', array('name' => $product_code, 'date' => Date('Y-m-d')));
            $attribute_group_id = $this->CI->db->insert_id();
        }
        //remove attribute option groups
        if(count($attribute_ids) > 0){
            $this->CI->db->where('group_id', $attribute_group_id);
            $this->CI->db->where_not_in('attribute_id', $attribute_ids);
            $this->CI->db->delete('attribute_option_groups');
        }
        foreach ($attribute_ids as $attribute_id){
            $this->CI->db->where('attribute_id', $attribute_id);
            $this->CI->db->where('group_id', $attribute_group_id);
            $query = $this->CI->db->get('attribute_option_groups');
            if($query->num_rows() == 0){
                $this->CI->db->insert('attribute_option_groups', array('attribute_id' => $attribute_id, 'group_id' => $attribute_group_id));
            }
        }
        $this->CI->db->where('product_id', $id);
        $this->CI->db->where('group_id', $attribute_group_id);
        $query = $this->CI->db->get('product_attributes');        
        if($query->num_rows() == 0){
            $this->CI->db->insert('product_attributes', array('product_id' => $id, 'group_id' => $attribute_group_id));
        }
        //Stock handling
        $this->CI->db->where(array('product_id' => $id, 'group_id' => $attribute_group_id, 'sku' => trim($unique_code)));
        $query = $this->CI->db->get('stock_price_attributes');
        $stock_data = array(
            'product_id'        => $id,
            'group_id'          => $attribute_group_id,
            'sku'               => trim($unique_code),
            'quantity'          => $soh,
            'min_quantity'      => 0,
            'price_variation'   => 0,
            'attribute_id1'     => NULL,
            'attribute_id2'     => NULL,
            'attribute_id3'     => NULL,
            'attribute_id4'     => NULL,
            'attribute_id5'     => NULL,
        );
        foreach ($attribute__option_ids as $attr_option_id => $attribute_option_id){
            $stock_data['attribute_id'.($attr_option_id+1)] = $attribute_option_id;                
        }
        if($query->num_rows() > 0){ 
            $stock      = $query->row();
            $stock_id   = $stock->id;
            $this->CI->db->where('id', $stock_id);
            $this->CI->db->update('stock_price_attributes', $stock_data); 
        }
        else{
            $this->CI->db->insert('stock_price_attributes', $stock_data);
        }
        unset($attribute_ids);
        return true; */
    }
}