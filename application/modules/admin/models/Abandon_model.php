<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abandon_Model extends CI_Model{
    
    public function add_to_cart($data){
        foreach ($data as $item){
            $this->db->where('session_id', $item['session_id']);
            $this->db->where('sku', $item['sku']);
            $query = $this->db->get('abandon_cart');
            
            if($query->num_rows() > 0){
                $cart_id = $query->row()->id;
                $this->db->where('session_id', $item['session_id']);
                $this->db->where('sku', $item['sku']);
                $this->db->update('abandon_cart', array('quantity' => $item['quantity']));
            }
            else{
                $this->db->insert('abandon_cart', $item);
            }
        }
        return TRUE;
    }
    
    public function remove_from_cart($session_id, $product_id){
        $this->db->where('sku', $product_id)->where('session_id', $session_id);
        return $this->db->delete('abandon_cart');
    }
    
    public function get_cart_items(){
        $cart_items = $this->db->get('abandon_cart');
        if($cart_items->num_rows() > 0)
            return $cart_items->result();
        return FALSE;
    }
    
    public function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('abandon_cart');
    }
    
    public function get_abandon_revenue(){
        $query = $this->db->select('SUM(quantity*price) as revenue')->get('abandon_cart');
        if($query->num_rows() > 0){
            return $query->row()->revenue;
        }
        return FALSE;
    }
    
    public function get_abandoned_carts(){
        $result = $this->db->select('count(DISTINCT session_id) as total')->get('abandon_cart');
        return $result->row()->total;
    }
    
    public function products_sold(){
        
        $sql = 'SELECT SUM( `quantity` ) AS total FROM `order_details` od JOIN orders o ON o.id = od.order_id WHERE `paid` =1';
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result->total;
        }
        return 0;
    }
    
    public function products_todeliver(){
        $sql = 'SELECT SUM( `quantity` ) AS total FROM `order_details` od JOIN orders o ON o.id = od.order_id WHERE `paid` =1 AND o.delivered=0';
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result->total;
        }
        return 0;
    }
    
    public function total_customers(){
        $sql = 'SELECT count( `id` ) as total FROM users WHERE active = 1';
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result->total;
        }
        return 0;
    }
    
    public function get_distinct_emails(){
        $query = $this->db->select('DISTINCT(user_email)')->where('user_email !=', '')->get('abandon_cart');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
}