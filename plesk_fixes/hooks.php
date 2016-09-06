<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");


/**
 * Register Hooks
 */

/* Plesk Password complexity fix */
add_hook("PreModuleCreate",1,"ws_plesk_pre_module_create");

/**
 * WHMCS only generates 8 character passwords which aren't complex enough
 * for the "Very Strong" security function in Plesk 12+
 * This hook modifies the password prior to provisioning to make it more secure
 **/
function ws_plesk_pre_module_create($vars){

	if ($vars['params']['moduletype'] == 'plesk'){

		$command = "updateclientproduct";
		$adminuser = $vars['adminuser'];
		$values["serviceid"] = $vars['params']['serviceid'];
		$values["servicepassword"] = randomPassword(20);

		$results = localAPI($command,$values,$adminuser);

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
