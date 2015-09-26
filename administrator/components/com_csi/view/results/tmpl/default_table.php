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
<table id="resultList" class="table table-striped table-bordered adminlist">

<!-- TABLE HEADER -->
<thead>
<tr>
	<!--CHECKBOX-->
	<th width="1%" class="center">
		<?php echo JHtml::_('grid.checkAll'); ?>
	</th>

	<!--ID-->
	<th width="5%" class="nowrap center">
		<?php echo $grid->sortTitle('JGRID_HEADING_ID', 'result.id'); ?>
	</th>

	<th width="25%">
		<?php echo $grid->sortTitle('Task', 'result.task_id'); ?>
	</th>

	<!--FK-->
	<th width="5%" class="nowrap center">
		<?php echo $grid->sortTitle('FK', 'result.fk'); ?>
	</th>

	<!--TYPE-->
	<th width="" class="nowrap center">
		<?php echo $grid->sortTitle('Type', 'result.type'); ?>
	</th>

	<!--KEY-->
	<th width="" class="nowrap center">
		<?php echo $grid->sortTitle('Key', 'result.key'); ?>
	</th>

	<!--VALUE-->
	<th width="" class="nowrap center">
		<?php echo $grid->sortTitle('Value', 'result.value'); ?>
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
	<tr class="result-row" sortable-group-id="<?php echo $item->catid; ?>">

		<!--CHECKBOX-->
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->result_id); ?>
		</td>

		<!--ID-->
		<td class="center">
			<?php echo (int) $item->id; ?>
		</td>

		<td>
			<?php echo $item->task_title; ?>
		</td>

		<!--FK-->
		<td class="center">
			<?php echo (int) $item->fk; ?>
		</td>

		<!--TYPE-->
		<td class="center">
			<span class="label label-info">
				<?php echo $item->type; ?>
			</span>
		</td>

		<!--KEY-->
		<td class="">
			<?php echo $item->key; ?>
		</td>

		<!--VALUE-->
		<td class="">
			<?php echo (int) $item->value; ?>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
