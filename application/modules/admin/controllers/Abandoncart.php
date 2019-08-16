<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Abandoncart extends App_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("abandon_model");
        $this->admins_only(); 
    }
    
    public function index(){
        //$cart_items = $this->abandon_model->get_cart_items();
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css', 'style_1.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );
        $abandond_revenue    = $this->abandon_model->get_abandon_revenue();
        $abandond_carts      = $this->abandon_model->get_abandoned_carts();
        $sold_products       = $this->abandon_model->products_sold();    
        $total_customers     = $this->abandon_model->total_customers();
        $this->render_page('abandon_cart/index', array('total_customers' => $total_customers, 'sold_products' => $sold_products, 'abandon_revenue' => $abandond_revenue, 'abandond_carts' => $abandond_carts ));
    }
    
    public function email(){
        //$cart_items = $this->abandon_model->get_cart_items();
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css', 'style_1.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js', 'ckeditor.js' );  
        $this->form_validation->set_rules('abandoned_email', 'Email template', 'trim');
        if ($this->form_validation->run() == true){
            $this->load->model('settings_model');
            $result = $this->settings_model->add_settings();
            if($result){   
                showFlash('Email template updated' );
            }
            else{
                showFlash('Sorry! Unable update template', 'danger');
            }   
            redirect('admin/abandoncart/email');
        }
        $this->render_page('abandon_cart/email', array());
    }
    
    public function load_cart(){ 
        $table          = 'abandon_cart';
        $primaryKey     = 'id';

        $columns = array(
            array( 'db' => 'product_name', 'dt' => 0 ),
            array( 'db' => 'quantity',  'dt' => 1 ),
            array(
                'db'        => 'price',
                'dt'        => 2,
                'formatter' => function( $d, $row ) {
                    return price($d);
                }
            ),
            array(
                'db'        => 'created',
                'dt'        => 3,
                'formatter' => function( $d, $row ) {
                    return Date('d M Y', strtotime($d));
                }
            ),
            array(
                'db'        => 'created',
                'dt'        => 4,
                'formatter' => function( $d, $row ) {
                    return Date('H:i', strtotime($d));
                }
            ),
            array( 'db' => 'user_name',     'dt' => 5 ),
            array( 'db' => 'user_email',     'dt' => 6 ),
            array(
                'db'        => 'id',
                'dt'        => 7,
                'formatter' => function( $d, $row ) {
                    return '<a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="'.$d.'">Delete</a>';
                }
            ),
        );
        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        include APPPATH . 'third_party/datatables/ssp.php';   
        $result = SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns );
       
        echo json_encode(
           $result 
        );
        die;
        /*
        $this -> load -> library('Datatable', array('model' => 'abandon_dt', 'rowIdCol' => 'a.id'));
		
	   $jsonArray = $this -> datatable -> datatableJson(array(
            'status' => 'boolean',
            'date'   => 'date',
            'price'  => 'currency',
            'id'     => 'edit',
            'image'  => 'image'
        ));
                
                
        $this -> output -> set_header("Pragma: no-cache");
        $this -> output -> set_header("Cache-Control: no-store, no-cache");
        $this -> output -> set_content_type('application/json') -> set_output(json_encode($jsonArray));*/
    }
    
    public function delete($id){
        $result = $this->abandon_model->delete($id);
        if($result){
            showFlash('Cart item removed successfully');
            redirect('admin/abandoncart');
        }
        else{
            showFlash('Sorry! Unable to remove cart item', 'danger');
            redirect('admin/abandoncart');
        }
    }
    
    public function send_email(){
        $emails = $this->abandon_model->get_distinct_emails();
        foreach ($emails as $email){
            $from_email = $this->config->item('store_email'); 
            $to_email   = $email; 
            //Load email library 
            $this->load->library('email'); 

            $this->email->from($from_email, 'POSEcom | '.$this->config->item('store_name')); 
            $this->email->to($to_email);
            $this->email->subject('Your cart is saved.'); 
            $this->email->message($this->config->item('abandoned_email')); 
            $this->email->send();
            
        }
        die(json_encode (array('success' => 1)));
    }
}