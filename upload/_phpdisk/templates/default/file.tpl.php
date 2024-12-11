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
#	$Id: file.tpl.php 34 2024-12-11 02:41:46Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($act=='rename_file'){#-->
<div class="p-2 mx-2">
<form action="_phpdisk/file.php" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="act" value="{$act}" />
<input type="hidden" name="task" value="{$act}" />
<input type="hidden" name="d" value="{$d}" />
<input type="hidden" name="old_file_name" value="{$old_file_name}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<label class="form-label mt-2"><?=__('file_name')?>:</label>
<div><input type="text" name="file_name" value="{$old_file_name_u}" maxlength="250" class="form-control form-control-sm" autocomplete="off" /></div>
<div class="mt-2"><input type="submit" class="btn btn-primary btn-sm shadow" value="<?=__('btn_submit')?>" /></div>
</form>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(o.file_name.value.strtrim()==''){
		atips('<?=__('file_name_error')?>');
		o.file_name.focus();
		return false;
	}
}
</script>
<!--#}elseif($act=='preview'){#-->

<!--#if($error){#-->
<script>atips('<?=__('cannot load file')?>');</script>
<!--#}else{#-->
<div id="t_btn" class="float-end m-2 " style="position:fixed; top:10px; right:10px;display:none">
<a href="./" class="btn btn-outline-primary"><i class="bx bx-home bx-xs"></i><?=__('home')?></a>
<a href="{$a_down}" class="btn btn-outline-success"><i class="bx bx-download bx-xs"></i><?=__('download')?></a>
</div>
<div class="p-2 mx-2">
<div class="ctn" style="min-height:300px">{$ctn}</div>
</div>
<script>
if(top.location==self.location){
	$('#t_btn').show(100)
}else{
	top.$('.layui-layer-min').before('<a class="" href="{$a_down}" onclick="top.layer.closeAll()" title="<?=__('download')?>" target="_blank"><i class="bx bx-download bx-xs"></i></a>');
}
</script>

<!--#}#-->
<!--#}#-->