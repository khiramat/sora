<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * スループットコントローラー
 */
class Traffic_trend extends CI_Controller
{
	public function __construct()
	{
		parent ::__construct();
		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$this -> load -> view('traffic_trend/line');
	}

	/**
	 * メイン処理
	 */
	public function line()
	{
		$this -> load -> helper('utility'); //ヘルパー
		$this -> load -> model('materials_model'); //モデル
		$this_month = get_this_month();
		$last_month = get_last_month();

// $this_month = '2020-09';
// $last_month = '2020-08';

		$sdate = get_first_date($last_month);
		$edate = get_last_date($this_month);
		$last_before_date = date('Y-m-01', strtotime("$sdate -1 month"));

		//トラフィック平均値データ取得
		$traffic_data = $this -> getAvgTraffic($sdate, $edate);

		//レポートテキスト文言取得
		$texts = $this -> getReportText();

		//アラート報告テキスト
		$alerts = $this -> getAlertText();

		//作業予定テキスト
		$jobs = $this -> getJobScheduleText($this_month.'-01', date('Y-m-t'));

		//12時の帯域使用率取得
		$bandwidth_use_rete_data = $this -> getBandwidthUserRate($last_before_date, $edate, 12, 'Xi');

		//速度測定情報取得（LTE, 12時）
 		$speed_data = $this -> getSpeedCount($last_before_date, $edate, 12, 1);

		//速度測定情報取得（LTE, 12時）
// 		$user_count_data = $this -> getActiveUserCount($sdate, $edate);

		//サービスTOP10
		$service_arr = array('Android Market', 'Google', 'HTTP', 'Instagram', 'LINE', 'SSL v3', 'Yahoo', 'YouTube', 'HTTP media stream', 'HTTP2 over TLS');
		$service_daily_data = $this -> getServiceTop10($last_before_date, $edate, $service_arr);
		$service_monthly_data = $this -> getServiceTop10Monthly($last_before_date, $edate, $service_arr);

		//速度測定結果
		$speed_graph_data = $this -> getSpeedGraph($this_month);
		$speed_monthly_data = $this -> getSpeedMonthly($last_before_date, $edate);

		//アラート受信数
		$alert_cnt_arr = $this -> getAlertCount($sdate, $edate);

		//view用パラメータ
		$data = array(
			"this_year"					=> get_month_y($edate), //先月の年
			"last_month" 				=> get_month_n($sdate), //先々月の月
			"this_month" 				=> get_month_n($edate), //先月の月
			"next_month" 				=> get_next_month_m($edate), //今月の月
			"last_before_month" 		=> get_last_before_month_m($sdate), //3ヶ月前の月
			"texts" 					=> $texts, //文言
			"alerts" 					=> $alerts, //アラートテキスト
			"jobs" 						=> $jobs, //作業予定テキスト
			"traffic_data"      		=> $traffic_data, //トラフィック平均値
			"user_count_data"      		=> $user_count_data, //接続者数
			"speed_data"				=> $speed_data, //速度測定カウント
			"speed_graph_data"			=> $speed_graph_data, //速度測定結果グラフ
			"speed_monthly_data"		=> $speed_monthly_data, //速度測定結果実データ表
			"service_arr" 				=> $service_arr, //サービス名配列
			"service_daily_data"		=> $service_daily_data, //サービスTOP10（グラフ用）
			"service_monthly_data"		=> $service_monthly_data, //サービスTOP10（実データ用）
			"bandwidth_use_rete_data"	=> $bandwidth_use_rete_data['json'], //帯域使用率
			"bandwidth_use_rete_point"	=> $bandwidth_use_rete_data['date'],
			"alert_cnt_arr"				=> $alert_cnt_arr, //アラート受信数
			"colors"					=> array('#F6CECE;', '#FBEFEF')
		);

		$this -> load -> view('report/traffic_trend', $data);
	}


	/*
	 *　指速度測定結果の月単位集計データ
	 */
	public function getSpeedMonthly($sdate, $edate)
	{
		//帯域変更日付取得（Xi限定）
		$this -> load -> model('Bandwidth_model');
		$rows = $this -> Bandwidth_model -> get_bandwidth_update_datetime($sdate, $edate);

		$bandwidths = array();
		foreach($rows as $val){
			$datetime	= $val -> datetime;
			$month 		= $val -> month;

			$bandwidths[$month] = $datetime;
		}

		$result = array();

		//集計期間配列を作成
		if (count($bandwidths) > 0) {
			//$i = 0;
			$date_arr = array();
			$sm = get_month_n($sdate);
			// $em = get_month_n($edate);

			for($i=0; $i<3; $i++){
				$m 	= sprintf('%02d', $sm);
				$sd = date("Y-m-01", strtotime($sdate));
				$ed = date("Y-m-t", strtotime($sdate));

				$date_arr['Xi'][$i] = array($sd, $ed);
				$date_arr['FOMA'][$i] = array($sd, $ed);

				if (isset($bandwidths[$m])) {
					$day 		= $bandwidths[$m];
					$y 			= date("Y", strtotime($day));
					$d 			= date("d", strtotime($day));
					$befor_day 	= date('Y-m-d', mktime(0, 0, 0, $sm, $d-1, $y));
					$sdate 		= date("Y-m-01", strtotime($day));
					$edate 		= date("Y-m-t", strtotime($day));

					unset($date_arr['Xi'][$i]);
					$date_arr['Xi'][$i][] = array($sdate, $befor_day);
					$date_arr['Xi'][$i][] = array($day, $edate);
				}

				// $sdate 	= date('Y-m-d', mktime(0, 0, 0, $sm+1, 1, $y));
				$sdate = date("Y-m-d", strtotime("$sdate +1 month")); //次月

				//12月の場合
				if($sm == 12){
					$sm = 0;
				}
				$sm++;
			}

			//集計期間ごとにデータ集計を行う
			//LTE専用(lte=1)
			$i = 0;
			foreach($date_arr['Xi'] as $key => $values){
				if(count($values[0]) > 1){ //複数の集計期間がある場合（帯域増速があった月）
					$datas = array();
					foreach($values as $val){
						$datas[] = $this -> getSpeedAvgByLte($val[0], $val[1], 1);
					}
					$arr = array();
					foreach($datas as $key => $hours){
						foreach($hours as $hour => $value){
							$arr[$hour][] = $value;
						}
					}
					foreach($arr as $key => $value){
						$result[1][$i][$key] = implode("/", $value);
						$result[1][$i]['str'] = "（減速前/減速後）";
					}
				} else { //集計期間が1個のみの場合（帯域増速がない月）
					$result[1][$i] = $this -> getSpeedAvgByLte($values[0], $values[1], 1);
					$result[1][$i]['str'] = "";
				}
				$i++;
			}

			//3G専用(lte=0)
			$i = 0;
			foreach($date_arr['FOMA'] as $key => $values){
				$result[0][$i] = $this -> getSpeedAvgByLte($values[0], $values[1], 0);
				$i++;
			}

		}
		else { //帯域更新なし
			//速度測定データ取得
			$result = $this -> getSpeedAvg($sdate, $edate);
		}

		return $result;
	}


	/*
	 * 速度測定データ取得（monthly）
	 */
	public function getSpeedAvg($sdate, $edate)
	{
		$this -> load -> model('Speed_model');
		$rows = $this -> Speed_model -> get_speed_monthly($sdate, $edate);

		$datas = array();
		$months = array();
		foreach($rows as $val){
			$lte 		= $val -> lte;
			$month	 	= $val -> month;
			$hour	 	= $val -> hour;
			$avg_down 	= $val -> avg_down;

			$datas[$lte][$month][$hour+0] = $avg_down;
		}

		//month -> index　変換
		$result = array();
		foreach($datas as $lte => $month_arr){
			$i = 0;
			foreach($month_arr as $month => $values){
				$result[$lte][$i] = $values;
				$result[$lte][$i]['str'] = "";
				$i++;
			}
		}

		return $result;
	}
	public function getSpeedAvgByLte($sdate, $edate, $lte)
	{
		$this -> load -> model('Speed_model');
		$rows = $this -> Speed_model -> get_speed_monthly_by_lte($sdate, $edate, $lte);

		$result = array();
		foreach($rows as $val){
			$hour	 	= $val -> hour;
			$avg_down 	= $val -> avg_down;

			$result[$hour+0] = $avg_down;
		}

		return $result;
	}


	/**
	 *速度測定グラフ用データ取得
	 *
	 * @param string sdate, edate
	 * @return json result
	 */
	 public function getSpeedGraph($Ym)
	 {
		 $this -> load -> model('speed_model');
		 $rows = $this -> speed_model -> get_speed_by_month($Ym);

		 //データ取得
		 $result = array();
		 $max_arr = array();

		 foreach($rows as $val){
			 $datetime 	= $val -> DAYTIME;
			 $unixtime 	= $val -> UNIXTIME;
			 $hour 		= $val -> HOUR;
			 $day 		= $val -> DAY;
			 $lte 		= $val -> lte;
			 $down 		= $val -> DOWN;

			 //y軸最大値取得用配列
			 $max_arr[$lte][$unixtime] = $down;

			 //グラフ用データ
			 $unixtime = $this -> convertUnixtime($day);
			 $result['down'][$lte][$hour][] = array($unixtime.'000', $down);
			 //$result['down'][$lte][$hour][] = array($unixtime.'000', round($down));
		 }

		 //グラフ用配列の再配置
		 $datas = array();
		 foreach($result['down'] as $lte => $hour_arr){
			 foreach($hour_arr as $hour => $values){
				 $datas[$lte][$hour][] = $this -> createSeries(PIPE_CODE[$lte]['name'], PIPE_CODE[$lte]['color'], $values);
			 }
		 }


		 //JSONに変換
		 $maxs = array();
		 $json_arr = array();
		 foreach($datas as $lte => $hour_arr){
			 foreach($hour_arr as $hour => $values){
				 $json_arr[$lte][$hour] = json_encode($values, JSON_NUMERIC_CHECK);
			 }
			 $maxs[$lte] = round(max($max_arr[$lte])) + 2;
		 }
		 unset($datas);

		 $result = array();
		 $result['tickInterval_y'] = array(2, 10);
		 $result['max'] = $maxs;
		 $result['json'] = $json_arr;
		 unset($json_arr);

		 return $result;
	 }



	/*
	 *　指定サービスTOP10のAllデータ取得
	 */
	public function getServiceTop10($sdate, $edate, $service_arr)
	{
		$this -> load -> model('Traffic_top_model');
		$rows = $this -> Traffic_top_model -> get_data_daily_by_service($sdate, $edate, $service_arr);

		//データ取得
		$data_arr = array();
		foreach($rows as $val){
			$date 		= $val -> date;
			$service 	= $val -> SERVICE;
			$avg_in 	= $val -> avg_in;

			$unixtime = $this -> convertUnixtime($date);
			$data_arr[$service][] = array($unixtime.'000', $avg_in);
		}

		//グラフ等データ加工
		$result = array();
		foreach($data_arr as $service => $datas){
			$result[] = $this -> createSeries($service, SERVICE_COLOR[$service], $datas);
		}
		$result = json_encode($result, JSON_NUMERIC_CHECK);

		return $result;
	}



	/*
	 *　指定サービスTOP10のAllデータ取得
	 */
	public function getServiceTop10Monthly($sdate, $edate, $service_arr)
	{
		$this -> load -> model('Traffic_top_model');
		$rows = $this -> Traffic_top_model -> get_data_monthly_by_service($sdate, $edate, $service_arr);

		//Totalデータ追加
		$datas = array();
		$total_arr = $this -> getServiceTop10MonthlyAll($sdate, $edate, $service_arr);
		$datas['Total'] = $total_arr;

		//データ取得
		foreach($rows as $val){
			$month 		= substr($val -> month, -2) + 0;
			$service 	= $val -> SERVICE;
			$avg_in 	= $val -> avg_in;
			$min_in 	= $val -> min_in;
			$max_in 	= $val -> max_in;

			$datas[$month]['Avg'][$service] = $avg_in;
			$datas[$month]['Max'][$service] = $max_in;
			$datas[$month]['Min'][$service] = $min_in;

		}
		//ksort($datas);

		//再ソート
		$result = array();
		foreach($service_arr as $value){
			foreach($datas as $month => $values){
				foreach($values as $key => $service_arr){
					foreach($service_arr as $service => $val){
						if($value == $service){
							$result[$month][$key][$value] = $datas[$month][$key][$service];
						}
					}
				}
			}
		}
		unset($datas);

		return $result;
	}


	/*
	 *　指定サービスTOP10のAllデータ取得
	 */
	public function getServiceTop10MonthlyAll($sdate, $edate, $service_arr)
	{
		$this -> load -> model('Traffic_top_model');
		$rows = $this -> Traffic_top_model -> get_data_all_by_service($sdate, $edate, $service_arr);

		//データ取得
		$result = array();
		foreach($rows as $val){
			$service 	= $val -> SERVICE;
			$avg_in 	= $val -> avg_in;
			$min_in 	= $val -> min_in;
			$max_in 	= $val -> max_in;

			$result['Avg'][$service] = $avg_in;
			$result['Max'][$service] = $max_in;
			$result['Min'][$service] = $min_in;

		}

		return $result;
	}



	/*
	 *　接続者数データ取得
	 */
/*	public function getActiveUserCount($sdate, $edate)
	{
		//$day_arr = array();
		$xi_arr 	= array();
		$foma_arr 	= array();
		$total_arr 	= array();
		$day_arr 	= array();

		//帯域変更履歴件数取得
		$this -> load -> model('Active_user_model');
		$rows_xi = $this -> Active_user_model -> get_max_data_daily($sdate, $edate, 'Xi');
		$rows_foma = $this -> Active_user_model -> get_max_data_daily($sdate, $edate, 'FOMA');
		$rows_total = $this -> Active_user_model -> get_max_data_daily($sdate, $edate, 'Xi+FOMA');

		//Xi
		$i = 0;
		foreach($rows_xi as $value){
			$day = $value -> day;
			$cnt = $value -> cnt;

			$j = date('j', strtotime($day));
			$t = date('t', strtotime($day));
			$nj = date('n/j', strtotime($day));

			if($j == 1):
				$day_arr['xi'][$i] = array('date' => $nj, 'count' => $cnt);
				$i++;
			elseif($j == 15):
				$day_arr['xi'][$i] = array('date' => $nj, 'count' => $cnt);
				$i++;
			elseif($j == $t):
				$day_arr['xi'][$i] = array('date' => $nj, 'count' => $cnt);
				$i++;
			endif;

			array_push($xi_arr, $cnt);
		}

		//FOMA
		$i = 0;
		foreach($rows_foma as $value){
			$day = $value -> day;
			$cnt = $value -> cnt;

			$j = date('j', strtotime($day));
			$t = date('t', strtotime($day));
			$nj = date('n/j', strtotime($day));

			if($j == 1):
				$day_arr['foma'][$i] = array('date' => $nj, 'count' => $cnt);
				$i++;
			elseif($j == 15):
				$day_arr['foma'][$i] = array('date' => $nj, 'count' => $cnt);
				$i++;
			elseif($j == $t):
				$day_arr['foma'][$i] = array('date' => $nj, 'count' => $cnt);
				$i++;
			endif;

			array_push($foma_arr, $cnt);
		}

		//total
		foreach($rows_total as $value){
			$cnt = $value -> cnt;
			array_push($total_arr, $cnt);
		}

		$data_arr = array(
			'Xi' => $xi_arr,
			'FOMA' => $foma_arr,
			'total' => $total_arr
		);

		//フォーキャストデータ取得
		$f_data = $this -> getForecast($sdate, $edate, $data_arr);

		$xi 		= $this->createSeries("LTE", '#0099ff', $xi_arr);
		$foma 		= $this->createSeries("3G", '#cc0000', $foma_arr);
		$total 		= $this->createSeries("ALL", '#00cc00', $total_arr);
		$f_Xi 		= $this->createSeries("線形（LTE）", '#0099ff', $f_data['Xi'], 'Dot');
		$f_FOMA 	= $this->createSeries("線形（3G）", '#cc0000', $f_data['FOMA'], 'Dot');
		$f_total 	= $this->createSeries("線形（ALL）", '#00cc00', $f_data['total'], 'Dot');
		$data_arr = array($xi, $foma, $total, $f_Xi, $f_FOMA, $f_total);

		$result['table'] = $day_arr;
		$result['json'] = json_encode($data_arr, JSON_NUMERIC_CHECK);

		return $result;
	}*/


	/*
	 *　トラフィック平均値データ取得
	 */
	public function getAvgTraffic($sdate, $edate)
	{
		$this -> load -> model('materials_model');
		$rows_graph = $this -> materials_model -> get_daily_traffic($sdate." 00:00:00", $edate." 23:59:59");
		//$rows_graph = $this -> materials_model -> get_daily_traffic($sdate." 00:00:00", get_this_month_end());

		//平均値の文字列
		foreach($rows_graph as $graph_ary){
			@${$graph_ary["PIPE"] . "_m"} .= $graph_ary["tm_in"] . ",";
		}

		//合計データ算出
		$Xi_m = substr($Xi_m, 0 , -1);
		$FOMA_m = substr($FOMA_m, 0 , -1);
		//配列に変換
		$Xi_ary    = explode(",", $Xi_m);
		$FOMA_ary  = explode(",", $FOMA_m);

		//ALLトラフィック取得
		$i = 0;
		$total_ary = array();
		while($i < count($Xi_ary)){
			$total_ary[$i] = (int) $Xi_ary[$i] + (int) $FOMA_ary[$i];
			$i++;
		}
		$total = implode(",", $total_ary);

		$data_arr = array(
			'Xi' => $Xi_ary,
			'FOMA' => $FOMA_ary,
			'total' => $total_ary
		);

		//フォーキャストデータ取得
		$f_data = $this -> getForecast($sdate, $edate, $data_arr);

		//グラフ用jsonデータ作成
		$Xi 		= $this->createSeries("LTE", '#0099ff', $Xi_ary);
		$FOMA 		= $this->createSeries("3G", '#cc0000', $FOMA_ary);
		$total 		= $this->createSeries("ALL", '#00cc00', $total_ary);
		$f_Xi 		= $this->createSeries("線形（LTE）", '#0099ff', $f_data['Xi'], 'Dot');
		$f_FOMA 	= $this->createSeries("線形（3G）", '#cc0000', $f_data['FOMA'], 'Dot');
		$f_total 	= $this->createSeries("線形（ALL）", '#00cc00', $f_data['total'], 'Dot');

		$data_arr = array($Xi, $FOMA, $total, $f_Xi, $f_FOMA, $f_total);
		$result = json_encode($data_arr, JSON_NUMERIC_CHECK);

		return $result;
	}


	/*
	 * フォーキャストデータ取得
	 */
	public function getForecast($sdate, $edate, $data_arr)
	{
		// 日数計算
		//$year                   = date("Y");
		// $this_month_date_num    = date('t', mktime(0, 0, 0, get_this_month_n(), 1, $year));
		// $last_month_date_num    = date('t', mktime(0, 0, 0, get_last_month_n(), 1, $year));
		$next_month_date_num 	=  date("t", strtotime("$edate +1 month"));
		$this_month_date_num    = date('t', strtotime($edate));
		$last_month_date_num    = date('t', strtotime($sdate));

		$forecast_date_base_num = $this_month_date_num + $last_month_date_num;
		$forecast_date_num      = $forecast_date_base_num + $next_month_date_num;

		// 実データ日にち配列生成
		$i = 0;
		$date_num_ary = array();
		while($i < $forecast_date_base_num){
			@$date_num_ary[$i] = $i;
			$i++;
		}

		// フォーキャストデータ日にち配列生成
		$i = 3;
		$forecast_x_ary = array();
		while($i < $forecast_date_num){
			@$forecast_x_ary[$i] = $i;
			$i++;
		}

		//Xi FOMA Total forecast値取得
		$forecast_xi_ary    = array(null, null);
		$forecast_foma_ary 	= array(null, null);
		$forecast_total_ary = array(null, null);

		foreach($forecast_x_ary as $val){
			$f_xi		= $this -> s_forecast($val, $data_arr['Xi'], $date_num_ary);
			$f_3g		= $this -> s_forecast($val, $data_arr['FOMA'], $date_num_ary);
			$f_total	= $this -> s_forecast($val, $data_arr['total'], $date_num_ary);
			array_push($forecast_xi_ary, round($f_xi, 0));
			array_push($forecast_foma_ary, round($f_3g, 0));
			array_push($forecast_total_ary, round($f_total, 0));
		}

		$result = array(
			'Xi' 		=> $forecast_xi_ary,
			'FOMA' 		=> $forecast_foma_ary,
			'total' 	=> $forecast_total_ary
		);

		return $result;
	}



	public function month_diff()
	{
		$this -> load -> helper('utility'); //ヘルパー
		$this -> load -> model('materials_model'); //モデル
		$this_month = get_this_month();
		$last_month = get_last_month();

		//先月のデータ取得
		$rows_this = $this -> materials_model -> get_max_traffic($this_month, $last_month);

		//データ加工
		$graph_data_ary = array();
		foreach($rows_this as $graph_ary){
			@${$graph_ary["PIPE"] . $graph_ary["target_month"] . "m"} .= $graph_ary["tm_in"] . ",";
			@${$graph_ary["PIPE"] . $graph_ary["target_month"] . "a"} .= $graph_ary["ta_in"] . ",";
		}

		// View に渡す配列を生成
		$pipe_ary    = array("Xi", "FOMA");
		$month_ary   = array($last_month, $this_month);
		$max_avg_ary = array("m", "a");
		foreach($pipe_ary as $pipe){
			foreach($month_ary as $month){
				foreach($max_avg_ary as $max_avg){
					$graph_data_ary += array($pipe . $month . $max_avg => @${$pipe . $month . $max_avg});
				}
			}
		}
		$this -> load -> view('report/month_diff', $graph_data_ary);
	}


	/**
	 * 回帰直線上でｘに対応するｙを求める
	 *
	 * @param int      $target_x 凡例名
	 * @param int      $list_y
	 * @param unixtime $list_x
	 * @return array $result
	 *
	 */

	public function s_forecast($target_x, $list_y, $list_x)
	{
		$result = false;
		if(count($list_x) < 2 || count($list_y) < 2 || count($list_x) != count($list_y)){
			return $result;
		}
		$a      = $this -> s_slope($list_y, $list_x);
		$b      = $this -> s_intercept($list_y, $list_x);
		$result = $a * $target_x + $b;

		return $result;
	}

	/**
	 * 回帰直線の傾きを求める
	 * （[y = a * x + b]の[a]を求める）
	 */
	function s_slope($list_y, $list_x)
	{
		if(count($list_x) < 2 || count($list_y) < 2 || count($list_x) != count($list_y)){
			return false;
		}

		$x_sum  = 0;
		$y_sum  = 0;
		$xx_sum = 0;
		$xy_sum = 0;

		$count = count($list_x);
		for($i = 0; $i < $count; $i++){
			$x      = $list_x[$i];
			$y      = $list_y[$i];
			$x_sum  += $x;
			$y_sum  += $y;
			$xx_sum += $x * $x;
			$xy_sum += $x * $y;
		}
		$a = ($count * $xy_sum - $x_sum * $y_sum) / ($count * $xx_sum - $x_sum * $x_sum);
		$b = ($y_sum - $a * $x_sum) / $count;

		return $a;
	}


	/**
	 * 回帰直線のｙ切片を求める
	 * （[y = a * x + b]の[b]を求める）
	 */
	function s_intercept($list_y, $list_x)
	{
		if(count($list_x) < 2 || count($list_y) < 2 || count($list_x) != count($list_y)){
			return false;
		}

		$x_sum  = 0;
		$y_sum  = 0;
		$xx_sum = 0;
		$xy_sum = 0;

		$count = count($list_x);
		for($i = 0; $i < $count; $i++){
			$x      = $list_x[$i];
			$y      = $list_y[$i];
			$x_sum  += $x;
			$y_sum  += $y;
			$xx_sum += $x * $x;
			$xy_sum += $x * $y;
		}
		$a = ($count * $xy_sum - $x_sum * $y_sum) / ($count * $xx_sum - $x_sum * $x_sum);
		$b = ($y_sum - $a * $x_sum) / $count;

		return $b;
	}


	/*
	 * レポート文言テキスト取得
	 */
	public function getReportText()
	{
		$result = array();
		$this -> load -> model('Report_text_model');
		$rows = $this -> Report_text_model -> get_data();

		foreach($rows as $key => $val){
			$id = $val['id'];
			$body = $val['body'];
			//$result[$id]['title'] = $val['title'];
			$result[$id]['body'] = $this -> convertTextLine($body);
		}

		return $result;
	}


	/*
	 * レポート文言テキスト取得
	 */
	public function getJobScheduleText($sdate, $edate)
	{
		$result = array();
		// $sdate = date('Y-m-01', strtotime("-1 month"));
		// $sdate = date('Y-m-t');

		$this -> load -> model('Job_schedule_text_model');
		$rows = $this -> Job_schedule_text_model -> get_data($sdate, $edate);

		foreach($rows as $key => $val){
			$id 		= $val['id'];
			$title 		= $val['title'];
			$day 		= $val['day'];
			$datetimes 	= $val['datetimes'];
			$body 		= $val['body'];

			$type = 1;
			if($day < date('Y-m-01')){
				$type = 0;
			}else{
				$type = 1;
			}

			$result[$type][$key]['title'] 	= $this -> convertTextLine($title);
			$result[$type][$key]['body'] 	= $this -> convertTextLine($body);
			$result[$type][$key]['day'] 	= (!$datetimes) ? date('n月j日', strtotime($day)) : $datetimes;
		}

		return $result;
	}


	/*
	 * アラート報告テキスト取得
	 */
	public function getAlertText()
	{
		$datas = array();
		$result = array();
		$this -> load -> model('Alert_text_model');
		$rows = $this -> Alert_text_model -> get_data();

		//データ取得
		foreach($rows as $key => $val){
			$page 			= $val['page'];
			$type 			= $val['type'];
			$hostname 		= $val['hostname'];
			$datetimes 		= $val['datetimes'];
			$service_flg 	= $val['service_flg'];
			$body 			= $val['body'];
			$cause 			= $val['cause'];

			//発生原加工
			$hostname_arr = explode(",", $hostname);
			$hostnames = array();
			foreach($hostname_arr as $val){
				$hostnames[] = nl2br(ALERT_HOSTNAME_ARR[$this -> convertTextLine($val)]);
			}

			$datas[$page][$key]['type'] 			= nl2br(ALERT_TYPE_ARR[$this -> convertTextLine($type)]);
			$datas[$page][$key]['hostname'] 		= implode("<br>", $hostnames);
			$datas[$page][$key]['datetimes'] 		= $this -> convertTextLine($datetimes);
			$datas[$page][$key]['service_flg'] 		= EXISTENCE_ARR[$this -> convertTextLine($service_flg)];
			$datas[$page][$key]['body'] 			= $this -> convertTextLine($body);
			$datas[$page][$key]['cause'] 			= $this -> convertTextLine($cause);
		}

		//配列再ソート
		foreach($datas as $page => $pages){
			$i = 0;
			foreach($pages as $value){
				$result[$page][$i] = $value;
				$i++;
			}
		}

		return $result;
	}


	/*
	 *　改行変換機能
	 */
	public function convertTextLine($str){
		$order = array("\r\n", "\n", "\r");
		return str_replace($order, '<br />', $str);
	}


	/*
	 * 速度測定データ取得（LTE, 12時）
	 */
	public function getSpeedCount($sdate, $edate, $hour, $lte)
	{

		$categories = array('1Mbps未満', '1Mbps~1.5Mbps', '1.5Mbps~2Mbps', '2Mbps~2.5Mbps', '2.5Mbps~3Mbps', '3Mbps~3.5Mbps', '3.5Mbps~4Mbps', '4Mbps以上');
		$result = array();
		$result['categories'] = json_encode($categories);

		$this -> load -> model('Speed_model');
		$rows = $this -> Speed_model -> get_data_by_time_lte($sdate, $edate, $hour, $lte);

		$data_arr = array();
		foreach($rows as $key => $val){
			$month 	= $val -> month;
			$day 	= $val -> day;
			$down 	= $val -> DOWN;

			$data_arr[$month+0][$day] = $down;
		}

		//速度測定値カウント配列作成
		$j = 0;
		foreach($data_arr as $month => $days){
			//count配列の初期設定
			$counts = array();
			for($i=0; $i<8; $i++){
				$counts[$i] = 0;
			}

			//count値取得
			foreach($days as $day => $down){
				if ($down < 1): //red
					$counts[0]++;
				elseif ($down  >= 1 && $down < 1.5): //red
					$counts[1]++;
				elseif ($down  >= 1.5 && $down < 2): //red
					$counts[2]++;
				elseif ($down  >= 2 && $down < 2.5): //orange
					$counts[3]++;
				elseif ($down  >= 2.5 && $down < 3): //yellow
					$counts[4]++;
				elseif ($down  >= 3 && $down < 3.5): //yellow
					$counts[5]++;
				elseif ($down  >= 3.5 && $down < 4): //yellow
					$counts[6]++;
				else: //green
					$counts[7]++;
				endif;
			}

			//count値格納
			$red_arr 		= array($counts[0], $counts[1], $counts[2], 0, 0, 0, 0, 0);
			$orange_arr 	= array(0, 0, 0, $counts[3], 0, 0, 0, 0);
			$yellow_arr 	= array(0, 0, 0, 0, $counts[4], $counts[5], $counts[6], 0);
			$green_arr 		= array(0, 0, 0, 0, 0, 0, 0, $counts[7]);

			//グラフ用jsonデータ作成
			$red 	= $this->createSeries("red", '#FF0000', $red_arr);
			$orange = $this->createSeries("orange", '#FF8000', $orange_arr);
			$yellow = $this->createSeries("yellow", '#FFBF00', $yellow_arr);
			$green 	= $this->createSeries("green", '#31B404', $green_arr);
			$json_arr = array($red, $orange, $yellow, $green);

			$result['json'][$j] = json_encode($json_arr, JSON_NUMERIC_CHECK);
			$j++;
		}
        unset($counts, $data_arr, $json_arr); //初期化

		return $result;
	}


	/*
	 * 指定時間の帯域使用率取得
	 */
	public function getBandwidthUserRate($sdate, $edate, $hour, $pipe)
	{
		$this -> load -> model('Traffic_model');
		$rows = $this -> Traffic_model -> get_avg_traffic_by_pipe($sdate, $edate, $hour, $pipe);

		//帯域情報取得
		$bandwidths = $this -> getBandwith($sdate, $edate);

		$datas = array();
		foreach($rows as $value){
			//$Xi   		= $value -> Xi;
			$ym	 		= $value['ym'];
			$month	 	= $value['month'];
			$date 		= $value['date'];
			$avg_in 	= $value['avg_in'];

			$datas[$ym][$date] = round(($avg_in/$bandwidths[$month][$date])*100, 0);
		}
		ksort($datas);

		//highchart形式配列作成
		$result = array();
		$date_arr = array();
		foreach($datas as $ym => $dates){
			foreach($dates as $key => $val){
				//$unixtime = $this -> convertUnixtime($key);
				//$result[$month][] = array($unixtime.'000', $val);
				$month = substr($ym, -2) + 0; //月のみ切り取り、intに変換
				$result[$month][] = $val;
			}
			$date_arr[] = date('Y-m-01', strtotime($key));
		}

		//JSONに変換
		$i = 0;
		$datas = array();
		$json_arr = array();
		foreach($result as $key => $value){
			$datas[$key]['name']  = '帯域使用率'; //凡例名
			$datas[$key]['color'] = '#FF0000'; //カラー番号
			$datas[$key]['data']  = $value; //値

			$json_arr[$i] = json_encode($datas[$key], JSON_NUMERIC_CHECK);
			$i++;
		}

		$result = array();
		$result['json'] = $json_arr;
		$result['date'] = $date_arr;

		return $result;
	}


	/**
	 * 帯域データ取得(Xi専用)
	 */
	public function getBandwith($sdate, $edate)
	{
		$result = array();
		$all_bandwidth = array();
		$bandwidth_arr = array();
		$this -> load -> model('Bandwidth_model');

		//帯域変更履歴件数取得
		$cnt = $this -> Bandwidth_model -> get_bandwidth_count($sdate, $edate);

		//帯域情報取得
		$rows = $this -> Bandwidth_model -> get_bandwidth($edate, $cnt+1);

		foreach($rows as $key => $val){
			//$FOMA 		= $val -> FOMA;
			$Xi   		= $val -> Xi;
			$month	 	= $val -> month;
			$datetime 	= $val -> datetime;
			$unixtime 	= $val -> unixtime;

			$month += 0; //int変換
			//$bandwidth_arr[$month][$unixtime] = $Xi; //帯域
			$bandwidth_arr[$month]['unixtime'] 	= $unixtime; //unixtime
			$bandwidth_arr[$month]['bandwidth'] = $Xi; //帯域
			$bandwidth_arr[$month][$unixtime] 	= $Xi; //帯域
			$all_bandwidth_arr[$unixtime] 		= $Xi;
		}

		//最小帯域値(初期値)
		$key = min(array_keys($all_bandwidth_arr));
		$bandwidth = $all_bandwidth_arr[$key];
		//asort($all_bandwidth_arr);

		//月のみ
		$sm = date('n', strtotime($sdate));
		$em = date('n', strtotime($edate));

		$date = $sdate;
		for($i=0; $i<3; $i++){ //月単位
			$sdate = get_first_date($date); //月初
			$edate = get_last_date($date); //月末

			//unixtimeに変換
	        $su = $this -> convertUnixtime($sdate);
	        $eu = $this -> convertUnixtime($edate);

			//集計範囲により1日単位のデータ作成
			for($unixtime=$su; $unixtime<=$eu; $unixtime+=86400){
				$bandwidth = (isset($bandwidth_arr[$sm][$unixtime])) ? $bandwidth_arr[$sm][$unixtime] : $bandwidth;
				$datetime = $this -> convertDatetime($unixtime);

				//帯域・閾値の配列作成
				$result[$sm][$datetime] = $bandwidth;
			}

			$date = date("Y-m-d", strtotime("$date +1 month")); //次月
			if($sm == 12){
				$sm = 0;
			}
			$sm++;
		}

		return $result;
	}


	/**
     * datetime形式をunixtimeに変換
     * @param datetime $datetime YYYY-MM-DD HH:MM:SS
     * @return unixtime $result
    */
    public function convertUnixtime($datetime){
        $date = new DateTime($datetime, new DateTimeZone('UTC'));
        return $date -> getTimestamp();
    }


	/**
	* unixtime形式をフォーマット変更
	*
	* @param unixtime $unixtime
	* @return string $result
	*/
	public function convertDatetime($unixtime){
		$date = new DateTime();
		//$date->setTimestamp($unixtime-32400);
		$date->setTimestamp($unixtime);
		$date = $date->format("Y-m-d");
		return $date;
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
	public function createSeries($name=null, $color=null, $data=array(), $dashStyle=null)
	{
		$result = array();

		if(isset($name)){
			$result['name'] = $name;
			$result['data'] = $data;
			if(isset($color)){
				$result['color'] = $color;
			}
			if(isset($dashStyle)){
				$result['dashStyle'] = $dashStyle;
			}

			return $result;
		} else {
			return false;
		}
	}


	/*
	 * アラート受信数
	 */
	public function getAlertCount($sdate, $edate)
	{
		$this -> load -> model('Alert_count_model');
		$rows = $this -> Alert_count_model -> get_data($sdate, $edate);

		$result = array();
		foreach($rows as $key => $val){
			$result[$key] = $val['cnt'];
		}

		return $result;
	}


}
