<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_gate {
    private $CI;

   function __construct() {
       $this->CI =& get_instance();
       $this->CI->load->database();
   }
   
    function cmpi_lookup($mygate, $order_id) {
        
        try {
            $client = new SoapClient($mygate['threedsecure_url']);            //var_dump($mygate); die;
            $arrResults = $client->lookup(
                $mygate['merchant_id'], 			//MerchantID
                $mygate['application_id'],			//ApplicationID
                1,  		
                $mygate['PAN'], 					//Credit Card Number
                $mygate['PanExp'],					//Expiry Date (YYMM)
                $mygate['Amount'],		//Transaction Amount
                $mygate['UserAgent'],				//Thhe HTTP User Agent
                $mygate['BrowserHeader'],			//The HTTP Browser Header
                $mygate['OrderNumber'],			//MerchantReference
                $mygate['OrderDesc'],				//The Order Desc

                $mygate['reccurring'],				//Is the transaction recurring
                $mygate['reccurring_frequency'],	//What is the recurring frequency										
                $mygate['reccurring_end'],			//when is the last debit date
                $mygate['installment']			//The amount of months the recurring debits will continue
            );
        }catch (SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }   
	
        $this->log_mygate(array('type' => 'cmpi_lookup', 'data' => json_encode($arrResults)));
        
	list($Result,$ResultValue) = explode("||",@$arrResults[1]);
	list($TransactionId,$TransactionIdValue) = explode("||",@$arrResults[0]);
	
	if ($ResultValue == 0){

            list($Enrolled,$EnrolledValue) = explode("||",@$arrResults[2]);
            list($AcsUrl,$AcsUrlValue) = explode("||",@$arrResults[3]);
            list($PAReq,$PAReqValue) = explode("||",@$arrResults[4]);
            list($TransactionId,$TransactionIdValue) = explode("||",@$arrResults[0]);

            //A 'Y' will be returned in the $arrResults[2] return parameter. In the case of a 'Y', the card holder needs to be redirected to the ACS. In all otrher cases, an Authorisation can be invoked.
            if ($EnrolledValue  == 'Y'){
                ?>
                <p>Redirecting.. Please wait..</p>
                <form name="frmLaunchACS" method="POST" action="<?PHP echo $AcsUrlValue ?>" style="display: none;" id="details">
                    <table align="center"  width='50%' style="border:1px solid black;">
                        <tr>
                            <td align="center" colspan="2" style="background-color:Red; font-size:16px;"><font color="FFFFFF">Posting data to the Issuer ACS server</font></td>
                        </tr>
                        <tr>
                            <td ><div align="right">PaReq :</div></td>
                            <td ><textarea cols="50" rows="5" style="width:400" name="PaReq" ><?PHP echo $PAReqValue ?></textarea></textarea></td>
                        </tr>
                        <tr>
                            <td ><div align="right">TermUrl :</div></td>
                            <td ><input type="text" style="width:400" name="TermUrl" value="<?php echo($mygate['ACSCallbackURL']); ?>"/>
                      </td>
                        </tr>
                        <tr>
                            <td ><div align="right">Transaction Index</div></td>
                            <td ><input type="text" style="width:400" name="MD" value="<?PHP echo $TransactionIdValue ?>"/></td>
                        </tr>
                        <tr>
                            <td colspan="2"><div align="center">
                                <input type="submit" value="Submit Form" style="width:250" >
                            </div></td>
                        </tr>
                    </table>				
                </form>	
                <script type="text/javascript">
                    document.getElementById("details").submit();
                </script>
                <?PHP
            } 
            else 
            { 
                //In the event of anything other than a 'Y', this will print out the results and perform an authorisation. This means that the card holders issueing bank has determined that the card holder is not enrolled for 3D-Secure and does not need to be.
                return $this->performAuth($TransactionIdValue, $mygate);
            }
			
	}
	else {
            //In the event of a 3D-Secure error, the transaction should still continue.
            list($ErrorNo,$ErrorNoValue) = explode("||",@$arrResults[1]);
            list($ErrorDesc,$ErrorDescValue) = explode("||",@$arrResults[3]);
            
            //return array("status" => false,  "message" => $ErrorDescValue);
            return $this->performAuth($TransactionIdValue, $mygate);
	}
    }
    
    
    public function cmpi_authenticate($mygate) {
	//Once the card holder has been posted back, the cmpi_authenticate function gets invoked to verify the results.
	$TransactionId  = $_POST['MD'];
	$PAResPayload   = $_POST['PaRes'];
	
        
        
	$client = new SoapClient($mygate['threedsecure_url']);
	$arrResults = $client->authenticate(
            $TransactionId, 				//TransactionID
            $PAResPayload					//PaRes
	);
        $this->log_mygate(array('type' => 'cmpi_authenticate', 'data' => json_encode($arrResults)));
        
	//list($Result,$ResultValue) = explode("||",@$arrResults[0]);

	//list($Result,$ECI) = explode("||",@$arrResults[3]);
	//list($Result,$XID) = explode("||",@$arrResults[4]);
	//list($Result,$CAVV) = explode("||",@$arrResults[5]); 

	//Regardless of the result, an authorisation should occur at this stage.
	return $this->performAuth($TransactionId, $mygate);
    }
    
    
    function performAuth($TransactionIndex, $mygate) {
	//A U T H O R I S E  P U R C H A S E     (A C T I O N  =  1)

	//Ensure that PHP is installed and has the php_soap extension enabled.
        try{
            $client = new SoapClient($mygate['url']);

            $arrResults = $client->fProcess(
                    $mygate['gateway_id'],             	//Gateway
                    $mygate['merchant_id'],          	//MerchantID
                    $mygate['application_id'],     		//ApplicationID
                    '1',      							//Action
                    $TransactionIndex,                  //TransactionIndex from 3D-Secure API
                    'Terminal',            				//Terminal
                    $mygate['mode'],                	//Mode
                    '',        							//MerchantReference
                    $mygate['Amount'],            	    //Amount
                    $mygate['currency'],            	//Currency
                    '',                    				//CashBackAmount                                        
                    $mygate['CardType'],            	//CardType
                    '',                    				//AccountType
                    $mygate['PAN'],        			//CardNumber
                    $mygate['CCName'],        			//CardHolder
                    $mygate['CVC'],                	//CCVNumber
                    $mygate['ExpMonth'],            	//ExpiryMonth
                    $mygate['ExpYear'],            	//ExpiryYear
                    '0',                				//Budget
                    '',                    				//BudgetPeriod
                    '',                    				//AuthorizationNumber
                    '',                    				//PIN
                    '',                    				//DebugMode
                    '07',               				//eCommerceIndicator                            
                    '',                    				//verifiedByVisaXID
                    '',                    				//verifiedByVisaCAFF
                    '',                    				//secureCodeUCAF
                    '',                    				//Unique Client Index - this is used to uniquely identify the client and is used by the MyGate Fraud module. It is an optional parameter. Please see online documentation for details.
                    '',                    				//IP Address - this is the IP address of the user using the online gateway (retrieved by yourselves), and is used by the MyGate Fraud module. It is an optional parameter.     Please see online documentation for details.
                    '',									//Shipping Country Code - this is the 2-digit shipping country code of the user, and is used by the MyGate Fraud module. It is an optional parameter. Please see online documentation for details.    
                    ''              
            );
	} catch (SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
        
        $this->log_mygate(array('type' => 'performAuth', 'data' => json_encode($arrResults)));
        
	//Results are returned from MyGate in an array format with the return parameter name and value seperated by a double-pipe (||)
	list($ResultName, $ResultValue) = explode("||",$arrResults[0]);
	
	//The first element of the retrn array ($arrResults[0]) is the Result. 0=Successful, 1=Warning (A result of 1 is returned either when the fraud module is providing a flag or if unnecessary parameters were sent to the API in the request message).
	if ($ResultValue >= 0)
	{
            //The TransactionIndex is needed for any further transaction attempts on an authorisation. It is the second array element that is returned ($arrResults[1]).
            list($ResultName, $TransactionID) = explode("||",$arrResults[1]);

            return $this->performSettlement($TransactionID, $mygate);	
	}
	else {
            return array("status" => FALSE,  "message" => 'Transaction failed');
	}
}

    function performSettlement($TransactionIndex, $mygate) { 
        try{
            $client = new SoapClient($mygate['url']);
            $arrResults2 = $client->fProcess(
                $mygate['gateway_id'], 		//Gateway
                $mygate['merchant_id'],  	//MerchantID
                $mygate['application_id'], 	//ApplicationID
                '3',						//Action
                $TransactionIndex,			//TransactionIndex
                '',							//Terminal
                '',							//Mode
                '',							//MerchantReference
                '',							//Amount
                '',							//Currency
                '',							//CashBackAmount										
                '',							//CardType
                '',							//AccountType
                '',							//CardNumber
                '',							//CardHolder
                '',							//CCVNumber
                '',							//ExpiryMonth
                '',							//ExpiryYear
                '',							//Budget
                '',							//BudgetPeriod
                '',							//AuthorizationNumber
                '',							//PIN
                '',							//DebugMode
                '',							//eCommerceIndicator							
                '',							//verifiedByVisaXID
                '',							//verifiedByVisaCAFF
                '',							//secureCodeUCAF
                '',                    		//Unique Client Index - this is used to uniquely identify the client and is used by the MyGate Fraud module. It is an optional parameter. Please see online documentation for details.
                '',                    		//IP Address - this is the IP address of the user using the online gateway (retrieved by yourselves), and is used by the MyGate Fraud module. It is an optional parameter.     Please see online documentation for details.
                '',							//Shipping Country Code - this is the 2-digit shipping country code of the user, and is used by the MyGate Fraud module. It is an optional parameter. Please see online documentation for details.    
                ''
                );
        } catch (SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
        
        $this->log_mygate(array('type' => 'performSettlement', 'data' => json_encode($arrResults2)));
        
        list($ResultName2, $ResultValue2) = explode("||",$arrResults2[0]);               

        if ($ResultValue2 >= 0) { 
                $output = array('settlement' => 1, 'result' => $arrResults2);
                return array("status" => TRUE,  "message" => '', "output" => $output);
        }
        else {
            $output = array('settlement' => 0, 'result' => $arrResults2);
            return array("status" => TRUE,  "message" => '', "output" => $output);
        }
    }
    
    public function log_mygate($data)
    {
        $userId = get_userid_checkout();
        
        $data['user_id'] =  $userId;
        $this->CI->db->insert('mygate_logs', $data);
    }
    
}