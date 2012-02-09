<?php
class LoginController extends Zend_Controller_Action
{
	public function twitterAction()
	{
		$session  = new Zend_Session_Namespace('OAUTH_TWITTER');
		$consumer = new Zend_Oauth_Consumer(array(
			'callbackUrl'		=> 'http://bancodeideas.local/login/twitter',
			'siteUrl'			=> 'http://twitter.com/oauth',
			'consumerKey'		=> 'PjxBFcI0SQZ5AldrQSxFrw',
			'consumerSecret'	=> '0TQb5OpMFrzF2aW5PtXgyFuWblLIyPnor2WlA',
		));

		if($this->_getParam('oauth_token')) {
			$session->token = $consumer->getAccessToken(
				$_GET,
				unserialize($session->request_token)
			);

			$twitter = new Zend_Service_Twitter(array(
				'accessToken' 	=> $session->token,
			));

			$twitterInfo = $twitter->account->verifyCredentials();
			$session->info = json_decode(json_encode($twitterInfo->getIterator(), true));

			return $this->_redirect('/');
		}

		$session->request_token = serialize($consumer->getRequestToken());
		$consumer->redirect();
		exit;
	}

	public function logoutAction() {
		Zend_Session::destroy();
		$this->_redirect('/ideas/mas-votadas');
	}
}