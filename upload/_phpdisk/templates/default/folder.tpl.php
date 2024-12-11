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
#	$Id: folder.tpl.php 34 2024-12-11 02:41:46Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($act=='add_folder'||$act=='rename_folder'){#-->
<div class="p-2 mx-2">
<form action="_phpdisk/folder.php" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="act" value="{$act}" />
<input type="hidden" name="task" value="{$act}" />
<input type="hidden" name="d" value="{$d}" />
<input type="hidden" name="old_folder_name" value="{$old_folder_name}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<label class="form-label mt-2"><?=__('folder_name')?>:</label>
<div><input type="text" name="folder_name" value="{$old_folder_name_u}" maxlength="250" class="form-control form-control-sm" autocomplete="off" /></div>
<div class="mt-2"><input type="submit" class="btn btn-primary btn-sm shadow" value="<?=__('btn_submit')?>" /></div>
</form>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(o.folder_name.value.strtrim()==''){
		atips('<?=__('folder_name_error')?>');
		o.folder_name.focus();
		return false;
	}
}
</script>
<!--#}#-->