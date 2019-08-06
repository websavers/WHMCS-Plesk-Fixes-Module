<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

/**
 * WHMCS only generates 8 character passwords which aren't complex enough
 * for the "Very Strong" security function in Plesk 12+
 * This hook modifies the password prior to provisioning to make it more secure
 **/

add_hook("PreModuleCreate", 2, function($vars){
	
	if ( $vars['params']['moduletype'] == 'plesk' ){

		//Change password saved in WHMCS for product
		$values["serviceid"] = $vars['params']['serviceid'];
		$password = decrypt($vars['params']['password'], $cc_encryption_hash) 
		$values["servicepassword"] = $password . "!!!AZ"; //append chars to better match policy

		$results = localAPI("updateclientproduct",$values);

	}

});

?>
