<?php

class Model_Idea {

    protected $_daos = array();
    protected $_transferAdapter = NULL;
    protected $_count = 10;

    public function find($id) {
        $idea = $this->getIdeaDao()->find($id);
        if (1 == count($idea))
            return $idea->current();
        else
            return $idea;
    }

    public function fetchAll($page = 1, $count = NULL) {
        if (NULL == $count) {
            $count = $this->getPageCount();
        }
        $select = $this->getIdeaDao()->select()
                ->where('aprobada = 1')
                ->order('fecha desc');

        return $this->getPaginator($select, $page, $count);
    }

    public function fetchMasVotadas($page = 1, $count = NULL) {
        if (NULL == $count) {
            $count = $this->getPageCount();
        }
        $select = $this->getIdeaDao()->select()
                ->where('aprobada = 1')
                ->order('votos desc')
                ->order('fecha desc');

        return $this->getPaginator($select, $page, $count);
    }

    public function fetchEnModeracion($page = 1, $count = NULL) {
        if (NULL == $count) {
            $count = $this->getPageCount();
        }
        $select = $this->getIdeaDao()->select()
                ->where('aprobada = 0')
                ->order('fecha desc');

        return $this->getPaginator($select, $page, $count);
    }

    protected function getPaginator($select, $page = 1, $count = 10) {
        $p = new Zend_Paginator(new Zend_Paginator_Adapter_DbTableSelect($select));
        return $p->setCurrentPageNumber($page)->setItemCountPerPage($count);
    }

    public function save($data) {
        $dao = $this->getIdeaDao();
        $user = $dao->createRow($data);

        return $user->save();
    }

    public function uploadFile() {
        $adapter = $this->getFileTransferAdapter();
        if (!$adapter->isUploaded('archivo')) {
            return NULL;
        }

        $target = time() . '-' . $adapter->getFilename('archivo', false);
        $adapter->addFilter('Rename', array(
            'target' => $target, 'overwrite' => true)
        );

        if ($adapter->receive()) {
            return $target;
        } else {
            var_dump($adapter->getMessages());
            die;
        }
    }

    public static function getFileExtension($filename) {
        $filename = strtolower($filename);
        $exts = split("[/\\.]", $filename);
        return $exts[count($exts) - 1];
    }

    public function getFileTransferAdapter() {
        if (NULL == $this->_transferAdapter) {
            $this->_transferAdapter = new Zend_File_Transfer_Adapter_Http;
        }
        return $this->_transferAdapter;
    }

    public function setFileTransferAdapter(Zend_File_Transfer_Adapter_Abstract $adapter) {
        $this->_transferAdapter = $adapter;
        return $this;
    }

    public function getPageCount() {
        return $this->_count;
    }

    public function getEncodedCookie($request) {
        $cookie = $request->getCookie('puntuados', NULL);
        if (!$cookie) {
            return array();
        }
        return unserialize(base64_decode($request->getCookie('puntuados')));
    }

    public function setEncodedCookie($cookie) {
        $value = base64_encode(serialize($cookie));
        setcookie('puntuados', $value, time() + 60 * 60 * 24 * 90, '/');
        return $this;
    }

    public function getIdeaDao() {
        if (empty($this->_daos['idea'])) {
            $this->_daos['idea'] = new Model_DbTable_Ideas;
        }

        return $this->_daos['idea'];
    }

}