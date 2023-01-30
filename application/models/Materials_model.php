<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once 'Abstract_model.php';

/**
 * VS File upload
 */
class materials_model extends CI_Model
{
	function __construct()
	{
		parent ::__construct();
		$this->load->database();
	}


	/**
	 * /**
	 * 該当テーブルからデータを取得する
	 * @param string $tenant_id
	 */
	public function get_every_hour($month)
	{
		$sdate = get_first_date($month);
		$edate = get_last_date($month);
		$statement = "
			SELECT
				`PIPE`,
				DATE_FORMAT(`DATE`, '%k') AS time,
				DATE_FORMAT(`DATE`, '%d') AS day,
				MAX(BPS_IN) AS tm_in,
				ROUND(AVG(BPS_IN),0) AS ta_in
			FROM
				t_traffic
			WHERE
				DATE between '$sdate 00:00:00' and '$edate 23:59:59'
			GROUP BY
				`PIPE`,
				DATE_FORMAT(`DATE`, '%k'),
				DATE_FORMAT(`DATE`, '%d')
			 ORDER BY
				`PIPE` DESC,
				DATE_FORMAT(`DATE`, '%k'),
				DATE_FORMAT(`DATE`, '%d')
			";
		$query     = $this -> db -> query($statement);
		return $query -> result('array');
	}



	/**
	 * /**
	 * 該当テーブルからデータを取得する
	 * @param date $sdate, $edate
	 */
	public function get_daily_traffic_12($last_year, $this_year)
	{
		$statement = "
			SELECT
				LEFT(`DATE`,4) AS year,
				DATE_FORMAT(`DATE`, '%Y%m%d') AS day,
				ROUND(AVG(BPS_IN),0) AS a_in,
				ROUND(AVG(BPS_OUT),0) AS a_out
			FROM
				t_traffic
			WHERE
				(LEFT(`DATE`,4) =  '$last_year' OR LEFT(`DATE`,4) =  '$this_year')
			AND 
			   SUBSTRING(`DATE`, 12, 2) = 12
			AND PIPE = 'Xi'
			GROUP BY
				LEFT(`DATE`,4), DATE_FORMAT(`DATE`, '%Y%m%d')
			 ORDER BY
				LEFT(`DATE`,4), DATE_FORMAT(`DATE`, '%Y%m%d')
			";
		$query     = $this -> db -> query($statement);
		return $query -> result('array');
	}

	/**
	 * /**
	 * 該当テーブルからデータを取得する
	 * @param date $sdate, $edate
	 */
	public function get_daily_traffic_12_m($last_year, $this_year)
	{
		$statement = "
			SELECT
				LEFT(`DATE`,4) AS year,
				DATE_FORMAT(`DATE`, '%Y%m%d') AS day,
				ROUND(AVG(BPS_IN),0) AS a_in,
				ROUND(AVG(BPS_OUT),0) AS a_out
			FROM
				t_traffic_new
			WHERE
				(LEFT(`DATE`,4) =  '$last_year' OR LEFT(`DATE`,4) =  '$this_year')
			AND 
			   SUBSTRING(`DATE`, 12, 2) = 12
			AND PIPE = 'mobile'
			GROUP BY
				LEFT(`DATE`,4), DATE_FORMAT(`DATE`, '%Y%m%d')
			 ORDER BY
				LEFT(`DATE`,4), DATE_FORMAT(`DATE`, '%Y%m%d')
			";
		$query     = $this -> db -> query($statement);
		return $query -> result('array');
	}

	/**
	 * /**
	 * 該当テーブルからデータを取得する
	 * @param date $sdate, $edate
	 */
	public function get_daily_traffic_12_r($last_year, $this_year)
	{
		$statement = "
			SELECT
				LEFT(`DATE`,4) AS year,
				DATE_FORMAT(`DATE`, '%Y%m%d') AS day,
				ROUND(AVG(BPS_IN),0) AS a_in,
				ROUND(AVG(BPS_OUT),0) AS a_out
			FROM
				t_traffic_new
			WHERE
				(LEFT(`DATE`,4) =  '$last_year' OR LEFT(`DATE`,4) =  '$this_year')
			AND 
			   SUBSTRING(`DATE`, 12, 2) = 12
		AND PIPE IN ('r71','r72')
			GROUP BY
				LEFT(`DATE`,4), DATE_FORMAT(`DATE`, '%Y%m%d')
			 ORDER BY
				LEFT(`DATE`,4), DATE_FORMAT(`DATE`, '%Y%m%d')
			";
		$query     = $this -> db -> query($statement);
		return $query -> result('array');
	}

	/**
	 * /**
	 * 該当テーブルからデータを取得する
	 * @param date $sdate, $edate
	 */
	public function get_daily_traffic($sdate, $edate)
	{
		$statement = "
			SELECT
				`PIPE`,
				DATE_FORMAT(`DATE`, '%Y%m%d') AS day,
				MAX(BPS_IN) AS tm_in,
				ROUND(AVG(BPS_IN),0) AS ta_in
			FROM
				t_traffic
			WHERE
				`DATE` BETWEEN '$sdate' AND '$edate'
			GROUP BY
				`PIPE`,
				DATE_FORMAT(`DATE`, '%Y%m%d')
			 ORDER BY
				`PIPE` DESC,
				DATE_FORMAT(`DATE`, '%Y%m%d')
			";
		$query     = $this -> db -> query($statement);
		return $query -> result('array');
	}


	/**
     * /**
     * 該当テーブルからデータを取得する
     * @param date $this_month, $last_month
     */
    public function get_max_traffic($this_month, $last_month)
    {
        $statement = "
SELECT
	`PIPE`,
	DATE_FORMAT(`DATE`, '%Y-%m') AS target_month,
	MAX(BPS_IN) AS tm_in,
	ROUND(AVG(BPS_IN),0) AS ta_in
FROM
	t_traffic
WHERE
	(`DATE` LIKE '$last_month%') OR (`DATE` LIKE '$this_month%')
GROUP BY
	`PIPE`,
	DATE_FORMAT(`DATE`, '%Y-%m')
 ORDER BY
	`PIPE` DESC,
	DATE_FORMAT(`DATE`, '%Y-%m')
";
        $query     = $this -> db -> query($statement);
        return $query -> result('array');
    }


}
