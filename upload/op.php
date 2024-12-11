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
#	$Id: op.php 27 2024-12-10 06:52:54Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/
include "_phpdisk/includes/commons.inc.php";

if($act=='rc_upload' && !$pd_uid) {
    die( __('check auth error'));
}

switch ($act) {

	case 'down':
		$fn = rawurldecode(base64_decode(trim(gpc('fn', 'G', ''))));
		//$fn = rawurldecode((trim(gpc('fn', 'G', ''))));
		if (substr($fn, 0, 1) == '.') {
			die(__('file_deny_download'));
		}
		//echo $fn;
		//$fn = str_iconv($fn,true);

		if (!$cfg['phpdisk_dir']) {
			die(__('base_dir_not_null'));
		}
		//$fn = str_replace(array('\\','\/'), '', $fn);
		$fn_src = $cfg['phpdisk_dir'] . '/' . $fn;
		//echo $fn_src;exit;
		//echo substr(strrchr($fn_src, "/"), 1);exit;


		// function check_ref(){
		// 	global $settings;
		// 	$arr = explode('/',$_SERVER['HTTP_REFERER']);
		// 	$arr2 = explode('/',$settings['phpdisk_url']);
		// 	$arr3 = explode(',',$settings['down_server_refs']);

		// 	if(!$_SERVER['HTTP_REFERER'] || $arr[2]!=$arr2[2]){
		// 		header('Location: '.$settings['phpdisk_url']);
		// 		exit;
		// 	}
		// 	if(is_array($arr3) && !in_array($arr[2],$arr3)){
		// 		header('Location: '.$settings['phpdisk_url']);
		// 		exit;			
		// 	}

		// }

		// if(!is_mobile()){
		// 	check_ref();
		// }

		// $str = $_SERVER['QUERY_STRING'];
		// if(strpos($str,'/phpdisk/')!==false){
		// 	$arr = explode('/phpdisk/',$str);
		// 	$str = $arr[0];
		// }

		// parse_str(pd_encode(base64_decode(rawurldecode($str)),'DECODE'));
		$fn = substr(strrchr(str_iconv($fn_src), "/"), 1);

		//$pp = $pp.get_real_ext(get_extension($pp));
		if (!file_exists(PHPDISK_ROOT . $fn_src)) {
			echo sprintf(__('[ %s ] -> This file does not exist. Please contact the website administrator.'), $fn);
			echo __('Contact') . $settings['contact_us'] . '</p>';

		} else {
			//$fn = filter_name(str_replace("+", "%20",$fn));
			ob_end_clean();
			// if(is_mobile()){
			// 	$fn = rawurlencode($fn);
			// }else{
			// 	$fn = iconv('utf-8','gbk',$fn);
			// }
			header('Content-disposition: attachment;filename="' . $fn . '"');

			header('Content-type: application/octet-stream');

			if (($auth['pd_a']||$auth['pd_p']) && $settings['open_xsendfile'] == 2) {
				header('X-Accel-Redirect: /' . $fn_src);
			} elseif (($auth['pd_a']||$auth['pd_p']) && $settings['open_xsendfile'] == 1) {
				header('X-sendfile: ./' . $fn_src);
			} else {
				header('Content-Encoding: none');
				header('Content-Transfer-Encoding: binary');
				header('Content-length: ' . filesize($fn_src));
				@readfile('./' . $fn_src);
			}
		}

		break;
	case 'rc_upload':
		$file = $_FILES['file'];
		$replace_file = (int)gpc('replace_file', 'GP', '');
		$d = trim(gpc('d', 'GP', ''));
		$up_token = trim(gpc('up_token', 'GP', ''));

		$sign = md5($settings['encrypt_key'].$d);
		if($up_token<>$sign){
			echo json_encode(array('ok'=>false,'msg'=>__('upload sign error')));
			exit;
		}

		$dir = rawurldecode(base64_decode($d));
		$dir = str_ireplace(array('./', '.\\', '"'), '', $dir);
		
		$base_dir = PHPDISK_ROOT . $cfg['phpdisk_dir'];
		if ($dir) {
			$base_dir = $base_dir . '/' . $dir;
		}
		if (file_exists($base_dir) && is_dir($base_dir)) {

			$file['name'] = filter_name($file['name']);
			$file_extension = get_extension($file['name']);
			$esp = strlen($file_extension)+1;
			if($file_extension){
				$file_name = substr($file['name'],0,strlen($file['name'])-$esp);
			}else{
				$file_name = $file['name'];
			}
			$file_ext = $file_extension ? '.' . $file_extension : '';

			$dest_file = $base_dir . '/' . str_iconv(rawurldecode($file_name.$file_ext),false);
			$px = '';
			
			if(file_exists($dest_file)){
				if(!$replace_file){
					$px = '_'.random(2);
					$dest_file = $base_dir . '/' . str_iconv(rawurldecode($file_name.$px.$file_ext),false);					

				}
				$replace_str = !$px ? __('replace_upload') : '';
			}			

			if($settings['h5_max_filesize']){
				$up_fileSingleSizeLimit = get_byte_value($settings['h5_max_filesize']);
			}else{
				$up_fileSingleSizeLimit = get_byte_value('500m'); //default
			}
			
			if(!chk_extension_ok_h5($file_extension)){
				echo json_encode(array('ok'=>false,'msg'=>sprintf(__('filetype %s not allow upload'),$file_extension)));
				exit;
			}
			if($file['size']>$up_fileSingleSizeLimit){
				echo json_encode(array('ok'=>false,'msg'=>sprintf(__('file too big %s'),get_size($up_fileSingleSizeLimit))));
				exit;
			}
			if(upload_file($file['tmp_name'],$dest_file)){
				@unlink($file['tmp_name']);
				echo json_encode(array('ok' => true, 'dt' => array('file_name' => $replace_str . $file_name.$px.$file_ext)));
				exit;
			}
		}else{
			echo json_encode(array('ok'=>false,'msg'=>__('upload dir not exist')));
			exit;
		}
		
		break;

	default:
		header('Location: ./');
		exit;

}
