<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

$result = $displayData['result'];

$icon = $result->value ? 'publish' : 'unpublish';
?>
<div class="input-prepend input-append">
	<a class="btn btn-micro" href="javascript:void(0);"
		onclick="jQuery('#result_field').val('<?php echo $result->key; ?>');
			jQuery('#result_value').val('<?php echo (int) $result->value - 1; ?>');
			return listItemTask('cb<?php echo $displayData['i']; ?>', 'pages.update.result')"
		title="">
		<i class="icon-chevron-down"></i>
	</a>
	<input type="text" class="span3" value="<?php echo $result->value; ?>" disabled />
	<a class="btn btn-micro" href="javascript:void(0);"
		onclick="jQuery('#result_field').val('<?php echo $result->key; ?>');
			jQuery('#result_value').val('<?php echo (int) $result->value + 1; ?>');
			return listItemTask('cb<?php echo $displayData['i']; ?>', 'pages.update.result')"
		title="">
		<i class="icon-chevron-up"></i>
	</a>
</div>
