<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Store_Model extends CI_Model

{

    public function add_settings($images)

    {


        $formValues = $this->input->post(NULL, TRUE);

        if(is_array($images))

            $formValues = array_merge($formValues, $images);

        

        foreach ($formValues as $key => $data)

        {

            $items = array('index' => $key, 'value' => is_array($data) ? json_encode($data): $data);

            

            $this->db->where('index', $key);

            $total = $this->db->count_all_results('settings');

            

            if($total == 0){

                $this->db->insert('settings', $items);

            }

            else{

                $this->db->where('index', $key);

                $this->db->update('settings', $items);

            }

            

        }

        

    }

}