<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once 'Abstract_model.php';

/**
 * SUBSCRIBER用モデル
 */
class Speed_test_model extends CI_Model{

	protected $table_name = 't_speed_test';

	/**
	 * コンストラクタ
	 */
	public function __construct(){
		// table name
		parent ::__construct($this -> table_name);
	}

	/**
	 * 該当テーブに、データを挿入する
	 * @param array $data
	 */
	public function put_into_the_table(array $data){
		//$this -> db -> insert('t_speed_test', $data);
		//print_r($data);
		$this -> db -> insert_batch('t_speed_test', $data);
	}








	/**
	 * 箱ひげグラフホストデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_sum_up_pg($last_month){
		$sql = "
SELECT 
	RIGHT(host,5) AS pg,
	up AS data
FROM 
	`t_speed_test`
WHERE 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	RIGHT(host,5)
";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 箱ひげグラフホストデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_sum_down_pg($last_month){
		$sql = "
SELECT 
	RIGHT(host,5) AS pg,
	down AS data
FROM 
	`t_speed_test`
WHERE 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	RIGHT(host,5)
";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}

	/**
	 * 箱ひげグラフホストデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_sum_up_place($last_month){
		$sql = "
SELECT 
	SUBSTRING(host,4,2) AS place,
	up AS data
FROM 
	`t_speed_test`
WHERE 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	SUBSTRING(host,4,2)
";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 箱ひげグラフホストデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_sum_down_place($last_month){
		$sql = "
SELECT 
	SUBSTRING(host,4,2) AS place,
	down AS data
FROM 
	`t_speed_test`
WHERE 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	SUBSTRING(host,4,2)
";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 箱ひげグラフホストデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_sum_up_server($last_month){
		$sql = "
SELECT 
	host,
	up AS data
FROM 
	`t_speed_test`
WHERE 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	host
";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 箱ひげグラフホストデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_sum_down_server($last_month){
		$sql = "
SELECT 
	host,
	down AS data
FROM 
	`t_speed_test`
WHERE 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	host
";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}






	/**
	 * 箱ひげグラフホストデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_host($last_month){
		$sql = "
SELECT 
	DISTINCT `host`
FROM 
	`t_speed_test`
WHERE 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	`host`
	";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 箱ひげグラフホストデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_pgw($last_month){
		$sql = "
SELECT 
	DISTINCT RIGHT(host,5) AS pg
FROM 
	`t_speed_test`
WHERE 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	RIGHT(host,5)
	";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 箱ひげグラフホストデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_place($last_month){
		$sql = "
SELECT 
	DISTINCT SUBSTRING(host,4,2) AS place
FROM 
	`t_speed_test`
WHERE 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	SUBSTRING(host,4,2)
	";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 箱ひげグラフデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_down($last_month){
		$sql = "
SELECT 
	`host`, 
	LEFT(`datetime`,10)  AS date,  
	`down`
FROM 
	`t_speed_test`
WHERE 
	`datetime` LIKE '%03:%'
AND 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	`host`,
	LEFT(`datetime`,10),
	`down`

	";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}


	/**
	 * 箱ひげグラフデータ出力
	 * @param string $last_month
	 */
	public function get_box_plot_up($last_month){
		$sql = "
SELECT 
	`host`, 
	LEFT(`datetime`,10)  AS date,  
	`up`
FROM 
	`t_speed_test`
WHERE 
	`datetime` LIKE '%03:%'
AND 
	LEFT(`datetime`,7) = '$last_month'
ORDER BY
	`host`,
	LEFT(`datetime`,10),
	`up`
	";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}
}