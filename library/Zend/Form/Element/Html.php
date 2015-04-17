<?php
require_once 'Zend/Form/Element/Xhtml.php';
class Zend_Form_Element_Html extends Zend_Form_Element_Xhtml
{
    /**
     * Use formHidden view helper by default
     * @var string
     */
    public $helper = 'formNote';
	public function isValid($value, $context = null) { return true; }
}
