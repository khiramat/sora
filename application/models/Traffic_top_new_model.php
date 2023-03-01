<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once 'Abstract_model.php';

/**
 * Traffic用モデル
 */
class Traffic_top_new_model extends CI_Model
{
    protected $table_name = 't_traffic_top_new';

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        // table name
        parent::__construct($this->table_name);
    }

    public function edit_service_top()
    {
/*        $sql = "DROP TABLE IF EXISTS `t_traffic_top_new_last`";
        $this -> db -> query($sql);

        $sql = "CREATE TABLE `t_traffic_top_new_last` LIKE `t_traffic_top_new`";
        $this -> db -> query($sql);*/

        $sql = "INSERT INTO `t_traffic_top_new_last` SELECT * FROM `t_traffic_top_new`";
        $this -> db -> query($sql);

        $sql = "TRUNCATE TABLE `t_traffic_top_new`";
        $this -> db -> query($sql);
        return true;
    }

    /**
     * /**
     * 指定サービスのみデータ取得
     * @param date sdate, edate
     * @param array service_arr (Xi, FOMA)
     */
    public function get_top_service()
    {
        $sql = "
            SELECT
                DATE_FORMAT(DATE, '%Y-%m-%d') AS date,
                SERVICE,
                all_traffic
            FROM
                t_traffic_top_new
            ORDER BY
                DATE_FORMAT(DATE, '%Y-%m-%d'),
                SERVICE;
            ";
        $query = $this -> db -> query($sql);
        return $query -> result();
    }
}
