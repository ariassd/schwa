<?php
	
	$app_key = "NDA5YWNkN2QtNDhhMi00ZmIxLTljZjMtZTNiMmVmZjYxZGJmOjc4NmFmNTdhYjQ4YjRiOTE5OTA5MmFkNTE5MjdhZTU4";
	$base_url = "https://developers.lingvolive.com/";
	
	function ABBYAuth() {
		global $base_url;
		global $app_key;
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_URL, $base_url."api/v1.1/authenticate");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	  		'Authorization:'. "Basic ".$app_key
		));
		$result = curl_exec($curl);
	    curl_close($curl);
	    return $result;
	}
	
	function ABBYTranslation($word)
	{
		global $base_url;
		if (!empty($word)) {
			$result = CallAPI(ABBYAuth(),"GET", $base_url."api/v1/Translation?text=".$word."&srcLang=1033&dstLang=1034&isCaseSensitive=false");
			$arrObj = json_decode($result, true);
			$status = "ok";
			if (!isset($arrObj)) { $status = "error"; }
			$audio = NULL;
			return $result;
			/*
			return (object)array(
				"status" => $status,
				"word" => $word,
			    "audio" => $audio, 
			    "phonetic" => $arrObj["results"][0]["lexicalEntries"][0]["pronunciations"][0]["phoneticSpelling"],
				"definitions" => $arrObj["results"][0]["lexicalEntries"][0]["entries"][0]["senses"],
			);
			*/
		}
	}
	
	
	
	
	// Method: POST, PUT, GET etc
	// Data: array("param" => "value") ==> index.php?param=value
	function CallAPI($token, $method, $url, $data = false)
	{
		global $app_id;
		global $app_key;
		global $base_url;
	    $curl = curl_init();
	
	    switch ($method)
	    {
	        case "POST":
	            curl_setopt($curl, CURLOPT_POST, 1);
	
	            if ($data)
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            break;
	        case "PUT":
	            curl_setopt($curl, CURLOPT_PUT, 1);
	            break;
	        default:
	            if ($data)
	                $url = sprintf("%s?%s", $url, http_build_query($data));
	    }
		
	    //Optional Authentication:
	    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");
	
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	  		'Authorization:'. "Bearer ".$token
		));
		
	    $result = curl_exec($curl);
	    curl_close($curl);
		
	    return $result;
	}