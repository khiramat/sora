<!--
8　エゴサーチ結果
-->
<?php
$this -> load -> view('layout/page_break');
$this -> load -> helper('utility');
$last_monday_tbl1 = date('m月d日', strtotime("monday previous week"));
$last_monday_tbl2 = date('m月d日', strtotime("3 weeks ago monday"));
$last_monday_tbl3 = date('m月d日', strtotime("4 weeks ago monday"));
$last_monday_tbl4 = date('m月d日', strtotime("5 weeks ago monday"));

$sdate_2 = date('Y-m-d', strtotime("3 weeks ago monday"));
$sdate_3 = date('Y-m-d', strtotime("4 weeks ago monday"));
$sdate_4 = date('Y-m-d', strtotime("5 weeks ago monday"));

$last_monday  = date('Y-m-d', strtotime("monday previous week"));
$last_sunday  = date('Y-m-d', strtotime("sunday previous week"));
$last_sunday2 = date('Y-m-d', strtotime("$last_monday +6 day"));
// レポート対象期間の収集対象ツイート全件数取得
$result = $this -> insert_form_model -> get_negative_word_total($last_monday, $last_sunday);
foreach($result as $key => $value){
	$total = $value["total"];
}
// レポート対象期間の収集対象ツイート全件から関連キーワード毎の件数取得
$result         = $this -> insert_form_model -> get_negative_word_calc($last_monday, $last_sunday);
$commu          = 0;
$cf             = 0;
$commu_negative = 0;
$cf_negative    = 0;
foreach($result as $key => $value){
	$negative_word       = $value["negative_word"];
	$negative_word_count = $value["negative_word_count"];
	$cf_flg              = $value["cf_flg"];
	$negative_flg        = $value["negative_flg"];
	if($cf_flg == 0){
		$commu += $negative_word_count;
	} elseif($cf_flg == 1) {
		$cf += $negative_word_count;
	}
	if($cf_flg == 0 && $negative_flg == 1){
		$commu_negative += $negative_word_count;
	} else if($cf_flg == 1 && $negative_flg == 1){
		$cf_negative += $negative_word_count;
	}
}
// 全件数に占める各キーワード毎の件数の割合を計算
$commu_pctg      = ROUND($commu / $total * 100, 2);
$commu_ngtv_pctg = ROUND($commu_negative / $total * 100, 2);
$cf_pctg         = ROUND($cf / $total * 100, 2);
$cf_ngtv_pctg    = ROUND($cf_negative / $total * 100, 2);

$result = $this -> insert_form_model -> get_ego_data($last_monday);

foreach($result as $key => $value){
	if($value["media_code"] == 2){
		$ch2_total          = $value["total"];
		$ch2_commu          = $value["commu_total"];
		$ch2_commu_negative = $value["commu_negative"];
		$ch2_cf             = $value["cf_total"];
		$ch2_cf_negative    = $value["cf_negative"];
	} else if($value["media_code"] == 3){
		$baku_total          = $value["total"];
		$baku_commu          = $value["commu_total"];
		$baku_commu_negative = $value["commu_negative"];
		$baku_cf             = $value["cf_total"];
		$baku_cf_negative    = $value["cf_negative"];
	}
}

$ch2_commu_pctg = ROUND($ch2_commu / $ch2_total * 100, 2);
if(is_nan($ch2_commu_pctg)){
	$ch2_commu_pctg = 0;
}
$ch2_commu_negative_pctg = ROUND($ch2_commu_negative / $ch2_total * 100, 2);
if(is_nan($ch2_commu_negative_pctg)){
	$ch2_commu_negative_pctg = 0;
}
$ch2_cf_pctg = ROUND($ch2_cf / $ch2_total * 100, 2);
if(is_nan($ch2_cf_pctg)){
	$ch2_cf_pctg = 0;
}
$ch2_cf_negative_pctg = ROUND($ch2_cf_negative / $ch2_total * 100, 2);
if(is_nan($ch2_cf_negative_pctg)){
	$ch2_cf_negative_pctg = 0;
}

$baku_commu_pctg = ROUND($baku_commu / $baku_total * 100, 2);
if(is_nan($baku_commu_pctg)){
	$baku_commu_pctg = 0;
}
$baku_commu_negative_pctg = ROUND($baku_commu_negative / $baku_total * 100, 2);
if(is_nan($baku_commu_negative_pctg)){
	$baku_commu_negative_pctg = 0;
}
$baku_cf_pctg = ROUND($baku_cf / $baku_total * 100, 2);
if(is_nan($baku_cf_pctg)){
	$baku_cf_pctg = 0;
}
$baku_cf_negative_pctg = ROUND($baku_cf_negative / $baku_total * 100, 2);
if(is_nan($baku_cf_negative_pctg)){
	$baku_cf_negative_pctg = 0;
}

$all_total               = $total + $ch2_total + $baku_total;
$all_commu               = $commu + $ch2_commu + $baku_commu;
$all_commu_negative      = $commu_negative + $ch2_commu_negative + $baku_commu_negative;
$all_cf                  = $cf + $ch2_cf + $baku_cf;
$all_cf_negative         = $cf_negative + $ch2_cf_negative + $baku_cf_negative;
$all_commu_pctg          = ROUND($all_commu / $all_total * 100, 2);
$all_commu_negative_pctg = ROUND($all_commu_negative / $all_total * 100, 2);
$all_cf_pctg             = ROUND($all_cf / $all_total * 100, 2);
$all_cf_negative_pctg    = ROUND($all_cf_negative / $all_total * 100, 2);


?>
<section class = "subject">
	8 エゴサーチ結果
</section>
<section id = "paragraph">
	<table>
		<tr>
			<th class = 'info-td'>目的</th>
			<td>関連する2chや爆サイのスレッド、twitterのツイート情報を確認し、品質に関わるコメントを拾うことで、システム監視のみで検知できないものも検知する。
				また、継続的に確認することで、品質に関わる声が増えたタイミングなどで増速などの検討を開始する。
			</td>
		</tr>
		<tr>
			<th>対象サイト</th>
			<td>Twitter、2ch、爆サイ</td>
		</tr>
		<tr>
			<th>検索キーワード</th>
			<td>LinksMate・リンクスメイト・LogicLinks・ロジックリンクス・ロジリン・HRTSIM</td>
		</tr>
		<tr>
			<th>カウント対象</th>
			<td>以下のような発言をネガティブ件数としてカウントしております。(一例)<br>
				通信品質関連<br>
				・遅い・つながらない <br>
				カウントフリー・課金関連<br>
				・カウントフリーになっていない
			</td>
		</tr>
	</table>
</section>
<section id = "paragraph">
	8-1 カウント
</section>
<section id = "paragraph">
	<table>
		<tbody>
		<tr>
			<th rowspan = "2"></th>
			<th rowspan = "2" style = "text-align: center">全件</th>
			<th colspan = "4" style = "text-align: center">通信品質関連</th>
			<th colspan = "4" style = "text-align: center">カウントフリー関連</th>
		</tr>
		<tr>
			<th colspan = "2" style = "text-align: center">合計</th>
			<th colspan = "2" style = "text-align: center">ネガティブ件数</th>
			<th colspan = "2" style = "text-align: center">合計</th>
			<th colspan = "2" style = "text-align: center">ネガティブ件数</th>
		</tr>
		<tr>
			<th>Twitter</th>
			<td style = "text-align: right"><?=$total?> 件</td>
			<td style = "text-align: right"><?=$commu?> 件</td>
			<td style = "text-align: right"><?=$commu_pctg?> %</td>
			<td style = "text-align: right"><?=$commu_negative?> 件</td>
			<td style = "text-align: right"><?=$commu_ngtv_pctg?> %</td>
			<td style = "text-align: right"><?=$cf?> 件</td>
			<td style = "text-align: right"><?=$cf_pctg?> %</td>
			<td style = "text-align: right"><?=$cf_negative?> 件</td>
			<td style = "text-align: right"><?=$cf_ngtv_pctg?> %</td>
		</tr>
		<tr>
			<th>2ch</th>
			<td style = "text-align: right"><?=$ch2_total?> 件</td>
			<td style = "text-align: right"><?=$ch2_commu?> 件</td>
			<td style = "text-align: right"><?=$ch2_commu_pctg?> %</td>
			<td style = "text-align: right"><?=$ch2_commu_negative?> 件</td>
			<td style = "text-align: right"><?=$ch2_commu_negative_pctg?> %</td>
			<td style = "text-align: right"><?=$ch2_cf?> 件</td>
			<td style = "text-align: right"><?=$ch2_cf_pctg?> %</td>
			<td style = "text-align: right"><?=$ch2_cf_negative?> 件</td>
			<td style = "text-align: right"><?=$ch2_cf_negative_pctg?> %</td>
		</tr>
		<tr>
			<th>爆サイ</th>
			<td style = "text-align: right"><?=$baku_total?> 件</td>
			<td style = "text-align: right"><?=$baku_commu?> 件</td>
			<td style = "text-align: right"><?=$baku_commu_pctg?> %</td>
			<td style = "text-align: right"><?=$baku_commu_negative?> 件</td>
			<td style = "text-align: right"><?=$baku_commu_negative_pctg?> %</td>
			<td style = "text-align: right"><?=$baku_cf?> 件</td>
			<td style = "text-align: right"><?=$baku_cf_pctg?> %</td>
			<td style = "text-align: right"><?=$baku_cf_negative?> 件</td>
			<td style = "text-align: right"><?=$baku_cf_negative_pctg?> %</td>
		</tr>
		<tr>
			<th>合計</th>
			<td style = "text-align: right"><?=$all_total?> 件</td>
			<td style = "text-align: right"><?=$all_commu?> 件</td>
			<td style = "text-align: right"><?=$all_commu_pctg?> %</td>
			<td style = "text-align: right"><?=$all_commu_negative?> 件</td>
			<td style = "text-align: right"><?=$all_commu_negative_pctg?> %</td>
			<td style = "text-align: right"><?=$all_cf?> 件</td>
			<td style = "text-align: right"><?=$all_cf_pctg?> %</td>
			<td style = "text-align: right"><?=$all_cf_negative?> 件</td>
			<td style = "text-align: right"><?=$all_cf_negative_pctg?> %</td>
		</tr>
		</tbody>
	</table>
</section>
<section id = "paragraph">
	▼ 以下の表では、ネガティブ件数の％を記載しています。
</section>
<section id = "paragraph">
	<?php
	$result = $this -> insert_form_model -> get_ego_data($sdate_2);
	foreach($result as $key => $value){
		if($value["media_code"] == 1){
			$twitter_total_2          = $value["total"];
			$twitter_commu_2          = $value["commu_total"];
			$twitter_commu_negative_2 = $value["commu_negative"];
			$twitter_cf_2             = $value["cf_total"];
			$twitter_cf_negative_2    = $value["cf_negative"];
		} else if($value["media_code"] == 2){
			$ch2_total_2          = $value["total"];
			$ch2_commu_2          = $value["commu_total"];
			$ch2_commu_negative_2 = $value["commu_negative"];
			$ch2_cf_2             = $value["cf_total"];
			$ch2_cf_negative_2    = $value["cf_negative"];
		} else if($value["media_code"] == 3){
			$baku_total_2          = $value["total"];
			$baku_commu_2          = $value["commu_total"];
			$baku_commu_negative_2 = $value["commu_negative"];
			$baku_cf_2             = $value["cf_total"];
			$baku_cf_negative_2    = $value["cf_negative"];
		}
	}

	$twitter_commu_negative_pctg_2 = ROUND($twitter_commu_negative_2 / $twitter_total_2 * 100, 2);
	if(is_nan($twitter_commu_negative_pctg_2)){
		$twitter_commu_negative_pctg_2 = 0;
	}
	$twitter_cf_negative_pctg_2 = ROUND($twitter_cf_negative_2 / $twitter_total_2 * 100, 2);
	if(is_nan($twitter_cf_negative_pctg_2)){
		$twitter_cf_negative_pctg_2 = 0;
	}

	$ch2_commu_negative_pctg_2 = ROUND($ch2_commu_negative_2 / $ch2_total_2 * 100, 2);
	if(is_nan($ch2_commu_negative_pctg_2)){
		$ch2_commu_negative_pctg_2 = 0;
	}
	$ch2_cf_negative_pctg_2 = ROUND($ch2_cf_negative_2 / $ch2_total_2 * 100, 2);
	if(is_nan($ch2_cf_negative_pctg_2)){
		$ch2_cf_negative_pctg_2 = 0;
	}

	$baku_commu_negative_pctg_2 = ROUND($baku_commu_negative_2 / $baku_total_2 * 100, 2);
	if(is_nan($baku_commu_negative_pctg_2)){
		$baku_commu_negative_pctg_2 = 0;
	}
	$baku_cf_negative_pctg_2 = ROUND($baku_cf_negative_2 / $baku_total_2 * 100, 2);
	if(is_nan($baku_cf_negative_pctg_2)){
		$baku_cf_negative_pctg_2 = 0;
	}

	$all_negative_pctg_2 = ROUND(($twitter_commu_negative_2+$ch2_commu_negative_2 + $baku_commu_negative_2) / ($twitter_total_2+$ch2_total_2+$baku_total_2) * 100, 2);
	if(is_nan($all_negative_pctg_2)){
		$all_negative_pctg_2 = 0;
	}
	$all_cf_negative_pctg_2 = ROUND(($twitter_cf_negative_2+$ch2_cf_negative_2+$baku_cf_negative_2) / ($twitter_total_2+$ch2_total_2+$baku_total_2) * 100, 2);
	if(is_nan($all_cf_negative_pctg_2)){
		$all_cf_negative_pctg_2 = 0;
	}

	$result = $this -> insert_form_model -> get_ego_data($sdate_3);
	foreach($result as $key => $value){
		if($value["media_code"] == 1){
			$twitter_total_3          = $value["total"];
			$twitter_commu_3          = $value["commu_total"];
			$twitter_commu_negative_3 = $value["commu_negative"];
			$twitter_cf_3             = $value["cf_total"];
			$twitter_cf_negative_3    = $value["cf_negative"];
		} else if($value["media_code"] == 2){
			$ch2_total_3          = $value["total"];
			$ch2_commu_3          = $value["commu_total"];
			$ch2_commu_negative_3 = $value["commu_negative"];
			$ch2_cf_3             = $value["cf_total"];
			$ch2_cf_negative_3    = $value["cf_negative"];
		} else if($value["media_code"] == 3){
			$baku_total_3          = $value["total"];
			$baku_commu_3          = $value["commu_total"];
			$baku_commu_negative_3 = $value["commu_negative"];
			$baku_cf_3             = $value["cf_total"];
			$baku_cf_negative_3    = $value["cf_negative"];
		}
	}

	$twitter_commu_negative_pctg_3 = ROUND($twitter_commu_negative_3 / $twitter_total_3 * 100, 2);
	if(is_nan($twitter_commu_negative_pctg_3)){
		$twitter_commu_negative_pctg_3 = 0;
	}
	$twitter_cf_negative_pctg_3 = ROUND($twitter_cf_negative_3 / $twitter_total_3 * 100, 2);
	if(is_nan($twitter_cf_negative_pctg_3)){
		$twitter_cf_negative_pctg_3 = 0;
	}

	$ch2_commu_negative_pctg_3 = ROUND($ch2_commu_negative_3 / $ch2_total_3 * 100, 2);
	if(is_nan($ch2_commu_negative_pctg_3)){
		$ch2_commu_negative_pctg_3 = 0;
	}
	$ch2_cf_negative_pctg_3 = ROUND($ch2_cf_negative_3 / $ch2_total_3 * 100, 2);
	if(is_nan($ch2_cf_negative_pctg_3)){
		$ch2_cf_negative_pctg_3 = 0;
	}

	$baku_commu_negative_pctg_3 = ROUND($baku_commu_negative_3 / $baku_total_3 * 100, 2);
	if(is_nan($baku_commu_negative_pctg_3)){
		$baku_commu_negative_pctg_3 = 0;
	}
	$baku_cf_negative_pctg_3 = ROUND($baku_cf_negative_3 / $baku_total_3 * 100, 2);
	if(is_nan($baku_cf_negative_pctg_3)){
		$baku_cf_negative_pctg_3 = 0;
	}
	$all_negative_pctg_3 = ROUND(($twitter_commu_negative_3+$ch2_commu_negative_3 + $baku_commu_negative_3) / ($twitter_total_3+$ch2_total_3+$baku_total_3) * 100, 2);
	if(is_nan($all_negative_pctg_3)){
		$all_negative_pctg_3 = 0;
	}
	$all_cf_negative_pctg_3 = ROUND(($twitter_cf_negative_3+$ch2_cf_negative_3+$baku_cf_negative_3) / ($twitter_total_3+$ch2_total_3+$baku_total_3) * 100, 2);
	if(is_nan($all_cf_negative_pctg_3)){
		$all_cf_negative_pctg_3 = 0;
	}

	$result = $this -> insert_form_model -> get_ego_data($sdate_4);
	foreach($result as $key => $value){
		if($value["media_code"] == 1){
			$twitter_total_4          = $value["total"];
			$twitter_commu_4          = $value["commu_total"];
			$twitter_commu_negative_4 = $value["commu_negative"];
			$twitter_cf_4             = $value["cf_total"];
			$twitter_cf_negative_4    = $value["cf_negative"];
		} else if($value["media_code"] == 2){
			$ch2_total_4          = $value["total"];
			$ch2_commu_4          = $value["commu_total"];
			$ch2_commu_negative_4 = $value["commu_negative"];
			$ch2_cf_4             = $value["cf_total"];
			$ch2_cf_negative_4    = $value["cf_negative"];
		} else if($value["media_code"] == 3){
			$baku_total_4          = $value["total"];
			$baku_commu_4          = $value["commu_total"];
			$baku_commu_negative_4 = $value["commu_negative"];
			$baku_cf_4             = $value["cf_total"];
			$baku_cf_negative_4    = $value["cf_negative"];
		}
	}
	$twitter_commu_negative_pctg_4 = ROUND($twitter_commu_negative_4 / $twitter_total_4 * 100, 2);
	if(is_nan($twitter_commu_negative_pctg_4)){
		$twitter_commu_negative_pctg_4 = 0;
	}
	$twitter_cf_negative_pctg_4 = ROUND($twitter_cf_negative_4 / $twitter_total_4 * 100, 2);
	if(is_nan($twitter_cf_negative_pctg_4)){
		$twitter_cf_negative_pctg_4 = 0;
	}

	$ch2_commu_negative_pctg_4 = ROUND($ch2_commu_negative_4 / $ch2_total_4 * 100, 2);
	if(is_nan($ch2_commu_negative_pctg_4)){
		$ch2_commu_negative_pctg_4 = 0;
	}
	$ch2_cf_negative_pctg_4 = ROUND($ch2_cf_negative_4 / $ch2_total_4 * 100, 2);
	if(is_nan($ch2_cf_negative_pctg_4)){
		$ch2_cf_negative_pctg_4 = 0;
	}

	$baku_commu_negative_pctg_4 = ROUND($baku_commu_negative_4 / $baku_total_4 * 100, 2);
	if(is_nan($baku_commu_negative_pctg_4)){
		$baku_commu_negative_pctg_4 = 0;
	}

	$baku_cf_negative_pctg_4 = ROUND($baku_cf_negative_4 / $baku_total_4 * 100, 2);
	if(is_nan($baku_cf_negative_pctg_4)){
		$baku_cf_negative_pctg_4 = 0;
	}
	
	$all_negative_pctg_4 = ROUND(($twitter_commu_negative_4+$ch2_commu_negative_4 + $baku_commu_negative_4) / ($twitter_total_4+$ch2_total_4+$baku_total_4) * 100, 2);
	if(is_nan($all_negative_pctg_4)){
		$all_negative_pctg_4 = 0;
	}
	$all_cf_negative_pctg_4 = ROUND(($twitter_cf_negative_4+$ch2_cf_negative_4+$baku_cf_negative_4) / ($twitter_total_4+$ch2_total_4+$baku_total_4) * 100, 2);
	if(is_nan($all_cf_negative_pctg_4)){
		$all_cf_negative_pctg_4 = 0;
	}


	?>
	<table>
		<tbody>
		<tr>
			<th rowspan = "2"></th>
			<th colspan = "2" style = "text-align: center"><?=$last_monday_tbl4?>週</th>
			<th colspan = "2" style = "text-align: center"><?=$last_monday_tbl3?>週</th>
			<th colspan = "2" style = "text-align: center"><?=$last_monday_tbl2?>週</th>
			<th colspan = "2" style = "text-align: center"><?=$last_monday_tbl1?>週</th>
		</tr>
		<tr>
			<th style = "text-align: center">通信品質関連</th>
			<th style = "text-align: center">CF･課金関連</th>
			<th style = "text-align: center">通信品質関連</th>
			<th style = "text-align: center">CF･課金関連</th>
			<th style = "text-align: center">通信品質関連</th>
			<th style = "text-align: center">CF･課金関連</th>
			<th style = "text-align: center">通信品質関連</th>
			<th style = "text-align: center">CF･課金関連</th>
		</tr>
		<tr>
			<th>Twitter</th>
			<td style = "text-align: right"><?=$twitter_commu_negative_pctg_4?> %</td>
			<td style = "text-align: right"><?=$twitter_cf_negative_pctg_4?> %</td>
			<td style = "text-align: right"><?=$twitter_commu_negative_pctg_3?> %</td>
			<td style = "text-align: right"><?=$twitter_cf_negative_pctg_3?> %</td>
			<td style = "text-align: right"><?=$twitter_commu_negative_pctg_2?> %</td>
			<td style = "text-align: right"><?=$twitter_cf_negative_pctg_2?> %</td>
			<td style = "text-align: right"><?=$commu_ngtv_pctg?> %</td>
			<td style = "text-align: right"><?=$cf_ngtv_pctg?> %</td>
		</tr>
		<tr>
			<th>2ch</th>
			<td style = "text-align: right"><?=$ch2_commu_negative_pctg_4?> %</td>
			<td style = "text-align: right"><?=$ch2_cf_negative_pctg_4?> %</td>
			<td style = "text-align: right"><?=$ch2_commu_negative_pctg_3?> %</td>
			<td style = "text-align: right"><?=$ch2_cf_negative_pctg_3?> %</td>
			<td style = "text-align: right"><?=$ch2_commu_negative_pctg_2?> %</td>
			<td style = "text-align: right"><?=$ch2_cf_negative_pctg_2?> %</td>
			<td style = "text-align: right"><?=$ch2_commu_negative_pctg?> %</td>
			<td style = "text-align: right"><?=$ch2_cf_negative_pctg?> %</td>
		</tr>
		<tr>
			<th>爆サイ</th>
			<td style = "text-align: right"><?=$baku_commu_negative_pctg_4?> %</td>
			<td style = "text-align: right"><?=$baku_cf_negative_pctg_4?> %</td>
			<td style = "text-align: right"><?=$baku_commu_negative_pctg_3?> %</td>
			<td style = "text-align: right"><?=$baku_cf_negative_pctg_3?> %</td>
			<td style = "text-align: right"><?=$baku_commu_negative_pctg_2?> %</td>
			<td style = "text-align: right"><?=$baku_cf_negative_pctg_2?> %</td>
			<td style = "text-align: right"><?=$baku_commu_negative_pctg?> %</td>
			<td style = "text-align: right"><?=$baku_cf_negative_pctg?> %</td>
		</tr>
		<tr>
			<th>合計</th>
			<td style = "text-align: right"><?=$all_negative_pctg_4?> %</td>
			<td style = "text-align: right"><?=$all_cf_negative_pctg_4?> %</td>
			<td style = "text-align: right"><?=$all_negative_pctg_3?> %</td>
			<td style = "text-align: right"><?=$all_cf_negative_pctg_3?> %</td>
			<td style = "text-align: right"><?=$all_negative_pctg_2?> %</td>
			<td style = "text-align: right"><?=$all_cf_negative_pctg_2?> %</td>
			<td style = "text-align: right"><?=$all_commu_negative_pctg?> %</td>
			<td style = "text-align: right"><?=$all_cf_negative_pctg?> %</td>
		</tr>
		</tbody>
	</table>
</section>
<?php $this -> load -> view('layout/page_footer'); ?>
