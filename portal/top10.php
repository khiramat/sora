
<!--
4 サービス top 10
-->
<?php $this->load->view('layout/page_break'); ?>
<section class="subject">
    4 サービスの利用状況について
</section>
<?php include($static_throughput . 'service_report_top10.html'); ?>

<section class="paragraph">
    <div id="service_top10_a1" class="throughput_top_all"></div>
</section>
<?php $this->load->view('layout/page_footer'); ?>

<?php $this->load->view('layout/page_break'); ?>
<?php include($static_throughput . 'service_report_top10_daily.html'); ?>
<section class="paragraph">
    <div id="service_top10_d_a1" class="throughput_top_d"></div>
    <div id="service_top10_d_a2" class="throughput_top_d"></div>
</section>

<?php $this->load->view('layout/page_footer'); ?>
<?php $this->load->view('layout/page_break'); ?>
<section class="paragraph">
    <div id="service_top10_d_a3" class="throughput_top_d"></div>
    <div id="service_top10_d_a4" class="throughput_top_d"></div>
    <div id="service_top10_d_a5" class="throughput_top_d"></div>
</section>
<?php $this->load->view('layout/page_footer'); ?>

<?php $this->load->view('layout/page_break'); ?>
<section class="paragraph">
    <div id="service_top10_d_a6" class="throughput_top_d"></div>
    <div id="service_top10_d_a7" class="throughput_top_d"></div>
</section>
<?php $this->load->view('layout/page_footer'); ?>
