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
#	$Id: file.php 23 2024-12-10 00:32:11Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";


// auth check
if(in_array($act,array('rename_file')) && !$pd_uid) {
	require_once template_echo('my_header', $user_tpl_dir);

    redirect('./', __('check auth error'));
	require_once template_echo('my_footer', $user_tpl_dir);

}

switch ($act){

	case 'rename_file':	
		require_once template_echo('my_header', $user_tpl_dir);

		$d = trim(gpc('d', 'GP', ''));
		$old_file_name = trim(gpc('old_file_name', 'GP', ''));
		$old_file_name_u = str_iconv(rawurldecode(base64_decode($old_file_name)));

		if($task=='rename_file'){
			form_auth(gpc('formhash','P',''),formhash());
			$old_file_name = rawurldecode(base64_decode($old_file_name));
			$file_name = trim(gpc('file_name','P',''));
            $dir = rawurldecode(base64_decode($d));
            $dir = $dir ? $dir .'/' : '';

			if(checklength($file_name,1,250)){
				$error = true;
				$sysmsg[] = __('file_name_error');
			}
            if(has_bad_chars($file_name,$cfg['deny_chars'])){
				$error = true;
				$sysmsg[] = __('Cannot contain special characters');
			}
            if(substr($file_name,0,1)=='.'){
                $error = true;
				$sysmsg[] = __('file_name_start_dot');
            }
            if(is_file(PHPDISK_ROOT . $cfg['phpdisk_dir'] .'/' .$dir.str_iconv($file_name,false))){
                $error = true;
                $sysmsg[] = __('file_exists');
            }
            
            //echo PHPDISK_ROOT . $cfg['phpdisk_dir'] .'/' .str_iconv($dir.$file_name);
			if(!$error){
				$sys_path = PHPDISK_ROOT . $cfg['phpdisk_dir'] .'/' .$dir;
				if($task=='rename_file'){
					if(rename($sys_path.$old_file_name,$sys_path.str_iconv(rawurldecode($file_name),false))){
						$sysmsg[] = __('rename_file_success');
						tb_redirect('reload',$sysmsg);
						return ;
					}

				}
				
				$sysmsg[] = __('rename_file_failed');
				tb_redirect('reload',$sysmsg);
			}else{
				tb_redirect('back',$sysmsg,'f');
			}
		}else{

			require_once template_echo('file',$user_tpl_dir);
		}
		break;

	case 'preview':
		$src_fn = trim(gpc('fn', 'GP', ''));
		$fn = rawurldecode(base64_decode($src_fn));

		$title = str_iconv($fn) .' - '. __('view file');

		$base_dir = PHPDISK_ROOT . $cfg['phpdisk_dir'];
        if ($fn) {
            $dir = $base_dir . '/' . $fn;
        }
		if(file_exists($dir)){
			$ctn = read_file($dir);
		}else{
			$error = true;
		}
		require_once template_echo('my_header',$user_tpl_dir);

		$a_down = 'op.php?act=down&fn='.$src_fn;
		require_once template_echo('file',$user_tpl_dir);
		require_once template_echo('pd_footer',$user_tpl_dir);
		
		break;
	default:
		header('Location: ../');	
}