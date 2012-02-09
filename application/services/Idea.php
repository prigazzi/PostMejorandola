<?php

class Service_Idea {

    protected $_forms = array();
    protected $_model = NULL;

    public function addIdea($data) {
        $form = $this->getIdeaForm();
        if ($form->isValid($data)) {
            $model = $this->getModel();
            $values = $form->getValues();

            $session = new Zend_Session_Namespace('OAUTH_TWITTER');
            $values['nombre']  = $session->info->name;
            $values['twitter'] = $session->info->screen_name;
            $values['avatar']  = $session->info->profile_image_url;

            return $model->save($values);
        } else {
            return FALSE;
        }
    }

    public function puntuar($request) {
        $idea = $this->getModel()->find($request->getParam('id'));
        $puntuados = $this->getModel()->getEncodedCookie($request);
        switch (trim($request->getParam('opcion'))) {
            case 'gusta':
                $idea->votos+=1;
                break;
            case 'nogusta':
                $idea->votos-=1;
                break;
        }
        if ($idea->save()) {
            $this->marcarPuntuado($request);
        }
        return $idea->votos;
    }

    public function marcarPuntuado($request) {
        $id = $request->getParam('id');
        $model = $this->getModel();
        $cookie = $model->getEncodedCookie($request);
        $cookie[$id] = $id;
        $model->setEncodedCookie($cookie);
    }

    public function fetchIdea($id) {
        return $this->getModel()->find($id);
    }

    public function fetchAll($page = 1, $count = NULL) {
        return $this->getModel()->fetchAll($page, $count);
    }

    public function fetchMasVotadas($page = 1, $count = NULL) {
        return $this->getModel()->fetchMasVotadas($page, $count);
    }

    public function fetchEnModeracion($page = 1, $count = NULL) {
        return $this->getModel()->fetchEnModeracion($page, $count);
    }

    public function getModel() {
        if (NULL == $this->_model) {
            $this->_model = new Model_Idea;
        }

        return $this->_model;
    }

    public function getIdeaForm() {
        if (empty($this->_forms['idea'])) {
            $this->setIdeaForm(new Form_Idea);
        }

        return $this->_forms['idea'];
    }

    public function setIdeaForm(Zend_Form $form) {
        $this->_forms['idea'] = $form;
        return $this;
    }

}
