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
			<h3>作業報告登録完了</h3>
			<br>
			<section>
			<h4><?= $message ?></h4>
			</section>
			<section>
				<a href="/report_sora/setup/work">>>続けて入力</a><br>
				<a href="/report_sora/setup/work_list">>>作業報告一覧へ</a>
			</section>
			<!-- footer -->
			<?php $this -> load -> view('layout/footer'); ?>
		</article>
	</div>
</body>
</html>
