<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

/*
**********************************************

   *** Plesk Fixes ***

This addon fixes some problems with WHMCS and Plesk provisioning

Most important code for this addon is found in the hooks.php file.

**********************************************
*/

function plesk_fixes_config() {
    $configarray = array(
	    "name" => "Plesk Fixes",
	    "version" => "1.0",
	    "author" => "Websavers Inc",
	    "language" => "english",
	    "fields" => array(
				"adminuser" => array (
						"FriendlyName" => "Admin User",
						"Type" => "text",
						"Size" => "25",
						"Description" => "Supply an admin username that has full privileges",
						"Default" => "admin",
					),
    	),
		);
    return $configarray;
}

function plesk_fixes_activate() {

    # Return Result
    return array('status'=>'success','description'=>'Congrats! The module is now activated.');
    return array('status'=>'error','description'=>'Sorry, for some reason we couldn\'t activate this addon for WHMCS');
    return array('status'=>'info','description'=>'Sup?');

}

function plesk_fixes_deactivate() {

    # Return Result
    return array('status'=>'success','description'=>'The addon has been successfully deactivated');
    return array('status'=>'error','description'=>'Couldn\'t deactivate. WTF?');
    return array('status'=>'info','description'=>'Sup?');

}

function plesk_fixes_upgrade($vars) {

    $version = $vars['version'];

}

/***** Admin View *****/

function plesk_fixes_output($vars) {

    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $LANG = $vars['_lang'];

    echo '<p>'.$LANG['intro'].'</p>
	<p>'.$LANG['description'].'</p>
	<p>'.$LANG['documentation'].'</p>';

}





?>
