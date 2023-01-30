<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 静的ファイルを取得。
 */
if (!function_exists('curl_get_file_contents')) {
    function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }
}

/**
 * 先週の月曜の日付を返す。
 */
if (!function_exists('get_last_monday')) {
    function get_last_monday()
    {
        return date("Y-m-d 00:00:00", strtotime('monday previous week'));
    }
}

/**
 * 先週の日曜の日付を返す。
 */
if (!function_exists('get_last_sunday')) {
    function get_last_sunday()
    {
        return date("Y-m-d 23:59:59", strtotime('sunday previous week'));
    }
}

/**
 * @desc 直前週の該当の日付を返す。
 */
if (!function_exists('get_last_start_day_of_week')) {
    function get_last_start_day_of_week(string $day_of_week)
    {
        return date("Y-m-d 00:00:00", strtotime($day_of_week . ' previous week'));
    }
}
/**
 * @desc 直前週の該当の日付を返す。
 */
if (!function_exists('get_last_end_day_of_week')) {
    function get_last_end_day_of_week(string $day_of_week)
    {
        return date("Y-m-d 23:59:59", strtotime($day_of_week . ' previous week'));
    }
}

/**
 * 先週の月曜の日付を返す。
 */
if (!function_exists('get_report_last_monday')) {
    function get_report_last_monday()
    {
        $week = Array('日', '月', '火', '水', '木', '金', '土');
        $date_of_interest = date(" Y年m月d日", strtotime('monday previous week'));
        $week_of_interest = $week[date('w', strtotime('monday previous week'))];
        $date_result = $date_of_interest . "（" . $week_of_interest . "）";
        return $date_result;
    }
}

/**
 * 先週の日曜の日付を返す。
 */
if (!function_exists('get_report_last_sunday')) {
    function get_report_last_sunday()
    {
        $week = Array('日', '月', '火', '水', '木', '金', '土');
        $date_of_interest = date(" Y年m月d日", strtotime('sunday previous week'));
        $week_of_interest = $week[date('w', strtotime('sunday previous week'))];
        $date_result = $date_of_interest . "（" . $week_of_interest . "）";
        return $date_result;
    }
}

/**
 * @desc レポート提出の日付を返す。
 */
if (!function_exists('get_report_submission_day')) {
    function get_report_submission_day()
    {
        $week = Array('日', '月', '火', '水', '木', '金', '土');
        $weekday = date("w");
        if ($weekday == 5) {
            $date_of_interest = date(" Y年m月d日");
            $week_of_interest = $week[date('w')];
        } else if ($weekday == 6 || $weekday == 0) {
            $date_of_interest = date(" Y年m月d日", strtotime('previous Friday'));
            $week_of_interest = $week[date('w', strtotime('previous Friday'))];
        } else {
            $date_of_interest = date(" Y年m月d日", strtotime('next Friday'));
            $week_of_interest = $week[date('w', strtotime('next Friday'))];
        }
        $date_result = $date_of_interest . "（" . $week_of_interest . "）";
        return $date_result;
    }
}
/**
 * 先週の月曜の日付を返す。
 */
if (!function_exists('get_directory_last_monday')) {
    function get_directory_last_monday()
    {
        return date("Y-m-d", strtotime('monday previous week'));
    }
}


/**
 * 改行
 */
if (!function_exists('br')) {
    function br($count = 1)
    {
        if (is_cli()) {
            return str_repeat(PHP_EOL, $count);
        } else {
            return str_repeat("<br/>", $count);
        }

    }
}

if (!function_exists('str_empty')) {
    /**
     * string is empty
     * @param string $str
     * @return bool
     */
    function str_empty(string $str = NULL, bool $trim = FALSE): bool
    {
        if ($str === NULL) return TRUE;
        if ($trim) $str = trim($str);
        return $str === '' ? TRUE : FALSE;
    }
}
