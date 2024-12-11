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
#	$Id: adm_header.tpl.php 30 2024-12-10 13:26:02Z along $
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
	<meta name="keywords" content="{$keywords}" />
	<meta name="description" content="{$description}" />
	<link rel="shortcut icon" href="favicon.ico">
	<base href="{$cfg['phpdisk_url']}"/>
	<meta name="Copyright" content="Powered by PHPDisk Team, {PHPDISK_EDITION} {PHPDISK_VERSION} build{PHPDISK_RELEASE}" />
	<meta name="generator" content="PHPDisk Team" />
	<script src="{$admin_tpl_dir}assets/js/jquery.min.js"></script>

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
	<link href="{$admin_tpl_dir}assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="{$admin_tpl_dir}assets/css/app.css" rel="stylesheet">
	<link href="{$admin_tpl_dir}assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{$admin_tpl_dir}assets/css/dark-theme.css" />
	<link rel="stylesheet" href="{$admin_tpl_dir}assets/css/semi-dark.css" />
	<link rel="stylesheet" href="{$admin_tpl_dir}assets/css/header-colors.css" />
	
</head>

<body>
<section class="navbar-area">
	<div class="container-fluid">
		<div class="row bg-dark">
			<nav class="navbar navbar-expand-lg navbar-dark rounded">
						<div class="container">
						<a class="navbar-brand mb-1" href="_phpdisk/admin.php" title="{$settings['site_title']}<?=__('backend manage')?>"><img src="{$admin_tpl_dir}images/logo_cp.png" align="absmiddle" border="0" alt="{$settings['site_title']}" id="logo"></a>

						</div>
					</nav>
					
		</div> <!-- row -->
	</div> <!-- container -->
</section>
