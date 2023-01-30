<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once 'Abstract_model.php';

/**
 * SUBSCRIBER用モデル
 */
class Speed_model extends CI_Model {

	protected $table_name = 't_speed';

	/**
	 * コンストラクタ
	 */
	public function __construct()
	{
		// table name
		parent::__construct($this->table_name);
	}

	/**
	 * 該当テーブに、データを挿入する
	 * @param string $tenant_id
	 */
	public function put_into_the_table(array $data)
	{
		$this->insert($data);
	}

	/**
	 * @desc 3ヵ月以前のデータを削除する。
	 */
	public function delete_the_periode()
	{
		$before_3_months = date("Y-m-d 00:00:00", strtotime("-3 Months")); // 3 months ago precise
		$this->delete(array('DATETIME<' => $before_3_months)); // 3ヵ月以前のレコードは全部削除
	}


	/**
	 * allデータ取得
	 * @param string sdata, edata
	 * @return array
	 */
	public function get_date(string $sdate, string $edate)
	{
		$sql = "SELECT
					DAYTIME, DOWN, lte
                FROM
					t_speed
                WHERE
					DAYTIME between '$sdate 00:00:00' and '$edate 23:59:59'
                ORDER BY
					DAYTIME, lte; ";

		$query = $this->db->query($sql);
		return $query->result();
	}


	/**
	 * 指定時間のみのデータ取得
	 * @param string sdata, edata, hour
	 * @param int lte
	 * @return array
	 */
	public function get_data_by_time_lte(string $sdate, string $edate, string $hour, int $lte)
	{
		$sql = "SELECT
					DATE_FORMAT(DAYTIME, '%m')as month,
					DATE_FORMAT(DAYTIME, '%Y-%m-%d')as day,
					DOWN
				FROM
					t_speed
				WHERE
					DAYTIME between '$sdate 00:00:00' and '$edate 23:59:59' AND
					lte = '$lte' AND
					DATE_FORMAT(DAYTIME, '%H') = '$hour'
				ORDER BY
					DAYTIME, lte; ";

		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 折り線グラフ用データ取得
	 * @param string edata
	 * @return array result rows
	 */
	public function get_speed_by_month(string $Ym)
	{
		$sql = "SELECT
					unix_timestamp(DAYTIME)+32400 as UNIXTIME,
					DAYTIME,
					DATE_FORMAT(DAYTIME, '%k:%i') as HOUR,
					DATE_FORMAT(DAYTIME, '%Y-%m-%d') as DAY,
					lte,
					DOWN
				FROM
					t_speed
				WHERE
					DATE_FORMAT(DAYTIME, '%Y-%m') = '$Ym'
				ORDER BY
					lte,
					DATE_FORMAT(DAYTIME, '%Y-%m-%d'),
					DATE_FORMAT(DAYTIME, '%H')
				;";
		$query = $this -> db -> query($sql);

		return $query -> result();
	}


	/**
	 * 実データ用データ取得
	 * @param string sdate, edata
	 * @return array result rows
	 */
	public function get_speed_monthly(string $sdate, string $edate)
	{
		$sql = "SELECT
					lte,
					DATE_FORMAT(DAYTIME, '%m') as month,
					DATE_FORMAT(DAYTIME, '%H') as hour,
					TRUNCATE((AVG(DOWN * 1000000) / 1000000) + .005, 2) as avg_down
				FROM
					t_speed
				WHERE
					DAYTIME between '$sdate 00:00:00' and '$edate 23:59:59'
				GROUP BY
					lte,
					DATE_FORMAT(DAYTIME, '%m'),
					DATE_FORMAT(DAYTIME, '%H')
				ORDER BY
					lte,
					DATE_FORMAT(DAYTIME, '%m'),
					DATE_FORMAT(DAYTIME, '%H');
				";

		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 実データ用データ取得
	 * 1ヶ月単位前提
	 * @param string sdate, edata
	 * @return array result rows
	 */
	public function get_speed_monthly_by_lte(string $sdate, string $edate, int $lte)
	{
		$sql = "SELECT
					DATE_FORMAT(DAYTIME, '%H') as hour,
					TRUNCATE((AVG(DOWN * 1000000) / 1000000) + .005, 2) as avg_down
				FROM
					t_speed
				WHERE
					lte = $lte AND
					DAYTIME between '$sdate 00:00:00' and '$edate 23:59:59'
				GROUP BY
					DATE_FORMAT(DAYTIME, '%H')
				ORDER BY
					DATE_FORMAT(DAYTIME, '%H');
				";

		$query = $this -> db -> query($sql);
		return $query -> result();
	}

	/**
	 * データ登録
	 */
	function uploadData($data)
	{
		//$this -> db -> truncate('t_speed');
		$result = array();
		foreach($data as $key => $val){
			$result[$key] = array(
				'DAYTIME'   => $val['DAYTIME'],
				'DOWN' 		=> $val['DOWN'],
				'UP' 		=> $val['UP'],
				'lte' 		=> $val['lte']
			);
		}

		//return $this -> db -> insert_batch('t_speed', $result);
		if($this -> db -> insert_batch('t_speed', $result)){
			return true;
		}else{
			return false;
		}
	}

}
