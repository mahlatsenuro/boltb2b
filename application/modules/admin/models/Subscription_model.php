<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscription_Model extends CI_Model
{
    
    public function subscribe($email){
        
        $id = $this->check_existing($email);
        
        if(!$id){
            return $this->db->insert('email_subscription_list', array('email' => $email));
        }
        return ;
    }
    
    public function check_existing($email){
        $query = $this->db->get_where('email_subscription_list', array('email' => $email));
        if($query != null)
            return $query->row()->id;
        else
            return FALSE;
    }
    
    public function remove($email){
        return $this->db->delete('email_subscription_list', array('email' => $email)); 
    }
    
}