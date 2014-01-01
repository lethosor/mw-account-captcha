<?php
class SpecialAccountCaptcha extends SpecialPage {
        public static $usernameForm = <<<HTML
<form>
    <input type="text" name="username">
    <input type="submit" name="submit" value="Get token">
</form>
HTML;
        public static function getTokenHTML($token) {
        return <<<HTML
<h3 id="accountcaptcha-token">$token</h3>
HTML;
        }
        
	function __construct() {
		parent::__construct('AccountCaptcha');
	}
 
	function execute($par) {
		$request = $this->getRequest();
		$output = $this->getOutput();
                $output->setPageTitle('Account creation token');
		$username = $request->getText('username');
                if (!$username) {
                    $output->addHtml($this->msg('accountcaptcha-form-text')->parse());
                    $output->addHTML(self::$usernameForm);
                }
                else {
                    $output->addHtml($this->msg('accountcaptcha-result-text')->parse());
                    $token = $username;
                    global $ACTokenFunctions;
                    foreach ($ACTokenFunctions as $func) {
                        $token = call_user_func($func, $token);
                    }
                    $output->addHTML(self::getTokenHTML($token));
                }
 	}
}
