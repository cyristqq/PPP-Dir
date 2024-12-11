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
#	$Id: adm_ajax.php 24 2024-12-10 03:39:13Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/
include "includes/commons.inc.php";

// auth check
if(!$pd_gid) {
	die( __('admin check auth error'));
}
switch($act){
	
	case 'close_update_msgbox':
		$day = trim(gpc('day','P',''));
		if($day){
			write_file(PHPDISK_ROOT.'_phpdisk/system/no_update.php','<?php exit; ?>'.$day);
			echo json_encode(array('success'=>true,'msg'=>__('no update tips')));
		}else{
			echo json_encode(array('success'=>false,'msg'=>__('update msg error')));
		}
		exit;
		break;
	default:
		die('no act');
}
