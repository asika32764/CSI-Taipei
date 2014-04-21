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
?>

<!-- LIST TABLE -->
<table id="taskList" class="table table-striped adminlist">

<!-- TABLE HEADER -->
<thead>
<tr>
	<!--CHECKBOX-->
	<th width="1%" class="center">
		<?php echo JHtml::_('grid.checkAll'); ?>
	</th>

	<!--TITLE-->
	<th class="center">
		<?php echo $grid->sortTitle('JGLOBAL_TITLE', 'page.title'); ?>
	</th>

	<!--FILETYPE-->
	<th width="15%" class="center">
		<?php echo $grid->sortTitle('檔案類型', 'page.filetype'); ?>
	</th>

	<?php foreach ($data->resultFields as $field): ?>
	<th>
		<?php echo JText::_('COM_CSI_RESULT_FIELD_' . strtoupper($field)); ?>
	</th>
	<?php endforeach; ?>

	<!--DETAIL-->
	<th width="5%" class="center">
		詳情
	</th>

	<!--ID-->
	<th width="1%" class="nowrap center">
		<?php echo $grid->sortTitle('JGRID_HEADING_ID', 'page.id'); ?>
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
	<tr class="task-row">

		<!--CHECKBOX-->
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->task_id); ?>
		</td>

		<!--TITLE-->
		<td class="n/owrap has-context quick-edit-wrap">
			<div class="item-title">
				<!-- Title -->
				<a href="<?php echo \Csi\Router\Route::_('com_csi.task_page', array('id' => $item->id)); ?>">
					<?php echo $this->escape($item->title); ?>
				</a>
			</div>

			<!-- Sub Title -->
			<a class="text-muted" href="<?php $item->url; ?>">
				<div class="small">
					<?php echo $this->escape($item->url); ?>
				</div>
			</a>
		</td>

		<!--FILETYPE-->
		<td class="center">
			<span class="label label-default">
				<?php echo $this->escape($item->filetype); ?>
			</span>
		</td>

		<?php foreach ($data->resultFields as $field): ?>
			<td class="center">
				<?php
				if (!empty($item->results[$field]))
				{
					echo $item->results[$field];
				}
				else
				{
					echo '-';
				}
				?>
			</td>
		<?php endforeach; ?>

		<!--DETAIL-->
		<td class="center">
			<a class="btn btn-info" href="<?php echo '#'; ?>">
				詳情
			</a>
		</td>

		<!--ID-->
		<td class="center">
			<?php echo (int) $item->id; ?>
		</td>

	</tr>
<?php endforeach; ?>
</tbody>
</table>
