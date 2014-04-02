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
		<form action="<?php echo \Windwalker\Router\Route::_('com_csi', array('task' => 'entry.edit.save')); ?>" class="form-horizontal"
			method="post">
			<fieldset>
				<legend>請輸入檢索字串</legend>

				<!--Chinese Name-->
				<div class="form-group ">
					<label for="chineseName" class="col-lg-4 control-label">
						Chinese Name
					</label>
					<div class="col-lg-8">
						<input type="text" name="jform[chinese_name]" class="form-control" id="chineseName" placeholder="姓名">
					</div>
				</div>

				<!--English Name-->
				<div id="eng-name-form" class="form-group">
					<div class="eng-input-set">
						<label for="engNameFirst-0" class="col-lg-4 control-label">
							English Name
						</label>
						<div class="col-lg-8">
							<div class="row">
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst-0" name="jform[eng_name][0][first]" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameLast-0" name="jform[eng_name][0][last]" placeholder="Last Name">
                                </span>
							</div>
						</div>
					</div>

					<div class="eng-input-set">
						<label for="engNameFirst-1" class="col-lg-4 control-label">
							English Name
						</label>
						<div class="col-lg-8">
							<div class="row">
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst-1" name="jform[eng_name][1][first]" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameLast-1" name="jform[eng_name][1][last]" placeholder="Last Name">
                                </span>
							</div>
						</div>
					</div>

					<div class="eng-input-set">
						<label for="engNameFirst-2" class="col-lg-4 control-label">
							English Name
						</label>
						<div class="col-lg-8">
							<div class="row">
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst-2" name="jform[eng_name][2][first]" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameLast-2" name="jform[eng_name][2][last]" placeholder="Last Name">
                                </span>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10 ">
						<button type="submit" class="btn btn-primary pull-right">Submit</button>
					</div>
				</div>

			</fieldset>

			<fieldset>
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

			<fieldset>
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
