<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */
class Dashboard extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("dashboard_model");
    }

    public function index() {
        redirect('admin/login');
    }

    public function home(){
        $this->admins_only();
        $this->page_title           = 'Admin';
        $this->assets_css           = array( 'dataTables.bootstrap.css', 'style_1.css', 'morris.css' );  
        $this->assets_js            = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js', 'hisrc.js', 'raphael-2.1.0.min.js' ); 
        
        $data                       = array();
        $data['total_revenue']      = $this->dashboard_model->total_revenue();
        $data['products_sold']      = $this->dashboard_model->products_sold();
        $data['products_todeliver'] = $this->dashboard_model->products_todeliver();
        $data['total_customers']    = $this->dashboard_model->total_customers();
        //$this->load->library('POSReportico');  
        $this->render_page('dashboard/index', $data);
    }
    /*
     * @method login for user login
     */
    public function login($path = '')
    {  
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
           redirect('admin/home', 'refresh');
        }
        $this->template->set_layout('login');
        $this->body_class[]     = 'login';
        $this->page_title       = 'Please sign in';
        $this->current_section  = 'login';

        $this->form_validation->set_rules('identity', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true)
        { 
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            { 
                if (empty($path))
                    redirect('admin/home');
                else
                    redirect ($path);
            }
            else
            { 
                $this->session->set_flashdata('app_error', $this->ion_auth->errors());
                redirect('admin/login');
            }
        }
        else
        {  
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $data['message']  = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $data['identity'] = array('name' => 'identity',
                'id'          => 'identity',
                'type'        => 'email',
                'value'       => $this->form_validation->set_value('identity'),
                'class'       => 'textfield',
                'placeholder' => 'Username',
                'required'    => ''
            );
            $data['password'] = array('name' => 'password',
                'id'          => 'password',
                'type'        => 'password',
                'class'       => 'textfield',
                'placeholder' => 'Password',
                'required'    => ''  
            );
            $this->render_page('dashboard/login', $data);
        }
    }

    public function logout()
    {
        // log the user out
        $logout = $this->ion_auth->logout();
        //$this->session->set_flashdata('app_success', 'You have logged out successfully!');
        // redirect them back to the login page
        redirect('admin/login');
    }

    public function area(){
        $data   = $this->dashboard_model->get_monthwise_data();   
        $result = $output = array();
        
        if(is_array($data) && count($data) > 0){
            foreach ($data as $d){
                $result['y'] = $d->name.' - '.$d->year;
                $result['a'] = $d->users;
                $result['b'] = $d->price;

                $output[] = $result;
            }
        }
        echo json_encode($output);
        die;
    }
    
    public function abandond(){
        $data   = $this->dashboard_model->get_abandont_monthwise();   
        $result = $output = array();
        
        if(is_array($data) && count($data) > 0){
            foreach ($data as $d){
                $result['y'] = $d->name.' - '.$d->year;
                $result['a'] = $d->users;
                $result['b'] = number_format($d->price, 2,",",".");

                $output[] = $result;
            }
        }
        echo json_encode($output);
        die;
    }

    public function line(){
        
        $data   = $this->dashboard_model->get_monthwise_products();   
        $result = $output = array();
        
        if(is_array($data) && count($data) > 0){
            foreach ($data as $d){
                $result['y'] = $d->name.' - '.$d->year;
                $result['b'] = $d->price;

                $output[] = $result;
            }
        }
        echo json_encode($output);
        die;
    }
}    