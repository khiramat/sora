<html lang = "jp">
<head>
	<?php $this -> load -> view('layout/import'); ?>
	<?php $this -> load -> helper('utility'); ?>
	<title><?=SITE_NAME?></title>
</head>
<body class = "cloak">

<!-- header -->
<?php
	$this -> load -> view('layout/header');

	$datetimes = array(
		'name'      => 'datetimes',
		'id'        => 'datetimes',
		'value' 	=> '',
		'maxlength' => '1000',
		// 'size'      => '20',
		'cols' 		=> '80',
		'rows' 		=> '5'
	);

	$body = array(
		'name'      => 'body',
		'id'        => 'body',
		'value' 	=> '',
		'maxlength' => '1000',
		// 'size'      => '20',
		'cols' 		=> '80',
		'rows' 		=> '5'
	);

	$cause = array(
		'name'      => 'cause',
		'id'        => 'cause',
		'value' 	=> '',
		'maxlength' => '1000',
		// 'size'      => '20',
		'cols' 		=> '80',
		'rows' 		=> '5'
	);

	$page = array(
		1 => 1,
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11,
		12 => 12,
		13 => 13,
		14 => 14,
		15 => 15
	);
?>

<div class = "container">

	<h3>アラート報告情報登録</h3>
	※レポートには登録順に表示されます。登録済みデータの編集機能はありません。<br><br>
	<div>
		<a href="/report_sora/setup/alert_list">>>アラート報告一覧へ</a>
	</div>

	<font color='blue'><?= $message ?></font>			<!--バリデーションエラーのない場合はサクセスメッセージを表示する-->
	<font color='red'><?= validation_errors() ?></font>	<!--バリデーションエラーの場合はメッセージを表示する-->

	<?= form_open('setup/alert_valid') ?>
		<article>
			<section>
				<?= form_dropdown('page', $page) ?>ページ
			</section>

			<section>
				<!-- <h4> <?= form_label("アラート種別", "TYPE") ?></h4> -->
				<?= form_dropdown('type', $type) ?>
			</section>

			<section>
				<h4> <?= form_label("サービス影響", "SERVICE_FLG") ?></h4>
				<input type="radio" name="service_flg" id="service_flg" value="1" checked="">あり
				&nbsp;&nbsp;
				<input type="radio" name="service_flg" id="service_flg" value="0" checked="checked">なし
			</section>

			<section>
				<h4> <?= form_label("発生源", "HOSTNAME") ?></h4>※Windowsの場合は、ShiftまたはCtrlキーを押しながらクリックすると、複数を選択することができます。<br>
				<?php $js = 'id="hostname" size=10';?>
				<?= form_multiselect('hostname[]', $hostname, $selecteds, $js) ?>
			</section>

			<section>
				<h4><?= form_label("発生日時", "datetimes") ?></h4>
				<?= form_textarea($datetimes) ?>
			</section>

			<section>
				<h4><?= form_label("アラート内容", "body") ?></h4>
				<?= form_textarea($body) ?>
			</section>

			<section>
				<h4><?= form_label("発生原因", "cause") ?></h4>
				<?= form_textarea($cause) ?>
			</section>

			<section>
				<?= form_submit("Submit", "登録") ?>
			</section>

		</article>
	<?= form_close() ?>

</div>

<!-- footer -->
<?php $this -> load -> view('layout/footer'); ?>

</body>
</html>
