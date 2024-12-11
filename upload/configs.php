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
#	$Id: configs.php 37 2024-12-11 08:10:08Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/
// Fill in freely, only for display
$cfg['username'] = 'PPPAdmin'; 
// 随便填写，只用于显示

// User Frontend login password
$cfg['login_pass'] = '11'; 
// 用户前台登录密码

// Admin Backend login password
$cfg['admin_login_pass'] = '12'; 
// 管理后台登录密码

// The file parsing directory is based on the directory name of the website root directory. The program will read files in this directory, which can be modified without using special characters.
// Please make sure to modify the name of the parsing directory. To ensure security, it is recommended to disable the execution permission of this directory, and the directory name can be modified from time to time
$cfg['phpdisk_dir'] = '@dir'; 
// !!文件解析目录 基于网站根目录的目录名称，程序会读取此目录下的文件，可修改不要使用特殊字符
// 请务必修改解析目录名称，为确保安全，推荐设置禁用此目录执行权限，同时可不定时修改此目录名称 

// The default language pack in the _phpdisk/languages/ , zh_cn is the Chinese language pack, en_us is an English language pack
$cfg['default_lang'] = 'zh_cn'; 
// 默认语言 语言包在 _phpdisk/languages/ 目录下  zh_cn 为中文语言包 , en_us 为英文语言包

// Program access address, add at the end /
$cfg['phpdisk_url'] = 'http://127.0.0.1/dev/3pdir/'; 
// 程序访问完整地址，结尾要加 /

// Browser character encoding
$cfg['charset'] = 'utf-8'; 
// 浏览器字符编码

// Enable debug mode
$cfg['debug'] = 0; // 1 open , 0 close 
// 是否开启调试模式

// File name not allowed to appear in the characters
$cfg['deny_chars'] = array('\\','/',':','<','>','?','"','*',"'",'`'); 
// 文件名中不允许出现的字符

