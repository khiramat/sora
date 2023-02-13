<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * スループットコントローラー
 */
class Traffic_analytics extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(false);
    }

    public function index()
    {
        $this->load->view('traffic_analytics/line');
    }

    /**
     * メイン処理
     */
    public function line()
    {
        $this->load->helper('utility'); //ヘルパー
        $this->load->model('materials_model'); //モデル
        $today = date();
        $this_month = get_this_month();
        $last_month = date("Y-m", strtotime("$today -1 month"));
        $month = explode("-", $last_month)[1];

// $this_month = '2020-09';
// $last_month = '2020-08';
        if($month == 12){
            $this_year = date("Y", strtotime("$today -1 year"));
            $last_year = date("Y", strtotime("$today -2 year"));
        } else {
            $this_year = date("Y");
            $last_year = date("Y", strtotime("$today -1 year"));
        }

        $sdate = get_first_date($last_month);
        $edate = get_last_date($this_month);
        $last_month_1day = date('Y-m-01', strtotime(date('Y-m-1') . '-1 month'));
        $last_month_last_day = date('Y-m-t', strtotime(date('Y-m-01') . '-1 month'));
        $last_before_date = date('Y-m-01', strtotime("$sdate -1 month"));

        //トラフィック平均値データ取得
        $traffic_data12_m = $this->getAvgTraffic12M($last_year, $this_year);
        $traffic_data12_r = $this->getAvgTraffic12R($last_year, $this_year);

        $host_data = $this->getBoxPlotHostData($last_month);
        $box_plot_down_data = $this->getBoxPlotDownData($last_month);
        $box_plot_up_data = $this->getBoxPlotUpData($last_month);

        //作業予定テキスト
        $jobs = $this->getJobScheduleText($this_month . '-01', date('Y-m-t'));

        //アクティブユーザ情報取得
        $user_count_data = $this->getActiveUserCount();

        //総数アクティブユーザー数
        $active_user_count_datas = $this->getActiveUsersCount12($last_before_date, $edate);

        //最大アクティブユーザー数 LTE（月次）
        $month = date("Y-m", strtotime("- 1 month"));
        $max_active_user_count_lte_month = $this->getMaxUserCountXiMonthly($month);

        //最大アクティブユーザー数 3G（月次）
        $month = date("Y-m", strtotime("- 1 month"));
        $max_active_user_count_3g_month = $this->getMaxUserCountFomaMonthly($month);

        $pgw_data = $this->getBoxPlotPgwData($last_month);
        $place_data = $this->getBoxPlotPlaceData($last_month);

        $speed_test_pg_up_month = $this->getSpeedPgwUpMonthly($month);
        $speed_test_pg_down_month = $this->getSpeedPgwDownMonthly($month);

        $speed_test_place_up_month = $this->getSpeedPlaceUpMonthly($month);
        $speed_test_place_down_month = $this->getSpeedPlaceDownMonthly($month);

        $speed_test_server_up_month = $this->getSpeedServerUpMonthly($month);
        $speed_test_server_down_month = $this->getSpeedServerDownMonthly($month);

        $service_daily_data_new = $this->getServiceTop10_new();

        //基準値
        $plotLineValue = $this->getPlotLineValue();

        //view用パラメータ
        $data = array(
            "this_year" => get_month_y($edate),
            "last_month" => get_month_n($sdate),
            "this_month" => get_month_n($edate),
            "next_month" => get_next_month_m($edate),
            "last_before_month" => get_last_before_month_m($sdate),
            "jobs" => $jobs,
            "plotLineValue" => $plotLineValue,
            "traffic_data12_m" => $traffic_data12_m,
            "traffic_data12_r" => $traffic_data12_r,
            "active_user_count_datas" => $active_user_count_datas,
            "user_count_data" => $user_count_data,
            "host_data" => $host_data,
            "box_plot_down_data" => $box_plot_down_data,
            "box_plot_up_data" => $box_plot_up_data,
            "service_daily_data_new" => $service_daily_data_new,
            "max_active_user_count_lte_month" => $max_active_user_count_lte_month,
            "max_active_user_count_3g_month" => $max_active_user_count_3g_month,
            "speed_test_pg_up_month" => $speed_test_pg_up_month,
            "speed_test_pg_down_month" => $speed_test_pg_down_month,
            "speed_test_place_up_month" => $speed_test_place_up_month,
            "speed_test_place_down_month" => $speed_test_place_down_month,
            "speed_test_server_up_month" => $speed_test_server_up_month,
            "speed_test_server_down_month" => $speed_test_server_down_month,
            "pgw_data" => $pgw_data,
            "place_data" => $place_data,
            "colors" => array(
                '#F6CECE;',
                '#FBEFEF'
            )
        );

        $this->load->view('report/traffic_analytics', $data);
    }

    public function getMaxUserCountXiMonthly($month)
    {
        $this->load->model('Active_users_model');
        return $this->Active_users_model->get_max_user_count_let_monthly($month);
    }

    public function getMaxUserCountFomaMonthly($month)
    {
        $this->load->model('Active_users_model');
        return $this->Active_users_model->get_max_user_count_3g_monthly($month);
    }

    public function getPlotLineValue()
    {
        $this->load->model('Plot_value_model');
        return $this->Plot_value_model->get_base_value();
    }

    public function getSpeedPgwUpMonthly($month)
    {
        $this->load->model('Speed_test_model');
        $plot_arr = array();
        $rows = $this->Speed_test_model->get_box_plot_sum_up_pg($month);
        foreach ($rows as $row) {
            $plot_arr[$row->pg][] = $row->data;
        }
        return $plot_arr;
    }

    public function getSpeedPgwDownMonthly($month)
    {
        $this->load->model('Speed_test_model');
        $plot_arr = array();
        $rows = $this->Speed_test_model->get_box_plot_sum_down_pg($month);
        foreach ($rows as $row) {
            $plot_arr[$row->pg][] = $row->data;
        }
        return $plot_arr;
    }

    public function getSpeedPlaceUpMonthly($month)
    {
        $this->load->model('Speed_test_model');
        $plot_arr = array();
        $rows = $this->Speed_test_model->get_box_plot_sum_up_place($month);
        foreach ($rows as $row) {
            $plot_arr[$row->place][] = $row->data;
        }
        return $plot_arr;
    }

    public function getSpeedPlaceDownMonthly($month)
    {
        $this->load->model('Speed_test_model');
        $plot_arr = array();
        $rows = $this->Speed_test_model->get_box_plot_sum_down_place($month);
        foreach ($rows as $row) {
            $plot_arr[$row->place][] = $row->data;
        }
        return $plot_arr;
    }

    public function getSpeedServerUpMonthly($month)
    {
        $this->load->model('Speed_test_model');
        $plot_arr = array();
        $rows = $this->Speed_test_model->get_box_plot_sum_up_server($month);
        foreach ($rows as $row) {
            $plot_arr[$row->host][] = $row->data;
        }
        return $plot_arr;
    }

    public function getSpeedServerDownMonthly($month)
    {
        $this->load->model('Speed_test_model');
        $plot_arr = array();
        $rows = $this->Speed_test_model->get_box_plot_sum_down_server($month);
        foreach ($rows as $row) {
            $plot_arr[$row->host][] = $row->data;
        }
        return $plot_arr;
    }

    /**
     *　指定サービスTOP10のAllデータ取得
     */
    public function getServiceTop10_new()
    {
        $this->load->model('Traffic_top_new_model');
        $rows = $this->Traffic_top_new_model->get_top_service();

        //データ取得
        $data_arr = array();
        foreach ($rows as $val) {
            $date = $val->date;
            $service = $val->SERVICE;
            $avg_in = $val->all_traffic;

            $unixtime = $this->convertUnixtime($date);
            $data_arr[$service][] = array(
                $unixtime . '000',
                $avg_in
            );
        }

        //グラフ等データ加工
        $result = array();
        foreach ($data_arr as $service => $datas) {
            $result[] = $this->createSeries($service, SERVICE_COLOR[$service], $datas);
        }
        $result = json_encode($result, JSON_NUMERIC_CHECK);

        return $result;
    }


 /**
     *　接続者数データ取得
     */
          public function getActiveUserCount()
        {
            $date_this_y = date("Y");
            $date_last_y = date("Y", strtotime("-1 year"));
            //帯域変更履歴件数取得
            $this->load->model('Active_users_model');
            $rows = $this->Active_users_model->get_max_data_daily_new();
            $mobile_last_y = null;
            $mobile_this_y = null;

            //平均値の文字列
            foreach ($rows as $row) {
                $data_year =  explode("-", $row['date'])[0];
                if ($row['apn'] == 'mair.jp' && $data_year == $date_last_y) {
                    $mobile_last_y .= $row["number"] . ",";
                } else if($row['apn'] == 'mair.jp' && $data_year == $date_this_y){
                    $mobile_this_y .= $row["number"] . ",";
                } else if($row['apn'] == 'route7.jp' && $data_year == $date_last_y){
                    $route_last_y .= $row["number"] . ",";
                } else if($row['apn'] == 'route7.jp' && $data_year == $date_this_y){
                    $route_this_y .= $row["number"] . ",";
                }
            }

            $mobile_last_y = substr($mobile_last_y, 0, -1);
            $mobile_this_y = substr($mobile_this_y, 0, -1);
            $route_last_y = substr($route_last_y, 0, -1);
            $route_this_y = substr($route_this_y, 0, -1);

            $mobile_last_year_array = explode(",", $mobile_last_y);
            $mobile_this_year_array = explode(",", $mobile_this_y);
            $route_last_year_array = explode(",", $route_last_y);
            $route_this_year_array = explode(",", $route_this_y);

           $ary_count = count($mobile_last_year_array);
            $all_last_year_array = array();
            $all_this_year_array = array();
            for ($i = 0; $i < $ary_count; $i++){
                $total_last = $mobile_last_year_array[$i] + $route_last_year_array[$i];
                array_push($all_last_year_array, $total_last);
                if($mobile_this_year_array[$i]){
                    $total_this = $mobile_this_year_array[$i] + $route_this_year_array[$i];
                    array_push($all_this_year_array, $total_this);
                }
            }

            $mobile_data_last_year = $this->createSeries($date_last_y." 接続者数", '#ff8800', $mobile_last_year_array);
            $mobile_data_this_year = $this->createSeries($date_this_y." 接続者数", '#0099ff', $mobile_this_year_array);
            $route_data_last_year = $this->createSeries($date_last_y." 接続者数", '#ff8800', $route_last_year_array);
            $route_data_this_year = $this->createSeries($date_this_y." 接続者数", '#0099ff', $route_this_year_array);
            $all_data_last_year = $this->createSeries($date_last_y." 接続者数", '#ff8800', $all_last_year_array);
            $all_data_this_year = $this->createSeries($date_this_y." 接続者数", '#0099ff', $all_this_year_array);

            $mobile_data_arr = array(
                $mobile_data_last_year,
                $mobile_data_this_year
            );

            $route_data_arr = array(
                $route_data_last_year,
                $route_data_this_year
            );

            $all_data_arr = array(
                $all_data_last_year,
                $all_data_this_year
            );

            $result['mobile'] = json_encode($mobile_data_arr, JSON_NUMERIC_CHECK);
            $result['route'] = json_encode($route_data_arr, JSON_NUMERIC_CHECK);
            $result['all'] = json_encode($all_data_arr, JSON_NUMERIC_CHECK);

            return $result;
        }




    /**
     *　箱ひげダウンデータ取得getBoxPlotHostData
     */
    public function getBoxPlotHostData($last_month)
    {
        $plot_arr = array();
        //日別アクディブユーザー数取得
        $this->load->model('Speed_test_model');
        $rows = $this->Speed_test_model->get_box_plot_host($last_month);

        foreach ($rows as $row) {
            array_push($plot_arr, $row->host);
        }
        return $plot_arr;
    }


    /**
     *　箱ひげダウンデータ取得getBoxPlotHostData
     */
    public function getBoxPlotPgwData($last_month)
    {
        $plot_arr = array();
        //日別アクディブユーザー数取得
        $this->load->model('Speed_test_model');
        $rows = $this->Speed_test_model->get_box_plot_pgw($last_month);

        foreach ($rows as $row) {
            array_push($plot_arr, $row->pg);
        }
        return $plot_arr;
    }


    /**
     *　箱ひげダウンデータ取得getBoxPlotHostData
     */
    public function getBoxPlotPlaceData($last_month)
    {
        $plot_arr = array();
        //日別アクディブユーザー数取得
        $this->load->model('Speed_test_model');
        $rows = $this->Speed_test_model->get_box_plot_place($last_month);

        foreach ($rows as $row) {
            array_push($plot_arr, $row->place);
        }
        return $plot_arr;
    }

    /**
     *　箱ひげダウンデータ取得getBoxPlotHostData
     */
    public function getBoxPlotDownData($last_month)
    {
        $plot_arr = array();
        //日別アクディブユーザー数取得
        $this->load->model('Speed_test_model');
        $rows = $this->Speed_test_model->get_box_plot_down($last_month);

        foreach ($rows as $row) {
            $plot_arr[$row->host][$row->date][] = $row->down;
        }

        return $plot_arr;
    }

    /**
     *　箱ひげアップデータ取得
     */
    public function getBoxPlotUpData($last_month)
    {
        $plot_arr = array();

        //日別アクディブユーザー数取得
        $this->load->model('Speed_test_model');
        $rows = $this->Speed_test_model->get_box_plot_up($last_month);
        foreach ($rows as $row) {
            $plot_arr[$row->host][$row->date][] = $row->up;
        }
        return $plot_arr;
    }


    /**
     *　接続者数データ取得
     */
    public function getActiveUsersCount12($sdate, $edate)
    {
        //$day_arr = array();
        $xi_arr = array();
        $day_arr = array();

        //日別アクディブユーザー数取得
        $this->load->model('Active_users_model');
        $rows_xi = $this->Active_users_model->get_max_data_daily_12($sdate, $edate);

        //契約帯域取得
        $this->load->model('Bandwidth_model');
        $bandwidth_xis = $this->Bandwidth_model->get_data();
        foreach ($bandwidth_xis as $bandwidth_xi) {
            $xi_band = $bandwidth_xi->Xi;
        }

        foreach ($rows_xi as $value) {
            $day = $value->day;
            $cnt = $value->Xi;
            $cnt_usage = ROUND(($xi_band / $cnt / 1000));
            $day_arr[] = array(
                'date' => $day,
                'count' => $cnt_usage
            );
        }

        $result = $day_arr;

        return $result;
    }


    /**
     *　トラフィック平均値データ取得
     */
    public function getAvgTraffic12M($last_year, $this_year)
    {
        $this->load->model('materials_model');
        $rows_graph = $this->materials_model->get_daily_traffic_12_m($last_year, $this_year);

        //平均値の文字列
        foreach ($rows_graph as $graph_ary) {
            if ($graph_ary['year'] == $last_year) {
                $traffic_avg_in_last_year .= $graph_ary["a_in"] . ",";
                $traffic_avg_out_last_year .= $graph_ary["a_out"] . ",";
                $traffic_avg_in_all_last_year .= $graph_ary["a_in"] + $graph_ary["a_out"] . ",";
            }
            if ($graph_ary['year'] == $this_year) {
                $traffic_avg_in_this_year .= $graph_ary["a_in"] . ",";
                $traffic_avg_out_this_year .= $graph_ary["a_out"] . ",";
                $traffic_avg_out_all_this_year .= $graph_ary["a_in"] + $graph_ary["a_out"] . ",";
            }
        }

        $traffic_avg_in_last_year = substr($traffic_avg_in_last_year, 0, -1);
        $traffic_avg_out_last_year = substr($traffic_avg_out_last_year, 0, -1);
        $traffic_avg_in_all_last_year = substr($traffic_avg_in_all_last_year, 0, -1);
        $traffic_avg_in_this_year = substr($traffic_avg_in_this_year, 0, -1);
        $traffic_avg_out_this_year = substr($traffic_avg_out_this_year, 0, -1);
        $traffic_avg_out_all_this_year = substr($traffic_avg_out_all_this_year, 0, -1);


        $traffic_avg_in_last_year_array = explode(",", $traffic_avg_in_last_year);
        $Xi_ai_data_last_year = $this->createSeries($last_year . " AVG IN", '#ff8800', $traffic_avg_in_last_year_array);

        $traffic_avg_out_last_year_array = explode(",", $traffic_avg_out_last_year);
        $Xi_ao_data_last_year = $this->createSeries($last_year . " AVG OUT", '#ff8800', $traffic_avg_out_last_year_array);


        $traffic_avg_in_this_year_array = explode(",", $traffic_avg_in_this_year);
        $Xi_ai_data_this_year = $this->createSeries($this_year . " AVG IN", '#0099ff', $traffic_avg_in_this_year_array);

        $traffic_avg_out_this_year_array = explode(",", $traffic_avg_out_this_year);
        $Xi_ao_data_this_year = $this->createSeries($this_year . " AVG OUT", '#0099ff', $traffic_avg_out_this_year_array);

        $traffic_avg_all_last_year_array = explode(",", $traffic_avg_in_all_last_year);
        $Xi_aai_data_last_year = $this->createSeries($last_year . " AVG", '#ff8800', $traffic_avg_all_last_year_array);

        $traffic_avg_all_this_year_array = explode(",", $traffic_avg_out_all_this_year);
        $Xi_aao_data_this_year = $this->createSeries($this_year . " AVG", '#0099ff', $traffic_avg_all_this_year_array);

        $data_arr_in = array(
            $Xi_ai_data_last_year,
            $Xi_ai_data_this_year
        );
        $data_arr_out = array(
            $Xi_ao_data_last_year,
            $Xi_ao_data_this_year
        );
        $data_arr_all = array(
            $Xi_aai_data_last_year,
            $Xi_aao_data_this_year
        );


        $result['in'] = json_encode($data_arr_in, JSON_NUMERIC_CHECK);
        $result['out'] = json_encode($data_arr_out, JSON_NUMERIC_CHECK);
        $result['all'] = json_encode($data_arr_all, JSON_NUMERIC_CHECK);

        return $result;
    }

    /**
     *　トラフィック平均値データ取得
     */
    public function getAvgTraffic12R($last_year, $this_year)
    {
        $this->load->model('materials_model');
        $rows_graph = $this->materials_model->get_daily_traffic_12_r($last_year, $this_year);

        //平均値の文字列
        foreach ($rows_graph as $graph_ary) {
            if ($graph_ary['year'] == $last_year) {
                $traffic_avg_in_last_year .= $graph_ary["a_in"] . ",";
                $traffic_avg_out_last_year .= $graph_ary["a_out"] . ",";
                $traffic_avg_in_all_last_year .= $graph_ary["a_in"] + $graph_ary["a_out"] . ",";
            }
            if ($graph_ary['year'] == $this_year) {
                $traffic_avg_in_this_year .= $graph_ary["a_in"] . ",";
                $traffic_avg_out_this_year .= $graph_ary["a_out"] . ",";
                $traffic_avg_out_all_this_year .= $graph_ary["a_in"] + $graph_ary["a_out"] . ",";
            }
        }

        $traffic_avg_in_last_year = substr($traffic_avg_in_last_year, 0, -1);
        $traffic_avg_out_last_year = substr($traffic_avg_out_last_year, 0, -1);
        $traffic_avg_in_all_last_year = substr($traffic_avg_in_all_last_year, 0, -1);
        $traffic_avg_in_this_year = substr($traffic_avg_in_this_year, 0, -1);
        $traffic_avg_out_this_year = substr($traffic_avg_out_this_year, 0, -1);
        $traffic_avg_out_all_this_year = substr($traffic_avg_out_all_this_year, 0, -1);


        $traffic_avg_in_last_year_array = explode(",", $traffic_avg_in_last_year);
        $Xi_ai_data_last_year = $this->createSeries($last_year . " AVG IN", '#ff8800', $traffic_avg_in_last_year_array);

        $traffic_avg_out_last_year_array = explode(",", $traffic_avg_out_last_year);
        $Xi_ao_data_last_year = $this->createSeries($last_year . " AVG OUT", '#ff8800', $traffic_avg_out_last_year_array);


        $traffic_avg_in_this_year_array = explode(",", $traffic_avg_in_this_year);
        $Xi_ai_data_this_year = $this->createSeries($this_year . " AVG IN", '#0099ff', $traffic_avg_in_this_year_array);

        $traffic_avg_out_this_year_array = explode(",", $traffic_avg_out_this_year);
        $Xi_ao_data_this_year = $this->createSeries($this_year . " AVG OUT", '#0099ff', $traffic_avg_out_this_year_array);

        $traffic_avg_all_last_year_array = explode(",", $traffic_avg_in_all_last_year);
        $Xi_aai_data_last_year = $this->createSeries($last_year . " AVG", '#ff8800', $traffic_avg_all_last_year_array);

        $traffic_avg_all_this_year_array = explode(",", $traffic_avg_out_all_this_year);
        $Xi_aao_data_this_year = $this->createSeries($this_year . " AVG", '#0099ff', $traffic_avg_all_this_year_array);

        $data_arr_in = array(
            $Xi_ai_data_last_year,
            $Xi_ai_data_this_year
        );
        $data_arr_out = array(
            $Xi_ao_data_last_year,
            $Xi_ao_data_this_year
        );
        $data_arr_all = array(
            $Xi_aai_data_last_year,
            $Xi_aao_data_this_year
        );


        $result['in'] = json_encode($data_arr_in, JSON_NUMERIC_CHECK);
        $result['out'] = json_encode($data_arr_out, JSON_NUMERIC_CHECK);
        $result['all'] = json_encode($data_arr_all, JSON_NUMERIC_CHECK);

        return $result;
    }

    /**
     * レポート文言テキスト取得
     */
    public function getJobScheduleText($sdate, $edate)
    {
        $result = array();
        // $sdate = date('Y-m-01', strtotime("-1 month"));
        // $sdate = date('Y-m-t');

        $this->load->model('Job_schedule_text_model');
        $rows = $this->Job_schedule_text_model->get_data($sdate, $edate);

        foreach ($rows as $key => $val) {
            $id = $val['id'];
            $title = $val['title'];
            $day = $val['day'];
            $datetimes = $val['datetimes'];
            $body = $val['body'];

            $type = 1;
            if ($day < date('Y-m-01')) {
                $type = 0;
            } else {
                $type = 1;
            }

            $result[$type][$key]['title'] = $this->convertTextLine($title);
            $result[$type][$key]['body'] = $this->convertTextLine($body);
            $result[$type][$key]['day'] = (!$datetimes) ? date('n月j日', strtotime($day)) : $datetimes;
        }

        return $result;
    }


    /**
     *　改行変換機能
     */
    public function convertTextLine($str)
    {
        $order = array(
            "\r\n",
            "\n",
            "\r"
        );
        return str_replace($order, '<br />', $str);
    }


    /**
     * datetime形式をunixtimeに変換
     * @param datetime $datetime YYYY-MM-DD HH:MM:SS
     * @return unixtime $result
     */
    public function convertUnixtime($datetime)
    {
        $date = new DateTime($datetime, new DateTimeZone('UTC'));
        return $date->getTimestamp();
    }


    /**
     * グラフ用配列データ作成
     *
     * @param string $name 凡例名
     * @param string $color　指定カラー（nullの場合レンダムカラーになる）
     * @param int $zIndex グラフindex
     * @param array $data　グラフ値
     * @return array $result
     */
    public function createSeries($name = null, $color = null, $data = array(), $dashStyle = null)
    {
        $result = array();

        if (isset($name)) {
            $result['name'] = $name;
            $result['data'] = $data;
            if (isset($color)) {
                $result['color'] = $color;
            }
            if (isset($dashStyle)) {
                $result['dashStyle'] = $dashStyle;
            }

            return $result;
        } else {
            return false;
        }
    }

}
