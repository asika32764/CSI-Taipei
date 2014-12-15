<?php

use Windwalker\Helper\ArrayHelper;

/** @var $query \Joomla\Registry\Registry */
$query = $data->query;

$data->asset->jquery();
$data->asset->addJS('webometrics.js');
?>
<script>
	jQuery(document).ready(function()
	{
		Webometrics.fetchWebometrics();
	});
</script>
<div class="container result-index">

<div class="row">

<div class="col-lg-8">

<div id="search-box" class="row">
	<div class="col-lg-12">

		<h2>您現在搜索的是: </h2>
		<h3><?php echo $data->entry->title; ?></h3>

		<div class="accordion" id="accordion2">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
						重新搜尋 <i class="icon-chevron-down"></i>
					</a>
				</div>
				<div id="collapseOne" class="accordion-body collapse">
					<div class="accordion-inner">
						<fieldset style="padding: 20px;">

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
							<input type="text" class="form-control" id="school" name="jform[school]" placeholder="School" value="<?php echo $query['school']; ?>">
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

							<!-- Webometrics URL -->
							<?php
							$urls = $query['webo_url'];

							foreach (range(1, 3) as $i => $v): ?>
								<div class="form-group">
									<input type="text" class="col-lg-12 form-control" placeholder="Enter URL" value="<?php echo isset($urls[$i]) ? $urls[$i] : ''; ?>">
								</div>
							<?php endforeach; ?>


						</fieldset>
					</div>
				</div>
			</div>
		</div>
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

				<!--Databases-->
				<?php
				foreach ($data->results as $name => $result)
				{
					echo $this->loadTemplate('result_row', array('database' => $name, 'databaseResult' => $result));
				}
				?>

				<!-- Webometrics -->
				<?php foreach ($urls as $i => $url): ?>
					<tr>
					<?php if ($i == 0): ?>
						<td rowspan="<?php echo count($urls); ?>">
							Webometrics
						</td>
					<?php endif; ?>

						<td>
							<?php echo $url; ?>
						</td>
						<td>
							<div class="webo-result" data-url="<?php echo $url; ?>">
								<img src="<?php echo JUri::root() . '/images/csi/ajax-loader.gif'; ?>" alt="Ajax loading" />
							</div>
						</td>
					</tr>
				<?php endforeach; ?>

				</tbody>
			</table>
		</fieldset>
	</div>
</div>
</div>

<div class="col-lg-4">
	<fieldset>
		<legend>相關搜索</legend>
		<ul>
			<?php foreach ($data->relates as $relate): ?>
			<li>
				<a href="<?php echo $relate->link ?>">
					<?php echo $relate->title; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</fieldset>
</div>

</div>
</div>