<!--
6 アクティブユーザ数の推移
-->
<?php $this->load->view('layout/page_break'); ?>
<section class="subject">
    6　アクティブユーザ数の推移
</section>
<?php include($static_throughput . 'active_user_report_xi.html'); ?>
<?php include($static_throughput . 'active_user_report_foma.txt'); ?>
<?php $this->load->view('layout/page_footer'); ?>

<?php $this->load->view('layout/page_break'); ?>
<?php include($static_throughput . 'active_user_report_all.txt'); ?>
<?php $this->load->view('layout/page_footer'); ?>
