<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| 通信方法文字列定義
|--------------------------------------------------------------------------
 */
const PIPE = array(
    'Xi' => 'LTE',
    'FOMA' => '3G'
);
const PIPE_CODE = array(
    0 => array(
        'name' => '3G',
        'color' => '#0077cc'),
    1 => array(
        'name' => 'LTE',
        'color' => '#CC0000')
);


/*
|--------------------------------------------------------------------------
| その他グロバルパラメータ定義
|--------------------------------------------------------------------------
 */
const SITE_NAME = 'SORAシームレポート管理画面';
const WEEK_NAME = array("日", "月", "火", "水", "木", "金", "土");
const MENU_NAME_ARR = array(
    ''				=> '選択してください',
    't_speed' 		=> '速度測定',
    't_active_user' => 'アクティブユーザ'
);
const MSG_ARR = array(
    0 => '※データが登録されました。',
    1 => '※データ登録を失敗しました。',
    2 => '※データが更新されました。',
    3 => '※データ更新を失敗しました。',
    4 => '※データが削除されました。',
    5 => '※データ削除を失敗しました。'
);
const ALERT_TYPE_ARR = array(
    0 => 'アラート種別を選択してください',
    1 => '既知<br>（未知アラート）',
    2 => '既知<br>（既知アラート）',
    3 => '既知<br>（一過性のもの）',
    4 => '既知<br>（対向の問題）',
    5 => '既知<br>（作業影響）',
    6 => '既知<br>（ハードウェア障害）',
    7 => '既知<br>（ハードウェア障害に<br>伴うアラート）',
    8 => '新規<br>（未知アラート）',
    9 => '新規<br>（既知アラート）',
    10 => '新規<br>（一過性のもの）',
    11 => '新規<br>（対向の問題）',
    12 => '新規<br>（作業影響）',
    13 => '新規<br>（ハードウェア障害）',
    14 => '新規<br>（ハードウェア障害に<br>伴うアラート）',
);
const ALERT_HOSTNAME_ARR = array(
    //0 => '発生原因を選択してください',
    1 => 'GN-TY-VPC01<br>(パケット交換機)',
    2 => 'GN-TY-VPC02<br>(パケット交換機)',
    3 => 'GN-TY-MON01<br>(監視サーバ)',
    4 => 'GN-TY-LOG01<br>(Syslogサーバ)',
    5 => 'GN-TY-ODB01<br>(DBサーバ)',
    6 => 'GN-TY-ODB02<br>(DBサーバ)',
    7 => 'GN-TY-DNS01<br>(DNSサーバ)',
    8 => 'GN-TY-DNS02<br>(DNSサーバ)',
    9 => 'GN-TY-WEB01<br>(PCCWEBサーバ)',
    10 => 'GN-TY-WEB02<br>(PCCWEBサーバ)',
    11 => 'GN-TY-RAD01<br>(RADIUSサーバ)',
    12 => 'GN-TY-RAD02<br>(RADIUSサーバ)',
    13 => 'GN-TY-EOA01<br>(OnbordAdministrator)',
    14 => 'GN-TY-EOA02<br>(OnbordAdministrator)',
    15 => 'GN-TY-EOA03<br>(OnbordAdministrator)',
    16 => 'GN-TY-EOA04<br>(OnbordAdministrator)',
    17 => 'GN-TY-VCE01<br>(HPバーチャルコネクトスイッチ)',
    18 => 'GN-TY-VCE02<br>(HPバーチャルコネクトスイッチ)',
    19 => 'GN-TY-VCE03<br>(HPバーチャルコネクトスイッチ)',
    20 => 'GN-TY-VCE04<br>(HPバーチャルコネクトスイッチ)',
    21 => 'GN-TY-STR01<br>(ストレージサーバ)',
    22 => 'GN-TY-SVP01<br>(サービスプロセッサ)',
    23 => 'GN-TY-PCC01<br>(PCCサーバ)',
    24 => 'GN-TY-PCC02<br>(PCCサーバ)',
    25 => 'GN-TY-EMS01<br>(EMSサーバ)',
    26 => 'GN-TY-EMS02<br>(EMSサーバ)',
    // 27 => 'GN-TY-DPI03<br>(統計情報保存装置)',
    28 => 'GN-TY-DPI01<br>(帯域制御装置)',
    29 => 'GN-TY-DPI02<br>(帯域制御装置)',
    30 => 'GN-TY-PCM01<br>(PCCMSサーバ)',
    31 => 'GN-TY-PCM02<br>(PCCMSサーバ)',
    32 => 'GN-TY-CSW01<br>(コアスイッチ)',
    33 => 'GN-TY-DCM01<br>(MNO接続スイッチ)',
    34 => 'GN-TY-NFW01#1<br>(NATファイアウォール)',
    35 => 'GN-TY-NFW01#2<br>(NATファイアウォール)',
    36 => 'GN-TY-VPN01<br>(SSL-VPN装置)',
    37 => 'GN-TY-MFW01<br>(保守用ファイアウォール)',
    38 => 'GN-TY-SAN01<br>(SANスイッチ)',
    39 => 'GN-TY-SAN02<br>(SANスイッチ)',
    40 => 'GN-TY-MDC01<br>(メディアコンバータ)',
    41 => 'GN-TY-MDC02<br>(メディアコンバータ)',
    42 => 'GN-TY-MDC03<br>(メディアコンバータ)',
    43 => 'GN-TY-MDC04<br>(メディアコンバータ)',
    44 => 'GN-TY-CON01<br>(コンソールサーバ)',
    45 => 'GN-TY-DPI04(統計情報保存装置)',
    46 => 'GN-TY-VPC03(パケット交換機)',
    47 => 'GN-TY-VPC04(パケット交換機)'
);
const EXISTENCE_ARR = array(
    0 => 'なし',
    1 => 'あり'
);



/*
|--------------------------------------------------------------------------
| サービスごとカラー定義
|--------------------------------------------------------------------------
 */
const SERVICE_COLOR = array(
    'Android Market'    => '#007bbb',
    'Google'            => '#b94047',
    'HTTP'              => '#99ab4e',
    'Instagram'         => '#895b8a',
    'LINE'              => '#00a3af',
    'SSL v3'            => '#00b362',
    'HTTP2 over TLS'    => '#ff051e',
    'Yahoo'             => '#C00000',
    'YouTube'           => '#1ad9ff',
    'HTTP media stream' => '#f39800'
);
