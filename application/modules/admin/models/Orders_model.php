<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_Model extends CI_Model
{
    
    
    /**
     * Check stock exist for the product
     */
    
    public function confirm_stock($product_sku, $id, $quantity)
    {
        $this->db->where('sku', $product_sku);
        $products = $this->db->get('products');
        
        if($products->num_rows() > 0){
            $product = $products->row();
            
            if($product->inventory == 3){
                $this->db->where("id", $id)->where('quantity >= ', $quantity);
                $exist = $this->db->count_all_results('stock_price_attributes'); 
                return  (bool)$exist;
            }
            else if($product->inventory == 2){
                return $product->stock > $product->stock_min;
            }
            else{
                return TRUE;
            }
        }
        
    }
    
    public function delete_order($order_id){
        $this->db->where('id', $order_id);
        return $this->db->delete('orders');
    }

    public function update_stock($product_sku, $stock_id, $quantity){
        $this->db->where('sku', $product_sku);
        $products = $this->db->get('products');
        
        if($products->num_rows() > 0){
            $product = $products->row();
            if($product->inventory == 3){
                $this->db->where('id', $stock_id);
                $this->db->set('quantity', "quantity-$quantity", FALSE);
                return $this->db->update('stock_price_attributes');
            }
            else if($product->inventory == 2){
                $this->db->where('sku', $product_sku);
                $this->db->set('stock', "stock-$quantity", FALSE);
                return $this->db->update('products');
            }
            else{
                return TRUE;
            }
        }
    }
    
    public function release_stock($product_sku, $stock_id, $quantity){ return; 
        $this->db->where('sku', $product_sku);
        $products = $this->db->get('products');
        
        if($products->num_rows() > 0){
            $product = $products->row();
            if($product->inventory == 3){
                $this->db->where('id', $stock_id);
                $this->db->set('quantity', "quantity+$quantity", FALSE);
                return $this->db->update('stock_price_attributes');
            }
            else if($product->inventory == 2){
                $this->db->where('sku', $product_sku);
                $this->db->set('stock', "stock+$quantity", FALSE);
                return $this->db->update('products');
            }
            else{
                return TRUE;
            }
        } 
    }
    /**
     * @method type place_orderw(type $paramName) to place order for user
     * @param array $cart cart items as array
     * @return boolean 
     */
    
    public function place_order($shipping, $payment_mode = 'mygate', $total, $coupon = array())
    {
        $shipping_charge = $shipping['shipping_charge'];
        $cart_items = $this->cart->contents();      
        $order      = $order_details = array();
        $order_reference = unique_string(5).uniqid();
        
        $order_comments    = $this->session->userdata( 'order_comments' );
        
        
        $order['order_reference']   = $order_reference;
        $order['user_id']           = get_userid_checkout();
        $order['price']             = price_calc( $total );
        $order['coupon']            = json_encode($coupon);
        $order['pos_shipping_price']= $shipping_charge;
        $order['ship_address_id']   = $shipping['address_id'];
        $order['ship_contact_id']   = $shipping['contact_id'];
        $order['paid']              = 0;    
        $order['payment_method']    = $payment_mode;
        $order['shipping_address']  = isset($shipping['shipping_address']) ? $shipping['shipping_address'] : '';
        $order['courier']           = $this->config->item('courier_service');
        $order['comment']           = $order_comments;
        
        $this->db->trans_start();
        $this->db->insert('orders', $order);
        $order_id = $this->db->insert_id();
        $order_reference = 'ORDER'.$order['user_id'].$order_id;
        $this->db->where('id', $order_id);
        $this->db->update('orders', array('order_reference' => $order_reference));
        
        if ( $order_id > 0 && $order_id){
            foreach ($cart_items as $index => $cart){     
                
                $product_comment                        = "";
                
                $order_details[$index]['order_id']      = $order_id;
                $order_details[$index]['product_sku']   = $cart['id'];
                $order_details[$index]['product_name']  = $cart['name'];
                $order_details[$index]['quantity']      = $cart['qty'];
                $order_details[$index]['price']         = $cart['price'];
                $order_details[$index]['delivery_price']= $shipping_charge;
                
                $options = $cart['options'];                
                
                $order_details[$index]['weight']        = isset($options['weight'])  ? $options['weight']  : "";
                $order_details[$index]['hight']         = isset($options['height'])  ? $options['height']  : "";
                $order_details[$index]['width']         = isset($options['width'])   ? $options['width']   : "";
                $order_details[$index]['length']        = isset($options['length'])  ? $options['length']  : "";
                $order_details[$index]['option1']       = isset($options['option1']) ? $options['option1'] : "";
                $order_details[$index]['option2']       = isset($options['option2']) ? $options['option2'] : "";
                $order_details[$index]['option3']       = isset($options['option3']) ? $options['option3'] : "";
                $order_details[$index]['option4']       = isset($options['option4']) ? $options['option4'] : "";
                $order_details[$index]['option5']       = isset($options['option5']) ? $options['option5'] : "";
                $order_details[$index]['options']       = json_encode($options);
                
                if($this->session->userdata('product_note_'.$options['product_id'])){
                    $order_details[$index]['comment'] = "Product ID: ".$options['product_id']." :: ".$this->session->userdata('product_note_'.$options['product_id']);
                }
            }
            $this->db->insert_batch('order_details', $order_details);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return array( 'order' => 0, 'status' => FALSE);
        }
        else{
            return array( 'order' => $order_id, 'reference' => $order_reference, 'status' => TRUE);
        }
    }
    
    public function update_status($order_id){
        
        $paid = $this->input->post('status');
        
        if($paid == 1){
            $query = $this->db->select('product_sku, quantity')->from('orders o')->join('order_details od', 'o.id = od.order_id')->where('o.id', $order_id)->where('o.order_placed', 0)->get();
            if($query->num_rows() > 0){
                $result = $query->result();
                foreach ($result as $order){
                    $this->db->where('sku', $order->product_sku);
                    $this->db->set('stock', "stock-$order->quantity", FALSE);
                    $this->db->update('products');
                    //echo $this->db->last_query(); die;
                }
            }
        }
        $transaction = $this->input->post('transaction_id');
        $this->db->where('id', $order_id);
        return $this->db->update('orders', array('paid' => $paid, 'transaction_id' => $transaction, 'order_placed' => $paid == 1 ? 1 : 0));
    }

    public function get_full_data($id){
        $query = $this->db->select('o.order_reference, o.comment ocomment, od.comment odcomment, o.coupon, od.options, o.id as oid, o.price as oprice, o.shipping_address, o.pos_shipping_price, paid, transaction_id, payment_method, o.date, od.price as odprice, o.price as oprice, courier, order_placed, delivered, u.first_name, u.last_name, u.email, u.phone, od.product_name, od.quantity, od.price, od.option1, od.option2, od.option3, od.option4, od.option5')->from('orders o')->join('users u', 'u.id = o.user_id')->join('order_details od', 'od.order_id = o.id')->where('o.id', $id)->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }

    public function get_report_orders(){
        $query = $this->db->select('o.paid, o.id, o.payment_method, o.delivered, o.order_placed, o.date, od.product_name, od.quantity, od.price, u.first_name, u.last_name, u.email')->from('orders o')->join('order_details od', 'od.order_id = o.id')->join('users u', 'u.id = o.user_id')->order_by('o.id', 'desc')->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function get_brief_orders(){
        $query = $this->db->select('o.paid, o.courier_id1, o.order_reference, o.courier_id2, o.id, o.payment_method, o.delivered, o.order_placed, o.date, u.first_name, u.last_name, u.email')->from('orders o')->join('users u', 'u.id = o.user_id')->order_by('o.id', 'desc')->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }

        /**
     * @method type verify_payments(type $paramName) to verify payment done in admin
     * @param int $order_id order id to which payment has done.
     * @return boolean True on success
     */
    
    public function verify_payment($order_id){
        $this->db->where('id', $order_id);
        return $this->db->update('orders', array('paid' => 1));
        
    }
    
    /**
     * @method type get_orderss(type $paramName) to get successfull orders 
     * @param int $order_id order id to which payment has done.
     * @return boolean True on success
     */
    
    public function get_orders($user_id){
        $this->db->select('o.order_reference, od.options, o.price as total, o.paid, od.price, o.date, o.shipping_address, od.product_sku, od.product_name, od.quantity, od.price')->from('orders as o');
        $query = $this->db->join('order_details as od', 'od.order_id = o.id')->where( array('o.user_id' => $user_id))->order_by("date", "desc")->get();
    
        if ($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
  
    /**
     * @method type record_transaction_detailss(type $paramName) to record transaction data
     * @param int $order_id order id
     * @param array $result mygate transaction details
     */
    
    public function record_transaction_details($order_id, $result)
    {
        $data = array();
        
        if(isset($result) && is_array($result) && count($result) >= 4){

            list($ftext,$final)             = explode("||",$result[0]);
            list($ttext,$transaction_index) = explode("||",$result[1]);
            list($atext,$acquire_time)      = explode("||",$result[2]);
            list($ttext,$authorization_id)  = explode("||",$result[3]);

            $data['user_id']    = get_userid_checkout();
            $data['order_id']   = $order_id;
            $data['result']     = $final;
            $data['transaction_index'] = $transaction_index;
            $data['acquire_time']      = $acquire_time;
            $data['auth_id']           = $authorization_id;

            $this->db->insert('mygate_transactions', $data);
            return $this->db->insert_id();
        }
        return true;
    }
    
    
}
