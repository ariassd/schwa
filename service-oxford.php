<?php
	
	$app_id = "42243392";
	$app_key = "2ba6bb8eaf2ccf32752bc30ab0e49bc0";
	$base_url = "https://od-api.oxforddictionaries.com/api/v1/";
	
	
	function GetWord($word)
	{
		global $base_url;
		if (!empty($word)) {
			$result = CallAPI("GET", $base_url."entries/en/".$word);
			$arrObj = json_decode($result, true);
			$status = "ok";
			if (!isset($arrObj)) { $status = "error"; }
			$audio = NULL;
			if (isset($arrObj["results"][0]["lexicalEntries"][0]["pronunciations"][0]["audioFile"])) {
				$audio = $arrObj["results"][0]["lexicalEntries"][0]["pronunciations"][0]["audioFile"];
			}
			
			return (object)array(
				"status" => $status,
				"word" => $word,
			    "audio" => $audio, 
			    "phonetic" => $arrObj["results"][0]["lexicalEntries"][0]["pronunciations"][0]["phoneticSpelling"],
				"definitions" => $arrObj["results"][0]["lexicalEntries"][0]["entries"][0]["senses"],
			);
		}
	}
	
	
	
	
	// Method: POST, PUT, GET etc
	// Data: array("param" => "value") ==> index.php?param=value
	function CallAPI($method, $url, $data = false)
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
			 'Accept:'. "application/json",
		     'app_id:'. $app_id,
		    'app_key:'. $app_key
		));
		
	    $result = curl_exec($curl);
	    curl_close($curl);
		
	    return $result;
	}