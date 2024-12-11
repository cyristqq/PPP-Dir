<?php
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Chinese Website: http://www.phpdisk.com
#
#	International Website: http://www.phpdisk.net
#
#	Author: Along ( admin@phpdisk.com )
#
#	$Id: index.php 23 2024-12-10 00:32:11Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/


include "_phpdisk/includes/commons.inc.php";


$d = trim(gpc('d', 'G', ''));
$grid = (int) gpc('grid', 'G', '');

$dir = rawurldecode(base64_decode($d));

$dir = str_ireplace(array('./', '.\\', '"'), '', $dir);
//$dir = filter_var($dir, FILTER_SANITIZE_URL);

$dir_text = str_iconv($dir);
//echo $dir . '|' . $dir_text;
//echo $base_dir;
$title = $dir ? "[ $dir_text ]" : '[ ' . __('root folder') . ' ]';
$title = $settings['site_title'] . $title;

require_once template_echo('pd_header', $user_tpl_dir);

//echo PHPDISK_ROOT;
if (!$cfg['phpdisk_dir']) {
    redirect('./', __('base_dir_not_null'), 99999);
    require_once template_echo('pd_footer', $user_tpl_dir);
    exit;
}

$base_dir = PHPDISK_ROOT . $cfg['phpdisk_dir'];

//$curr_page = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if ($d) {
    $curr_page = $cfg['phpdisk_url'] . "?d=$d&grid=$grid";
    $list_page = $cfg['phpdisk_url'] . "?d=$d&grid=0";
    $grid_page = $cfg['phpdisk_url'] . "?d=$d&grid=1";
} else {
    $curr_page = $cfg['phpdisk_url'] . '?grid=' . $grid;
    $list_page = $cfg['phpdisk_url'] . '?grid=0';
    $grid_page = $cfg['phpdisk_url'] . '?grid=1';
}
//echo $curr_page;
if ($dir) {
    $base_dir = $base_dir . '/' . $dir;
    $nav_arr = explode('/', $dir_text);
}
// for($i=0;$i<30;$i++){
//     make_dir($base_dir.$i.'/');
// }
// $pass_file = $base_dir.'/.pass';
// $visit_code = '111';
// if(!(file_exists($pass_file) && $visit_code==read_file($pass_file))){
//     die('deny');
// }

$disk_stats = getDirSize($base_dir, true);
$h5_max_filesize = $settings['h5_max_filesize'] ? $settings['h5_max_filesize'].'b' : '500mb';
$h5_upload_ext = $settings['h5_upload_ext'] ? trim($settings['h5_upload_ext']) : '';
$up_token = md5($settings['encrypt_key'].$d);
$file_rc_upload_url = 'op.php';

if (file_exists($base_dir) && is_dir($base_dir)) {

    $files_array = list_dir($base_dir, false, $dir);
    $folders_array = list_dir($base_dir, true, $dir);
    // print_r($arr);
    require_once template_echo('phpdisk', $user_tpl_dir);
    require_once template_echo('pd_footer', $user_tpl_dir);
    exit;
} else {
    if ($dir) {
        redirect('./', "[ $dir ]..." . __('your dir not found'), 99999);
    } else {
        redirect('./', __('base_dir_not_exists'), 99999);
    }
    require_once template_echo('pd_footer', $user_tpl_dir);
    exit;

}
