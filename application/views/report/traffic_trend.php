<?php
$this->load->helper('url');
$this->load->helper('utility');
// $last_month = get_last_month_n();
// $this_month = get_this_month_n();
//$next_month = get_next_month_n();
//$last_before_month = get_last_before_month_n();

//ヘッダ
$this->load->view('common/report_head');

//トラフィック量数位グラフ用データ
$sd = date('Y年n月t日' ,strtotime($bandwidth_use_rete_point[0]));
$ed = date('Y年n月t日' ,strtotime("$bandwidth_use_rete_point[1] +1 month"));
$subtitle = $sd . "　〜　" . $ed;

//年跨ぎバグ対応
$start_year = ($last_before_month == 11) ? $this_year - 1 : $this_year;
?>


<body>
<!-- Graph -->
<!-- <script type="text/javascript" src="<?= base_url() ?>assets/js/highcharts.js"></script> -->
<script type="text/javascript">
    $(function () {
        //12時の帯域使用率
        lineChartBandwidthUseRate("line_bandwidth_1", "<?=$last_before_month?>月", "", "", "%", <?=date('Y' ,strtotime($bandwidth_use_rete_point[0]))?>, <?=date('n' ,strtotime($bandwidth_use_rete_point[0]))?>, <?=$bandwidth_use_rete_data[0]?>);
        lineChartBandwidthUseRate("line_bandwidth_2", "<?=$last_month?>月", "", "", "%", <?=date('Y' ,strtotime($bandwidth_use_rete_point[1]))?>, <?=date('n' ,strtotime($bandwidth_use_rete_point[1]))?>, <?=$bandwidth_use_rete_data[1]?>);
        lineChartBandwidthUseRate("line_bandwidth_3", "<?=$this_month?>月", "", "", "%", <?=date('Y' ,strtotime($bandwidth_use_rete_point[2]))?>, <?=date('n' ,strtotime($bandwidth_use_rete_point[2]))?>, <?=$bandwidth_use_rete_data[2]?>);
        //速度測定カウント
        speedCountBarChart("speed_count_1", "<?=$last_before_month?>月", <?=$speed_data['categories']?>, <?=$speed_data['json'][0]?>);
        speedCountBarChart("speed_count_2", "<?=$last_month?>月", <?=$speed_data['categories']?>, <?=$speed_data['json'][1]?>);
        speedCountBarChart("speed_count_3", "<?=$this_month?>月", <?=$speed_data['categories']?>, <?=$speed_data['json'][2]?>);
        //トラフィック量推移
        lineChartDaily("traffic_line", "トラフィック量推移", "", 'トラフィック（bps）', 400000000, 20000000, <?=$traffic_data?>, <?=$start_year?>, <?=$last_before_month?> );
        //接続者数推移
        lineChartDaily("user_count_line", "接続者数推移", "", '接続者数（人）', 16000, 2000, <?=$user_count_data['json']?>, <?=$start_year?>, <?=$last_before_month?> );
        //サービスTOP10
        lineChartServiceTop("service_line", "主要サービス単体のトラフィック使用量", "", "トラフィック（bps）", "bps", 1, 1000000, <?=$service_daily_data?>);
        AreaChart("service_area", "主要サービス全体の合計使用量", "", "トラフィック（bps）", "bps",  <?=$service_daily_data?>);
        //速度測定時間別グラフ
        <?php foreach($speed_graph_data['json'] as $lte => $hour_arr){ ?>
        <?php foreach($hour_arr as $hour => $values){ ?>
            lineChartSetMax("<?=PIPE_CODE[$lte]['name']?>_line_speed_<?=$hour?>", "<?=PIPE_CODE[$lte]['name']?>下り速度(<?=$hour?>)", "", "", "Mbps", 1, 0, <?=$speed_graph_data['max'][$lte]?>, <?=$speed_graph_data['tickInterval_y'][$lte]?>, <?=$speed_graph_data['json'][$lte][$hour]?>);
        <?php } ?>
        <?php } ?>
    });
</script>

<style type="text/css">
    tr{
        border-bottom: #313131 solid 1px;
    }
    th{
        padding: 2px;

    }
    td{
        border-right: #313131 solid 1px;
        padding: 2px;
    }
</style>

<!-- Page 1 -->
<article class="sheet">
    <header>
        <h1>SORAシム株式会社 御中 </h1>
    </header>
    <section style="width: 94%; text-align: center; font-size: 50px; font-weight: bold; height: 80mm; vertical-align: middle">月次報告書</section>
	<!-- <section style="width: 94%; text-align: center; font-size: 24px; font-weight: bold; height: 20mm;"><?=$this_year?>年 <?=get_next_month_n()?>月 13日</section> -->
    <section style="width: 94%; text-align: center; font-size: 24px; font-weight: bold; height: 20mm;"><?=date('Y年')?> <?=get_next_month_n()?>月版</section>
    <section style="width: 94%; text-align: center; height: 60mm;"><img src="<?=base_url()?>assets/images/ranger_newlogo-big.png"></section>
</article>

<!-- Page 2 -->
<article class="sheet">
    <header>
        <h1>目次</h1>
        <div class="header"></div>
    </header>
    <br>
    <br>
    <section>
        <table align=center width=900 style="font-size: 20px;">
            <tr><td>
                <ol>
                    <li>帯域状況について</li>
                    <br>
                    <li>ハードウェアメンテナンス結果について</li>
                    <br>
                    <li>帯域運用について</li>
                    <ol>
                        <li>トラフィック量の推移(全体/時間別)</li>
                        <li>接続者数の推移</li>
                        <li>主要サービスについて</li>
                    </ol>
                    <br>
                    <li>速度測定結果について(LTE/3G)</li>
                    <ol>
                        <li>LTE RBB</li>
                        <li>3G RBB</li>
                    </ol>
                    <br>
                    <li>アラート報告</li>
                    <br>
                    <li>作業報告
                    </li>
                </ol>
            </td></tr>
        </table>
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>

<!-- Page 3 -->
<article class="sheet">
    <header>
        <h1>帯域状況について</h1>
        <!-- <div class="header"></div> -->
    </header>
    <section>
        今月の結果をもとに、帯域の未来予測をご報告致します。<br>
        <div id="line_bandwidth_1" style="width: 31.8%; height: 160px; margin: 2px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="line_bandwidth_2" style="width: 31.8%; height: 160px; margin: 2px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="line_bandwidth_3" style="width: 31.8%; height: 160px; margin: 2px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <br><br><br>
        <div id="speed_count_1" style="width: 31.8%; height: 250px; margin: 2px 8px 0px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="speed_count_2" style="width: 31.8%; height: 250px; margin: 2px 8px 0px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="speed_count_3" style="width: 31.8%; height: 250px; margin: 2px 0px 0px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <!-- <div id="advanced_timeline_1" style="width: 30%; height: 100mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>-->
    <section>
        <br><?= $texts[1]['body'] ?><br><br>
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>

<!-- Page 4 -->
<article class="sheet">
    <header>
        <h1>ハードウェアメンテナンス結果について</h1>
        <div class="header"></div>
    </header>
    <section>
        <div style="width: 90%; font-size: 19px;">
        <?= $this_month ?>月中のハードウェアメンテナンスについてご報告致します。
        <br><br>
        <center>
        <table style="width: 190mm; float: center; margin: 10px 0 10px 50px; font-size: 18px;">
	        <tr style="color: white; background-color: #CC0000">
		        <th style='border-right: #313131 solid 1px; text-align: left;'>項目</th>
                <th style='border-right: #313131 solid 1px; text-align: left;'>結果</th>
	        </tr>
	        <tr style='background-color:#D8D8D8'>
		        <td>ネットワーク関連</td><td>異常はございませんでした</td>
	        </tr>
	        <tr>
		        <td>リモートアクセス装置</td><td>異常はございませんでした</td>
	        </tr>
	        <tr style='background-color:#D8D8D8'>
		        <td>メディアコンバータ</td><td>異常はございませんでした</td>
	        </tr>
	        <tr>
		        <td>DPI装置</td><td>異常はございませんでした</td>
	        </tr>
	        <tr style='background-color:#D8D8D8'>
		        <td>サーバ関連</td><td>異常はございませんでした</td>
	        </tr>
	        <tr>
		        <td>現地LED確認</td><td>異常はございませんでした</td>
	        </tr>
	        <tr style='background-color:#D8D8D8'>
		        <td>脆弱性調査</td><td>異常はございませんでした</td>
	        </tr>
        </table>
        </center>
        <br>
        <br>
        なお、詳細のステータス確認結果は、以下ファイルをご参照ください。
        <br><br>

        <b>▼ファイル名</b><br>
        SORAシム株式会社御中_MNOダイレクトプロジェクト_月次報告書（<?= $this_year ?>年<?= $this_month ?>月).pdf
        </div>
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>

<!-- Page 5 -->
<article class="sheet">
    <header>
        <h1>帯域運用について（トラフィック量の推移(全体)）</h1>
        <div class="header"></div>
    </header>
    <section>
        <?= $last_month ?>月から<?= $next_month ?>月までのトラフィック量の推移予測についてご報告致します。<br>
        <br>
        <div id="traffic_line"
             style="width: 89%; height: 130mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
    </section>
    <section style="width: 89%; text-align: right; font-size: 9px;">
        ※DPI装置より取得（平均トラフィックを使用）
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>

<!-- Page 6 -->
<article class="sheet">
    <header>
        <h1>帯域運用について（トラフィック量の推移(時間別)）</h1>
        <div class="header"></div>
    </header>
    <section>
        <div style="width: 90%; font-size: 19px;">
            時間別のトラフィック量の推移につきましては、以下ファイルをご参照下さい。
            <br><br>
            <b>▼ファイル名</b><br>
            【別紙】時間別トラフィック量まとめ_<?= $this_month ?>月度.pdf
        </div>
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>

<!-- Page 7 -->
<article class="sheet">
    <header>
        <h1>帯域運用について（接続者数の推移）</h1>
        <div class="header"></div>
    </header>
    <section>
        <?= $last_month ?>月から<?= $next_month ?>月までの接続者数の推移予測についてご報告致します。<br>
        <br>
        <div id="user_count_line" style="width: 89%; height: 100mm; margin: 0 auto; border-style: solid; border-width: 1px; border-color: #C0C0C0;"></div>
        <table style="width: 90%; margin: 10px 0 10px 50px; font-size: 14px; float: center;">
            <tr style="color: white; background-color: #CC0000;">
                <th style='border-right: #313131 solid 1px; text-align: center;'>接続者数</th>
                <th style='border-right: #313131 solid 1px; text-align: center;'><?= $user_count_data['table']['xi'][0]['date'] ?></th>
                <th style='border-right: #313131 solid 1px; text-align: center;'><?= $user_count_data['table']['xi'][1]['date'] ?></th>
                <th style='border-right: #313131 solid 1px; text-align: center;'><?= $user_count_data['table']['xi'][2]['date'] ?></th>
                <th style='border-right: #313131 solid 1px; text-align: center;'><?= $user_count_data['table']['xi'][3]['date'] ?></th>
                <th style='border-right: #313131 solid 1px; text-align: center;'><?= $user_count_data['table']['xi'][4]['date'] ?></th>
                <th style='border-right: #313131 solid 1px; text-align: center;'><?= $user_count_data['table']['xi'][5]['date'] ?></th>
            </tr>
            <tr style="background-color: #F6CECE;">
	            <td style="text-align: left; font-weight: bold;">&nbsp;&nbsp;LTE</td>
	            <td style="text-align: center"><?= $user_count_data['table']['xi'][0]['count'] ?></td>
	            <td style="text-align: center"><?= $user_count_data['table']['xi'][1]['count'] ?></td>
	            <td style="text-align: center"><?= $user_count_data['table']['xi'][2]['count'] ?></td>
                <td style="text-align: center"><?= $user_count_data['table']['xi'][3]['count'] ?></td>
                <td style="text-align: center"><?= $user_count_data['table']['xi'][4]['count'] ?></td>
                <td style="text-align: center"><?= $user_count_data['table']['xi'][5]['count'] ?></td>
            </tr>
            <tr style="background-color: #FBEFEF;">
	            <td style="text-align: left; font-weight: bold;">&nbsp;&nbsp;3G</td>
	            <td style="text-align: center"><?= $user_count_data['table']['foma'][0]['count'] ?></td>
                <td style="text-align: center"><?= $user_count_data['table']['foma'][1]['count'] ?></td>
                <td style="text-align: center"><?= $user_count_data['table']['foma'][2]['count'] ?></td>
                <td style="text-align: center"><?= $user_count_data['table']['foma'][3]['count'] ?></td>
                <td style="text-align: center"><?= $user_count_data['table']['foma'][4]['count'] ?></td>
                <td style="text-align: center"><?= $user_count_data['table']['foma'][5]['count'] ?></td>
            </tr>
        </table>
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>


<!-- Page 8 -->
<article class="sheet">
    <header>
        <h1>帯域運用について（主要サービスについて）</h1>
        <div class="header"></div>
    </header>
    <section>
        <?= $last_before_month ?>月から<?= $this_month ?>月までの主要サービスのトラフィック量についてご報告致します。<br>
        詳細なトラフィック量のまとめにつきましては、次のページに記載しております。<br>
        <br>
        <div id="service_line" style="width: 49%; height: 460px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="service_area" style="width: 49%; height: 460px; margin: 0px 8px 6px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>



<!-- Page 9 -->
<article class="sheet">
    <header>
        <h1>帯域運用について（主要サービスについて）</h1>
        <div class="header"></div>
    </header>
    <section>
        <?= $texts[2]['body'] ?><br>
        <table style="width: 90%; margin: 10px 0 10px 50px; font-size: 14px; float: center;">
            <tr style="color: white;">
                <th colspan=2 style='width: 30mm; background-color: #CC0000; border-right: #313131 solid 1px; text-align: center;'></th>
                <?php foreach($service_arr as $value){ ?>
                <th style='width: 20mm; background-color: #CC0000; border-right: #313131 solid 1px; text-align: center;'><?= $value ?></th>
                <?php } ?>
            </tr>
            <?php $i = 0; ?>
            <?php foreach($service_monthly_data as $month => $values){ ?>
                <?php $month = (strcmp($month, 'Total') == 0) ? $month : $month.'月'; ?>
                <?php $color = ($i%2 == 0) ? '#FBEFEF': '#F6CECE'; ?>
            <tr>
                <th rowspan=3 style='color: white; background-color: #CC0000; border-right: #313131 solid 1px; text-align: center;'><?= $month ?></th>
                <?php foreach($values as $key => $service_arr){ ?>
                <td style="color: white; background-color: #CC0000; text-align: center;"><?= $key ?></td>
                <?php foreach($service_arr as $service => $val){ ?>
                    <td style="background-color: <?=$color?>; text-align: center"><?= $val ?></td>
                <?php } ?>
            </tr>
                <?php } ?>
                <?php $i++; ?>
            <?php } ?>
        </table>
    </section>
    <!-- footer -->
    <?php //$this->load->view('common/report_footer'); ?>
</article>


<!-- Page 10 -->
<article class="sheet">
    <header>
        <h1>速度測定結果について</h1>
        <div class="header"></div>
    </header>
    <section>
        <div style="width: 90%; font-size: 19px;">
            <br><?= $texts[3]['body'] ?><br>
            <br>
            ＠モバイルくん。の各測定結果のグラフにつきましては、次のページに記載しております。
        </div>
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>


<!-- Page 11 -->
<article class="sheet">
    <header>
        <h1>速度測定結果について(LTE RBB)</h1>
        <div class="header"></div>
    </header>
    <section>
        <div id="LTE_line_speed_2:00" style="width: 33%; height: 199px; margin: 0px 2px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="LTE_line_speed_12:00" style="width: 33%; height: 199px; margin: 0px 2px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="LTE_line_speed_18:00" style="width: 33%; height: 199px; margin: 0px 0px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <br>
        <div id="LTE_line_speed_6:00" style="width: 33%; height: 199px; margin: 0px 2px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="LTE_line_speed_15:00" style="width: 33%; height: 199px; margin: 0px 2px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="LTE_line_speed_22:00" style="width: 33%; height: 199px; margin: 0px 0px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <br>
        <div id="LTE_line_speed_9:00" style="width: 33%; height: 199px; margin: 0px 2px 0px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
    </section>
    <!-- footer -->
    <?php //$this->load->view('common/report_footer'); ?>
</article>

<!-- Page 12 -->
<article class="sheet">
    <header>
        <h1>速度測定結果について(3G RBB)</h1>
        <div class="header"></div>
    </header>
    <section>
        <div id="3G_line_speed_2:00" style="width: 33%; height: 199px; margin: 0px 2px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="3G_line_speed_12:00" style="width: 33%; height: 199px; margin: 0px 2px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="3G_line_speed_18:00" style="width: 33%; height: 199px; margin: 0px 0px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <br>
        <div id="3G_line_speed_6:00" style="width: 33%; height: 199px; margin: 0px 2px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="3G_line_speed_15:00" style="width: 33%; height: 199px; margin: 0px 2px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <div id="3G_line_speed_22:00" style="width: 33%; height: 199px; margin: 0px 0px 2px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
        <br>
        <div id="3G_line_speed_9:00" style="width: 33%; height: 199px; margin: 0px 2px 0px 0px; border-style: solid; border-width: 1px; border-color: #C0C0C0; float:left;"></div>
    </section>
    <!-- footer -->
    <?php //$this->load->view('common/report_footer'); ?>
</article>


<!-- Page 13 -->
<article class="sheet">
    <header>
        <h1>速度測定結果について(RBB)</h1>
        <div class="header"></div>
    </header>
    <section>
        <section>

            <!-- LTE -->
            <div style="width: 47%; margin: 2px 8px 6px 0px; float:left;">
            LTE端末（iPhone6）によるRBBでの測定結果についてご報告いたします。<br>
            <table style="width: 100%; height: 400px; font-size: 14px; float: center;">
                <tr style="color: white; background-color: <?=PIPE_CODE[1]['color']?>;">
                    <th colspan=4 style='border-right: #313131 solid 1px; text-align: center;'>LTE 1ヶ月の時間帯別　平均速度</th>
                </tr>
                <tr style="color: white; background-color:<?=PIPE_CODE[1]['color']?>;">
                    <th style='border-right: #313131 solid 1px; text-align: center;'>時間</th>
                    <th style='border-right: #313131 solid 1px; text-align: center;'><?= $last_before_month ?>月<?=$speed_monthly_data[1][0]['str']?></th>
                    <th style='border-right: #313131 solid 1px; text-align: center;'><?= $last_month ?>月<?=$speed_monthly_data[1][1]['str']?></th>
                    <th style='border-right: #313131 solid 1px; text-align: center;'><?= $this_month ?>月<?=$speed_monthly_data[1][2]['str']?></th>
                </tr>
                <tr style="background-color: #F6CECE;">
    	            <th style="background-color:<?=PIPE_CODE[1]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">2:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][0][2]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][1][2]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][2][2]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #F6CECE;">
    	            <th style="background-color:<?=PIPE_CODE[1]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">6:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][0][6]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][1][6]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][2][6]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #F6CECE;">
    	            <th style="background-color:<?=PIPE_CODE[1]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">9:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][0][9]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][1][9]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][2][9]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #F6CECE;">
    	            <th style="background-color:<?=PIPE_CODE[1]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">12:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][0][12]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][1][12]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][2][12]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #F6CECE;">
    	            <th style="background-color:<?=PIPE_CODE[1]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">15:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][0][15]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][1][15]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][2][15]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #F6CECE;">
    	            <th style="background-color:<?=PIPE_CODE[1]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">18:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][0][18]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][1][18]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][2][18]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #F6CECE;">
    	            <th style="background-color:<?=PIPE_CODE[1]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">22:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][0][22]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][1][22]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[1][2][22]?> Mbps&nbsp;</td>
                </tr>
            </table>
            </div>

            <!-- 3G -->
            <div style="width: 47%; margin: 2px 8px 6px 0px; float:right;">
                3G端末（モバイルルータ）によるRBBでの測定結果について<br>
            <table style="width: 100%; height: 400px; font-size: 14px; float: center;">
                <tr style="color: white; background-color: <?=PIPE_CODE[0]['color']?>;">
                    <th colspan=4 style='border-right: #313131 solid 1px; text-align: center;'>3G 1ヶ月の時間帯別　平均速度</th>
                </tr>
                <tr style="color: white; background-color:<?=PIPE_CODE[0]['color']?>;">
                    <th style='border-right: #313131 solid 1px; text-align: center;'>時間</th>
                    <th style='border-right: #313131 solid 1px; text-align: center;'><?= $last_before_month ?>月</th>
                    <th style='border-right: #313131 solid 1px; text-align: center;'><?= $last_month ?>月</th>
                    <th style='border-right: #313131 solid 1px; text-align: center;'><?= $this_month ?>月</th>
                </tr>
                <tr style="background-color: #d1e8ff;">
    	            <th style="background-color:<?=PIPE_CODE[0]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">2:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][0][2]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][1][2]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][2][2]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #d1e8ff;">
    	            <th style="background-color:<?=PIPE_CODE[0]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">6:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][0][6]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][1][6]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][2][6]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #d1e8ff;">
    	            <th style="background-color:<?=PIPE_CODE[0]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">9:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][0][9]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][1][9]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][2][9]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #d1e8ff;">
    	            <th style="background-color:<?=PIPE_CODE[0]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">12:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][0][12]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][1][12]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][2][12]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #d1e8ff;">
    	            <th style="background-color:<?=PIPE_CODE[0]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">15:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][0][15]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][1][15]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][2][15]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #d1e8ff;">
    	            <th style="background-color:<?=PIPE_CODE[0]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">18:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][0][18]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][1][18]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][2][18]?> Mbps&nbsp;</td>
                </tr>
                <tr style="background-color: #d1e8ff;">
    	            <th style="background-color:<?=PIPE_CODE[0]['color']?>; border-right: #313131 solid 1px; text-align: center; color: #FFFFFF">22:00</th>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][0][22]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][1][22]?> Mbps&nbsp;</td>
    	            <td style="text-align: right"><?=$speed_monthly_data[0][2][22]?> Mbps&nbsp;</td>
                </tr>
            </table>
            </div>
        </section>
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>


<!-- Page 14 -->
<?php foreach($alerts as $page => $no_arr): ?>
    <article class="sheet">
        <header>
            <h1>アラート報告</h1>
            <div class="header"></div>
        </header>
        <section>
            <?php if($page == 1): ?>
                <?= $this_month ?>月中に発生しましたアラートについてご報告致します。<br>
                <br>
                アラート受信数： <?= $alert_cnt_arr[0] ?>件（先月： <?= $alert_cnt_arr[1] ?>件）<br>
            <?php endif; ?>

            <table style="width: 100%; font-size: 12px; float: center;">
                <tr style="color: white; background-color: #CC0000;">
                    <th style='border-right: #313131 solid 1px; text-align: center;' nowrap>アラート種別</th>
                    <th style='border-right: #313131 solid 1px; text-align: center;' nowrap>発生源</th>
                    <th style='border-right: #313131 solid 1px; text-align: center;' nowrap>発生日時</th>
                    <th style='border-right: #313131 solid 1px; text-align: center;' nowrap>サービス<br>影響</th>
                    <th style='border-right: #313131 solid 1px; text-align: center; width: 250px;' nowrap>アラート内容</th>
                    <th style='border-right: #313131 solid 1px; text-align: center; width: 250px;' nowrap>発生原因</th>
                </tr>

                <?php foreach($no_arr as $no => $val): ?>
                    <?php $color = ($no%2==0) ? $colors[1] : $colors[0]; ?>
                    <tr style="background-color: <?= $color ?>; vertical-align: top;">
        	            <td style="text-align: left;" nowrap><?=$val['type']?></td>
        	            <td style="text-align: left;" nowrap><?=$val['hostname']?></td>
        	            <td style="text-align: left;" nowrap><?=$val['datetimes']?></td>
                        <td style="text-align: left; text-align: center; width: 20;" nowrap><?=$val['service_flg']?></td>
                        <td style="text-align: left; width: 100;"><?=nl2br($val['body'])?></td>
                        <td style="text-align: left; width: 100;"><?=nl2br($val['cause'])?></td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </section>

        <!-- footer -->
        <?php //$this->load->view('common/report_footer'); ?>
    </article>
<?php endforeach; ?>


<!-- Page 19 -->
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
            <?php $i=1; foreach($jobs[0] as $val){ ?>
                <tr style="background-color: <?php echo ($i%2==0)?'#F6CECE':'#FBEFEF'; ?>; vertical-align: top;">
    	            <td style="text-align: left;"><?=$val['title']?></td>
    	            <td style="text-align: left;" nowrap><?=$val['day']?></td>
    	            <td style="text-align: left;"><?=$val['body']?></td>
                </tr>
            <?php $i++; } ?>
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
            <?php $i=1; foreach($jobs[1] as $val){ ?>
                <tr style="background-color: <?php echo ($i%2==0)?'#F6CECE':'#FBEFEF'; ?>; vertical-align: top;">
                    <td style="text-align: left;"><?=$val['title']?></td>
                    <td style="text-align: left;" nowrap><?=$val['day']?></td>
                    <td style="text-align: left;"><?=$val['body']?></td>
                </tr>
            <?php $i++; } ?>
        </table>
    </section>
    <!-- footer -->
    <?php $this->load->view('common/report_footer'); ?>
</article>


</body>
</html>
