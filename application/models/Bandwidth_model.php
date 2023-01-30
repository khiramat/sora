<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once 'Abstract_model.php';

/**
 * Bandwidth用モデル
 */
class Bandwidth_model extends CI_Model {

    protected $table_name = 'h_bandwidth';

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

    public function empty_table()
    {
        $this->db->truncate($this->table_name);
    }


    /**
     * 帯域情報を取得
     * @param string edata
     * @param int limit [1]最新情報
     * @return array result rows
     */
    public function get_bandwidth(string $date, int $limit=1)
    {
        $sql = "SELECT
                    Xi,
                    FOMA,
                    `datetime`,
                    DATE_FORMAT(`datetime`, '%m') as month,
                    unix_timestamp(DATE_FORMAT(`datetime`, '%Y/%m/%d 09:00:00')) as unixtime
                FROM
                    $this->table_name
                WHERE
                    flag = 1 AND `datetime` <= '$date'
                ORDER BY
                    `datetime` DESC
                LIMIT $limit ;";
        $query = $this -> db -> query($sql);

        return $query -> result();
    }


	/**
	 * 帯域情報を取得
	 * @param int limit [1]最新情報
	 * @return array result rows
	 */
	public function get_data(int $limit=1)
	{
		$sql = "SELECT
                    Xi,
                    FOMA,
                    `datetime`
                FROM
                    $this->table_name
                WHERE
                    flag = 1
                ORDER BY
                    `datetime` DESC
                LIMIT $limit ;";
		$query = $this -> db -> query($sql);

		return $query -> result();
	}


	/**
     * 指定期間内に帯域変更有無を確認
     * @param string sdata (YYYY-MM-DD)
     * @param string edata (YYYY-MM-DD)
     * @return int result
     */
    public function get_bandwidth_count(string $sdate, string $edate)
    {
        $sql = sprintf("SELECT *
                        FROM $this->table_name
                        WHERE flag = 1 AND `datetime` between %s and %s
                        ;",
                        "'" .$sdate. "'", "'" .$edate. "'");
        $query = $this -> db -> query($sql);

        return $query -> num_rows();
    }


    /**
     * 速度測定専用(Xi限定)
     * @param string edata
     * @param int limit [1]最新情報
     * @return array result rows
     */
    public function get_bandwidth_update_datetime(string $sdate, string $edate)
    {
        $sql = "SELECT
                    `datetime`,
                    DATE_FORMAT(`datetime`, '%m') as month
                FROM
                    $this->table_name
                WHERE
                    flag = 1 AND
                    `datetime` between '$sdate 00:00:00' and '$edate 23:59:59'
                ORDER BY
                    `datetime`
                ;";

        $query = $this -> db -> query($sql);

        return $query -> result();
    }


    /**
     * データ登録
     */
    public function insert_data($data)
    {
        $result = false;
        if($this -> db -> insert($this->table_name, $data)){
            $result = true;
        }

        return $result;
    }

    /**
	 * データ削除
	 */
	public function delete_data($data)
	{
        $result = false;
        if($this -> db -> delete($this->table_name, $data)){
            $result = true;
        }

		return $result;
	}


}
