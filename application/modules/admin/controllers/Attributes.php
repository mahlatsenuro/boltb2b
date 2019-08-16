<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */
class Attributes extends App_Controller
{
    
    public $oldname;

    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("attributes_model");
        $this->admins_only(); 
    }

    public function index(){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        
        $attributes          =     $this->attributes_model->get_attributes();
        $this->render_page('attributes/index', array( 'attributes' => $attributes ));
    }
    
    public function groups(){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        
          
        $attributes          =     $this->attributes_model->get_attribute_groups();
        $this->render_page('attributes/groups', array( 'attributes' => $attributes ));
    }

    public function new_options(){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        
          
        $this->render_page('attributes/new_options', array());
    }

    public function new_size($attribute_id = NULL){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        $attributes          = array();
        if(!empty($attribute_id)){
            $attributes = $this->attributes_model->get_attribute_options($attribute_id);
            if(!$attributes)
                show_404();
        }
        
        $this->form_validation->set_rules('attribute_name', 'Attribute Name', 'trim|required');
        $this->form_validation->set_rules('system_name', 'System Attribute Name', 'trim|required');
        $this->form_validation->set_rules('attr_options[]', 'Attribute options', 'trim|required');
        $this->form_validation->set_rules('sort[]', 'Attribute sort', 'trim|integer');        
        if(!empty($attribute_id)){
            $this->form_validation->set_rules('ids[]', 'Attribute option ids', 'trim|integer|required');
        }
        
        if ($this->form_validation->run() == true){ 
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->attributes_model->create_new('size', $attribute_id);
            if($result){
                showFlash('Attributes modified successfully!');
                if($formSubmit == 'formSaveClose')
                    redirect('admin/attributes'); 
                else
                    redirect('admin/attributes/new_size/'.$result); 
            }
            else{
                showFlash('Attributes modification failed!', 'danger');
                redirect('admin/attributes'); 
            }
        }
        $data  = array('attribute_name' => '');        
        foreach ($attributes as $attribute){
            $data['attribute_name'] = $attribute->aname;
            $data['system_name']    = $attribute->system_name;
            $data['options'][]      = $attribute->oname;
            $data['sort'][]         = $attribute->sort;
            $data['ids'][]          = $attribute->id;
            $data['hex'][]          = $attribute->hex;
            
        }
        $this->render_page('attributes/new_size', $data);
    }

    public function new_colour($id=NULL){
        
        $attributes = array();
        
        if(!empty($id)){
            $attributes = $this->attributes_model->get_attributes_existing($id);
            if(!$attributes)
                show_404();
        }
        
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        
        $this->form_validation->set_rules('attribute_name', 'Attribute Name', 'trim|required');
        $this->form_validation->set_rules('attr_options[]', 'Attribute options', 'trim|required');
        $this->form_validation->set_rules('sort[]', 'Attribute sort', 'trim|integer');
        $this->form_validation->set_rules('hex[]', 'Hex', 'trim|required');
        
        if ($this->form_validation->run() == true){ 
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->attributes_model->create_new('colour', $id);
            if( $result){
               showFlash('New attribute changed successfully!');
               if($formSubmit == 'formSaveClose')
                    redirect('admin/attributes'); 
                else
                    redirect('admin/attributes/new_colour/'.$result); 
            }
            else{
                showFlash('Sorry! Unable to '.strtolower($title).' attribute', 'danger');
                redirect(site_url( 'admin/attributes/new_attribute/'));
            }
        }
          
        $this->render_page('attributes/new_colour', array('id' => $id, 'attribs' => $attributes));
    }

    public function new_group($group_id=NULL){
        $attribute_options = array();
        if(!empty($group_id)){
            $attribute_options = $this->attributes_model->get_attribute_options_details($group_id);
        }
        
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        $attributes          = $this->attributes_model->get_attributes(); 
        $this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
        $this->form_validation->set_rules('members[]', 'Attributes', 'trim|required');
       
        if ($this->form_validation->run() == true){ 
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->attributes_model->create_new_group($group_id);
            if($result){
                showFlash('Attribute group modified successfully!' );
                if($formSubmit == 'formSaveClose')
                    redirect('admin/attributes/groups'); 
                else
                    redirect('admin/attributes/new_group/'.$result); 
            }
            else{
                showFlash('Attribute group modification failed!' );
                redirect('admin/attributes'); 
            }
        }
        $data  = array('group_name' => '', 'attributes' => $attributes, 'attribute_ids' => array());        
                
        foreach ($attribute_options as $key => $option){
            $data['group_name']      = $option->gname;
            $data['attribute_ids'][] = $option->attribute_id;
        }
        
        $this->render_page('attributes/new_group', $data);
        
    }
    public function delete_groups($id){
        if( empty($id) || !is_numeric($id) )
            show_404 ();
        $result = $this->attributes_model->delete_group($id);
        if ($result)
            showFlash('Attribute group removed successfully!');
        else
            showFlash('Sorry! Unable to delete attribute!', 'danger');

        redirect(site_url( 'admin/attributes/groups'));
    }

    public function delete($id){
        if( empty($id) || !is_numeric($id) )
            show_404 ();
        $result = $this->attributes_model->delete($id);
        if ($result){
            showFlash('Attribute removed successfully!');
            redirect(site_url( 'admin/attributes/'));
        }
        else{
            showFlash('Sorry! Unable to delete attribute!', 'danger');
            redirect(site_url( 'admin/attributes/'));
        }
    }

    public function exists($name){
        $oldname  = $this->input->post( 'old' );
        if (strtolower($name) == strtolower($oldname)){
            echo 1;
            die;
        }
        $result = $this->attributes_model->get_attributes($name, 'name');  
        if ($result === FALSE || count($result) == 0){
            echo 1; die;
        }
        echo 0; die;
    }
    
    public function _unique_name($aname){
        if ($aname == $this->oldname){
            return true;
        }
        if ($this->attributes_model->get_attributes($aname, 'name')){
            $this->form_validation->set_message('_unique_name', 'The attribute name must be unique');
            return false;
        }
        return true;
    }

}  