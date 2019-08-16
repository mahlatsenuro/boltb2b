<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_Model extends CI_Model
{
    
    
    /**
     * @method get_home_productss - get all products with basic attributes for the home page
     * @param none $name Description
     * @return array with products and attributes or false if nothing!
     * called from products/index
     */
    
    public function get_home_products($existing_images = array()){ 
        if( $this->config->item('products_without_image') && 'no' == strtolower($this->config->item('products_without_image'))){
            $query_string = 'SELECT ps.id, ps.code, ps.strike_price, ps.strike_status, ps.inventory, ps.stock, ps.stock_min, short_name, long_description, model, sku, price  from products ps JOIN product_categories pc ON pc.product_id = ps.id JOIN categories c ON c.id = pc.category_id JOIN images im on (im.product_id = ps.id)  AND (image in ('.  implode(",", $existing_images).')) WHERE status = 1 AND c.active = 1 and c.in_menu = 1 AND ps.featured = 1';
        }
        else{
            $query_string = 'SELECT ps.id, ps.code, ps.strike_price, ps.strike_status, short_name, ps.inventory, ps.stock, ps.stock_min, model, long_description, sku, price  from products ps JOIN product_categories pc ON pc.product_id = ps.id JOIN categories c ON c.id = pc.category_id  WHERE status = 1 AND c.active = 1  AND ps.featured = 1 AND c.in_menu = 1';
        }
        $query      =   'SELECT p.inventory, p.strike_price, p.strike_status, p.long_description, p.stock, p.stock_min, p.id as pid, p.`short_name` as pname, p.`model` as pmodel, p.`sku` as psku, 
                        p.price as pprice, p.code, i.image FROM ( '.$query_string.' ) AS p LEFT JOIN images as i ON (i.product_id = p.id) 
                        ORDER BY p.id DESC';
        
        
        $query      =   $this->db->query($query); 
        $products   =   $product_list = array();
        if ($query->num_rows() > 0){          
            foreach ($query->result() as $product){ 
                $products[$product->pid]['name']  = $product->pname;
                $products[$product->pid]['id']    = $product->pid;
                $products[$product->pid]['sku']   = $product->psku;
                $products[$product->pid]['price'] = $product->pprice;
                $products[$product->pid]['model'] = empty($product->pmodel) ? $product->code : $product->pmodel;
                $products[$product->pid]['desc']  = $product->long_description;
                $products[$product->pid]['strike_price']  = $product->strike_price;
                $products[$product->pid]['strike_status'] = $product->strike_status;
                $products[$product->pid]['image'][] = (is_null($product->image) || empty($product->image)) ? 'no_image.jpg' : $product->image;
                if($product->inventory == 3){   
                    $product_list[] = $product->pid;
                    $products[$product->pid]['stock'] = 'out_stock';
                }
                else if ($product->inventory == 2) {
                    $products[$product->pid]['stock'] = ($product->stock > $product->stock_min) ? 'in_stock' : 'out_stock';                  
                }
                else{
                    $products[$product->pid]['stock'] = 'in_stock';
                }
            }
            if(count($product_list) > 0){
                $this->db->where_in('product_id', $product_list);
                $query = $this->db->get('stock_price_attributes');
                if($query->num_rows() > 0){
                    $stock_list = $query->result();
                    foreach($stock_list as $stocks){
                        if($stocks->quantity > $stocks->min_quantity){
                            $products[$stocks->product_id]['stock'] = 'in_stock';
                        }
                    }
                }
            } 
            return $products;
        }
        return FALSE;    
    }
    
    public function check_mail($email){
        $query = $this->db->where('email', $email)->get('users');
        if($query->num_rows() > 0){
            return $query->row()->id;
        }
        return FALSE;
    }

    public function create_guest($email){
        $this->db->insert('users', array('email' => $email));
        return $this->db->insert_id();
    }
    
    public function add_comment($user_id){
        $product_id = $this->input->post('id');
        $comment    = $this->input->post('comment');
        
        $this->db->insert('comments', array('product_id' => $product_id, 'user_id' => $user_id, 'comment' => $comment));
        return $this->db->insert_id();
        
    }
    
    public function get_comments(){
        $product_id = $this->input->post('product_id');
        
        $query = $this->db->select("c.id, c.comment, c.date, u.first_name, u.last_name")->from("comments c")->join("users u", "u.id = c.user_id")->where("c.product_id", $product_id)->order_by('date', 'desc')->limit(20)->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
        
    }

    public function get_price_groups($id=0){
        $query = $this->db->query('SELECT g.id, g.name, pu.product_id, pu.price FROM `groups` g LEFT JOIN product_usergroups pu ON g.id=pu.group_id and pu.product_id = '.$id.' WHERE g.id NOT IN(1, 2)');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }

    public function discount_data($product_id){
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('product_discounts');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function update_bulk_pricing($product_id){
        
        $froms    = $this->input->post('from');
        $tos      = $this->input->post('to');
        $types    = $this->input->post('type');
        $discount = $this->input->post('discount');        
        
        foreach ($froms as $key => $from){
            if(empty($from))
                continue;
            
            if($key < 0 || $key > 3)
                continue;
            
            $to    = isset($tos[$key])      && !empty($tos[$key])      ? $tos[$key]      : "";
            $type  = isset($types[$key])    && !empty($types[$key])    ? $types[$key]    : "";
            $dis   = isset($discount[$key]) && !empty($discount[$key]) ? $discount[$key] : "";
            
            if(empty($to) || empty($type) || empty($dis))
                continue;
            
            $discount_items = $this->discount_data($product_id);                
            
            if($discount_items && isset($discount_items[$key]) && isset($discount_items[$key]->id)){
                $this->db->where('id', $discount_items[$key]->id);
                $this->db->update('product_discounts', array('quantity_from' => $from, 'quantity_to' => $to, 'type' => $type, 'discount' => $dis));
            }
            else{
                $this->db->insert('product_discounts', array('product_id' => $product_id, 'quantity_from' => $from, 'quantity_to' => $to, 'type' => $type, 'discount' => $dis));
            }
        }
        return;
    }

    public function get_all_whish_products($user_id){
        $parameter = $search = array();
        $query     ='SELECT p.id as pid, p.stock, p.stock_min, p.inventory, p.`short_name` as pname, p.`model` as pmodel, p.`sku` as psku, p.price as pprice, i.image FROM products AS p JOIN whishlist w ON w.product_id = p.id INNER JOIN images as i ON (i.product_id = p.id) AND (i.featured = 1 )  WHERE w.user_id = '.$user_id;
        $query  .= ' ORDER BY p.id DESC ';
        $query  =   $this->db->query($query, $parameter); 
        $products = array();
        $product_list   = array();
        if ($query->num_rows() > 0){          
            foreach ($query->result() as $product){ 
                $products[$product->pid]['name']  = $product->pname;
                $products[$product->pid]['sku']   = $product->psku;
                $products[$product->pid]['price'] = $product->pprice;
                $products[$product->pid]['model'] = $product->pmodel;
                $products[$product->pid]['image'] = (is_null($product->image) || empty($product->image)) ? 'no_image.jpg' : $product->image;
                if($product->inventory == 3){   
                    $product_list[] = $product->pid;
                    $products[$product->pid]['stock'] = 'out_stock';
                }
                else if ($product->inventory == 2) {
                    $products[$product->pid]['stock'] = ($product->stock > $product->stock_min) ? 'in_stock' : 'out_stock';                  
                }
                else{
                    $products[$product->pid]['stock'] = 'in_stock';
                }
            }
            if(count($product_list) > 0){
                $this->db->where_in('product_id', $product_list);
                $query = $this->db->get('stock_price_attributes');
                if($query->num_rows() > 0){
                    $stock_list = $query->result();
                    foreach($stock_list as $stocks){
                        if($stocks->quantity > $stocks->min_quantity){
                            $products[$stocks->product_id]['stock'] = 'in_stock';
                        }
                    }
                }
            } 
            return $products;
        }
        return FALSE; 
    }
    
     /**
     * @method get_all_products - get all products with basic attributes for the home page
     * @param none $name Description
     * @return array with products and attributes or false if nothing!
     * called from products/all
     */
    
    public function get_all_products($page = 0, $value = '', $by = '', $existing_images = array()){ 
        $parameter = $search = array();
        
        if( $this->config->item('products_without_image') && 'no' == strtolower($this->config->item('products_without_image'))){
            $query_string = 'JOIN images as i ON (i.product_id = p.id) AND (i.featured = 1 ) AND i.image in ('.  implode(',', $existing_images).')';
        }
        else {
            $query_string = 'LEFT JOIN images as i ON (i.product_id = p.id) AND (i.featured = 1 )';
        }
        $query     ='SELECT p.id as pid, p.stock, p.stock_min, p.inventory, p.`short_name` as pname, p.`model` as pmodel, p.`sku` as psku, pc.category_id as catid,
                    p.price as pprice, i.image 
                    FROM products AS p '.$query_string.' LEFT JOIN product_categories as pc ON pc.product_id = p.id JOIN categories c ON c.id = pc.category_id 
                    ';
        if ( $by == 'search' && !empty($value)){
            $search[]       = ' p.short_name LIKE  ? ';
            $parameter[]    = '%'.$value.'%';
        }
        if ( $by == 'category' && !empty($value)){
            $search[]       = ' pc.category_id = ? ';
            $parameter[]    = $value;
        }
        
        
        $search[]           = ' p.status = ? ';
        $parameter[]        = 1;
        if(count($search) > 0){
            $query .= ' WHERE '.implode(' AND ', $search).' AND c.in_menu=1';
        }
        else
            $query .= ' WHERE c.id NOT IN(SELECT `parent_id` FROM `categories`)';
        $query          .= ' ORDER BY p.id DESC ';
        $query          =   $this->db->query($query, $parameter); 
        $products       = array();
        $product_list   = array();
        if ($query->num_rows() > 0){          
            foreach ($query->result() as $product){ 
                $products[$product->pid]['name']  = $product->pname;
                $products[$product->pid]['sku']   = $product->psku;
                $products[$product->pid]['price'] = $product->pprice;
                $products[$product->pid]['model'] = $product->pmodel;
                $products[$product->pid]['image'] = (is_null($product->image) || empty($product->image)) ? 'no_image.jpg' : $product->image;
                if($product->inventory == 3){   
                    $product_list[] = $product->pid;
                    $products[$product->pid]['stock'] = 'out_stock';
                }
                else if ($product->inventory == 2) {
                    $products[$product->pid]['stock'] = ($product->stock > $product->stock_min) ? 'in_stock' : 'out_stock';                  
                }
                else{
                    $products[$product->pid]['stock'] = 'in_stock';
                }
            }
            if(count($product_list) > 0){
                $this->db->where_in('product_id', $product_list);
                $query = $this->db->get('stock_price_attributes');
                if($query->num_rows() > 0){
                    $stock_list = $query->result();
                    foreach($stock_list as $stocks){
                        if($stocks->quantity > $stocks->min_quantity){
                            $products[$stocks->product_id]['stock'] = 'in_stock';
                        }
                    }
                }
            } 
            return $products;
        }
        return FALSE;      
    }
    
    
    public function get_all_products_search($page = 0, $value = '', $by = '', $existing_images = array()){ 
        if( $this->config->item('products_without_image') && 'no' == strtolower($this->config->item('products_without_image'))){
            $query_string = 'INNER JOIN images im on (im.product_id = ps.id) AND (im.featured = 1) AND (image in ('.  implode(",", $existing_images).'))';
        }
        else{
            $query_string = 'LEFT JOIN images im on (im.product_id = ps.id) AND (im.featured = 1)';
        }
        $price_from = $this->input->post("price_from");
        $price_to   = $this->input->post("price_to");
        $parameter  = $search = array();
        $query_part = 'SELECT DISTINCT ps.id, short_name, ps.inventory, ps.stock, ps.stock_min, model, sku, price  from products ps '.$query_string.' INNER JOIN product_categories as pc on ps.id = pc.product_id JOIN categories c ON c.id = pc.category_id';
        $search[]       = ' ps.status =  ? ';
        $parameter[]    = 1;
        
        if($price_from !== NULL){
            $search[]       = ' ps.price >= ?';
            $parameter[]    = $price_from;
        }
        if($price_to !== NULL){
            $search[]       = ' ps.price <= ?';
            $parameter[]    = $price_to;
        }
        if ( $by == 'search' && !empty($value)){
            $search[]       = ' ps.short_name LIKE  ? OR ps.code LIKE ? OR ps.model = ?';
            $parameter[]    = '%'.$value.'%';
            $parameter[]    = '%'.$value.'%';
            $parameter[]    = '%'.$value.'%';
        }
        if ( $by == 'category' && !empty($value)){
            $search[]       = ' pc.category_id = ? ';
            $parameter[]    = $value;
        }
        
        
        if(count($search) > 0){
            $query_part .= ' WHERE '.implode(' AND ', $search).' AND c.in_menu=1';
        }
        else
            $query_part .= ' WHERE c.id NOT IN(SELECT `parent_id` FROM `categories`)';
        $query_part .= ' LIMIT '.$page.', 15 ';
            
        $query     ='SELECT p.id as pid, p.inventory, p.stock, p.stock_min, p.`short_name` as pname, p.`model` as pmodel, p.`sku` as psku, 
                    p.price as pprice, i.image 
                    FROM ( '.$query_part.' ) AS p LEFT JOIN images as i ON (i.product_id = p.id) AND (i.featured = 1 )';
        
        $search = array();
        if(count($search) > 0){
            $query      .= ' WHERE '.implode(' AND ', $search);
        }
        $query          .= ' ORDER BY p.short_name ASC ';
        $query          =   $this->db->query($query, $parameter); 

        //echo $this->db->last_query();

        $products       = array();
        $product_list   = array();
        if ($query->num_rows() > 0){          
            foreach ($query->result() as $product){ 
                $products[$product->pid]['id']    = $product->pid;
                $products[$product->pid]['name']  = $product->pname;
                $products[$product->pid]['sku']   = $product->psku;
                $products[$product->pid]['price'] = $product->pprice;
                $products[$product->pid]['model'] = $product->pmodel;
                $products[$product->pid]['image'] = (is_null($product->image) || empty($product->image)) ? 'no_image.jpg' : $product->image;
                if($product->inventory == 3){   
                    $product_list[] = $product->pid;
                    $products[$product->pid]['stock'] = 'out_stock';
                }
                else if ($product->inventory == 2) {
                    $products[$product->pid]['stock'] = ($product->stock > $product->stock_min) ? 'in_stock' : 'out_stock';                  
                }
                else{
                    $products[$product->pid]['stock'] = 'in_stock';
                }
            }
            if(count($product_list) > 0){
                $this->db->where_in('product_id', $product_list);
                $query = $this->db->get('stock_price_attributes');
                if($query->num_rows() > 0){
                    $stock_list = $query->result();
                    foreach($stock_list as $stocks){
                        if($stocks->quantity > $stocks->min_quantity){
                            $products[$stocks->product_id]['stock'] = 'in_stock';
                        }
                    }
                }
            } 
            return $products;
        }
        return FALSE; 
    }
    
    
    public function count_products($value = '', $by = '', $existing_images = array()){
        if( $this->config->item('products_without_image') && 'no' == strtolower($this->config->item('products_without_image'))){
            $query_string = 'JOIN images im on (im.product_id = ps.id) AND (im.featured = 1) AND (image in ('.  implode(",", $existing_images).'))';
        }
        else{
            $query_string = 'LEFT JOIN images im on (im.product_id = ps.id) AND (im.featured = 1)';
        }
        $price_from = $this->input->post("price_from");
        $price_to   = $this->input->post("price_to");
        $parameter  = $search = array();
        $query_part = 'SELECT ps.id, short_name, model, sku, price  from products ps '.$query_string.' JOIN product_categories as pc on ps.id = pc.product_id JOIN categories c ON c.id = pc.category_id';
        
        $search[]       = ' ps.status =  ? ';
        $parameter[]    = 1;
        if ( $by == 'search' && !empty($value)){
            $search[]       = ' ps.short_name LIKE  ? OR ps.code LIKE ? OR ps.model = ?';
            $parameter[]    = '%'.$value.'%';
            $parameter[]    = '%'.$value.'%';
            $parameter[]    = '%'.$value.'%';
        
        }
        if ( $by == 'category' && !empty($value)){
            $search[]       = ' pc.category_id = ? ';
            $parameter[]    = $value;
        }
        if($price_from !== NULL){
            $search[]       = ' ps.price >= ?';
            $parameter[]    = $price_from;
        }
        if($price_to !== NULL){ 
            $search[]       = ' ps.price <= ?';
            $parameter[]    = $price_to;
        }
        if(count($search) > 0){
            $query_part .= ' WHERE '.implode(' AND ', $search). ' AND c.in_menu=1';
        }
        else
            $query_part .= 'WHERE c.id NOT IN(SELECT `parent_id` FROM `categories`)';
        $query     ='SELECT count(Distinct p.id) as total
                    FROM ( '.$query_part.' ) AS p LEFT JOIN images as i ON (i.product_id = p.id) AND (i.featured = 1 )';
        
        $search = array();
        if(count($search) > 0){
            $query .= ' WHERE '.implode(' AND ', $search);
        }
        $query  .= ' ORDER BY p.id DESC ';
        $query  = $this->db->query($query, $parameter);
        $result = $query->row();
        return $result->total;
    }
    
    public function price_check_products()
    {
        $query    = 'SELECT p.`long_name`, p.id, p.`short_name`, p.`model`, p.`short_description`, p.`long_description`, p.`sku`, p.`price`, i.`image`, c.name as cname, m.name as mname FROM `products` as p LEFT JOIN images as i ON ( i.`product_id` = p.id AND i.`featured` = 1) LEFT JOIN product_manufacurer as pm ON pm.`product_id` = p.id LEFT JOIN manufacturer as m ON m.`id` = pm.manufacturer_id LEFT JOIN product_categories as pc ON pc.product_id = p.id JOIN categories as c ON c.id = pc.category_id WHERE `status` = 1 ';
   
        $query    =   $this->db->query($query); 
        
        $products = array();
        if ($query->num_rows() > 0)
        {
            $cats = array();
            foreach ( $query->result() as $key => $product)
            {
                $products[$product->id]['name']       = $product->short_name;
                $products[$product->id]['offer']      = $product->long_name;
                $products[$product->id]['l_description']= $product->long_description;
                $products[$product->id]['s_description']= $product->short_description;
                $products[$product->id]['model']      = $product->model;
                $products[$product->id]['sku']        = $product->sku;
                $products[$product->id]['image']      = $product->image;
                $products[$product->id]['price']      = $product->price;
                $products[$product->id]['manu']       = $product->mname;
                
                if(!in_array($product->cname, $cats)){
                    
                    $cats[] = $product->cname;
                    $products[$product->id]['category'][] = $product->cname;
                }
            }
            $products[$product->id]['category'] = array_unique($products[$product->id]['category']);
        }
        return $products;
    }
    
    
    /**
     * @method select_single get details for details page
     * @param string $sku unique identifier
     * @return array details of products
     */
    
    public function select_single($sku){
        $query_string   =  'SELECT *, p.strike_price, p.code, p.strike_status, i.id as imid, i.image as imname, p.id as pid, p.page_title, p.meta_keys, p.meta_description, c.id as catid, c.name as catname, ao.id as aoid, a.id as aid, a.name as aname, ao.name as aoname FROM `products` p LEFT JOIN images i ON i.product_id = p.id LEFT JOIN product_categories pc ON pc.product_id = p.id LEFT JOIN categories c ON c.id = pc.category_id LEFT JOIN `product_attributes` pa ON pa.product_id = p.id  LEFT JOIN `attribute_option_groups` aog ON aog.`group_id` = pa.group_id LEFT JOIN `attributes` a ON a.`id` = aog.attribute_id LEFT JOIN `attribute_options` ao ON ao.`attribute_id` = a.id WHERE p.sku = ? ORDER BY aog.sort, ao.sort asc';
        $query          =   $this->db->query($query_string, array($sku)); 
        $offer          = 0;
        $products       = $categories = $image = $colour = $size = $others = $option1 = $ratings = array();
        
        if ($query->num_rows() > 0){
            foreach ( $query->result() as $key => $product){
                $products['name']         = $product->long_name;
                $products['model']        = empty($product->model) ? $product->code : $product->model;
                $products['sku']          = $product->sku;
                $products['price']        = $product->price;
                $products['description']  = $product->long_description;
                $products['meta_keys']    = $product->meta_keys;
                $products['meta_description']  = $product->meta_description;
                $products['page_title']   = $product->page_title;
                $products['strike_price']    = $product->strike_price;
                $products['strike_status']   = $product->strike_status;
                $products['id']           = $product->pid;
                $products['images'][$product->imid]                                    = $product->imname;   
                $products['categories'][$product->catid]                               = $product->catname;   
                $products['attributes'][$product->aid][$product->aoid]['aid']          = $product->aid;
                $products['attributes'][$product->aid][$product->aoid]['aname']        = $product->aname;
                $products['attributes'][$product->aid][$product->aoid]['option']       = $product->aoname;
                $products['attributes'][$product->aid][$product->aoid]['option_id']    = $product->aoid; 
                $products['attributes'][$product->aid]['aname']                        = $product->aname;
            } 
            return $products;
        }
        return FALSE;
    }
    
    /**
     * Add to whishlist
     */
    public function whishlist()
    {
        $product_id  = $this->input->post('id');
        $user_id     = $this->ion_auth->get_user_id();   
        
        $this->db->where("product_id", $product_id)->where('user_id', $user_id);
        $exist = $this->db->count_all_results('whishlist');
        
        if($exist > 0)
            return TRUE;
        
        return $this->db->insert('whishlist', array('user_id' => $user_id, 'product_id' => $product_id));
    }
    /**
     * 
     * @return boolean FALSE if nothing sound
     * @return array all products in descending order of id
     * Called from admin/index
     */
    
    public function get_products($name = '', $by = ''){     
        $this->db->select("p.id, p.strike_price, p.strike_status, p.short_name, p.weight, p.width, p.height, p.length, p.model, p.envelop_type, p.status, p.date, p.sku, p.page_title, p.meta_keys, p.meta_description, p.price, p.long_name, p.long_description, p.featured, p.inventory, p.stock, p.stock_min");     
        if (!empty($name)){
            $this->db->where( $by, $name);
        }    
        $query = $this->db->order_by("p.id", "desc")->limit(10)->get('products as p'); 
        if ( $query->num_rows() > 0 ){
            if (empty($name)){     
                return $query->result(); 
            }
            return $query->row();
        }
        return FALSE;   
    }
    
    public function update_inventory($id){
        $inventory = $this->input->post('inventory');
        $stock     = $this->input->post('stock');
        $min_stock = $this->input->post('stock_min');
        
        $data               = array();
        $data['inventory']  = $inventory;
        $data['stock']      = $stock;
        $data['stock_min']  = $min_stock;
        
        $this->db->where('id', $id);
        $this->db->update('products', $data); 
        return $id;
    }

        /**
     * @method type new_create(type $paramName) create new product
     * @return id   of created product else false
     * $param id optional
     */
    
    public function new_create(){
        $short_name = $this->input->post('shortname');
        $data       = array(
                    
            'short_name'        => $short_name 
        );
        $sku            = strtolower(preg_replace('/\s+/', '_', $short_name).'-'.uniqid('prd-poscom-'));
        $data['sku']    = clean($sku);
        $data['status'] = 0;
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }
    
    /**
     * @method type create_news(type $paramName) create new product
     * @return id   of created product else false
     * $param id optional
     */
    
    public function create_new(){
        $short_name = $this->input->post('shortname');
        $long_name  = $this->input->post('longname');
        $model      = $this->input->post('model');
        $describe   = $this->input->post('description');
        $price      = $this->input->post('price');
        $featured   = $this->input->post('featured');
        $id         = $this->input->post('id');
        $width      = $this->input->post('width');
        $hight      = $this->input->post('height');
        $length     = $this->input->post('length');
        $weight     = $this->input->post('weight');
        $envelop    = $this->input->post('envelop');
        $status     = $this->input->post('status');
        $sku        = $this->input->post('sku');
        
        $sku        = preg_replace("/[^A-Za-z0-9_-]/", "", $sku);
        
        $strike_price      = $this->input->post('strike_price');
        $strike_status     = $this->input->post('strike_status');
        $page_title = $this->input->post('page_title');
        $meta_keys  = $this->input->post('meta_keywords');
        $meta_description = $this->input->post('meta_description');
        $product_url = $this->input->post('product_url');
        
        $data       = array(
                    
            'short_name'        => $short_name,
            'long_name'         => $long_name,
            'model'             => $model,
            'long_description'  => $describe,
            'featured'          => $featured,
            'price'             => $price,
            'weight'            => $weight,
            'width'             => $width,
            'height'            => $hight,
            'length'            => $length,
            'envelop_type'      => $envelop,
            'status'            => (isset($status) && $status == 1) ? 1 : 0,
            'page_title'        => $page_title,
            'meta_keys'         => $meta_keys,
            'meta_description'  => $meta_description,
            'strike_price'      => $strike_price,
            'strike_status'     => $strike_status,
        );
        $product_url            = clean($product_url);
        //if(!empty($product_url)){
            $this->db->where('sku', $sku);
            $this->db->where('id <>', $id);
            
            $exist_check = $this->db->get('products');
            if($exist_check->num_rows() == 0){
               $data['sku'] = $sku; 
            }
        //}
        if (empty($id)){
            //$sku            = strtolower(preg_replace('/\s+/', '_', $short_name).'-'.uniqid('prd-poscom-'));
            //$data['sku']    = $sku;
            $data['status'] = 0;
            
            $this->db->insert('products', $data);
            $product_id = $this->db->insert_id();
        }
        else{
            $this->db->where('id', $id);
            $update = $this->db->update('products', $data); 
            
            $product_id = $id;
            
            
        }
        if(isset($product_id))
            return $product_id;
        return FALSE;
    }
    
    
    /**
     * @method get_categoriess - get all categories available
     * @param int $id category id conditional
     * @return array with categories 
     * called from admin/products and main products controller
     */
    
    public function get_categories($id = '', $by = ''){
        $parent = $second = array();
        $query = $this->db->select('id')->from('categories')->where('parent_id', 0)->get();
        if($query->num_rows() > 0){
            $parents = $query->result();
            foreach ($parents as $par){
                $parent[] = $par->id;
            }
            
            if(count($parent) > 0){
                
                $this->db->where_in('parent_id', $parent);
                $subs = $this->db->get('categories');
                
                if($subs->num_rows() > 0){
                    $sub_cats = $subs->result();
                    foreach ($sub_cats as $subcats){
                        $second[] = $sub_cats->id;
                    }
                }
                
                if(count($parent) > 0 || count($second) > 0){
                    if(count($parent) > 0)
                    $this->db->or_where_in('parent_id', $parent);
                    if(count($second) > 0)
                    $this->db->or_where_in('parent_id', $second);
                    $this->db->update('categories', array('in_menu' => 1));
                }
                
            }
        }
        
        
        if( $this->config->item('products_without_image') && 'no' == strtolower($this->config->item('products_without_image')))
        {
            $images          = glob(IMAGE_URL_PATH."*.{jpg,png,gif,JPG,PNG,GIF}", GLOB_BRACE);
            $existing_images = array();
            foreach ($images as $image)
                $existing_images[] = "'".basename ($image)."'";
            
            $query_string = "INNER JOIN images im on (im.product_id = pc.product_id) AND (im.featured = 1) AND (image in (".  implode(",", $existing_images)."))";
        }
        else 
        {
            $query_string = 'LEFT JOIN images im on (im.product_id = pc.product_id) AND (im.featured = 1)';
        }
        
        
                
        //$old_query = "SELECT DISTINCT name, id, sort, in_menu FROM (SELECT c.id, name, in_menu, CASE WHEN parent_id = 0 THEN c.id ELSE parent_id END AS sort FROM categories c LEFT JOIN product_categories pc ON pc.category_id = c.id /*OR parent_id = 0*/ INNER JOIN images im on (im.product_id = pc.product_id) AND (im.featured = 1) AND (image in (".  implode(",", $existing_images)."))  WHERE c.active = 1 ORDER BY sort, c.id) t ORDER BY in_menu desc";

        $query = "SELECT DISTINCT id, display_name as name, sort, sorting, in_menu FROM (SELECT c.id, c.sort as sorting, display_name, in_menu, CASE WHEN parent_id = 0 THEN c.id ELSE parent_id END AS sort FROM categories c LEFT JOIN product_categories pc ON pc.category_id = c.id  ".$query_string." WHERE c.active = 1 ORDER BY sorting asc) t ORDER BY sorting asc";
        
        if (empty($id))
        {
            $query = $this->db->query( $query, array() );
            if ($query->num_rows() > 0)
            {
                return $query->result();
            }
        }
        else
        {
            $query .= ' WHERE c.'.$by.' = ?';
            $query = $this->db->query( $query, array($id) );
            return $query->row();
        }
        return FALSE;
    }
    
    function all_page_cats(){
        if( $this->config->item('products_without_image') && 'no' == strtolower($this->config->item('products_without_image')))
        {
            $images          = glob(IMAGE_URL_PATH."*.{jpg,png,gif,JPG,PNG,GIF}", GLOB_BRACE);
            $existing_images = array();
            foreach ($images as $image)
                $existing_images[] = "'".basename ($image)."'";
            
            $query_string = "INNER JOIN images im on (im.product_id = pc.product_id) AND (im.featured = 1) AND (image in (".  implode(",", $existing_images)."))";
        }
        else 
        {
            $query_string = 'LEFT JOIN images im on (im.product_id = pc.product_id) AND (im.featured = 1)';
        }
        
        
                
        //$old_query = "SELECT DISTINCT name, id, sort, in_menu FROM (SELECT c.id, name, in_menu, CASE WHEN parent_id = 0 THEN c.id ELSE parent_id END AS sort FROM categories c LEFT JOIN product_categories pc ON pc.category_id = c.id /*OR parent_id = 0*/ INNER JOIN images im on (im.product_id = pc.product_id) AND (im.featured = 1) AND (image in (".  implode(",", $existing_images)."))  WHERE c.active = 1 ORDER BY sort, c.id) t ORDER BY in_menu desc";

        $query = "SELECT DISTINCT name, id, sort, in_menu FROM (SELECT c.id, c.sort as sorting, display_name as name, in_menu, CASE WHEN parent_id = 0 THEN c.id ELSE parent_id END AS sort FROM categories c LEFT JOIN product_categories pc ON pc.category_id = c.id  ".$query_string." WHERE c.active = 1 ORDER BY name asc) t ORDER BY name asc";
        
        if (empty($id))
        {
            $query = $this->db->query( $query, array() );
            if ($query->num_rows() > 0)
            {
                return $query->result();
            }
        }
        else
        {
            $query .= ' WHERE c.'.$by.' = ?';
            $query = $this->db->query( $query, array($id) );
            return $query->row();
        }
        return FALSE;
    }
    
    /**
     * @method get_categoriess - get all categories available
     * @param int $id category id conditional
     * @return array with categories 
     * called from admin/products and main products controller
     */
    
    public function get_manus($id = '', $by = ''){
        
        $query = "SELECT id, name FROM manufacturer";
        
        if (empty($id))
        {
            $query = $this->db->query( $query, array() );
            if ($query->num_rows() > 0)
            {
                return $query->result();
            }
        }
        else
        {
            $query .= ' WHERE '.$by.' = ?';
            $query = $this->db->query( $query, array($id) );
            return $query->row();
        }
        return FALSE;
    }
    
     /**
     * @param type $productid product id to which manufacturer must be added
     * @method type add_manusa(type $paramName) to add manufacturer with a product
     * return product id
     * called from admin/manufacture
     */
    
    public function add_manus($product_id)
    {
        $result = $this->db->select('id')->from('product_manufacurer')->where('product_id', $product_id)->get();
    
        $manu = $this->input->post('manu');   
        
        $insert                    = array();
        $insert['product_id']      = $product_id;
        $insert['manufacturer_id'] = $manu;
        
        if ($result->num_rows() == 0)
        {
            return $this->db->insert('product_manufacurer', $insert);
        }
        else{
            $this->db->where('product_id', $product_id);
            return $this->db->update('product_manufacurer', $insert);
        }
    }
    
    
    /**
     * @param type $productid product id to which category must be added
     * @method type add_categorys(type $paramName) to add category with a product
     * return product id
     * called from admin/add_category
     */
    
    public function add_category($product_id)
    {
        $result = $this->remove_category($product_id);
    
        if ($result)
        {
            $insert = array();
            $categories = $this->input->post('cats');     
            if (is_array($categories) && count($categories) > 0)
            {
                $categories = array_unique($categories);
                
                foreach ($categories as $cats)
                {
                    $temp                = array();
                    $temp['product_id']  = $product_id;
                    $temp['category_id'] = $cats;
                
                    $insert[]            = $temp;
                }
                
                $this->db->insert_batch('product_categories', $insert);
                return TRUE;
            }
        }
        return FALSE;
    }
   
    
    public function remove_products($product_id)
    {
        return $this->db->delete('products', array('id' => $product_id)); 
    }

        /**
     * @method type remove_categorys(type $paramName) remove categories
     * @param int $param_id product id to remove categories
     * return true on success false on failure
     */
    
    public function remove_category($product_id)
    {
        return $this->db->delete('product_categories', array('product_id' => $product_id)); 
    }

    /**
     * @method type get_product_catss(type $paramName) to get all categories related with product
     * @param int $product_id product id
     * @return array with attributes
     */
    public function get_product_cats($product_id)
    {
        $query  = 'SELECT p.short_name, c.category_id FROM products as p LEFT JOIN `product_categories` as c ON p.id = c.product_id WHERE p.id = ?';
        $query  = $this->db->query($query, array($product_id));
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }

    /**
     * @method type get_product_manus(type $paramName) to get all categories related with product
     * @param int $product_id product id
     * @return array with manufactures
     */
    public function get_product_manus($product_id)
    {
        $query  = 'SELECT p.short_name, m.manufacturer_id FROM products as p LEFT JOIN `product_manufacurer` as m ON p.id = m.product_id WHERE p.id = ?';
        $query  = $this->db->query($query, array($product_id));
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }    
    /**
     * @method type products_imagess(type $paramName) to get all images for a product
     * @param int $product_id product id
     * @return array array of products and images
     * called from admin/products
     */
 
    
    public function set_featured_image(){
        $sql  = 'select DISTINCT product_id from images where product_id not in(select product_id from images WHERE `featured` = 1)';
        
        $query = $this->db->query($sql); 
        if($query->num_rows() > 0){
            $data =  $query->result();
            foreach($data as $image){
                $product_id = $image->product_id;
                $this->db->query('UPDATE images SET featured = 1 WHERE product_id = '.$product_id.' limit 1');
            }
        }
    }




    public function products_images($product_id)
    {
        $query  = 'SELECT p.short_name, p.sku, i.id as image_id, i.image, i.featured as image_featured, i.date as image_date '
                . 'FROM products as p LEFT JOIN `images` as i ON p.id = i.product_id WHERE p.id = ? ORDER BY i.featured DESC';
        
        $query  = $this->db->query($query, array($product_id));
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }
    
    /**
     * @param type $productid product id to which category must be added
     * @method type add_imagess(type $paramName) to add images with a product
     * return product id
     * called from admin/add_category
     */
    
    public function add_images($product_id, $images = '')
    {  
        $return = FALSE;
        $insert = array();
        
        $insert_ids = array_keys($images);
        $update_ids = $remove_images = array();     
        $query = $this->db->select('id, image')->from('images')->where('product_id', $product_id)->where_in('id', $insert_ids)->get();

        // To set either insert or update based on the existence of image id.
        if ($query->num_rows() > 0)
        {
            $product_images = $query->num_rows();
            foreach ($query->result() as $update)
            {
                if ( array_key_exists($update->id, $images) ) 
                {      
                    $index                       = count($update_ids);
                    //Images already exists.                
                    $update_ids[$index]          = array( 'id' => $update->id, 'image' => $images[$update->id] );
                    //Image already exists and going to be updated. So remove existing image
                    $remove_images[]             = $update->image;
                    //Image id exists. So remove it from insert ids
                    unset($images[$update->id]);
                }
            }
        }
        else
        {
            $query = $this->db->select('id, image')->from('images')->where('product_id', $product_id)->get();
            $product_images = $query->num_rows();
        }
        //Check any image already set for product or not
        $query = $this->db->select('id')->from('images')->where('product_id', $product_id)->get();
        
        //If insert ids not empty, insert them               
        if (is_array($images) && count($images) > 0)
        {
            foreach ($images as $key => $img)
            {
                $temp                = array();
                $temp['product_id']  = $product_id;
                $temp['image']       = $img;
                $temp['featured']    = ( (count($insert) == 0) && ($product_images == 0) ) ? 1 : 0;   
                $insert[]            = $temp;
            }
            $this->db->insert_batch('images', $insert);
            $return = TRUE;
        }
        //If update ids not empty, update images
        if(count($update_ids) > 0)
        { 
            $this->db->update_batch('images', $update_ids, 'id'); 
            $return = TRUE;
        }      
        //Delete uploaded images if they are replaced with new images
        if ($return == TRUE && count($remove_images) > 0)
        {
            foreach ($remove_images as $img)
            {                
                //Remove replaced images.
                if (file_exists(IMAGE_PATH.SP.$img)) { 
                    unlink(IMAGE_PATH.$img);
                }   
                if (file_exists(IMAGE_PATH.'thumb'.SP.$img)) {
                    unlink(IMAGE_PATH.'thumb'.SP.$img);
                } 
            }    
        }
        
        return $return;
    }
    
    
    public function add_image_attributes($product_id){ 
        $attributes         = $this->input->post('attribute');
        $removed_images     = array();
        
        $query = $this->db->query("SELECT i.id, ai.id attribute_image_id FROM `attribute_images` ai RIGHT JOIN images i on i.id = ai.image_id WHERE i.product_id = $product_id");
        
        if($query->num_rows() > 0){
            $result = $query->result();
            
            $insert = array();
            
            foreach ($result as $key => $image){
                
                if(isset($attributes[$image->id]) && is_numeric($attributes[$image->id])){ 
                    
                    $update_temp                 = array();
                    $update_temp['image_id']     = $image->id;
                    $update_temp['attribute_id'] = $attributes[$image->id];
                    $update_temp['product_id']   = $product_id;
                       
                    if(isset($image->attribute_image_id) && is_numeric($image->attribute_image_id)){
                        $this->db->where('image_id', $image->id);
                        $this->db->update('attribute_images', $update_temp);
                    }
                    else{
                        $this->db->insert('attribute_images', $update_temp);
                    }
                }
            } 
        }
    }
    
    
    /**
     * @method product_images to get all product images based on sku
     * @param array $sku array of skus
     * called from products/my_cart
     */
    
    public function product_images($sku)
    {
        $query = $this->db->select('p.model, p.sku, i.image')->from('products as p')->join('images as i', 'i.product_id = p.id')->where_in('sku', $sku)->where('i.featured', 1)->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }

        /**
     * @method type remove_product_images(type $paramName) to remove image from images table
     * @param int $product_id products id
     * @param int $image_id image id to remove
     * @return boolean True on success else false
     */
    
    public function remove_product_image($product_id, $image_id)
    {
        $query = $this->db->select('id, image')->from('images')->where('product_id', $product_id)->where('id', $image_id)->where('featured', 0)->get();
        $exist = $query->row();       
        
        if ($exist && count($exist))
        {
            $delete = $this->db->delete('images', array('id' => $image_id, 'product_id' => $product_id));
            
            if ($delete)
            {
                if (file_exists(IMAGE_PATH.$exist->image)) {
                    unlink(IMAGE_PATH.$exist->image);
                }   
                                
                if (file_exists(IMAGE_PATH.'thumb'.SP.$exist->image)) { 
                    unlink(IMAGE_PATH.'thumb'.SP.$exist->image);
                }    
                
                
            }
            return $delete;
        }
        return FALSE;
    }
    
    /**
     * @method get_product_by_idd to get products bu product id
     * @param int $product_id Description
     * @return array of product details
     * called from admin_products/attributes 
     */
    public function get_product_by_id($product_id)
    {
        return $row = $this->db->get_where('products', array('id' => $product_id))->row();
    }

    /**
     * @method type get_attributess(type $paramName) select all categories
     * @param
     * @return array with all available attributes,  admin_products/edit_attr
     */
    
    public function get_attributes()
    {
        $query = $this->db->select('id as at_id, name as at_name')->from('attributes')->where('type', '')->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }
    
    /**
     * @method type get_product_attributess(type $paramName) get all product related attributes
     * @param int $product_id product id to select attributes
     * @return array return all attributes related with a product
     * Called form admin_products/attributes
     */
    
    public function get_product_attributes($product_id)
    {
        $query = "SELECT p.`short_name`, type, p.`sku`, a.id as at_id, a.name as at_name,pa.id as paid,  pa.`value`, pa.`show_frontend`, pa.`hex` FROM `products` as p RIGHT JOIN product_attributes as pa ON pa.`product_id` = p.id LEFT JOIN attributes as a ON a.id = pa.`attribute_id` WHERE p.id = ?";//" AND a.type !='system'";
        
        $query  = $this->db->query($query, array($product_id));     
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }
    
    /**
     * @method get_product_attributes_by_paids to get product attribute based on product attribute id
     * @param 1 $product_id Description
     * @param 2 $at_id id of the attribute
     * called from admin_products/edit_attr
     */
    public function get_product_attributes_by_paid($product_id, $attr_id)
    {
        $query = 'SELECT pa.`id` as paid, pa.`product_id`, a.id as at_id, pa.`attribute_id`, pa.`value`, a.name as aname, p.short_name, pa.sort FROM `product_attributes` as pa INNER JOIN attributes as a ON a.id = pa.`attribute_id` INNER JOIN products as p ON p.id = pa.product_id WHERE  pa.id = ? AND pa.product_id = ? ';
        $query = $this->db->query($query, array($attr_id, $product_id));
                
        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        return FALSE;
        
    }
    
    /**
     * @method get_product_stocks_by_paids to get product attribute based on product attribute id
     * @param 1 $product_id Description
     * @param 2 $at_id id of the attribute
     * called from admin_products/edit_attr
     */
    public function get_product_stocks_by_paid($product_id, $stock_id)
    {
        $query = 'SELECT p.`short_name`, p.id as pid, p.sku, spa.id as spaid, spa.`attribute_id1`, spa.`attribute_id2`, spa.`attribute_id3`, spa.`attribute_id4`, spa.`attribute_id5`, spa.`quantity`, spa.`price_variation`  FROM `products` as p JOIN stock_price_attributes as spa ON spa.product_id = p.id  WHERE p.id = ? AND spa.id = ?';
        $query = $this->db->query($query, array($product_id, $stock_id));
                
        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        return FALSE;
        
    }    
    
    /**
     * @method update_attributess to update product attribute value
     * @param type $product_id
     * @param type $pa_id
     * called from admin_products/edit_attr
     */

    public function update_attributes($product_id, $pa_id)
    {
        $attribute = $this->input->post('attribute');
        $value     = $this->input->post('value');
        $sort      = $this->input->post('sort');

        $this->db->where('id', $pa_id);
        $this->db->where('product_id', $product_id);

        $data      = array('attribute_id' => $attribute, 'value' => $value, 'sort' => $sort);

        return $this->db->update('product_attributes', $data);
    }

    /**
     * @method update_attributess to update product attribute value
     * @param type $product_id
     * @param type $pa_id
     * called from admin_products/edit_attr
     */

    public function update_stocks($product_id, $stock_id)
    {
        $attribute_1 = $this->input->post('attribute1');
        $attribute_2 = $this->input->post('attribute2');
        $attribute_3 = $this->input->post('attribute3');
        $attribute_4 = $this->input->post('attribute4');
        $attribute_5 = $this->input->post('attribute5');

        $price       = $this->input->post('price_variation');
        $stocks      = $this->input->post('total_stock');
        
    
        $temp                   = array();
        $temp['attribute_id1']  = $attribute_1;
        $temp['attribute_id2']  = is_numeric($attribute_2) ? $attribute_2 : NULL;
        $temp['attribute_id3']  = is_numeric($attribute_3) ? $attribute_3 : NULL;
        $temp['attribute_id4']  = is_numeric($attribute_4) ? $attribute_4 : NULL;
        $temp['attribute_id5']  = is_numeric($attribute_5) ? $attribute_5 : NULL;

        $temp['price_variation']= is_numeric($price) ? $price : 0;
        $temp['quantity']       = is_numeric($stocks) ? $stocks : 0;

        $this->db->where('product_id', $product_id);
        $this->db->where('id', $stock_id);
        return $this->db->update('stock_price_attributes', $temp);


    }    
    /**
     *@method type remove_attributesa(type $paramName) remove attributes for a product
     * @param id $product_id products id
     * @return type Description 
     */
    
    public function remove_attributes($condition)
    {
        return $this->db->delete('product_attributes', $condition); 
    }

    /**
     * 
     */
    
    public function create_attributes($product_id)
    {
        $attributes = $this->input->post('attribute');
        $values     = $this->input->post('value');
        $sort       = $this->input->post('sort');
        
        $insert     = array( 'product_id' => $product_id, 'attribute_id' => $attributes, 'value' => $values, 'sort' => $sort); 
        return $this->db->insert('product_attributes', $insert);
        
    }    
    
            
    /**
     * @method type price_stock_attributess(type $paramName) to return all stock price details for a product
     * @param int $product_id Description
     * @return array array of product details
     * called from admin_product/stocks
     * 
     */      
    public function price_stock_attributes($product_id)
    {
        $query = 'SELECT p.`short_name`, p.id as pid, p.sku, spa.id as spaid, spa.`attribute_id1`, spa.`attribute_id2`, spa.`attribute_id3`, spa.`attribute_id4`, spa.`attribute_id5`, spa.`quantity`, spa.`price_variation`  FROM `products` as p JOIN stock_price_attributes as spa ON spa.product_id = p.id  WHERE p.id = ?';
    
        $query = $this->db->query( $query, array($product_id));
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }

    public function remove_stock_price_products($condition)
    {
        return $this->db->delete('stock_price_attributes', $condition);
    }


    /**
     * @method type create_stock_prices(type $paramName) to create new stock price set
     * @param int $product_id
     * @return true Description  
     */

    public function create_stock_price($product_id)
    {

        $attribute_1 = $this->input->post('attribute1');
        $attribute_2 = $this->input->post('attribute2');
        $attribute_3 = $this->input->post('attribute3');
        $attribute_4 = $this->input->post('attribute4');
        $attribute_5 = $this->input->post('attribute5');

        $price       = $this->input->post('price_variation');
        $stocks      = $this->input->post('total_stock');
        
    
        $temp                   = array();
        $temp['product_id']     = $product_id;
        $temp['attribute_id1']  = $attribute_1;
        $temp['attribute_id2']  = is_numeric($attribute_2) ? $attribute_2 : NULL;
        $temp['attribute_id3']  = is_numeric($attribute_3) ? $attribute_3 : NULL;
        $temp['attribute_id4']  = is_numeric($attribute_4) ? $attribute_4 : NULL;
        $temp['attribute_id5']  = is_numeric($attribute_5) ? $attribute_5 : NULL;

        $temp['price_variation']= is_numeric($price) ? $price : 0;
        $temp['quantity']       = is_numeric($stocks) ? $stocks : 0;


        return $this->db->insert('stock_price_attributes', $temp);

    }
    
    /**
     * @method type get_system_attributess(type $paramName) get system attributes only
     * @param int $product_id Description
     * @return array all system attributes
     */
    
    public function get_system_attributes($product_id)
    {
        $query = 'SELECT p.`short_name`,pa.value, a.name FROM `products` as p LEFT JOIN product_attributes as pa ON pa.product_id = p.id LEFT JOIN attributes as a ON a.id = pa.attribute_id WHERE a.type = ? AND p.id = ?';
        $query = $this->db->query($query, array('system', $product_id));
                
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }
    
    /**
     * @method remove_offerss
     * @param int $product_id product_id
     * @return bool Description
     */
    public function remove_offers($product_id)
    {
        $query = 'DELETE FROM product_attributes  WHERE  attribute_id IN  ( SELECT id FROM attributes WHERE attributes.index IN ( "offer", "new", "offer_value", "offer_from", "offer_to", "new_from", "new_to") ) AND product_attributes.product_id = ?';
        return $this->db->query($query, array($product_id));
        
    } 

    /**
     * @method type create_offerss(type $paramName) to create offer
     * @param int $product_id product id
     * @return bool Description
     */
    
    public function create_offers($product_id)
    {
        $offer          = $this->input->post('offer');
        $new            = $this->input->post('new');
        //$status         = $this->input->post('status');
        $offer_value    = $this->input->post('offer_value');
        $offer_from     = $this->input->post('offer_from');
        $offer_to       = $this->input->post('offer_to');
        
        $new_from       = $this->input->post('new_from');
        $new_to         = $this->input->post('new_to');
        
        $this->db->trans_strict(FALSE);
        $this->db->trans_start();
        
        //Update product visibility
        //$this->db->where('id', $product_id);
        //$success = $this->db->update('products', array('status' => $status ? 1 : 0)); 
        
        $this->remove_offers($product_id);
        
        $query = 'SELECT id, `index`, `name` FROM `attributes` WHERE `type` = "system"';
        
        $query = $this->db->query($query, array($product_id));
        if ($query->num_rows() > 0)
        {
            $insert = array();
            foreach ($query->result() as $key => $attr)
            {
                $temp = array();
                
                if($offer)
                {
                    if ('offer' == $attr->index)
                    {
                        $temp['product_id']   = $product_id;
                        $temp['attribute_id'] = $attr->id;
                        $temp['value']        = 1;  
                    }   
                    if ('offer_value' == $attr->index)
                    {
                        $temp['product_id']   = $product_id;
                        $temp['attribute_id'] = $attr->id;
                        $temp['value']        = $offer_value;  
                    }
                    if ('offer_from' == $attr->index)
                    {
                        $temp['product_id']   = $product_id;
                        $temp['attribute_id'] = $attr->id;
                        $temp['value']        = $offer_from;  
                    }
                    if ('offer_to' == $attr->index)
                    {
                        $temp['product_id']   = $product_id;
                        $temp['attribute_id'] = $attr->id;
                        $temp['value']        = $offer_to;  
                    }

                }
                else
                {
                    if ('offer' == $attr->index)
                    {
                        $temp['product_id']   = $product_id;
                        $temp['attribute_id'] = $attr->id;
                        $temp['value']        = 0;  
                    }
                }
                if ($new)
                {
                    if ('new' == $attr->index)
                    {
                        $temp['product_id']   = $product_id;
                        $temp['attribute_id'] = $attr->id;
                        $temp['value']        = 1;  
                    }
                    if ('new_from' == $attr->index)
                    {
                        $temp['product_id']   = $product_id;
                        $temp['attribute_id'] = $attr->id;
                        $temp['value']        = $new_from;  
                    }
                    if ('new_to' == $attr->index)
                    {
                        $temp['product_id']   = $product_id;
                        $temp['attribute_id'] = $attr->id;
                        $temp['value']        = $new_to;  
                    }
                }
                else
                {
                    if ('new' == $attr->index)
                    {
                        $temp['product_id']   = $product_id;
                        $temp['attribute_id'] = $attr->id;
                        $temp['value']        = 0;  
                    }
                }
                
                if (count($temp) > 0)
                    $insert[] = $temp;
            }
            
            if (count($insert) > 0)
            {
                $this->db->insert_batch('product_attributes', $insert); 
            }
            
            $this->db->trans_complete(); 
        
            if ($this->db->trans_status() === FALSE)
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    /**
     * @method type select_system_attributes(type $paramName) Description
     * @param int $product id
     * @return array with product attribute details
     */
    
    public function select_offer_attributes($prodict_id)
    {
        $query = 'SELECT pa.`value`, a.name, a.index, a.id FROM `product_attributes` as pa JOIN attributes as a ON a.id = pa.attribute_id WHERE a.type = "system" AND pa.product_id = ?';
        
        $query = $this->db->query($query, array($prodict_id));
        if ($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function select_products_attributes($product_id){
        
        $aoids = array();
        
        $this->input->post('option1') !== NULL ? $aoids[] = $this->input->post('option1') : '';
        $this->input->post('option2') !== NULL ? $aoids[] = $this->input->post('option2') : '';
        $this->input->post('option3') !== NULL ? $aoids[] = $this->input->post('option3') : '';
        $this->input->post('option4') !== NULL ? $aoids[] = $this->input->post('option4') : '';
        $this->input->post('option5') !== NULL ? $aoids[] = $this->input->post('option5') : '';
        
        $query_part = '';
        if(count($aoids) > 0){
            $query_part = 'AND ao.id IN ('.  implode(',', $aoids).')';
        }
        
        $query_string   =  'SELECT *, p.id as pid, ao.id as aoid, a.id as aid, a.name as aname, ao.name as aoname FROM `products` p LEFT JOIN `product_attributes` pa ON pa.product_id = p.id  LEFT JOIN `attribute_option_groups` aog ON aog.`group_id` = pa.group_id LEFT JOIN `attributes` a ON a.`id` = aog.attribute_id LEFT JOIN `attribute_options` ao ON ao.`attribute_id` = a.id WHERE p.id = ? '.$query_part.' ORDER BY aog.sort, ao.sort asc';
        $query          =   $this->db->query($query_string, array($product_id)); 
        $products       =   $colour = $size = $others = $option1 = $ratings = array();
        
        if ($query->num_rows() > 0){
            foreach ( $query->result() as $key => $product){
                $products['name']         = $product->long_name;
                $products['model']        = empty($product->model) ? $product->code : $product->model;
                $products['sku']          = $product->sku;
                $products['envelop']      = $product->envelop_type;
                $products['length']       = $product->length;
                $products['weight']       = $product->weight;
                $products['height']       = $product->height;
                $products['width']        = $product->width;
                $products['price']        = $product->price;
                $products['description']  = $product->long_description;
                $products['id']           = $product->pid;
                $products['attributes'][$product->aoid]['aid']          = $product->aid;
                $products['attributes'][$product->aoid]['aname']        = $product->aname;
                $products['attributes'][$product->aoid]['option']       = $product->aoname;
                $products['attributes'][$product->aoid]['option_id']    = $product->aoid; 
                $products['attributes']['aname']                        = $product->aname;
            } 
            return $products;
        }
        return FALSE;
    }
    
    
    /**
     * @method type check_stocks(type $paramName) to check stock available for a product with selected attributes
     * @param 
     * @return booldean either true or false
     * @called from products/add_cart
     */
    
    public function check_stock(){
        $query_parts    = $params = $options = array();
        $product_id     = $this->input->post('id');
        $quantity       = $this->input->post('quantity') && is_numeric($this->input->post('quantity')) ? $this->input->post('quantity') : 0;
        
        
        
        $this->db->where('id', $product_id);
        $query = $this->db->get('products');
        if($query->num_rows() > 0){ 
            
            $product = $query->row();
            
            $this->input->post('option1') != NULL ? $this->db->where('attribute_id1', $this->input->post('option1')) : $this->db->where('attribute_id1 IS NULL', null, FALSE);
            $this->input->post('option2') != NULL ? $this->db->where('attribute_id2', $this->input->post('option2')) : $this->db->where('attribute_id2 IS NULL', null, FALSE);
            $this->input->post('option3') != NULL ? $this->db->where('attribute_id3', $this->input->post('option3')) : $this->db->where('attribute_id3 IS NULL', null, FALSE);
            $this->input->post('option4') != NULL ? $this->db->where('attribute_id4', $this->input->post('option4')) : $this->db->where('attribute_id4 IS NULL', null, FALSE);
            $this->input->post('option5') != NULL ? $this->db->where('attribute_id5', $this->input->post('option5')) : $this->db->where('attribute_id5 IS NULL', null, FALSE);
            
            $this->db->where('group_id != ', 0);
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('stock_price_attributes'); 
                
            if($product->inventory == 3){ 
                if($query->num_rows() > 0){
                    $stock_data = $query->row();
                    $price_variation  = $stock_data->price_variation;
                    $stock_product_id = $stock_data->sku;
                    return (($stock_data->quantity - $quantity) >= $stock_data->min_quantity) ? array('status' => TRUE, 'stock_id' => $stock_data->id, 'price_variation' => $price_variation) : array('status' => FALSE);
                }
                return array('status' => FALSE);
            }
            else if ($product->inventory == 2) { 
                $price_variation = $stock_product_id = 0;
                if($query->num_rows() > 0){
                    $stock_data = $query->row();
                    $price_variation = $stock_data->price_variation;
                    $stock_product_id = $stock_data->sku;
                }
                return (($product->stock) > $product->stock_min) ? array('status' => TRUE, 'price_variation' => $price_variation) : array('status' => FALSE);
            }
            else{
                $price_variation = $stock_product_id = 0;
                if($query->num_rows() > 0){ 
                    $stock_data = $query->row();
                    $price_variation = $stock_data->price_variation;
                    $stock_product_id = $stock_data->sku;
                }
                return array('status' => TRUE, 'price_variation' => $price_variation, 'stock_product_id' => $stock_product_id);
            }   
        }
        return array('status' => FALSE);
    }
    
    public function category_select()
    {
        $query = $this->db->query('SELECT id, name, parent_id FROM categories ORDER BY parent_id, name');
        
         $category = array(
            'categories' => array(),
            'parent_cats' => array()
        );
         
        $result = $query->result_array(); 
        
        foreach($result as $row)
        {
            $category['categories'][$row['id']]    = $row;
            $category['parent_cats'][$row['parent_id']][] = $row['id'];
        }
        
        return $category;
    }
    
    public function get_name_attrvs($attr_ids){
        $query = $this->db->select('pa.value, a.name')->from('product_attributes pa')->join('attributes a', 'a.id = pa.attribute_id')->where_in('pa.id', $attr_ids)->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }

    public function get_product_before_cart($product_id)
    {
        $query = 'SELECT p.long_name, p.weight, p.height, p.width, p.envelop_type, p.length, p.`price`, p.`sku`, a.index, a.name, pa.value  as pavalue, pa.id as paid FROM `products` as p LEFT JOIN `product_attributes` as pa ON p.id = pa.`product_id` LEFT JOIN attributes as a ON a.id = pa.`attribute_id` WHERE p.id = ?';
        $query = $this->db->query($query, array($product_id)); 
                
        if ($query->num_rows() > 0){
            foreach ( $query->result() as $key => $product)
            {
                if( 0 == $key )
                {
                    $products['name']         = $product->long_name;
                    $products['sku']          = $product->sku;
                    $products['price']        = $product->price;
                    
                    $products['weight']       = $product->weight;
                    $products['height']       = $product->height;
                    $products['width']        = $product->width;
                    $products['length']       = $product->length;
                    $products['envelop']      = $product->envelop_type;
                    
                    $products['size']         = '';
                    $products['colour']       = '';
                }
                
                if ($product->index == 'option1')
                {
                    if( ( null !== $this->input->post('option1')) && ($product->paid == $this->input->post('option1')) )
                        $products['option1'] = $product->pavalue;
                }
                if ($product->index == 'option2')
                {
                    if( ( null !== $this->input->post('option2')) && ($product->paid == $this->input->post('option2')) )
                        $products['option2'] = $product->pavalue;
                }
                if ($product->index == 'option3')
                {
                    if( ( null !== $this->input->post('option3')) && ($product->paid == $this->input->post('option3')) )
                        $products['option3'] = $product->pavalue;
                }
                
                
                if ($product->index == "offer" )
                { 
                    $offer =  $product->pavalue;                              
                }
                if ($product->index == "offer_from" && !empty($product->pavalue))
                { 
                    $from = (time() >= strtotime($product->pavalue));                                
                }
                if ($product->index == "offer_to" && !empty($product->pavalue))
                {
                    $to   = (time() <=  strtotime($product->pavalue));                                      
                }
                if ($product->index == "offer_value" && !empty($product->pavalue))
                {
                    $offer_value   = $product->pavalue;                                     
                }
                if (isset($to) && isset($from) && isset($offer) && ($offer == 1) && $to && $from && isset($offer_value)){ 
                    $products['price']  = price_calc($product->price, $offer_value);
                }
                
            }    
            return $products;
        }
        return FALSE;
    }
    
    public function deactivate($product_id)
    {
        $this->db->where('id', $product_id);
        return $this->db->update('products', array('status' => 0));
    }
    
    public function activate($product_id)
    {
        $this->db->where('id', $product_id);
        return $this->db->update('products', array('status' => 1));
    }
    
    public function get_option_groups(){
        $query = $this->db->get('attribute_groups');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function get_grouped_attributes($group_id){
        $query = $this->db->select('a.id, a.name')->from('attributes a')->join('attribute_option_groups ao', 'ao.attribute_id = a.id')->where('group_id', $group_id)->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return array();
    }
    
    public function update_product_option_group($product_id){
        $this->db->where('product_id', $product_id);
        $query    = $this->db->get('product_attributes');
        $group_id = $this->input->post('attribute_group');
        if($query->num_rows() > 0){
            $this->db->where('product_id', $product_id);
            $this->db->update('product_attributes', array('group_id' => $group_id));
        }
        else{
            $this->db->insert('product_attributes', array('product_id' => $product_id, 'group_id' => $group_id));
        }
        return;
    }
    
    public function get_product_action($product_id){
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('product_attributes');
        if($query->num_rows() > 0){
            return $query->row()->group_id;
        }
        return 0;
    }
    
    public function get_attribute_options($product_id){
        if(is_numeric($product_id)){
            $string = 'SELECT a.name as aname, a.id as aid, ao.name as aoname, ao.id as aoid, ag.name as agname FROM `attributes` a JOIN attribute_options ao ON ao.attribute_id = a.id JOIN attribute_option_groups aog ON aog.attribute_id = a.id JOIN attribute_groups ag ON ag.id = aog.group_id JOIN product_attributes pa ON pa.group_id = ag.id WHERE product_id = '.$product_id.' ORDER BY a.id, ao.sort';
            $query  = $this->db->query($string); 
            return $query->result();
        }
        return array();
    }
    
    public function get_attribute_stocks($product_id){
        if(!is_numeric($product_id))
            return array();
        
        $sql    = 'SELECT spa.id as spaid, quantity, min_quantity, price_variation, ao.name as aoname, a.name as aname FROM `stock_price_attributes`spa JOIN attribute_options ao ON ( (ao.id = spa.`attribute_id1`  AND spa.`attribute_id1` IS NOT NULL) OR (ao.id = spa.`attribute_id2`  AND spa.`attribute_id2` IS NOT NULL) OR (ao.id = spa.`attribute_id3`  AND spa.`attribute_id3` IS NOT NULL) OR (ao.id = spa.`attribute_id4`  AND spa.`attribute_id4` IS NOT NULL) OR (ao.id = spa.`attribute_id5` AND spa.`attribute_id5` IS NOT NULL) ) JOIN attributes a ON a.id = ao.attribute_id JOIN product_attributes pa ON ( pa.product_id = spa.product_id AND pa.group_id = spa.group_id) WHERE spa.product_id = '.$product_id.' ORDER BY spa.id, ao.sort';
        $query  = $this->db->query($sql);
        return $query->result();
    }
    
    public function update_stock_options($update_id){
        $product_id  = $this->input->post('product_id');
        $attributes  = $this->input->post('attr_names');
        $product_sku = $this->input->post('sku');
        
        $data       = $conditions = array();
        $i = 1;
        
        $this->db->where('product_id', $product_id);
        $stock_group = $this->db->get('product_attributes');
        
        if($stock_group->num_rows() > 0){
            $group_id = $stock_group->row()->group_id;
        }
        else
            $group_id = 0;
        
        foreach ($attributes as $attribute){
            if($i > 5)
                break;
            $conditions['attribute_id'.$i]  = $this->input->post($attribute);
            $data['attribute_id'.$i]        = $this->input->post($attribute);
            ++$i;
        }
        $data['product_id']     = $product_id;
        $data['quantity']       = $this->input->post('stock');
        $data['min_quantity']   = $this->input->post('low_stock');
        $data['price_variation']= $this->input->post('price_variation');
        $data['group_id']       = $group_id;
        
        if(!empty($product_sku))
            $data['sku']            = $product_sku;
        
        if(isset($update_id) && is_numeric($update_id)){
            $this->db->where('id', $update_id);
            $this->db->update('stock_price_attributes', $data);
            return TRUE;
        }
        $return_true = FALSE;
        $this->db->where('sku', $product_sku);
        $exist = $this->db->get('stock_price_attributes');
        if($exist->num_rows() > 1){
            return FALSE;
        }
        if($exist->num_rows() == 1){
            $existing_id = $exist->row()->id;
        }
        if($exist->num_rows() == 0){
            $return_true = TRUE;
        }
        
        $conditions['product_id']= $product_id;
        $this->db->where($conditions);
        $query = $this->db->get('stock_price_attributes');
        
        if($query->num_rows() > 0){
            if($return_true || ($existing_id == $query->row()->id) ){
                $this->db->where('id', $query->row()->id);
                $this->db->update('stock_price_attributes', $data);
            }
            else
                return FALSE;
        }
        else{
            if(!$return_true)
                return FALSE;
            $this->db->insert('stock_price_attributes', $data);
        }
        return TRUE;
    }
    
    public function get_stocks($product_id, $stock_id){
        $this->db->where(array('id' => $stock_id, 'product_id' => $product_id));
        $query = $this->db->get('stock_price_attributes');
        
        if($query->num_rows() > 0){
            return $query->row();
        }
        return FALSE;
    }
    
    public function coupon_code(){
        $code = $this->input->post('coupon_code');
        $this->db->where('code', $code);
        $this->db->where('start_date <=', Date('Y-m-d'));
        $this->db->where('end_date >=', Date('Y-m-d'));
        $this->db->where('status', 1);
        $query = $this->db->get('coupon_codes'); //echo $this->db->last_query();
        if($query->num_rows() > 0){
            $result = $query->row();
            if($result->access >= $result->limit)
                return FALSE;
            
            $this->db->where('code', $code);
            $this->db->update('coupon_codes', array('access' => ($result->access + 1) ));
            return $result;
        }
        return FALSE; 
    }
    
    public function load_product_attributes($product_id){
        
        if(!is_numeric($product_id))
            return FALSE;
        
        $query = $this->db->query("SELECT ao.id attribute_id, a.name aname, ao.name option_name FROM `product_attributes` pa JOIN attribute_option_groups aog ON aog.group_id = pa.group_id JOIN attributes a ON a.id = aog.attribute_id JOIN attribute_options ao ON ao.attribute_id = a.id WHERE product_id = $product_id");
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        
        return FALSE;
        
    }
    
    public function product_attribute_images($product_id){
        
        $query = $this->db->query("SELECT `image_id`, `attribute_id` FROM `attribute_images` ai JOIN images i ON i.id = ai.image_id WHERE i.product_id =  $product_id");
        if($query->num_rows() > 0){
            $result = $query->result();
            $return = array();
            
            foreach ($result as $image_data){
                $return[$image_data->image_id] = $image_data->attribute_id;
            }
            return $return;
        }
        
        return FALSE;
    }
}
