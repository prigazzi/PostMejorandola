<?php
class Model_DbTable_Provincias extends Zend_Db_Table_Abstract
{
		protected $_name = 'Provincias';
		protected $_dependentTables = array('Localidades');
}