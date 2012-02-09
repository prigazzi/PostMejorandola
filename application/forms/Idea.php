<?php
class Form_Idea extends Zend_Form
{
	public function init()
	{
		$this->setAttrib('id', 'ideaForm')
			 ->setAttrib('enctype', 'multipart/form-data');
		
		/* --- Primera Parte --- */	 
		$this->addElement('textarea', 'idea', array(
			'label' => 'Contanos tu idea',
			'required' => true,
			'cols' => 60,
			'rows' => 6,
			'description' => 'Contanos tu idea, de la manera más breve posible.'
		));
		
		$this->addElement('submit', 'submit', array(
			'label' => 'Envianos tu Idea',
			'ignore' => true,
			'required' => false,
			'class' => 'submit-right'
		));
	}
}