<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Address extends App_Controller
{
    
    public $oldname;
    public $collivery;

    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("address_model");
        //$this->admins_only();
        $this->admins_only(); 
        include APPPATH . 'third_party/collivery_client/src/Mds/Collivery.php'; 
    }
    
    public function index()
    {
        $address = $this->address_model->get_collect_from_address();
        $this->collivery = new Collivery( $this->config->item('collivery_config') );
        
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'parselyjs.js' );  
        
        
        
        if (!$address)
        {
            $id     = '';
            $action = 'Create';
        }
        else 
        {
            $id     = $address->id;
            $action = 'Update';
        }
        
        $this->form_validation->set_rules('town', 'Town Name', 'trim|required|integer');
        $this->form_validation->set_rules('type', 'Location type', 'trim|integer|required');
        $this->form_validation->set_rules('suburb', 'Suburb', 'trim|integer|required');
        $this->form_validation->set_rules('company_name', 'Company', 'trim|min_length[3]|max_length[100]|required');
        $this->form_validation->set_rules('street', 'Street', 'trim|min_length[3]|max_length[150]|required');
        $this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|min_length[3]|max_length[20]|required');
        $this->form_validation->set_rules('full_name', 'Full name', 'trim|min_length[3]|max_length[100]|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|min_length[3]|max_length[20]|required');
        $this->form_validation->set_rules('cellphone', 'Cell', 'trim|min_length[3]|max_length[20]|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|min_length[3]|max_length[100]|valid_email|required');
        $this->form_validation->set_rules('free_delivery_above', 'Free delivery', 'trim|integer');        
        
        if ($this->form_validation->run() == true)
        { 
            $data = array();
            
            $data['company_name']   = $this->input->post('company_name');
            $data['street']         = $this->input->post('street');
            
            $data['location_type']  = $this->input->post('type');
            $data['suburb_id']      = $this->input->post('suburb');
            $data['town_id']        = $this->input->post('town');
            $data['zip_code']       = $this->input->post('zip_code');
            $data['full_name']      = $this->input->post('full_name');
            
            $data['phone']          = $this->input->post('phone');
            $data['cellphone']      = $this->input->post('cellphone');
            $data['email']          = $this->input->post('email');
            
            
            $collivery = $this->collivery->addAddress( $data );
            if( $collivery )
            {
                $data['address_id'] = $collivery['address_id'];
                $data['contact_id'] = $collivery['contact_id'];
                $data['free_delivery_above'] = $this->input->post('free_delivery_above');
                
                $result = $this->address_model->create_new_deliver_from($id, $data);               
                if ($result)
                {
                    $this->session->set_flashdata('app_success', 'The deliver from address '.strtolower($title).'d successfully!' );
                    redirect( site_url( 'admin/address' ) ); 
                }
                 else
                {
                    $this->session->set_flashdata('app_error', 'Sorry! Unable to '.strtolower($title).' deliver from address');
                    redirect(site_url( 'admin/address'));
                }
            }
            else
            {
                $this->session->set_flashdata('app_error', 'Sorry! Unable to '.strtolower($title).' deliver from address');
                redirect(site_url( 'admin/address'));
            }
            
        }
        else
        {      
        
            $towns          = $this->collivery->getTowns();
            $location_types = $this->collivery->getLocationTypes();

            $towns          = array('' => '--SELECT--') + $towns;

            $data = array(
                'current'        => 'address', 
                'head_title'     => $action,
                'address'        => $address,
                "towns"          => $towns,
                "types"          => $location_types,
                "suburbs"        => array( '' => '--SELECT--'),
                "company_name"   => array(
                    'name'                          => 'company_name',
                    'id'                            => 'company_name',
                    'type'                          => 'text',
                    'value'                         => isset($address->company_name) ? $address->company_name : $this->form_validation->set_value('company_name'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Company name',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "street"        => array(
                    'name'                          => 'street',
                    'id'                            => 'street',
                    'type'                          => 'text',
                    'value'                         => isset($address->street) ? $address->street : $this->form_validation->set_value('street'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Street( Street name and house number )',
                    'data-parsley-length'           => '[3, 150]',
                    'required'                      => '',
                ),
                "zip_code"        => array(
                    'name'                          => 'zip_code',
                    'id'                            => 'zip_code',
                    'type'                          => 'text',
                    'value'                         => isset($address->zip_code) ? $address->zip_code : $this->form_validation->set_value('zip_code'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Zip code',
                    'data-parsley-length'           => '[3, 20]',
                    'required'                      => '',
                ),
                "full_name"        => array(
                    'name'                          => 'full_name',
                    'id'                            => 'full_name',
                    'type'                          => 'text',
                    'value'                         => isset($address->full_name) ? $address->full_name : $this->form_validation->set_value('full_name'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Full name',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "phone"        => array(
                    'name'                          => 'phone',
                    'id'                            => 'phone',
                    'type'                          => 'text',
                    'value'                         => isset($address->phone) ? $address->phone : $this->form_validation->set_value('phone'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Phone',
                    'data-parsley-length'           => '[3, 20]',
                    'required'                      => '',
                ),
                "cellphone"        => array(
                    'name'                          => 'cellphone',
                    'id'                            => 'cellphone',
                    'type'                          => 'text',
                    'value'                         => isset($address->cellphone) ? $address->cellphone : $this->form_validation->set_value('cellphone'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Cell no',
                    'data-parsley-length'           => '[3, 20]',
                    'required'                      => '',
                ),
                "email"        => array(
                    'name'                          => 'email',
                    'id'                            => 'email',
                    'type'                          => 'email',
                    'value'                         => isset($address->email) ? $address->email : $this->form_validation->set_value('email'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Full name',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "free_delivery_above"        => array(
                    'name'                          => 'free_delivery_above',
                    'id'                            => 'free_delivery_above',
                    'type'                          => 'text',
                    'value'                         => isset($address->free_delivery_above) ? $address->free_delivery_above : $this->form_validation->set_value('free_delivery_above'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Put 0 if free delivery leave empty if no rules',
                ),
            );

            $this->render_page('address/index', $data);
        }    
    }
    
    
    public function get_suburb($town_id, $suburb = '')
    {
        if (!$this->input->is_ajax_request()) 
                show_404 ();
        
        $this->collivery = new Collivery( $this->config->item('collivery_config') );
        
        $return = '<option value="">--SELECT--</option>';
        if (!empty($town_id))
            $suburbs = $this->collivery->getSuburbs($town_id);  
        
        foreach ($suburbs as $key => $subs)
        {
            
            
            $selected = ($key == $suburb) ? 'selected' : 'nottt'; 
            $return  .= '<option value="'.$key.'" '.$selected.'>'.$subs.'</option>';
        }
        
        echo $return; die;
    }
}    