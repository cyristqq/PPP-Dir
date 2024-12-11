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
#	$Id: information.tpl.php 21 2024-12-09 07:51:27Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="container col-lg-6 col-md-6 col-sm-9 col-xs-12 mt-5">
    <div class="card">
        <div class="card-header alert-primary"><img src="_phpdisk/static/img/light.gif" align="absmiddle" border="0" /> <?=__('tips_message')?></div>
        <div class="card-body"><p>{$msg}</p></div>
        <div class="card-footer justify-content-center small"><a href="{$url}"><?=__('click_to_back')?></a></div>
    </div>
</div>
