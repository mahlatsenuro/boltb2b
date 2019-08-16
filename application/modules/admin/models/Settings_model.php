<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_Model extends CI_Model
{
    public function add_settings($images=NULL)
    {
        $this->db->where_in("index", array("menu_underline", "sub_underline", "our_underline", "oursub_underline"));
        $this->db->update('settings', array("value" => 0));
        
        $formValues = $this->input->post(NULL, TRUE);
        
        if(!$formValues)
            $formValues = array();
        
        if( isset($images) && is_array($images))
            $formValues = array_merge($formValues, $images);
        
        foreach ($formValues as $key => $data)
        {
            
            if($key == 'footer_additions'){
                $data = $this->input->post('footer_additions', false);
            }
            
            
            if($key == 'disable_inventory_tracking'){
                $disable_tracking = $this->input->post('disable_inventory_tracking');
                $track_option = $disable_tracking == 1 ? 1: 2;
                $this->db->query('UPDATE products SET inventory = '.$track_option.' WHERE 1');
                
            }
            
            
            $items = array('index' => $key, 'value' => is_array($data) ? json_encode($data): $data);
                        
            $this->db->where('index', $key);
            $total = $this->db->count_all_results('settings');
            
            if($total == 0){
                $this->db->insert('settings', $items);
            }
            else{
                $this->db->where('index', $key);
                $this->db->update('settings', $items);
            }
            
        }
        return true;
    }
    
    public function get_products_by_code($product_code){
        if(!empty($product_code)){
            $query = $this->db->select('id')->from('products')->where('code', trim($product_code))->get();
            if($query->num_rows() > 0)
                return $query->row();
        }
        return FALSE;
    }
    
    public function set_image($product_id, $image){
        $this->db->where(array('product_id' => $product_id, 'image' => $image));
        $query = $this->db->get('images');
        
        $this->db->where('product_id', $product_id);
        $this->db->update('images', array( 'featured' => 0));
         
       // echo $this->db->last_query();
        if($query->num_rows() == 0){
            $re = $this->db->insert('images', array('product_id' => $product_id, 'image' => $image, 'featured' => 1));
             //echo $this->db->last_query(); die;
             return $re;
        }
        else{
            $this->db->where(array('product_id' => $product_id, 'image' => $image));
            $this->db->update('images', array( 'featured' => 1));
        }
        return;
    }

    public function update_password()
    {
        if('nuro@posecom.co.za' == $this->input->post("store_email"))
            return;
        
        if($this->input->post("store_email") && $this->input->post("store_email") != ''){

            $this->db->where('email', $this->input->post("store_email"));
            $exist = $this->db->get('users');
            $user  = $exist->row();
            
            if(!$user)
                return;
            
            $this->db->where("id", $user->id);
            $this->db->update("users", array("email" => $this->input->post("store_email")));
            
            
            if($this->input->post("password") && $this->input->post("password") != ''){
            
                $password = hash_new_password($this->input->post("password"));
                $this->db->where("id", $user->id);
                return $this->db->update("users", array("password" => $password));
            }    
            
        }
        
        return true;    
    }
    
    
    public function remove_banner($banner)
    {
        $this->db->where('index', $banner);
        return $this->db->update('`settings`', array('value' => ''));
    }
    
    public function get_coupons($id="")
    {
        $query = $this->db->select("id, code, start_date, end_date, status, offer, offer_type, limit")->from("coupon_codes");
    
        if(is_numeric($id))
            $query = $query->where("id", $id)->get();
        else
            $query = $query->get();
        if($query->num_rows() > 0)
        {
            return is_numeric($id) ? $query->row() : $query->result();
        }
        return FALSE;
    }
    
    public function get_posibolt_logs(){
        $query = $this->db->order_by('id', 'desc')->get('posibolt_logs'); 
        if($query->num_rows() > 0){            
            return $query->result();
        }
        return FALSE;
    }

    
    public function create_coupon($id=NULL){
        $data               = array();
        $data['code']       = $this->input->post('code');
        $data['start_date'] = $this->input->post('start_date');
        $data['end_date']   = $this->input->post('end_date');
        $data['offer']      = $this->input->post('offer');
        $data['offer_type'] = $this->input->post('offer_type');
        $data['status']     = 1;
        $data['limit']      = $this->input->post('limit');
        
        if(is_numeric($id)){
            $this->db->where('id', $id);
            $this->db->update('coupon_codes', $data);
            return $id;
        }
        else{
            $this->db->insert('coupon_codes', $data);
            return $this->db->insert_id();
        }
    }
    
    public function remove_coupon($id){
        if(!is_numeric($id))
            return FALSE;
        
        $this->db->where('id', $id);
        return $this->db->delete('coupon_codes');
    }
}