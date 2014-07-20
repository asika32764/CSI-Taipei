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
<table id="enginepageList" class="table table-striped adminlist">

<!-- TABLE HEADER -->
<thead>
<tr>
	<!--SORT-->
	<th width="1%" class="nowrap center hidden-phone">
		<?php echo $grid->orderTitle(); ?>
	</th>

	<!--CHECKBOX-->
	<th width="1%" class="center">
		<?php echo JHtml::_('grid.checkAll'); ?>
	</th>

	<!--STATE-->
	<th width="5%" class="nowrap center">
		<?php echo $grid->sortTitle('JSTATUS', 'enginepage.state'); ?>
	</th>

	<th class="center" width="5%">
		<?php echo $grid->sortTitle('Entry ID', 'entry.id') ?>
	</th>

	<th class="center" width="5%">
		<?php echo $grid->sortTitle('Task ID', 'task.id') ?>
	</th>

	<th class="center" width="">
		<?php echo $grid->sortTitle('Entry', 'entry.title') ?>
	</th>

	<th class="center" width="">
		<?php echo $grid->sortTitle('Task', 'task.database') ?>
	</th>

	<th class="center" width="">
		<?php echo $grid->sortTitle('URL', 'enginepage.url') ?>
	</th>

	<th class="center" width="">
		<?php echo $grid->sortTitle('File', 'enginepage.file') ?>
	</th>

	<th class="center" width="">
		<?php echo $grid->sortTitle('Total', 'enginepage.total') ?>
	</th>

	<th class="center" width="">
		<?php echo $grid->sortTitle('Ordering', 'enginepage.ordering') ?>
	</th>

	<!--ID-->
	<th width="1%" class="nowrap center">
		<?php echo $grid->sortTitle('JGRID_HEADING_ID', 'enginepage.id'); ?>
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
	<tr class="enginepage-row" sortable-group-id="<?php echo $item->catid; ?>">
		<!-- DRAG SORT -->
		<td class="order nowrap center hidden-phone">
			<?php echo $grid->dragSort(); ?>
		</td>

		<!--CHECKBOX-->
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->enginepage_id); ?>
		</td>

		<!--STATE-->
		<td class="center">
			<div class="btn-group">
				<!-- STATE BUTTON -->
				<?php echo $grid->booleanIcon($item->state); ?>
			</div>
		</td>

		<td class="center">
			<?php echo $item->entry_id; ?>
		</td>

		<td class="center">
			<?php echo $item->task_id; ?>
		</td>

		<td class="">
			<?php echo $item->entry_title; ?>
		</td>

		<td class="">
			<?php echo $item->task_database; ?>
		</td>

		<td class="">
			<?php echo \Csi\Helper\UiHelper::getShortedLink($item->url); ?>
		</td>

		<td class="">
			<?php echo \Csi\Helper\UiHelper::getShortedLink(JUri::root() . '/' . $item->file, $item->file); ?>
		</td>

		<td class="center">
			<?php echo $item->total; ?>
		</td>

		<td class="center">
			<?php echo $item->ordering; ?>
		</td>

		<!--ID-->
		<td class="center">
			<?php echo (int) $item->id; ?>
		</td>

	</tr>
<?php endforeach; ?>
</tbody>
</table>
