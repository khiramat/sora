<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once 'Abstract_model.php';

/**
 * Traffic用モデル
 */
class Active_users_model extends CI_Model {

    protected $table_name = 't_active_users';

	/**
	 * 該当テーブに、データを挿入する
	 * @param array $data
	 */
	public function put_into_the_table(array $data){
		//$this -> db -> insert('t_speed_test', $data);
		//print_r($data);
		//$this -> db -> insert_batch('t_active_users', $data);
		foreach($data as $key => $record){
			$insert_query = $this->db->insert_string('t_active_users', $record );
			$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
			$this->db->query($insert_query);
		}
	}
	/**
	 * /**
	 * 指定項目の最大値取得（Daily単位）
	 * @param date sdate, edate
	 */
	public function get_max_data_daily_12($sdate, $edate)
	{
		$sql = "
SELECT 
	day, 
	ROUND(SUM(number)) AS Xi
FROM
	(SELECT SUBSTRING(`recorded_datetime`,1, 10) AS day, `vpc`,`apn`, AVG(`number`) AS number
	FROM t_active_users
	WHERE SUBSTRING(`recorded_datetime`,12, 2)  = '12'
	AND `apn` IN  ('3g.mair.jp','lte.mair.jp','3g.route7.jp','lte.route7.jp')
	AND `recorded_datetime` between '$sdate 00:00:00' and '$edate 23:59:59'
	GROUP BY `vpc`,`apn`, SUBSTRING(`recorded_datetime`,1, 10) ) AS AVG
GROUP BY day
ORDER BY day
            ";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}

	/**
	 * /**
	 * 指定項目の最大値取得（Daily単位）
	 * @param date sdate, edate
	 */
	public function get_max_data_daily_new()
	{
		$sql = "
SELECT 
		date, 
    ROUND(SUM(number)) AS number,
    SUBSTRING(apn,LOCATE('.',apn)+1,LENGTH(apn)) AS apn
FROM
(SELECT SUBSTRING(`recorded_datetime`,1, 10) AS date, `vpc`,`apn`, AVG(`number`) AS number
FROM t_active_users
WHERE SUBSTRING(`recorded_datetime`,12, 2)  = '12'
AND `apn` IN  ('3g.mair.jp','lte.mair.jp','3g.route7.jp','lte.route7.jp')
GROUP BY `vpc`,`apn`, SUBSTRING(`recorded_datetime`,1, 10) ) AS AVG
GROUP BY SUBSTRING(apn,LOCATE('.',apn)+1,LENGTH(apn)) ,date
ORDER BY date
";
		$query = $this -> db -> query($sql);
		return $query -> result('array');
	}

	/**
	 * /**
	 * 指定項目の最大値取得（Daily単位）
	 * @param date sdate, edate
	 */
	public function get_max_data_daily_all()
	{
		$sql = "
SELECT 
		date, 
    ROUND(SUM(number)) AS number
FROM
(SELECT SUBSTRING(`recorded_datetime`,1, 10) AS date, `vpc`,`apn`, AVG(`number`) AS number
FROM t_active_users
WHERE SUBSTRING(`recorded_datetime`,12, 2)  = '12'
AND `apn` IN  ('3g.mair.jp','lte.mair.jp','3g.route7.jp','lte.route7.jp')
GROUP BY `vpc`,`apn`, SUBSTRING(`recorded_datetime`,1, 10) ) AS AVG
GROUP BY date
ORDER BY date
";
		$query = $this -> db -> query($sql);
		return $query -> result('array');
	}

	/**
	 * /**
	 * 指定項目の最大値取得（Daily単位）
	 * @param date sdate, edate
	 */
	public function get_max_user_count_let_monthly($month)
	{
		$sql = "
SELECT SUM(number) AS Xi
FROM t_active_users
WHERE `recorded_datetime` LIKE '$month%'
AND `apn` IN  ('lte.mair.jp','lte.route7.jp')
GROUP BY `recorded_datetime`, LEFT(`apn`,3)
ORDER BY SUM(number) DESC
LIMIT 1
            ";
		$query = $this -> db -> query($sql);

		return $query -> result();
	}

	/**
	 * /**
	 * 指定項目の最大値取得（Daily単位）
	 * @param date sdate, edate
	 */
	public function get_max_user_count_3g_monthly($month)
	{
		$sql = "
SELECT SUM(number) AS FOMA
FROM t_active_users
WHERE `recorded_datetime` LIKE '$month%'
AND `apn` IN  ('3g.mair.jp','3g.route7.jp')
GROUP BY `recorded_datetime`, LEFT(`apn`,2)
ORDER BY SUM(number) DESC
LIMIT 1
            ";
		$query = $this -> db -> query($sql);

		return $query -> result();
	}

}
