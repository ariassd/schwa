<?php
	error_reporting(E_ALL);
  	ini_set('display_errors', 1);
	  
	require_once("service-abbyylingvo.php");  
	
	echo ABBYAuth();
	
	//var_dump (ABBYTranslation('about'));
	  
	  
	/*include("PhoneticTranscriber.php");
	
	  
	$trn = new GGG\Language\PhoneticTranscriber;
	
	echo $trn->transcribe("common");
	echo "<br/>------";*/