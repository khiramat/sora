<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once 'Abstract_model.php';

/**
 * Traffic用モデル
 */
class Job_schedule_text_model extends CI_Model {

    protected $table_name = 's_job_schedule_text';

    /**
	 * 全てのデータを取得する
	 */
	public function get_data_all()
	{
        $sql = "SELECT
                    id, title, datetimes, day, body
                FROM
                    $this->table_name
                ORDER BY
                    day DESC
                ;";

		$query = $this -> db -> query($sql);
		return $query -> result('array');
	}

    /**
	 * 該当テーブルからデータを取得する
	 */
    public function get_data($sdate, $edate)
	{
        $sql = "SELECT
                    id, title, datetimes, day, body
                FROM
                    $this->table_name
                WHERE
                    `day` BETWEEN '$sdate' AND '$edate'
                ORDER BY
                    day, id
                ;";

		$query = $this -> db -> query($sql);
		return $query -> result('array');
	}

    /**
	 * 指定データを取得する
	 */
	public function get_data_by_id($id)
	{
        $sql = "SELECT
                    id, title, datetimes, day, body
                FROM
                    $this->table_name
                WHERE
                    id = $id
                ;";

		$query = $this -> db -> query($sql);
		return $query -> result('array');
	}

    /**
	 * データ登録
	 */
	public function insert_job_schedule_data($data)
	{
        $result = false;
        if($this -> db -> insert('s_job_schedule_text', $data)){
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

    /**
	 * 指定データ更新
	 */
	public function update_set_id($data, $id)
	{
        $result = false;
        $this->db->where('id', $id);

        if($this -> db -> update($this->table_name, $data)){
            $result = true;
        }

		return $result;
	}


}
