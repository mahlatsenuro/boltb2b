<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Orders extends App_Controller
{   
    public function __construct(){
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("orders_model");
        $this->admins_only();
        
    }
    public function index(){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
          
        $orders              =     $this->orders_model->get_brief_orders();
        $this->render_page('orders/index', array( 'orders' => $orders ));
    }
    public function details($order_id=NULL){
        $this->page_title    = 'Order details';
        $this->assets_css    = array();  
        $this->assets_js     = array();  
          
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin() || !is_numeric($order_id)){
                redirect('admin/orders');
        }
        $order_details        =     $this->orders_model->get_full_data($order_id);
        if(!$order_details){
            redirect('admin/orders');die;
        } 
        $formSubmit = $this->input->post('submitForm');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('transaction_id', 'Transaction Id', 'xss_clean');
        if ($this->form_validation->run() == true){
            
            $result  = $this->orders_model->update_status($order_id);
            $user_id = $this->ion_auth->get_user_id();
            $user    = $this->ion_auth_model->user($user_id)->row();
            
            if( $result ){
                
                $data = array(
                    'user'     => $user,
                    'total'    => formatNumber( $order_details[0]->oprice),
                    'shipping' => $order_details[0]->pos_shipping_price, 
                    'order_id' => $order_details[0]->order_reference,
                    'user_id'  => $user_id,    
                    'products' => $order_details
                );
                 
                //$message = $this->load->view($this->config->item('email_templates', 'ion_auth').'admin_payment.tpl.php', $data, true);
                //$this->email->clear();
                //$this->email->from($this->config->item('store_email'), $this->config->item('store_name'));
                //$this->email->to($user->email);
                //$this->email->cc($this->config->item('store_email'));
                //$this->email->subject($this->config->item('store_name') . ' - Payment confirmation');
                //$this->email->message($message);
                //$this->email->send();
                showFlash('Status modified.');
                if($formSubmit == 'formSaveClose')
                    redirect( site_url( 'admin/orders/' ) ); 
                else
                    redirect( site_url( 'admin/orders/details/'.$order_id ) ); 
                
            }
            else{
                showFlash('Sorry! Unable to modify', 'danger');
                redirect('admin/orders/details/'.$order_id);
            }
        }
           
        $this->render_page('orders/details', array( 'orders' => $order_details ));
    }
    
    public function remove($order_id){
        if(!is_numeric($order_id)){
            redirect('admin/orders');
            die;
        }
        $this->orders_model->delete_order($order_id);
        showFlash('Order removed successfully.');
        redirect('admin/orders/');
    }
}