# WHMCS-Plesk-Fixes-Module
This module contains a fix for better Plesk compatibility for the built in WHMCS Plesk provisioning module.

Please note: This module is no longer necessary as WHMCS now has support for stronger passwords for provisioning and the Plesk devs have repaired the ampersands processing issue in the module found on GitHub. I will not be making further changes to this code; if you feel you need it, feel free to use it and modify as you wish.

Fix #1:

If you use the built in WHMCS Plesk provisioning module and set your security policy to "Very Strong" within Plesk, you'll find that automatic provisioning no longer works because WHMCS refuses to generate secure enough passwords. When queried about fixing this, WHMCS responded that since we are choosing to use a security policy it's not up to them to fix this. They recommend that we downgrade our security policty. This seemed absurd to us, so rather than waiting for them to fix it, we built this module to do the job.

WHMCS Error: Error: Error code: 1019. Error message: Your password is not complex enough. According to the server policy, the minimal password strength is Strong. To improve the password strength, use numbers, upper and lower-case characters, and special characters like !,@,#,$,%,^,&,*,?,_,~

Forum Thread: https://forum.whmcs.com/showthread.php?95734-Plesk-Product-Subscription-Password-Security-Error-code-1019-when-plesk-password-reqs-set-to-high

Fix #2:

[THIS IS NO LONGER IN THE CODE AS IT HAS BEEN FIXED IN THE WHMCS PLESK GITHUB MODULE CODE]

An '&' found in client profile data when sent to Plesk for provisioning will prevent the account from creating successfully with the following error. We brought this up to the WHMCS dev team in their forum 2 years ago and yet it hasn't been fixed. So we fixed it.

WHMCS Error: Error code: 1014. Error message: Parser error: Cannot parse the XML from the source specified

Forum Thread: https://forum.whmcs.com/showthread.php?95074-Error-code-1014-Error-message-Parser-error-Cannot-parse-the-XML-from-the-source-specified
