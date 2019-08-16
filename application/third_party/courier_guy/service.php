<?php  
require_once('base.php'); 
class CourierGuy { 

    function __construct($username=NULL, $password=NULL) { 
        $this->serviceURL = 'http://adpdemo.pperfect.com/ecomService/v8/Json/'; 
        $this->username   = empty($username) ? 'pose@ecom.co.za' : $username; //enter your username 
        $this->password   = empty($password) ? 'pose001' : $password; //enter your password 
        $this->token      = ''; 
        $this->json       = new Services_JSON(); 
    } 
     
    function makeCall($class, $method, $params, $token = null) { 
        $jsonParams = $this->json->encode($params); 
        $serviceCall = $this->serviceURL.'?params='.urlencode($jsonParams)."&method=$method&class=$class"; 
        if ($token != null) { 
            $serviceCall.='&token_id='.$token; 
        } 
        $session = curl_init($serviceCall); 
        curl_setopt($session, CURLOPT_HEADER, false); 
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true); 
        $response = curl_exec($session); 
        curl_close($session); 
        return $this->json->decode($response); 
    } 
     
    function saveBase64ToFile($base64string, $path) { 
        $decodedString = base64_decode($base64string); 
        $fileHandle = fopen($path, "w"); 
        if ($fileHandle) { 
            fwrite($fileHandle, $decodedString); 
            fclose($fileHandle); 
            return 1; 
        } else { 
            fclose($fileHandle); 
            return 0; 
        } 
    } 

    function tockens(){ 
        if (file_exists("tokenstore.dat")) { 
            $tokenstore     = unserialize(file_get_contents("tokenstore.dat")); 
            if (isset($tokenstore['token']) && $tokenstore['expire'] > time()) { 
                $response   = $this->makeCall('Auth','isTokenValid', null, $tokenstore['token']); 
                if ($response->errorcode == 0) { 
                    $this->token = $tokenstore['token']; 
                }  
            } 
        }  
        if ($this->token == '') { 
            $params              = array(); 
            $saltParams['email'] = $this->username; 
            $response            = $this->makeCall('Auth','getSalt',$saltParams); 
            if ($response->errorcode == 0) { 
                $salt            = $response->results[0]->salt; 
            } else { 
                return array('status' => FALSE, 'msg' => "Error: ".$response->errormessage); 
            } 
            $md5pass                    = md5($this->password.$salt); 
            $tokenParams                = array(); 
            $tokenParams['email']       = $this->username; 
            $tokenParams['password']    = $md5pass; 
            $response = $this->makeCall('Auth','getSecureToken',$tokenParams); 
             
            if ($response->errorcode == 0) { 
                $this->token = $response->results[0]->token_id; 
            } else { 
                return array('status' => FALSE, 'msg' => "Error: ".$response->errormessage);  
            } 
            if (false === @file_put_contents("tokenstore.dat",serialize(array("token"=>$this->token,"expire"=>time()+(24 * 60 * 60))))) { 
                return array('status' => TRUE, 'msg' => "");
            } 
        }
        if($this->token != '')
            return array('status' => TRUE, 'msg' => "");
        else
          return array('status' => FALSE, 'msg' => "Unable to proceed shipping. Please try later.");    
    }
     
    function getPlace($post_code=NULL){ 
        if(empty($post_code))
            return array('status' => FALSE, 'msg' => "Error: Invalid post code passed!"); 
        $result                             = $this->tockens();

        if($result['status']){ 
            $available_postal_codes             = array(); 
            $postCodeLookupParams               = array(); 
            $postCodeLookupParams['postcode']   = $post_code; 
            $postCodeLookupResponse             = $this->makeCall('Quote','getPlacesByPostcode',$postCodeLookupParams, $this->token); 
            $place = isset($postCodeLookupResponse->results[0]->place) ? $postCodeLookupResponse->results[0]->place : ""; 
            $town  = isset($postCodeLookupResponse->results[0]->town) ? $postCodeLookupResponse->results[0]->town : "";
            if(empty($place) || empty($town))
                return array('status' => FALSE, 'msg' => "Error: Unable to get place details. Please verify your zip code.");
            else
                return array('status' => TRUE, 'msg' => "Success", 'place' => $place, 'town' => $town);
        } 
        return $result;
    }
           
    function getPrice($details){
        $result                             = $this->tockens();
        if($result['status']){
            $quoteResponse = $this->makeCall('Quote','requestQuote',$details, $this->token); 
            if ($quoteResponse->errorcode !== 0) {      
                return array('status' => FALSE, 'msg' => "Error: Unable to calculate shipping coast!");
            } 
            $updateServiceParams            = array(); 
            $updateServiceParams['quoteno'] = $quoteResponse->results[0]->quoteno; 
            $updateServiceParams['service'] = 'ECO';//$quoteResponse->results[0]->rates[0]->service; //i used the first 1 returned 
            $updateResponse                 = $this->makeCall('Quote','updateService',$updateServiceParams, $this->token); 
            
            
            
            if(!isset($updateResponse->results[0]->total) || empty($updateResponse->results[0]->total))
                return array('status' => FALSE,  'msg' => 'Unable to calculate shipping price. Please try later.');
            return array('status' => TRUE, 'quoteno' => $quoteResponse->results[0]->quoteno, 'msg' => '', 'price' => $updateResponse->results[0]->total);
        }
        return $result;
    }
     
    function collection($quote_no, $instructions = '', $notes = ''){
        $convertResponse = FALSE;
        if(empty($quote_no))
            return FALSE;
        
        $result                             = $this->tockens();
        if($result['status']){
            $convertQuoteToWaybillParams = array(); 
            $convertQuoteToWaybillParams['quoteno']      = $quote_no; //this parameter is MANDATORY 
            $convertQuoteToWaybillParams['specins']      = $instructions; //this parameter is OPTIONAL 
            $convertQuoteToWaybillParams['printWaybill'] = 1; 
            $convertQuoteToWaybillParams['printLabels']  = 0; 
            
            $convertResponse = $this->makeCall('Quote','quoteToWaybill',$convertQuoteToWaybillParams, $this->token); 
            
            if (isset($convertResponse->results[0]->waybillBase64)) { 
                $this->saveBase64ToFile($convertResponse->results[0]->waybillBase64, FCPATH.'courier_data/'.$quote_no."-waybill.pdf");
            }
            if (isset($convertResponse->results[0]->labelsBase64)) { 
                $this->saveBase64ToFile($convertResponse->results[0]->labelsBase64, FCPATH.'courier_data/'.$quote_no-"labels.pdf");
            } 
        }
        return $convertResponse;
    }
    
    function runJsonExample() { 
     
        echo "-----------------------------------Authentication-----------------------------------<BR>"; 
     
        //check if stored token is available 
        echo "Checking for tokenstore<BR>"; 
        if (file_exists("tokenstore.dat")) { 
            echo "Tokenstore exists<BR>"; 
            $tokenstore = unserialize(file_get_contents("tokenstore.dat")); 
             
            print_r($tokenstore); 
            echo "<BR>"; 
             
            //check if token is expired 
            if (isset($tokenstore['token']) && $tokenstore['expire'] > time()) { 
                //check if token is still valid on the service 
                echo "Check if token is still valid on the service<BR>"; 
                $response = $this->makeCall('Auth','isTokenValid', null, $tokenstore['token']); 
                print_r($response); 
                 
                if ($response->errorcode == 0) { 
                    //token is still valid 
                    echo "Token is still valid<BR>"; 
                    $this->token = $tokenstore['token']; 
                } else { 
                    //token is no longer valid on the server 
                    echo "Token has expired<BR>"; 
                } 
            } else { 
                //token is present but is more than 24 hours old 
                echo "Token has expired<BR>"; 
            } 
        } else { 
            //token not present 
            echo "Tokenstore does not exist<BR>"; 
        } 
         
        if ($this->token == '') { //token still empty (old token either did not exist or is expired), sarequest new token 
            //get the salt 
            $params = array(); 
            $saltParams['email'] = $this->username; 
            $response = $this->makeCall('Auth','getSalt',$saltParams); 
            print_r($response); 
             
            //check for error 
            if ($response->errorcode == 0) { //no error 
                $salt = $response->results[0]->salt; 
                echo "Salt: ".$salt."<BR>\n"; 
            } else { //error, display notice and quit 
                echo "Error: ".$response->errormessage; 
                die; 
            } 
             
            //get the token 
            $md5pass = md5($this->password.$salt); 
            //echo "md5pass $md5pass <BR>\n"; 
            $tokenParams = array(); 
            $tokenParams['email'] = $this->username; 
            $tokenParams['password'] = $md5pass; 
            $response = $this->makeCall('Auth','getSecureToken',$tokenParams); 
             
            //check for error 
            if ($response->errorcode == 0) { //no error 
                $this->token = $response->results[0]->token_id; 
                echo "Token: ".$this->token."<BR>\n<BR>\n"; 
            } else { //error, display notice and quit 
                echo "Error: ".$response->errormessage; 
                die; 
            } 
             
            //store token 
            if (false === @file_put_contents("tokenstore.dat",serialize(array("token"=>$this->token,"expire"=>time()+(24 * 60 * 60))))) { //set expiry for 24 hours from now 
                echo "Failed to store token. Possible permission error?<br>\n"; 
            } else { 
                echo "Token saved!<BR>"; 
            } 
        } 
         
        echo "<BR><BR>-----------------------------------Requesting Data-----------------------------------<BR><BR>"; 
         
        $available_postal_codes = array(); 
        $postCodeLookupParams = array(); 
        $postCodeLookupParams['postcode'] = '7700'; 
        $postCodeLookupResponse = $this->makeCall('Quote','getPlacesByPostcode',$postCodeLookupParams, $this->token); 
        echo "<BR>\n"; 
        print_r($postCodeLookupResponse); 
        echo "<BR>\n"; 
         
        //originating location details 
        $nameLookupParams['name'] = 'Johan'; 
        $nameLookupResponse = $this->makeCall('Quote','getPlacesByName',$nameLookupParams, $this->token); 
        echo "<BR>\n"; 
        print_r($nameLookupResponse); 
        echo "<BR>\n"; 
         
        echo "<BR><BR>-----------------------------------Submitting Data-----------------------------------<BR><BR>"; 
         
        //build quote request: 
        $quoteParams = array(); 
        $quoteParams['details'] = array(); 
         
        //i added these just to make sure these tests are not processed as actual waybills 
        $quoteParams['details']['specinstruction'] = "This is a test"; 
        $quoteParams['details']['reference'] = "This is a test"; 
         
        //originating location 
        $quoteParams['details']['origperadd1'] = 'Address line 1'; 
        $quoteParams['details']['origperadd2'] = 'Address line 2'; 
        $quoteParams['details']['origperadd3'] = 'Address line 3'; 
        $quoteParams['details']['origperadd4'] = 'Address line 4'; 
        $quoteParams['details']['origperphone'] = '012345678'; 
        $quoteParams['details']['origpercell'] = '012345678'; 
         
        //i used the 1st result from the list returned when looking up postcode = 3340 as there was only 1, but normally the user would choose 
        $quoteParams['details']['origplace'] = $postCodeLookupResponse->results[0]->place; 
        $quoteParams['details']['origtown'] = $postCodeLookupResponse->results[0]->town; 
        $quoteParams['details']['origpers'] = 'TESTCUSTOMER'; 
        $quoteParams['details']['origpercontact'] = 'origcontactsname'; 
        $quoteParams['details']['origperpcode'] = '6730'; //postal code 
         
        //destination location details 
        $quoteParams['details']['destperadd1'] = 'Address line 1'; 
        $quoteParams['details']['destperadd2'] = 'Address line 2'; 
        $quoteParams['details']['destperadd3'] = 'Address line 3'; 
        $quoteParams['details']['destperadd4'] = 'Address line 4'; 
        $quoteParams['details']['destperphone'] = '012345678'; 
        $quoteParams['details']['destpercell'] = '012345678'; 
         
        //i chose the 1st result, but this will be up to the user as above 
        $quoteParams['details']['destplace'] = $nameLookupResponse->results[0]->place; 
        $quoteParams['details']['desttown'] = $nameLookupResponse->results[0]->town; 
        $quoteParams['details']['destpers'] = 'TESTCUSTOMER'; 
        $quoteParams['details']['destpercontact'] = 'destcontactsname'; 
        $quoteParams['details']['destperpcode'] = '3340'; //postal code 
         
        /* Add the contents: 
         * There needs to be at least 1 contents item with an "actmass" > 0 otherwise a rate will not calculate. 
         * "Contents" needs to be an array object, even if there is only one contents item. */ 
          
        //Create contents array object 
        $quoteParams['contents'] = array(); 
         
        //Create first contents item (index 0 in the contents array) 
        $quoteParams['contents'][0] = array(); 
         
        //Add contents details 
        $quoteParams['contents'][0]['item'] = 1; 
        $quoteParams['contents'][0]['desc'] = 'this is a test'; 
        $quoteParams['contents'][0]['pieces'] = 1; 
        $quoteParams['contents'][0]['dim1'] = 1; 
        $quoteParams['contents'][0]['dim2'] = 1; 
        $quoteParams['contents'][0]['dim3'] = 1; 
        $quoteParams['contents'][0]['actmass'] = 1; 
         
        //Create second contents item (index 1 in the contents array) 
        $quoteParams['contents'][1] = array(); 
         
        //Add contents details 
        $quoteParams['contents'][1]['item'] = 2; 
        $quoteParams['contents'][1]['desc'] = 'ths is another test'; 
        $quoteParams['contents'][1]['pieces'] = 1; 
        $quoteParams['contents'][1]['dim1'] = 1; 
        $quoteParams['contents'][1]['dim2'] = 1; 
        $quoteParams['contents'][1]['dim3'] = 1; 
        $quoteParams['contents'][1]['actmass'] = 1; 
         
        echo "<BR>\n<BR>\n ---- request params ---- <BR>\n"; 
        print_r($quoteParams); 
        echo "<BR>\n<BR>\n ---- calling requestQuote ---- <BR>\n"; 
        $quoteResponse = $this->makeCall('Quote','requestQuote',$quoteParams, $this->token); 
        echo "<BR>\n<BR>\n ---- response ---- <BR>\n<BR>\n"; 
        print_r($quoteResponse); 
         
        if ($response->errorcode !== 0) { 
            echo "Error: ".$response->errormessage; 
            die; 
        } 
         
        /* 
         * the user then needs to choose the service most desirable to them and use  
         * the "updateService" method to  set the service, 
         * thereafter use the "quoteToWaybill" or "quoteTocCollection" method convert the quote to a legitimate waybill or collection 
         *  
         * */ 
         
        echo "<BR><BR>-----------------------------------Updating Service-----------------------------------<BR><BR>"; 
         
        $updateServiceParams = array(); 
        $updateServiceParams['quoteno'] = $quoteResponse->results[0]->quoteno; 
        $updateServiceParams['service'] = $quoteResponse->results[0]->rates[0]->service; //i used the first 1 returned 
        $updateResponse = $this->makeCall('Quote','updateService',$updateServiceParams, $this->token); 
         
        echo "<BR>\n--------<BR>\nFinal Rates:<BR>\n<BR>\n"; 
        print_r($updateResponse); 
         
         
        echo "<BR><BR>-----------------------------------Converting-----------------------------------<BR><BR>"; 
         
        //The following code converts the quote to a waybill, uncomment to test 
        /* 
        //Convert quote to waybill 
        //Calling this method will create a waybill with the same details as the submitted quote 
        echo "<BR>\n<BR>\n ---- converting to waybill---- <BR>\n"; 
         
        $convertQuoteToWaybillParams = array(); 
        $convertQuoteToWaybillParams['quoteno'] = $quoteResponse->results[0]->quoteno; //this parameter is MANDATORY 
        $convertQuoteToWaybillParams['specins'] = "special instructions"; //this parameter is OPTIONAL 
        $convertQuoteToWaybillParams['printWaybill'] = 1; 
        $convertQuoteToWaybillParams['printLabels'] = 0; 
         
        echo "<BR>\n<BR>\n ---- convert params ---- <BR>\n"; 
        print_r($convertQuoteToWaybillParams); 
         
        $convertResponse = $this->makeCall('Quote','quoteToWaybill',$convertQuoteToWaybillParams, $this->token); 
        */ 
         
         
         
        //The following code converts the quote to a collection, uncomment to test 
         
        //Convert quote to Collection 
        //Calling this method will create a Collection with the same details as the submitted quote 
        echo "<BR>\n<BR>\n ---- converting to collection---- <BR>\n"; 
         
        $convertQuoteToCollectionParams = array(); 
        $convertQuoteToCollectionParams['quoteno'] = $quoteResponse->results[0]->quoteno; //this parameter is MANDATORY 
        $convertQuoteToCollectionParams['specinstruction'] = "special instructions"; //this parameter is OPTIONAL 
        $convertQuoteToCollectionParams['starttime'] = "11:09"; 
        $convertQuoteToCollectionParams['endtime'] = "17:00"; 
        $convertQuoteToCollectionParams['quoteCollectionDate'] = "27/01/2017"; 
        $convertQuoteToCollectionParams['notes'] = "some notes here"; 
        $convertQuoteToCollectionParams['printWaybill'] = 1; //OPTIONAL param to return a base64 encoded pdf of the waybill 
        $convertQuoteToCollectionParams['printLabels'] = 0; //OPTIONAL param to return a base64 encoded pdf of the labels 
         
        echo "<BR>\n<BR>\n ---- convert params ---- <BR>\n"; 
        print_r($convertQuoteToCollectionParams); 
         
        $convertResponse = $this->makeCall('Collection','quoteToCollection',$convertQuoteToCollectionParams, $this->token); 
         
         
        echo "<BR>\n<BR>\n ---- response ---- <BR>\n<BR>\n"; 
        print_r($convertResponse); 
         
        echo "<BR><BR>-----------------------------------Saving PDFs-----------------------------------<BR><BR>"; 
         
        //save printable pdfs to disk 
        //waybill 
        if (isset($convertResponse->results[0]->waybillBase64)) { 
            echo "<BR><BR>saving waybill.pdf<BR>"; 
            if ($this->saveBase64ToFile($convertResponse->results[0]->waybillBase64, "waybill.pdf")) { 
                echo "waybill.pdf saved<BR><BR>"; 
            } else { 
                echo "error saving waybill.pdf<BR><BR>"; 
            } 
        } else { 
            echo "<BR>waybill.pdf data not returned<BR><BR>"; 
        } 
         
        //labels 
        if (isset($convertResponse->results[0]->labelsBase64)) { 
            echo "<BR><BR>saving labels.pdf<BR>"; 
            if ($this->saveBase64ToFile($convertResponse->results[0]->labelsBase64, "labels.pdf")) { 
                echo "labels.pdf saved<BR><BR>"; 
            } else { 
                echo "error saving labels.pdf<BR><BR>"; 
            } 
        } else { 
            echo "<BR>labels.pdf data not returned<BR><BR>"; 
        } 
         
        echo "<BR><BR>-----------------------------------Done-----------------------------------<BR><BR>"; 
    } 
} 
