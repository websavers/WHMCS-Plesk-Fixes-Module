<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

define("NEW_PASSWORD_LENGTH", 20);

/**
 * WHMCS only generates 8 character passwords which aren't complex enough
 * for the "Very Strong" security function in Plesk 12+
 * This hook modifies the password prior to provisioning to make it more secure
 **/

add_hook("PreModuleCreate", 2, function($vars){
	
	if ( $vars['params']['moduletype'] == 'plesk' && strlen($vars['params']['password']) <= NEW_PASSWORD_LENGTH ){

		//Change password saved in WHMCS for product
		$command = "updateclientproduct";
		$adminuser = getSettings('plesk_fixes', 'adminuser');
		$values["serviceid"] = $vars['params']['serviceid'];
		$values["servicepassword"] = randomPassword(NEW_PASSWORD_LENGTH);

		$results = localAPI($command,$values,$adminuser);

	}

});

/* Has conditionals to encode/decode HTML entities */

add_hook("PreModuleCreate", 1, "ws_plesk_encode_decode");
add_hook("AfterModuleCreate", 1, "ws_plesk_encode_decode");

function ws_plesk_encode_decode($vars){
	
	if ( $vars['params']['moduletype'] === 'plesk' ){

		$companyname = $vars['params']['clientsdetails']['companyname'];

		// Set up for localAPI call
		$command = "updateclient";
		$adminuser = getSettings('plesk_fixes', 'adminuser');
		//logActivity("Admin User: $adminuser");
		$values["clientid"] = $vars['params']['clientsdetails']['id'];

		if ( strstr($companyname, 'and') ){ //after module, change back

			$values["companyname"] = str_replace('and', '&', $companyname);

			// Change Client Data
			$results = localAPI($command,$values,$adminuser);

		}
		else if ( strstr($companyname, '&') || strstr($companyname, '&amp;') ){ //before module, escape HTML data

			$values["companyname"] = str_replace('&amp;', 'and', $companyname);
			$values["companyname"] = str_replace('&', 'and', $values["companyname"]);
			//logActivity("NAME AFTER CHANGE: " . $values["companyname"]); //DEBUG

			// Change Client Data
			$results = localAPI($command,$values,$adminuser);

		}
		else{
			//No & or 'and' found. Do nothing.
		}

	}

}

/********************
 * Helper Functions *
 ********************/
 
/**
 * Returns:
 * - Associative array containing settings if no settingname provided
 * - value of type stored in DB if settingname is provided 
 */
function getSettings($modulename, $settingname = null){
	
	if ($settingname === null){
		return (array) Capsule::table('tbladdonmodules')->where('module', $modulename)->get();
	}
	else{
		return Capsule::table('tbladdonmodules')->where( array(
				'module' => $modulename, 
				'setting' => $settingname,
			) )->value('value');
	}
		
}

/**
 * Pseudorandom password generator
 * Limitations:
 * - since rand() isn't truly random, it should be replaced with random_int()
 *   if/when you switch to using PHP 7 (probably after WHMCS v7)
 */

function randomPassword($size = 8) {

    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^*?_~';
		$symbols = '!@#$%^*?_~';

    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $size; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
		if ( empty( preg_grep('/[!@#\$%\^&\*\?_~]/', $pass) ) ){ // If no symbols. Add 2
				$pass[rand(0, $alphaLength)] = $symbols[rand(0, strlen($symbols) - 1)];
				$pass[rand(0, $alphaLength)] = $symbols[rand(0, strlen($symbols) - 1)];
		}
    return implode($pass); //turn the array into a string

}

?>
