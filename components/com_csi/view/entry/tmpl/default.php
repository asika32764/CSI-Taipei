<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

?>
<div class="row-fluid">
	<div class="col-lg-6 col-lg-offset-2 span12">

		<form action="<?php echo \Csi\Router\Route::_('com_csi.entry', array('task' => 'entry.edit.save')); ?>" class="form-horizontal"
			method="post">
			<fieldset>
				<legend>請輸入檢索字串</legend>

				<!--Chinese Name-->
				<div class="form-group row">
					<div class="col-lg-2">
						<label for="chineseName" class="control-label">
							Chinese Name
						</label>
					</div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-12">
								<input type="text" name="jform[chinese_name]" class="form-control" id="chineseName" placeholder="姓名">
							</div>
						</div>
					</div>
				</div>

				<!--English Name-->
				<div id="eng-name-form" class="form-group row">
					<div class="col-lg-2">
						<label for="engNameFirst" class="control-label">
							English Name
						</label>
					</div>
					<div class="col-lg-10">
						<div class="row">
                                <span class="col-lg-6 margin-b-20">
                                    <input type="text" class="form-control" id="engNameFirst-0" name="jform[eng_name][0][first]" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst-0" name="jform[eng_name][0][last]" placeholder="Last Name">
                                </span>
						</div>
					</div>

					<div class="col-lg-10 col-lg-offset-2 margin-b-20">
						<div class="row">
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst-1" name="jform[eng_name][1][first]" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst-1" name="jform[eng_name][1][last]" placeholder="Last Name">
                                </span>
						</div>
					</div>

					<div class="col-lg-10 col-lg-offset-2 margin-b-20">
						<div class="row">
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst-2" name="jform[eng_name][2][first]" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst-2" name="jform[eng_name][2][last]" placeholder="Last Name">
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
                                    <input type="text" class="form-control" id="school" name="jform[school]" placeholder="School">
                                </span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10 ">
						<button type="submit" class="btn btn-primary pull-right">Submit</button>
					</div>
				</div>

			</fieldset>

			<fieldset class="margin-t-50 form-inline">
				<legend>請選擇檢索項目</legend>

				<?php echo \Csi\Helper\DatabaseHelper::generateCheckboxes($data->query['database']); ?>

			</fieldset>

			<fieldset class="margin-t-50">
				<legend>個人網站網址</legend>

				<div class="form-group">
					<input type="text" name="jform[webo_url][]" class="col-lg-12 form-control" placeholder="Enter URL">
				</div>
				<div class="form-group">
					<input type="text" name="jform[webo_url][]" class="col-lg-12 form-control" placeholder="Enter URL">
				</div>
				<div class="form-group">
					<input type="text" name="jform[webo_url][]" class="col-lg-12 form-control" placeholder="Enter URL">
				</div>
			</fieldset>

			<?php
			if (JDEBUG)
			{
				echo \Csi\Helper\EntryHelper::getEntryQuickLink();
			}
			?>

			<div id="hidden-inputs">
				<?php echo JHtmlForm::token(); ?>
			</div>

		</form>
	</div>
</div>
