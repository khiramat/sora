<html lang="jp">
<head>
    <?php
    ini_set('display_errors', "Off");
    $this->load->helper('report');
    //	$this -> load -> view('layout/import');
    $directory = get_directory_last_monday();
    //$directory         = "2018-06-27";
    $static_throughput = "/var/www/html/static/" . $directory . "/report/";
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="http://13.114.82.254/report/assets/css/submission_report.css"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript"
            src="http://13.114.82.254/report/assets/highcharts/code/modules/exporting.js"></script>
    <script type="text/javascript" src="http://13.114.82.254/report/assets/js/common.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script type="text/javascript" src="http://13.114.82.254/report/assets/highcharts/code/highcharts.js"></script>
    <script type="text/javascript" src="http://13.114.82.254/report/assets/js/highcharts.js"></script>

    <title>LinksMate様 週次報告書</title>
</head>
<body>
<?php

include('top_page.php');
include('count_free.php');

include('xi_throughput_data.php');

include('foma_throughput_data.php');

include('top10.php');
include('plan.php');
include('active_user.php');
include('speed.php');

include('egosearch.php');
include('work.php');
include('etc.php');

?>
</body>
</html>