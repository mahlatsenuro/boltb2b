<?php

class LoadConfig {

    function load_config() {

        $CI     =& get_instance();
        $result = $CI->db->get('settings')->result(); 
        foreach ($result as $key => $item){
            $CI->config->set_item($item->index, $item->value);
        }
        $collivery_email        = $CI->config->item("delivery_collivery_id");
        $collivery_password     = $CI->config->item("delivery_collivery_password"); 
        $mygate_merchant_id     = $CI->config->item("mygate_merchant_id");
        $mygate_application_id  = $CI->config->item("mygate_application_id");

        if(!empty($collivery_email) && !empty($collivery_password)){
            
            $collivery_settings  =  
                array(
                    'app_name'      => 'POSComm', // Application Name
                    'app_version'   => '0.0.1',            // Application Version
                    'app_host'      => '', 
                    'app_url'       => '', 
                    'user_email'    => $collivery_email,
                    'user_password' => $collivery_password,
                    'demo'          => true,
                    'cache_dir'     => FCPATH.'courier_data/cache/'
                );
            $CI->config->set_item('collivery_config', $collivery_settings);
        }
        
        if($CI->config->item('mygate_live_transaction') == 1){
            if(!empty($mygate_merchant_id) && !empty($mygate_merchant_id)){
                $mygate_settings  = 
                    array(
                        'threedsecure_url'      => 'https://3dsecure.mygateglobal.com/ws3DSecure.WSDL',
                        'url'                   => 'https://enterprise.mygateglobal.com/5x0x0/wsCCPayments.wsdl',
                        'mode'                  => 1,
                        'merchant_id'           => $mygate_merchant_id,
                        'application_id'        => $mygate_application_id,
                        'gateway_id'            => 23,
                        'currency'              => 'ZAR',
                        'reccurring'            => 'N',
                        'reccurring_frequency'  => '',
                        'reccurring_end'        => '',
                        'installment'           => '' 
                    );     
                $CI->config->set_item('mygate', $mygate_settings);
            }
        }
        else{ 
            $mygate_settings    = 
                array(
                    'threedsecure_url'      => 'https://dev-3dsecure.mygateglobal.com/ws3DSecure.wsdl',//'https://3dsecure.mygateglobal.com/ws3DSecure.WSDL',
                    'url'                   => 'https://dev-enterprise.mygateglobal.com/5x0x0/wsCCPayments.wsdl',
                    'mode'                  => 0,
                    'merchant_id'           => $mygate_merchant_id,
                    'application_id'        => $mygate_application_id,
                    'gateway_id'            => 01,
                    'currency'              => 'ZAR',
                    'reccurring'            => 'N',
                    'reccurring_frequency'  => '',
                    'reccurring_end'        => '',
                    'installment'           => '' 
                ); 
            $CI->config->set_item('mygate', $mygate_settings);
        }
    }

}