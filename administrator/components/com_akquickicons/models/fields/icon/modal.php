<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_akquickicons
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

include_once JPATH_ADMINISTRATOR.'/components/com_akquickicons/includes/core.php' ;
JForm::addFieldPath( AKPATH_FORM.'/fields');
JFormHelper::loadFieldClass('Modal');

/**
 * Supports a modal article picker.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class JFormFieldIcon_Modal extends JFormFieldModal
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Icon_Modal';
	
	protected $view_list = 'icons' ;
	
	protected $view_item = 'icon' ;
	
	protected $extension = 'com_akquickicons' ;
	
	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	public function getInput()
	{
		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal');
		$this->setElement();
		

		// Build the script.
		$script = array();
		$script[] = '	function jSelect'.ucfirst($this->component).'_'.$this->id.'(id, title) {';
		$script[] = '		document.id("'.$this->id.'_id").value = id;';
		$script[] = '		document.id("'.$this->id.'_name").value = title;';
		$script[] = '		$$("#'.$this->id.'_preview i").set("class", "ak"+title)';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));


		// Setup variables for display.
		$html	= array();
		$link	= $this->getLink();

		$class 	= $this->value;

		if (empty($class)) {
			$class = JText::_('COM_'.strtoupper($this->component).'_SELECT_ITEM');
		}
		$class = htmlspecialchars($class, ENT_QUOTES, 'UTF-8');
		
		if( JVERSION >=3 ){
			// The current user display field.
			$html[] = '<span class="input-append input-prepend">';
			$html[] = '<div class="media-preview add-on" id="'.$this->id.'_preview"><i class="'.$class.'"></i></div>' ;
			$html[] = '<input type="text" class="input-medium" id="'.$this->id.'_name" value="'.$class.'" disabled="disabled" size="35" /><a class="modal btn" title="'.JText::_('COM_'.strtoupper($this->component).'_CHANGE_ITEM_BUTTON').'"  href="'.$link.'&amp;'.JSession::getFormToken().'=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}"><i class="icon-file"></i> '.JText::_('JSELECT').'</a>';
			$html[] = '</span>';
		}else{
			// The current user display field.
			$html[] = '<div class="fltlft">';
			$html[] = '  <input type="text" id="'.$this->id.'_name" value="'.$class.'" disabled="disabled" size="35" />';
			$html[] = '</div>';
	
			// The user select button.
			$html[] = '<div class="button2-left">';
			$html[] = '  <div class="blank">';
			$html[] = '	<a class="modal" title="'.JText::_('COM_'.strtoupper($this->component).'_CHANGE_ITEM').'"  href="'.$link.'&amp;'.JSession::getFormToken().'=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">'.JText::_('COM_'.strtoupper($this->component).'_CHANGE_ITEM_BUTTON').'</a>';
			$html[] = '  </div>';
			$html[] = '</div>';
		}
		

		// The active article id field.
		//if (0 == (int)$this->value) {
		//	$value = '';
		//} else {
		//	$value = $this->value;
		//}

		// class='required' for client side validation
		$class = '';
		if ($this->required) {
			$class = ' class="required modal-value"';
		}

		$html[] = '<input type="hidden" id="'.$this->id.'_id"'.$class.' name="'.$this->name.'" value="'.$this->value.'" />';

		return implode("\n", $html);
	}
	
	
	/*
	 * function getLink
	 * @param 
	 */
	
	public function getLink()
	{
		// Avoid self
		$id 	= JRequest::getVar('id') ;
		$option = JRequest::getVar('option') ;
		$view 	= JRequest::getVar('view') ;
		$layout = JRequest::getVar('layout') ;
		$params = '' ;
		
		$select = (string) $this->element['select'] ;
		$params .= "&select={$select}" ;
		
		return 'index.php?option='.$this->extension.'&view='.$this->view_list.$params.'&layout=modal&tmpl=component&function=jSelect'.ucfirst($this->component).'_'.$this->id ;
	}
	
}
