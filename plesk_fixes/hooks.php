<?php

use WHMCS\Database\Capsule;

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

/**
 * WHMCS only generates 8 character passwords which aren't complex enough
 * for the "Very Strong" security function in Plesk 12+
 * This hook modifies the password prior to provisioning to make it more secure
 **/

add_hook("PreModuleCreate", 0, function($vars){
	
	//logActivity( "Service ID " . $vars['params']['serviceid'] . " with Password: " . $vars['params']['password'] ); ///DEBUG
	
	//14 is the default 'secure' password length that WHMCS creates
	if ( $vars['params']['moduletype'] == 'plesk' && strlen($vars['params']['password']) <= 14 ){

		$newpassword = $vars['params']['password'] . getchars(8); //append 8 chars to match Plesk policy
		
		//Change password saved in WHMCS for product
		$results = localAPI("updateclientproduct", array(
			'serviceid' => $vars['params']['serviceid'],
			'servicepassword' => $newpassword,
		));
		
		if ($results['result'] != 'success') {
		  logActivity( "[Plesk Fixes Module] An Error Occurred: " . $results['result'] );
		}
		else{
			return array( //Send new data directly to module create function (so says the docs)
				'password' => $newpassword,
			);
		}
		
	}

});

function getchars($str_len){
	$str = '';
	for($i = 0; $i < $str_len; $i++){
		if ($i % 2 == 0){ //generate a letter when even, symbol when odd
	    $str .= chr(rand(65, 90)); //65 = ascii for 'A' / 90 = ascii for 'Z'
		}
		else{
			$symbols = '!@#$%^*?_~'; //Plesk supported symbols minus & due to WHMCS weirdness
			$str .= $symbols[rand(0, strlen($symbols) - 1)]; 
		}
	}
	return $str;
}

?>
