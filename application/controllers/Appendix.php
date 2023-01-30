<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 別紙レポートコントローラー
 */
class Appendix extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this -> output -> enable_profiler(TRUE);
	}

	public function index()
	{
		$this->load->view('appendix/line');
	}

	/**
	 * メイン処理
	 */
	public function line()
	{
		$this -> load -> helper('utility'); //ヘルパー
		$this -> load -> model('Materials_model'); //モデル
		$this_month = get_this_month();
		$last_month = get_last_month();

//	 $this_month = '2020-09';
//	 $last_month = '2020-08';

		$sdate = get_first_date($last_month);
		$edate = get_last_date($this_month);

		//先月のデータ取得
		$rows_this = $this -> Materials_model -> get_every_hour($this_month);

		//データ加工(グラフ用)
		$graph_data_ary = array();
		foreach ($rows_this as $graph_ary_this) {
			@${"this_m_" . $graph_ary_this["PIPE"] . "_" . $graph_ary_this["time"]} .= $graph_ary_this["tm_in"] . ",";
			@${"this_a_" . $graph_ary_this["PIPE"] . "_" . $graph_ary_this["time"]} .= $graph_ary_this["ta_in"] . ",";
		}
		//先々月データ取得
		$rows_last = $this -> Materials_model -> get_every_hour($last_month);

		foreach ($rows_last as $graph_ary_last) {
			@${"last_m_" . $graph_ary_last["PIPE"] . "_" . $graph_ary_last["time"]} .= $graph_ary_last["tm_in"] . ",";
			@${"last_a_" . $graph_ary_last["PIPE"] . "_" . $graph_ary_last["time"]} .= $graph_ary_last["ta_in"] . ",";
		}

		$month_ary = array("this", "last");
		$pipe_ary  = array("Xi", "FOMA");
		$hour_ary  = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
		$max_avg_ary   = array("m", "a");

		foreach ($month_ary as $month) {
			foreach ($pipe_ary as $pipe) {
				foreach ($hour_ary as $hour) {
					foreach ($max_avg_ary as $max_avg) {
						$graph_data_ary += array($month . "_" . $max_avg . "_" . $pipe . "_" . $hour => @${$month . "_" . $max_avg . "_" . $pipe . "_" . $hour});
					}
				}
			}
		}

		//アクセスユーザ数の時間配列
		$active_user_time_arr = array('0'=>'2:00', '3'=>'6:00', '7'=>'9:00', '10'=>'12:00', '13'=>'15:00', '16'=>'18:00', '19'=>'22:00', '23'=>'');

		//帯域情報取得
		$bandwidth_arr = $this -> getBandwith($sdate, $edate);

		//文言作成
		$strs 			= array('減速前', '減速後');
		$update_date 	= $bandwidth_arr[count($bandwidth_arr)-1]['datetime'];
		$n 				= date('n', strtotime($update_date));
		$sd 			= array(date('n月１日', strtotime($update_date)), date('n月j日', strtotime($update_date)));
		$ed 			= array(date('n月j日', strtotime("-1 day", strtotime($update_date))), date('n月t日', strtotime($update_date)));

		//帯域更新日を区切りにしデータ集計を分ける
		//帯域更新があった場合、最大２件まである
		$week_date 	= array();
		$tb_data  	= array();
		$title_arr 	= array();
		$str_arr 	= array();

		//Xi, FOMAごとに処理
		foreach($bandwidth_arr[0]['update_flg'] as $pipe => $val){
			$this -> load -> model('Traffic_model'); //モデル
			if($val == 1){ //帯域更新があった場合
				foreach($bandwidth_arr as $key => $value){
					$title_arr[$pipe][$key] = "(" . $strs[$key] . ")";
					$str_arr[$pipe][$key] 	= "なお、本ページに掲載している".$n."月のデータは".$sd[$key]."〜".$ed[$key]."(".$strs[$key].")の値を使用しております。";
					//曜日ごとの日付
					$sdate_arr = $value['sdate'];
					$edate_arr = $value['edate'];
					$week_date[$pipe][$key] = $this -> getDateGroupByWeek($sdate_arr, $edate_arr);
					$user_count[$pipe][$key] = $this -> getActiveUserCount($sdate_arr, $edate_arr, $pipe);
					//実データ作成
					$rows = $this -> Traffic_model -> get_traffic_weekly_by_pipe($sdate_arr, $edate_arr, $pipe);
					//$tb_data[$pipe][$key] = $this -> getTrafficData($rows, $bandwidth_arr[$key], $pipe, $key);
					//array_push($tb_data, $this -> getTrafficData($rows, $bandwidth_arr[$key], $pipe, $key));

					$rows = $this -> getTrafficData($rows, $bandwidth_arr, $pipe, $key);

					foreach($rows as $key2 => $value2){
						foreach($value2 as $key3 => $value3){
							if($pipe==$key2 && $key==$key3){
								$tb_data[$pipe][$key] = $value3;
							}
						}
					}
					unset($rows);
				}
			} else { //帯域更新なしの場合
				$key = 0;
				$title_arr[$pipe][$key] = '';
				$str_arr[$pipe][$key] 	= '';
				//曜日ごとの日付
				$sdate_arr = array($sdate);
				$edate_arr = array($edate);
				$week_date[$pipe][$key] = $this -> getDateGroupByWeek($sdate_arr, $edate_arr);
				$user_count[$pipe][$key] = $this -> getActiveUserCount($sdate_arr, $edate_arr, $pipe);
				//実データ作成
				$rows = $this -> Traffic_model -> get_traffic_weekly_by_pipe($sdate_arr, $edate_arr, $pipe);
				//$tb_data[$pipe][$key] = $this -> getTrafficData($rows, $bandwidth_arr[$key], $pipe, $key);

				$rows = $this -> getTrafficData($rows, $bandwidth_arr, $pipe, $key);
				foreach($rows as $key2 => $value2){
					foreach($value2 as $key3 => $value3){
						if($pipe==$key2 && $key==$key3){
							$tb_data[$pipe][$key] = $value3;
						}
					}
				}
				unset($rows);
			}
		}

		//view用パラメータ
		$graph_data_ary['month_ary'] 	= $month_ary;
		$graph_data_ary['pipe_ary'] 	= $pipe_ary;
		$graph_data_ary['hour_ary'] 	= $hour_ary;
		$graph_data_ary['max_avg_ary'] 	= $max_avg_ary;
		$graph_data_ary['week_date'] 	= $week_date; //曜日ごとの日付
		$graph_data_ary['user_count'] 	= $user_count; //アクセスユーザ数
		$graph_data_ary['tb_data'] 		= $tb_data; //テーブル表データ
		$graph_data_ary['title_arr'] 	= $title_arr; //タイトル
		$graph_data_ary['str_arr'] 		= $str_arr; //文言
		$graph_data_ary['this_month'] 	= get_month_n($edate); //凡例名称用(先月)
		$graph_data_ary['last_month'] 	= get_month_n($sdate); //凡例名称用(先々月)

		$this->load->view('report/appendix', $graph_data_ary);
	}


	/**
	 * データ加工
	 */
	public function getTrafficData($rows, $bandwidth_arr, $pipe, $key)
	{
		$result = array();

		foreach($rows as $value){
			$pipe 	= $value['PIPE'];
			$month 	= $value['month'];
			$week 	= $value['week'];
			$time 	= $value['time']+0;
			$max_in = $value['max_in'];
			$avg_in = $value['avg_in'];
			$date 	= date('Y-m-d', strtotime($value['date']));

			//帯域
			$bandwidth = $bandwidth_arr[$key][$pipe];
			//帯域変更がある場合
			if(count($bandwidth_arr) > 1){
				$bandwidth = ($date < $bandwidth_arr[1]['datetime']) ? $bandwidth_arr[0][$pipe] : $bandwidth_arr[1][$pipe];
			}

			//帯域使用率
			$max_bandwidth = round($max_in/$bandwidth*100, 0);
			$avg_bandwidth = round($avg_in/$bandwidth*100, 0);

			$result[$pipe][$key]['max'][$time][$week][$month] = array($max_in, $max_bandwidth);
			$result[$pipe][$key]['avg'][$time][$week][$month] = array($avg_in, $avg_bandwidth);
		}

		return $result;
	}


	/**
	 * 帯域データ取得
	 * 更新履歴は２ヶ月間、最大１件までが前提！
	 */
	public function getBandwith($sdate, $edate)
	{
		$result = array();
		$this -> load -> model('Bandwidth_model');

		//帯域変更履歴件数取得
		$cnt = $this -> Bandwidth_model -> get_bandwidth_count($sdate, $edate);

		//帯域情報取得
		$rows = $this -> Bandwidth_model -> get_bandwidth($edate, $cnt+1);
		foreach($rows as $key => $val){
			$Xi   		= $val -> Xi;
			$FOMA 		= $val -> FOMA;
			$datetime 	= $val -> datetime;
			//$unixtime 	= $val -> unixtime;

			$result[$key]['Xi'] 		= $Xi;
			$result[$key]['FOMA'] 		= $FOMA;
			$result[$key]['datetime'] 	= $datetime;
			$result[$key]['sdate'][0] 	= $sdate;
			$result[$key]['edate'][0] 	= $edate;
		}

		//初期値
		$result[0]['update_flg']['Xi'] 	= 0;
		$result[0]['update_flg']['FOMA'] = 0;
		$result[0]['sdate'][0] = $sdate;
		$result[0]['sdate'][1] = get_first_date($edate);
		$result[0]['edate'][0] = get_last_date($sdate);
		$result[0]['edate'][1] = $edate;

		//指定期間の間、更新があった場合（更新件数は最大１件が前提）
		if($cnt > 0){
			$last_month = date('Y-m', strtotime($sdate));
			$this_month = date('Y-m', strtotime($edate));

			$update_date 	= strtotime($result[0]['datetime']); //更新日
			$update_day 	= date('d', $update_date);
			$last_day 		= date('d', strtotime("-1 day", $update_date)); //更新日-1day(日単位集計のため)

			$last_month_edate = $last_month."-".$last_day;
			$this_month_edate = $this_month."-".$last_day;
			$last_month_sdate = $last_month."-".$update_day;
			$this_month_sdate = $this_month."-".$update_day; //$result[0]['datetime']

			//各月の集計期間(更新前)
			$result[1]['sdate'][0] = $sdate;
			$result[1]['sdate'][1] = get_first_date($this_month_edate);
			$result[1]['edate'][0] = $last_month_edate;
			$result[1]['edate'][1] = $this_month_edate;

			//各月の集計期間(更新後)
			$result[0]['sdate'][0] = $last_month_sdate;
			$result[0]['sdate'][1] = $this_month_sdate;
			$result[0]['edate'][0] = get_last_date($last_month_sdate);
			$result[0]['edate'][1] = $edate;

			//更新日付順に再ソート
			foreach ($result as $key => $value) {
				$sort[$key] = $value['datetime'];
			}
			array_multisort($sort, SORT_ASC, $result);

			//更新データ有無フラグ（更新件数は最大１件が前提）
			$result[0]['update_flg']['Xi']  = ($result[0]['Xi'] == $result[1]['Xi']) ? 0 : 1;
			$result[0]['update_flg']['FOMA'] = ($result[0]['FOMA'] == $result[1]['FOMA']) ? 0 : 1;
		}

		return $result;
	}


	/**
	 * アクセスユーザ数取得
	 */
	public function getActiveUserCount($sdate_arr, $edate_arr, $pipe)
	{
		$str = '';
		$result = array();
		$data_arr = array();

		$this -> load -> model('Active_user_model');

		$rows = $this -> Active_user_model -> get_data($sdate_arr, $edate_arr);
		foreach($rows as $key => $val){
			$datetime 	= $val -> datetime;
			$user_count = $val -> $pipe;
			$result[$datetime] = $user_count;
		}

		foreach($result as $datetime => $value){
			$n = date('n', strtotime($datetime)); //月（1〜12）
			$w = date('w', strtotime($datetime)); //曜日（0 (日曜)〜 6 (土曜)）
			$j = date('j', strtotime($datetime)); //日(1〜31)
			$G = date('G', strtotime($datetime)); //時。24時間単位。(0〜23)
			$data_arr[$n][$w][$G][] = $j . ": " . $value;
		}

		$result = array();
		foreach($data_arr as $n => $weeks){
			foreach($weeks as $w => $hours){
				foreach($hours as $G => $value){
					$str = implode("<br>", $value);
					$result[$n][$w][$G] = "<b>{$G}:00</b><br>{$str}<br>";
				}
			}
		}

		return $result;
	}


	/**
	 * 曜日ごと日付取得
	 */
	public function getDateGroupByWeek($sdate_arr, $edate_arr)
	{
		$datas 		= array();
		$result 	= array();

		foreach($sdate_arr as $key => $val){
			$sdate 		= strtotime($sdate_arr[$key]);
			$edate 		= strtotime($edate_arr[$key]);
			$date 		= $sdate;

			while($date <= $edate){
			   $n = date('n', $date);
			   $w = date('w', $date);
			   $j = date('j', $date);
			   $datas[$n][$w][] = $j;

			   $date = strtotime("+1 day", $date);
			}

			foreach($datas as $n => $weeks){
				foreach($weeks as $w => $value){
					$str = implode(",", $value);
					$result[$n][$w] = $n."/".$str;
				}
			}
		} //foreach($sdate_arr as $key => $val)の END

		return $result;
	}


}
