<?php
error_reporting(0);
header('Content-type: application/json');

class players_socket_connect {
	
    public function __construct($address, $port, $passwd = NULL, &$success = NULL, &$errno = NULL, &$errstr = NULL) {
    	$this->address = $address;
    	$this->port = $port;

        $this->fp = fsockopen("udp://$address", $port, $errno, $errstr, 5);
		if($passwd != NULL){
			$this->passwd = $passwd;
		}
    }
	
	public function onconnects(){
		
		$json = json_encode(array("ip" => $_SERVER['REMOTE_ADDR'], "time" => time()));
		
		fwrite($this->fp, "\xFF\xFF\xFF\xFFrcon {$this->passwd} sibzranget:setup $json\x00");
		
		return $json;
		
	}
	
}

// IP PORT PASSWORD RCON
$new = new players_socket_connect("103.208.27.118", 30120, "aa123");

if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	print_r($new->onconnects());
	
}