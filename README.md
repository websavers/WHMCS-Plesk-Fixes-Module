# WHMCS-Plesk-Fixes-Module
This module contains whatever repairs are currently necessary for better Plesk compatibility for the built in WHMCS Plesk provisioning module.

Please note: This module *only* includes fixes that apply to the latest release of WHMCS, so any fixes needed for either earlier versions or older versions of the Plesk module have been removed. The fixes included are listed below:

### Strong Passwords Fix

If you use the built in WHMCS Plesk provisioning module and you have Plesk configured with a security policy of "Very Strong", you'll find that automatic provisioning no longer works because WHMCS does not generate secure enough passwords (although the latest releases of WHMCS are *very* close). WHMCS tried to fix this by introducing more secure password generation for modules with newer releases of WHMCS, however it's still not up to snuff for the most secure policy in Plesk. You'll get errors like:

> WHMCS Error: Error: Error code: 1019. Error message: Your password is not complex enough. According to the server policy, the minimal password strength is Strong. To improve the password strength, use numbers, upper and lower-case characters, and special characters like !,@,#,$,%,^,&,*,?,_,~

Related Forum Thread: https://forum.whmcs.com/showthread.php?95734-Plesk-Product-Subscription-Password-Security-Error-code-1019-when-plesk-password-reqs-set-to-high