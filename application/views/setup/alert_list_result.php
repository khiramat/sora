<html lang = "jp">
<head>
	<?php $this -> load -> view('layout/import'); ?>
	<?php $this -> load -> helper('utility'); ?>
	<title><?=SITE_NAME?></title>
</head>
<body class = "cloak">
	<!-- header -->
	<?php $this -> load -> view('layout/header'); ?>
	<div class = "container">
		<article>
			<h3>アラート報告ソート削除完了</h3>
			<br>
			<section>
			<h4><?= $message ?></h4>
			</section>
			<section>
				<a href="/report_sora/setup/alert_list"> >>アラート報告一覧へ</a><br>
				<a href="/report_sora/setup/alert"> >>新規入力画面へ</a>
			</section>
			<!-- footer -->
			<?php $this -> load -> view('layout/footer'); ?>
		</article>
	</div>
</body>
</html>
