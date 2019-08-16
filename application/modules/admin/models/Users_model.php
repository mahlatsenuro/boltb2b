<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_Model extends CI_Model
{
    
    /**
     * @param string $email email to text exist or not
     */
    
    public function single($email = ""){
        $query = $this->db
            ->select("*")
            ->where("email", $email)
            ->get('users');    
        if ( $query->num_rows() > 0 )
        {
            $row = $query->result(); 
            return $row;
        }
        return FALSE; 
        
    }
    
    /**
     * @method type get_userss(type $paramName) to get all users refistered
     * @param none $name Description
     * @return array with all users or false
     * @called from admin/users
     */
    
    public function get_users()
    {
        
        $query = 'SELECT u.`username`, u.`email`, u.`active`, u.`created_on`, u.`id` as uid, u.`last_login`, u.`first_name`, u.`last_name`, g.`description` as role FROM `users` as u JOIN `users_groups` as ug  ON ug.`user_id` = u.id JOIN groups as g ON g.id = `group_id` group by u.email';
        $query = $this->db->query($query);
        if ( $query->num_rows() > 0 )
        {
            $row = $query->result(); 
            return $row;
        }
        return FALSE; 
    }

    /**
     * @method type deletes(type $paramName) delete user
     * @param int $id user id to delete
     * @return boolean true on success FALSE on failure
     * @called from admin/user
     */

    public function delete($id)
    {
        if ($this->db->delete('users', array('id' => $id)))
        {
            $this->db->delete('users_groups', array('user_id' => $id) );
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * @method type get_all_orderss(type $paramName) to get all orders of an user
     * @param int $user_id User id
     */
    
    public function get_all_orders($user_id)
    {
        $query = $this->db->query('SELECT o.`order_reference`, o.paid, o.`delivered`, od.`product_sku`, od.options, od.`product_name`, od.`quantity`, od.`price`, o.date FROM `orders` as o JOIN order_details as od ON od.order_id = o.id WHERE o.`user_id` = '.$user_id);
        
        if ( $query->num_rows() > 0 )
        {
            $row = $query->result(); 
            return $row;
        }
        return FALSE; 
        
    }
    /**
     * @method type get_users_with_order_count 
     * @param none 
     * @return array with all users or false
     * @called from admin/users
     */
    
    public function get_users_with_order_count()
    {
    
    	$query = 'SELECT u.username, u.`email`, u.`active`, u.`created_on`, u.`id` as uid, u.`last_login`, u.`first_name`, u.`last_name`, g.`description` as role ,COALESCE(x.cnt,0) AS order_count FROM `users` as u
		JOIN `users_groups` as ug  ON ug.`user_id` = u.id
    	JOIN groups as g ON g.id = `group_id`
    	LEFT OUTER JOIN (SELECT user_id, count(*) cnt FROM orders GROUP BY user_id) x ON u.id = x.user_id
    	group by u.email';
    	$query = $this->db->query($query);
    	if ( $query->num_rows() > 0 )
    	{
    		$row = $query->result();
    		return $row;
    	}
    	return FALSE;
    }
}

?>