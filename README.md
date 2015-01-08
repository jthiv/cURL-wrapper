# cURL-wrapper
Wrapper for a rest API

Note: Since $new_URL_BASE and $new_API_KEY are optional parameters, you can add them inside the class or when you initiate it.
This is good if you typically use one API throughout your app, but would like to make a one time call to another API as well.

*********************************************************
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

