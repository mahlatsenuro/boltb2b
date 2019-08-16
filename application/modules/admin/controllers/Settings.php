<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Settings extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("settings_model");
        $this->admins_only(); 
    }
    
    public function index()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array('bootstrap-editable.css');  
        $this->assets_js     = array( 'ckeditor.js', 'parsely-remote.min.js', 'bootstrap-editable.min.js' );
        $this->form_validation->set_rules('store_name', 'Store name', 'trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('store_owner', 'Store owner', 'trim|required|min_length[3]|max_length[70]');
        $this->form_validation->set_rules('store_email', 'Store email', 'trim|valid_email|required');
        $this->form_validation->set_rules('password', 'Password', 'trim');
        $this->form_validation->set_rules('phone_number', 'Store contact number', 'trim|required');
        $this->form_validation->set_rules('store_address', 'Physical address', 'trim|min_length[3]');
        $this->form_validation->set_rules('mygate_merchant_id', 'Merchant number', 'trim|required|min_length[1]|max_length[36]');
        $this->form_validation->set_rules('mygate_application_id', 'Merchant application id', 'trim|required|min_length[1]|max_length[36]');
        
        $this->form_validation->set_rules('vat_percentage', 'Vat percentage', 'trim|is_natural');
        $this->form_validation->set_rules('show_price', 'Show price', 'trim|integer');
        $this->form_validation->set_rules('use_catalogue', 'Product weight', 'trim');
        $this->form_validation->set_rules('payment_method[]', 'Payment method', 'trim|required');
        $this->form_validation->set_rules('link1', 'Link 1', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('link2', 'Link 2', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('link3', 'Link 3', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('link4', 'Link 4', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('link5', 'Link 5', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('link6', 'Link 6', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('link7', 'Link 7', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('link8', 'Link 8', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('facebook_url', 'Facebook url', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('twitter_url', 'Twitter url', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('google_url', 'Google url', 'trim|callback_valid_url_format');
        $this->form_validation->set_rules('meta_title', 'Meta title', 'trim');
        $this->form_validation->set_rules('meta_description', 'Meta description', 'trim');
        $this->form_validation->set_rules('keywords', 'Meta keywords', 'trim');
        
        if ($this->form_validation->run() == true)
        {           
            if(!isset($_FILES['images']))
                $result = true;
            else
            $return = uploadMultiFiles($_FILES['images'], 'assets/common/img/');
            $result               = array();
            
            foreach ($return as $key => $upload_result) {
                if($upload_result['status']){
                    $result[$key] = $upload_result['data']['file_name'];
                }
            }
            $formSubmit = $this->input->post('submitForm');
            if(is_array($result))
                $images['mygate_live_transaction'] = $this->input->post('mygate_live_transaction') ? 1 : 0;
            else{
                $result = array();
                $result['mygate_live_transaction'] = $this->input->post('mygate_live_transaction') ? 1 : 0;
            }
            
            $result = $this->settings_model->add_settings($result);
            $this->settings_model->update_password();
            $result ? showFlash('Settings updated successfully') : showFlash('Sorry! Unable to save settings.'); 

            if($formSubmit == 'formSaveClose')
                redirect('admin');
            else 
                redirect('admin/settings');
        }
        
        
        $this->render_page('settings/index', array('current' => 'basic'));
    }
    
    public function remove_banner($banner_id)
    {
        if(!empty($banner_id))
        {
            $banners = array(1 => 'banner1', 2 => 'banner2', 3 => 'banner3', 4 => 'banner4', 5 => 'banner5');
            
            if(isset($banners[$banner_id]))
                $result  = $this->settings_model->remove_banner($banners[$banner_id]);
            else
                $result = FALSE;
            
            if($result){
                showFlash('Banner removed successfully' );
                redirect( 'admin/settings' );
            }
            else
            {
                showFlash('Sorry! Unable to remove banner!', 'danger');
                redirect( 'admin/settings' );
            }
        }
        else
            show_404 ();
    }

    public function coupon_code(){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        
          
        $coupons             = $this->settings_model->get_coupons();       
        $this->render_page('settings/coupon_code', array('coupons' => $coupons));
    }
    
    public function new_coupon($id = ""){
        $title               = 'Create';
        if (!empty($id))
        {
            $title           = 'Update';
            $coupon          = $this->settings_model->get_coupons($id);          
            if (!$coupon)
                show_404 ();
        }
        
        $this->assets_css    = array('jquery-ui.css');  
        $this->assets_js     = array('jquery-ui.min.js');
        
        $this->page_title    = 'Admin'; 
        
        $this->form_validation->set_rules('code', 'Coupon code', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('start_date', 'Start date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'end date', 'trim|required');
        $this->form_validation->set_rules('offer', 'Offer', 'trim|integer|required');
        $this->form_validation->set_rules('offer_type', 'Offer type', 'trim|required');
        $this->form_validation->set_rules('coupon_id', 'Coupon id', 'trim|integer');
        
        if ($this->form_validation->run() == true)
        { 
            $result = $this->settings_model->create_coupon($id);
            if( $result)
            {
               showFlash('New coupon '.strtolower($title).'d successfully!' );
               redirect( site_url( 'admin/settings/coupon_code' ) ); 
            }
            else
            {
                showFlash('Sorry! Unable to '.strtolower($title).' coupon', 'danger');
                redirect(site_url( 'admin/settings/new_coupon/'.$id));
            }
        }
        else
        {    
            $data = array(
                        "head_title"      => $title,
                        "code"  => array(
                            'name'                          => 'code',
                            'id'                            => 'code',
                            'type'                          => 'text',
                            'value'                         => isset($coupon->code) ? $coupon->code : $this->form_validation->set_value('code'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Coupon code',
                            'required'                      => '',
                        ),
                        "start_date"    => array(
                            'name'                          => 'start_date',
                            'id'                            => 'start_date',
                            'type'                          => 'text',
                            'value'                         => isset($coupon->start_date) ? $coupon->start_date : $this->form_validation->set_value('start_date'),
                            'class'                         => 'form-control',
                            'required'                      => '',
                        ),
                        "end_date"      => array(
                            'name'                          => 'end_date',
                            'id'                            => 'end_date',
                            'type'                          => 'text',
                            'value'                         => isset($coupon->end_date) ? $coupon->end_date : $this->form_validation->set_value('end_date'),
                            'class'                         => 'form-control',
                            'required'                      => '',
                        ),
                        "offer"      => array(
                            'name'                          => 'offer',
                            'id'                            => 'offer',
                            'type'                          => 'number',
                            'value'                         => isset($coupon->offer) ? $coupon->offer : $this->form_validation->set_value('offer'),
                            'class'                         => 'form-control',
                            'required'                      => '',
                        ),
                        "limit"      => array(
                            'name'                          => 'limit',
                            'id'                            => 'limit',
                            'type'                          => 'number',
                            'value'                         => isset($coupon->limit) ? $coupon->limit : $this->form_validation->set_value('limit'),
                            'class'                         => 'form-control',
                            'required'                      => '',
                        ),
                        'id'    => array( 'coupon_id' => $id ),
                        'offer_type' => isset($coupon->offer) ? $coupon->offer : $this->form_validation->set_value('offer')
                    );
        }
        $this->render_page('settings/coupon_new', $data );
    }
    
    public function delete_coupon($id=null)
    {
        if(empty($id))
            show_404();
        
        $result = $this->settings_model->remove_coupon($id);
        if($result)
        {
            showFlash('Coupon removed successfully!' );
            redirect('admin/settings/coupon_code'); die;
        }
        showFlash('Cannot remove coupon!', 'danger');
        redirect('admin/settings/coupon_code'); die;
    }
    
    
    public function address(){
        require_once APPPATH . 'third_party/collivery_client/src/Mds/Collivery.php';
        $this->collivery     = new Collivery( $this->config->item('collivery_config') );
        
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'parselyjs.js' );  
        
        
        $this->form_validation->set_rules('free_delivery', 'Free delivery', 'trim|required');
        if($this->input->post('free_delivery') == 'flat')
            $this->form_validation->set_rules('flat_rate_delivery', 'Flat rate', 'trim|numeric|required');
        
        $data['free_delivery_above'] = 0;    
        if($this->input->post('free_delivery_above')){
           $this->form_validation->set_rules('free_rate_above', 'Price above rate', 'trim|numeric|required');
           $data['free_delivery_above'] = 1;
        }
        
        $this->form_validation->set_rules('courier_service', 'Courier service', 'trim|required');
        
        if ($this->form_validation->run() == true){ 
            $formSubmit             = $this->input->post('submitForm');
            $data['free_delivery']  = $this->input->post('free_delivery');  
            $result                 = $this->settings_model->add_settings($data);

            if ($result){ 
                if($this->input->post('courier_service') == 'courierguy_delivery'){
                    require_once APPPATH . 'third_party/courier_guy/service.php';
                    $courrierGuy     = new CourierGuy($this->config->item('delivery_courierguy_id'), $this->config->item('delivery_courierguy_password')); 
                    $places          = $courrierGuy->getPlace($this->input->post('delivery_courierguy_zip_code'));

                    if( $places['status'] )
                    {
                        $items['delivery_courierguy_place']         = $places['place'];
                        $items['delivery_courierguy_town']          = $places['town'];
                        $items['delivery_courierguy_id']            = $this->input->post('delivery_collivery_company_name');

                        $result = $this->settings_model->add_settings($items);         
                        if($result){
                            showFlash('Delivery details modified successfully!' );
                            if($formSubmit == 'formSaveClose')
                                redirect('admin'); 
                            else 
                                redirect('admin/settings/address'); 
                        }
                        else{
                            showFlash('Sorry! Unable to update delivery details', 'danger');
                            redirect(site_url( 'admin/address'));
                        }
                    }
                }
                if($this->input->post('courier_service') == 'collivery_delivery'){
                    $data                   = $items = array();                  
                    $data['company_name']   = $this->input->post('delivery_collivery_company_name');
                    $data['street']         = $this->input->post('delivery_collivery_street');
                    $data['location_type']  = $this->input->post('delivery_collivery_type');
                    $data['suburb_id']      = $this->input->post('delivery_collivery_suburb');
                    $data['town_id']        = $this->input->post('delivery_collivery_town');
                    $data['zip_code']       = $this->input->post('delivery_collivery_zip_code');
                    $data['full_name']      = $this->input->post('delivery_collivery_full_name');
                    $data['phone']          = $this->input->post('delivery_collivery_phone');
                    $data['cellphone']      = $this->input->post('delivery_collivery_cellphone');
                    $data['email']          = $this->input->post('delivery_collivery_email');
                    $collivery              = $this->collivery->addAddress( $data );
                    
                    if( $collivery )
                    {
                        $items['delivery_collivery_address_id']          = $collivery['address_id'];
                        $items['delivery_collivery_contact_id']          = $collivery['contact_id'];

                        $result = $this->settings_model->add_settings($items);         
                        if($result){
                            showFlash('Delivery details modified successfully!' );
                            if($formSubmit == 'formSaveClose')
                                redirect('admin'); 
                            else 
                                redirect('admin/settings/address'); 
                        }
                        else{
                            showFlash('Sorry! Unable to update delivery details', 'danger');
                            redirect(site_url( 'admin/settings/address'));
                        }
                    }
                    else{
                        showFlash('Sorry! Unable to update delivery details', 'danger');
                        redirect(site_url( 'admin/settings/address'));
                    }
                }
                else{
                    showFlash('Delivery details modified successfully!' );
                    if($formSubmit == 'formSaveClose')
                        redirect('admin'); 
                    else 
                        redirect('admin/settings/address'); 
                }
            }
            else{
                showFlash('Sorry! Unable to update delivey details', 'danger');
                redirect(site_url( 'admin/settings/address'));
            }  
        }
        else{   
            $town_list      = $this->collivery->getTowns(); 
            $suburbs        = $this->config->item('delivery_collivery_town') ? $this->collivery->getSuburbs($this->config->item('delivery_collivery_town')) : array(); 
            
            $location_types = $this->collivery->getLocationTypes();
            
            $data = array(
                'current'        => 'address', 
                "towns"          => $town_list,
                "types"          => $location_types,
                "suburbs"        => $suburbs,
                "company_name"   => array(
                    'name'                          => 'delivery_collivery_company_name',
                    'id'                            => 'company_name',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_collivery_company_name') ? $this->config->item('delivery_collivery_company_name') : $this->form_validation->set_value('delivery_collivery_company_name'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Company name',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "collivery_email"   => array(
                    'name'                          => 'delivery_collivery_id',
                    'id'                            => 'delivery_collivery_id',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_collivery_id') ? $this->config->item('delivery_collivery_id') : $this->form_validation->set_value('delivery_collivery_id'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Collivery ID(Email)',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "collivery_password"   => array(
                    'name'                          => 'delivery_collivery_password',
                    'id'                            => 'delivery_collivery_password',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_collivery_password') ? $this->config->item('delivery_collivery_password') : $this->form_validation->set_value('delivery_collivery_password'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Collivery password',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "street"        => array(
                    'name'                          => 'delivery_collivery_street',
                    'id'                            => 'street',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_collivery_street') ? $this->config->item('delivery_collivery_street') : $this->form_validation->set_value('delivery_collivery_street'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Street( Street name and house number )',
                    'data-parsley-length'           => '[3, 150]',
                    'required'                      => '',
                ),
                "zip_code"        => array(
                    'name'                          => 'delivery_collivery_zip_code',
                    'id'                            => 'zip_code',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_collivery_zip_code') ? $this->config->item('delivery_collivery_zip_code') : $this->form_validation->set_value('delivery_collivery_zip_code'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Zip code',
                    'data-parsley-length'           => '[3, 20]',
                    'required'                      => '',
                ),
                "full_name"        => array(
                    'name'                          => 'delivery_collivery_full_name',
                    'id'                            => 'full_name',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_collivery_full_name') ? $this->config->item('delivery_collivery_full_name') : $this->form_validation->set_value('delivery_collivery_full_name'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Full name',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "phone"        => array(
                    'name'                          => 'delivery_collivery_phone',
                    'id'                            => 'phone',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_collivery_phone') ? $this->config->item('delivery_collivery_phone') : $this->form_validation->set_value('delivery_collivery_phone'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Phone',
                    'data-parsley-length'           => '[3, 20]',
                    'required'                      => '',
                ),
                "cellphone"        => array(
                    'name'                          => 'delivery_collivery_cellphone',
                    'id'                            => 'cellphone',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_collivery_cellphone') ? $this->config->item('delivery_collivery_cellphone') : $this->form_validation->set_value('delivery_collivery_cellphone'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Cell no',
                    'data-parsley-length'           => '[3, 20]',
                    'required'                      => '',
                ),
                "email"        => array(
                    'name'                          => 'delivery_collivery_email',
                    'id'                            => 'email',
                    'type'                          => 'email',
                    'value'                         => $this->config->item('delivery_collivery_email') ? $this->config->item('delivery_collivery_email') : $this->form_validation->set_value('delivery_collivery_email'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Full name',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "delivery_courierguy_company_name"   => array(
                    'name'                          => 'delivery_courierguy_company_name',
                    'id'                            => 'company_name',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_company_name') ? $this->config->item('delivery_courierguy_company_name') : $this->form_validation->set_value('delivery_courierguy_company_name'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Company name',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "delivery_courierguy_email"   => array(
                    'name'                          => 'delivery_courierguy_id',
                    'id'                            => 'delivery_courierguy_id',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_id') ? $this->config->item('delivery_courierguy_id') : $this->form_validation->set_value('delivery_courierguy_id'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Courier guy ID(Email)',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "delivery_courierguy_password"   => array(
                    'name'                          => 'delivery_courierguy_password',
                    'id'                            => 'delivery_courierguy_password',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_password') ? $this->config->item('delivery_courierguy_password') : $this->form_validation->set_value('delivery_courierguy_password'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Courier guy password',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "delivery_courierguy_street"        => array(
                    'name'                          => 'delivery_courierguy_street',
                    'id'                            => 'street',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_street') ? $this->config->item('delivery_courierguy_street') : $this->form_validation->set_value('delivery_courierguy_street'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Street( Street name and house number )',
                    'data-parsley-length'           => '[3, 150]',
                    'required'                      => '',
                ),
                "delivery_courierguy_zip_code"        => array(
                    'name'                          => 'delivery_courierguy_zip_code',
                    'id'                            => 'zip_code',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_zip_code') ? $this->config->item('delivery_courierguy_zip_code') : $this->form_validation->set_value('delivery_courierguy_zip_code'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Area code',
                    'data-parsley-length'           => '[3, 20]',
                    'required'                      => '',
                ),
                "delivery_courierguy_address_1"        => array(
                    'name'                          => 'delivery_courierguy_address1',
                    'id'                            => 'delivery_courierguy_address1',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_address1') ? $this->config->item('delivery_courierguy_address1') : $this->form_validation->set_value('delivery_courierguy_address1'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Street',
                    'data-parsley-length'           => '[3, 40]',
                    'required'                      => '',
                ),
                 "delivery_courierguy_address_2"        => array(
                    'name'                          => 'delivery_courierguy_address2',
                    'id'                            => 'delivery_courierguy_address2',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_address2') ? $this->config->item('delivery_courierguy_address2') : $this->form_validation->set_value('delivery_courierguy_address2'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'City',
                    'data-parsley-length'           => '[3, 40]',
                    'required'                      => '',
                ),
                "delivery_courierguy_address_3"        => array(
                    'name'                          => 'delivery_courierguy_address3',
                    'id'                            => 'delivery_courierguy_address3',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_address3') ? $this->config->item('delivery_courierguy_address3') : $this->form_validation->set_value('delivery_courierguy_address3'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Suburb',
                    'data-parsley-length'           => '[3, 40]',
                ),
                "delivery_courierguy_full_name"        => array(
                    'name'                          => 'delivery_courierguy_full_name',
                    'id'                            => 'full_name',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_full_name') ? $this->config->item('delivery_courierguy_full_name') : $this->form_validation->set_value('delivery_courierguy_full_name'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Full name',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                ),
                "delivery_courierguy_phone"        => array(
                    'name'                          => 'delivery_courierguy_phone',
                    'id'                            => 'phone',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_phone') ? $this->config->item('delivery_courierguy_phone') : $this->form_validation->set_value('delivery_courierguy_phone'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Phone',
                    'data-parsley-length'           => '[3, 20]',
                    'required'                      => '',
                ),
                "delivery_courierguy_cellphone"        => array(
                    'name'                          => 'delivery_courierguy_cellphone',
                    'id'                            => 'cellphone',
                    'type'                          => 'text',
                    'value'                         => $this->config->item('delivery_courierguy_cellphone') ? $this->config->item('delivery_courierguy_cellphone') : $this->form_validation->set_value('delivery_courierguy_cellphone'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Cell no',
                    'data-parsley-length'           => '[3, 20]',
                    'required'                      => '',
                ),
                "delivery_courierguy_email"        => array(
                    'name'                          => 'delivery_courierguy_email',
                    'id'                            => 'email',
                    'type'                          => 'email',
                    'value'                         => $this->config->item('delivery_courierguy_email') ? $this->config->item('delivery_courierguy_email') : $this->form_validation->set_value('delivery_courierguy_email'),
                    'class'                         => 'form-control',
                    'placeholder'                   => 'Full name',
                    'data-parsley-length'           => '[3, 100]',
                    'required'                      => '',
                )
            );
            $data['current']    = 'address';
            $this->render_page('settings/address', $data);
        }
    }

    public function product_images()
    {
        $this->load->library('form_validation');
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->form_validation->set_rules('checker', 'Checker', 'trim|required');
        if ($this->form_validation->run() == true){ 
            $config = array(
                'upload_path'   => FCPATH.'assets/products/img/uploads/',
                'allowed_types' => 'zip',
                'overwrite'     => TRUE,                       
            );

            $result = uploadFiles('images', 'assets/products/img/uploads/', $config);
            //jpg|gif|png|jpeg|zip
            $this->load->library('upload', $config);
            if ( !$result['status'])
            {
                showFlash('Images updation failed!', 'danger');
                redirect('admin/settings/product_images'); 
            }
            else
            {
                $data = array('upload_data' => $result['data']);                  
                $zip = new ZipArchive;
                $file = $data['upload_data']['full_path'];
                
                if($data['upload_data']['file_ext'] == '.zip')
                {
                    chmod($file,0777);
                    if ($zip->open($file) === TRUE) {
                            $zip->extractTo(FCPATH.'assets/products/img/uploads/');
                            $zip->close();
                            $images       = glob(FCPATH.'assets/products/img/uploads/'."*.{jpg,png,gif,jpeg,JPG,JPEG,PNG,GIF}", GLOB_BRACE); 
                            $added_images = array();
                            foreach($images as $image) {                                
                                
                                $parts          = explode('/', $image);
                                $file_details   = explode("__", end($parts));
                                $image_name     = $file_details[0];
                                $name_parts     = explode(".", $image_name);
                                $product_code   = $name_parts[0]; 
                                $product        = $this->settings_model->get_products_by_code($product_code);
                                if(!isset($product->id)){
                                    //unlink($image);
                                    //continue;
                                }
                                
                                //$this->settings_model->set_image($product->id, end($parts));
                                resizeImages($image);
                                unlink($image);
                                $added_images[] = $product->id;
                            }
                            unlink($file);
                            showFlash('Images updated successfully!' );
                            redirect( site_url( 'admin/settings/product_images' ) ); 
                    } else {
                        unlink($file);
                        showFlash('Images updation failed!', 'danger');
                        redirect( site_url( 'admin/settings/product_images' ) ); 
                    }
                }
                else{
                    resizeImages($image);
                    showFlash('Images updated successfully!' );
                    unlink($file);
                    redirect( site_url( 'admin/settings/product_images' ) ); 
                }
            }
        }
        $this->render_page('settings/product_images', array('current' => 'images'));
    }
    
    function valid_url_format($str){
         
        if(empty($str))
            return TRUE;
        $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
        if (!preg_match($pattern, $str)){
            $this->form_validation->set_message('valid_url_format', 'The URL you entered is not correctly formatted.');
            return FALSE;
        }
 
        return TRUE;
    }       
 
    // --------------------------------------------------------------------
     
 
    /**
     * Validates that a URL is accessible. Also takes ports into consideration. 
     * Note: If you see "php_network_getaddresses: getaddrinfo failed: nodename nor servname provided, or not known" 
     *          then you are having DNS resolution issues and need to fix Apache
     *
     * @access  public
     * @param   string
     * @return  string
     */
    function url_exists($url){                                   
        $url_data = parse_url($url); // scheme, host, port, path, query
        if(!fsockopen($url_data['host'], isset($url_data['port']) ? $url_data['port'] : 80)){
            $this->set_message('url_exists', 'The URL you entered is not accessible.');
            return FALSE;
        }               
         
        return TRUE;
    }  
    
    public function sync()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->render_page('settings/sync', array('current' => 'sync'));
    }
    
    public function style()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->form_validation->set_rules('keywords', 'Meta keywords', 'trim');
        
        if ($this->form_validation->run() == true)
        {        
            $formSubmit = $this->input->post('submitForm');
            $result = $this->settings_model->add_settings();

            showFlash('Settings updated successfully' );

            if($formSubmit == 'formSaveClose')
                redirect('admin');
            else 
                redirect( 'admin/settings/style' );
        }
        $this->render_page('settings/style', array('current' => 'style')); 
    }
    
    public function front_end()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->form_validation->set_rules('products_without_image', 'Product display without image', 'trim');
        
        if ($this->form_validation->run() == true)
        {        
            $formSubmit = $this->input->post('submitForm');
            $result = $this->settings_model->add_settings();

            showFlash('Settings updated successfully' );
            if($formSubmit == 'formSaveClose')
                redirect('admin');
            else 
                redirect( 'admin/settings/front_end' );
        }
        $this->render_page('settings/front_end', array('current' => 'front_end')); 
    }
    
    public function point_sale()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->form_validation->set_rules('micomp_host_address', 'Micomp host address', 'trim|required');
        $this->form_validation->set_rules('micomp_database', 'Micomp database', 'trim|required');
        $this->form_validation->set_rules('micomp_username', 'Micomp username', 'trim|required');
        $this->form_validation->set_rules('micomp_password', 'Micomp password', 'trim|required');
        $this->form_validation->set_rules('micomp_menu_level1', 'Micomp menu level 1', 'trim|required');
        $this->form_validation->set_rules('micomp_menu_level2', 'Micomp menu level 1', 'trim|required');
        $this->form_validation->set_rules('micomp_menu_level3', 'Micomp menu level 1', 'trim|required');
                
        if ($this->form_validation->run() == true)
        {        
            $formSubmit = $this->input->post('submitForm');
            $option     = $sync_options = array();
            if(!$this->input->post('posecom_posoption')){
                $option = array('posecom_posoption' => "");
            }
            
            if($this->input->post('schedule') !== FALSE){
                $scheduled_day   = $this->input->post('schedule_day');
                $schedule_hour   = $this->input->post('schedule_hour');
                $schedule_min    = $this->input->post('schedule_min');
                $schedule_hour2  = $this->input->post('schedule_hour2');
                $schedule_min2   = $this->input->post('schedule_min2');
                $sync_options = array(
                    'schedule_day'  => isset($scheduled_day[$this->input->post('schedule')]) ? $scheduled_day[$this->input->post('schedule')] : "",
                    'schedule_hour' => isset($schedule_hour[$this->input->post('schedule')]) ? $schedule_hour[$this->input->post('schedule')] : "",
                    'schedule_min'  => isset($schedule_min[$this->input->post('schedule')]) ? $schedule_min[$this->input->post('schedule')] : "",
                    'schedule_hour2'  => isset($schedule_hour2[$this->input->post('schedule')]) ? $schedule_hour2[$this->input->post('schedule')] : "",
                    'schedule_min2'  => isset($schedule_min2[$this->input->post('schedule')]) ? $schedule_min2[$this->input->post('schedule')] : "",
                    );
            }
            
            $options = array_merge($option, $sync_options);
            $result = $this->settings_model->add_settings($options);
            showFlash('Settings updated successfully' );
            if($formSubmit == 'formSaveClose')
                redirect('admin');
            else 
                redirect( 'admin/settings/point_sale' );
        }
        $this->render_page('settings/point_sale', array('current' => 'point', 'subs' => 'micomp')); 
    }
    
    public function shop_keeper()
    {
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->form_validation->set_rules('shopkeeper_json_creation_url', 'Json creation URL', 'trim|required');
        $this->form_validation->set_rules('shopkeeper_json_url', 'Json url', 'trim|required');
        $this->form_validation->set_rules('shopkeeper_username', 'User name', 'trim|required');      
        $this->form_validation->set_rules('shopkeeper_password', 'Password', 'trim|required');
                
        if ($this->form_validation->run() == true)
        {        
            $formSubmit = $this->input-$formSubmit = $this->input->post('submitForm');
            $option     = $sync_options = array();
            if(!$this->input->post('posecom_posoption')){
                $option = array('posecom_posoption' => "");
            }
            
            if($this->input->post('schedule') !== FALSE){
                $scheduled_day   = $this->input->post('schedule_day');
                $schedule_hour   = $this->input->post('schedule_hour');
                $schedule_min    = $this->input->post('schedule_min');
                $schedule_hour2  = $this->input->post('schedule_hour2');
                $schedule_min2   = $this->input->post('schedule_min2');
                
                $sync_options = array(
                    'schedule_day'  => isset($scheduled_day[$this->input->post('schedule')]) ? $scheduled_day[$this->input->post('schedule')] : "",
                    'schedule_hour' => isset($schedule_hour[$this->input->post('schedule')]) ? $schedule_hour[$this->input->post('schedule')] : "",
                    'schedule_min'  => isset($schedule_min[$this->input->post('schedule')]) ? $schedule_min[$this->input->post('schedule')] : "",
                    'schedule_hour2'  => isset($schedule_hour2[$this->input->post('schedule')]) ? $schedule_hour2[$this->input->post('schedule')] : "",
                    'schedule_min2'  => isset($schedule_min2[$this->input->post('schedule')]) ? $schedule_min2[$this->input->post('schedule')] : "",
                    );
            }
            
            $options = array_merge($option, $sync_options);
            $result = $this->settings_model->add_settings($options);
            showFlash('Settings updated successfully' );
            if($formSubmit == 'formSaveClose')
                redirect('admin');
            else 
                redirect( 'admin/settings/shop_keeper' );
        }
        $this->render_page('settings/shop_keeper', array('current' => 'point', 'subs' => 'shop')); 
    }
    
    public function posibolt(){
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->form_validation->set_rules('posibolt_url', 'Posibolt URL', 'trim|required');
        $this->form_validation->set_rules('posibolt_auth_username', 'Auth Username', 'trim|required');
        $this->form_validation->set_rules('posibolt_auth_password', 'Auth Password', 'trim|required');      
        $this->form_validation->set_rules('posibolt_password', 'Posibolt Password', 'trim|required');
        $this->form_validation->set_rules('posibolt_terminal', 'Terminal', 'trim|required');
        $this->form_validation->set_rules('posibolt_username', 'Posibolt Username', 'trim|required');
        
        if ($this->form_validation->run() == true)
        {        
            $formSubmit = $this->input-$formSubmit = $this->input->post('submitForm');
            $result     = $this->settings_model->add_settings();
            showFlash('Settings updated successfully' );

            if($formSubmit == 'formSaveClose')
                redirect('admin');
            else 
                redirect( 'admin/settings/posibolt' );
        }
        $this->render_page('settings/posibolt', array('current' => 'point', 'subs' => 'posibolt')); 
    }
    
    public function posibolt_log(){
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $logs     = $this->settings_model->get_posibolt_logs();
        $this->render_page('settings/posiboltlog', array('logs' => $logs)); 
    }

    public function posi_describe(){ 
        
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->load->model("settings_model");
        $this->settings_model->add_settings(array('last_sync_time' => Date('Y-m-d H:i:s')));
        
        $auth_username = $this->config->item('posibolt_auth_username');
        $auth_password = $this->config->item('posibolt_auth_password');
        $posi_username = $this->config->item('posibolt_username');
        $posi_password = $this->config->item('posibolt_password');
        $server_url    = $this->config->item('posibolt_url');
        $terminal      = $this->config->item('posibolt_terminal'); 
        
        if(empty($auth_username) || empty($auth_password) || empty($posi_password) || empty($server_url) || empty($terminal))
            die;
        
        $host          = "$server_url/oauth/token?grant_type=password&username=$posi_username&password=$posi_password&terminal=$terminal";

        $crl           = curl_init($host);
        $data_string   = "username=$posi_username&password=$posi_password";

        $headr = array();
        $headr[] = 'Content-length: '.strlen($data_string);
        $headr[] = 'Content-type: application/x-www-form-urlencoded';
        //$headr[] = 'Authorization: Basic VGhpcmRQYXJ0eUFwcDpscENTOVRWQmQ1RGhzWjM=';
        $headr[] = 'Authorization: Basic '.base64_encode( "$auth_username:$auth_password" );


        curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
        curl_setopt($crl, CURLOPT_POST,1);
        curl_setopt($crl, CURLOPT_TIMEOUT, 30);

        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, TRUE);
        $rest = curl_exec($crl);
        curl_close($crl);
        
        $login_data = json_decode($rest, TRUE);         
        if(!isset($login_data['access_token']) || empty($login_data['access_token'])){
            die;
        }
                
        $updated_since = strtotime("-1 days");

        $host    = "$server_url/PosiboltRest/productmaster/productlist?updatedSince=$updated_since&webstoreFeaturedOnly=true";
        $crl     = curl_init($host);

        $headr   = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: Bearer '.$login_data['access_token'];


        curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
        curl_setopt($crl, CURLOPT_TIMEOUT, 30);

        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($crl, CURLOPT_RETURNTRANSFER, TRUE);


        $rest    = curl_exec($crl);
        $result  = ""; 
        $data = json_decode($rest);        
        
        $result .= "<table class='table table-striped'>";
        $result .= "<tr>";
        $result .= "<th>Product ID</th><th>Description</th><th>Name</th><th>isActive</th><th>stockQty</th><th>salesPrice</th><th>productCategory</th><th>upc</th><th>group1</th><th>group2</th>";
        $result .= "</tr>";
        
        if(json_last_error() == JSON_ERROR_NONE){
            $this->load->library('sync');
            foreach ($data as $product){    
                $result .= "<tr><td>$product->productId</td><td>$product->description</td><td>$product->name</td><td>$product->isActive</td><td>$product->stockQty</td><td>$product->salesPrice</td><td>$product->productCategory</td><td>$product->upc</td><td>$product->group1</td><td>$product->group2</td></tr>";
            }   
        }
        $result .= "</table>";
        $this->render_page('settings/posi_describe', array('data' => $result)); 
                
    }


    public function csv()
    {
        $this->load->model("mapper_model");
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        
        $this->form_validation->set_rules('csv', 'Import file', 'trim');        
        if ($this->form_validation->run() == true){ 
            $data = array();          
            if($_FILES['csv']['error'] == 0){
                $name    = $_FILES['csv']['name'];
                $ext     = strtolower(end(explode('.', $_FILES['csv']['name'])));
                $type    = $_FILES['csv']['type'];
                $tmpName = $_FILES['csv']['tmp_name'];
                if($ext === 'csv'){
                    $data    = array_map('str_getcsv', file($tmpName));               
                    $message = $this->mapper_model->import_products($data);
                    
                    $this->load->model('products_model');
                    $this->products_model->set_featured_image();
                    
                    showFlash($message);
                    redirect('admin/settings/csv');
                }
                else{
                    showFlash('Sorry! Only csv files are allowed', 'danger');
                    redirect('admin/settings/csv');
                }
            }
            else{
                showFlash('Sorry! Only csv files are allowed', 'danger');
                redirect('admin/settings/csv');
            }
        }
        $this->render_page('settings/csv', array('current' => 'point', 'subs' => 'csv') );
    }
    
    public function update_settings(){
        if (!$this->input->is_ajax_request()) 
            die;
        $field_name    = $this->input->post('name');
        $field_value   = $this->input->post('value');
        
        if(in_array($field_name, array('popup_title', 'popup_describe', 'popup_footertext', 'popup_title_color', 'popup_footertext_color', 'popup_describe_color', 'popup_btn_color'))){
            $this->settings_model->add_settings(array($field_name => $field_value));
        }
        else{
            header('HTTP/1.0 400 Bad Request', true, 400);
            echo "Invalid data passed";
        }
    }
    
    public function image_handler(){
        $return = uploadMultiFiles($_FILES['images'], 'assets/common/img/');
        $result               = array();
        foreach ($return as $key => $upload_result) {
            if($upload_result['status']){
                $result[$key] = $upload_result['data']['file_name'];
            }
        }
        $result = $this->settings_model->add_settings($result);
        if($result){
            if(isset($return['image_file'])){
                echo loadAsset('img/'.$return['image_file']['data']['file_name'], 'common');
            }
        }
        else{
            header('HTTP/1.0 400 Bad Request', true, 400);
            echo "Invalid image passed";
        }
    }
}