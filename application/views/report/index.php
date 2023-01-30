<?php
$h1 = "運用レポート ポータルサイト";
$this->load->view('common/report_head');
?>
<body>

<?php
include('top_page.php');
$this->load->view('daily_traffic/line');
include('');

?>

<!-- footer -->
<?php $this->load->view('common/report_footer'); ?>

</body>
</html>