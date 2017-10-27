<?php
	error_reporting(E_ALL); 
	ini_set('display_errors', 0);

	$DBhost = "localhost";
	$DBuser = "root";
	$DBpass = "";
	$DBname = "hicheel";
	 
	$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
	    
	$DBcon->query("SET NAMES 'utf8'"); 
	$DBcon->query("SET CHARACTER SET utf8");  
	$DBcon->query("SET SESSION collation_connection = 'utf8_unicode_ci'"); 
    
    if ($DBcon->connect_errno) {
    	die("ERROR : -> ".$DBcon->connect_error);
    }
