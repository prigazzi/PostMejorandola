<?php
class Model_DbTable_Localidades extends Zend_Db_Table_Abstract
{
		protected $_name = 'Localidades';
		protected $_rowClass = 'LocalidadesRow';

		protected $_referenceMap = array(
			'Provincia' => array(
				'columns' => 'Provincias_id',
				'refTableClass' => 'Banca_Model_DbTable_Provincias',
				'refColumns' => 'id'
			));

}

class LocalidadesRow extends Zend_Db_Table_Row
{
	public function __toString()
	{
		return $this->nombre;
	}
}