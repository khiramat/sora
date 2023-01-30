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

	<h3>アラート報告一覧</h3>
	※レポートにはページ毎、登録順に表示されます。<br>
	※今月分データのみ表示されます。<br><br>

	<div>
		<a href="/report_sora/setup/alert">>>アラート報告登録画面へ</a>
	</div>

	<font color='blue'><?= $message ?></font>			<!--バリデーションエラーのない場合はサクセスメッセージを表示する-->
	<font color='red'><?= validation_errors() ?></font>	<!--バリデーションエラーの場合はメッセージを表示する-->

	<article>
		<section>
			<table cellpadding="15">
				<tr bgcolor='#D8D6D5'>
					<th style='border-right: #313131 solid 1px; text-align: center;'>実行</th>
					<th style='border-right: #313131 solid 1px; text-align: center;' nowrap>ページ</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>アラート種別</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>発生源</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>発生日時</th>
					<th style='border-right: #313131 solid 1px; text-align: center;' nowrap>サービス<br>影響</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>アラート内容</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>発生原因</th>
				</tr>
				<?php foreach($datas as $key => $val){ ?>
					<?= form_open('setup/alert_delete') ?>
						<input type="hidden" name="id" id="id" value="<?= $val['id'] ?>">
						<tr>
							<td><?= form_submit("Submit", "削除") ?></td>
							<td style='vertical-align: top; text-align: center;' nowrap><?= $val['page'] ?></td>
							<td style='vertical-align: top;' nowrap><?= ALERT_TYPE_ARR[$val['type']] ?></td>
							<td style='vertical-align: top;' nowrap><?= implode("<br>", $val['hostname']) ?></td>
							<td style='vertical-align: top;' nowrap><?= nl2br($val['datetimes']) ?></td>
							<td style='vertical-align: top; text-align: center;' nowrap><?= EXISTENCE_ARR[$val['service_flg']] ?></td>
							<td style='vertical-align: top; width: 250px;'><?= $val['body'] ?></td>
							<td style='vertical-align: top;'><?= $val['cause'] ?></td>
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
