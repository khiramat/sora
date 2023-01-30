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
?>
<div class = "container">
	<article>
		<h3>CSV File Upload 結果</h3>
		<br>
		<section>
			<h4><?=$message?></h4>
		</section>
	</article>
</div>
<!-- footer -->
<?php $this -> load -> view('layout/footer'); ?>
</body>
</html>
