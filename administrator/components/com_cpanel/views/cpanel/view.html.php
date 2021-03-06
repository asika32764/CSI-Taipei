<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_cpanel
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * HTML View class for the Cpanel component
 *
 * @package     Joomla.Administrator
 * @subpackage  com_cpanel
 * @since       1.0
 */
class CpanelViewCpanel extends JViewLegacy
{
	/**
	 * Array of cpanel modules
	 *
	 * @var  array
	 */
	protected $modules = null;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 */
	public function display($tpl = null)
	{
		// Set toolbar items for the page
		JToolbarHelper::title(JText::_('COM_CPANEL'), 'home-2 cpanel');
		JToolbarHelper::help('screen.cpanel');

		$input = JFactory::getApplication()->input;

		/*
		 * Set the template - this will display cpanel.php
		 * from the selected admin template.
		 */
		$input->set('tmpl', 'cpanel');

		// Display the cpanel modules
		$this->modules = JModuleHelper::getModules('cpanel');

		// Removed for CMF';
$this->postinstall_message_count = 0;

		parent::display($tpl);
	}
}
