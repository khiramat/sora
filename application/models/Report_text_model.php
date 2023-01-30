<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once 'Abstract_model.php';

/**
 * Traffic用モデル
 */
class Report_text_model extends CI_Model {

    protected $table_name = 's_report_text';

    /**
	 * /**
	 * 該当テーブルからデータを取得する
	 */
	public function get_data()
	{
        $sql = "SELECT
                    id, title, body
                FROM
                    s_report_text
                ; ";

		$query = $this -> db -> query($sql);

		return $query -> result('array');
	}

    /**
	 * /**
	 * 指定文言更新
	 */
	public function update_report_text($data, $id)
	{
        $result = false;
        $this->db->where('id', $id);

        if($this -> db -> update('s_report_text', $data)){
            $result = true;
        }

		return $result;
	}




}
