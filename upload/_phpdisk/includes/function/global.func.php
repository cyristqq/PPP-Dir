<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Chinese Website: http://www.phpdisk.com
#
#	International Website: http://www.phpdisk.net
#
#	Author: Along ( admin@phpdisk.com )
#
#	$Id: global.func.php 33 2024-12-11 02:33:32Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}

function template_echo($tpl,$tpl_dir,$app='',$is_admin_tpl=0){
	if($app){
		$tpl_cache_dir = PHPDISK_ROOT."_phpdisk/system/plugins/$app/";
		$tpl_src_dir = PHPDISK_ROOT."_phpdisk/plugins/$app/";
	}else{
		$tpl_cache_dir = $tpl_cache_dir_tmp = PHPDISK_ROOT.'_phpdisk/system/'.$tpl_dir;
		$tpl_src_dir = PHPDISK_ROOT.$tpl_dir;
		//$arr = explode('/',$tpl_dir);
		$tpl_default_dir = PHPDISK_ROOT.$tpl_dir;
		$admin_tpl_dir = PHPDISK_ROOT.'_phpdisk/templates/admin/';
	}
	if(strpos($tpl,'/')!==false){
		$tpl_cache_dir_tmp = $tpl_cache_dir_tmp.substr($tpl,0,strlen($tpl)-strlen(strrchr($tpl,'/'))).'/';
	}
	make_dir($tpl_cache_dir_tmp);
	make_dir($tpl_cache_dir);

	$tpl_cache_file = $tpl_cache_dir.$tpl.'.tpl.php';
	$tpl_src_file = $tpl_src_dir.$tpl.'.tpl.php';
	if(!$app){
		if($is_admin_tpl && !file_exists($tpl_src_file)){
			$tpl_src_file = $admin_tpl_dir.$tpl.'.tpl.php';
		}elseif(!file_exists($tpl_src_file)){
			$tpl_src_file = $tpl_default_dir.$tpl.'.tpl.php';
		}
	}
	if(@filemtime($tpl_cache_file) < @filemtime($tpl_src_file)){
		write_file($tpl_cache_file,template_parse($tpl_src_file,$tpl_dir));
		return $tpl_cache_file;
	}
	if(file_exists($tpl_cache_file)){
		return $tpl_cache_file;
	}else{
		$str = strrchr($tpl_cache_file,'/');
		$str = substr($str,1,strlen($str));
		die("PHPDisk Template echo : <b>$tpl_dir -> $tpl_cache_file</b> not Exists!");
	}

}

function template_parse($tpl,$tpl_dir){
	//global $user_tpl_dir;
	if(!file_exists($tpl)){
		exit('PHPDisk Template parse : ['.$tpl.'] not exists!');
	}
	$str = read_file($tpl);

	if(file_exists(PHPDISK_ROOT.$tpl_dir.'core.tpl.php') && substr(strrchr($tpl,'/'),1)=='pd_header.tpl.php'){
		return $str;
	}else{
		$str = preg_replace("/\<\!\-\-\#include (.+?)\#\-\-\>/si","<?php require_once template_echo('\\1','$tpl_dir'); ?>", $str);
		$str = preg_replace("/\<\!\-\-\#(.+?)\#\-\-\>/si","<?php \\1 ?>", $str);
		$str = preg_replace("/\{([A-Z_]+)\}/","<?=\\1?>",$str);
		$str = preg_replace("/\{(\\\$[a-z0-9_\'\"\[\]]+)\}/si", "<?=\\1?>", $str);
		$str = preg_replace("/\{\<\?\=(\\\$[a-z0-9_\'\"\[\]]+)\?\>\}/si","{\\1}",$str);
		$str = preg_replace("/\{\#(.+?)\#\}/si","<?=\\1?>", $str);

		$prefix = "<?php ".LF;
		$prefix .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF.LF;
		$prefix .= "// Cache Time:".date('Y-m-d H:i:s').LF.LF;
		$prefix .= "!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');".LF.LF;
		$prefix .= "?>".LF;
		return $prefix.$str;
	}
}

function form_auth($p_formhash,$formhash){
	if($p_formhash != $formhash){
		exit(__('system_error'));
	}
}
function convert_str($in,$out,$str){
	global $db;
	if(DEFAULT_LANG=='zh_cn'){
		$str = addslashes($str);
		if(function_exists("iconv")){
			$str = iconv($in,$out,$str);
		}elseif(function_exists("mb_convert_encoding")){
			$str = mb_convert_encoding($str,$out,$in);
		}
	}
	return $str;
}

function is_utf8(){
	global $charset;
	return (strtolower($charset) == 'utf-8') ? true : false;
}
function str_iconv($str,$g2u = TRUE){
	if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ){
		if($g2u === TRUE) {			
			if(function_exists("mb_convert_encoding")){
				$str = mb_convert_encoding($str, 'utf-8' , 'gbk' ) ? mb_convert_encoding($str, 'utf-8' , 'gbk' ) : $str;
			}elseif(function_exists("iconv")){
				$str = iconv('gbk' , 'utf-8' , $str ) ? iconv('gbk' , 'utf-8' , $str ) : $str;
			}
		}else if($g2u === FALSE) {
			if(function_exists("mb_convert_encoding")){
				$str = mb_convert_encoding($str , 'gbk' , 'utf-8') ? mb_convert_encoding($str , 'gbk' , 'utf-8') : $str ;
			}elseif(function_exists("iconv")){
				$str = iconv( 'utf-8' , 'gbk' ,$str ) ? iconv( 'utf-8' , 'gbk' ,$str ) : $str;
			}
		}
	}
	return $str;
}

function is_windows(){
	return (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 1 : 0;
}

function word_style($i,$type ='font'){
	switch($i){
		case 500:
			$f_px = "25px";
			$c_col = '#ff6600';
			break;
		case 300:
			$f_px = "20px";
			$c_col = '#ff5500';
			break;
		case 100:
			$f_px = "18px";
			$c_col = '#003366';
			break;
		case 50:
			$f_px = "14px";
			$c_col = '#003366';
			break;
		default:
			$f_px = "12px";
			$c_col = '#666666';
	}
	return ($type =='font') ? $f_px : $c_col;
}
function page_end_time(){
	global $ps_time,$db,$C;
	return 'Processed in '.get_runtime('start','end').' second(s), '.$db->querycount.' queries, Gzip '.$C['gz']['status'];
}

function replace_inject_str($str){
	$bad_chars = array("\\","'",'"','/','*',',','<','>',"\r","\t","\n",'$','(',')','%','?',';','^','#',':','&');
	return str_replace($bad_chars,'',$str);
}

function checklength($str,$min,$max){
	if(!$str || strlen($str) > $max || strlen($str) < $min){
		return true;
	}
}
function ifselected($int1,$int2,$type = 'int'){
	if($type == 'int'){
		if(intval($int1) == intval($int2)){
			return ' selected';
		}
	}elseif($type == 'str'){
		if(strval($int1) == strval($int2)){
			return ' selected';
		}
	}
}
function ifchecked($int1,$int2,$type = 'int'){
	if($type == 'int'){
		if(intval($int1) == intval($int2)){
			return ' checked';
		}
	}elseif($type == 'str'){
		if(strval($int1) == strval($int2)){
			return ' checked';
		}
	}
}
function multi_selected($id,$str){
	if(strpos($str,',')){
		$a2 = explode(',',$str);
		$rtn = in_array($id,$a2) ? ' selected' : '';
	}else{
		$rtn = $id==$str ? ' selected' : '';
	}
	return $rtn;
}

function replace_js($str){
	$str = preg_replace("'<script[^>]*?>(.*?)</script>'si","[script]\\1[/script]",$str);
	return preg_replace("'<iframe[^>]*?>(.*?)</iframe>'si","[iframe]\\1[/iframe]",$str);
}
function get_byte_value($v){
	$v = trim($v);
	$l = strtolower($v[strlen($v) - 1]);
	switch($l){
		case 't':
			$v *= 1024;
		case 'g':
			$v *= 1024;

		case 'm':
			$v *= 1024;

		case 'k':
			$v *= 1024;
	}
	return $v;
}
function adm_redirect($url,$str,$timeout = 2000,$target = ''){

	global $admin_tpl_dir,$curr_script;

	if($timeout ==0){
		header("Location:$url");
		exit;
	}else{
		$msg = '';
		if(is_array($str)){
			for($i=0;$i<count($str);$i++){
				$msg .= "<p>".$str[$i]."</p>".LF;
			}
		}else{
			$msg = $str;
		}
		$go_url = $url=='back' ? $url = 'javascript:history.back();' : $url;
		require_once template_echo('information',$admin_tpl_dir);
		$rtn = "<script>".LF;
		$rtn .= "<!--".LF;
		$rtn .= "function redirect() {".LF;
		if($target =='top'){
			$rtn .= "	top.document.location.href = '$go_url';".LF;
		}else{
			$rtn .= "	document.location.href = '$go_url';".LF;
		}
		$rtn .= "}".LF;
		$rtn .= "setTimeout('redirect();', $timeout);".LF;
		$rtn .= "-->".LF;
		$rtn .= "</script>".LF;
		echo $rtn;
	}
}
function redirect($url,$str,$timeout = 2000,$target = ''){
	global $user_tpl_dir,$curr_script;

	if($timeout ==0){
		header("Location:$url");
		exit;
	}else{
		$msg = '';
		if(is_array($str)){
			for($i=0;$i<count($str);$i++){
				$msg .= "<p>".$str[$i]."</p>".LF;
			}
		}else{
			$msg = $str;
		}
		$go_url = $url=='back' ? $url = 'javascript:history.back();' : $url;
		require_once template_echo('information',$user_tpl_dir);
		$rtn = "<script>".LF;
		$rtn .= "<!--".LF;
		$rtn .= "function redirect() {".LF;
		if($target =='top'){
				$rtn .= "	top.document.location.href = '$go_url';".LF;
		}else{
			$rtn .= "	document.location.href = '$go_url';".LF;
		}
		$rtn .= "}".LF;
		$rtn .= "setTimeout('redirect();', $timeout);".LF;
		$rtn .= "-->".LF;
		$rtn .= "</script>".LF;
		echo $rtn;
	}
}

function tb_redirect($url,$str,$status='ok',$timeout=2000){
	if(is_array($str)){
		for($i=0;$i<count($str);$i++){
			$msg .= "<dt>".$str[$i]."</dt>".LF;
		}
	}else{
		$msg = $str;
	}
	$go_url = $url=='back' ? 'javascript:history.back();' : $url;
	$rtn = '';
	if($status=='f'){
		$rtn .= '<div class="alert alert-danger m-2">';
		$rtn .= '<div style="text-align:center"><i class="bx bx-x-circle bx-md"></i></div>';
	}else{
		$rtn .= '<div class="alert alert-info m-2">';
		$rtn .= '<div style="text-align:center"><i class="bx bx-check-circle bx-md"></i></div>';
	}
	$rtn .= '<dl style="text-align:center;margin-top:5px;">'.$msg.'</dl></div>'.LF;
	$rtn .= "<script>".LF;
	$rtn .= "<!--".LF;
	$rtn .= '$(document).ready(function(){$(".row").css({"display":"block"})});'.LF;
	$rtn .= "function redirect() {".LF;
	//$rtn .= $url=='back' ? 'javascript:history.back();'.LF : $url;
	if($url =='reload'){
		$rtn .= " top.document.location.reload();";
	}else{
		$rtn .= "	top.document.location = '$go_url';".LF;
	}
	$rtn .= "}".LF;
	if($timeout){
		$rtn .= "setTimeout('redirect();', $timeout);".LF;
	}
	$rtn .= "-->".LF;
	$rtn .= "</script>".LF;
	echo $rtn;
}
function is_bad_chars($str){
	$bad_chars = array("\\",' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'$','(',')','%','+','?',';','^','#',':','　','`','=','|','-','_','.');
	foreach($bad_chars as $value){
		if (strpos($str,$value) !== false){
			return true;
		}
	}
}
function get_extension($name){
	return strtolower(trim(strrchr($name, '.'), '.'));
}
function formhash(){
	global $pd_uid,$pd_pwd;
	return substr(md5(substr(time(), 0, -7).$pd_uid.$pd_pwd), 8, 8);
}
function encode_pwd($str){
	global $settings;
	$len = trim($str) ? strlen($str) : 6;
	if($settings['online_demo']){
		$rtn = str_repeat('*',$len);
	}else{
		if($len <=4){
			$rtn = str_repeat('*',$len);
		}elseif($len <=10){
			$rtn = str_repeat('*',$len-4);
			$rtn .= substr($str,-4);
		}else{
			$rtn = str_repeat('*',$len-6);
			$rtn .= substr($str,-6);
		}
	}
	return $rtn;
}
function random($length){
	$seed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str = "";
	while(strlen($str) < $length){
		$str .= substr($seed,(mt_rand() % strlen($seed)),1);
	}
	return $str;
}

function addslashes_array(&$array) {
	if(is_array($array)){
		foreach($array as $k => $v) {
			$array[$k] = addslashes_array($v);
		}
	}elseif(is_string($array)){
		$array = addslashes($array);
	}
	return $array;
}

function get_size($s,$u='B',$p=2){
	$us = array('B'=>'K','K'=>'M','M'=>'G','G'=>'T');
	return (($u!=='B')&&(!isset($us[$u]))||($s<1024))?@(number_format($s,$p)." $u"):(get_size($s/1024,$us[$u],$p));
}

function checkemail($email) {
	if((strlen($email) > 6) && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email)){
		return true;
	}else{
		return false;
	}
}

function defend_xss($val){
	return is_array($val) ? $val : htmlspecialchars($val);
}

function gpc($name,$w = 'GPC',$default = '',$d_xss=1){
	for($i = 0; $i < strlen($w); $i++) {
		if($w[$i] == 'G' && isset($_GET[$name])) return $d_xss ? defend_xss($_GET[$name]) : $_GET[$name];
		if($w[$i] == 'P' && isset($_POST[$name])) return $d_xss ? defend_xss($_POST[$name]) : $_POST[$name];
		if($w[$i] == 'C' && isset($_COOKIE[$name])) return $d_xss ? defend_xss($_COOKIE[$name]) : $_COOKIE[$name];
	}
	return $default;
}
function get_ip(){
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$onlineip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$onlineip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	$onlineip = addslashes($onlineip);
	@preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
	$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
	unset($onlineipmatches);
	return $onlineip;
}

function pd_setcookie($var, $value, $expires = 0,$cookiepath = '/') {
	global $timestamp,$cfg;
	$cookie_domain = $cfg['cookie_domain'] ? '.'.$cfg['cookie_domain'] : '';
	setcookie($var, $value,$expires ? ($timestamp + $expires) : 0,$cookiepath,$cookie_domain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}

function pd_encode($string, $operation = 'ENCODE',$key = ''){
	global $settings;
	$ckey_length = 4;
	$key = md5($key ? $key : ($settings['encrypt_key'] ? $settings['encrypt_key'] : 'PHPDisk3p=Rc0o'));

	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d',0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$arr = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $arr[$i] + $rndkey[$i]) % 256;
		$tmp = $arr[$i];
		$arr[$i] = $arr[$j];
		$arr[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $arr[$a]) % 256;
		$tmp = $arr[$a];
		$arr[$a] = $arr[$j];
		$arr[$j] = $tmp;

		$result .= chr(ord($string[$i]) ^ ($arr[($arr[$a] + $arr[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {

		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function cutstr($string, $length, $dot = '...',$charset='utf-8') {
	if(strlen($string) <= $length) {
		return $string;
	}
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	if(strtolower($charset) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length - strlen($dot) - 1; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	return $strcut.$dot;
}

function multi($total, $perpage, $curpage, $mpurl) {
	global $auth,$curr_script;
	$multipage = '';
	$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
	if($total > $perpage) {
		$pg = 10;
		$offset = 5;
		$pgs = @ceil($total / $perpage);
		if($pg > $pgs) {
			$from = 1;
			$to = $pgs;
		} else {
			$from = $curpage - $offset;
			$to = $curpage + $pg - $offset - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if(($to - $from) < $pg && ($to - $from) < $pgs) {
					$to = $pg;
				}
			} elseif($to > $pgs) {
				$from = $curpage - $pgs + $to;
				$to = $pgs;
				if(($to - $from) < $pg && ($to - $from) < $pgs) {
					$from = $pgs - $pg + 1;
				}
			}
		}
		if($auth['tpl_style']=='bs'|| $curr_script==ADMINCP){
			$multipage = ($curpage - $offset > 1 && $pgs > $pg ? '<li class="paginate_button page-item "><a href="'.$mpurl.'pg=1" class="page-link">&laquo;</a></li>' : '').($curpage > 1 ? '<li class="paginate_button page-item "><a href="'.$mpurl.'pg='.($curpage - 1).'" class="page-link">&#8249;</a></li>' : '');
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '<li class="paginate_button page-item active"><span class="page-link ">'.$i.'</span></li>' : '<li class="paginate_button page-item "><a href="'.$mpurl.'pg='.$i.'" class="page-link">'.$i.'</a></li>';
			}
			$multipage .= ($curpage < $pgs ? '<li class="paginate_button page-item "><a href="'.$mpurl.'pg='.($curpage + 1).'" class="page-link">&#8250;</a></li>' : '').($to < $pgs ? '<li class="paginate_button page-item "><a href="'.$mpurl.'pg='.$pgs.'" class="page-link">&raquo;</a></li>' : '');
			$multipage = $multipage ? '<ul class="pagination "><li class="paginate_button page-item page-link">Total:&nbsp;<b>'.$total.'</b>&nbsp;</li>'.$multipage.'</ul>' : '';

		}elseif($auth['tpl_style']=='pt'){
			$multipage = ($curpage - $offset > 1 && $pgs > $pg ? '<li><a href="'.$mpurl.'pg=1" >'.__('First').'</a></li>' : '').($curpage > 1 ? '<li><a href="'.$mpurl.'pg='.($curpage - 1).'" ><i class="icon-double-angle-left"></i></a></li>' : '');
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '<li class="active"><a href="#">'.$i.'</a></li>' : '<li><a href="'.$mpurl.'pg='.$i.'">'.$i.'</a></li>';
			}
			$multipage .= ($curpage < $pgs ? '<li><a href="'.$mpurl.'pg='.($curpage + 1).'"><i class="icon-double-angle-right"></i></a></li>' : '').($to < $pgs ? '<li><a href="'.$mpurl.'pg='.$pgs.'">'.__('End').'</a></li>' : '');
			$multipage = $multipage ? '<div class="span5"><div class="dataTables_info" id="table_files_info">'.__('Total').' : '.$total.','.__('perpage').$perpage.__('row').'</div></div><div class="span7"><div class="dataTables_paginate paging_bootstrap pagination"><ul>'.$multipage.'</ul></div></div>' : '';
			
		}else{
			$multipage = ($curpage - $offset > 1 && $pgs > $pg ? '<a href="'.$mpurl.'pg=1" class="p_redirect">&laquo;</a>' : '').($curpage > 1 ? '<a href="'.$mpurl.'pg='.($curpage - 1).'" class="p_redirect">&#8249;</a>' : '');
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '<span class="p_curpage">'.$i.'</span>' : '<a href="'.$mpurl.'pg='.$i.'" class="p_num">'.$i.'</a>';
			}
			$multipage .= ($curpage < $pgs ? '<a href="'.$mpurl.'pg='.($curpage + 1).'" class="p_redirect">&#8250;</a>' : '').($to < $pgs ? '<a href="'.$mpurl.'pg='.$pgs.'" class="p_redirect">&raquo;</a>' : '');
			$multipage = $multipage ? '<div class="p_bar"><span class="p_info">Total:&nbsp;<b>'.$total.'</b>&nbsp;</span>'.$multipage.'</div>' : '';
		}
		return $multipage;
	}
}
function is_today($time){
	return (date('Ymd') == date('Ymd',$time)) ? 1 : 0;
}
function get_ids_arr($arr,$msg,$str_in_db=0){
	$error = 0;
	//print_r(count($arr));
	if(!count($arr)){
		$error = 1;
		$strs = $msg;
	}else{
		$strs = '';
		for($i=0;$i<count($arr);$i++){
			if(is_numeric($arr[$i])){
				$strs .= $str_in_db ? (int)$arr[$i]."," : "'".(int)$arr[$i]."',";
			}else{
				$strs .= $str_in_db ? (int)$arr[$i]."," : "'".addslashes($arr[$i])."',";
			}
		}
		if($strs){
			$strs = substr($strs,0,-1);
		}else{
			$error = 1;
			$strs = $msg;
		}
	}
	return array($error,$strs);
}



function get_real_ext($file_extension){
	global $settings;
	$file_extension = trim($file_extension);
	if($file_extension){
		$exts = explode(',',$settings['filter_extension']);
		if(in_array($file_extension,$exts)){
			$file_ext = '.'.$file_extension.'.txt';
		}else{
			$file_ext = '.'.$file_extension;
		}
	}else{
		$file_ext = '.txt';
	}
	return $file_ext;
}
function get_file_name($file_name,$file_ext){
	$tmp_ext = $file_ext ? '.'.$file_ext: '';
	return $file_name.$tmp_ext;
}

function file_icon($ext,$fd = 'filetype',$align='absmiddle'){
	$icon = PHPDISK_ROOT."_phpdisk/static/img/{$fd}/".$ext.".gif";
	if(file_exists($icon)){
		$img = "<img src='_phpdisk/static/img/{$fd}/{$ext}.gif' align='{$align}' border='0' />";
	}else{
		$img = "<img src='_phpdisk/static/img/{$fd}/file.gif' align='{$align}' border='0' />";
	}
	return $img;
}


function file_icon_min($ext,$fd = 'filetype'){
	$icon = PHPDISK_ROOT."_phpdisk/static/img/{$fd}/".$ext.".gif";
	if(file_exists($icon)){
		$img = $ext;
	}else{
		$img = 'file';
	}
	return $img;
}


function get_rank($rank){
	if($rank){
		$sun = floor($rank/16);
		$moon = floor(($rank-16*$sun)/4);
		$star = $rank-16*$sun-4*$moon;
		$rtn = str_repeat('<img src="images/lv_sun.gif" align="absmiddle" border="0">',$sun);
		$rtn .= str_repeat('<img src="images/lv_moon.gif" align="absmiddle" border="0">',$moon);
		$rtn .= str_repeat('<img src="images/lv_star.gif" align="absmiddle" border="0">',$star);
	}else{
		$rtn = '<span class="f10">N/A</span>';
	}
	return $rtn;
}

function send_email($to,$subject,$body){
	global $settings;
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	$mail->CharSet = 'utf-8';
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;
	//Ask for HTML-friendly debug output
	$mail->Debugoutput = 'html';
	//Set the hostname of the mail server
	$mail->Host = trim($settings['email_smtp']);
	//Set the SMTP port number - likely to be 25, 465 or 587
	$mail->Port = (int)$settings['email_port'];
	if($settings['email_ssl']){
		$mail->SMTPSecure = $settings['email_ssl'];
	}
	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;
	//Username to use for SMTP authentication
	$mail->Username = $settings['email_address'];
	//Password to use for SMTP authentication
	$mail->Password = $settings['email_pwd'];//
	//Set who the message is to be sent from
	$mail->setFrom($settings['email_address']);
	//Set an alternative reply-to address
	//$mail->addReplyTo($settings['email_address']);
	//Set who the message is to be sent to
	$mail->addAddress($to);
	//Set the subject line
	$mail->Subject = $subject;
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML($body);
	//Replace the plain text body with one created manually
	//$mail->AltBody = $body;
	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');

	//send the message, check for errors
	if (!$mail->send()) {
		return "Mailer Error: " . $mail->ErrorInfo;
	} else {
		return 'success';
	}
}

function make_dir($path,$write_file=1){
	if(!is_dir($path)){
		$str = dirname($path);
		if($str){
			make_dir($str.'/');
			@mkdir($path,0777);
			chmod($path,0777);
			if($write_file){
				write_file($path.'index.htm','PHPDisk');
			}
		}
	}
}

function get_order_number(){
	$arr = explode(' ',microtime());
	return date('YmdHis',$arr[1]).substr($arr[0],2,6);
}

function read_file($f) {
	if (file_exists($f)) {
		if (PHP_VERSION >= "4.3.0") return file_get_contents($f);
		$fp = @fopen($f,"rb");
		$fsize = @filesize($f);
		$c = @fread($fp, $fsize);
		@fclose($fp);
		return $c;
	} else{
		exit("<b>$f</b> does not exist!");
	}
}

function write_file($f,$str,$mode = 'wb') {
	$fp = @fopen($f,$mode);
	if (!$fp) {
		exit("Can not open file <b>$f</b> .code:1");
	}
	if(is_writable($f)){
		if(!@fwrite($fp,$str)){
			exit("Can not write file <b>$f</b> .code:2");
		}
	}else{
		exit("Can not write file <b>$f</b> .code:3");
	}
	@fclose($fp);
}
function upload_file($source, $target) {
	if (function_exists('move_uploaded_file') && @move_uploaded_file($source, $target)) {
		@chmod($target, 0666);
		return $target;
	} elseif (@copy($source, $target)) {
		@chmod($target, 0666);
		return $target;
	} elseif (@is_readable($source)) {
		if ($fp = @fopen($source,'rb')) {
			@flock($fp,2);
			$filedata = @fread($fp,@filesize($source));
			@fclose($fp);
		}
		if ($fp = @fopen($target, 'wb')) {
			@flock($fp, 2);
			@fwrite($fp, $filedata);
			@fclose($fp);
			@chmod ($target, 0666);
			return $target;
		} else {
			return false;
		}
	}
}

function ip_encode($ip){
	global $pd_gid;
	if($pd_gid==1){
		return $ip;
	}else{
		$arr = explode('.',$ip);
		for($i=0;$i<count($arr)-1;$i++){
			return $arr[0].'.*.*.*';
		}
	}
}
function clear_html($str,$len=50){
	return str_replace("\r\n",' ',cutstr(preg_replace("/<.+?>/i","",$str),$len));
}

function select_tpl($name){
	global $db,$tpf,$settings,$tpl_type_arr,$tpl_info;
	$rs0 = $db->get_all("select * from {$tpf}templates where tpl_type='{$name}'");
	$tpl_sw_ = array();
	foreach($rs0 as $rs){
		$file = PHPDISK_ROOT."templates/{$rs['tpl_name']}/template_info.php";
		if(file_exists($file)){
			require_once $file;
		}
		$arr = get_template_info($rs['tpl_name'],$tpl_info[$rs['tpl_name']]);
		
		$add = $tpl_type_arr[$name] ? "[{$tpl_type_arr[$name]}]" : '';
		$rs['tpl_title'] = $arr['tpl_title'].$add;
		if($name=='mydisk'){
			$rs['tpl_href'] = $settings['phpdisk_url'].'mydisk.php?tpl='.$rs['tpl_name'].'&ref='.base64_encode($_SERVER['REQUEST_URI']);
		}else{
			$rs['tpl_href'] = $settings['phpdisk_url'].'?tpl='.$rs['tpl_name'].'&ref='.base64_encode($_SERVER['REQUEST_URI']);
		}
		if($arr['authed_tpl']==2 ||!$arr['authed_tpl']){
			$tpl_sw_[] = $rs;
		}
	}	
	unset($rs0);
	return $tpl_sw_;
}
function select_lang(){
	global $db,$tpf,$settings,$lang_info;
	$rs0 = $db->get_all("select * from {$tpf}langs");
	$langs_sw = array();
	foreach($rs0 as $rs){
		$file = PHPDISK_ROOT."languages/{$rs['lang_name']}/lang_info.php";
		if(file_exists($file)){
			require_once $file;
		}
		$arr = get_lang_info($rs['lang_name'],$lang_info[$rs['lang_name']]);
		$rs['lang_txt'] = $arr['lang_title'];
		$rs['lang_href'] = $settings['phpdisk_url'].'?lang='.$rs['lang_name'].'&ref='.base64_encode($_SERVER['REQUEST_URI']);
		$langs_sw[] = $rs;
	}
	
	unset($rs0);
	return $langs_sw;
}
function check_template($tpl_name){
	$dir = PHPDISK_ROOT."templates/{$tpl_name}/";
	if(file_exists($dir.'template_info.php') && $tpl_name !='.' && $tpl_name !='..'){
		$rtn = 1;
	}else{
		$rtn = 0;
	}
	return $rtn;
}
function check_lang($lang_name){
	$dir = PHPDISK_ROOT."languages/{$lang_name}/";
	if(file_exists($dir.'./lang_info.php') && $lang_name !='.' && $lang_name !='..'){
		$rtn = 1;
	}else{
		$rtn = 0;
	}
	return $rtn;
}

function filter_name($str){
	global $cfg;
	return str_ireplace($cfg['deny_chars'],'',$str);
}

function super_admin(){
	global $adminset,$pd_uid;
	$arr = explode(',',$adminset[super_adminid]);
	if(in_array($pd_uid,$arr)){
		return true;
	}else{
		return false;
	}
}


function is_mobile(){
	$pattern = "/(Mobile|Android|iPhone|iPod|iPad|BlackBerry|Windows Phone)/i";
    return preg_match($pattern, strtolower($_SERVER['HTTP_USER_AGENT']));

}
function filter_word($str){
	global $settings;
	if(!empty($settings['filter_word'])){
		$arr = explode(',', $settings['filter_word']);
		foreach($arr as $k=>$v){
			$str = str_ireplace($v, '*', $str);
		}
	}
	return $str;
}

function dir_writeable($dir) {
	if(!is_dir($dir)) {
		@mkdir($dir, 0777);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/phpdisk.test", 'w')) {
			@fclose($fp);
			@unlink("$dir/phpdisk.test");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}
function seo_filter($str){
	return str_replace('"','',$str);
}


function is_ie(){
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')===false){
		return false;
	}else{
		return true;
	}
}


function arr2str($arr,$one=0){
	if(is_array($arr)){
		if($one){
			$rtn = '<li>'.$arr[0].'</li>';
		}else{
			for ($i=0;$i<count($arr);$i++){
				$rtn .= '<li>'.$arr[$i].'</li>';
			}
		}
	}else{
		$rtn = $arr;
	}
	return $rtn;
}
function app_arr2str($arr,$one=0){
	if(is_array($arr)){
		if($one){
			$rtn = '> '.$arr[0].LF;
		}else{
			for ($i=0;$i<count($arr);$i++){
				$rtn .= $arr[$i] ? '> '.$arr[$i].LF : '';
			}
		}
	}else{
		$rtn = $arr;
	}
	return $rtn;
}

function get_day_hour($time){
	$hour = $time%24;
	$day = floor($time/24);
	$day = $day ? $day.__('day') : '';
	$hour = $hour ? $hour.__('hour') : '';
	return $day.$hour;
}


function num2star($view){
	global $auth;
	if($auth['core']=='pt'){
		$star = '<i class="icon-star orange"></i>';
		if($view>1000){
			$rtn = str_repeat($star,5);
		}elseif($view>100){
			$rtn = str_repeat($star,4);
		}else{
			$rtn = str_repeat($star,3);
		}
	}else{
		$star = '<img src="images/lv_star.gif" align="absmiddle" />';
		if($view>1000){
			$rtn = str_repeat($star,5);
		}elseif($view>100){
			$rtn = str_repeat($star,4);
		}else{
			$rtn = str_repeat($star,3);
		}
	}
	return $rtn;
}

function get_values_arr($arr,$msg,$str_in_db=0){
	$error = 0;
	if(!count($arr)){
		$error = 1;
		$strs = $msg;
	}else{
		for($i=0;$i<count($arr);$i++){
			$strs .= $str_in_db ? $arr[$i]."," : "'".$arr[$i]."',";
		}
		$strs = substr($strs,0,-1);
	}
	return array($error,$strs);
}

function phpdisk_md5($str){
	global $settings;
	$key = $settings['encrypt_key'] ? $settings['encrypt_key'] : md5('1Phpdisko$_Salt9');
	return md5(md5($str).$key);
}
function phpdisk_encrypt($data, $expire = 0) {
	global $settings;
	$key  = $settings[phpdisk_urr_key] ? md5($settings[phpdisk_urr_key]) : md5('imphpdisk2099Ax');
	$data = base64_encode($data);
	$x    = 0;
	$len  = strlen($data);
	$l    = strlen($key);
	$char = '';
	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}
	$str = sprintf('%010d', $expire ? $expire + time():0);
	for ($i = 0; $i < $len; $i++) {
		$str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
	}
	return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

function phpdisk_decrypt($data){
	global $settings;
	$key  = $settings[phpdisk_urr_key] ? md5($settings[phpdisk_urr_key]) : md5('imphpdisk2099Ax');
	$data   = str_replace(array('-','_'),array('+','/'),$data);
	$mod4   = strlen($data) % 4;
	if ($mod4) {
		$data .= substr('====', $mod4);
	}
	$data   = base64_decode($data);
	$expire = substr($data,0,10);
	$data   = substr($data,10);
	if($expire > 0 && $expire < time()) {
		return '';
	}
	$x      = 0;
	$len    = strlen($data);
	$l      = strlen($key);
	$char   = $str = '';
	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}
	for ($i = 0; $i < $len; $i++) {
		if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
			$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
		}else{
			$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
		}
	}
	return base64_decode($str);
}

function chk_extension_ok_h5($ext){
	global $settings;
	$can_upload = false;
	$ext = strtolower($ext);
	if(strtolower($settings['h5_upload_ext'])){
		$arr = explode(',',$settings['h5_upload_ext']);
		if(in_array($ext,$arr)){
			$can_upload = true;
		}
	}else{
		$can_upload = true;
	}
	return $can_upload;
}

if (!function_exists('hash_equals')) {
	function hash_equals($str1, $str2) {
		if (strlen($str1) != strlen($str2)) {
			return false;
		} else {
			$res = $str1 ^ $str2;
			$ret = $res;
			for ($i = 1; $i < strlen($res); $i++) {
				$ret |= $res << $i;
				$ret |= $res >> (strlen($res) - $i);
			}
			return $ret === 0;
		}
	}
}
if (!function_exists('getallheaders')){
	function getallheaders()
	{
		$headers = [];
		foreach ($_SERVER as $name => $value)
		{
			if (substr($name, 0, 5) == 'HTTP_')
			{
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
}

function get_template_info($tpl_name,$data){
	global $db,$tpf,$tpl_settings;

	//$actived = (int)@$db->get_one("select actived from {$tpf}templates where tpl_name='$tpl_name' limit 1");
	$tmp_arr = explode(',',$data['suitable_core']);
	$can_run = in_array(PHPDISK_CORE, $tmp_arr) ? true : false;
	$arr = array(
			'tpl_title' => $data['tpl_title'],
			'tpl_url' => $data['tpl_url'],
			'tpl_desc' => $data['tpl_desc'],
			'tpl_author' => $data['tpl_author'],
			'tpl_site' => $data['tpl_site'],
			'tpl_version' => $data['tpl_version'],
			'tpl_type' => $data['tpl_type'],
			'tpl_dir' => $tpl_name,
			'phpdisk_core' => $data['phpdisk_core'],
			'tpl_style' => $data['tpl_style'],
			'tpl_cate' => $data['tpl_cate'],
			'actived' => $tpl_settings[$tpl_name]['actived'],
			'can_run' => $can_run,
	);

	return $arr;
}

function get_lang_info($lang_name,$data){
	global $db,$tpf,$lang_settings;

	//$actived = (int)@$db->get_one("select actived from {$tpf}langs where lang_name='$lang_name' limit 1");
	$tmp_arr = explode(',',$data[suitable_core]);
	$can_run = in_array(PHPDISK_CORE, $tmp_arr) ? true : false;
	$arr = array(
			'lang_title' => $data[lang_title],
			'lang_url' => $data[lang_url],
			'lang_desc' => $data[lang_desc],
			'lang_author' => $data[lang_author],
			'lang_site' => $data[lang_site],
			'lang_version' => $data[lang_version],
			'lang_dir' => $data[lang_dir],
			'phpdisk_core' => $data[phpdisk_core],
			'actived' => $lang_settings[$lang_name][actived],
			'can_run' => $can_run,
	);
	return $arr;
}



function mydebug($str){
	write_file(PHPDISK_ROOT.'system/debug.txt',$str,'ab');
}

function multi_ajax($action,$total, $perpage, $curpage ) {
	$multipage = '';
	//$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
	if($total > $perpage) {
		$pg = 10;
		$offset = 5;
		$pgs = @ceil($total / $perpage);
		if($pg > $pgs) {
			$from = 1;
			$to = $pgs;
		} else {
			$from = $curpage - $offset;
			$to = $curpage + $pg - $offset - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if(($to - $from) < $pg && ($to - $from) < $pgs) {
					$to = $pg;
				}
			} elseif($to > $pgs) {
				$from = $curpage - $pgs + $to;
				$to = $pgs;
				if(($to - $from) < $pg && ($to - $from) < $pgs) {
					$from = $pgs - $pg + 1;
				}
			}
		}

		$multipage = ($curpage - $offset > 1 && $pgs > $pg ? '<a href="javascript:;" onclick="'.$action.'(1);" class="p_redirect">&laquo;</a>' : '').($curpage > 1 ? '<a href="javascript:;" onclick="'.$action.'('.($curpage - 1).');" class="p_redirect">&#8249;</a>' : '');
		for($i = $from; $i <= $to; $i++) {
			$multipage .= $i == $curpage ? '<span class="p_curpage">'.$i.'</span>' : '<a href="javascript:;" onclick="'.$action.'('.$i.');" class="p_num">'.$i.'</a>';
		}
		$multipage .= ($curpage < $pgs ? '<a href="javascript:;" onclick="'.$action.'('.($curpage + 1).');" class="p_redirect">&#8250;</a>' : '').($to < $pgs ? '<a href="javascript:;" onclick="'.$action.'('.$pgs.');" class="p_redirect">&raquo;</a>' : '');
		$multipage = $multipage ? '<div class="p_bar"><span class="p_info">Total:&nbsp;<b>'.$total.'</b>&nbsp;</span>'.$multipage.'</div>' : '';
	}
	return $multipage;
}
function getDirSize($path,$calc_all = false) {
    $totalsize = 0;
    $totalcount = 0;
    $dircount = 0;
    if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) {
            $nextpath = $path . '/' . $file;
            if ($file != '.' && $file != '..' && !is_link($nextpath)) {
                if (is_dir($nextpath)) {
                    $dircount++;
                    $result = getDirSize($nextpath);
                    $totalsize += $result['size'];
                    $totalcount += $result['count'];
                    $dircount += $result['dircount'];
                } elseif (is_file($nextpath)) {
                    $totalsize += filesize($nextpath);
                    $totalcount++;
                }
            }
        }
    }
    closedir($handle);
	$disk_space = $calc_all ? get_size(@disk_free_space(PHPDISK_ROOT)) : 0;

    return [
        'total_space'=>$disk_space,
        'used_size' => get_size($totalsize),
        'file_count' => $totalcount,
        'folder_count' => $dircount
    ];
}

function nav_txt($arr, $num)
{
    if ($num > 0) {
        $str = '';
        for ($i = 0; $i < $num + 1; $i++) {
            $str .= $arr[$i] . '/';
        }
        return base64_encode(str_iconv(substr($str, 0, -1),false));
    } else {
        return base64_encode(str_iconv($arr[0],false));
    }
}

function list_dir($path,$show_folder=true, $dir = '')
{
    global $cfg,$grid;
    $arr = $arr2 = array();
    //echo $path;
    foreach (glob("$path/*") as $k => $name) {
		//echo str_iconv($name).'|';
        $sys_fname = rawurlencode(substr($name, strlen($path) + 1));
        $fname = str_iconv(rawurldecode($sys_fname));

        $extension = get_extension($name);
        $file_time = date('Y-m-d H:i:s', filemtime($name));
        $file_size = get_size(filesize($name));
        $t_encode_fname = $dir ? $dir . '/' . $sys_fname : $sys_fname;
        $encode_fname = base64_encode($t_encode_fname);

        if (is_dir($name)) {
            $arr[$k]['filename'] = $fname;
            $arr[$k]['extension'] = $extension;
            $arr[$k]['file_time'] = $file_time;
            $arr[$k]['file_size'] = $file_size;
            $arr[$k]['sys_fname'] = base64_encode($sys_fname);
            $arr[$k]['encode_fname'] = $encode_fname;
            $arr[$k]['a_folder'] = $cfg['phpdisk_url'] . '?d=' . $encode_fname;
            $arr[$k]['a_qr_folder'] = base64_encode($cfg['phpdisk_url'] .'?d=' . $encode_fname."&grid=$grid");


        } else {

            $arr2[$k]['filename'] = $fname;
            $arr2[$k]['extension'] = $extension;
            $arr2[$k]['file_time'] = $file_time;
            $arr2[$k]['file_size'] = $file_size;
            $arr2[$k]['sys_fname'] = base64_encode($sys_fname);
            $arr2[$k]['encode_fname'] = $encode_fname;
            $arr2[$k]['a_down'] = 'op.php?act=down&fn=' .$encode_fname;
            $arr2[$k]['a_qr_down'] = base64_encode($cfg['phpdisk_url'] .'op.php?act=down&fn=' .$encode_fname);
			$arr2[$k]['a_view'] = $cfg['phpdisk_url'].'_phpdisk/file.php?act=preview&fn='.$encode_fname;
			$arr2[$k]['a_qr_view'] = base64_encode($arr2[$k]['a_view']);
        }
    }
    return $show_folder ? $arr : $arr2;
}

function phpdisk_user_login(){
	global $pd_uid;
	return $pd_uid ? true : false;
}
function phpdisk_admin_login(){
	global $pd_gid;
	return $pd_gid ? true : false;
}
function has_bad_chars($str,$chars){
	$found = false;
	foreach ($chars as $char) {
		if (strpos($str, $char) !== false) {
			$found = true;
			break;
		}
	}
	return $found;

}
function settings_cache($arr=0){
	$str_c = '';
	if(is_array($arr)){
		foreach($arr as $k => $v){
			$v = str_replace(array("'",'\\'),'',$v);
			$str_c .= "\t'".$k."' => '".$v."',".LF;

		}
	}
	$str = "<?php".LF.LF;
	$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
	$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF.LF;
	$str .= "\$settings = array(".LF;
	$str .= $str_c;
	$str .= ");".LF.LF;

	write_file(PHPDISK_ROOT."_phpdisk/system/settings.inc.php",$str);

}
// // 移动目录
// $source = '../php';
// $destination = '../php2';

// // 检查目标目录是否存在，如果不存在则创建
// if (!is_dir($destination)) {
//     mkdir($destination, 0755, true);
// }

// // 复制目录内容
// copyDir($source, $destination);

// // 删除源目录及其内容
// delDir($source);

// echo "目录移动成功！";

// 复制目录内容的函数
function copyDir($source, $destination) {
    $files = scandir($source);
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $sourcePath = $source . '/' . $file;
            $destinationPath = $destination . '/' . $file;
            if (is_dir($sourcePath)) {
                copyDir($sourcePath, $destinationPath);
            } else {
                copy($sourcePath, $destinationPath);
            }
        }
    }
}

// 删除目录及其内容的函数
function delDir($dir) {
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        is_dir("$dir/$file") ? delDir("$dir/$file") : @unlink("$dir/$file");
    }
    return rmdir($dir);
}
