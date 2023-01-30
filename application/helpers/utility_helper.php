<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * 先週の月曜の日付を返す。
 */
if (!function_exists('get_last_monday'))
{
    function get_last_monday()
    {
 //       return '2018-06-11 00:00:00';
        return date("Y-m-d 00:00:00", strtotime('monday previous week'));
    }
}

/**
 * 先週の日曜の日付を返す。
 */
if (!function_exists('get_last_sunday'))
{
    function get_last_sunday()
    {
 //       return '2018-06-17 23:59:59';
        return date("Y-m-d 23:59:59", strtotime('sunday previous week'));
    }
}
/**
 * 先月の年を返す。
 */
if (!function_exists('get_this_year'))
{
	function get_this_year()
	{
        return date("Y", strtotime('-1 month'));
	}
}
/**
 * 先月の年月を返す。
 */
if (!function_exists('get_this_month'))
{
	function get_this_month()
	{
		return date("Y-m", strtotime('-1 month'));
	}
}
/**
 * 先先月の年月を返す。
 */
if (!function_exists('get_last_month'))
{
    function get_last_month()
    {
        return date("Y-m", strtotime('-2 month'));
    }
}

/**
 * 先先月の年月を返す。
 */
if (!function_exists('get_next_month'))
{
    function get_next_month()
    {
        return date("Y-m");
    }
}


/**
 * 先月の年月を返す。
 */
if (!function_exists('get_this_month_end'))
{
	function get_this_month_end()
	{
		return date('Y-m-d 23:59:59', mktime(0, 0, 0, date('m'), 0, date('Y')));;
	}
}

/**
 * 先先月の年月を返す。
 */
if (!function_exists('get_last_month_first'))
{
	function get_last_month_first()
	{
		return date("Y-m-d", strtotime('-2 month'));
	}
}


/**
 * 先月の月を返す。
 */
if (!function_exists('get_next_month_n'))
{
    function get_next_month_n()
    {
        return date("n");
    }
}
/**
 * 先月の月を返す。
 */
if (!function_exists('get_this_month_n'))
{
    function get_this_month_n()
    {
        return date("n", strtotime('-1 month'));
    }
}
/**
 * 先先月の月を返す。
 */
if (!function_exists('get_last_month_n'))
{
    function get_last_month_n()
    {
        return date("n", strtotime('-2 month'));
    }
}
/**
 * 指定月を返す。
 */
if (!function_exists('get_month_n'))
{
    function get_month_n($date)
    {
        return date("n", strtotime($date));
    }
}
/**
 * 指定月の年を返す。
 */
if (!function_exists('get_month_y'))
{
    function get_month_y($date)
    {
        return date("Y", strtotime($date));
    }
}
/**
 * 指定月の年月を返す。
 */
if (!function_exists('get_month_ym'))
{
    function get_month_ym($date)
    {
        return date("Y-m", strtotime($date));
    }
}
/**
 * 指定月の来月の月を返す。
 */
if (!function_exists('get_next_month_m'))
{
    function get_next_month_m($date)
    {
        $n = get_month_n($date);
        $reault = ($n == 12) ? 1 : $n+1;
        return $reault;
    }
}
/**
 * 指定月の月初日
 */
if (!function_exists('get_first_date'))
{
 function get_first_date($month)
 {
     return date('Y-m-d', strtotime('first day of ' . $month));
 }
}
 /**
  * 指定月の月末日
  */
if (!function_exists('get_last_date'))
{
  function get_last_date($month)
  {
      return date('Y-m-d', strtotime('last day of ' . $month));
  }
}


/**
 * 先先先月の月を返す。
 */
if (!function_exists('get_last_before_month_n'))
{
    function get_last_before_month_n()
    {
        return date("n", strtotime('-3 month'));
    }
}

/**
 * 指定日の1ヶ月前の月を返す。
 */
if (!function_exists('get_last_before_month_m'))
{
    function get_last_before_month_m($date)
    {
        return date("n", strtotime("$date -1 month"));
    }
}

/**
 * @desc レポート提出の日付を返す。
 */
if (!function_exists('get_report_submission_day'))
{
	function get_report_submission_day()
	{
		$week = Array('日','月','火','水','木','金','土');
		$date_of_interest = date(" Y年m月d日", strtotime('next Friday'));
		$week_of_interest = $week[date('w', strtotime('next Friday'))];
		$date_result = $date_of_interest. "（".$week_of_interest."）";
		return $date_result;
		}
}


/**
 * @desc サーバーのIPアドレス取得
 * @return string
 */
if (!function_exists('get_server_ip'))
{
    function get_server_ip() : string
    {
        return getenv('SERVER_NAME');
    }
}


// /**
//  * datetime形式をunixtimeに変換
//  * @param datetime $datetime YYYY-MM-DD HH:MM:SS
//  * @return unixtime $result
// */
// if (!function_exists('convert_unixtime'))
// {
//     function convert_unixtime($datetime){
//         $date = new DateTime($datetime, new DateTimeZone('UTC'));
//         $date = $date -> getTimestamp();
//         return $date - 32400;
//     }
// }


// /**
// * unixtime形式をフォーマット変更
// *
// * @param unixtime $unixtime
// * @return string $result
// */
// if (!function_exists('convert_datetime'))
// {
//     function convert_datetime($unixtime){
//         $date = new DateTime();
//         $date->setTimestamp($unixtime-32400);
//         $date = $date->format("Y-m-d");
//         return $date;
//     }
// }

// // ------------------------------------------------------------------------
//
// if ( ! function_exists('uri_string'))
// {
// 	/**
// 	 * URL String
// 	 *
// 	 * Returns the URI segments.
// 	 *
// 	 * @return	string
// 	 */
// 	function uri_string()
// 	{
// 		return get_instance()->uri->uri_string();
// 	}
// }
//
// if ( ! function_exists('current_url'))
// {
// 	/**
// 	 * Current URL
// 	 *
// 	 * Returns the full URL (including segments) of the page where this
// 	 * function is placed
// 	 *
// 	 * @return	string
// 	 */
// 	function current_url()
// 	{
// 		$CI =& get_instance();
// 		return $CI->config->site_url($CI->uri->uri_string());
// 	}
// }
//
// // ------------------------------------------------------------------------
//
// if ( ! function_exists('site_url'))
// {
// 	/**
// 	 * Site URL
// 	 *
// 	 * Create a local URL based on your basepath. Segments can be passed via the
// 	 * first parameter either as a string or an array.
// 	 *
// 	 * @param	string	$uri
// 	 * @param	string	$protocol
// 	 * @return	string
// 	 */
// 	function site_url($uri = '', $protocol = NULL)
// 	{
// 		return get_instance()->config->site_url($uri, $protocol);
// 	}
// }
