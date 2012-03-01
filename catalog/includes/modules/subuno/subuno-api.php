<?php
#
#
# Copyright 2011 MERS Technologies.
#

# PHP 5.3.x client library for the SUBUNO API.
#
# This client library is designed to support the SUBUNO API. Read more
# about the SUBUNO API at subuno.com. You can download this API at
# http://github.com/subuno/api/

define("SUBUNO_SERVER_URI" , "https://api.subuno.com/v1/");

class SUBUNOAPI {
/* A client for the SUBUNO API.
   See subuno.com for complete API documentation.
   ...
*/
	private $_apikey = NULL;
	private $_server_uri = NULL;

	public function __construct($apikey, $server_uri = SUBUNO_SERVER_URI) {
		$this->_set_authentication_info($apikey, $server_uri);
	}
	
	public function run($data) {
		return $this->_call_server($data);
	}
	
	private function _set_authentication_info($apikey, $server_uri=NULL) {
		$server_uri = ($server_uri !== NULL) ? $server_uri : SUBUNO_SERVER_URI;

		$this->_apikey = $apikey;
		$this->_server_uri = $server_uri;
	}

	private function _call_server($args) {
		if ($this->_apikey) {

			#create data packet.
			$data = array();

			foreach ($args as $i => $value) {
				$data[$i] = $value;
			}

			#add apikey to the data packet.
			$data["apikey"] = $this->_apikey;
			
			#serialize data.
			$urlencoding = http_build_query($data);
			
			$url = $this->_server_uri . "?" . $urlencoding;
						
			#echo($url . "\n");
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$result = curl_exec($ch);
			
			if ($result === false) {
				throw new SUBUNOAPIError("Curl error: " . curl_error($ch));
			}
			curl_close($ch);
			
			$json = json_decode($result, true);
			if ($json === null) {
				throw new SUBUNOAPIError("Value doesn't convert to json object: '" . $json . "'");
			} else {
				return $json;
			}
			
		} else {
			throw new SUBUNOAPIError("API key not set.");
		}
	}
}

class SUBUNOAPIError extends Exception { }

?>
