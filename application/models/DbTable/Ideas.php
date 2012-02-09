<?php
class Model_DbTable_Ideas extends Zend_Db_Table_Abstract
{
    protected $_name = 'Ideas';
    protected $_rowClass = 'IdeasRow';
}

class IdeasRow extends Zend_Db_Table_Row {}