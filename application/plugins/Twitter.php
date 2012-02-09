<?php
class Plugin_Twitter extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
        $session = new Zend_Session_Namespace('OAUTH_TWITTER');

        if($session->info) {
            $viewr = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
            $viewr->initView();
            $viewr->view->twitterInfo = $session->info;
        }
	}
}