<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
class AuthorizeNet
{
    var $loginId;
	var $tranKey;
    var $version;
    var $customerEmail;
    var $address;
    var $city;
    var $state;
    var $zip;
    var $phone;
    var $country;
    var $ADC_URL;
    var $type;
    var $method;
    var $firstName;
    var $lastName;
    var $amount;
    var $cardNumber;
	var $cardCVV;
    var $expireDate;
    var $script;
    var $port;
    var $ADC_Delim_Char;
    var $error;
    var $Bank_ABA_Code;
    var $Bank_Acct_Num;
    var $Bank_Name;
    
    function authorizenet()
    {

        $this->version = "3";
        $this->type = "AUTH_CAPTURE";
        $this->method = "CC"; 
        $this->script = "https://secure.authorize.net/gateway/transact.dll";
        $this->port = 443;
    }
    
    function process()
    {
			
		$ch=curl_init($this->script);
	
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $this->getUrlData());  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   

		$buffer = curl_exec($ch);   
		curl_close($ch);        
		
      
        $returnArray = array();
        $returnArray = explode( '|', $buffer );
		
        $responseCode = $returnArray[2];
        if( $responseCode == 1 ) return true; 
        else
        {
            if( $returnArray[3] ) $this->error = $returnArray[3];
        
            else $this->error = "";
            
            return false;
        }
    }
    
    function error() 
    {
        return $this->error;
    }
    
    function getUrlData()
    {
		$data="";
        $data .=
        "x_Login="                    . $this->loginId . 
		"&x_Tran_Key="                    . $this->tranKey . 
        "&x_ADC_Delim_Data="          . "TRUE" . 
        "&x_ADC_Delim_Character="     . "|" . 
        "&x_ADC_URL="                 . "FALSE" .
        "&x_Email_Customer="          . $this->customerEmail .
        "&x_Address="                 . $this->address .
        "&x_City="                    . $this->city .
        "&x_State="                   . $this->state .
        "&x_Zip="                     . $this->zip .
        "&x_Country="                 . $this->country .
        "&x_Phone="                   . $this->phone .
        "&x_Type="                    . $this->type .
        "&x_Method="                  . $this->method .
        "&x_First_Name="              . $this->firstName .
        "&x_Last_Name="               . $this->lastName .
        "&x_Amount="                  . $this->amount;
        
        if( $this->method == "CC" )
        {
            $data .=
            "&x_Card_Num="                . $this->cardNumber .
			"&x_Card_Code="                . $this->cardCVV .
            "&x_Exp_Date="                . $this->expireDate;
        }
        
        if( $this->method == "ECHECK" ) 
        {
            $data .=
            "&x_Bank_ABA_Code="           . $this->Bank_ABA_Code .
            "&x_Bank_Acct_Num="           . $this->Bank_Acct_Num .
            "&x_Bank_Name="               . $this->Bank_Name;
        }

        return $data;
    }
    
   
    function setRoutingNumber( $number )
    {
        $this->Bank_ABA_Code = urlencode( $number );
    }
    
    function setBankAccountNumber( $number )
    {
        $this->Bank_Acct_Num = urlencode( $number );
    }
    
    function setBankName( $name )
    {
        $this->Bank_Name = urlencode( $name );
    }
    
    function setMethod( $method )
    {
        $this->method = $method;
    }
    
    function setLoginId( $loginId )
    {
        $this->loginId = urlencode( $loginId );
    }
	
	function setTranKey( $tranKey )
    {
        $this->tranKey = urlencode( $tranKey );
    }
    
    
    function setCustomerEmail( $customerEmail )
    {
        $this->customerEmail = urlencode( $customerEmail );
    }
    
    function setAddress( $address )
    {
        $this->address = urlencode( $address );
    }
    
    function setCity( $city )
    {
        $this->city = urlencode( $city );
    }
    
    function setState( $state )
    {
        $this->state = urlencode( $state );
    }
    
    function setZip( $zip )
    {
        $this->zip = urlencode( $zip );
    }
    
    function setCountry( $country )
    {
        $this->country = urlencode( $country );
    }
    
    function setPhone( $phone )
    {
        $this->phone = urlencode( $phone );
    }
    
    function setFirstName( $name )
    {
        $this->firstName = urlencode( $name );
    }
    
    function setLastName( $name )
    {
        $this->lastName = urlencode( $name );
    }
    
    function setAmount( $amount )
    {
        $this->amount = urlencode( $amount );
    }
    
    function setCardNumber( $cardNumber )
    {
        $this->cardNumber = urlencode( $cardNumber );
    }
	
     function setCardCVV( $number )
    {
        $this->cardCVV = urlencode( $number );
    }
	
    function setExpireDate( $date )
    {
        $this->expireDate = urlencode( $date );
    }
};

?>
