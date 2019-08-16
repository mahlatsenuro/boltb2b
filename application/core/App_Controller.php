<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Base Controller
 *
 */
class App_Controller extends CI_Controller
{

    /**
     * Site Title
     * 
     * @var string
     */
    public $site_title = '';
    
    /**
     * Page Title
     * 
     * @var string
     */
    public $page_title = '';
    public $blogs      = array(); 
    /**
     * Page Meta Keywords
     * 
     * @var string
     */
    public $page_meta_keywords = '';
    
    /**
     * Page Meta Description
     * 
     * @var string
     */
    public $page_meta_description = '';
    
    /**
     * JS Calls on DOM Ready
     * 
     * @var array 
     */
    public $js_domready = array();
    
    /**
     * JS Calls on window load
     * 
     * @var array 
     */
    public $js_windowload = array();

    /**
     * Body classes
     * 
     * @var array 
     */
    public $body_class = array();

    /**
     * Current section
     * 
     * @var string
     */
    public $current_section = '';
    
    /**
     * Class Constructor
     */
    
    public $categories   = array();
    public $pos_template = NULL;
    
    public function __construct()
    {
        // Call Parent Constructor
        parent::__construct();
        // Site Page Title
        $this->site_title = $this->config->item('app_title'); 

        // Initialize array with assets we use site wide
        $this->assets_css = array(); //echo $this->router->fetch_class();
        
        $class_called = $this->router->fetch_class();
       
        $this->assets_js = array();

        $this->template->set('is_frontend', true);
        $this->load->model("admin/contents_model");
        
        $this->blogs = $this->contents_model->get_frontend_blogs();      
    }
    
    /**
     * Prepare BASE Javascript
     */
    private function prepare_base_javascript()
    {
        $str = "<script type=\"text/javascript\">\n";
        
        if (count($this->js_domready) > 0)
        {
            $str.= "$(document).ready(function() {\n";
            $str.= implode("\n", $this->js_domready) . "\n";
            $str.= "});\n";
        }
        
        if (count($this->js_windowload) > 0)
        {
            $str.= "$(window).load(function() {\n";
            $str.= implode("\n", $this->js_windowload) . "\n";
            $str.= "});\n";
        }
        
        $str.= "</script>\n";
        $this->template->append_metadata($str);
    }
    
    /**
     * Set CSS Meta
     */
    private function set_styles()
    {
        if (count($this->assets_css) > 0)
        {
            foreach($this->assets_css as $asset)
                $this->template->append_css('<link rel="stylesheet" type="text/css" href="' . loadAsset('css/' . $asset) . '" media="screen" />');
        }
    }
    
    /**
     * Set Javascript Meta
     */
    private function set_javascript()
    { 
        if (count($this->assets_js) > 0)
        {
            foreach($this->assets_js as $asset)
                if (stristr($asset, 'http') === FALSE)
                    $this->template->append_js('<script type="text/javascript" src="' .loadAsset('js/' . $asset). '"></script>');
                else
                    $this->template->append_js('<script type="text/javascript" src="' . $asset . '"></script>');
        }
    }

    /**
     * Locks in controller and/or methods
     */
    public function lock_in($path = '')
    {
        $user_id = get_userid_checkout();
                
        if ( ! $this->ion_auth->logged_in() && $user_id == FALSE )
        {
            $this->session->set_flashdata('app_error', 'Please login to our system using our secured server and proceed checkout.');
            redirect('user/login/'.$path);
        }
    }

    /**
     * Make sure user is admin
     */
    public function admins_only()
    {
        // Make sure user is logged in
        if ( ! $this->ion_auth->logged_in()){ 
            redirect('admin/login');
        }

        if ( ! $this->ion_auth->in_group('admin'))
        {   
            $this->session->set_flashdata('app_error', 'Please log in first.');
            redirect('admin/login'); die('HERE');
        }
    }


    public function set_postheme(){
        $this->pos_template = getTemplate();
    }

    /**
     * Renders page
     */
    public function render_page($page, $data = array())
    {   
        $this->set_postheme();
        $this->template->set_theme($this->pos_template);
        // Renders the whole page
        $this->template
            ->set_metadata('keywords', $this->page_meta_keywords)
            ->set_metadata('description', $this->page_meta_description)
            ->set_metadata('canonical', site_url($this->uri->uri_string()), 'link')
            ->title($this->page_title, $this->config->item('store_name'));

        $this->set_styles();
        $this->set_javascript();
        $this->prepare_base_javascript();
        
        // Set global template vars
        $this->template
            ->set('current_section', $this->current_section)
            ->set('user_logged_in', $this->ion_auth->logged_in())
            ->set('body_class', implode(' ', $this->body_class));

        $this->template
            ->set_partial('flash', 'flash')
            ->set_partial('header', 'header')
            ->set_partial('sidebar', 'sidebar')    
            ->set_partial('footer', 'footer'); 
        
        
        $data['template_name']  = $this->pos_template;
        // Renders the main layout
        $this->template->build($page, $data); 
    }
    
    
}
