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
#	$Id: admin.php 35 2024-12-11 06:21:34Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$act_tit = array(
	'upload' => __('upload setting'),
	'announce' => __('announce setting')
);
$title = $nav_tit = $act_tit[$act] ? $act_tit[$act] : __('base setting');

require_once template_echo('adm_header', $admin_tpl_dir);

// auth check
if (!$pd_gid) {
	adm_redirect('./', __('admin check auth error'));
	exit;
}
$b4_array = array('announce','meta_ext','contact_us','miibeian');

if ($task == 'doset') {

	$set = array(

	);
	$sets = gpc('set', 'P', $set);
	//print_r($sets);exit;
	$keys = array_keys($sets);
	foreach ($keys as $key) {
		if(in_array($key,$b4_array)){
			$settings[$key] = base64_encode($sets[$key]);
		}else{
			$settings[$key] = $sets[$key];
		}
	}

	if ($settings['user_tpl_dir'] && !is_dir(PHPDISK_ROOT . '_phpdisk/templates/' . $settings['user_tpl_dir'])) {
		$error = true;
		$sysmsg[] = __('user template dir not exists');
	}
	if (!$error) {
		settings_cache($settings);

		adm_redirect('_phpdisk/admin.php?act=' . $act, __('settings update success'));
	} else {
		adm_redirect('back', $sysmsg);
	}

} else {
	$arr = check_update_time();
	$show_update_tips = (int) $arr[0];
	$last_up_day = $arr[1];

	$alert_bgs = array('success', 'info', 'warning', 'danger');
	$alert_bg = $alert_bgs[mt_rand(0, 3)];

	$keys = array_keys($settings);
	foreach ($keys as $key) {
		if(in_array($key,$b4_array)){
			$settings[$key] = base64_decode($settings[$key]);
		}
	}

	require_once template_echo('admin', $admin_tpl_dir);

}
require_once template_echo('adm_footer', $admin_tpl_dir);

function check_update_time()
{
	global $timestamp;
	$show_tips = 1;
	$last_up_day = '';
	$no_update = PHPDISK_ROOT . '_phpdisk/system/no_update.php';
	if (file_exists($no_update)) {
		if ($timestamp - filemtime($no_update) < 7 * 86400) {
			$last_up_day = str_replace('<?php exit; ?>', '', read_file($no_update));
			$show_tips = 0;
		} else {
			$last_up_day = str_replace('<?php exit; ?>', '', read_file($no_update));
			$show_tips = 1;
		}
	}
	return array($show_tips, $last_up_day);
}



