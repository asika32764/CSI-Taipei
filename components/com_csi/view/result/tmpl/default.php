<?php

use Windwalker\Helper\ArrayHelper;

/** @var $query \Joomla\Registry\Registry */
$query = $data->query;
?>
<div class="container result-index">

<div class="row">

<div class="col-lg-8">

<div id="search-box" class="row">
	<div class="col-lg-12">
		<fieldset>
			<legend>重新搜尋</legend>

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
							<input type="text" name="jform[chinese_name]" class="form-control"
								id="chineseName" placeholder="姓名" value="<?php echo $query['chinese_name']; ?>">
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
						English Name
					</label>
				</div>
				<div class="col-lg-10">
					<div class="row">
                                <span class="col-lg-6 margin-b-20">
                                    <input type="text" class="form-control" id="engNameFirst-0"
										name="jform[eng_name][0][first]" placeholder="First Name" value="<?php echo ArrayHelper::getByPath($engNames, '0.first'); ?>">
                                </span>
                                <span class="col-lg-6">
                                    <input type="text" class="form-control" id="engNameFirst-0"
										name="jform[eng_name][0][last]" placeholder="Last Name" value="<?php echo ArrayHelper::getByPath($engNames, '0.last'); ?>">
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

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10 ">
					<button type="submit" class="btn btn-primary pull-right">Submit</button>
				</div>
			</div>

			<hr>

			<div class="form-inline">
				<?php echo \Csi\Helper\DatabaseHelper::generateCheckboxes($data->query['database']); ?>
			</div>


			<div class="form-group">
				<input type="text" class="col-lg-12 form-control" placeholder="Enter URL" value="http://getbootstrap.com/">
			</div>


		</fieldset>
	</div>
</div>

<div id="result-table" class="row">
	<div class="col-lg-12">
		<fieldset>
			<legend>檢索結果</legend>

			<table class="table table-bordered">
				<thead>
				<tr>
					<th class="text-center">資料庫</th>
					<th class="text-center">分析項目</th>
					<th class="text-center">數量</th>
				</tr>
				</thead>

				<tbody>

				<?php
				foreach ($data->results as $name => $result)
				{
					echo $this->loadTemplate('result_row', array('database' => $name, 'databaseResult' => $result));
				}
				?>

				<tr>
					<th rowspan="3">課程大綱</th>
					<td>
						<a href="/csi-proto/result/list/index">被引用</a>
					</td>
					<td>
						2899
					</td>
				</tr>
				<tr>
					<td>
						<a href="/csi-proto/result/list/index">自我引用</a>
					</td>
					<td>
						84
					</td>
				</tr>
				<tr>
					<td>
						<a href="/csi-proto/result/list/index">課程大綱數量</a>
					</td>
					<td>
						106
					</td>
				</tr>

				<tr>
					<th rowspan="2">
						博碩士論文資料庫
					</th>
					<td>
						<a href="/csi-proto/result/list/index">指導論文次數</a>
					</td>
					<td>
						92
					</td>
				</tr>
				<tr>
					<td>
						<a href="/csi-proto/result/list/index">論文參考文獻次數</a>
					</td>
					<td>
						0
					</td>
				</tr>

				<tr>
					<th rowspan="2">
						報紙資料庫
					</th>
					<td>
						<a href="/csi-proto/result/list/index">著作篇數</a>
					</td>
					<td>
						20
					</td>
				</tr>
				<tr>
					<td>
						<a href="/csi-proto/result/list/index">被提及次數</a>
					</td>
					<td>
						5
					</td>
				</tr>

				<tr>
					<th rowspan="2">
						雜誌資料庫
					</th>
					<td>
						<a href="/csi-proto/result/list/index">著作篇數</a>
					</td>
					<td>
						57
					</td>
				</tr>
				<tr>
					<td>
						<a href="/csi-proto/result/list/index">被提及次數</a>
					</td>
					<td>
						49
					</td>
				</tr>

				<tr>
					<th>
						維基百科
					</th>
					<td>
						<a href="/csi-proto/result/list/index">被提及次與列為參考文獻</a>
					</td>
					<td>
						6
					</td>
				</tr>

				<tr>
					<th rowspan="2">
						Webometrics
					</th>
					<td>
						<a href="/csi-proto/result/list/index">Google</a>
					</td>
					<td>
						5252201
					</td>
				</tr>
				<tr>
					<td>
						<a href="/csi-proto/result/list/index">Yahoo</a>
					</td>
					<td>
						555673
					</td>
				</tr>

				</tbody>
			</table>
		</fieldset>
	</div>
</div>
</div>

<div class="col-lg-4">
	<fieldset>
		<legend>相關搜索</legend>

		<h3>您現在搜索的是:</h3>
		<p>黃俊傑; Chun Chieh, Huang</p>

		<h3>其他相關搜索</h3>
		<ul>
			<li>
				<a href="/csi-proto/result/index?q=黃俊傑; Chun Chieh; Huang">
					黃俊傑; Chun Chieh, Huang
				</a>
			</li>
			<li>
				<a href="/csi-proto/result/index?q=黃俊傑; Huang">
					黃俊傑; Huang
				</a>
			</li>
		</ul>
	</fieldset>
</div>

</div>
</div>