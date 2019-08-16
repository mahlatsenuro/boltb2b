<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Manufacturer extends App_Controller
{
    public $oldname;

    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("manufacture_model");
        $this->admins_only();
        
    }

    public function index(){
        
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        $manufactures        =     $this->manufacture_model->get_manufactures(); 
        $this->render_page('manufacturer/index', array( 'manufactures' => $manufactures ));
    }
    
    
    public function new_manu($id = ""){
        $this->oldname = '';
        $title               = 'Create';
        
        if (!empty($id)){
            $title           = 'Update';
            $manufacturer    = $this->manufacture_model->get_manufactures($id, 'id');
            if (!$manufacturer)
                show_404 ();
        }
            
        $this->oldname       = $manufacturer->name;
        
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'parsely-remote.min.js' );  
        $this->form_validation->set_rules('name', 'Manufacturer Name', 'trim|required|min_length[3]|callback__unique_name');
        $this->form_validation->set_rules('details', 'Details', 'trim');
        
        if ($this->form_validation->run() == true)
        { 
            $result = $this->manufacture_model->create_new();
            if( $result)
            {
               showFlash('Manufacturer '.strtolower($title).'d successfully!' );
               redirect( site_url( 'admin/manufacturer/new_manu/'.$result ) ); 
            }
            else
            {
                showFlash('Sorry! Unable to '.strtolower($title).' manufacturer!', 'danger');
                redirect('admin/manufacturer/new_manu');
            } 
        }
        else
        {   
            $data = array(
                
                "head_title"      => $title,

                "name"  => array(
                    'name'                          => 'name',
                    'id'                            => 'name',
                    'type'                          => 'text',
                    'value'                         => isset($manufacturer->name) ? $manufacturer->name : $this->form_validation->set_value('name'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Manufacturer name',
                    'data-parsley-length'           => '[3, 25]',
                    'required'                      => '',
                    'data-parsley-remote'           => '',
                    'data-parsley-remote-options'   => '{ "type": "POST", "dataType": "jsonp", "data": { "token": "{value}" } }',
                    'data-parsley-remote-validator' => 'validateManufacturer',
                    'data-parsley-remote-message'   => 'Manufacturer already exists!',
                    'parsley-remote-method'         => 'POST'
                ),
                "details"  => array(
                    'name'                          => 'details',
                    'id'                            => 'details',
                    'type'                          => 'text',
                    'value'                         => isset($manufacturer->details) ? $manufacturer->details : $this->form_validation->set_value('details'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Manufacturer details',
                    'data-parsley-length'           => '[3, 50]',
                ),

                'id'    => array( 'manufacturer_id' => $id ),
                'old'   => array( 'old' => $this->oldname )
            );
        }
        $this->render_page('manufacturer/new', $data );
    }
    
    
    public function delete($id)
    {
        if( empty($id) || !is_numeric($id) )
            show_404 ();
        
        $result = $this->manufacture_model->delete($id);
        
        if ($result){
            showFlash('Manufacturer removed successfully!');
            redirect('admin/manufacturer');
        }
        else{
            showFlash('Sorry! Unable to delete manufacturer!', 'danger');
            redirect('admin/manufacturer');
        }
    }

    



    public function exists($name)
    {
        $oldname  = $this->input->post( 'old' );
        
        if (strtolower($name) == strtolower($oldname)) 
        {
            echo 1;
            die;
        }
        
        $result = $this->manufacture_model->get_manufactures($name, 'name');  
        if ($result === FALSE || count($result) == 0){
            echo 1; die;
        }
        echo 0; die;
    }
    
    
    public function _unique_name($aname) {

        if ($aname == $this->oldname) 
        {
            return true;
        }

        if ($this->manufacture_model->get_manufactures($aname, 'name')) {

            $this->form_validation->set_message('_unique_name', 'The manufacturer name must be unique');

            return false;
        }

        return true;
    }

}  