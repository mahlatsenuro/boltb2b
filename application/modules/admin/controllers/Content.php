<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Content extends App_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("contents_model");
        $this->admins_only();
        
    }
    
    public function terms()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'ckeditor.js', 'parsely-remote.min.js' );
        $this->form_validation->set_rules('terms', 'Terms and conditions', 'trim');
        
        if ($this->form_validation->run() == true)
        {   
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->contents_model->update_terms('terms');
            if( $result)
            {
                showFlash('Terms and conditions updated successfully' );

                if($formSubmit == 'formSaveClose')
                    redirect('admin');
                else 
                    redirect( 'admin/content/terms' ); 
            }
            else
            {
                showFlash('Sorry! Unable update terms and conditions', 'danger');
                redirect(site_url( 'admin/content/terms'));
            }
        }
        
        $this->render_page('content/terms', array());
    }
    
    public function whoweare()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'ckeditor.js', 'parsely-remote.min.js' );

        
        $this->form_validation->set_rules('whoweare', 'Who we are', 'trim');
        
        if ($this->form_validation->run() == true)
        {   
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->contents_model->update_terms('whoweare');
            if( $result)
            {
                showFlash('Who we are updated successfully' );

                if($formSubmit == 'formSaveClose')
                    redirect('admin');
                else 
                    redirect( 'admin/content/whoweare' ); 
            }
            else
            {
                showFlash('Sorry! Unable update who we are data', 'danger');
                redirect(site_url( 'admin/content/terms'));
            }
        }
        
        $this->render_page('content/whoweare', array());
    }

    public function faq()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'ckeditor.js', 'parsely-remote.min.js' );

        
        $this->form_validation->set_rules('faq', 'FAQ', 'trim');
        
        if ($this->form_validation->run() == true)
        {   
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->contents_model->update_terms('faq');
            if( $result)
            {
                showFlash('FAQ updated successfully' );

                if($formSubmit == 'formSaveClose')
                    redirect('admin');
                else 
                    redirect( 'admin/content/faq' ); 
            }
            else
            {
                showFlash('Sorry! Unable update FAQ', 'danger');
                redirect(site_url( 'admin/content/faq'));
            }
        }
        
        $this->render_page('content/faq', array());
    }
    
    public function privacy()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'ckeditor.js', 'parsely-remote.min.js' );

        
        $this->form_validation->set_rules('privacy', 'Privacy Policy', 'trim');
        
        if ($this->form_validation->run() == true)
        {   
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->contents_model->update_terms('privacy');
            if( $result)
            {
                showFlash('Privacy policy updated successfully' );

                if($formSubmit == 'formSaveClose')
                    redirect('admin');
                else 
                    redirect( 'admin/content/privacy' ); 
            }
            else
            {
                showFlash('Sorry! Unable update Privay policy', 'danger');
                redirect(site_url( 'admin/content/privacy'));
            }
        }
        
        $this->render_page('content/privacy', array());
    }
    
        public function delivery()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'ckeditor.js', 'parsely-remote.min.js' );

        
        $this->form_validation->set_rules('privacy', 'Delivery Policy', 'trim');
        
        if ($this->form_validation->run() == true)
        {   
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->contents_model->update_terms('delivery');
            if( $result)
            {
                showFlash('Delivery Policy updated successfully' );

                if($formSubmit == 'formSaveClose')
                    redirect('admin');
                else 
                    redirect( 'admin/content/delivery' ); 
            }
            else
            {
                showFlash('Sorry! Unable update Delivery Policy', 'danger');
                redirect(site_url( 'admin/content/delivery'));
            }
        }
        
        $this->render_page('content/delivery', array());
    }
    
    public function returns()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'ckeditor.js', 'parsely-remote.min.js' );

        
        $this->form_validation->set_rules('policy', 'Returns policy', 'trim');
        
        if ($this->form_validation->run() == true)
        {   
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->contents_model->update_terms('policy');
            if( $result)
            {
                showFlash('Returns policy updated successfully' );

                if($formSubmit == 'formSaveClose')
                    redirect('admin');
                else 
                    redirect( 'admin/content/returns' ); 
            }
            else
            {
                showFlash('Sorry! Unable update returns policy', 'danger');
                redirect(site_url( 'admin/content/returns'));
            }
        }
        
        $this->render_page('content/returns', array());
    }
    
    
    public function blogs()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        
          
        
        
        $blogs          =     $this->contents_model->get_blogs();
        $this->render_page('content/blogs', array( 'blogs' => $blogs ));
    }
    
    public function new_blog($id=NULL)
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'ckeditor.js', 'parsely-remote.min.js' );

        if($id)
            $option = "edit";
        else
            $option = "create";
        
        
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|integer');
        
        if ($this->form_validation->run() == true)
        {   
            $formSubmit = $this->input->post('submitForm');
            $result     = $this->contents_model->create_blog($id);
            if( $result)
            {
                showFlash('Blog '.$option.'ed successfully' );

                if($formSubmit == 'formSaveClose')
                    redirect('admin/content/blogs');
                else 
                    redirect( 'admin/content/new_blog/'.$result ); 
            }
            else
            {
                showFlash('Sorry! Unable to '.$option.' blog', 'danger');
                redirect(site_url( 'admin/content/new_blog'));
            }
        }
        else
        {
            if($id)
                $blog = $this->contents_model->get_blogs($id);
                        
            $data = array(
                    "title"  => array(
                        'name'                          => 'title',
                        'type'                          => 'text',
                        'value'                         => isset($blog->title) ? $blog->title : $this->form_validation->set_value('title'),
                        'class'                         => 'form-control',
                        'placeholder'                   => 'Title',
                        'required'                      => '',
                    ),
                    "status"                            =>  isset($blog->status) ? $blog->status : $this->form_validation->set_value('status'),
                    'option'                            => $option,
                    'content'                           => isset($blog->content) ? $blog->content : $this->form_validation->set_value('content'),
                );
        }
        $this->render_page('content/new_blog', $data);
    }
    
    public function status($action = "activate", $id)
    {
        if(!is_numeric($id))
            show_404 ();
        
        $result = $this->contents_model->status($action, $id);
        if( $result)
        {
            showFlash('Blog '.$action.'d successfully' );
            redirect('admin/content/blogs');
        }
        else
        {
            showFlash('Sorry! Unable to '.$action.' blog', 'danger');
            redirect(site_url( 'admin/content/blogs'));
        }
    }
    
}