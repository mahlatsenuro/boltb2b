<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_Model extends CI_Model
{
    
    public function total_revenue(){
        $sql = 'SELECT SUM(`price`) as total FROM `orders` WHERE `paid` = 1';
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result->total;
        }
        return 0;
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
    
     public function products_todeliver()
    {
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

    public function waiter_total()
    {
        
        $from_date = $this->input->post("date_from");
        $to_date   = $this->input->post("date_to");
        
        $query_parts = array();
        
        $query = $this->db->select('u.first_name, u.last_name, u.username')->from($this->config->item('SITE_ID').'users as u')->join($this->config->item('SITE_ID').'users_groups as ug', 'ug.user_id = u.id')->join($this->config->item('SITE_ID').'groups g', 'g.id = ug.group_id')->where('g.id', $this->config->item('waiter_index', 'ion_auth'));
        
        if(!empty($from_date))
            $this->db->where('u.created_on >= ', strtotime ($from_date));
        
        if(!empty($to_date))
            $this->db->where('u.created_on <= ', strtotime ($to_date));
        
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function get_monthwise_data()
    {
        $from_date = $this->input->get("from_date");
        $to_date   = $this->input->get("to_date");
        
        $query_parts = array();
        
        $sql = 'SELECT sum(price) as price, MONTH(`date`) month, YEAR(`date`) year, MONTHNAME(`date`) name, count(id) as users from orders WHERE YEAR(`date`) = "'.Date('Y-m-d').'" AND paid = 1';
    
        
        if(!empty($from_date) || !empty($to_date))
        {
            if(!empty($from_date)){
                $query_parts[] = " DATE(date) >= '".$from_date."'";
            }
            
            if(!empty($to_date)){
                $query_parts[] = " DATE(date) <= '".$to_date."'";
            }
            //$query_parts[] = "";
            $sql .= ' AND '.implode(" AND ", $query_parts);
        }
        $sql .= " group by MONTH(date) ";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function get_abandont_monthwise(){
        $sql = 'SELECT sum(price*quantity) as price, MONTH(`created`) month, YEAR(`created`) year, MONTHNAME(`created`) name, count(id) as users from abandon_cart WHERE YEAR(`created`) = "'.Date('Y-m-d').'"';
        $sql .= " group by MONTH(created) ";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }

    public function get_monthwise_products()
    {
        $from_date = $this->input->get("from_date");
        $to_date   = $this->input->get("to_date");
        
        $query_parts = array();
        
        $sql = 'SELECT count(id) as price, MONTH(`date`) month, YEAR(`date`) year, MONTHNAME(`date`) name, count(id) as users from products WHERE `date` > "'.Date('Y-m-d', strtotime('-6 months')).'" AND status = 1';
        $sql .= " group by MONTH(date) ";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
    
}
    