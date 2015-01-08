<?php
/************************************************************************************
 *File: cURL_wrapper.php
 *Created: October 20, 2013
 *Authors: Joe Hinton
 *Purpose: A wrapper class for curl calls to a REST API.
 ************************************************************************************/
class cURL_wrapper{
    
    private $API_KEY;
    private $API_URL_BASE;
    private $method;
    private $params;
    
    /*Constructor: Grabs all the needed info to make a cURL call
     *__________________________________________________________
     *PARAMETERS
     *----------------------------------------------------------
     *new_method(STRING): API Method
     *
     *params(ARRAY): API Parameter array
     *	param[0]["name"]: Parameter Name
     *	param[0]["value"]: Parameter value
     *	
     *new_URL_BASE(STRING): Base of the REST URL. You can define this inside your class or
     *	at call time.
     *
     *new_API_KEY(STRING): Your API Key. You can define this inside your class or
     *	at call time.
     */
    function __construct($new_method,$params, $new_URL_BASE = "", $new_API_KEY = ""){
	try
	{
	    $this->API_KEY = $new_API_KEY;
	    $this->API_URL_BASE = $new_URL_BASE;
	    $this->method = $new_method;
	    if(is_array($params))
	    {
		$this->params = $params;
	    }
	    else
	    {
		throw new Exception("Invalid Parameter: Expecting array");
	    }
	}
	catch(Exception $e)
	{
	    echo "Error initializing wrapper. <br />Message:".$e->getMessage();
	}
		
		
    }
    
    //This will build your REST URL, make the cURL and return the data received
    public function getMethodResponse(){
	//Build Service URL with method and API KEY
	$service_url = $this->API_URL_BASE.$this->method."?apikey=".$this->API_KEY;
	    //Add parameters to the URL
	    foreach($this->params as $singleParam){
		$service_url .= "&".$singleParam["name"]."=".$singleParam["value"];
	    }
	
	try
	{
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	}
	catch(Exception $e)
	{
	    return false;
	}
	
	return $curl_response;
	    
    }
}
/********************************************************
PROOF OF CONCEPT

I will use the Sunlight Foundation Congress API. View
documentation on this API here:
https://sunlightlabs.github.io/congress/

You will need a valid API key for this to work.
---------------------------------------------------------

$url_base = "https://congress.api.sunlightfoundation.com";
$api_key = "***************";
$method ="/legislators";
$params = array();
    $params[0]=array("name" => "state",
		     "value" => "VA"
		    );
    $params[1]=array("name" => "chamber",
		     "value" => "senate"
		    );
    $params[2]=array("name" => "in_office",
		     "value" => "true"
		    );
$objAPI = new cURL_wrapper($method,$params,$url_base,$api_key);
try
{
    if($objAPI)
    {
	$jsonResponse = $objAPI->getMethodResponse();
	$arrResponse = json_decode($jsonResponse,true);
    }
    else
    {
	throw new Exception("API Error: Invalid response.");
    }
}
catch(Exception $e)
{
    echo $e->getMessage();
}
********************************************************/


?>