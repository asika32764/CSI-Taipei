<?php

?>
<div class="container result-index">

<div class="row">

<div class="col-lg-8">

<div id="search-box" class="row">
	<div class="col-lg-12">
		<fieldset>
			<legend>重新搜尋</legend>


			<div class="row">
				<!--Chinese Name-->
				<div class="form-group ">
					<label for="chineseName" class="col-lg-3 control-label">
						Chinese Name
					</label>
					<div class="col-lg-9">
						<input type="text" class="form-control" id="chineseName" placeholder="姓名" value="黃俊傑">
					</div>
				</div>

				<!--English Name-->
				<div id="eng-name-form" class="form-group">
					<label for="engNameFirst" class="col-lg-3 control-label">
						English Name
					</label>
					<div class="col-lg-9">
						<div class="row">
            <span class="col-lg-6">
                <input type="text" class="form-control" id="engNameFirst" placeholder="First Name" value="Chun Chieh">
            </span>
            <span class="col-lg-6">
                <input type="text" class="form-control" id="engNameLast" placeholder="Last Name" value="Huang">
            </span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10 ">
						<button type="submit" class="btn btn-primary pull-right">Submit</button>
					</div>
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