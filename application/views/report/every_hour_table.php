<?php
$this->load->helper('utility');
$last_month = get_last_month_n();
$this_month = get_this_month_n();

$bandWidth_lte = 120000000;
$bandWidth_3g = 9000000;

// 必要な変数を生成
$month_ary = array("this", "last");
$pipe_ary = array("Xi", "FOMA");
$hour_ary = array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23");
foreach ($month_ary as $month) {
    foreach ($pipe_ary as $pipe) {
        foreach ($hour_ary as $hour) {
            // 各時間の日付順の最大・平均トラフィックデータ配列を分解
            ${$month . "_m_" . $pipe . "_" . $hour . "_ary"} = explode(",", ${$month . "_m_" . $pipe . "_" . $hour});
            ${$month . "_a_" . $pipe . "_" . $hour . "_ary"} = explode(",", ${$month . "_a_" . $pipe . "_" . $hour});

            // 指定された日付順の最大・平均トラフィックデータを取得するための配列を生成
            ${$month . "_m_" . $pipe . "_" . $hour . "_1_ary"} = array(
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[0],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[1],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[2],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[3],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[4],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[5],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[6]
            );
            ${$month . "_m_" . $pipe . "_" . $hour . "_8_ary"} = array(
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[7],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[8],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[9],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[10],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[11],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[12],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[13]
            );
            ${$month . "_m_" . $pipe . "_" . $hour . "_15_ary"} = array(
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[14],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[15],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[16],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[17],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[18],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[19],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[20]
            );
            ${$month . "_m_" . $pipe . "_" . $hour . "_22_ary"} = array(
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[21],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[22],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[23],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[24],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[25],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[26],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[27]
            );
            ${$month . "_m_" . $pipe . "_" . $hour . "_29_ary"} = array(
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[28],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[29],
                ${$month . "_m_" . $pipe . "_" . $hour . "_ary"}[30]
            );
            ${$month . "_a_" . $pipe . "_" . $hour . "_1_ary"} = array(
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[0],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[1],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[2],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[3],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[4],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[5],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[6]
            );
            ${$month . "_a_" . $pipe . "_" . $hour . "_8_ary"} = array(
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[7],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[8],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[9],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[10],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[11],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[12],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[13]
            );
            ${$month . "_a_" . $pipe . "_" . $hour . "_15_ary"} = array(
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[14],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[15],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[16],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[17],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[18],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[19],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[20]
            );
            ${$month . "_a_" . $pipe . "_" . $hour . "_22_ary"} = array(
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[21],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[22],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[23],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[24],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[25],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[26],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[27]
            );
            ${$month . "_a_" . $pipe . "_" . $hour . "_29_ary"} = array(
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[28],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[29],
                ${$month . "_a_" . $pipe . "_" . $hour . "_ary"}[30]
            );
        }
    }
}

// 共通テーブルヘッダ

$table_header = "
<table>
    <tr>
        <th>時間</th>
<th colspan=\"2\">$last_month/1~$last_month/7</th>
<th colspan=\"2\">$this_month/1~$this_month/7</th>
<th colspan=\"2\">$last_month/8~$last_month/14</th>
<th colspan=\"2\">$this_month/8~$this_month/14</th>
<th colspan=\"2\">$last_month/15~$last_month/21</th>
<th colspan=\"2\">$this_month/15~$this_month/21</th>
<th colspan=\"2\">$last_month/22~$last_month/28</th>
<th colspan=\"2\">$this_month/22~$this_month/28</th>
<th colspan=\"2\">$last_month/29~$last_month/31</th>
<th colspan=\"2\">$this_month/29~$this_month/31</th>
    </tr>
    ";

// LET 最大値表
foreach ($hour_ary as $hour) {
    $ary_day_1 = "_1_ary";
    $ary_day_8 = "_8_ary";
    $ary_day_15 = "_15_ary";
    $ary_day_22 = "_22_ary";
    $ary_day_29 = "_29_ary";

    $last_lte_m = "last_m_Xi_";
    $this_lte_m = "this_m_Xi_";
    $last_lte_td_m = $last_lte_m . $hour;
    $this_lte_td_m = $this_lte_m . $hour;

    $last_lte_a = "last_a_Xi_";
    $this_lte_a = "this_a_Xi_";
    $last_lte_td_a = $last_lte_a . $hour;
    $this_lte_td_a = $this_lte_a . $hour;

    $last_3g_m = "last_m_Xi_";
    $this_3g_m = "this_m_Xi_";
    $last_3g_td_m = $last_3g_m . $hour;
    $this_3g_td_m = $this_3g_m . $hour;

    $last_3g_a = "last_a_Xi_";
    $this_3g_a = "this_a_Xi_";
    $last_3g_td_a = $last_3g_a . $hour;
    $this_3g_td_a = $this_3g_a . $hour;


    @$lte_m .= "<tr>
<th>$hour</th>
<td>" . max(${$last_lte_td_m . $ary_day_1}) . "</td><td>" . ROUND(max(${$last_lte_td_m . $ary_day_1}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_m . $ary_day_1}) . "</td><td>" . ROUND(max(${$this_lte_td_m . $ary_day_1}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$last_lte_td_m . $ary_day_8}) . "</td><td>" . ROUND(max(${$last_lte_td_m . $ary_day_8}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_m . $ary_day_8}) . "</td><td>" . ROUND(max(${$this_lte_td_m . $ary_day_8}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$last_lte_td_m . $ary_day_15}) . "</td><td>" . ROUND(max(${$last_lte_td_m . $ary_day_15}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_m . $ary_day_15}) . "</td><td>" . ROUND(max(${$this_lte_td_m . $ary_day_15}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$last_lte_td_m . $ary_day_22}) . "</td><td>" . ROUND(max(${$last_lte_td_m . $ary_day_22}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_m . $ary_day_22}) . "</td><td>" . ROUND(max(${$this_lte_td_m . $ary_day_22}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$last_lte_td_m . $ary_day_29}) . "</td><td>" . ROUND(max(${$last_lte_td_m . $ary_day_29}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_m . $ary_day_29}) . "</td><td>" . ROUND(max(${$this_lte_td_m . $ary_day_29}) / $bandWidth_lte * 100, 0) . "%</td>
</tr>
";

// LET 平均値表

    @$lte_a .= "<tr>
<th>$hour</th>
<td>" . max(${$last_lte_td_a . $ary_day_1}) . "</td><td>" . ROUND(max(${$last_lte_td_a . $ary_day_1}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_a . $ary_day_1}) . "</td><td>" . ROUND(max(${$this_lte_td_a . $ary_day_1}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$last_lte_td_a . $ary_day_8}) . "</td><td>" . ROUND(max(${$last_lte_td_a . $ary_day_8}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_a . $ary_day_8}) . "</td><td>" . ROUND(max(${$this_lte_td_a . $ary_day_8}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$last_lte_td_a . $ary_day_15}) . "</td><td>" . ROUND(max(${$last_lte_td_a . $ary_day_15}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_a . $ary_day_15}) . "</td><td>" . ROUND(max(${$this_lte_td_a . $ary_day_15}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$last_lte_td_a . $ary_day_22}) . "</td><td>" . ROUND(max(${$last_lte_td_a . $ary_day_22}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_a . $ary_day_22}) . "</td><td>" . ROUND(max(${$this_lte_td_a . $ary_day_22}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$last_lte_td_a . $ary_day_29}) . "</td><td>" . ROUND(max(${$last_lte_td_a . $ary_day_29}) / $bandWidth_lte * 100, 0) . "%</td>
<td>" . max(${$this_lte_td_a . $ary_day_29}) . "</td><td>" . ROUND(max(${$this_lte_td_a . $ary_day_29}) / $bandWidth_lte * 100, 0) . "%</td>
</tr>
";

// 3G 最大値表

    @$g3_m .= "<tr>
<th>$hour</th>
<td>" . max(${$last_3g_td_m . $ary_day_1}) . "</td><td>" . ROUND(max(${$last_3g_td_m . $ary_day_1}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_m . $ary_day_1}) . "</td><td>" . ROUND(max(${$this_3g_td_m . $ary_day_1}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$last_3g_td_m . $ary_day_8}) . "</td><td>" . ROUND(max(${$last_3g_td_m . $ary_day_8}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_m . $ary_day_8}) . "</td><td>" . ROUND(max(${$this_3g_td_m . $ary_day_8}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$last_3g_td_m . $ary_day_15}) . "</td><td>" . ROUND(max(${$last_3g_td_m . $ary_day_15}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_m . $ary_day_15}) . "</td><td>" . ROUND(max(${$this_3g_td_m . $ary_day_15}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$last_3g_td_m . $ary_day_22}) . "</td><td>" . ROUND(max(${$last_3g_td_m . $ary_day_22}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_m . $ary_day_22}) . "</td><td>" . ROUND(max(${$this_3g_td_m . $ary_day_22}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$last_3g_td_m . $ary_day_29}) . "</td><td>" . ROUND(max(${$last_3g_td_m . $ary_day_29}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_m . $ary_day_29}) . "</td><td>" . ROUND(max(${$this_3g_td_m . $ary_day_29}) / $bandWidth_3g * 100, 0) . "%</td>
</tr>
";
// 3G 最大値表

    @$g3_a .= "<tr>
<th>$hour</th>
<td>" . max(${$last_3g_td_a . $ary_day_1}) . "</td><td>" . ROUND(max(${$last_3g_td_a . $ary_day_1}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_a . $ary_day_1}) . "</td><td>" . ROUND(max(${$this_3g_td_a . $ary_day_1}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$last_3g_td_a . $ary_day_8}) . "</td><td>" . ROUND(max(${$last_3g_td_a . $ary_day_8}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_a . $ary_day_8}) . "</td><td>" . ROUND(max(${$this_3g_td_a . $ary_day_8}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$last_3g_td_a . $ary_day_15}) . "</td><td>" . ROUND(max(${$last_3g_td_a . $ary_day_15}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_a . $ary_day_15}) . "</td><td>" . ROUND(max(${$this_3g_td_a . $ary_day_15}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$last_3g_td_a . $ary_day_22}) . "</td><td>" . ROUND(max(${$last_3g_td_a . $ary_day_22}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_a . $ary_day_22}) . "</td><td>" . ROUND(max(${$this_3g_td_a . $ary_day_22}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$last_3g_td_a . $ary_day_29}) . "</td><td>" . ROUND(max(${$last_3g_td_a . $ary_day_29}) / $bandWidth_3g * 100, 0) . "%</td>
<td>" . max(${$this_3g_td_a . $ary_day_29}) . "</td><td>" . ROUND(max(${$this_3g_td_a . $ary_day_29}) / $bandWidth_3g * 100, 0) . "%</td>
</tr>
";
}

$table_footer = "</table>";

?>
