<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");


/**
 * Register Hooks
 */

add_hook("PreModuleCreate",1,"ws_plesk_password_complexity");

/* Has conditionals to encode/decode HTML entities */
add_hook("PreModuleCreate",2,"ws_plesk_encode_decode");
add_hook("AfterModuleCreate",2,"ws_plesk_encode_decode");

/**
 * WHMCS only generates 8 character passwords which aren't complex enough
 * for the "Very Strong" security function in Plesk 12+
 * This hook modifies the password prior to provisioning to make it more secure
 **/

function ws_plesk_password_complexity($vars){

	if (
		$vars['params']['moduletype'] == 'plesk' &&
		strlen($vars['params']['password']) < 9
	){

		//Change password saved in WHMCS for product
		$command = "updateclientproduct";
		$adminuser = $vars['adminuser'];
		$values["serviceid"] = $vars['params']['serviceid'];
		$values["servicepassword"] = randomPassword(20);

		$results = localAPI($command,$values,$adminuser);

	}

}

function ws_plesk_encode_decode($vars){

	if ( $vars['params']['moduletype'] == 'plesk' ){

		$companyname = $vars['params']['clientsdetails']['companyname'];

		// Set up for localAPI call
		$command = "updateclient";
		$adminuser = $vars['adminuser'];
		$values["clientid"] = $vars['params']['clientsdetails']['id'];

		if ( strstr($companyname, ' and ') ){ //after module, change back

			$values["companyname"] = str_replace(' and ', ' & ', $companyname);

			// Change Client Data
			$results = localAPI($command,$values,$adminuser);

		}
		elseif ( strstr($companyname, ' & ') || strstr($companyname, ' &amp; ') ){ //before module, escape HTML data

			$values["companyname"] = str_replace(' & ', ' and ', $companyname);
			$values["companyname"] = str_replace(' &amp; ', ' and ', $values["companyname"]);
			//logActivity("NAME AFTER CHANGE: " . $values["companyname"]); //DEBUG

			// Change Client Data
			$results = localAPI($command,$values,$adminuser);

		}
		else{
			//No ampersands found to deal with
		}

	}

}

/********************
 * Helper Functions *
 ********************/

/**
 * Pseudorandom password generator
 * Limitations:
 * - since rand() isn't truly random, it should be replaced with random_int()
 *   if/when you switch to using PHP 7 (probably after WHMCS v7)
 */

function randomPassword($size = 8) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()-+=~';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $size; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

?>
