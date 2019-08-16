<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_Model extends CI_Model
{
    function addQueue($to, $subject, $message, $type)
    {
        return $this->db->insert('mail_queue', array('to' => $to, 'subject' => $subject, 'message' => $message, 'type' => $type));
    }
    
    public function get_emails($types)
    {
        $query = $this->db->select('id, to, subject, message')->from('mail_queue')->where('status', 0)->where_in('type', $types)->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function update_status($id)
    {
        $this->db->where('id', $id);
        $this->db->update('mail_queue', array('status' => 1));
    }
}