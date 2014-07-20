<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\Data\Data;
use Windwalker\Html\HtmlElement;

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
<table id="pageList" class="table table-striped table-bordered adminlist">

<!-- TABLE HEADER -->
<thead>
<tr>
	<!--CHECKBOX-->
	<th width="1%" class="center">
		<?php echo JHtml::_('grid.checkAll'); ?>
	</th>

	<!--ID-->
	<th width="1%" class="nowrap center">
		<?php echo $grid->sortTitle('JGRID_HEADING_ID', 'page.id'); ?>
	</th>

	<!--STATE-->
	<th width="5%" class="nowrap center">
		<?php echo $grid->sortTitle('JSTATUS', 'page.state'); ?>
	</th>

	<!--TITLE-->
	<th class="center">
		<?php echo $grid->sortTitle('JGLOBAL_TITLE', 'page.title'); ?>
	</th>

	<th class="canter">
		Task
	</th>

	<th class="center">
		File
	</th>

	<th width="7%" class="center">
		File Type
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
	<tr class="page-row" sortable-group-id="<?php echo $item->catid; ?>">
		<!--CHECKBOX-->
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->page_id); ?>
		</td>

		<!--ID-->
		<td class="center">
			<?php echo (int) $item->id; ?>
		</td>

		<!--STATE-->
		<td class="center">
			<div class="btn-group">
				<!-- STATE BUTTON -->
				<?php echo $grid->booleanIcon($item->state); ?>
			</div>
		</td>

		<!--TITLE-->
		<td class="n/owrap has-context quick-edit-wrap">
			<div class="item-title">
				<!-- Checkout -->
				<?php echo $grid->checkoutButton(); ?>

				<!-- Title -->
				<?php echo new HtmlElement('a', $item->title, array('href' => $item->url, 'target' => '_blank')); ?>
			</div>

			<!-- Sub Title -->
			<div class="small" style="overflow: hidden; text-overflow: ellipsis; max-width: 500px;">
				<?php echo $item->url; ?>
			</div>
		</td>

		<td>
			<?php echo $item->task_title; ?>
		</td>

		<td>
			<?php echo \Csi\Helper\UiHelper::getShortedLink(JUri::root() . $item->filepath, $item->filepath); ?>
		</td>

		<td class="center">
			<?php echo $item->filetype; ?>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
