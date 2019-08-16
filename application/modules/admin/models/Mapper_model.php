<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mapper_model extends CI_Model
{
    
    public function sync_users(){ 
        $micomp        = $this->load->database('micomp', TRUE);
        $query         = $micomp->select('*')->from('m1debtors')->get();
        if($query->num_rows() > 0){
            $users = $query->result(); 
            
            foreach ($users as $user):
                if (!filter_var($user->Email, FILTER_VALIDATE_EMAIL))
                    continue;
                $exist_user = $this->db->where('email', $user->Email)->get('users');                
                if($exist_user->num_rows() == 0){
                    $username = $user->Email;
                    $password = 'Pos@12Q9PoBv!@#';
                    $email     = $user->Email;
                    $additional_data = array(
                        'first_name' => $user->contact,
                        'company'    => $user->name,
                        'phone'      => $user->tel1,
                    );
                    if ($user_id = $this->ion_auth->register($username, $password, $email, $additional_data)){   
                            $activation = $this->ion_auth->activate($user_id);
                    }
                }                
            endforeach;
        }
    }
    

    public function get($table){
        $micomp = $this->load->database('micomp', TRUE);
        $query  = $micomp->select('*')->from($table)->get();
        $result = FALSE;
        if($query->num_rows() > 0){
            $cont = $query->result_array();
            echo '<table>';
            foreach( $cont[0] as $p => $cs){
                echo '<td  style="width:200px; height:50px;"><strong>'.$p.'</strong><br/></td>';
            }
            foreach( $cont as $co){
                echo '<tr>';
                foreach ($co as $key => $c) {
                    echo '<td style="width:200px;">'.$c.'<br/></td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }
        else{
            echo 'No data';
        }
    }
    
    public function load_products(){
        $start  = 0;
        $batch  = 8501;
        $micomp = $this->load->database('micomp', TRUE);
        while(1){
            $query      = $micomp->select('*')->from('m1stockt2')->group_by('code')->limit($batch, $start)->get();
            //echo "\n".$query->num_rows()." : ";
            $result     = FALSE;
            if($query->num_rows() > 0){
                $result = $query->result();
                foreach ($result as $data){ 
                    $unique_code   = trim($data->code);
                }
            }
            else
                break;
            $start = $start + $batch; sleep(1); die;
        }
    }
    
    public function import_products($products = array()){
        array_shift($products);
        foreach ($products as $product){            
            if(!empty($product[0]) && !empty($product[1])){
                $product_code   = $product[1];
                $sku            = clean(substr(trim($product[0]), 0, 200).'-'.$product_code);
                $exist          = $this->db->select('id')->from('products')->where('code', $product_code)->get();
                $product_id     = NULL;
                
                if($exist->num_rows() > 0){
                    $product_id = $exist->row()->id;
                }
                $price = clean_price($product[3]);
                
                $item       = array(
                    'short_name'        => trim($product[0]),
                    'long_name'         => trim($product[0]),
                    'short_description' => trim($product[8]),
                    'long_description'  => trim($product[8]),
                    'model'             => '',
                    'weight'            => trim($product[4]),
                    'price'             => $price
                );
                
                if(empty($product_id)){
                    $item['sku']            = $sku; 
                    $item['code']           = $product_code; 
                    $item['status']         = 1;
                    $item['sync']           = 1;
                    $item['date']           = Date('Y-m-d');
                    $item['last_modified']  = Date('Y-m-d');
                    $item['page_title']     = $product[0];  
                    $item['envelop_type'] = 2;
                    $item['inventory']    = 2;
                    
                    $item['stock_min']      = 0;
                    $item['stock']          = $product[2];//<= 0 ? 0 : $soh;// change made to insert stock (-ve/+ve) values on Insert.
                    
                    $this->db->insert('products', $item);
                    $product_id = $this->db->insert_id();
                }
                else{
                    $item['stock']          = $product[2];
                    $this->db->where('id', $product_id);
                    $this->db->update('products', $item); 
                }
                //echo $this->db->last_query()."<br/><br/>";
                $this->pos_categories($product_id, $product[11], $product[9], $product[10]);
            }
        }
        return 'Products uploaded successfully.';
    }
    
    public function update_products(){ 
        $product_ids   = array();
        $micomp        = $this->load->database('micomp', TRUE); //;->where('lstUpdate >=', Date('Y-m-d', strtotime('-2 days')))
        $query         = $micomp->select('*')->from('m1stockt2')/*->where("code", 'BLK2616')*/->group_by('code')/*->limit($batch, $start)*/->get();
        $result        = FALSE;
        $exist_cats    = array(); 
        if($query->num_rows() > 0){
            $result = $query->result();  
            foreach ($result as $data){ 
                
                if(isset($data->extra1) && $data->extra1 == "false")
                    continue;
                
                
                if(empty(trim($data->descr)))
                    continue;
                $unique_code    = trim($data->code);                   
                $soh            = trim($data->soh);
                if(empty($unique_code))
                    continue;
                $sku_parts      = explode('|', $unique_code);
                $product_code   = isset($sku_parts[0]) ? trim($sku_parts[0]) : "";
                if(empty($product_code))
                    continue;
                $attribute_options = array_slice($sku_parts, 1);                    
                $sku               = clean(substr(trim($data->descr), 0, 200).'-'.$product_code);
                $exist  = $this->db->select('id')->from('products')->where('code', $product_code)->get();     
                $id     = NULL;
                if($exist->num_rows() > 0){
                    $re = $exist->row();
                    $id = $re->id;
                }
                $this->db->trans_start();
                $item       = array(
                    'short_name'        => trim($data->descr),
                    'long_name'         => trim($data->descr),
                    'short_description' => trim($data->descr2),
                    'long_description'  => trim($data->descr2),
                    'model'             => trim($product_code),
                    'weight'            => trim($data->weight),
                );

                if( isset($data->sp1) && $data->sp1 > 0)
                    $item['price']          = $data->sp1;

                if (empty($id)){
                    $item['sku']            = $sku; 
                    $item['code']           = $product_code; 
                    $item['status']         = 1;
                    $item['sync']           = 1;
                    $item['date']           = Date('Y-m-d');
                    $item['last_modified']  = Date('Y-m-d');
                    $item['page_title']     = trim($data->descr);                        
                    if(is_array($attribute_options) && count($attribute_options) > 0){
                        $item['envelop_type'] = 3;
                        $item['inventory']    = 3;
                    }
                    else{
                        $item['envelop_type'] = 2;
                        $item['inventory']    = 2;
                    }
                    $item['stock_min']      = 0;
                    $item['stock']          = $soh;//<= 0 ? 0 : $soh;// change made to insert stock (-ve/+ve) values on Insert.
                    
                    $this->db->insert('products', $item);
                    $id = $this->db->insert_id();
                    if(!empty($id) && $id>0){

                        if(is_array($attribute_options) && count($attribute_options) > 0){
                            $images = array(
                                'product_id'    => $id,
                                'image'         => str_replace('|', '', $unique_code).'.jpg',
                                //'featured'      => 1
                            );
                            $this->db->insert('images', $images); 
                            $this->manage_attributes($id, $product_code, $unique_code,  $attribute_options, $soh);
                        }
                        $images = array(
                            'product_id'    => $id,
                            'image'         => $product_code.'.jpg',
                            //'featured'      => 1
                        );
                        $this->db->insert('images', $images);
                        
                        $level_1    = $this->config->item('micomp_menu_level1');
                        $level_2    = $this->config->item('micomp_menu_level2');
                        $level_3    = $this->config->item('micomp_menu_level3');
                        $this->pos_categories($id, $data->$level_1, $data->$level_2, $data->$level_3);
                    }
                }
                else{                  
                    $this->db->where('id', $id);
                    // change to update stock inventory on update
                    if(is_array($attribute_options) && count($attribute_options) > 0){
                    
                    	$item['envelop_type'] = 3;
                    	$item['inventory']    = 3;
                    }
                    else{
                    	$item['envelop_type'] = 2;
                    	$item['inventory']    = 2;
                    	$item['stock']        = $soh;// change made to insert stock (-ve/+ve) values on update
                    }
                    $this->db->update('products', $item); 
                    if(is_array($attribute_options) && count($attribute_options) > 0){ 
                        
                        $image_name = str_replace('|', '', $unique_code);
                        $this->db->where(array('image' => $image_name.'.jpg', 'product_id' => $id));
                        $im_name = $this->db->get('images');
                        if($im_name->num_rows() == 0){
                            $images = array(
                                'product_id'    => $id,
                                'image'         => $image_name.'.jpg',
                                //'featured'      => 1
                            );
                            $this->db->insert('images', $images); 
                        }
                        $this->manage_attributes($id, $product_code, $unique_code,  $attribute_options, $soh);
                    } 
                    $level_1 = $this->config->item('micomp_menu_level1');
                    $level_2 = $this->config->item('micomp_menu_level2');
                    $level_3 = $this->config->item('micomp_menu_level3');
                    $this->pos_categories($id, $data->$level_1, $data->$level_2, $data->$level_3);
                }
                $exist_cats[] = $data->$level_1;
                $exist_cats[] = $data->$level_2; 
                $exist_cats[] = $data->$level_3;
                
                $this->db->trans_complete(); 
                $product_ids[] = $id;
            }
            unset($result);
        }
        
        //$this->db->where_not_in('name', $exist_cats);
        //$this->db->delete('categories');
        
        
        if(count($product_ids) > 0){
            $this->db->where('sync', 1);
            $this->db->where_not_in('id', $product_ids);
            $this->db->delete('products');
        }
    }
    
    public function manage_attributes($id, $product_code, $unique_code,  $attribute_options, $soh){
        $attribute_ids = $attribute__option_ids = array();        
        foreach ($attribute_options as $key => $new_attribute){
            if($key > 4)
                break;
            if(empty($new_attribute))
                continue;
            
            $this->db->where('index', $product_code.'-'.($key+1));
            $query = $this->db->get('attributes');
            if($query->num_rows() > 0){
                $attribute              = $query->row();
                $attribute_id           = $attribute->id;
                if(!empty($new_attribute)){
                    $this->db->where("name", $new_attribute);
                    $this->db->where('attribute_id', $attribute_id);
                    $query              = $this->db->get('attribute_options');
                    if($query->num_rows() == 0){
                        $this->db->insert('attribute_options', array('sort' => ($key+1), 'attribute_id' => $attribute_id, 'name' => $new_attribute));
                        $attribute_option_id = $this->db->insert_id();
                    }
                    else{
                        $attribute_option_id = $query->row()->id;
                    }
                }
            }
            else{
                $this->db->insert('attributes', array('index' => $product_code.'-'.($key+1), 'type' => 'size', 'name' => 'Option '.($key+1), 'system_name' => trim($data->descr)." ".'Option '.($key+1), 'date' => Date('Y-m-d') ));
                $attribute_id = $this->db->insert_id();  
                if(!empty($new_attribute)){
                    $this->db->insert('attribute_options', array('sort' => ($key+1), 'attribute_id' => $attribute_id, 'name' => $new_attribute)); 
                    $attribute_option_id = $this->db->insert_id();
                }
            }
            $attribute_ids[]         = $attribute_id; 
            $attribute__option_ids[] = $attribute_option_id; 
        }
        $this->db->where('name', $product_code);
        $query = $this->db->get('attribute_groups');
        if($query->num_rows() > 0){
            $attribute_group_id = $query->row()->id;
        }
        else{
            $this->db->insert('attribute_groups', array('name' => $product_code, 'date' => Date('Y-m-d')));
            $attribute_group_id = $this->db->insert_id();
        }
        //remove attribute option groups
        if(count($attribute_ids) > 0){
            $this->db->where('group_id', $attribute_group_id);
            $this->db->where_not_in('attribute_id', $attribute_ids);
            $this->db->delete('attribute_option_groups');
        }
        foreach ($attribute_ids as $attribute_id){
            $this->db->where('attribute_id', $attribute_id);
            $this->db->where('group_id', $attribute_group_id);
            $query = $this->db->get('attribute_option_groups');
            if($query->num_rows() == 0){
                $this->db->insert('attribute_option_groups', array('attribute_id' => $attribute_id, 'group_id' => $attribute_group_id));
            }
        }
        $this->db->where('product_id', $id);
        $this->db->where('group_id', $attribute_group_id);
        $query = $this->db->get('product_attributes');        
        if($query->num_rows() == 0){
            $this->db->insert('product_attributes', array('product_id' => $id, 'group_id' => $attribute_group_id));
        }
        //Stock handling
        $this->db->where(array('product_id' => $id, 'group_id' => $attribute_group_id, 'sku' => trim($unique_code)));
        $query = $this->db->get('stock_price_attributes');
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
            $this->db->where('id', $stock_id);
            $this->db->update('stock_price_attributes', $stock_data); 
        }
        else{
            $this->db->insert('stock_price_attributes', $stock_data);
        }
        unset($attribute_ids);
        return true;
    }

    public function existing_options($product_id){
        $sql = 'SELECT *, p.id as paid,pa.id as aid, spa.id as spaid FROM `products` p JOIN product_attributes pa ON pa.product_id = p.id JOIN stock_price_attributes spa ON spa.product_id = p.id  WHERE p.id ='.$product_id;
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            $results = $query->result();
            return $results;
        }
        return FALSE;
    }
    
    public function create_categories(){ 
        $micomp = $this->load->database('micomp', TRUE);
        $query  = $micomp->select('*')->from('m1departments')->get();
        $result = FALSE;
        if($query->num_rows() > 0){
            $result = $query->result();
            foreach ($result as $key => $category){
                if(empty($category->Descr) || $category->Descr == "NA")
                    continue;    
                $category_text  = trim($category->Descr);
                $query          = $this->db->select('name')->from('categories')->where('name', $category_text)->get();                 
                $data = array('name' => $category_text);
                if($query->num_rows() > 0){  
                }
                else{
                    $data['code']   = uniqid("-CAT-");
                    $this->db->insert('categories', $data);
                } 
            }
        }  
    }
    
    public function remove_deleted(){
        $micomp = $this->load->database('micomp', TRUE);
        $micomp->distinct();
        $query  = $micomp->select('code')->from('m1stockt2')->where("code != ", "")->get();
        $result = FALSE;
        if($query->num_rows() > 0){
            $result       = $query->result();
            $delete_items = array();
            foreach ($result as $product_code){
               if(empty($product_code))
                   continue;
               $delete_items[] = $product_code->code; 
            }
            if(count($delete_items) > 0){
                $this->db->where('sync', 1);
                $this->db->where_not_in("code", $delete_items);
                $this->db->delete('products');
            }
        }
        else{
        }
    }
    
    public function check_to_add_parents($product_id, $parent_id){
        $cat_code = $this->db->select('id, parent_id')->from('categories')->where('id', $parent_id)->get();
        if($cat_code->num_rows() == 1){
            $cat_id_ = $cat_code->row();
            $query = $this->db->select('id')->from('product_categories')->where('product_id', $product_id)->where('category_id', $cat_id_->id)->get();
            if($query->num_rows() == 0 && $cat_id_->id != 0){
                $categories = array(
                        'product_id'  => $product_id,
                        'category_id' => $cat_id_->id
                    );
                $this->db->insert('product_categories', $categories);
            }
            $query = $this->db->select('id')->from('product_categories')->where('product_id', $product_id)->where('category_id', $cat_id_->parent_id)->get();
            if($query->num_rows() == 0 && $cat_id_->parent_id != 0){
                $categories = array(
                            'product_id'  => $product_id,
                            'category_id' => $cat_id_->parent_id
                        );

                $this->db->insert('product_categories', $categories);
            }
        }
    }    
    
    public function check_exist($table,$column, $value){
        $query = $this->db->select("*")->from($table)->where($column, $value)->get();
        return $query->row() ? $query->row()->id : FALSE;
    }
    
    public function create_cat($category_name, $parent_id, $code = ''){
        $code = empty($code) ? uniqid("-CAT-") : $code;
        $insert = array('name' => $category_name, 'parent_id' => $parent_id, 'code' => $code);
        $this->db->insert('categories', $insert);
        return $this->db->insert_id();
    }
    
    public function check_exist_pcats($par_id, $cat_id){
        $query = $this->db->select("*")->from('product_categories')->where( array('product_id'=>$par_id, "category_id" => $cat_id) )->get();
        return $query->row() ? $query->row()->id : FALSE;
    }

    public function category_manipulation($product_id, $top='', $middle='', $low=''){
        if(!empty($top) && $top != 'NA'){
            $item1 = $this->check_exist('categories', 'name', $top); 
            if( $item1 === FALSE){
                $item1 = $this->create_cat($top, 0);
            }
            if(is_numeric($item1)){
                if(!$this->check_exist_pcats($product_id, $item1)){
                    $categories = array(
                                'product_id'  => $product_id,
                                'category_id' => $item1
                            );

                    $this->db->insert('product_categories', $categories);
                }
            }
        }
        
        if(!empty($middle) && $middle != 'NA' && isset($item1)){
            $item2 = $this->check_exist('categories', 'name', $middle);
            if( $item2 === FALSE){   
                $item2 = $this->create_cat($middle, $item1);
            }
            if(is_numeric($item2)){
                if(!$this->check_exist_pcats($product_id, $item2)){
                    $categories = array(
                                'product_id'  => $product_id,
                                'category_id' => $item2
                            );
                    $this->db->insert('product_categories', $categories);
                }   
            }
        }
        
        if(!empty($low) && $low != 'NA' && isset($item2)){
            $item3 = $this->check_exist('categories', 'name', $low);
            if( $item3 === FALSE){
                $item3 = $this->create_cat($low, $item2);
            }
            if(is_numeric($item3)){
                if(!$this->check_exist_pcats($product_id, $item3)){
                    $categories = array(
                                'product_id'  => $product_id,
                                'category_id' => $item3
                            );
                    $this->db->insert('product_categories', $categories);
                }
            }
        }
    }
    
    
    public function pos_categories($product_id, $level1, $level2, $level3){ 
        if( empty($level1) || $level1 == 'NA')
            return;
        
        $level1 = trim($level1);
        $level2 = trim($level2);
        $level3 = trim($level3);
        
        
        $query = $this->db->select('id')->from('categories')->where(array('name' => trim($level1), "parent_id" => 0))->get();
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
        $query = $this->db->select('id')->from('categories')->where(array('name'=> $level2, 'parent_id' => $level1_id) )->get();
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
        $query = $this->db->select('id')->from('categories')->where(array('name'=> $level3, "parent_id" => $level2_id))->get();
        if($query->num_rows() > 0){
            $level3s   = $query->row();
            $level3_id = $level3s->id;
        }
        else{
            $level3_id = $this->create_missing_cats($level3, $level2_id);
        }
        $this->create_cat_association($product_id, $level3_id);
        /**PARENT**/
        
        //$this->db->where('product_id', $product_id);
        //$this->db->where_not_in('category_id', array($level1_id, $level2_id, $level3_id));
        //$this->db->delete('product_categories');
        
       // echo $this->db->last_query();
    }
    
    public function create_missing_cats($cat_name, $parent=0){ 
        
        if($parent == 0)
            $insert = array('code' => uniqid('-code-'), 'parent_id' => $parent, 'name' => $cat_name, 'display_name' => $cat_name, 'active' => 1);
        else
            $insert = array('code' => uniqid('-code-'), 'parent_id' => $parent, 'name' => $cat_name, 'display_name' => $cat_name, 'active' => 1, 'in_menu' => 1); 
                
        $result = $this->db->insert('categories', $insert);
        //echo $this->db->last_query();

        if($result)
            return $this->db->insert_id();
        return FALSE;
    }
    
    public function create_cat_association($product_id, $category_id){
        $query = $this->db->select('id')->from('product_categories')->where(array('product_id' => $product_id, 'category_id' => $category_id))->get();
        if($query->num_rows() > 0)
            return;
        
        return $this->db->insert('product_categories', array('product_id' => $product_id, 'category_id' => $category_id ));
    }
    
    
    public function get_products_download(){
        $query = "SELECT p.*, GROUP_CONCAT(c.name SEPARATOR '||') as c_name FROM `products` p JOIN product_categories pc ON pc.product_id = p.id JOIN categories c ON c.id = pc.category_id WHERE 1 GROUP BY p.id";
        
        $query = $this->db->query($query);
        
        
        if($query->num_rows()){
            $products = $query->result();
            return $products;
        }
        return FALSE;
    }
    
}
    
