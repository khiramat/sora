<?php


require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$category_directry_ary = [
	'SR-NG-SPT01',
	'SR-NG-SPT02',
	'SR-NG-SPT03',
	'SR-NG-SPT04',
	'SR-RS-SPT01',
	'SR-RS-SPT02',
	'SR-RS-SPT03',
	'SR-RS-SPT04'
];
foreach($category_directry_ary as $key => $value){
	array_map('unlink', glob($value."/*"));
}
$today = date();
$target_month = date("Y-m", strtotime("$today -1 month"));

$credentials = [
	'key'    => 'AKIAT3D3VV3WG66SRBZW',
	'secret' => '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',
];
$region = "ap-northeast-1";
$bucket = 'rs-noc-sora-speedtest';

$params = [
	'Bucket' => $bucket,
	'Prefix' => 'log',
];

$s3 = S3Client ::factory([
	'credentials' => $credentials,
	'region'      => $region,
	'version'     => 'latest'
]);

$result = $s3 -> ListObjects($params);
foreach($result['Contents'] as $key => $value){
	if($value['Size'] != 0){
		$category_slash_ary = explode('/', $value['Key']);
		$category_dot_ary = explode('.', $category_slash_ary[1]);
		$category = $category_dot_ary[3];
		$path = $category.'/'.$category_slash_ary[3];
		if($category != 'SR-NG-SPT99' && substr($category_slash_ary[3], 0, 7) == $target_month){
			$file = $s3 -> getObject([
				'Bucket' => $bucket,
				'Key'    => $value['Key'],
				'SaveAs' => $path
			]);
		}
	}
}