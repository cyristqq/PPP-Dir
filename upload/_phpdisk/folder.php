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
#	$Id: folder.php 21 2024-12-09 07:51:27Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

// auth check
if(!$pd_uid) {
    die( __('check auth error'));
}
require_once template_echo('my_header', $user_tpl_dir);

switch ($act){

	case 'add_folder':
	case 'rename_folder':	
		$d = trim(gpc('d', 'GP', ''));
		$old_folder_name = trim(gpc('old_folder_name', 'GP', ''));
		$old_folder_name_u = str_iconv(rawurldecode(base64_decode($old_folder_name)));

		if($task=='add_folder'||$task=='rename_folder'){
			form_auth(gpc('formhash','P',''),formhash());
			$old_folder_name = rawurldecode(base64_decode($old_folder_name));
			$folder_name = trim(gpc('folder_name','P',''));
            $dir = rawurldecode(base64_decode($d));
            $dir = $dir ? $dir .'/' : '';

			if(checklength($folder_name,1,250)){
				$error = true;
				$sysmsg[] = __('create_folder_error');
			}
            if(has_bad_chars($folder_name,$cfg['deny_chars'])){
				$error = true;
				$sysmsg[] = __('Cannot contain special characters');
			}
            if(substr($folder_name,0,1)=='.'){
                $error = true;
				$sysmsg[] = __('folder_name_start_dot');
            }
            if(is_dir(PHPDISK_ROOT . $cfg['phpdisk_dir'] .'/' .$dir.str_iconv($folder_name,false))){
                $error = true;
                $sysmsg[] = __('folder_exists');
            }
            
            //echo PHPDISK_ROOT . $cfg['phpdisk_dir'] .'/' .str_iconv($dir.$folder_name);
			if(!$error){
				$sys_path = PHPDISK_ROOT . $cfg['phpdisk_dir'] .'/' .$dir;
				if($task=='add_folder'){
					if(mkdir($sys_path.str_iconv(rawurldecode($folder_name),false),0755)){
						$sysmsg[] = __('create_folder_success');
						tb_redirect('reload',$sysmsg);
						return ;
					}
				}
				if($task=='rename_folder'){
					if(rename($sys_path.$old_folder_name,$sys_path.str_iconv(rawurldecode($folder_name),false))){
						$sysmsg[] = __('rename_folder_success');
						tb_redirect('reload',$sysmsg);
						return ;
					}

				}
				
				$sysmsg[] = __('create_folder_failed');
				tb_redirect('reload',$sysmsg);
			}else{
				tb_redirect('back',$sysmsg,'f');
			}
		}else{

			require_once template_echo('folder',$user_tpl_dir);
		}
		break;

	case 'folder_delete':
		$folder_id = (int)gpc('folder_id','GP',0);
		if($task=='folder_delete'){
			form_auth(gpc('formhash','P',''),formhash());
			$ref = gpc('ref','P','');

			$db->query("update {$tpf}files set is_del=1,folder_id=0 where folder_id='$folder_id' and userid='$pd_uid'");
			$db->query("update {$tpf}folders set parent_id=0 where parent_id='$folder_id' and userid='$pd_uid'");
			$db->query("delete from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid'");

			$sysmsg[] = __('delete_folder_success');
			tb_redirect(urr("mydisk","item=files&menu=file&action=files"),$sysmsg);
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			$folder_name = @$db->get_one("select folder_name from {$tpf}folders where folder_id='$folder_id' and userid='$pd_uid'");
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'modify_folder':
		
		$folder_id = (int)gpc('folder_id','GP',0);
		if($task =='modify_folder'){
			form_auth(gpc('formhash','P',''),formhash());
			$folder_name = trim(gpc('folder_name','P',''));
			$pid = (int)gpc('pid','P',0);

			if(checklength($folder_name,1,150)){
				$error = true;
				$sysmsg[] = __('folder_name_error');
			}elseif(strpos($folder_name,"'")!==false){
				$error = true;
				$sysmsg[] = __('Cannot contain special characters');
			}
			if($folder_id==$pid){
				$error = true;
				$sysmsg[] = __('folder_id_pid_not_same');
			}
			$num = @$db->get_one("select count(*) from {$tpf}folders where folder_name='$folder_name' and folder_id<>'$folder_id' and userid='$pd_uid'");
			if($num){
				$error = true;
				$sysmsg[] = __('folder_exists');
			}

			if(!$error){
				$ins = array(
				'folder_name' => $folder_name,
				'parent_id' => $pid,
				);
				$db->query("update {$tpf}folders set ".$db->sql_array($ins)." where folder_id='$folder_id' and userid='$pd_uid'");

				tb_redirect('reload',__('modify_folder_success'));
			}else{
				tb_redirect('back',$sysmsg,'f');
			}
		}else{

			$fd = $db->get_row("select folder_name,parent_id from {$tpf}folders where folder_id='$folder_id' limit 1");
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	default:
		header('Location: ../');
}