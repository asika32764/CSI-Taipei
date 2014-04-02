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

		<?php echo \Csi\Router\Route::_('com_csi', array('task' => 'entry.edit.save')); ?>
		<form action="<?php echo \Csi\Router\Route::_('com_csi', array('task' => 'entry.edit.save')); ?>" class="form-horizontal"
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
								<input type="text" class="form-control" id="chineseName" placeholder="姓名">
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
                                    <input type="text" class="form-control" id="engNameFirst" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameLast" placeholder="Last Name">
                                </span>
						</div>
					</div>

					<div class="col-lg-10 col-lg-offset-2 margin-b-20">
						<div class="row">
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameLast" placeholder="Last Name">
                                </span>
						</div>
					</div>

					<div class="col-lg-10 col-lg-offset-2 margin-b-20">
						<div class="row">
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameLast" placeholder="Last Name">
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

			<fieldset class="margin-t-50">
				<legend>請選擇檢索項目</legend>


				<div class="checkbox">
					<label>
						<input type="checkbox" name="jform[database][]" value="syllabus"> 課程大綱
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="jform[database][]" value="ndltd"> 博碩士論文資訊網
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="jform[database][]" value="paper"> 報紙資料庫
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="jform[database][]" value="magazine"> 雜誌資料庫
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="jform[database][]" value="wiki"> 維基百科
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="jform[database][]" value="webometrics"> Webometrics
					</label>
				</div>

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

			<div id="hidden-inputs">
				<?php echo JHtmlForm::token(); ?>
			</div>

		</form>
	</div>
</div>
