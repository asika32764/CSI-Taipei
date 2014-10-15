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
	$task = $data->tasks->{$data->database};

	$nolink = ($user->guest || $data->database == 'scholar');
?>
<tr>
	<?php if ($i == 0): ?>
	<th rowspan="<?php echo count($data->databaseResult); ?>">
		<?php if ($nolink): ?>
			<?php echo JText::_('COM_CSI_DATABASE_' . strtoupper($data->database)); ?>
		<?php else: ?>
		<a target="_blank" href="<?php echo \Csi\Router\Route::_('com_csi.task_pages', array('id' => $task->id)); ?>">
			<?php echo JText::_('COM_CSI_DATABASE_' . strtoupper($data->database)); ?>
		</a>
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
