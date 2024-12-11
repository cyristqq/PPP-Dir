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
#	$Id: commons.inc.php 40 2024-12-11 08:41:51Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/
if(!(version_compare(PHP_VERSION,'5.4','>=') && version_compare(PHP_VERSION,'5.7','<'))){
	die('[PHPDisk Tips] This program only support PHP 5.4-5.7 version!<Br>Currently PHP installed version is: '.PHP_VERSION);
}
if(!function_exists('scandir') || !function_exists('glob')){
	die('[PHPDisk Tips] Please open your [ scandir ] and [ glob ] in php.ini .');
}
if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
	define ( 'LF', "\r\n" );
} else {
	define ( 'LF', "\n" );
}
$timestamp = time ();
define ( 'IN_PHPDISK', TRUE );
define ( 'NOW_YEAR', '2024' );

function get_runtime($start,$end='') {
	static $_ps_time = array();
	if(!empty($end)) {
		if(!isset($_ps_time[$end])) {
			$mtime = explode(' ', microtime());
		}
		return number_format(($mtime[1] + $mtime[0] - $_ps_time[$start]), 6);
	}else{
		$mtime = explode(' ', microtime());
		$_ps_time[$start] = $mtime[1] + $mtime[0];
	}
}
function sys_error($msg) {
	$rtn = '<p style="padding:8px; font-size:14px; border:2px solid #F04C27;border-radius:5px;background-color:#FFFADC; color:#252525; margin:8px;">';
	$rtn .= '<a href="http://faq.phpdisk.com/search?w='.$msg.'" target="_blank">[<span style="color:#FF0000;">[PHPDisk] Connect error!</span>]&nbsp;'.$msg.'</a><br><br>';
	$rtn .= '</p>';
	echo $rtn;
}
get_runtime('start');
@session_start();
$settings = $sysmsg = array();

define('PHPDISK_ROOT', substr(dirname(__FILE__), 0, -17));


$config_file = PHPDISK_ROOT.'configs.php';
if(!file_exists($config_file)){
	sys_error('[PHPDisk PPP-Dir] Please create [ configs.php ] file!');
	exit();
}else{
	require($config_file);
}
define ( 'DEFAULT_LANG', $cfg['default_lang'] );
$phpdisk_site = in_array(DEFAULT_LANG,array('zh_cn','zh_tw')) ? 'http://www.phpdisk.com/' : 'https://www.phpdisk.net/';
$phpdisk_faq = in_array(DEFAULT_LANG,array('zh_cn','zh_tw')) ? 'http://faq.phpdisk.com/' : 'https://faq.phpdisk.net/';
define ( 'PHPDISK_SITE', $phpdisk_site );
define ( 'PHPDISK_FAQ', $phpdisk_faq );
define ( 'PHPDISK_CORE', 'pppdir' );
define ( 'PHPDISK_CORE_TXT', 'PPP-Dir' );
define ( 'PHPDISK_COOKIE', 'phpdisk_pppdir_v2_info' );
define ( 'PHPDISK_COOKIE_ADMIN', 'phpdisk_pppdir_v3a_info' );


$auth_dir = PHPDISK_ROOT.'_phpdisk/includes/auth/';
if(file_exists($auth_dir.'phpdisk.a.inc.php')){
	require_once $auth_dir.'phpdisk.a.inc.php';
}elseif(file_exists($auth_dir.'phpdisk.p.inc.php')){
	require_once $auth_dir.'phpdisk.p.inc.php';
}elseif(file_exists($auth_dir.'phpdisk.c.inc.php')){
	require_once $auth_dir.'phpdisk.c.inc.php';
}
unset($auth_dir);

$arr = array('global');
for ($i=0;$i<count($arr);$i++){
	require_once(PHPDISK_ROOT.'_phpdisk/includes/function/'.$arr[$i].'.func.php');
}

require_once PHPDISK_ROOT.'_phpdisk/includes/phpdisk_version.inc.php';

$setting_file = PHPDISK_ROOT.'_phpdisk/system/settings.inc.php';
file_exists($setting_file) ? require_once $setting_file : settings_cache();


list($pd_uid,$pd_login_token) = gpc(PHPDISK_COOKIE,'C','') ? explode("\t", pd_encode(gpc(PHPDISK_COOKIE,'C',''), 'DECODE')) : array('', '');
if($pd_login_token<>phpdisk_md5($cfg['login_pass'])){
	$pd_uid = 0;
}
if($pd_uid){
	list($pd_gid,$pd_admin_token) = gpc(PHPDISK_COOKIE_ADMIN,'C','') ? explode("\t", pd_encode(gpc(PHPDISK_COOKIE_ADMIN,'C',''), 'DECODE')) : array('', '');
	if($pd_admin_token<>phpdisk_md5($cfg['admin_login_pass'])){
		$pd_gid = 0;
	}
}
// for debug;
define('DEBUG',$cfg['debug'] ? true : false);
if($cfg['debug']){
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	@ini_set('display_errors', 'On');
}else{
	error_reporting(0);
	@ini_set('display_errors', 'Off');
}
$charset = $cfg['charset'];
$charset_arr = array('gbk' => 'gbk','utf-8' => 'utf8');
$db_charset = $charset_arr[strtolower($cfg['charset'])];
header("Content-Type: text/html; charset=$charset");

// tpl
$user_tpl_dir = $settings['user_tpl_dir'] ? $settings['user_tpl_dir'] : 'default';
$user_tpl_dir = '_phpdisk/templates/'.$user_tpl_dir.'/';
$admin_tpl_dir = '_phpdisk/templates/admin/';


// i18n 
require PHPDISK_ROOT.'_phpdisk/includes/lib/php-gettext/gettext.inc.php';
_setlocale(LC_MESSAGES, DEFAULT_LANG);
_bindtextdomain('phpdisk', '_phpdisk/languages');
_bind_textdomain_codeset('phpdisk', $charset);
_textdomain('phpdisk');


$act = trim(gpc('act', 'GP',''));
$task = trim(gpc('task', 'GP',''));
$p_formhash = trim(gpc('formhash','P',''));

$formhash = formhash();

if(!dir_writeable(PHPDISK_ROOT.'_phpdisk/system/') || !dir_writeable(PHPDISK_ROOT.$cfg['phpdisk_dir'])){
	die(sprintf(__('need to set the [ _phpdisk/system ] and [ %s ] directory to be writeable!'),$cfg['phpdisk_dir']));
}
