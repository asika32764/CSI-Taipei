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
		<form action="<?php echo \Windwalker\Router\Route::_('com_csi.entry', array('task' => '123')); ?>" class="form-horizontal">
			<?php echo \Windwalker\Router\Route::_('com_csi.entry', array('task' => '123')); ?>
			<br />
			<?php echo \Windwalker\Router\Route::_('com_csi.result', array('task' => '123')); ?>
			<br />
			<?php echo \Windwalker\Router\Route::_('com_csi.task', array('task' => '123')); ?>
			<fieldset>
				<legend>請輸入檢索字串</legend>

				<!--Chinese Name-->
				<div class="form-group ">
					<label for="chineseName" class="col-lg-4 control-label">
						Chinese Name
					</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="chineseName" placeholder="姓名">
					</div>
				</div>

				<!--English Name-->
				<div id="eng-name-form" class="form-group">
					<div class="eng-input-set">
						<label for="engNameFirst" class="col-lg-4 control-label">
							English Name
						</label>
						<div class="col-lg-8">
							<div class="row">
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst" name="eng_name_first[]" placeholder="First Name">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameLast" name="eng_name_last[]" placeholder="Last Name">
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
						<input type="checkbox" value="on" name="syllabus"> 課程大綱
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" value="on" name="ndltd"> 博碩士論文資訊網
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" value="on" name="paper"> 報紙資料庫
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" value="on" name="magazine"> 雜誌資料庫
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" value="on" name="wiki"> 維基百科
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" value="on" name="webo"> Webometrics
					</label>
				</div>

			</fieldset>

			<fieldset>
				<legend>個人網站網址</legend>

				<div class="form-group">
					<input type="text" name="webo_url[]" class="col-lg-12 form-control" placeholder="Enter URL">
				</div>
				<div class="form-group">
					<input type="text" name="webo_url[]" class="col-lg-12 form-control" placeholder="Enter URL">
				</div>
				<div class="form-group">
					<input type="text" name="webo_url[]" class="col-lg-12 form-control" placeholder="Enter URL">
				</div>
			</fieldset>

		</form>
	</div>
</div>
