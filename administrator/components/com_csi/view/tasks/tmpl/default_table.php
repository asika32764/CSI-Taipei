<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\Data\Data;

// No direct access
defined('_JEXEC') or die;

// Prepare script
JHtmlBehavior::multiselect('adminForm');

/**
 * Prepare data for this template.
 *
 * @var $container Windwalker\DI\Container
 * @var $data      Windwalker\Data\Data
 * @var $asset     Windwalker\Helper\AssetHelper
 * @var $grid      Windwalker\View\Helper\GridHelper
 * @var $date      \JDate
 */
$container = $this->getContainer();
$asset     = $container->get('helper.asset');
$grid      = $data->grid;
$date      = $container->get('date');

// Set order script.
$grid->registerTableSort();
?>

<!-- LIST TABLE -->
<table id="taskList" class="table table-striped table-bordered adminlist">

<!-- TABLE HEADER -->
<thead>
<tr>
	<!--CHECKBOX-->
	<th width="1%" class="center">
		<?php echo JHtml::_('grid.checkAll'); ?>
	</th>

	<th class="center">
		Entry ID
	</th>

	<th class="center">
		Engine
	</th>

	<!--TITLE-->
	<th class="center">
		<?php echo $grid->sortTitle('JGLOBAL_TITLE', 'task.title'); ?>
	</th>

	<th class="center" width="40%">
		Keyword
	</th>

	<!--ID-->
	<th width="1%" class="nowrap center">
		<?php echo $grid->sortTitle('JGRID_HEADING_ID', 'task.id'); ?>
	</th>
</tr>
</thead>

<!--PAGINATION-->
<tfoot>
<tr>
	<td colspan="15">
		<div class="pull-left">
			<?php echo $data->pagination->getListFooter(); ?>
		</div>
	</td>
</tr>
</tfoot>

<!-- TABLE BODY -->
<tbody>
<?php foreach ($data->items as $i => $item)
	:
	// Prepare data
	$item = new Data($item);

	// Prepare item for GridHelper
	$grid->setItem($item, $i);
	?>
	<tr class="task-row" sortable-group-id="<?php echo $item->catid; ?>">
		<!--CHECKBOX-->
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->task_id); ?>
		</td>

		<td class="center">
			<?php echo $item->entry_id; ?>
		</td>

		<td class="center">
			<?php echo $item->engine ?>
		</td>

		<!--TITLE-->
		<td class="n/owrap has-context quick-edit-wrap">
			<div class="item-title">
				<!-- Title -->
				<?php echo $grid->editTitle(); ?>
			</div>
		</td>

		<td>
			<span style="font-family: monospace, serif;">
				<?php echo $item->keyword; ?>
			</span>
		</td>

		<!--ID-->
		<td class="center">
			<?php echo (int) $item->id; ?>
		</td>

	</tr>
<?php endforeach; ?>
</tbody>
</table>
