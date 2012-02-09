<?php

class ModeracionController extends Zend_Controller_Action implements Zend_Auth_Adapter_Interface
{
    protected $_loginData = array();
	
	
    public function init()
    {
        if('login' != $this->getRequest()->getActionName() 
            && !Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/moderacion/login');            
        }

        /* Initialize action controller here */
    	$this->idea = new Service_Idea;
    }

    public function indexAction()
    {
        $page = $this->_getParam('page', 1);
    	$this->view->ideas = $this->idea->fetchEnModeracion($page);
    }
    
    public function ideaAction()
    {
    	if($this->getRequest()->isPost())
    	{
            $idea = $this->idea->fetchIdea($this->_getParam('id'));
            switch($this->_getParam('accion'))
            {
                    case 'aprobar':
                            $idea->aprobada = 1;
                            $idea->save();
                            break;
                    case 'eliminar':
                            $idea->delete();
                            break;
            }
            return $this->_helper->json(array(
                'accion' => $this->_getParam('accion'),
                'id' => $this->_getParam('id')));
    	}
    }

    public function loginAction()
    {
    	if($this->getRequest()->isPost())
    	{
            $this->_loginData = $this->getRequest()->getPost();
            $r = Zend_Auth::getInstance()->authenticate($this);
            if($r->isValid())
            {
                    $this->_helper->redirector('index', 'moderacion');
            } else {
                    $this->view->error = true;
            }
    	}
    }

    public function authenticate()
    {
        $data = $this->_loginData;
    	
    	if($data['usuario'] == 'moderador' && $data['password'] == 'preceptouno') {
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, 'moderador');
    	} else {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE, '');
    	}
    }
}

