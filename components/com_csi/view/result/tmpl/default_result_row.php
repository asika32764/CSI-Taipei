<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

show($data->databaseResult);

$rowSpan = count($data->databaseResult);

?>

<?php
$i = 0;

foreach ($data->databaseResult as $title => $result)
:
?>
<tr>
	<?php if ($i == 0): ?>
	<th rowspan="<?php echo count($data->databaseResult); ?>">
		<?php echo JText::_('COM_CSI_DATABASE_' . strtoupper($data->database)); ?>
	</th>
	<?php endif; ?>

	<td>
		<a href="#">
			<?php echo JText::_('COM_CSI_RESULT_' . strtoupper($title));?>
		</a>
	</td>

	<td>
		<?php echo $result; ?>
	</td>
</tr>
<?php
	$i++;
endforeach;
?>
