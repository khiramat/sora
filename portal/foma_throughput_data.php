<!--
3 FOMA 帯域レポート
-->
<?php
$this -> load -> view('layout/page_break');
$this -> load -> helper('utility');
$last_sunday = get_last_sunday();
$result = $this -> insert_form_model -> get_bandwidth_data_report($last_sunday);

foreach($result as $key => $value){
	$game  = $value["foma-high-game"]/1000000;
	$zero  = $value["foma-high-zero"]/1000000;
	$other = $value["foma-high-other"]/1000000;
	$low   = $value["foma-low"]/1000000;
	$gtp   = $value["foma-gtp"]/1000000;
	$all = $game + $zero + $other + $low + $gtp;
}

?>
<section class = "subject">
	3 帯域利用状況について（FOMA）
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
	3-1 現在の帯域設定<br>
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
	<!--
	<div style="display: flex; align-items: center; justify-content: center; height: 220mm">
	<img src = "<?=base_url()?>assets/images/xi_pipe.jpg" width = "600" height = "700">
	</div>
	-->
</section>

<?php $this -> load -> view('layout/page_footer');
//
// foma All Traffic
//

$this -> load -> view('layout/page_break');
include($static_throughput . 'weekly_31.html');
?>
<section class = "chart">
	<div id = "line_foma-all" class = "throughput_top_all"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break');
include($static_throughput . 'daily_31.html'); ?>
<section class = "chart">
	<div id = "line_foma-all_1" class = "throughput_part"></div>
	<div id = "line_foma-all_2" class = "throughput_part"></div>
	<div id = "line_foma-all_3" class = "throughput_part"></div>
	<div id = "line_foma-all_4" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "chart">
	<div id = "line_foma-all_5" class = "throughput_part"></div>
	<div id = "line_foma-all_6" class = "throughput_part"></div>
	<div id = "line_foma-all_7" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<!--
//
// foma Traffic by Pipe Game
//
-->

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'weekly_32.html'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-game" class = "throughput_all"></div>
	<div id = "pie_foma-high-game" class = "throughput_all"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'daily_32.html'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-game_1" class = "throughput_part"></div>
	<div id = "pie_foma-high-game_1" class = "throughput_part"></div>
	<div id = "line_foma-high-game_2" class = "throughput_part"></div>
	<div id = "pie_foma-high-game_2" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-game_3" class = "throughput_part"></div>
	<div id = "pie_foma-high-game_3" class = "throughput_part"></div>
	<div id = "line_foma-high-game_4" class = "throughput_part"></div>
	<div id = "pie_foma-high-game_4" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-game_5" class = "throughput_part"></div>
	<div id = "pie_foma-high-game_5" class = "throughput_part"></div>
	<div id = "line_foma-high-game_6" class = "throughput_part"></div>
	<div id = "pie_foma-high-game_6" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-game_7" class = "throughput_part"></div>
	<div id = "pie_foma-high-game_7" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<!--
//
// foma Traffic by Pipe Zero
//
-->

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'weekly_33.html'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-zero" class = "throughput_all"></div>
	<div id = "pie_foma-high-zero" class = "throughput_all"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'daily_33.html'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-zero_1" class = "throughput_part"></div>
	<div id = "pie_foma-high-zero_1" class = "throughput_part"></div>
	<div id = "line_foma-high-zero_2" class = "throughput_part"></div>
	<div id = "pie_foma-high-zero_2" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-zero_3" class = "throughput_part"></div>
	<div id = "pie_foma-high-zero_3" class = "throughput_part"></div>
	<div id = "line_foma-high-zero_4" class = "throughput_part"></div>
	<div id = "pie_foma-high-zero_4" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-zero_5" class = "throughput_part"></div>
	<div id = "pie_foma-high-zero_5" class = "throughput_part"></div>
	<div id = "line_foma-high-zero_6" class = "throughput_part"></div>
	<div id = "pie_foma-high-zero_6" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-zero_7" class = "throughput_part"></div>
	<div id = "pie_foma-high-zero_7" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<!--
//
// foma Traffic by Pipe Other
//
-->

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'weekly_34.html'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-other" class = "throughput_all"></div>
	<div id = "pie_foma-high-other" class = "throughput_all"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'daily_34.html'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-other_1" class = "throughput_part"></div>
	<div id = "pie_foma-high-other_1" class = "throughput_part"></div>
	<div id = "line_foma-high-other_2" class = "throughput_part"></div>
	<div id = "pie_foma-high-other_2" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-other_3" class = "throughput_part"></div>
	<div id = "pie_foma-high-other_3" class = "throughput_part"></div>
	<div id = "line_foma-high-other_4" class = "throughput_part"></div>
	<div id = "pie_foma-high-other_4" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-other_5" class = "throughput_part"></div>
	<div id = "pie_foma-high-other_5" class = "throughput_part"></div>
	<div id = "line_foma-high-other_6" class = "throughput_part"></div>
	<div id = "pie_foma-high-other_6" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-high-other_7" class = "throughput_part"></div>
	<div id = "pie_foma-high-other_7" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<!--
//
// foma Traffic by Pipe Low
//
-->

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'weekly_35.html'); ?>
<section class = "paragraph">
	<div id = "line_foma-low" class = "throughput_all"></div>
	<div id = "pie_foma-low" class = "throughput_all"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>

<?php $this -> load -> view('layout/page_break'); ?>
<?php include($static_throughput . 'daily_35.html'); ?>
<section class = "paragraph">
	<div id = "line_foma-low_1" class = "throughput_part"></div>
	<div id = "pie_foma-low_1" class = "throughput_part"></div>
	<div id = "line_foma-low_2" class = "throughput_part"></div>
	<div id = "pie_foma-low_2" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-low_3" class = "throughput_part"></div>
	<div id = "pie_foma-low_3" class = "throughput_part"></div>
	<div id = "line_foma-low_4" class = "throughput_part"></div>
	<div id = "pie_foma-low_4" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-low_5" class = "throughput_part"></div>
	<div id = "pie_foma-low_5" class = "throughput_part"></div>
	<div id = "line_foma-low_6" class = "throughput_part"></div>
	<div id = "pie_foma-low_6" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
<?php $this -> load -> view('layout/page_break'); ?>
<section class = "paragraph">
	<div id = "line_foma-low_7" class = "throughput_part"></div>
	<div id = "pie_foma-low_7" class = "throughput_part"></div>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>


