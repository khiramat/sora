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
		<h3>基準値設定</h3>
		<?= form_open_multipart('setup/base_value_update') ?>
		<section>
			<?= form_label("帯域基準値 kbps", "") ?><br>
			<?= form_input('base_value') ?>
		</section>
		<section>
			<?= form_submit("submit", "送信") ?>
		</section>
	</article>
</div>
<!-- footer -->
<?php $this -> load -> view('layout/footer'); ?>
</body>
</html>
