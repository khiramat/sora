<html lang = "jp">
<head>
	<?php $this -> load -> view('layout/import'); ?>
	<?php $this -> load -> helper('utility'); ?>
	<style type="text/css">
		th,td {
			border: solid 1px; margin: 20px 20px 20px 20px;           /* 枠線指定 */
		}

		table {
			border-collapse:  collapse;     /* セルの線を重ねる */
			/* margin: 20px 20px 20px 20px; */
		}
	</style>
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
		'maxlength' => '400',
		// 'size'      => '20',
		'cols' 		=> '80',
		'rows' 		=> '5'
	);

	$body = array(
		'name'      => 'body',
		'id'        => 'body',
		'value' 	=> '',
		'maxlength' => '400',
		// 'size'      => '20',
		'cols' 		=> '80',
		'rows' 		=> '5'
	);

	$cause = array(
		'name'      => 'cause',
		'id'        => 'cause',
		'value' 	=> '',
		'maxlength' => '400',
		// 'size'      => '20',
		'cols' 		=> '80',
		'rows' 		=> '5'
	);
?>

<div class = "container">

	<h3>帯域設定履歴</h3>

	<div>
		<a href="/report_sora/setup/bandwidth">>>帯域設定フォームへ</a>
	</div>

	<font color='blue'><?= $message ?></font>			<!--バリデーションエラーのない場合はサクセスメッセージを表示する-->
	<font color='red'><?= validation_errors() ?></font>	<!--バリデーションエラーの場合はメッセージを表示する-->

	<article>
		<section>
			<table width="500" cellpadding="15">
				<tr bgcolor='#D8D6D5'>
					<th style='border-right: #313131 solid 1px; text-align: center; width: 20px;'>実行</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>帯域変更日付</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>LTE(bps)</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>3G(bps)</th>
				</tr>
				<?php foreach($datas as $key => $val){ ?>
					<?= form_open('setup/bandwidth_delete') ?>
						<input type="hidden" name="datetime" id="datetime" value="<?= $val['datetime'] ?>">
						<tr>
							<td style='text-align: center; width: 20px;' ><?= form_submit("Submit", "削除") ?></td>
							<td style='text-align: center;' nowrap><?= $val['datetime'] ?></td>
							<td style='text-align: center;' nowrap><?= $val['Xi'] ?></td>
							<td style='text-align: center;' nowrap><?= $val['FOMA'] ?></td>
						</tr>
					<?= form_close() ?>
				<?php } ?>
			</table>
		</section>
	</article>

</div>

<!-- footer -->
<?php $this -> load -> view('layout/footer'); ?>

</body>
</html>
