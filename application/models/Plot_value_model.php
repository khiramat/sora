<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once 'Abstract_model.php';

/**
 * Bandwidth用モデル
 */
class Plot_value_model extends CI_Model {

    protected $table_name = 't_base_value';

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
    public function get_base_value()
    {
			$sql = "SELECT
                    base_value
                FROM
                    $this->table_name
                WHERE
                    id = 1";
			$query = $this -> db -> query($sql);

			return $query -> result();
    }

	/**
	 * データ登録
	 */
	public function update_base_value($data)
	{
		$sql = "UPDATE $this->table_name
            SET base_value = $data
            WHERE id = 1";
		$query = $this -> db -> query($sql);
		if($query){
			return true;
		}
	}

}
