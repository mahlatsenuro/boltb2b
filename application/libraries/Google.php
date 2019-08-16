<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Google 
{
   
    public function VerifyCaptcha($response)
    {   
        $google_url = "https://www.google.com/recaptcha/api/siteverify";
        $secret     = '6Lf91xoTAAAAAOlEAby7rn4uTfEfLLU2Cn2fUcnq';
        
        $url = $google_url."?secret=".$secret.
               "&response=".$response;
 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, TRUE); 
        $curlData = curl_exec($curl);
 
        curl_close($curl); echo $url;
 
        $res = json_decode($curlData, TRUE);        var_dump($curlData); die;
        if($res['success'] == 'true') 
            return TRUE;
        else
            return FALSE;
    }
 
}