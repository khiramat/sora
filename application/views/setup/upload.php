<?php $this -> load -> view('layout/import'); ?>
<?php $this -> load -> helper('utility'); ?>

<body class = "cloak">
<!-- header -->
<?php $this -> load -> view('layout/header'); ?>
<?php $this_year  = date("Y"); ?>
<?php $this_month = date("m"); ?>
<?php $this_day   = date("d"); ?>

<div class = "container">
	<article class="sheet">
		<h3>CSV File Upload</h3>
		<font color='blue'><?= $message ?></font>			<!--バリデーションエラーのない場合はサクセスメッセージを表示する-->
		<font color='red'><?= validation_errors() ?></font>	<!--バリデーションエラーの場合はメッセージを表示する-->

		<?= form_open_multipart('setup/do_upload') ?>
			<section>
				<?= form_label("対象データ", "TITLE") ?><br>
				<?= form_dropdown('table_name', $table_name) ?>
			</section>
			<section>
				<?= form_label("CSVファイル添付 ", "userfile") ?>
				<?php
					$data = array(
						'name'          => 'userfile',
						'id'            => 'userfile',
						'maxlength'     => '30',
						'size'          => '25'
					);
				?>
				<?= form_upload($data) ?>
			</section>
			<section>
				<?= form_submit("submit", "送信") ?>
			</section>
		<?= form_close() ?>
		<br>
		<section>
			<h4><b>CSVファイルフォマットについて</b></h4>
			※CSVファイルには値のみ記述してください。項目名は不要です。<br>
			※カラムの区切り記号は「,」を使用してください。<br><br>
			<?= form_label("・速度測定", "speed") ?><br>
			<table>
		        <tr>
			        <th style='border-right: #313131 solid 1px; text-align: left;'>日時</th>
	                <th style='border-right: #313131 solid 1px; text-align: left;'>DOWN値</th>
					<th style='border-right: #313131 solid 1px; text-align: left;'>UP値</th>
					<th style='border-right: #313131 solid 1px; text-align: left;'>[0]3G [1]LTE</th>
		        </tr>
		        <tr>
			        <td>2018-07-01 02:00:00</td><td>12.32</td><td>15.74</td><td>1</td>
		        </tr>
		        <tr>
			        <td>2018-07-01 02:00:00</td><td>1.5</td><td>0.4</td><td>0</td>
		        </tr>
			</table>
			<b>>> csv file sample</b><br>
			2018-07-01 02:00:00,12.32,15.74,1<br>
			2018-07-01 02:00:00,1.5,0.4,0
			<br>
			<br>
			<?= form_label("・アクティブユーザ", "active_user") ?><br>
			<table>
		        <tr>
			        <th style='border-right: #313131 solid 1px; text-align: left;'>日時</th>
	                <th style='border-right: #313131 solid 1px; text-align: left;'>LTE値</th>
					<th style='border-right: #313131 solid 1px; text-align: left;'>3G値</th>
		        </tr>
		        <tr>
			        <td>2019-02-28 02:00:00</td><td>12125</td><td>936</td>
		        </tr>
		        <tr>
			        <td>2019-02-28 06:00:00</td><td>12546</td><td>859</td>
		        </tr>
			</table>
			<b>>> csv file sample</b><br>
			2019-02-28 02:00:00,12125,936<br>
			2019-02-28 06:00:00,12546,859
		</section>
	</article>
</div>
<!-- footer -->
<?php $this -> load -> view('layout/footer'); ?>
</body>
</html>
