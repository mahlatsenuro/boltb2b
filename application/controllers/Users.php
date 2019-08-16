<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends App_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index(){
       	$this->page_title       = 'Login';
       	$validate	= $this->validateUserLogin();
       	if($validate){
       		$remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)){
                $path = 'products';
            }
            else{
                $this->session->set_flashdata('app_error', $this->ion_auth->errors());
                $path = 'login';
            }
            redirect($path);
       	}
       	$this->render_page('users/login', array('test' => 'test'));
    }

    function validateUserLogin(){
    	if($_POST){
	    	$this->form_validation->set_rules('identity', 'Email', 'required');
	        $this->form_validation->set_rules('password', 'Password', 'required');;
	        return $this->form_validation->run();
        }
        return FALSE;
    }

}
