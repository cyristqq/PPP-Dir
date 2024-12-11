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
#	$Id: my_header.tpl.php 30 2024-12-10 13:26:02Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{$title} - PPP-Dir - Powered by PHPDisk</title>
	<link rel="shortcut icon" href="favicon.ico">
	<base href="{$cfg['phpdisk_url']}"/>
	<meta name="Copyright" content="Powered by PHPDisk Team, {PHPDISK_EDITION} {PHPDISK_VERSION} build{PHPDISK_RELEASE}" />
	<meta name="generator" content="PHPDisk Team" />
	<script src="{$user_tpl_dir}assets/js/jquery.min.js"></script>

	<script type="text/javascript" src="_phpdisk/static/js/common.js"></script>

	<script type="text/javascript" src="_phpdisk/static/layer/layer.js"></script>
	<script type="text/javascript" src="_phpdisk/static/layer/mobile/layer.js"></script>
	<script type="text/javascript" src="_phpdisk/static/js/clipboard.min.js"></script>
	<script>
		$(document).ready(function () {
			var clipboard = new ClipboardJS('.cp_btn');
			clipboard.on('success', function (e) {
				atips('<?= __('copy success') ?>',1);
			});
		});
	</script>

	<link href="_phpdisk/static/css/style.css" rel="stylesheet" type="text/css">

	<!-- Bootstrap CSS -->
	<link href="{$user_tpl_dir}assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="{$user_tpl_dir}assets/css/app.css" rel="stylesheet">
	<link href="{$user_tpl_dir}assets/css/icons.css" rel="stylesheet">
	
</head>

<body>
