<?php
include 'modeller.php';

$obj_mod=new Modeller();

$uri = $_SERVER['REQUEST_URI'];   // /api/consumers
$method = $_SERVER['REQUEST_METHOD'];  // GET,POST,DELETE, etc.

switch ($method | $uri) {	
	
	// GET all customer user data
    case ($method == 'GET' && $uri == '/api/consumers'):
        header('Content-Type: application/json');

		$data=$obj_mod->getConsumerData(0);
		$http_resp=200;
		echo $data;
		http_response_code($http_resp); 
        break;
	
	// GET specific customer user data
	case ($method == 'GET' && preg_match('/\/api\/consumers\/[1-9]/', $uri)):
        header('Content-Type: application/json');
		
		// Get User Id from URL		
		$id= basename($uri);		
		$data=$obj_mod->getConsumerData($id);
		$http_resp = 200;

		echo $data;
		http_response_code($http_resp); 
        break;
		
	// Create Consumer
	case ($method == 'POST' && $uri == '/api/consumers'):
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
		$data = json_decode($jsonData, true);
		
		// API Gateway - Key authorization check

		$headers = getallheaders();		
		$security_token = $headers['token'];
		
		$check_status = $obj_mod->checkSecurityToken($security_token);
		
		if($check_status==200)
		{		
			if ($data !== null) {
				   $resp=$obj_mod->createConsumer($data);
			   $http_resp = 201;

			} else {
			   $http_resp =400;
			}
		}
		else
		{
			$http_resp=$check_status;
		}
		
		http_response_code($http_resp); 
		echo $http_resp.":".getHttpStatusMessage($http_resp);
        break;	
		
	// PUT : Update Consumer
	case ($method == 'PUT' && $uri == '/api/consumers'):
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
		$data = json_decode($jsonData, true);

		// API Gateway - Key authorization check

		$headers = getallheaders();		
		$security_token = $headers['token'];
		
		$check_status = $obj_mod->checkSecurityToken($security_token);
		
		if($check_status==200)
		{		
			if ($data !== null) {
				   $resp=$obj_mod->modifyConsumer($data);
			   $http_resp = 200;

			} else {
			   $http_resp =400;
			}
		}
		else
		{
			$http_resp=$check_status;
		}
		
		http_response_code($http_resp); 
		echo $http_resp.":".getHttpStatusMessage($http_resp);
        break;	
	
	// DELETE consumer
	case ($method == 'DELETE' && $uri == '/api/consumers'):
        header('Content-Type: application/json');
        $jsonData = file_get_contents('php://input');
		$data = json_decode($jsonData, true);
		
		// API Gateway - Key authorization check

		$headers = getallheaders();		
		$security_token = $headers['token'];
		
		$check_status = $obj_mod->checkSecurityToken($security_token);
		
		if($check_status==200)
		{		
			if ($data !== null) {
				   $resp=$obj_mod->removeConsumer($data);
			   $http_resp = 200;

			} else {
			   $http_resp =400;
			}
		}
		else
		{
			$http_resp=$check_status;
		}		
		
		http_response_code($http_resp); 
		echo $http_resp.":".getHttpStatusMessage($http_resp);
        break;	
}

function getHttpStatusMessage($statusCode)
    {
        $httpStatus = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request (Input JSON)',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }

?>