<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Users extends App_Controller
{
    public $oldemail;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("users_model");
    }

    public function index(){ 
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        $users               =     $this->users_model->get_users_with_order_count();
        $this->render_page('users/index', array( 'users' => $users ));
    }
    
 
    public function delete($id)
    {
        $this->admins_only();
        if( empty($id) || !is_numeric($id) )
            show_404 ();
        $result = $this->users_model->delete($id); 
        $result ? showFlash('User removed successfully!') : showFlash('Sorry! Unable to delete user!', 'danger');
        redirect('admin/users');  
    }
    
    function create_user(){
        $this->admins_only();
        $this->page_title    = 'Create user';
        $this->assets_css    = array();  
        $this->assets_js     = array();  
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[3]');
        $this->form_validation->set_rules('company', 'Company', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password confirm', 'required');
        if ($this->form_validation->run() == true){
                $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
                $email    = $this->input->post('email');
                $password = $this->input->post('password');
                
                $additional_data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name'  => $this->input->post('last_name'),
                        'company'    => $this->input->post('company'),
                        'phone'      => $this->input->post('phone'),
                );
        }
        
        if ($this->form_validation->run() == true && $user = $this->ion_auth->register($username, $password, $email, $additional_data))
        {
            $activation = $this->ion_auth->activate($user['id']);
            showFlash('message', 'User added successfully!');
            redirect("admin/users");
        }
        else
        { 
            $this->data['first_name'] = array(
                    'name'  => 'first_name',
                    'id'    => 'first_name',
                    'class' => 'form-control',
                    'required' => '',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                    'name'  => 'last_name',
                    'class' => 'form-control',
                    'required' => '',
                    'id'    => 'last_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['email'] = array(
                    'name'  => 'email',
                    'id'    => 'email',
                    'class' => 'form-control',
                    'required' => '',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                    'name'  => 'company',
                    'id'    => 'company',
                    'class' => 'form-control',
                    'required' => '',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                    'name'  => 'phone',
                    'id'    => 'phone',
                    'class' => 'form-control',
                    'required' => '',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                    'name'  => 'password',
                    'id'    => 'password',
                    'class' => 'form-control',
                    'required' => '',
                    'type'  => 'password',
                    'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                    'name'  => 'password_confirm',
                    'id'    => 'password_confirm',
                    'class' => 'form-control',
                    'required' => '',
                    'type'  => 'password',
                    'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->render_page('users/create_user', $this->data);
        }
    }
    
    function edit_user($id){
        $this->admins_only();
        $this->page_title    = 'Edit user';
        $this->assets_css    = array();  
        $this->assets_js     = array();  
        
          
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()){
                redirect('admin/users');
        }
        $user           = $this->ion_auth->user($id)->row();
        $groups         =   $this->ion_auth->groups()->result_array();
        $currentGroups  = $this->ion_auth->get_users_groups($id)->result();

        $this->form_validation->set_rules('first_name', "First name", 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[3]');
        $this->form_validation->set_rules('company', 'Company', 'required');
        $this->form_validation->set_rules('groups', 'Groups', 'xss_clean');

        if (isset($_POST) && !empty($_POST)){
                $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name'  => $this->input->post('last_name'),
                        'company'    => $this->input->post('company'),
                        'phone'      => $this->input->post('phone'),
                        'email'      => $this->input->post('email')
                );
                $groupData = $this->input->post('groups');
                if (isset($groupData) && !empty($groupData)) {
                        $this->ion_auth->remove_from_group('', $id);
                        foreach ($groupData as $grp) {
                                $this->ion_auth->add_to_group($grp, $id);
                        }

                }
                //update the password if it was posted
                if ($this->input->post('password')){
                        $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                        $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
                        $data['password'] = $this->input->post('password');
                }

                if ($this->form_validation->run() === TRUE){
                        $this->ion_auth->update($user->id, $data);
                        showFlash("User details updated");
                        redirect("admin/users/edit_user/".$id);
                }
        }

        $this->data['user']   = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;
        $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'class' => 'form-control',
                'required' => '',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'class' => 'form-control',
                'required' => '',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'class' => 'form-control',
                'required' => '',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone1',
                'class' => 'form-control',
                'required' => '',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone', $user->phone),
        );
         $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'class' => 'form-control',
                'required' => '',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email', $user->email),
        );
        $this->data['password'] = array(
                'name' => 'password',
                'id'   => 'password',
                'type' => 'password',
                'class' => 'form-control',
        );
        $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id'   => 'password_confirm',
                'type' => 'password',
                'class' => 'form-control',
        );

        $this->render_page('users/edit_user', $this->data);
    }
}
