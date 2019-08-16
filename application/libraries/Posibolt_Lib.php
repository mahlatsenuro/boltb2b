<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Posibolt_Lib 
{
    
    private $auth_username;
    private $auth_password;
    private $posi_username;
    private $posi_password;
    private $server_url;
    private $terminal;
    private $access_token;
    var $CI;
    
    public function __construct()
    { 
        $this->CI =& get_instance();
        
        $this->auth_username = $this->CI->config->item('posibolt_auth_username');
        $this->auth_password = $this->CI->config->item('posibolt_auth_password');
        $this->posi_username = urlencode($this->CI->config->item('posibolt_username'));
        $this->posi_password = urlencode($this->CI->config->item('posibolt_password'));
        $this->server_url    = $this->CI->config->item('posibolt_url');
        $this->terminal      = urlencode($this->CI->config->item('posibolt_terminal')); 
        
        $this->getToken();
    }

    public function getToken(){

        if(empty($this->auth_username) || empty($this->auth_password) || empty($this->posi_password) || empty($this->server_url) || empty($this->terminal))
        {
            $this->access_token = FALSE;;
            return;
        }
        $host          = "$this->server_url/oauth/token?grant_type=password&username=".urlencode($this->posi_username)."&password=$this->posi_password&terminal=".urlencode($this->terminal);

        $crl           = curl_init($host);
        $data_string   = "username=$this->posi_username&password=$this->posi_password";

        $headr = array();
        $headr[] = 'Content-length: '.strlen($data_string);
        $headr[] = 'Content-type: application/x-www-form-urlencoded';
        //$headr[] = 'Authorization: Basic VGhpcmRQYXJ0eUFwcDpscENTOVRWQmQ1RGhzWjM=';
        $headr[] = 'Authorization: Basic '.base64_encode( "$this->auth_username:$this->auth_password" );


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
            $this->access_token = FALSE;
            $this->log($host, 'POST', array('data_string' => $data_string), $login_data);
            return;
        }
        $this->access_token = $login_data['access_token'];
        return;
    }
    
    public function getRequest($url){
        $host         = "$this->server_url/".$url;
        $crl          = curl_init($host);
        $headr   = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: Bearer '.$this->access_token;


        curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
        curl_setopt($crl, CURLOPT_TIMEOUT, 30);

        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($crl, CURLOPT_RETURNTRANSFER, TRUE);


        $rest    = curl_exec($crl);
        
        $data = json_decode($rest);     
        
        $this->log($host, 'GET', array(), $data);
        
        if(json_last_error() == JSON_ERROR_NONE){ 
            return $data;
        }
        else{
            return false;
        }
    }
    
    public function postRequest($url, $data){
        $host    = "$this->server_url".$url;
        $crl     = curl_init($host);    
       
        
        if(isset($data['country']) && empty($data['country'])){
            $data['country'] = 'South Africa';
        }
        
        $headr   = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: Bearer '.$this->access_token;
       
        //$data = '{    "orderNo" : "HISORD002",  "description": "some comments",    "dateOrdered": "09-03-2015",    "salesrep" : "",    "warehouseId"  : "",    "invoiceRule" : "After Delivery",    "paymentType" : "Cash",    "orderLineList":  [                   {                    "productId":  1300635,                    "qty": 1,                    "price": 100,                    "uom": ""                    } ],       ​"payments" :​ ​[      {                       "paymentNo":"PAY001",                       "amount":200,                       "paymentType" : "Cash"                    }  ]   } ';
        curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
        curl_setopt($crl, CURLOPT_TIMEOUT, 30);

        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_POST,1);
        curl_setopt($crl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, TRUE);
        $rest    = curl_exec($crl);        //var_dump($rest);
        //var_dump($rest);
        $response_data = json_decode($rest);
        
        $this->log($host, 'POST', $data, $rest);
        
        if(json_last_error() == JSON_ERROR_NONE){
            return $response_data;
        }
        else{
            return json_last_error();
        }
    }
    
    
    function create_user($customer_data, $user_id = NULL, $status="create"){
        $customer_data['action'] = $status;
               
        $customer_url       = "/PosiboltRest/customermaster";        
        $customer_return    = $this->postRequest($customer_url, $customer_data); 
        
        
        if($customer_return && isset($user_id)){
            $posibolt_user_id    = $customer_return->recordNo; 
            $this->CI->db->insert("posibolt_customer_code", array("user_id" => $user_id, "posibolt_user_id" => $posibolt_user_id));
        }
        return $posibolt_user_id ? $posibolt_user_id : FALSE;
    }
    
    
    function update_posibolt_customer($user_id, $pos_customer_id, $address){
        $customer_url       = "/PosiboltRest/customermaster/$pos_customer_id"; 
        $user_data          = $this->CI->ion_auth->user($user_id)->row();
        
        
        $customer_data      = array(
                'customerCode'  => "CUSTPOS".get_string_between(base_url(), '//', '.').$user_id, 
                'name'      => $address->full_name,
                'address1'   => $address->full_name.', '.$address->company_name,
                'address2'  => $address->town_name,
                'city'      => $address->suburb_name,
                'mobile'    => $address->cellphone,
                'phone'     => $address->phone,
                'postalCode' => $address->zip_code,
                'region'     => $address->street,   
                'email'      => isset($user_data->email) ? $user_data->email : '',
                'country'   => 'South Africa',
                'active'    => true,
                'action'    => 'update'
            );
            
        $customer_return    = $this->postRequest($customer_url, $customer_data); 
        
    }
    
    function create_user_address($address_data, $posibolt_user_id){
        
        $address_url        = "/PosiboltRest/customermaster/customeraddress/".$posibolt_user_id;        
        $address_return          = $this->postRequest($address_url, $address_data); 
        if($address_return){
            
            
           // $posibolt_user_id    = $customer_return->recordNo; 
           // $this->CI->db->insert("posibolt_customer_code", array("user_id" => $user_id, "posibolt_user_id" => $posibolt_user_id));
        }
    }
    
    function create_sales_order($order_data){       
        $order_url               = "/PosiboltRest/salesorder/createorder";         
        $order_return            = $this->postRequest($order_url, $order_data);        
        if($order_return){
            
            
           // $posibolt_user_id    = $customer_return->recordNo; 
           // $this->CI->db->insert("posibolt_customer_code", array("user_id" => $user_id, "posibolt_user_id" => $posibolt_user_id));
        }
    }
    
    function log($url, $method, $request_data = array(), $response_data = array()){
        
        $request_data  = is_array($request_data)  ? json_encode($request_data)  : $request_data;
        $response_data = is_array($response_data) ? json_encode($response_data) : $response_data; 
        
        $this->CI->db->query('DELETE FROM `posibolt_logs`
            WHERE id NOT IN (
              SELECT id
              FROM (
                SELECT id
                FROM `posibolt_logs`
                ORDER BY id DESC
                LIMIT 500 
              ) foo
            );');

        $this->CI->db->insert('posibolt_logs', array('request_url' => $url, 'request_method' => $method, 'request_data' => $request_data, 'response_data' => $response_data) );
    }
    
}