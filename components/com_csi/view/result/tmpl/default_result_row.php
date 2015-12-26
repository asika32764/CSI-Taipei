<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

$rowSpan = count($data->databaseResult);

$i = 0;

$user = JFactory::getUser();

foreach ($data->databaseResult as $title => $result)
:
	$task = $data->tasks[$i];

	$nolinks = array(
		'scholar',
		'tci',
		'wos',
		'thesis',
		'scopus',
		'mendeley'
	);

	$nolink = ($user->guest || in_array($data->database, $nolinks));
?>
<tr>
	<?php if ($i == 0): ?>
	<th rowspan="<?php echo count($data->databaseResult); ?>">
		<?php if ($nolink): ?>
			<?php echo JText::_('COM_CSI_DATABASE_' . strtoupper($data->database)); ?>
		<?php else: ?>
		<a target="_blank" href="<?php echo \Csi\Router\Route::_('com_csi.task_pages', array('id' => $task->id)); ?>"
			title="<?php echo JText::_('COM_CSI_DATABASE_' . strtoupper($data->database) . '_RESULT_DESC') ?>">
			<?php echo JText::_('COM_CSI_DATABASE_' . strtoupper($data->database)); ?>
		</a>
			<i class="icon-question-sign hasTooltip" title="<?php echo JText::_('COM_CSI_DATABASE_CAN_EDIT') ?>"></i>
		<?php endif; ?>
	</th>
	<?php endif; ?>

	<td>
		<?php echo JText::_('COM_CSI_RESULT_' . strtoupper($title));?>
	</td>

	<td>
		<?php echo $result; ?>
	</td>
</tr>
<?php
	$i++;
endforeach;
?>
