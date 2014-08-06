<?php
/**
 * Part of Component Csi files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\Registry\Registry;
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
<table id="webpageList" class="table table-striped adminlist table-bordered">

<!-- TABLE HEADER -->
<thead>
<tr>
	<!--CHECKBOX-->
	<th width="1%" class="center">
		<?php echo JHtml::_('grid.checkAll'); ?>
	</th>

	<th width="5%" class="center">
		Edit
	</th>

	<th class="center">
		<?php echo $grid->sortTitle('URL', 'webpage.url'); ?>
	</th>

	<th class="center">
		<?php echo $grid->sortTitle('Count', 'webpage.count'); ?>
	</th>

	<th class="center">
		Params
	</th>

	<!--ID-->
	<th width="1%" class="nowrap center">
		<?php echo $grid->sortTitle('JGRID_HEADING_ID', 'webpage.id'); ?>
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
	<tr class="webpage-row" sortable-group-id="<?php echo $item->catid; ?>">
		<!--CHECKBOX-->
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->webpage_id); ?>
		</td>

		<td class="center">
			<a class="btn btn-primary btn-small" href="<?php echo JRoute::_('index.php?option=com_csi&task=webpage.edit.edit&id=' . $item->id) ?>">
				<span class="glyphicon glyphicon-edit"></span>
			</a>
		</td>

		<td>
			<a href="<?php echo $item->url; ?>" target="_blank">
				<?php echo $item->url; ?>
			</a>
		</td>

		<td class="center">
			<?php echo $item->count; ?>
		</td>

		<td>
			<?php
			$params = new Registry($item->params);

			foreach ((array) $params['counts'] as $engine => $count): ?>
				<span class="label label-info">
					<?php echo $engine; ?>: <?php echo $count; ?>
				</span>&nbsp;
			<?php endforeach; ?>
		</td>

		<!--ID-->
		<td class="center">
			<?php echo (int) $item->id; ?>
		</td>

	</tr>
<?php endforeach; ?>
</tbody>
</table>
