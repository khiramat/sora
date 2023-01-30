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

	$this_year  = date("Y");
	$this_month = date("m");

	$from_date_y  = array(
		'name'      => 'from_year',
		'id'        => 'from_year',
		'value'     => $this_year,
		'maxlength' => '4',
		'size'      => '6'
	);

	$date_m = array(
		$this_month => $this_month,
		'01'        => '1',
		'02'        => '2',
		'03'        => '3',
		'04'        => '4',
		'05'        => '5',
		'06'        => '6',
		'07'        => '7',
		'08'        => '8',
		'09'        => '9',
		'10'        => '10',
		'11'        => '11',
		'12'        => '12',
	);

	$cnt = array(
		'name'      => 'cnt',
		'id'        => 'cnt',
		//"value" 	=> set_value("title"),
		'value' 	=> '',
		'maxlength' => '100',
		'size'      => '10',
		'cols' 		=> '100',
		'rows' 		=> '4'
	);
?>

<div class = "container">

	<h3>アラート受信数登録</h3>
	※登録済みのデータ修正機能はありません。間違えてデータ登録した場合はシステム管理担当者へご連絡ください。
	<font color='blue'><?= $message ?></font>			<!--バリデーションエラーのない場合はサクセスメッセージを表示する-->
	<font color='red'><?= validation_errors() ?></font>	<!--バリデーションエラーの場合はメッセージを表示する-->

	<?= form_open('setup/cnt_valid') ?>
		<article>
			<section>
				<?= form_input($from_date_y) ?>
				<?= form_label("年 ", "from_year") ?>
				<?= form_dropdown('from_month', $date_m) ?>
				<?= form_label("月 ", "from_month") ?>
				1<?= form_label("日", "from_day") ?>
				&nbsp;&nbsp;&nbsp;
				<?= form_input($cnt, '') ?>件
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
