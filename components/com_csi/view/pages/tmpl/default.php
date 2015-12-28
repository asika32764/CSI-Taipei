<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\View\Layout\FileLayout;

// No direct access
defined('_JEXEC') or die;

// Prepare script
// JHtmlBootstrap::tooltip();
JHtmlFormbehavior::chosen('select');
// JHtmlDropdown::init();

$doc = JFactory::getDocument();

$doc->addStyleSheet('administrator/templates/isis3/css/template.css');

/**
 * Prepare data for this template.
 *
 * @var Windwalker\DI\Container $container
 */
$container = $this->getContainer();
?>
<style>
	.table td.title-cell
	{
		word-break: break-all;
	}
</style>
<div id="csi" class="windwalker tasks tablelist row-fluid">
	<form action="<?php echo JURI::getInstance(); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

		<?php if (!empty($this->data->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
			<h4 class="page-header"><?php echo JText::_('JOPTION_MENUS'); ?></h4>
			<?php echo $this->data->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
		<?php else: ?>
		<div id="j-main-container">
		<?php endif;?>

			<h2>頁面總覽 <small class="text-mute"><?php echo $data->task->title; ?></small></h2>

			<hr />

			<?php echo with(new FileLayout('joomla.searchtools.default'))->render(array('view' => $this->data)); ?>

			<?php echo $this->loadTemplate('table'); ?>

			<!-- Hidden Inputs -->
			<div id="hidden-inputs">
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="boxchecked" value="0" />
				<input type="hidden" name="field" value="" id="result_field" />
				<input type="hidden" name="value" value="" id="result_value" />
				<?php echo JHtml::_('form.token'); ?>
			</div>

		</div>
	</form>
</div>
