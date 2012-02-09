<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
		$autoloader = new Zend_Application_Module_Autoloader(array(
			'namespace'	=> '',
			'basePath'	=> dirname(__FILE__),
		));
		return $autoloader;
	}

	protected function _initActionHelpers()
	{
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/plugins/helpers',
                                             'Action_Helper');
		Zend_Controller_Action_HelperBroker::addHelper(new ZendX_JQuery_Controller_Action_Helper_AutoComplete());
	}
	
	protected function _initConstants()
	{
		defined('UPLOAD_URL') || define('UPLOAD_URL', '/uploads');
		defined('UPLOAD_PATH') || define('UPLOAD_PATH', getenv('UPLOAD_PATH') ? getenv('UPLOAD_PATH') : realpath(APPLICATION_PATH.'/../public'.UPLOAD_URL)); 
	}
	
	protected function _initTranslation()
	{
		$translate = new Zend_Translate(
			'ini', 
			APPLICATION_PATH.'/../languages/es/forms.ini',
			'es');
		$translate->setLocale('es');
		Zend_Validate_Abstract::setDefaultTranslator($translate);
	}
}

