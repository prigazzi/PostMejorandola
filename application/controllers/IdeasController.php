<?php
class IdeasController extends Zend_Controller_Action
{
	public function init()
	{
		$this->idea = new Service_Idea;
	}

	public function indexAction()
	{
		$this->_redirect('/ideas/mas-votadas');
	}

	public function nuevasAction()
	{
		$this->view->aviso = $this->_getParam('aviso', false);
		$page = $this->_getParam('page', 1);
		$this->view->votadas = $this->idea->getModel()->getEncodedCookie($this->getRequest());
		$this->view->ideas = $this->idea->fetchAll($page);
	}
	
	public function masVotadasAction()
	{
		$page = $this->_getParam('page', 1);
		$this->view->votadas = $this->idea->getModel()->getEncodedCookie($this->getRequest());
		$this->view->ideas = $this->idea->fetchMasVotadas($page);
	}

	public function agregarAction()
	{
        // action body
        $request = $this->getRequest();
        if($request->isPost())
        {
        	$valid = $this->idea->addIdea( $this->getRequest()->getPost() );
        	if($valid) {
        		$this->_redirect('/ideas/nuevas/?aviso=1');
        		/*
        		$this->_helper->redirector('nuevas', 'ideas', 'default', array('aviso' => true));
        		*/
        	}
        }
        
        $this->view->form = $this->idea->getIdeaForm();
	}
	
	public function puntuarAction()
	{
		$value = $this->idea->puntuar($this->getRequest());
		return $this->_helper->json(array('value' => $value));
	}
}
