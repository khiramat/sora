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

	if($datas['day'] != ''){
		$days = explode("-", $datas['day']);
		$this_year 	= $days[0];
		$this_month = $days[1]+0;
		$this_day 	= $days[2]+0;
	}

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

	$date_d = array(
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

	$datetimes = array(
		'name'      => 'datetimes',
		'id'        => 'datetimes',
		"value" 	=> $datas['datetimes'],
		'maxlength' => '100',
		'size'      => '81',
		'cols' 		=> '100',
		'rows' 		=> '4'
	);

	$title = array(
		'name'      => 'title',
		'id'        => 'title',
		'value' 	=> $datas['title'],
		'maxlength' => '100',
		'size'      => '81',
		'cols' 		=> '100',
		'rows' 		=> '4'
	);

	$body = array(
		'name'      => 'body',
		'id'        => 'body',
		'value' 	=> $datas['body'],
		'maxlength' => '1000',
		// 'size'      => '20',
		'cols' 		=> '80',
		'rows' 		=> '5'
	);
	// print_r($datas);
?>

<div class = "container">

	<h3>作業報告登録フォーム</h3>
	<div>
		<a href="/report_sora/setup/work_list">>>作業報告一覧へ</a>
	</div>

	<font color='blue'><?= $message ?></font>			<!--バリデーションエラーのない場合はサクセスメッセージを表示する-->
	<font color='red'><?= validation_errors() ?></font>	<!--バリデーションエラーの場合はメッセージを表示する-->

	<?= form_open('setup/work_valid') ?>
		<input type="hidden" name="id" id="id" value="<?= $datas['id'] ?>">
		<article>
			<section>
				<h4><b>作業実施日選択</b></h4>
				<?= form_input($from_date_y) ?>
				<?= form_label("年 ", "from_year") ?>
				<?= form_dropdown('from_month', $date_m) ?>
				<?= form_label("月 ", "from_month") ?>
				<?= form_dropdown('from_day', $date_d) ?>
				<?= form_label("日", "from_day") ?>
			</section>
			<section>
				<h4><?= form_label("作業実施日入力", "datetimes") ?>(※テキスト登録の場合、作業実施日選択データは無効になります)</h4>
				<?= form_input($datetimes) ?>
			</section>
			<section>
				<h4><?= form_label("タイトル", "title") ?></h4>
				<?= form_input($title) ?>
			</section>
			<section>
				<h4><?= form_label("作業内容", "body") ?></h4>
				<?= form_textarea($body) ?>
			</section>
			<section>
				<?= form_submit("workSubmit", "登録") ?>
			</section>
		</article>
	<?= form_close() ?>

</div>

<!-- footer -->
<?php $this -> load -> view('layout/footer'); ?>

</body>
</html>
