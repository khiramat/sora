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

	<h3>作業報告一覧</h3>

	<div>
		<a href="/report_sora/setup/work">>>作業報告登録フォームへ</a>
	</div>

	<font color='blue'><?= $message ?></font>			<!--バリデーションエラーのない場合はサクセスメッセージを表示する-->
	<font color='red'><?= validation_errors() ?></font>	<!--バリデーションエラーの場合はメッセージを表示する-->

	<article>
		<section>
			<table width="900" cellpadding="15">
				<tr bgcolor='#D8D6D5'>
					<th style='border-right: #313131 solid 1px; text-align: center; width: 20px;'>実行</th>
					<th style='border-right: #313131 solid 1px; text-align: center;' nowrap>作業実施日<br>(YYYY-MM-DD)</th>
					<th style='border-right: #313131 solid 1px; text-align: center;' nowrap>作業実施日</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>タイトル</th>
					<th style='border-right: #313131 solid 1px; text-align: center;'>作業内容</th>
				</tr>
				<?php foreach($datas as $key => $val){ ?>
					<tr>
						<td style='vertical-align: middle; text-align: center; width: 20px;' >
							<?= form_open('setup/work') ?>
								<input type="hidden" name="id" id="id" value="<?= $val['id'] ?>">
								<?= form_submit("Submit", "編集") ?>
							<?= form_close() ?>
							<?= form_open('setup/work_delete') ?>
								<input type="hidden" name="id" id="id" value="<?= $val['id'] ?>">
								<?= form_submit("Submit", "削除") ?>
							<?= form_close() ?>
						</td>
						<td style='text-align: center;' nowrap><?= $val['day'] ?></td>
						<td style='text-align: center;' nowrap><?= $val['datetimes'] ?></td>
						<td style='text-align: left;' ><?= $val['title'] ?></td>
						<td style='text-align: left;' ><?= nl2br($val['body']) ?></td>
					</tr>

				<?php } ?>
			</table>
		</section>
	</article>

</div>

<!-- footer -->
<?php $this -> load -> view('layout/footer'); ?>

</body>
</html>
