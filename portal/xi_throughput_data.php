<!--
Xi 帯域レポート
-->
<?php
$this -> load -> view('layout/page_break');
$this -> load -> helper('utility');
$last_sunday = get_last_sunday();
$result = $this -> insert_form_model -> get_bandwidth_data_report($last_sunday);

foreach($result as $key => $value){
	$game  = $value["xi-high-game"]/1000000;
	$zero  = $value["xi-high-zero"]/1000000;
	$other = $value["xi-high-other"]/1000000;
	$low   = $value["xi-low"]/1000000;
	$gtp   = $value["xi-gtp"]/1000000;
	$all = $game + $zero + $other + $low + $gtp;
}

?>
<section class = "subject">
	2 帯域利用状況について（Xi）
</section>
<section class = "paragraph">
	<table>
		<tr>
			<th>目的</th>
			<td>各土管での帯域利用状況を確認し、帯域増速の目安を把握する。</td>
		</tr>
		<tr>
			<th>表示内容</th>
			<td>各土管に対する帯域利用状況</td>
		</tr>
	</table>
</section>

<section class = "paragraph">
	2-1 現在の帯域設定<br>
	現在の帯域設定を以下に記載いたします。
</section>
<section class = "paragraph">
	<div class = "pipe">
		<div class = "all">契約帯域<br>（<?=$all?>Mbps）</div>
		<div class = "game">高速ルール用土管<br>（カウントフリー対象：ゲーム）<br>（<?=$game?>Mbps）</div>
		<div class = "zero">高速ルール用土管<br>（カウントフリー対象：その他）<br>（<?=$zero?>Mbps）</div>
		<div class = "other">高速ルール用土管<br>（カウントフリー対象外）<br>（<?=$other?>Mbps）</div>
		<div class = "low">低速ルール用土管<br>（<?=$low?>Mbps）</div>
		<div class = "gtp">GTP<br>（<?=$gtp?>Mbps）</div>
	</div>
</section>
<?php
$this -> load -> view('layout/page_footer');

//
// Xi All Traffic
//

$this -> load -> view('layout/page_break');
include($static_throughput . 'weekly_11.html');
?>
<section class = "chart">
	<div id = "line_xi-all" class = "throughput_top_all"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break');
include($static_throughput . 'daily_11.html'); ?>
<section class = "chart">
	<div id = "line_xi-all_1" class = "throughput_part"></div>
	<div id = "line_xi-all_2" class = "throughput_part"></div>
	<div id = "line_xi-all_3" class = "throughput_part"></div>
	<div id = "line_xi-all_4" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "chart">
	<div id = "line_xi-all_5" class = "throughput_part"></div>
	<div id = "line_xi-all_6" class = "throughput_part"></div>
	<div id = "line_xi-all_7" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<!--
//
// Xi Traffic by Pipe Game
//
-->

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'weekly_12.html'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-game" class = "throughput_all"></div>
	<div id = "pie_xi-high-game" class = "throughput_all"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'daily_12.html'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-game_1" class = "throughput_part"></div>
	<div id = "pie_xi-high-game_1" class = "throughput_part"></div>
	<div class = "comment"></div>
	<div id = "line_xi-high-game_2" class = "throughput_part"></div>
	<div id = "pie_xi-high-game_2" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-game_3" class = "throughput_part"></div>
	<div id = "pie_xi-high-game_3" class = "throughput_part"></div>
	<div class = "comment"></div>
	<div id = "line_xi-high-game_4" class = "throughput_part"></div>
	<div id = "pie_xi-high-game_4" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-game_5" class = "throughput_part"></div>
	<div id = "pie_xi-high-game_5" class = "throughput_part"></div>
	<div class = "comment"></div>
	<div id = "line_xi-high-game_6" class = "throughput_part"></div>
	<div id = "pie_xi-high-game_6" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-game_7" class = "throughput_part"></div>
	<div id = "pie_xi-high-game_7" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<!--
//
// Xi Traffic by Pipe Zero
//
-->

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'weekly_13.html'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-zero" class = "throughput_all"></div>
	<div id = "pie_xi-high-zero" class = "throughput_all"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'daily_13.html'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-zero_1" class = "throughput_part"></div>
	<div id = "pie_xi-high-zero_1" class = "throughput_part"></div>
	<div class = "comment"></div>
	<div id = "line_xi-high-zero_2" class = "throughput_part"></div>
	<div id = "pie_xi-high-zero_2" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-zero_3" class = "throughput_part"></div>
	<div id = "pie_xi-high-zero_3" class = "throughput_part"></div>
	<div class = "comment"></div>
	<div id = "line_xi-high-zero_4" class = "throughput_part"></div>
	<div id = "pie_xi-high-zero_4" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-zero_5" class = "throughput_part"></div>
	<div id = "pie_xi-high-zero_5" class = "throughput_part"></div>
	<div class = "comment"></div>
	<div id = "line_xi-high-zero_6" class = "throughput_part"></div>
	<div id = "pie_xi-high-zero_6" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-zero_7" class = "throughput_part"></div>
	<div id = "pie_xi-high-zero_7" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<!--
//
// Xi Traffic by Pipe Other
//
-->

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'weekly_14.html'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-other" class = "throughput_all"></div>
	<div id = "pie_xi-high-other" class = "throughput_all"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'daily_14.html'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-other_1" class = "throughput_part"></div>
	<div id = "pie_xi-high-other_1" class = "throughput_part"></div>
	<div class = "comment"></div>
	<div id = "line_xi-high-other_2" class = "throughput_part"></div>
	<div id = "pie_xi-high-other_2" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-other_3" class = "throughput_part"></div>
	<div id = "pie_xi-high-other_3" class = "throughput_part"></div>
	<div class = "comment"></div>
	<div id = "line_xi-high-other_4" class = "throughput_part"></div>
	<div id = "pie_xi-high-other_4" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-other_5" class = "throughput_part"></div>
	<div id = "pie_xi-high-other_5" class = "throughput_part"></div>
	<div class = "comment"></div>
	<div id = "line_xi-high-other_6" class = "throughput_part"></div>
	<div id = "pie_xi-high-other_6" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-high-other_7" class = "throughput_part"></div>
	<div id = "pie_xi-high-other_7" class = "throughput_part"></div>
	<div class = "comment"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<!--
//
// Xi Traffic by Pipe Low
//
-->

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'weekly_15.html'); ?>
<section class = "paragraph">
	<div id = "line_xi-low" class = "throughput_all"></div>
	<div id = "pie_xi-low" class = "throughput_all"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'daily_15.html'); ?>
<section class = "paragraph">
	<div id = "line_xi-low_1" class = "throughput_part"></div>
	<div id = "pie_xi-low_1" class = "throughput_part"></div>
	<div id = "line_xi-low_2" class = "throughput_part"></div>
	<div id = "pie_xi-low_2" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-low_3" class = "throughput_part"></div>
	<div id = "pie_xi-low_3" class = "throughput_part"></div>
	<div id = "line_xi-low_4" class = "throughput_part"></div>
	<div id = "pie_xi-low_4" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-low_5" class = "throughput_part"></div>
	<div id = "pie_xi-low_5" class = "throughput_part"></div>
	<div id = "line_xi-low_6" class = "throughput_part"></div>
	<div id = "pie_xi-low_6" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_xi-low_7" class = "throughput_part"></div>
	<div id = "pie_xi-low_7" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
