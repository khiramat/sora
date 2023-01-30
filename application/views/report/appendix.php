<?php
$this->load->helper('url');
//$this->load->helper('utility');
//$last_month = get_last_month_n();
//$this_month = get_this_month_n();

// 必要な変数を生成
// $month_ary     = array("last", "this");
// $pipe_ary      = array("Xi", "FOMA");
// $hour_ary      = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
// $max_avg_ary   = array("m", "a");
//$split_page_arr = array(1, 2, 3, 4, 5, 6, 0);
$split_day_ary = array(1, 8, 15, 22, 29);
$html_mac_arr  = array('max' => '最大値', 'avg' => '平均値');
// array(トラフィックの時間 => array(rowspan値, アクセスユーザ数の時間, cssのclass名))
$active_user_time_arr = array(
		'0' => array(3, 2, 'even'), '3' => array(4, 6, 'odd'), '7' => array(3, 9, 'even'), '10' => array(3, 12, 'odd'), '13' => array(3, 15, 'even'), '16' => array(3, 18, 'odd'), '19' => array(4, 22, 'even'), '23' => array(1, 23, 'odd')
);


foreach ($month_ary as $month) {
	foreach ($pipe_ary as $pipe) {
		foreach ($hour_ary as $hour) {
			foreach ($max_avg_ary as $max_avg) {
				foreach ($split_day_ary as $split_day) {

					// 各時間の日付順の最大・平均トラフィックデータ配列を分解
					${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"} = explode(",", ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour});
					// 指定された日付順の最大・平均トラフィックデータを取得するための配列を生成
					if ($split_day == 29) { //２月の場合？
						$day_28 = ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day - 1];
						$day_29 = (empty(${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day])) ? null : ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day];
						$day_30 = (empty(${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day + 1])) ? null : ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day + 1];

						${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_" . $split_day . "_ary"} = array();
						if (isset($day_28)) {
							${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_" . $split_day . "_ary"} += array($day_28);
						}
						if (isset($day_29)) {
							${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_" . $split_day . "_ary"} += array($day_29);
						}
						if (isset($day_30)) {
							${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_" . $split_day . "_ary"} += array($day_30);
						}
						// 	${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_" . $split_day . "_ary"} = array(
						// 		${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day - 1],
						// 		${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day],
						// 		${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day + 1]
						// 	);

					} else {
						${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_" . $split_day . "_ary"} = array(
								${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day - 1], ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day], ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day + 1], ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day + 2], ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day + 3], ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day + 4], ${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_ary"}[$split_day + 5]
						);
					}
					// トラフィック表のための変数設定
					${$month . "_" . $pipe . "_" . $hour . "_" . $max_avg . $split_day} = max(${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour . "_" . $split_day . "_ary"});
				}
			}
		}
	}
}

// 共通テーブルヘッダ
$h1 = "運用レポート ポータルサイト";
$this->load->view('common/report_head');
// X軸 一覧
?>
<body>
<!-- Graph -->
<?php //$this->load->view('common/report_footer'); ?>
<script type="text/javascript" src="<?= base_url() ?>assets/js/highcharts.js"></script>
<script type="text/javascript">
	<?php

	foreach ($hour_ary as $hour) {
	$title = "トラフィックデータ " . $hour . "時";
	$data = "[{
		name: '3G(" . $last_month . "月度)',
        color: '#0099ff',
		data: [" . substr(${"last_m_FOMA_" . $hour}, 0, -1) . "]}, {
        name: '3G(" . $this_month . "月度)',
        color: '#ff9900',
        data: [" . substr(${"this_m_FOMA_" . $hour}, 0, -1) . "]}, {
        name: 'LTE(" . $last_month . "月度)',
        color: '#006699',
        data: [" . substr(${"last_m_Xi_" . $hour}, 0, -1) . "]}, {
        name: 'LTE(" . $this_month . "月度)',
        color: '#cc0000',
        data: [" . substr(${"this_m_Xi_" . $hour}, 0, -1) . "]}]
        ";
	?>
	$(function () {
		lineChartAppendix("line_<?=$hour?>", "<?=$title?>", <?=$data?>);
	});
	<?php } ?>

</script>
<?php
foreach ($hour_ary as $hour) {
	?>
	<article class="sheet">
		<?php
		$h1 = "トラフィックグラフ " . $hour . "時";
		?>
		<header>
			<h1><?= $h1 ?></h1>
			<div class="header"></div>
		</header>
		<section>
			<div id="line_<?= $hour ?>"
					 style="width: 90%; height: 140mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
		</section>
		<br>
		<?php $this->load->view('common/report_footer'); ?>
	</article>
<?php }
$data = "[";
foreach ($hour_ary as $hour) {
	$data .= "{
		name: '" . $hour . ":00',
		data: [" . substr(${"this_m_Xi_" . $hour}, 0, -1) . "]},
        ";
}
$data = substr($data, 0, -1);
$data .= "]";
?>

<script type="text/javascript">
	$(function () {
		lineChartAppendix("time", "時間帯別トラフィックグラフ", <?=$data?>);
	});
</script>


<!--　実データ表出力 ///////////////////////////////////////////////////////////////////////////////////// START -->
<?php foreach ($tb_data

as $pipe => $pipes){ ?>
<?php foreach (
		$pipes

		as $key => $types
) { ?>
	<?php foreach (
			$types

			as $type => $times
	) { ?>

		<!--//// 月、火、水、木 //////////////////////////////-->
		<article class="sheet">
			<!-- header -->
			<header>
				<h1>各時間のトラフィック状況について（<?= PIPE[$pipe] . $html_mac_arr[$type] . $title_arr[$pipe][$key] ?>)(1/2)</h1>
				<div class="header"></div>
			</header>
			<section>
				各時間における<?= PIPE[$pipe] ?>トラフィックの状況を以下に記載致します。<br>
				<?= $str_arr[$pipe][$key] ?>
			</section>

			<!-- 本文 -->
			<!-- 月中に増速（減速）があった場合、増速後月末まで日程が短いと全ての曜日が取得できない場合があり、配列からデータが取得できないのでエラーとなる。
			  エラーの対策として、View の HTML を分割し、配列の曜日に対して日付が存在する・しないで表示処理を分岐させることで、エラーを回避する。 -->
			<section>
				<table>
					<tr>
						<th class='time'>時間</th>
						<!-- 曜日に対して前月の日付があれば日付を表示。なければ - を表示。  -->
						<th colspan='3' class='last'><?= WEEK_NAME[1] ?><?php echo (isset($week_date[$pipe][$key][$last_month][1])) ? '(' . $week_date[$pipe][$key][$last_month][1] : '( -'; ?>
							)
						</th>
						<!-- 曜日に対して前月と今月両方の日付があれば日付を表示。なければ - を表示。  -->
						<th colspan='3' class='this'><?= WEEK_NAME[1] ?><?php echo ((isset($week_date[$pipe][$key][$last_month][1])) && (isset($week_date[$pipe][$key][$this_month][1]))) ? '(' . $week_date[$pipe][$key][$this_month][1] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='last'><?= WEEK_NAME[2] ?><?php echo (isset($week_date[$pipe][$key][$last_month][2])) ? '(' . $week_date[$pipe][$key][$last_month][2] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='this'><?= WEEK_NAME[2] ?><?php echo ((isset($week_date[$pipe][$key][$last_month][2])) && (isset($week_date[$pipe][$key][$this_month][2]))) ? '(' . $week_date[$pipe][$key][$this_month][2] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='last'><?= WEEK_NAME[3] ?><?php echo (isset($week_date[$pipe][$key][$last_month][3])) ? '(' . $week_date[$pipe][$key][$last_month][3] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='this'><?= WEEK_NAME[3] ?><?php echo ((isset($week_date[$pipe][$key][$last_month][3])) && (isset($week_date[$pipe][$key][$this_month][3])) )? '(' . $week_date[$pipe][$key][$this_month][3] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='last'><?= WEEK_NAME[4] ?><?php echo (isset($week_date[$pipe][$key][$last_month][4])) ? '(' . $week_date[$pipe][$key][$last_month][4] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='this'><?= WEEK_NAME[4] ?><?php echo ((isset($week_date[$pipe][$key][$last_month][4])) && (isset($week_date[$pipe][$key][$this_month][4])) )? '(' . $week_date[$pipe][$key][$this_month][4] : '( -'; ?>
							)
						</th>
					</tr>

					<?php foreach ($times as $time => $weeks) { ?>
						<?php $css['th'] = ($time % 2 == 0) ? "time_even" : "time_odd"; ?>
						<?php $css[$last_month] = ($time % 2 == 0) ? "last_time_even" : "last_time_odd"; ?>
						<?php $css[$this_month] = ($time % 2 == 0) ? "this_time_even" : "this_time_odd"; ?>
						<tr>
							<th class=<?= $css['th'] ?>><?= $time ?>:00</th>
							<?php for ($i = 1; $i <= 4; $i++) {
								if (isset($weeks[$i][$last_month])) { // 月曜日から木曜日まで各々に対応する前月の日付が存在するか確認。存在する場合の処理（まず前月分のデータを取得し表示）
									?>
									<?php $css['last_warning'] = ($weeks[$i][$last_month][1] >= 90) ? "red" : "black"; ?>
									<td class=<?= $css[$last_month] ?>><?= number_format($weeks[$i][$last_month][0]) ?></td>
									<td class=<?= $css[$last_month] ?> style="color:<?= $css['last_warning'] ?>;"><?= $weeks[$i][$last_month][1] ?>
										%
									</td>
									<?php if (isset($active_user_time_arr[$time])) { ?>
										<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=last_time_<?= $active_user_time_arr[$time][2] ?> nowrap>
											<?php if ($time < 23) { ?>
												<?= $user_count[$pipe][$key][$last_month][$i][$active_user_time_arr[$time][1]] ?>
											<? } else { ?>

											<?php } ?>
										</td>
									<?php } ?>

									<?php if (isset($weeks[$i][$this_month])) { // 月曜日から木曜日まで各々に対応する今月の日付が存在するか確認。存在する場合の処理（今月分のデータを取得し表示）

										?>
										<?php $css['last_warning'] = ($weeks[$i][$this_month][1] >= 90) ? "red" : "black"; ?>
										<td class=<?= $css[$this_month] ?>><?= number_format($weeks[$i][$this_month][0]) ?></td>
										<td class=<?= $css[$this_month] ?> style="color:<?= $css['last_warning'] ?>"><?= $weeks[$i][$this_month][1] ?>
											%
										</td>
										<?php if (isset($active_user_time_arr[$time])) { ?>
											<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=this_time_<?= $active_user_time_arr[$time][2] ?> nowrap>
												<?php if ($time < 23) { ?>
													<?= $user_count[$pipe][$key][$this_month][$i][$active_user_time_arr[$time][1]] ?>
												<? } else { ?>
													&nbsp;
												<?php } ?>
											</td>
										<?php } ?>
									<?php } else { // 月曜日から木曜日まで各々に対応する今月の日付が存在するか確認。存在しない場合の処理（今月分のデータを取得しない）
										?>
										<td class=<?= $css[$this_month] ?>></td>
										<td class=<?= $css[$this_month] ?> style="color:<?= $css['this_warning'] ?>"></td>
										<?php if (isset($active_user_time_arr[$time])) { ?>
											<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=this_time_<?= $active_user_time_arr[$time][2] ?> nowrap></td>
										<?php } ?>
									<?php } ?>
								<?php } else { // 月曜日から木曜日まで各々に対応する前月の日付が存在するか確認。存在しない場合の処理（今月、先月どちらもデータも取得しない）
									?>
										<td class=<?= $css[$last_month] ?>></td>
										<td class=<?= $css[$last_month] ?> style="color:<?= $css['last_warning'] ?>;">
										</td>
										<?php if (isset($active_user_time_arr[$time])) { ?>
											<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=last_time_<?= $active_user_time_arr[$time][2] ?> nowrap>
											</td>
										<?php } ?>
										<td class=<?= $css[$this_month] ?>></td>
										<td class=<?= $css[$this_month] ?> style="color:<?= $css['this_warning'] ?>"></td>
										<?php if (isset($active_user_time_arr[$time])) { ?>
											<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=this_time_<?= $active_user_time_arr[$time][2] ?> nowrap>
											</td>
										<?php } ?>
								<?php } ?>
							<?php } ?>
						</tr>
					<?php } ?>
				</table>
				<br>
			</section>
			<!-- footer -->
			<?php //$this->load->view('common/report_footer'); ?>
		</article>

		<!--// 金、土、日 //////////////////////////////////////////-->
		<article class="sheet">
			<!-- header -->
			<header>
				<h1>各時間のトラフィック状況について（<?= PIPE[$pipe] . $html_mac_arr[$type] . $title_arr[$pipe][$key] ?>)(2/2)</h1>
				<div class="header"></div>
			</header>
			<section>
				各時間における<?= PIPE[$pipe] ?>トラフィックの状況を以下に記載致します。<br>
				<?= $str_arr[$pipe][$key] ?>
			</section>

			<!-- 本文 -->
			<section>
				<table>
					<tr>
						<th class='time'>時間</th>
						<th colspan='3' class='last'><?= WEEK_NAME[5] ?><?php echo (isset($week_date[$pipe][$key][$last_month][5])) ? '(' . $week_date[$pipe][$key][$last_month][5] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='this'><?= WEEK_NAME[5] ?><?php echo ((isset($week_date[$pipe][$key][$last_month][5])) && (isset($week_date[$pipe][$key][$this_month][5])))? '(' . $week_date[$pipe][$key][$this_month][5] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='last'><?= WEEK_NAME[6] ?><?php echo (isset($week_date[$pipe][$key][$last_month][6])) ? '(' . $week_date[$pipe][$key][$last_month][6] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='this'><?= WEEK_NAME[6] ?><?php echo ((isset($week_date[$pipe][$key][$last_month][6])) && (isset($week_date[$pipe][$key][$this_month][6])) )? '(' . $week_date[$pipe][$key][$this_month][6] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='last'><?= WEEK_NAME[0] ?><?php echo (isset($week_date[$pipe][$key][$last_month][0])) ? '(' . $week_date[$pipe][$key][$last_month][0] : '( -'; ?>
							)
						</th>
						<th colspan='3' class='this'><?= WEEK_NAME[0] ?><?php echo ((isset($week_date[$pipe][$key][$last_month][0])) && (isset($week_date[$pipe][$key][$this_month][0])) )? '(' . $week_date[$pipe][$key][$this_month][0] : '( -'; ?>
							)
						</th>
					</tr>

					<?php foreach ($times as $time => $weeks) { ?>
						<?php $css['th'] = ($time % 2 == 0) ? "time_even" : "time_odd"; ?>
						<?php $css[$last_month] = ($time % 2 == 0) ? "last_time_even" : "last_time_odd"; ?>
						<?php $css[$this_month] = ($time % 2 == 0) ? "this_time_even" : "this_time_odd"; ?>
						<tr>
							<th class=<?= $css['th'] ?>><?= $time ?>:00</th>
							<?php for ($i = 5; $i <= 7; $i++) { ?>
								<?php $j = ($i == 7) ? 0 : $i ?>

								<?php if (isset($weeks[$j][$last_month])) { //金曜日から日曜日まで各々に対応する前月の日付が存在するか確認。存在する場合の処理（まず前月分のデータを取得し表示）
									?>
									<?php $css['last_warning'] = ($weeks[$j][$last_month][1] >= 90) ? "red" : "black"; ?>
									<td class=<?= $css[$last_month] ?>><?= number_format($weeks[$j][$last_month][0]) ?></td>
									<td class=<?= $css[$last_month] ?> style="color:<?= $css['last_warning'] ?>"><?= $weeks[$j][$last_month][1] ?>
										%
									</td>
									<?php if (isset($active_user_time_arr[$time])) { ?>
										<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=last_time_<?= $active_user_time_arr[$time][2] ?> nowrap>
											<?php if ($time < 23) { ?>
												<?= $user_count[$pipe][$key][$last_month][$j][$active_user_time_arr[$time][1]] ?>
											<? } else { ?>
												&nbsp;
											<?php } ?>
										</td>
									<?php } ?>

									<?php if (isset($weeks[$j][$this_month])) { //金曜日から日曜日まで各々に対応する今月の日付が存在するか確認。存在する場合の処理（まず前月分のデータを取得し表示）
										?>

										<?php $css['this_warning'] = ($weeks[$j][$this_month][1] >= 90) ? "red" : "black"; ?>
										<td class=<?= $css[$this_month] ?>><?= number_format($weeks[$j][$this_month][0]) ?></td>
										<td class=<?= $css[$this_month] ?> style="color:<?= $css['this_warning'] ?>"><?= $weeks[$j][$this_month][1] ?>
											%
										</td>
										<?php if (isset($active_user_time_arr[$time])) { ?>
											<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=this_time_<?= $active_user_time_arr[$time][2] ?> nowrap>
												<?php if ($time < 23) { ?>
													<?= $user_count[$pipe][$key][$this_month][$j][$active_user_time_arr[$time][1]] ?>
												<? } else { ?>
													&nbsp;
												<?php } ?>
											</td>
										<?php } ?>

									<?php } else { //金曜日から日曜日まで各々に対応する今月の日付が存在するか確認。存在しない場合の処理（今月分のデータを取得しない）
										?>

										<td class=<?= $css[$this_month] ?>></td>
										<td class=<?= $css[$this_month] ?> style="color:<?= $css['this_warning'] ?>">
										</td>
										<?php if (isset($active_user_time_arr[$time])) { ?>
											<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=this_time_<?= $active_user_time_arr[$time][2] ?> nowrap></td>
										<?php } ?>
									<?php } ?>

								<?php } else { //金曜日から日曜日まで各々に対応する前月の日付が存在するか確認。存在しない場合の処理（今月、前月分両方のデータを取得しない）
									?>

									<td class=<?= $css[$last_month] ?>></td>
									<td class=<?= $css[$last_month] ?> style="color:<?= $css['last_warning'] ?>"></td>
									<?php if (isset($active_user_time_arr[$time])) { ?>
										<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=last_time_<?= $active_user_time_arr[$time][2] ?> nowrap></td>
									<?php } ?>
									<td class=<?= $css[$this_month] ?>></td>
									<td class=<?= $css[$this_month] ?> style="color:<?= $css['this_warning'] ?>"></td>
									<?php if (isset($active_user_time_arr[$time])) { ?>
										<td rowspan=<?= $active_user_time_arr[$time][0] ?> class=this_time_<?= $active_user_time_arr[$time][2] ?> nowrap></td>
									<?php } ?>

								<?php } ?>
							<?php } ?>
						</tr>
					<?php } ?>
				</table>

				<br>
			</section>
			<!-- footer -->
			<?php //$this->load->view('common/report_footer'); ?>
		</article>

	<?php } ?>
<?php } ?>
<?php } ?><!-- foreach($tb_data as $pipe => $pipes)のend -->
<!--　実データ表出力 ///////////////////////////////////////////////////////////////////////////////////// END -->


<!-- footer -->

</body>
</html>
