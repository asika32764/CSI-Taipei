<?php

/**
 * Class CsiHelper
 *
 * @since 1.0
 */
abstract class CsiHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName)
	{
		$app       = \JFactory::getApplication();
		$inflector = \JStringInflector::getInstance(true);

		// Add Category Menu Item
		if ($app->isAdmin())
		{
			JHtmlSidebar::addEntry(
				JText::_('JCATEGORY'),
				'index.php?option=com_categories&extension=com_csi',
				($vName == 'categories')
			);
		}

		foreach (new \DirectoryIterator(JPATH_ADMINISTRATOR . '/components/com_csi/view') as $folder)
		{
			if ($folder->isDir() && $inflector->isPlural($view = $folder->getBasename()))
			{
				$name = \JText::_('COM_CSI_VIEW_' . strtoupper($view));

				JHtmlSidebar::addEntry(
					JText::sprintf('LIB_WINDWALKER_TITLE_LIST', $name),
					'index.php?option=com_csi&view=' . $view,
					($vName == $view)
				);
			}
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   string  $option  Action option.
	 *
	 * @return  JObject
	 *
	 * @since   1.0
	 */
	public static function getActions($option = 'com_csi')
	{
		$user   = JFactory::getUser();
		$result = new \JObject;

		$actions = array(
			'core.admin',
			'core.manage',
			'core.create',
			'core.edit',
			'core.edit.own',
			'core.edit.state',
			'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $option));
		}

		return $result;
	}
}
