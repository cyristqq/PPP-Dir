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
#	$Id: qr.php 21 2024-12-09 07:51:27Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/
include "includes/commons.inc.php";

ob_end_clean();

$url = trim(gpc('url','G',''));
$b4 = (int)(gpc('b4','G',''));

include_once PHPDISK_ROOT."_phpdisk/includes/phpqrcode.inc.php";

if($url){
	$url = $b4 ? base64_decode($url) : $url;
	QRcode::png($url, false, 'L', '4',2);
}else{
	header('Location: ../');
}
exit;
