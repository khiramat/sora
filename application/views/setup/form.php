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

	$body = array(
		'name'      => 'body',
		'id'        => 'body',
		"value" 	=> set_value("body"),
		'maxlength' => '1000',
		// 'size'      => '60',
		'cols' 		=> '80',
		'rows' 		=> '10'
	);
?>

<div class = "container">

	<h3>月次報告書 文言登録</h3>
	<font color='red'>
		<font color='blue'><?= $message ?></font>			<!--バリデーションエラーのない場合はサクセスメッセージを表示する-->
		<font color='red'><?= validation_errors() ?></font>	<!--バリデーションエラーの場合はメッセージを表示する-->
	</font>
	<?= form_open('setup/form_valid') ?>
		<article>
			<section>
				<h4> <?= form_label("タイトル ", "TITLE") ?></h4>
				<?= form_dropdown('title', $title) ?>
			</section>
			<section>
				<h4><?= form_label("本文", "BODY") ?></h4>
				<?= form_textarea($body) ?>
			</section>
			<section>
				<?= form_submit("submit", "登録") ?>
			</section>
		</article>
	<?= form_close() ?>

</div>

<!-- footer -->
<?php $this -> load -> view('layout/footer'); ?>

</body>
</html>
