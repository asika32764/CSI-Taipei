<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\Bootstrap\Dropdown;

// No direct access
defined('_JEXEC') or die;

/**
 * Prepare data for this template.
 *
 * @var $data Windwalker\Data\Data
 * @var $grid Windwalker\View\Helper\GridHelper
 * @var $item Windwalker\Data\Data
 */
$grid = $data->grid;
$item = $grid->current;

// Duplicate
Dropdown::duplicate($grid->row, 'schools.batch');

Dropdown::divider();

// Published & Unpublished
if ($item->state)
{
	Dropdown::unpublish($grid->row, 'schools.state');
}
else
{
	Dropdown::publish($grid->row, 'schools.state');
}

// Trash & Delete
if (JDEBUG || $data->state->get('filter.school.state') == -2)
{
	Dropdown::addCustomItem(\JText::_('JTOOLBAR_DELETE'), 'delete', $grid->row, 'schools.state.delete');
}
else
{
	Dropdown::trash($grid->row, 'schools.state');
}

// Render it
echo Dropdown::render();
