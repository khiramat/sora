<!--
5 サービス top 10
-->
<?php $this->load->view('layout/page_break'); ?>
<section class="subject">
    5 プラン毎の通信量（1週間）（Mbytes）
</section>
<?php include($static_throughput . 'traffic_report_xi.html'); ?>
<?php include($static_throughput . 'traffic_report_foma.txt'); ?>
<?php $this->load->view('layout/page_footer'); ?>

<?php $this->load->view('layout/page_break'); ?>
<?php include($static_throughput . 'traffic_report_all.txt'); ?>
<?php $this->load->view('layout/page_footer'); ?>
