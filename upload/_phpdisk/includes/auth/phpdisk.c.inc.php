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
#	$Id: phpdisk.c.inc.php 21 2024-12-09 07:51:27Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}
$auth['com_news_url'] = PHPDISK_SITE.'m_news/pppdir_idx_v2.php';
$auth['com_upgrade_url'] = PHPDISK_SITE.'autoupdate/pppdir_last_version_v2.php';

define('PHPDISK_EDITION',PHPDISK_CORE_TXT.' Community Edition');
