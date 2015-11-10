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

// Add CSS
$asset->addCss('main.css');
?>

<!-- LIST TABLE -->
<table id="queueList" class="table table-striped adminlist">

<!-- TABLE HEADER -->
<thead>
<tr>

	<!--CHECKBOX-->
	<th width="1%" class="center">
		<?php echo JHtml::_('grid.checkAll'); ?>
	</th>

	<!--ID-->
	<th width="1%" class="nowrap center">
		<?php echo $grid->sortTitle('JGRID_HEADING_ID', 'queue.id'); ?>
	</th>

	<!--STATE-->
	<th width="5%" class="nowrap center">
		<?php echo $grid->sortTitle('JSTATUS', 'queue.state'); ?>
	</th>

	<!--EXECUTE-->
	<th width="5%">
		Execute
	</th>

	<!--TITLE-->
	<th class="center">
		<?php echo $grid->sortTitle('Task', 'queue.task'); ?>
	</th>

	<!--QUERY-->
	<th width="" class="center">
		<?php echo $grid->sortTitle('Query', 'queue.query'); ?>
	</th>

	<!--PRIORITY-->
	<th width="" class="center">
		<?php echo $grid->sortTitle('Priority', 'queue.priority'); ?>
	</th>

	<!--CREATED-->
	<th width="20%" class="center">
		<?php echo $grid->sortTitle('JDATE', 'queue.created'); ?>
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
	<tr class="queue-row" sortable-group-id="<?php echo $item->catid; ?>">

		<!--CHECKBOX-->
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->queue_id); ?>
		</td>

		<!--ID-->
		<td class="center">
			<?php echo (int) $item->id; ?>
		</td>

		<!--STATE-->
		<td class="center">
			<div class="btn-group">
			<?php if ($item->state == 0): ?>
				<span class="label label-default">Close</span>
			<?php elseif ($item->state == 1): ?>
				<span class="label label-info">Pending</span>
			<?php elseif ($item->state == 2): ?>
				<span class="label label-warning">Processing</span>
			<?php elseif ($item->state == 3): ?>
				<span class="label label-success">Finished</span>
			<?php endif; ?>
			</div>
		</td>

		<!--EXECUTE-->
		<td class="center">
			<a class="btn btn-primary btn-mini" href="<?php echo JUri::root() . sprintf('?task=%s&id=%s', $item->task, $item->id); ?>" target="_blank">
				<i class="glyphicon glyphicon-play"></i>
			</a>
		</td>

		<!--TITLE-->
		<td class="n/owrap has-context quick-edit-wrap">
			<div class="item-title">
				<!-- Title -->
				<?php echo $item->task; ?>
			</div>
		</td>

		<!--Query-->
		<td class="center">
			<?php echo \Windwalker\Helper\ModalHelper::modalLink('See Query', 'query-' . $item->id); ?>
			<?php echo \Windwalker\Helper\ModalHelper::renderModal('query-' . $item->id, '<pre>' . print_r(json_decode($item->query, true), true) . '</pre>'); ?>
		</td>

		<!--Priority-->
		<td class="center">
			<?php echo $item->priority; ?>
		</td>

		<!--CREATED-->
		<td class="center">
			<?php echo JHtml::_('date', $item->created, 'Y-m-d H:i:s'); ?>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
