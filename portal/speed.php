<!--
7　速度測定結果
-->
<?php $this->load->view('layout/page_break'); ?>
<section class="subject">
    7　速度測定結果
</section>
<?php include($static_throughput . 'speed_report_index.html'); ?>
<?php $this->load->view('layout/page_footer'); ?>

<?php $this->load->view('layout/page_break'); ?>
<?php include($static_throughput . 'speed_report_daily.html'); ?>
<section class="chart">
    <div id="line_speed_1" class="speed_daily"></div>
    <div id="line_speed_2" class="speed_daily"></div>
    <div id="line_speed_3" class="speed_daily"></div>
    <div id="line_speed_4" class="speed_daily"></div>
</section>
<?php $this->load->view('layout/page_footer'); ?>
<?php $this->load->view('layout/page_break'); ?>
<section class="chart">
    <div id="line_speed_5" class="speed_daily"></div>
    <div id="line_speed_6" class="speed_daily"></div>
    <div id="line_speed_7" class="speed_daily"></div>
</section>
<?php $this->load->view('layout/page_footer'); ?>
