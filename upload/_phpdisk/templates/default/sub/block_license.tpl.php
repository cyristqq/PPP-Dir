<!--#
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
#	$Id: block_license.tpl.php 27 2024-12-10 06:52:54Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if(!$settings[hide_license]){#-->
&nbsp;<a href="{PHPDISK_SITE}commerce.html?w={#$_SERVER['HTTP_HOST']#}" target="_blank" title="<?=__('query your domain in phpdisk')?>"><img src="_phpdisk/static/img/ico_auth.gif" align="absmiddle" border="0" /><?=__('phpdisk auth')?></a>
<!--#}#-->