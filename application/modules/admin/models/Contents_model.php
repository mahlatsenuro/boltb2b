<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contents_Model extends CI_Model
{
    
    public function update_terms($option)
    {
        $terms = $this->input->post($option);
        
        $this->db->where('index', $option);
        $total = $this->db->count_all_results('settings');

        if($total == 0){
            return $this->db->insert('settings', array("index" => $option, "value" => $terms));
        }
        else{
            $this->db->where('index', $option);
            return $this->db->update('settings', array("value" => $terms));
        }
    }
    
    public function get_blogs($id=NULL)
    {
        $this->db->select("title, date, id, status, content")->from("blogs");
        if($id)
            $this->db->where("id", $id);
        
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            if($id)
                return $query->row();
            return $query->result();
        }
        return FALSE;
    }
    
     public function get_frontend_blogs($id=NULL)
    {
        $this->db->select("title, date, id, status, content")->from("blogs");
        if($id)
            $this->db->where("id", $id);
        
        $this->db->where("status", 1);
        
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            if($id)
                return $query->row();
            return $query->result();
        }
        return FALSE;
    }
    
    public function create_blog($id=NULL)
    {
        $title   = $this->input->post("title");
        $content = $this->input->post('content');
        $status  = $this->input->post('status') ? 1 : 0;
        
        if($id)
        {
            $this->db->where("id", $id);
            $result = $this->db->update("blogs", array("title" => $title, "content" => $content, "status" => $status));
            return $result ? $id : FALSE;
        }
        else{
            
            $result = $this->db->insert("blogs", array("title" => $title, "content" => $content, "date" => Date("Y-m-d H:i:s"), "status" => $status));
            return $result ? $this->db->insert_id() : FALSE;
        }
    }
    
    public function status($action, $id)
    {
        $this->db->where("id", $id);
        
        switch($action){
            case "activate":
                $result = $this->db->update("blogs", array("status" => 1));
                break;
            case "deactivate" :
                $result = $this->db->update("blogs", array("status" => 0));
                break;
            case "delete":
                $result = $this->db->delete("blogs");
                break;
            default :
                $result = FALSE;
        }
        return $result;
    }
    
}

?>