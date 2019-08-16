<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_model extends CI_Model
{
    public function getCatalog(){
        $query = $this->db->get_where('categories', array('parent_id' => 0));
        return $query->result();
    }

    public function insertuser($catalog){
			return $this->db->insert('catalog', $catalog);
		}
}
