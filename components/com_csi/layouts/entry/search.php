<?php
/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

use Windwalker\Helper\ArrayHelper;

extract($displayData);

?>
<!--Chinese Name-->
<div class="form-group row">
	<div class="col-lg-2">
		<label for="chineseName" class="control-label">
			* Chinese Name
		</label>
	</div>
	<div class="col-lg-10">
		<div class="row">
			<div class="col-lg-12">
				<input type="text" name="jform[chinese_name]" class="form-control"
					id="chineseName" placeholder="姓名 (必填)" value="<?php echo $query['chinese_name']; ?>">
			</div>
		</div>
	</div>
</div>

<!--English Name-->
<?php
$engNames = $query['eng_name'];
?>
<div id="eng-name-form" class="form-group row">
	<div class="col-lg-2">
		<label for="engNameFirst" class="control-label">
			* English Name
		</label>
	</div>
	<div class="col-lg-10">
		<div class="row">
			<span class="col-lg-6 margin-b-20">
				<input type="text" class="form-control" id="engNameFirst-0"
					name="jform[eng_name][0][first]" placeholder="First Name (必填)" value="<?php echo ArrayHelper::getByPath($engNames, '0.first'); ?>">
			</span>
			<span class="col-lg-6">
				<input type="text" class="form-control" id="engNameFirst-0"
					name="jform[eng_name][0][last]" placeholder="Last Name (必填)" value="<?php echo ArrayHelper::getByPath($engNames, '0.last'); ?>">
			</span>
		</div>
	</div>

	<div class="col-lg-10 col-lg-offset-2 margin-b-20">
		<div class="row">
			<span class="col-lg-6">
				<input type="text" class="form-control" id="engNameFirst-1"
					name="jform[eng_name][1][first]" placeholder="First Name" value="<?php echo ArrayHelper::getByPath($engNames, '1.first'); ?>">
			</span>
			<span class="col-lg-6">
				<input type="text" class="form-control" id="engNameFirst-1"
					name="jform[eng_name][1][last]" placeholder="Last Name" value="<?php echo ArrayHelper::getByPath($engNames, '1.last'); ?>">
			</span>
		</div>
	</div>

	<div class="col-lg-10 col-lg-offset-2 margin-b-20">
		<div class="row">
			<span class="col-lg-6">
				<input type="text" class="form-control" id="engNameFirst-2"
					name="jform[eng_name][2][first]" placeholder="First Name" value="<?php echo ArrayHelper::getByPath($engNames, '2.first'); ?>">
			</span>
			<span class="col-lg-6">
				<input type="text" class="form-control" id="engNameFirst-2"
					name="jform[eng_name][2][last]" placeholder="Last Name" value="<?php echo ArrayHelper::getByPath($engNames, '2.last'); ?>">
			</span>
		</div>
	</div>
</div>

<!-- School -->
<div id="eng-name-form" class="form-group row">
	<div class="col-lg-2">
		<label for="engNameFirst" class="control-label">
			School
		</label>
	</div>
	<div class="col-lg-10">
		<div class="row">
			<span class="col-lg-6 margin-b-20">
				<input type="text" class="form-control" id="school" name="jform[school]" placeholder="School (必填)" value="<?php echo $query['school']; ?>">
			</span>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-lg-offset-2 col-lg-10 ">
		<button type="submit" class="btn btn-primary pull-right">Submit</button>
	</div>
</div>

<hr>

<div class="form-inline">
	<?php echo \Csi\Helper\DatabaseHelper::generateCheckboxes($query['database']); ?>
</div>

<!-- Webometrics URL -->
<?php
$urls = $query['webo_url'];

foreach (range(1, 3) as $i => $v): ?>
	<div class="form-group">
		<input type="text" class="col-lg-12 form-control" placeholder="Enter URL" value="<?php echo isset($urls[$i]) ? $urls[$i] : ''; ?>">
	</div>
<?php endforeach; ?>
