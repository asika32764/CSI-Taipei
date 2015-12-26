<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

$displayData = new \Joomla\Registry\Registry($displayData);

$databases = $displayData['databases'];
$actives = $displayData['actives'] ? : array();
?>

<div id="databases-box" class="databases-box checkboxes">
	<?php foreach ($databases as $database): ?>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="jform[database][]" value="<?php echo $database; ?>"
					<?php echo in_array($database, $actives) ? 'checked' : ''; ?>>
				<?php echo JText::_('COM_CSI_DATABASE_' . strtoupper($database)); ?>
			</label>
		</div>
		&nbsp;&nbsp;
	<?php endforeach; ?>
</div>
