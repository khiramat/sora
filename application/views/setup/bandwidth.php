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
	$this_day   = date("d");

	$data_year = array(
		'name'      => 'year',
		'id'        => 'year',
		'value'     => $this_year,
		'maxlength' => '4',
		'size'      => '6'
	);

	$data_month = array(
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

	$data_day = array(
		$this_day => $this_day,
		'01'      => '1',
		'02'      => '2',
		'03'      => '3',
		'04'      => '4',
		'05'      => '5',
		'06'      => '6',
		'07'      => '7',
		'08'      => '8',
		'09'      => '9',
		'10'      => '10',
		'11'      => '11',
		'12'      => '12',
		'13'      => '13',
		'14'      => '14',
		'15'      => '15',
		'16'      => '16',
		'17'      => '17',
		'18'      => '18',
		'19'      => '19',
		'20'      => '20',
		'21'      => '21',
		'22'      => '22',
		'23'      => '23',
		'24'      => '24',
		'25'      => '25',
		'26'      => '26',
		'27'      => '27',
		'28'      => '28',
		'29'      => '29',
		'30'      => '30',
		'31'      => '31'
	);

	$xi_down = array(
		'name'      => 'xi',
		'id'        => 'xi',
		"value"     => $datas[0]->Xi,
		'maxlength' => '12',
		'size'      => '12'
	);

	$foma_down = array(
		'name'      => 'foma',
		'id'        => 'foma',
		"value"     => $datas[0]->FOMA,
		'maxlength' => '12',
		'size'      => '12'
	);
?>

<div class = "container">
	<h3>帯域設定フォーム</h3>

	<div>
		<a href="/report_sora/setup/bandwidth_list">>>帯域設定履歴画面へ</a>
	</div>

	<font color='blue'><?= $message ?></font>			<!--バリデーションエラーのない場合はサクセスメッセージを表示する-->
	<font color='red'><?= validation_errors() ?></font>	<!--バリデーションエラーの場合はメッセージを表示する-->

	<?= form_open('setup/bandwidth_valid') ?>
		<article>
			<section>
				<?= form_label("日付 ", "datetime") ?>
				<?= form_input($data_year) ?>
				<?= form_label("年 ", "year") ?>
				<?= form_dropdown('month', $data_month) ?>
				<?= form_label("月 ", "month") ?>
				<?= form_dropdown('day', $data_day) ?>
				<?= form_label("日", "day") ?>
			</section>
			<section>
				<?= form_label("LTE ", "xi") ?>
				<?= form_input($xi_down) ?> bps
			</section>
			<section>
				<?= form_label("3G ", "foma") ?>&nbsp
				<?= form_input($foma_down) ?> bps
			</section>
		</article>
		<?= form_submit("Submit", "登録") ?>
	<?= form_close() ?>

</div>

<!-- footer -->
<?php $this -> load -> view('layout/footer'); ?>
</body>
</html>
