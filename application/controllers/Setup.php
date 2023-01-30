<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * データ登録フォーム
 */
class Setup extends CI_Controller
{
	public function __construct()
	{
		parent ::__construct();
	}

	public function index()
	{
		$this -> load -> helper('form');
	}


	/**
	 * 帯域情報登録
	 */
	public function bandwidth()
	{
		$this -> load -> helper("form");
		$this -> load -> model('Bandwidth_model');

		$data = array();
		$data["message"] = "";
		$data["datas"] = $this -> Bandwidth_model -> get_data();

		$this -> load -> view("setup/bandwidth", $data);
	}

	// バリデーション
	public function base_value_update()
	{
		$base_value = $this -> input -> post('base_value', true);
		$this -> load -> model('Plot_value_model');
			$this -> Plot_value_model -> update_base_value($base_value);
		$base_value["message"] = "基準値が登録されました。";
			$this -> load -> view("setup/base_value_result", $base_value);
	}

	function base_value()
	{
		$result = array(
			'message' 		=> "",
			'table_name' 	=> MENU_NAME_ARR
		);

		$this -> load -> view('setup/base_value', $result);
	}

	// バリデーション
	public function bandwidth_valid()
	{
		$this -> load -> library("form_validation");
		$this -> load -> model('Bandwidth_model');
		$this -> form_validation -> set_rules("xi", "Xi", "trim|required|numeric");
		$this -> form_validation -> set_rules("foma", "FOMA", "trim|required|numeric");

		if($this -> form_validation -> run() == false){  //バリデーションエラーの場合は、以下の処理を行なう
			$data["message"] = "";
			$this -> load -> view('setup/bandwidth', $data);
		} else { //バリデーションエラーのない場合は、以下の処理を行なう
			$year  	= $this -> input -> post('year', true);
			$month 	= $this -> input -> post('month', true);
			$day   	= $this -> input -> post('day', true);
			$DAY   	= $year . "-" . $month . "-" . $day;
			$xi  	= $this -> input -> post('xi', true);
			$foma	= $this -> input -> post('foma', true);

			$data = array(
				'datetime'		=> $DAY,
				'Xi'    		=> $xi,
				'FOMA'  		=> $foma,
				'flag'			=> 1,
				'record_date'	=> date("Y/m/d H:i:s")
			);

			$this -> Bandwidth_model -> insert_data($data);
			$data["message"] = "帯域データが登録されました。";
			$this -> load -> view("setup/bandwidth_result", $data);
		}
	}


	/**
	 * 帯域設定履歴画面
	 */
	function bandwidth_list($msg='')
	{
		$this -> load -> helper("form");
		$this -> load -> model('Bandwidth_model');

		$rows = $this -> Bandwidth_model -> get_data(100);

		$result = array();
		foreach($rows as $key => $val){
			$result[$key]['Xi'] 			= $val->Xi;
			$result[$key]['FOMA'] 			= $val->FOMA;
			$result[$key]['datetime'] 		= $val->datetime;
		}

		$message = ($msg) ? MSG_ARR[$msg] : '';
		$data = array(
			'message' 		=> $message,
			'datas'			=> $result
		);

		$this -> load -> view('setup/bandwidth_list', $data);
	}

	function bandwidth_delete()
	{
		$this -> load -> library("form_validation");
		$this -> load -> model('Bandwidth_model');
		$this -> form_validation -> set_rules("datetime", "日付", "required|callback__check_dropdown_value");

		if($this -> form_validation -> run() == false){  //バリデーションエラーの場合は、以下の処理を行なう
			$data["message"] = "";
			$this -> load -> view('setup/bandwidth_list', $data);
		} else {
			$datetime = $this -> input -> post('datetime', true);
			$data = array(
				'datetime' => $datetime
			);

			$msg = ($this -> Bandwidth_model -> delete_data($data)) ? 4 : 5;
			redirect('/setup/bandwidth_list/'.$msg);
		}
	}

	function upload()
	{
		$result = array(
			'message' 		=> "",
			'table_name' 	=> MENU_NAME_ARR
		);

		$this -> load -> view('setup/upload', $result);
	}

	function upload_result()
	{
		$this -> load -> view('setup/upload_result');
	}

	function do_upload()
	{
		$result_arr = array('失敗', '完了');
		$table_name = $this -> input -> post('table_name', true);
		$_POST['userfile'] = $_FILES['userfile']['tmp_name'];
		$this -> form_validation -> set_rules("table_name", "対象データ", "required|callback__check_dropdown_value");
		$this -> form_validation -> set_rules("userfile", "対象CSVファイル", "required|callback__check_csv_upload");

		if($this -> form_validation -> run() == false){  //バリデーションエラーの場合は、以下の処理を行なう
			$data = array(
				'message' 		=> "",
				'table_name' 	=> MENU_NAME_ARR
			);
			$this -> load -> view('setup/upload', $data);
		}else{
			switch ($table_name){
				case "t_speed":
					$menu_name = '速度測定';
					$item_arr = array(
						'DAYTIME',
						'DOWN',
						'UP',
						'lte'
					);

					$data = $this -> import_csv($item_arr);
					$this -> load -> model('Speed_model');
					$result = $this -> Speed_model -> uploadData($data);
					unset($data);
					$data['message'] = $menu_name."データ登録が".$result_arr[$result]."しました。";
					$this -> load -> view('setup/upload_result', $data);
					break;

				case "t_active_user":
					$menu_name = 'アクティブユーザ';
					$item_arr = array(
						'datetime',
						'Xi',
						'FOMA'
					);

					$data = $this -> import_csv($item_arr);
					$this -> load -> model('Active_user_model');
					$result = $this -> Active_user_model -> uploadData($data);
					unset($data);
					$data['message'] = $menu_name."データ登録が".$result_arr[$result]."しました。";
					$this -> load -> view('setup/upload_result', $data);
					break;

				default:
					$data = array(
						'message' 		=> "※対象データを選択してください。",
						'table_name' 	=> MENU_NAME_ARR
					);
					$this -> load -> view('setup/upload', $data);
			}
		}

		//redirect('setup/upload_result');
	}

	/**
	 * CSV読み込み
	 */
	function import_csv($item_arr){
		$i = 0;
		$result = array();
		$fp = fopen($_FILES['userfile']['tmp_name'], 'r') or die("can't open file");

		while($csv = fgetcsv($fp, 1024)){
			$j = 0;
			$record = array();
			foreach($item_arr as $val){
				$record[$val] = $csv[$j];
				$j++;
			}
			$result[$i] = $record;
			$i++;
		}

		return $result;
	}


	/**
	 * 月次報告書 文言登録フォーム
	 */
	function form()
	{
		$data 				= array();
		$data['message'] 	= "";
		$data['title'] 		= $this -> get_form_title();

		$this -> load -> helper("form");
		$this -> load -> view('setup/form', $data);
	}

	function form_valid()
	{
		$this -> load -> library("form_validation");
		$this -> load -> model('Report_text_model');
		$this -> form_validation -> set_rules("body", "本文", "trim|required");

		if($this -> form_validation -> run() == false){  //バリデーションエラーの場合は、以下の処理を行なう
			$data["message"] = "";
			$data['title'] = $this -> get_form_title();
			$this -> load -> view('setup/form', $data);

		} else {              //バリデーションエラーのない場合は、以下の処理を行なう
			$body 	= $this -> input -> post('body', true);
			$title	= $this -> input -> post('title', true);

			$data = array(
	                'body' => $body
	        );

			$result = array();
			if($this -> Report_text_model -> update_report_text($data, $title)){
				$result["message"] = MSG_ARR[2];
			}else{
				$result["message"] = MSG_ARR[3];
			}

			$this -> load -> view("setup/form_result", $result);
		}
	}


	/**
	 * 月次報告書 文言のタイトル取得
	 */
	function get_form_title(){
		$this -> load -> model('Report_text_model');
		$result = $this -> Report_text_model -> get_data();

		foreach($result as $val){
			$id = $val['id'];
			$title = $val['title'];
			$data[$id] = $title;
		}

		return $data;
	}


	/**
	 * 月次報告書 作業報告情報フォーム
	 */
	function work()
	{
		$this -> load -> helper("form");

		$data = array();
		$data['message'] = "";
		$data['datas'] = [
			'id' => 0,
			'day' => '',
			'datetimes' => '',
			'title' => '',
			'body' => ''
		];

		$id	= $this -> input -> post('id', true);
		if($id > 0){
			$this -> load -> model('Job_schedule_text_model');
			$rows = $this -> Job_schedule_text_model -> get_data_by_id($id);
			$data['datas'] = $rows[0];
		}

		$this -> load -> view('setup/work', $data);
	}

	function work_valid()
	{
		$this -> load -> library("form_validation");
		$this -> load -> model('Job_schedule_text_model');
		$this -> form_validation -> set_rules("title", "タイトル", "trim|required");
		$this -> form_validation -> set_rules("body", "作業内容", "trim|required");

		if($this -> form_validation -> run() == false){  //バリデーションエラーの場合は、以下の処理を行なう
			$data["message"] = "";
			$data['datas'] = [
				'id' => 0,
				'day' => '',
				'datetimes' => '',
				'title' => '',
				'body' => ''
			];
			$this -> load -> view('setup/work', $data);

		} else {              //バリデーションエラーのない場合は、以下の処理を行なう
			$id			= $this -> input -> post('id', true);
			$title		= $this -> input -> post('title', true);
			$body	 	= $this -> input -> post('body', true);
			$datetimes	= $this -> input -> post('datetimes', true);
			$year       = $this -> input -> post('from_year', true);
			$month      = $this -> input -> post('from_month', true);
			$day        = $this -> input -> post('from_day', true);
			$FROM_DAY	= $year . "-" . $month . "-" . $day;

			$data = array(
				'day' 		=> $FROM_DAY,
				'datetimes' => $datetimes,
				'title' 	=> $title,
				'body' 		=> $body
			);

			$result = array();
			if($id > 0){
				if($this -> Job_schedule_text_model -> update_set_id($data, $id)){
					$result["message"] = MSG_ARR[2];
				}else{
					$result["message"] = MSG_ARR[3];
				}
			}else{
				if($this -> Job_schedule_text_model -> insert_job_schedule_data($data)){
					$result["message"] = MSG_ARR[0];
				}else{
					$result["message"] = MSG_ARR[1];
				}
			}

			$this -> load -> view("setup/work_result", $result);
		}
	}

	/**
	 * 作業報告一覧画面
	 */
	function work_list($msg='')
	{
		$this -> load -> helper("form");
		$this -> load -> model('Job_schedule_text_model');

		$rows 		= $this -> Job_schedule_text_model -> get_data_all();
		$message 	= ($msg) ? MSG_ARR[$msg] : '';

		$data = array(
			'message' 		=> $message,
			'datas'			=> $rows
		);

		$this -> load -> view('setup/work_list', $data);
	}

	function work_delete()
	{
		$this -> load -> library("form_validation");
		$this -> load -> model('Job_schedule_text_model');
		$this -> form_validation -> set_rules("id", "ID", "required|callback__check_dropdown_value");

		if($this -> form_validation -> run() == false){  //バリデーションエラーの場合は、以下の処理を行なう
			$data["message"] = "";
			$data['datas'] = [
				'id' => 0,
				'day' => '',
				'datetimes' => '',
				'title' => '',
				'body' => ''
			];
			$this -> load -> view('setup/work_list', $data);
		} else {
			$id	= $this -> input -> post('id', true);
			$data = array(
				'id' => $id
			);

			$msg = ($this -> Job_schedule_text_model -> delete_data($data)) ? 4 : 5;
			redirect('/setup/work_list/'.$msg);
		}
	}



	/**
	 * アラート受信件数登録
	 */
	function cnt()
	{
		$data['message'] = "";
		$this -> load -> helper("form");
		$this -> load -> view('setup/cnt', $data);
	}

	function cnt_valid()
	{
		$this -> load -> library("form_validation");
		$this -> load -> model('Alert_count_model');
		$this -> form_validation -> set_rules("cnt", "件数", "required|numeric");


		if($this -> form_validation -> run() == false){  //バリデーションエラーの場合は、以下の処理を行なう
			$data["message"] = "";
			$this -> load -> view('setup/cnt', $data);

		} else { //バリデーションエラーのない場合は、以下の処理を行なう
			$cnt		= $this -> input -> post('cnt', true);
			$year       = $this -> input -> post('from_year', true);
			$month      = $this -> input -> post('from_month', true);
			$FROM_DAY	= $year . "-" . $month . "-01";

			$data = array(
				'day' 	=> $FROM_DAY,
				'cnt' 	=> $cnt
			);

			$result = array();
			if($this -> Alert_count_model -> insert_alert_count_data($data)){
				$result["message"] = MSG_ARR[0];
			}else{
				$result["message"] = MSG_ARR[1];
			}

			$this -> load -> view("setup/cnt_result", $result);
		}
	}


	/**
	 * 月次報告書 アラート報告情報フォーム
	 */
	function alert()
	{
		$data = array(
			'message' 		=> '',
			'type' 			=> ALERT_TYPE_ARR,
			'hostname' 		=> ALERT_HOSTNAME_ARR,
			'service_flg' 	=> EXISTENCE_ARR,
			'selecteds'		=> array()
		);

		$this -> load -> helper("form");
		$this -> load -> view('setup/alert', $data);
	}

	function alert_valid()
	{
		$this -> load -> library("form_validation");
		$this -> load -> model('Alert_text_model');
		$this -> form_validation -> set_rules("type", "アラート種別", "required|callback__check_dropdown_value");
		$this -> form_validation -> set_rules("hostname[]", "発生源", "required|callback__check_dropdown_value");
		$this -> form_validation -> set_rules("cause", "発生原因", "trim|required");
		$this -> form_validation -> set_rules("body", "アラート内容", "trim|required");
		$this -> form_validation -> set_rules("datetimes", "発生日時", "trim|required");


		if($this -> form_validation -> run() == false){  //バリデーションエラーの場合は、以下の処理を行なう
			$data = array(
				'message' 		=> '',
				'type' 			=> ALERT_TYPE_ARR,
				'hostname' 		=> ALERT_HOSTNAME_ARR,
				'service_flg' 	=> EXISTENCE_ARR,
				'selecteds'		=> $this -> input -> post('hostname')
			);
			// $hostname		= $this -> input -> post('hostname');
			// // foreach(){
			// //
			// // }
			// print_r($hostname);
			$this -> load -> view('setup/alert', $data);

		} else { //バリデーションエラー のない場合は、以下の処理を行なう
			$page			= $this -> input -> post('page', true);
			$type			= $this -> input -> post('type', true);
			$hostname		= $this -> input -> post('hostname');
			$service_flg	= $this -> input -> post('service_flg', true);
			$cause			= $this -> input -> post('cause', true);
			$body	 		= $this -> input -> post('body', true);
			$datetimes		= $this -> input -> post('datetimes', true);

			$data = array(
				'page' 			=> $page,
				'type' 			=> $type,
				'datetimes' 	=> $datetimes,
				'hostname' 		=> implode(",", $hostname),
				'service_flg' 	=> $service_flg,
				'cause' 		=> $cause,
				'body' 			=> $body,
				'datetimes' 	=> $datetimes
			);

			$result = array();
			if($this -> Alert_text_model -> insert_data($data)){
				$result["message"] = MSG_ARR[0];
			}else{
				$result["message"] = MSG_ARR[1];
			}

			$this -> load -> view("setup/alert_result", $result);
		}
	}

	//プルダウン選択可否確認
	public function _check_dropdown_value($id){
		if(!$id){
			$this -> form_validation -> set_message('_check_dropdown_value', '{field}を選択してください。');
			return FALSE;
		}
		return TRUE;
	}

	//ファイル添付可否確認
	public function _check_csv_upload($id){
		if(!$id){
			$this -> form_validation -> set_message('_check_csv_upload', '{field}を選択してください。');
			return FALSE;
		}
		return TRUE;
	}


	/**
	 * 月次報告書一覧
	 */
	function alert_list($msg='')
	{
		$this -> load -> helper("form");
		$this -> load -> model('Alert_text_model');

		$rows = $this -> Alert_text_model -> get_data();

		$result = array();
		foreach($rows as $key => $val){
			$result[$key]['id'] 			= $val['id'];
			$result[$key]['page'] 			= $val['page'];
			$result[$key]['type'] 			= $val['type'];
			$result[$key]['datetimes'] 		= $val['datetimes'];
			$result[$key]['service_flg'] 	= $val['service_flg'];
			$result[$key]['body'] 			= $val['body'];
			$result[$key]['cause'] 			= $val['cause'];

			//発生原加工
			$hostname_arr = explode(",", $val['hostname']);
			$hostnames = array();
			foreach($hostname_arr as $val){
				$result[$key]['hostname'][] = nl2br(ALERT_HOSTNAME_ARR[$this -> convertTextLine($val)]);
			}
		}

		$message = ($msg) ? MSG_ARR[$msg] : '';
		$data = array(
			'message' 		=> $message,
			//'type' 			=> ALERT_TYPE_ARR,
			//'hostname' 		=> ALERT_HOSTNAME_ARR,
			//'service_flg' 	=> EXISTENCE_ARR,
			'datas'			=> $result
		);

		$this -> load -> view('setup/alert_list', $data);
	}

	function alert_delete()
	{
		$this -> load -> library("form_validation");
		$this -> load -> model('Alert_text_model');
		$this -> form_validation -> set_rules("id", "アラート報告", "required|callback__check_dropdown_value");

		if($this -> form_validation -> run() == false){  //バリデーションエラーの場合は、以下の処理を行なう
			$data["message"] = "";
			$this -> load -> view('setup/alert_list', $data);
		} else {
			$id = $this -> input -> post('id', true);
			$data = array(
				'id' => $id
			);

			$msg = ($this -> Alert_text_model -> delete_data($data)) ? 4 : 5;
			redirect('/setup/alert_list/'.$msg);
		}
	}

	/*
	 *　改行変換機能
	 */
	public function convertTextLine($str){
		$order = array("\r\n", "\n", "\r");
		return str_replace($order, '<br />', $str);
	}


}
