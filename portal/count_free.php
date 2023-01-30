<?php $this -> load -> view('layout/page_break'); ?>
<section class = "subject">
	前提
</section>
<section class = "paragraph">
	1-1 本書で使用する用語の定義
</section>
<section class = "paragraph">
	<table>
		<tr>
			<th>帯域利用状況（bps）</th>
			<td>単位時間当たりのデータ転送量のこと
				（通信速度によりキロ,メガ,ギガ等の単位の変更あり）
			</td>
		</tr>
		<tr>
			<th>通信量(Byte)</th>
			<td>実際に通信した量のこと（通信量によりキロ,メガ,ギガ等の単位の変更あり）
			</td>
		</tr>
		<tr>
			<th>Incoming</th>
			<td>download（下り）通信のこと</td>
		</tr>
		<tr>
			<th>Outgoing</th>
			<td>upload（上り）通信のこと</td>
		</tr>
		<tr>
			<th>Total</th>
			<td>download と upload を含めたもの</td>
		</tr>
		<tr>
			<td></td>
			<td>PREのシグネチャ単位で識別されるもの</td>
		</tr>
	</table>
</section>
<section class = "paragraph">
	1-2 カウントフリー対象リスト
</section>

<!--
VS ファイルのバージョン名表示
-->

<?php
$version_data_table = "<table><tr>";
$result             = $this -> insert_form_model -> get_cf_version_data();
foreach($result as $key => $value){
	$array_list = get_object_vars($value);
	foreach($array_list as $key_version => $value_version){
		$version_data_table .= "<th>" . $value_version . "</th>";
	}
}
$version_data_table .= "</tr></table>";
?>
<section>
	<?=$version_data_table?>
</section>
<?php

/*
 * --
土管名配列作成
--
*/

$pipe_name_ary = array();
$result        = $this -> insert_form_model -> get_report_cf_list_pipe();
foreach($result as $key => $value){
	$array_list = get_object_vars($value);
	foreach($array_list as $key_pipe => $value_pipe){
		array_push($pipe_name_ary, $value_pipe);
	}
}

/*
--
ゲーム土管一覧
--
*/

$vs_data_table = "<section><table><tr><th style=\"width: 40%\">$pipe_name_ary[0]</th><th style=\"width: 60%\">対象</th></tr>";
$result        = $this -> insert_form_model -> get_report_cf_list_data_by_pipe($pipe_name_ary[0], 0, 40);
foreach($result as $key => $value){
	$array_list    = get_object_vars($value);
	$vs_data_table .= "<tr>";
	if($array_list["new_flg"] == 1){
		$vs_data_table .= "<td style='text-align: right; padding-right: 10px; color: #bc0600;'>新規</td><td style='color: #bc0600; font-weight: bold'>" . $array_list["vs_name"] . "</td>";
	} else {
		$vs_data_table .= "<td></td><td>" . $array_list["vs_name"] . "</td>";
	}
	$vs_data_table .= "</tr>";
}
$vs_data_table .= "</table></section>";
echo $vs_data_table;
$this -> load -> view('layout/page_footer');


$this -> load -> view('layout/page_break');
$vs_data_table = "";
$vs_data_table = "<section><table><tr><th style=\"width: 40%\">$pipe_name_ary[0]</th><th>対象</th></tr>";
$result        = $this -> insert_form_model -> get_report_cf_list_data_by_pipe($pipe_name_ary[0], 40, 40);
foreach($result as $key => $value){
	$array_list    = get_object_vars($value);
	$vs_data_table .= "<tr>";
	if($array_list["new_flg"] == 1){
		$vs_data_table .= "<td style='text-align: right; padding-right: 10px; color: #bc0600;'>新規</td><td style='color: #bc0600; font-weight: bold'>" . $array_list["vs_name"] . "</td>";
	} else {
		$vs_data_table .= "<td></td><td>" . $array_list["vs_name"] . "</td>";
	}
	$vs_data_table .= "</tr>";
}
$vs_data_table .= "</table></section>";
echo $vs_data_table;

/*
--
カウントフリー対象：その他
--
*/

$vs_data_table = "";
$vs_data_table = "<section><table><tr><th style=\"width: 40%\">$pipe_name_ary[1]</th><th>対象</th></tr>";
$result        = $this -> insert_form_model -> get_report_cf_list_data_by_pipe($pipe_name_ary[1], 0, 26);
foreach($result as $key => $value){
	$array_list    = get_object_vars($value);
	$vs_data_table .= "<tr>";
	if($array_list["new_flg"] == 1){
		$vs_data_table .= "<td style='text-align: right; padding-right: 10px; color: #bc0600;'>新規</td><td style='color: #bc0600; font-weight: bold'>" . $array_list["vs_name"] . "</td>";
	} else {
		$vs_data_table .= "<td></td><td>" . $array_list["vs_name"] . "</td>";
	}
	$vs_data_table .= "</tr>";
}
$vs_data_table .= "</table></section>";
echo $vs_data_table;
$this -> load -> view('layout/page_footer');

$this -> load -> view('layout/page_break');
$vs_data_table = "";
$vs_data_table = "<section><table><tr><th style=\"width: 40%\">$pipe_name_ary[1]</th><th>対象</th></tr>";
$result        = $this -> insert_form_model -> get_report_cf_list_data_by_pipe($pipe_name_ary[1], 26, 100);
foreach($result as $key => $value){
	$array_list    = get_object_vars($value);
	$vs_data_table .= "<tr>";
	if($array_list["new_flg"] == 1){
		$vs_data_table .= "<td style='text-align: right; padding-right: 10px; color: #bc0600;'>新規</td><td style='color: #bc0600; font-weight: bold'>" . $array_list["vs_name"] . "</td>";
	} else {
		$vs_data_table .= "<td></td><td>" . $array_list["vs_name"] . "</td>";
	}
	$vs_data_table .= "</tr>";
}
$vs_data_table .= "</table></section>";
echo $vs_data_table;
$this -> load -> view('layout/page_footer');

/*
--
カウントフリー対象外土管一覧
--
$vs_data_table = "";
$vs_data_table = "<section><table><tr><th>土管名：$pipe_name_ary[2]</th><th>対象</th></tr>";
$result        = $this -> insert_form_model -> get_report_cf_list_data_by_pipe($pipe_name_ary[2], 0, 40);
foreach($result as $key => $value){
	$array_list    = get_object_vars($value);
	$vs_data_table .= "<tr>";
	foreach($array_list as $key_count => $value_count){
		$vs_data_table .= "<td></td><td>" . $value_count . "</td>";
	}
	$vs_data_table .= "</tr>";
}
$vs_data_table .= "</table></section>";
echo $vs_data_table;
*/

/*
--
低速土管一覧
--
*/


$this -> load -> view('layout/page_break');
$vs_data_table = "";
$vs_data_table = "<section><table><tr><th style=\"width: 40%\">$pipe_name_ary[3]</th><th>対象</th></tr>";
$result        = $this -> insert_form_model -> get_report_cf_list_data_by_pipe($pipe_name_ary[3], 0, 53);
foreach($result as $key => $value){
	$array_list    = get_object_vars($value);
	$vs_data_table .= "<tr>";
	if($array_list["new_flg"] == 1){
		$vs_data_table .= "<td style='text-align: right; padding-right: 10px; color: #bc0600;'>新規</td><td style='color: #bc0600; font-weight: bold'>" . $array_list["vs_name"] . "</td>";
	} else {
		$vs_data_table .= "<td></td><td>" . $array_list["vs_name"] . "</td>";
	}
	$vs_data_table .= "</tr>";
}
$vs_data_table .= "</table></section>";
echo $vs_data_table;
$this -> load -> view('layout/page_footer');

$this -> load -> view('layout/page_break');

$vs_data_table = "";
$vs_data_table = "<section><table><tr><th style=\"width: 40%\">$pipe_name_ary[3]</th><th>対象</th></tr>";
$result        = $this -> insert_form_model -> get_report_cf_list_data_by_pipe($pipe_name_ary[3], 53, 100);
foreach($result as $key => $value){
	$array_list    = get_object_vars($value);
	$vs_data_table .= "<tr>";
	if($array_list["new_flg"] == 1){
		$vs_data_table .= "<td style='text-align: right; padding-right: 10px; color: #bc0600;'>新規</td><td style='color: #bc0600; font-weight: bold'>" . $array_list["vs_name"] . "</td>";
	} else {
		$vs_data_table .= "<td></td><td>" . $array_list["vs_name"] . "</td>";
	}
	$vs_data_table .= "</tr>";
}
$vs_data_table .= "</table></section>";
echo $vs_data_table;

/*
--
GTP土管一覧
--

$vs_data_table = "";
$vs_data_table = "<section><table><tr><th>土管名：$pipe_name_ary[4]</th><th>対象</th></tr>";
$result        = $this -> insert_form_model -> get_report_cf_list_data_by_pipe($pipe_name_ary[4], 0, 40);
foreach($result as $key => $value){
	$array_list    = get_object_vars($value);
	$vs_data_table .= "<tr>";
	foreach($array_list as $key_count => $value_count){
		$vs_data_table .= "<td></td><td>" . $value_count . "</td>";
	}
	$vs_data_table .= "</tr>";
}
$vs_data_table .= "</table></section>";
echo $vs_data_table;
*/

$this -> load -> view('layout/page_footer');
?>
