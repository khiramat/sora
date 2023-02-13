<?php
$this->load->helper('url');
$this->load->helper('utility');

//ヘッダ
$this->load->view('common/report_head');

//分位数を求める関数
function Quartile($Array, $Quartile)
{
    sort($Array);
    $pos = (count($Array) - 1) * $Quartile;

    $base = floor($pos);
    $rest = $pos - $base;

    if (isset($Array[$base + 1])) {
        return $Array[$base] + $rest * ($Array[$base + 1] - $Array[$base]);
    } else {
        return $Array[$base];
    }
}

//トラフィック量数位グラフ用データ
$sd = date('Y年n月t日', strtotime($bandwidth_use_rete_point[0]));
$ed = date('Y年n月t日', strtotime("$bandwidth_use_rete_point[1] +1 month"));
$subtitle = $sd . "　〜　" . $ed;

//年跨ぎバグ対応
//$start_year = ($last_before_month == 11) ? $this_year - 1 : $this_year;
//$start_year_line_graph = date("Y", strtotime("$this_year -1 year"));
//$last_before_month_line_graph = 12;

// 帯域情報データ作成
$active_date = "[";
$active_usage = '{"name":"帯域状況/ActiveUser","color":"#ffb601","data":[';
foreach ($active_user_count_datas as $active_user_count_data) {
    $active_date .= "'" . $active_user_count_data['date'] . "',";
    $active_usage .= $active_user_count_data['count'] . ",";
}
$active_date = substr($active_date, 0, -1) . "]";
$active_usage = substr($active_usage, 0, -1) . "]}";

$today = date();
$last_month_1 = date("Y-m-01", strtotime("$today -1 month"));
$this_month_1 = date("Y-m-01");
$start_day = $last_month_1;
$last_month_days = array();
while ($start_day < $this_month_1) {
    array_push($last_month_days, $start_day);
    $start_day = date("Y-m-d", strtotime("$start_day +1 day"));
}
$plot_down_data = array();
foreach ($host_data as $key => $host) {
    foreach ($last_month_days as $key => $last_month_day) {
        $center_value = round(Quartile($box_plot_down_data[$host][$last_month_day], 0.5) / 1000000 * 8, 2);
        $quoter_value = round(Quartile($box_plot_down_data[$host][$last_month_day], 0.25) / 1000000 * 8, 2);
        $seventh_value = round(Quartile($box_plot_down_data[$host][$last_month_day], 0.75) / 1000000 * 8, 2);
        $max_value = round(max($box_plot_down_data[$host][$last_month_day]) / 1000000 * 8, 2);
        $min_value = round(min($box_plot_down_data[$host][$last_month_day]) / 1000000 * 8, 2);
        $plot_down_data[$host][$last_month_day] = array($min_value, $quoter_value, $center_value, $seventh_value, $max_value);
    }
}
$plot_up_data = array();
foreach ($host_data as $key => $host) {
    foreach ($last_month_days as $key => $last_month_day) {
        $center_value = round(Quartile($box_plot_up_data[$host][$last_month_day], 0.5) / 1000000 * 8, 2);
        $quoter_value = round(Quartile($box_plot_up_data[$host][$last_month_day], 0.25) / 1000000 * 8, 2);
        $seventh_value = round(Quartile($box_plot_up_data[$host][$last_month_day], 0.75) / 1000000 * 8, 2);
        $max_value = round(max($box_plot_up_data[$host][$last_month_day]) / 1000000 * 8, 2);
        $min_value = round(min($box_plot_up_data[$host][$last_month_day]) / 1000000 * 8, 2);
        $plot_up_data[$host][$last_month_day] = array($min_value, $quoter_value, $center_value, $seventh_value, $max_value);
    }
}

$box_pg_up_data = array();
foreach ($pgw_data as $key => $pgw) {
    $center_value = round(Quartile($speed_test_pg_up_month[$pgw], 0.5) / 1000000 * 8, 2);
    $quoter_value = round(Quartile($speed_test_pg_up_month[$pgw], 0.25) / 1000000 * 8, 2);
    $seventh_value = round(Quartile($speed_test_pg_up_month[$pgw], 0.75) / 1000000 * 8, 2);
    $max_value = round(max($speed_test_pg_up_month[$pgw]) / 1000000 * 8, 2);
    $min_value = round(min($speed_test_pg_up_month[$pgw]) / 1000000 * 8, 2);
    $box_pg_up_data[$pgw] = array($min_value, $quoter_value, $center_value, $seventh_value, $max_value);
}

$box_data_p_u = null;
$pgw_category = null;
foreach ($pgw_data as $key => $pgw) {
    $box_data_p_u .= '[';
    foreach ($box_pg_up_data[$pgw] as $key => $val) {
        if (!$val) {
            $val = 0;
        }
        $box_data_p_u .= $val . ',';
    }
    $box_data_p_u = substr($box_data_p_u, 0, -1) . '],';
    $pgw_category .= "'" . $pgw . "',";
}
$box_data_p_u = substr($box_data_p_u, 0, -1);
$pgw_category = substr($pgw_category, 0, -1);

$box_pg_dw_data = array();
foreach ($pgw_data as $key => $pgw) {
    $center_value = round(Quartile($speed_test_pg_down_month[$pgw], 0.5) / 1000000 * 8, 2);
    $quoter_value = round(Quartile($speed_test_pg_down_month[$pgw], 0.25) / 1000000 * 8, 2);
    $seventh_value = round(Quartile($speed_test_pg_down_month[$pgw], 0.75) / 1000000 * 8, 2);
    $max_value = round(max($speed_test_pg_down_month[$pgw]) / 1000000 * 8, 2);
    $min_value = round(min($speed_test_pg_down_month[$pgw]) / 1000000 * 8, 2);
    $box_pg_dw_data[$pgw] = array($min_value, $quoter_value, $center_value, $seventh_value, $max_value);
}

$box_data_p_d = null;
foreach ($pgw_data as $key => $pgw) {
    $box_data_p_d .= '[';
    foreach ($box_pg_dw_data[$pgw] as $key => $val) {
        if (!$val) {
            $val = 0;
        }
        $box_data_p_d .= $val . ',';
    }
    $box_data_p_d = substr($box_data_p_d, 0, -1) . '],';
}
$box_data_p_d = substr($box_data_p_d, 0, -1);

$box_pl_up_data = array();
foreach ($place_data as $key => $place) {
    $center_value = round(Quartile($speed_test_place_up_month[$place], 0.5) / 1000000 * 8, 2);
    $quoter_value = round(Quartile($speed_test_place_up_month[$place], 0.25) / 1000000 * 8, 2);
    $seventh_value = round(Quartile($speed_test_place_up_month[$place], 0.75) / 1000000 * 8, 2);
    $max_value = round(max($speed_test_place_up_month[$place]) / 1000000 * 8, 2);
    $min_value = round(min($speed_test_place_up_month[$place]) / 1000000 * 8, 2);
    $box_pl_up_data[$place] = array($min_value, $quoter_value, $center_value, $seventh_value, $max_value);
}

$box_data_pl_u = null;
foreach ($place_data as $key => $place) {
    $box_data_pl_u .= '[';
    foreach ($box_pl_up_data[$place] as $key => $val) {
        if (!$val) {
            $val = 0;
        }
        $box_data_pl_u .= $val . ',';
    }
    $box_data_pl_u = substr($box_data_pl_u, 0, -1) . '],';
    $place_category .= "'" . $place . "',";
}
$box_data_pl_u = substr($box_data_pl_u, 0, -1);
$place_category = substr($place_category, 0, -1);

$box_pl_dw_data = array();
foreach ($place_data as $key => $place) {
    $center_value = round(Quartile($speed_test_place_down_month[$place], 0.5) / 1000000 * 8, 2);
    $quoter_value = round(Quartile($speed_test_place_down_month[$place], 0.25) / 1000000 * 8, 2);
    $seventh_value = round(Quartile($speed_test_place_down_month[$place], 0.75) / 1000000 * 8, 2);
    $max_value = round(max($speed_test_place_down_month[$place]) / 1000000 * 8, 2);
    $min_value = round(min($speed_test_place_down_month[$place]) / 1000000 * 8, 2);
    $box_pl_dw_data[$place] = array($min_value, $quoter_value, $center_value, $seventh_value, $max_value);
}

$box_data_pl_d = null;
foreach ($place_data as $key => $place) {
    $box_data_pl_d .= '[';
    foreach ($box_pl_dw_data[$place] as $key => $val) {
        if (!$val) {
            $val = 0;
        }
        $box_data_pl_d .= $val . ',';
    }
    $box_data_pl_d = substr($box_data_pl_d, 0, -1) . '],';
}
$box_data_pl_d = substr($box_data_pl_d, 0, -1);


$box_sv_up_data = array();
foreach ($host_data as $key => $host) {
    $center_value = round(Quartile($speed_test_server_up_month[$host], 0.5) / 1000000 * 8, 2);
    $quoter_value = round(Quartile($speed_test_server_up_month[$host], 0.25) / 1000000 * 8, 2);
    $seventh_value = round(Quartile($speed_test_server_up_month[$host], 0.75) / 1000000 * 8, 2);
    $max_value = round(max($speed_test_server_up_month[$host]) / 1000000 * 8, 2);
    $min_value = round(min($speed_test_server_up_month[$host]) / 1000000 * 8, 2);
    $box_sv_up_data[$host] = array($min_value, $quoter_value, $center_value, $seventh_value, $max_value);
}

$box_data_sv_u = null;
foreach ($host_data as $key => $host) {
    $box_data_sv_u .= '[';
    foreach ($box_sv_up_data[$host] as $key => $val) {
        if (!$val) {
            $val = 0;
        }
        $box_data_sv_u .= $val . ',';
    }
    $box_data_sv_u = substr($box_data_sv_u, 0, -1) . '],';
    $host_category .= "'" . $host . "',";
}
$box_data_sv_u = substr($box_data_sv_u, 0, -1);
$host_category = substr($host_category, 0, -1);

$box_sv_dw_data = array();
foreach ($host_data as $key => $host) {
    $center_value = round(Quartile($speed_test_server_down_month[$host], 0.5) / 1000000 * 8, 2);
    $quoter_value = round(Quartile($speed_test_server_down_month[$host], 0.25) / 1000000 * 8, 2);
    $seventh_value = round(Quartile($speed_test_server_down_month[$host], 0.75) / 1000000 * 8, 2);
    $max_value = round(max($speed_test_server_down_month[$host]) / 1000000 * 8, 2);
    $min_value = round(min($speed_test_server_down_month[$host]) / 1000000 * 8, 2);
    $box_sv_dw_data[$host] = array($min_value, $quoter_value, $center_value, $seventh_value, $max_value);
}

$box_data_sv_d = null;
foreach ($host_data as $key => $host) {
    $box_data_sv_d .= '[';
    foreach ($box_sv_dw_data[$host] as $key => $val) {
        if (!$val) {
            $val = 0;
        }
        $box_data_sv_d .= $val . ',';
    }
    $box_data_sv_d = substr($box_data_sv_d, 0, -1) . '],';
}
$box_data_sv_d = substr($box_data_sv_d, 0, -1);
?>

<body>
<!-- Graph -->
<?php
$max_plot_line = $plotLineValue[0]->base_value + 15;
//$max_plot_line = 35;
?>
<script>
    $(function () {
        //12時の帯域使用率
        lineChartBandwidthUseRateColumn("line_bandwidth_1", "<?=$last_before_month?>月〜<?=$last_month?>月", "", "", "kbps", <?=$active_date?>, <?=$active_usage?>, <?=$plotLineValue[0]->base_value?>, <?=$max_plot_line?>);
        lineChartDaily("traffic_line_in_1", "トラフィック量推移", "", 'トラフィック（bps）', 400000000, 20000000, <?=$traffic_data12_m['in']?>);
        lineChartDaily("traffic_line_out_1", "トラフィック量推移", "", 'トラフィック（bps）', 400000000, 20000000, <?=$traffic_data12_m['out']?>);
        lineChartDaily("traffic_line_in_2", "トラフィック量推移", "", 'トラフィック（bps）', 400000000, 20000000, <?=$traffic_data12_r['in']?>);
        lineChartDaily("traffic_line_out_2", "トラフィック量推移", "", 'トラフィック（bps）', 400000000, 20000000, <?=$traffic_data12_r['out']?>);
        lineChartDaily("traffic_line_all_1", "トラフィック量推移", "", 'トラフィック（bps）', 400000000, 20000000, <?=$traffic_data12_m['all']?>);
        lineChartDaily("traffic_line_all_2", "トラフィック量推移", "", 'トラフィック（bps）', 400000000, 20000000, <?=$traffic_data12_r['all']?>);
        //サービスTOP10
        lineChartServiceTop("service_line_new", "主要サービス単体のトラフィック使用量", "", "トラフィック（bps）", "bps", 1, 1000000, <?=$service_daily_data_new?>);
        AreaChart("service_area_new", "主要サービス全体の合計使用量", "", "トラフィック（bps）", "bps", <?=$service_daily_data_new?>);
        //接続者数推移
        lineChartDaily("user_count_line_1", "接続者数推移", "", '接続者数（人）', 16000, 2000, <?=$user_count_data['mobile']?>);
        lineChartDaily("user_count_line_2", "接続者数推移", "", '接続者数（人）', 16000, 2000, <?=$user_count_data['route']?>);
        lineChartDaily("user_count_line_3", "接続者数推移", "", '接続者数（人）', 16000, 2000, <?=$user_count_data['all']?>);
    });

    $(function () {
        Highcharts.chart('BoxPlotChart_up_summary_pg', {
            credits: {
                enabled: false,
            },
            chart: {
                type: 'boxplot'
            },
            title: {
                text: 'PGWごと（上り）',
                style: {
                    fontSize: '11px' // タイトルの文字サイズ
                }
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: [<?=$pgw_category?>]
            },
            yAxis: {
                title: {
                    text: 'Mbps'
                },
            },
            series: [{
                name: '速度',
                data: [
                    <?=$box_data_p_u?>
                ],
            },]
        });
    });

    $(function () {
        Highcharts.chart('BoxPlotChart_dw_summary_pg', {
            credits: {
                enabled: false,
            },
            chart: {
                type: 'boxplot'
            },
            title: {
                text: 'PGWごと（下り）',
                style: {
                    fontSize: '11px' // タイトルの文字サイズ
                }
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: [<?=$pgw_category?>]
            },
            yAxis: {
                title: {
                    text: 'Mbps'
                },
            },
            series: [{
                name: '速度',
                data: [
                    <?=$box_data_p_d?>
                ],
            },]
        });
    });

    $(function () {
        Highcharts.chart('BoxPlotChart_up_summary_place', {
            credits: {
                enabled: false,
            },
            chart: {
                type: 'boxplot'
            },
            title: {
                text: '測定拠点ごと（上り）',
                style: {
                    fontSize: '11px' // タイトルの文字サイズ
                }
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: [<?=$place_category?>]
            },
            yAxis: {
                title: {
                    text: 'Mbps'
                },
            },
            series: [{
                name: '速度',
                data: [
                    <?=$box_data_pl_u?>
                ],
            },]
        });
    });

    $(function () {
        Highcharts.chart('BoxPlotChart_dw_summary_place', {
            credits: {
                enabled: false,
            },
            chart: {
                type: 'boxplot'
            },
            title: {
                text: '測定拠点ごと（下り）',
                style: {
                    fontSize: '11px' // タイトルの文字サイズ
                }
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: [<?=$place_category?>]
            },
            yAxis: {
                title: {
                    text: 'Mbps'
                },
            },
            series: [{
                name: '速度',
                data: [
                    <?=$box_data_pl_d?>
                ],
            },]
        });
    });

    $(function () {
        Highcharts.chart('BoxPlotChart_up_summary_server', {
            credits: {
                enabled: false,
            },
            chart: {
                type: 'boxplot'
            },
            title: {
                text: '測定サーバーごと（上り）',
                style: {
                    fontSize: '11px' // タイトルの文字サイズ
                }
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: [<?=$host_category?>]
            },
            yAxis: {
                title: {
                    text: 'Mbps'
                },
            },
            series: [{
                name: '速度',
                data: [
                    <?=$box_data_sv_u?>
                ],
            },]
        });
    });

    $(function () {
        Highcharts.chart('BoxPlotChart_dw_summary_server', {
            credits: {
                enabled: false,
            },
            chart: {
                type: 'boxplot'
            },
            title: {
                text: '測定サーバーごと（下り）',
                style: {
                    fontSize: '11px' // タイトルの文字サイズ
                }
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: [<?=$host_category?>]
            },
            yAxis: {
                title: {
                    text: 'Mbps'
                },
            },
            series: [{
                name: '速度',
                data: [
                    <?=$box_data_sv_d?>
                ],
            },]
        });
    });

</script>
<style>
    tr {
        border-bottom: #313131 solid 1px;
    }

    th {
        padding: 2px;

    }

    td {
        border-right: #313131 solid 1px;
        padding: 2px;
    }

    .box {
        display: inline-block;
        width: 200px;
    }
</style>
<article class="sheet">
    <header>
        <h1>SORAシム株式会社 御中</h1>
    </header>
    <section
            style="width: 94%; text-align: center; font-size: 50px; font-weight: bold; height: 80mm; vertical-align: middle">
        月次報告書
    </section>
    <section
            style="width: 94%; text-align: center; font-size: 24px; font-weight: bold; height: 20mm;"><?= date('Y年') ?> <?= get_next_month_n() ?>
        月版
    </section>
    <section style="width: 94%; text-align: center; height: 60mm;"><img
                src="<?= base_url() ?>assets/images/ranger_newlogo-big.png"></section>
</article>

<article class="sheet">
    <header>
        <h1>目次</h1>
        <div class="header"></div>
    </header>
    <br>
    <br>
    <section>
        <table align=center width=900 style="font-size: 20px;">
            <tr>
                <td>
                    <ol>
                        <li>帯域状況について</li>
                        <br>
                        <li>帯域運用について</li>
                        <ol>
                            <li>未来予測</li>
                            <li>トラフィック量の推移</li>
                            <li>接続者数の推移</li>
                            <li>主要サービスについて</li>
                        </ol>
                        <br>
                        <li>速度測定結果について</li>
                        <ol>
                            <li>Down SR-NG-STP0[1-4]</li>
                            <li>Down SR-RS-STP0[1-4]</li>
                            <li>Up SR-NG-STP0[1-4]</li>
                            <li>Up SR-RS-STP0[1-4]</li>
                            <li>PGWごと、測定拠点ごと、測定サーバーごと</li>
                        </ol>
                        <br>
                        <br>
                        <li>作業報告
                        </li>
                    </ol>
                </td>
            </tr>
        </table>
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>帯域状況について(未来予測)</h1>
    </header>
    <section>
        今月の結果をもとに、帯域の未来予測をご報告致します。<br>
        <div id="line_bandwidth_1"
             style="width: 89%; height: 500px; margin: 2px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>帯域運用について（インバウンドトラフィック量の推移）</h1>
        <div class="header"></div>
    </header>
    <section>
        <h2>@モバイルくん</h2>
        <br>
        <div id="traffic_line_in_1"
             style="width: 89%; height: 130mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section style="width: 89%; text-align: right; font-size: 9px;">
        ※DPI装置より取得（平均トラフィックを使用）
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>帯域運用について（インバウンドトラフィック量の推移）</h1>
        <div class="header"></div>
    </header>
    <section>
        <h2>Route7</h2>
        <br>
        <div id="traffic_line_in_2"
             style="width: 89%; height: 130mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section style="width: 89%; text-align: right; font-size: 9px;">
        ※DPI装置より取得（平均トラフィックを使用）
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>帯域運用について（アウトバウンドトラフィック量の推移）</h1>
        <div class="header"></div>
    </header>
    <section>
        <h2>@モバイルくん</h2>
        <br>
        <div id="traffic_line_out_1"
             style="width: 89%; height: 130mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section style="width: 89%; text-align: right; font-size: 9px;">
        ※DPI装置より取得（平均トラフィックを使用）
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>帯域運用について（アウトバウンドトラフィック量の推移）</h1>
        <div class="header"></div>
    </header>
    <section>
        <h2>Route7</h2>
        <br>
        <div id="traffic_line_out_2"
             style="width: 89%; height: 130mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section style="width: 89%; text-align: right; font-size: 9px;">
        ※DPI装置より取得（平均トラフィックを使用）
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>帯域運用について（全体トラフィック量の推移）</h1>
        <div class="header"></div>
    </header>
    <section>
        <h2>@モバイルくん</h2>
        <br>
        <div id="traffic_line_all_1"
             style="width: 89%; height: 130mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section style="width: 89%; text-align: right; font-size: 9px;">
        ※DPI装置より取得（平均トラフィックを使用）
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>帯域運用について（全体トラフィック量の推移）</h1>
        <div class="header"></div>
    </header>
    <section>
        <h2>Route7</h2>
        <br>
        <div id="traffic_line_all_2"
             style="width: 89%; height: 130mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section style="width: 89%; text-align: right; font-size: 9px;">
        ※DPI装置より取得（平均トラフィックを使用）
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>接続者数推移</h1>
        <div class="header"></div>
    </header>
    <section>
        <h2>@モバイルくん</h2>
        <div id="user_count_line_1"
             style="width: 89%; height: 60mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section>
        <h2>Route7</h2>
        <div id="user_count_line_2"
             style="width: 89%; height: 60mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>接続者数推移（全体）</h1>
        <div class="header"></div>
    </header>
    <section>
        <h2>全体</h2>
        <br>
        <div id="user_count_line_3"
             style="width: 89%; height: 100mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section style="font-size: 16px; margin-top: 20px">
        <div style="text-align: center"><p><?= $last_month ?>月の最大ユーザ数</p>
            <div class='box'
                 style="text-align: left; width: 100px; background-color: #a6d5ec; padding: 2px; border-bottom: #0b2e13 solid 1px;">
                LTE
            </div>
            <div class='box'
                 style="text-align: right; width: 100px; padding: 2px; border-bottom: #0b2e13 solid 1px;"><?= $max_active_user_count_lte_month[0]->Xi ?></div>
            <div class='after'></div>
            <div class='box'
                 style="text-align: left; width: 100px; background-color: #8fcafe; padding: 2px; border-bottom: #0b2e13 solid 1px;">
                3G
            </div>
            <div class='box'
                 style="text-align: right; width: 100px; padding: 2px; border-bottom: #0b2e13 solid 1px;"><?= $max_active_user_count_3g_month[0]->FOMA ?></div>
        </div>
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>帯域運用について（主要サービスについて）</h1>
        <div class="header"></div>
    </header>
    <section>
        <?= $last_before_month?>月から<?= $this_month?>月までの主要サービスのトラフィック量についてご報告致します。<br>
        <br>
        <div id="service_line_new"
             style="width: 49%; height: 550px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="service_area_new"
             style="width: 49%; height: 550px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
    </section>
    <?php /*$this -> load -> view('common/report_footer'); */ ?>
</article>

<?php
$date = '[';
foreach ($last_month_days as $key => $last_month_day) {
    $date .= "'" . $last_month_day . "',";
}
$date = substr($date, 0, -1) . ']';

$i = 1;
foreach ($host_data as $key => $host) {
    $data = null;
    foreach ($last_month_days as $key => $last_month_day) {
        $data .= '[';
        foreach ($plot_down_data[$host][$last_month_day] as $key => $val) {
            if (!$val) {
                $val = 0;
            }
            $data .= $val . ',';
        }
        $data = substr($data, 0, -1) . '],';
    }
    $data = substr($data, 0, -1);
    $id = 'BoxPlotChart_' . $i;
    $i++;
    ?>
    <script type="text/javascript">
        $(function () {
            Highcharts.chart('<?=$id?>', {
                credits: {
                    enabled: false,
                },
                chart: {
                    type: 'boxplot'
                },
                title: {
                    text: 'PGW: <?=$host?>'
                },
                legend: {
                    enabled: false
                },
                xAxis: {
                    categories: <?=$date?>,
                },
                yAxis: {
                    title: {
                        text: 'Mbps'
                    },
                },
                series: [{
                    name: '速度',
                    data: [
                        <?=$data?>
                    ],
                },]
            });

        });
    </script>
    <article class="sheet">
        <header>
            <h1>速度測定結果 Down</h1>
            <div class="header"></div>
        </header>
        <section>
            <div id="<?= $id ?>"
                 style="width: 89%; height: 550px; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
        </section>
        <?php $this->load->view('common/report_footer'); ?>
    </article>
    <?php
}
?>

<?php
$date = '[';
foreach ($last_month_days as $key => $last_month_day) {
    $date .= "'" . $last_month_day . "',";
}
$date = substr($date, 0, -1) . ']';

$i = 1;
foreach ($host_data as $key => $host) {
    $data = null;
    foreach ($last_month_days as $key => $last_month_day) {
        $data .= '[';
        foreach ($plot_up_data[$host][$last_month_day] as $key => $val) {
            if (!$val) {
                $val = 0;
            }
            $data .= $val . ',';
        }
        $data = substr($data, 0, -1) . '],';
    }
    $data = substr($data, 0, -1);
    $id = 'BoxPlotChart_up_' . $i;
    $i++;
    ?>
    <script type="text/javascript">
        $(function () {
            Highcharts.chart('<?=$id?>', {
                credits: {
                    enabled: false,
                },
                chart: {
                    type: 'boxplot'
                },
                title: {
                    text: 'PGW: <?=$host?>'
                },
                legend: {
                    enabled: false
                },
                xAxis: {
                    categories: <?=$date?>,
                },
                yAxis: {
                    title: {
                        text: 'Mbps'
                    },
                },
                series: [{
                    name: '速度',
                    data: [
                        <?=$data?>
                    ],
                },]
            });

        });
    </script>
    <article class="sheet">
        <header>
            <h1>速度測定結果 Up</h1>
            <div class="header"></div>
        </header>
        <section>
            <div id="<?= $id ?>"
                 style="width: 89%; height: 550px; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
        </section>
        <?php $this->load->view('common/report_footer'); ?>
    </article>
    <?php
}
?>


<article class="sheet">
    <header>
        <h1>速度測定結果</h1>
        <div class="header"></div>
    </header>
    <section>
        <div id="BoxPlotChart_up_summary_pg"
             style="width: 45%; height: 200px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="BoxPlotChart_dw_summary_pg"
             style="width: 45%; height: 200px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="BoxPlotChart_up_summary_place"
             style="width: 45%; height: 200px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="BoxPlotChart_dw_summary_place"
             style="width: 45%; height: 200px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="BoxPlotChart_up_summary_server"
             style="width: 45%; height: 200px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="BoxPlotChart_dw_summary_server"
             style="width: 45%; height: 200px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>

<article class="sheet">
    <header>
        <h1>作業報告</h1>
        <div class="header"></div>
    </header>
    <section>
        <?= $this_month ?>月中に実施しました作業は以下の通りとなります。
        <br>
        <table style="width: 100%; font-size: 12px; float: center;">
            <tr style="color: white; background-color: #CC0000;">
                <th style='border-right: #313131 solid 1px; width: 240px; text-align: center;'>タイトル</th>
                <th style='border-right: #313131 solid 1px; width: 200px; text-align: center;' nowrap>作業実施日</th>
                <th style='border-right: #313131 solid 1px; width: 560px; text-align: center;' nowrap>作業内容</th>
            </tr>
            <?php $i = 1;
            foreach ($jobs[0] as $val) { ?>
                <tr style="background-color: <?php echo ($i % 2 == 0) ? '#F6CECE' : '#FBEFEF'; ?>; vertical-align: top;">
                    <td style="text-align: left;"><?= $val['title'] ?></td>
                    <td style="text-align: left;" nowrap><?= $val['day'] ?></td>
                    <td style="text-align: left;"><?= $val['body'] ?></td>
                </tr>
                <?php $i++;
            } ?>
        </table>
        <br>
        <br>
        <br>

        <?= $next_month ?>月の予定作業は以下の通りとなります。
        <br>
        <table style="width: 100%; font-size: 12px; float: center;">
            <tr style="color: white; background-color: #CC0000;">
                <th style='border-right: #313131 solid 1px; width: 240px; text-align: center;'>タイトル</th>
                <th style='border-right: #313131 solid 1px; width: 200px; text-align: center;' nowrap>作業実施日</th>
                <th style='border-right: #313131 solid 1px; width: 560px; text-align: center;' nowrap>作業内容</th>
            </tr>
            <?php $i = 1;
            foreach ($jobs[1] as $val) { ?>
                <tr style="background-color: <?php echo ($i % 2 == 0) ? '#F6CECE' : '#FBEFEF'; ?>; vertical-align: top;">
                    <td style="text-align: left;"><?= $val['title'] ?></td>
                    <td style="text-align: left;" nowrap><?= $val['day'] ?></td>
                    <td style="text-align: left;"><?= $val['body'] ?></td>
                </tr>
                <?php $i++;
            } ?>
        </table>
    </section>
    <?php $this->load->view('common/report_footer'); ?>
</article>


</body></html>
