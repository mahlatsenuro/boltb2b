<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */
class Categories extends App_Controller
{
    public $oldname;
    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("categories_model");
        $this->admins_only();
        
    }

    public function index(){
        
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        
        $this->form_validation->set_rules('cats[]','Categoty', 'required');
        $this->form_validation->set_rules('parent','Parent category', 'required');
        
        $formSubmit = $this->input->post('submitForm');
        if ($this->form_validation->run() == true){ 
            
            if($formSubmit == "delete"){
                $result = $this->categories_model->remove_bulk();
                if( $result){
                   showFlash('Categories removed successfully.' );
                   redirect( site_url( 'admin/categories/' ) ); 
                }
                else{
                    showFlash('Sorry! Unable to remove categories.', 'danger');
                    redirect('admin/categories');
                }
            }
            
            $result = $this->categories_model->update_cates();
            if( $result)
               showFlash('Parent added.' );
            else
                showFlash('Sorry! Unable to add parent', 'danger');
                
            redirect('admin/categories');
           
        }
        
        $categories          =     $this->categories_model->get_categories();
        $this->render_page('categories/index', array( 'categories' => $categories ));
    }
    
    
    public function deactivate($cat_id)
    {
        if(!is_numeric($cat_id)){
            redirect('admin/categories');die;
        }
        
        $result = $this->categories_model->deactivate($cat_id);
        $result ? showFlash('Category deactivated.') : showFlash('Sorry! Unable to deactivate categories', 'danger');

        redirect('admin/categories');die;
    }
    
    public function activate($cat_id)
    {
        if(!is_numeric($cat_id)){
            redirect('admin/categories');die;
        }
        
        $result = $this->categories_model->activate($cat_id);
        $result ? showFlash('Category activated.') : showFlash('Sorry! Unable to activate category', 'danger');;
            
        redirect('admin/categories');die;
    }

    public function new_category($id = ""){
        
        $this->oldname       = '';
        $title               = 'Create';
        $categories          =     $this->categories_model->category_select();
        
        if (!empty($id)){
            $title           = 'Update';
            $category        = $this->categories_model->get_categories($id, 'id');
            if (!$category || !isset($category))
                show_404 ();
        }
        $this->oldname = $category->cname;    
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'parsely-remote.min.js' );  
        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[1]|callback__unique_name');
        $this->form_validation->set_rules('category_id', 'Category ID', 'trim|integer');
        $this->form_validation->set_rules('parent_category', 'Parent category', 'trim|integer');
        $this->form_validation->set_rules('sort', 'Sort order', 'trim|is_natural');
        
        $formSubmit = $this->input->post('submitForm');
        
        if ($this->form_validation->run() == true){ 
            $result = $this->categories_model->create_new();
            if( $result){
               showFlash('New category '.strtolower($title).'d successfully!' );
               if($formSubmit == 'formSaveClose')
                    redirect( site_url( 'admin/categories/' ) ); 
                else
                    redirect('admin/categories/new_category/'.$result); 
               
            }
            else{
                showFlash('Sorry! Unable to '.strtolower($title).' category', 'danger');
                redirect('admin/categories/new_category');
            }
            
        }
        else{   
            $parent = array( '' => '  --Select--  ' );
            foreach ($categories as $cat){
                $parent[$cat->cid] = $cat->cname;
            }
            $data = array(
                        "parent_category"                   => $parent,                
                        "head_title"                        => $title=='Update' ? 'Edit' : $title,
                        "name"  => array(
                            'name'                          => 'category_name',
                            'id'                            => 'category_name',
                            'type'                          => 'text',
                            'value'                         => isset($category->cname) ? $category->cname : $this->form_validation->set_value('category_name'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Category name',
                            'data-parsley-length'           => '[1, 25]',
                            'required'                      => '',
                            'data-parsley-remote'           => '',
                            'data-parsley-remote-options'   => '{ "type": "POST", "dataType": "jsonp", "data": { "token": "{value}" } }',
                            'data-parsley-remote-validator' => 'validateCategory',
                            'data-parsley-remote-message'   => 'Category already exists!'                            
                        ),
                        "display_name"  => array(
                            'name'                          => 'display_name',
                            'id'                            => 'display_name',
                            'type'                          => 'text',
                            'value'                         => isset($category->dname) ? $category->dname : $this->form_validation->set_value('display_name'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Display name',
                            'data-parsley-length'           => '[1, 25]',
                            'required'                      => '',
                        ),
                        "sort"  => array(
                            'name'                          => 'sort',
                            'id'                            => 'sort',
                            'type'                          => 'number',
                            'value'                         => isset($category->sort) ? $category->sort : $this->form_validation->set_value('sort'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Sort order',
                        ),
                        'id'                                => array( 'category_id' => $id ),
                        'parent'                            => isset($category) ? $category->cparent : $this->form_validation->set_value('parent_category'), 
                        'old'   => array( 'old' => $this->oldname ),
                        'menu'  => array('name' => 'menu', 'value'  => '1', 'checked' => isset($category) ? (bool)$category->in_menu : (bool)$this->form_validation->set_value('menu') )
                    );
        }
        $this->render_page('categories/new', $data );
    }
    
    
    public function exists($name)
    {
        $oldname  = $this->input->post( 'old' );
        
        if (strtolower($name) == strtolower($oldname)) 
        {
            echo 1;
            die;
        }
        
        $result = $this->categories_model->get_categories($name, 'name');  
        if ($result === FALSE || count($result) == 0){
            echo 1; die;
        }
        echo 0; die;
    }
    
    
    public function _unique_name($aname) {

        if (strtolower($aname) == strtolower($this->oldname)) 
        {
            return true;
        }

        if ($this->categories_model->get_categories($aname, 'name')) {

            $this->form_validation->set_message('_unique_name', 'The category name must be unique');

            return false;
        }

        return true;
    }
    
    
    public function delete($id)
    {
        if( empty($id) || !is_numeric($id) )
            show_404 ();
        
        $result = $this->categories_model->delete($id);
        $result ? showFlash('Category removed successfully!') : showFlash('Sorry! Unable to delete category!', 'danger');
        
        redirect('admin/categories');
    }
}

?>