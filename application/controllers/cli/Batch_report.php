<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Batch_report extends CI_Controller{

	/**
	 * Tweet情報
	 * 毎日定時に実行する。
	 */
	public function get_speed_test_results(){
		$this -> load -> model('speed_test_model');
		$today = date();
		$target_month = date("Y-m", strtotime("$today -1 month"));
		$file_path = '/home/ec2-user/SR*/'.$target_month.'*';

		foreach(glob($file_path) as $file){
			if(is_file($file)){
				$fp = gzopen($file, 'r');
				while(!feof($fp)){
					$json = fgets($fp);
					$speed_test = json_decode($json, true);
					if($speed_test['timestamp']){
						$datetime_ary = explode('T', $speed_test['timestamp']);
						$datetime = $datetime_ary[0].' '.substr($datetime_ary[1], 0, -1);
						$results[] = [
							'datetime' => $datetime,
							'down'     => $speed_test['download']['bandwidth'],
							'up'       => $speed_test['upload']['bandwidth'],
							'host'     => $speed_test['hostname']
						];
						//print_r($results)."\n";
					}
				}
			}
		}
		$this -> speed_test_model -> put_into_the_table($results);
	}


	/**
	 * Tweet情報
	 * 毎日定時に実行する。
	 */
	public function get_active_user_results(){
		ini_set("memory_limit", "8G");
		$this -> load -> model('Active_users_model');
		$today = date();
		//$target_month = date("Ym", strtotime("$today -1 month"));
		//$file_path = '/home/ec2-user/bulkstats/sessions_vpc*'.$target_month.'*';
		$file_path = '/home/ec2-user/bulkstats/sessions_vpc*';

		foreach(glob($file_path) as $file){
			$file_name_ary = explode('/', $file);
			$file_name = explode('_', $file_name_ary[4]);
			$vpc = $file_name[1];
			$f = fopen($file, "r");
			while($line = fgetcsv($f)){
				if( $line[1] == '3g.mair.jp' || $line[1] == 'lte.mair.jp' || $line[1] == '3g.route7.jp' || $line[1] == 'lte.route7.jp'){
					$recorded_datetime_ary = explode("-", $line[0]);
					$date = substr($recorded_datetime_ary[0],0,4).'-'.substr($recorded_datetime_ary[0],4,2).'-'.substr($recorded_datetime_ary[0],6,2);
					$time = substr($recorded_datetime_ary[1],0,2).';'.substr($recorded_datetime_ary[1],2,2).':'.substr($recorded_datetime_ary[1],4,2);
					$recorded_datetime = $date. ' '.$time;
					$results[] = [
						'recorded_datetime' => $recorded_datetime,
						'vpc'     => $vpc,
						'apn'       => $line[1],
						'number'     =>$line[2],
					];
				}
			}
			fclose($f);
		}
		$this -> Active_users_model -> put_into_the_table($results);
	}

    /**
     * トップ10新規インサート
     * 毎日定時に実行する。
     */
    public function top_10_service_clear(){
        $this -> load -> model('Traffic_top_new_model');
        $this -> Traffic_top_new_model -> edit_service_top();
    }

}
