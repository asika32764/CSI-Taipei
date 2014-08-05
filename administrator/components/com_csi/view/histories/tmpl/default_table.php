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
<table id="historyList" class="table table-striped adminlist table-bordered">

<!-- TABLE HEADER -->
<thead>
<tr>
	<!--CHECKBOX-->
	<th width="1%" class="center">
		<?php echo JHtml::_('grid.checkAll'); ?>
	</th>

	<th class="center" width="5%">
		<?php echo $grid->sortTitle('會員 ID', 'user.name'); ?>
	</th>

	<th class="center">
		<?php echo $grid->sortTitle('會員名稱', 'user.name'); ?>
	</th>

	<th class="center">
		<?php echo $grid->sortTitle('Entry', 'entry.id'); ?>
	</th>

	<th class="center">
		<?php echo $grid->sortTitle('Task', 'task.id'); ?>
	</th>

	<th class="center">
		<?php echo $grid->sortTitle('Page', 'page.title'); ?>
	</th>

	<th class="center">
		<?php echo $grid->sortTitle('Result', 'history.result_name'); ?>
	</th>

	<th class="center">
		<?php echo $grid->sortTitle('Before', 'history.before'); ?>
	</th>

	<th class="center">
		<?php echo $grid->sortTitle('After', 'history.after'); ?>
	</th>

	<!--ID-->
	<th width="1%" class="nowrap center">
		<?php echo $grid->sortTitle('JGRID_HEADING_ID', 'history.id'); ?>
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
	<tr class="history-row" sortable-group-id="<?php echo $item->catid; ?>">

		<!--CHECKBOX-->
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->history_id); ?>
		</td>

		<td class="center">
			<?php echo $item->user_id; ?>
		</td>

		<td class="center">
			<?php echo $item->name; ?>
		</td>

		<td class="center">
			<?php echo $item->entry_title; ?>
		</td>

		<td class="center">
			<?php echo $item->task_database; ?>
		</td>

		<td class="center">
			<?php echo $item->page_title; ?>
		</td>

		<td class="center">
			<?php echo $item->result_name; ?>
		</td>

		<td class="center">
			<?php echo $item->before; ?>
		</td>

		<td class="center">
			<?php echo $item->after; ?>
		</td>

		<!--ID-->
		<td class="center">
			<?php echo $item->id; ?>
		</td>

	</tr>
<?php endforeach; ?>
</tbody>
</table>
