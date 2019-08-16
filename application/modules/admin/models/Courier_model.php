<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courier_Model extends CI_Model
{
    
    /**
     * Log collivery data
     */
    public function log_collivery($order_id, $type, $array)
    {
        $data             = array();
        $data['order_id'] = $order_id;
        $data['type']     = $type;
        $data['log']      = json_encode($array);
        
        $this->db->insert('order_collivery_log', $data);
        return;
    }
    
    /**
     * To update order placing
     */
    
    public function order_place_update($order_id, $field, $collivery_id)
    {
        $this->db->where('id', $order_id);
        return $this->db->update('orders', array('order_placed' => 1, $field => $collivery_id));
    }

    /**
     * @method get_unplaced_orders to get all unplaced orders
     * 
     */
    
    public function get_unplaced_orders()
    {
        $this->db->select('o.id, o.user_id, o.price, o.ship_address_id, o.ship_contact_id, o.courier_id1, od.product_sku, od.product_name, od.quantity, od.weight, od.length, od.width, od.hight, od.option1, od.option2, od.option3');
        $this->db->from('orders as o')->join('order_details as od', 'od.order_id = o.id');
        $query = $this->db->where( array('o.order_placed' => 0, 'o.paid' => 1))->get();
        
        if ($query->num_rows() > 0)
            return $query->result();
        return FALSE;
    }
    
    /**
     * @method get_collect_from_address to get admin collect from address
     * 
     */
    public function get_collect_from_address()
    {
       $query = $this->db->select('address_id, contact_id')->from('address_delivery')->get();
       
       if ($query->num_rows() > 0)
           return $query->row();
       return FALSE;
       
    }
    
    /**
     * @method type place_orderw(type $paramName) to place order for user
     * @param array $cart cart items as array
     * @return boolean 
     */
    
    public function create_towns($towns)
    {
        $collivery_towns = array();
        
        $query = $this->db->select('id')->from('collivery_towns')->where('id', 1)->get();
        
        $index = 0;
        
        foreach ($towns as $key => $town)
        {
            $collivery_towns[$index]['town_id'] = $key;
            $collivery_towns[$index]['name']    = $town;
            
            ++$index;
        }
        
        if ($query->num_rows() > 0)
            return $this->db->update_batch('collivery_towns', $collivery_towns, 'town_id');
        else
            return $this->db->insert_batch('collivery_towns', $collivery_towns);
        
    }
    
    public function create_suburb($suburbs)
    {
        $query = $this->db->select('id')->from('collivery_suburbs')->limit(1)->get();
        
        if ($query->num_rows() > 0)
            return $this->db->update_batch('collivery_suburbs', $suburbs, 'town_id');
        else
            return $this->db->insert_batch('collivery_suburbs', $suburbs);
    }
    
    public function create_location_types($types)
    {
        $query = $this->db->select('id')->from('collivery_location_types')->limit(1)->get();
        
        if ($query->num_rows() > 0)
            return $this->db->update_batch('collivery_location_types', $types, 'type_id');
        else
            return $this->db->insert_batch('collivery_location_types', $types);
    }
    
    public function create_services($services)
    {
        $query = $this->db->select('id')->from('collivery_sevices')->limit(1)->get();
        
        if ($query->num_rows() > 0)
            return $this->db->update_batch('collivery_sevices', $services, 'service_id');
        else
            return $this->db->insert_batch('collivery_sevices', $services);
    }
    
    public function create_parcel_types($parcel_types)
    {
        $query = $this->db->select('id')->from('collivery_parcel_types')->limit(1)->get();
        
        if ($query->num_rows() > 0)
            return $this->db->update_batch('collivery_parcel_types', $parcel_types, 'type_text');
        else
            return $this->db->insert_batch('collivery_parcel_types', $parcel_types);
    }
    
    public function get_user()
    {
        //$this->
    }
    
    public function get_non_delivered_orders()
    {
        $query = $this->db->select('id, user_id, courier_id1, courier_id2')->from("orders")->where(array('order_placed' => 1, 'delivered' => 0, 'courier_id1 !=' => 0))->get();
        if($query->num_rows() > 0)
        {
            $result = $query->result();
            return $result;
        }
        return FALSE;
    }
    
    public function update_collivery_status($order_id, $data)
    {
        $this->db->where("id", $order_id);
        return $this->db->update("orders", $data);
    }
}    