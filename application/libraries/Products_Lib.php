<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Products_Lib {
    private $CI;

    function __construct() {
       $this->CI =& get_instance();
       $this->CI->load->database();
    }
    
    public function get_stock_details($sku){
        $this->CI->db->where('sku', $sku);
        $query = $this->CI->db->get('products');
        if($query->num_rows() > 0){
            $product    = $query->row();
            $product_id = $product->id;
            $this->CI->db->where('group_id != ', 0);
            $this->CI->db->where('product_id', $product_id);
            $stock_query = $this->CI->db->get('stock_price_attributes'); 
            
            if($product->inventory == 3){ 
                if($stock_query->num_rows() > 0){
                    $stock_data  = $stock_query->result();
                    $hidden_data = array();
                    $status      = FALSE;
                    foreach ($stock_data as $s_data){                        
                        if($s_data->quantity > $s_data->min_quantity){
                            $status = TRUE;
                        }
                        else 
                            $hidden_data[] = $s_data->attribute_id1;
                    }
                }
                return array('status' => $status, "hidden" => $hidden_data);
            }
            else if ($product->inventory == 2) { 
                $status = $product->stock > $product->stock_min;
                return array('status' => $status, 'hidden' => array());
            }
            else{
                return array('status' => TRUE, "hidden" => array());
            }   
        }   
        return array('status' => FALSE, 'hidden' => array());
    }

    

    public function remove_product($ids){
        $this->CI->db->where('sync', 1);
        $this->CI->db->where_not_in('id', $ids);
        return $this->CI->db->delete('products');
    }

}