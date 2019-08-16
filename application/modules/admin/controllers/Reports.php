<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Reports extends App_Controller
{
    public $oldsku;
    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->admins_only();
    }
    
    public function index(){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        $data['reports']     = array(
            'order_status_monthly' => "Order status monthly",
            'users_list'           => 'User list' 
        );
        $this->render_page('reports/index', $data);
    }
    
    public function view($request=''){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        $this->load->library('POSReportico');
        $this->render_page('reports/view', array('request' => $request));
        
    }
}