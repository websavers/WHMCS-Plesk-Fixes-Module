# WHMCS-Plesk-Fixes-Module
This module contains a set of fixes for better Plesk compatibility for the built in WHMCS Plesk provisioning module.

Fix #1 (Confirmed working):

If you use the built in WHMCS Plesk provisioning module and set your security policy to "Very Strong" within Plesk, you'll find that automatic provisioning no longer works because WHMCS refuses to generate secure enough passwords. When queried about fixing this, WHMCS responded that since we are choosing to use a security policy it's not up to them to fix this. They recommend that we downgrade our security policty. This seemed absurd to us, so rather than waiting for them to fix it, we built this module to do the job.

  https://forum.whmcs.com/showthread.php?95734-Plesk-Product-Subscription-Password-Security-Error-code-1019-when-plesk-password-reqs-set-to-high

Fix #2 (Not fixed yet):

An '&' found in client profile data when sent to Plesk for provisioning will prevent the account from creating successfully and therefore breaks automation. We brought this up to the WHMCS dev team in their forum 2 years ago and yet it hasn't been fixed. So we fixed it.

https://forum.whmcs.com/showthread.php?95074-Error-code-1014-Error-message-Parser-error-Cannot-parse-the-XML-from-the-source-specified
