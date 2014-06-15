<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

$data = $this->data;
?>
<div class="page-header row">
	<h1>頁面詳情 <small><?php echo $data->item->title; ?></small></h1>
</div>

<div id="filter-bar" class="row">
	<div class="col-lg-8">
		<a class="btn btn-default" href="<?php echo \Csi\Router\Route::_('task_pages', array('id' => $data->item->task_id)); ?>">
			<i class="glyphicon glyphicon-chevron-left"></i>
			回前頁
		</a>
	</div>

	<div class="col-lg-4">
	</div>

	<div class="clearfix"></div>
	<hr />
</div>

<div class="row">

	<div class="col-lg-12">
		<div id="search-info" class="row">
			<div class="col-lg-12">
				<fieldset>
					<legend>搜尋資訊</legend>
					<dl class="dl-horizontal">
						<dt>
							搜尋結果
						</dt>
						<dd>
							<?php echo $data->entry->title; ?>
						</dd>

<!--						<dt>-->
<!--							下載時間-->
<!--						</dt>-->
<!--						<dd>-->
<!--							2013-10-10-->
<!--						</dd>-->

						<dt>
							URL
						</dt>
						<dd>
							<a class="text-muted" href="<?php echo JUri::root(true) . '/' . $data->item->filepath; ?>" target="_blank">
								<?php echo JUri::root(true) . '/' . $data->item->filepath; ?>
							</a>
						</dd>
					</dl>
				</fieldset>
			</div>
		</div>

		<div id="search-content" class="row">
			<div class="col-lg-8">
				<fieldset>
					<legend>
						頁面預覽
					</legend>

					<iframe width="100%" height="640px" src="<?php echo JUri::root(true) . '/' . $data->item->filepath; ?>" frameborder="0">

					</iframe>
				</fieldset>
			</div>

			<div class="col-lg-4">
				<div id="modification-box" class="row">
					<div class="col-lg-12">
						<fieldset>
							<legend>修改紀錄</legend>

							<ul>
								<li>
									<a href="#">Simon</a> 將此頁面的 <strong>被引</strong> 設為 <strong>是</strong> - 2013-10-10
								</li>
								<li>
									<a href="#">Eddy</a> 將此頁面的 <strong>被引</strong> 設為 <strong>否</strong> - 2013-09-05
								</li>
								<li>
									<a href="#">Andy</a> 將此頁面的 <strong>自引</strong> 設為 <strong>是</strong> - 2013-08-17
								</li>
							</ul>
						</fieldset>
					</div>
				</div>

				<div id="comment-box" class="row">
					<div class="col-lg-12">
						<fieldset>
							<legend>留言</legend>

							<div id="comment-content">
								<div id="fb-root"></div>
								<script>(function(d, s, id) {
										var js, fjs = d.getElementsByTagName(s)[0];
										if (d.getElementById(id)) return;
										js = d.createElement(s); js.id = id;
										js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&appId=418927461513801&version=v2.0";
										fjs.parentNode.insertBefore(js, fjs);
									}(document, 'script', 'facebook-jssdk'));</script>
								<div class="fb-comments" data-href="<?php echo JUri::current(); ?>" data-numposts="5" data-width="390" data-colorscheme="light"></div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>


	</div>

</div>

