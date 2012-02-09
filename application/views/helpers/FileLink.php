<?php
class Zend_View_Helper_FileLink extends Zend_View_Helper_Abstract
{
	public function fileLink($file = NULL)
	{
		if(NULL != $file)
		{
			$ext = $this->getFileExtension($file);
			$text = basename($file);
			return "<a target='_blank' class='$ext file' href='/uploads/$file'>$text</a>";	
		} else {
			return false;
		}
		
	}
	
	public function getFileExtension($filename)
	{
		return Model_Idea::getFileExtension($filename);
	}
}