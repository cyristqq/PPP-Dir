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
#	$Id: admin.tpl.php 35 2024-12-11 06:21:34Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="container my-2  col-md-9 col-sm-12">
            <div class="row">
                <div class="col-lg-12 ">
				<div id="phpdisk_news" class="mb-2"></div>
<a name="tag" id="tag"></a>
<!--breadcrumb-->
<div class="page-breadcrumb  d-flex align-items-center mb-3">
	<div class="">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0 p-0">
				<li class="breadcrumb-item active">
				<a href="_phpdisk/admin.php"><i class="bx bx-cog"></i><?=__('backend index')?></a></li>
				<li class="breadcrumb-item active">{$nav_tit}</li>

			</ol>
		</nav>
	</div>
	<div class="ms-auto d-none d-sm-flex bx-xs">

	</div>
</div>
<!--end breadcrumb-->
<hr />
<div class="row mb-2">
<div class="col-md-2 col-sm-12 h6">
<dl class="menu">
	<dd class="mb-3 p-2 text-center radius-10 border-bottom border-0 border-3"><a href="./" target="_index"><i class="bx bx-share"></i><?=__('home')?></a></dd>
	<dd class="my-3 p-2 text-center radius-10 border-bottom border-0 border-3" id="adm_"><a href="_phpdisk/admin.php#tag"><i class="bx bx-wrench"></i><?=__('base setting')?></a></dd>
	<dd class="my-3 p-2 text-center radius-10 border-bottom border-0 border-3" id="adm_upload"><a href="_phpdisk/admin.php?act=upload#tag"><i class="bx bx-upload"></i><?=__('upload setting')?></a></dd>
	<dd class="my-3 p-2 text-center radius-10 border-bottom border-0 border-3" id="adm_announce"><a href="_phpdisk/admin.php?act=announce#tag"><i class="bx bx-volume-low"></i><?=__('announce setting')?></a></dd>
</dl>
</div>
<script>
$(document).ready(function(){
	$('#adm_{$act}').addClass('border-success')
})
</script>
<div class="col-md-10 col-sm-12">
	<form action="_phpdisk/admin.php" method="post" onsubmit="return dosubmit(this);">
	<input type="hidden" name="act" value="{$act}" />
	<input type="hidden" name="task" value="doset" />
	<input type="hidden" name="formhash" value="{$formhash}" />
	<!--#if($act=='upload'){#-->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped shadow radius-10">
	<tr><td>
	<label class=" text-dark"><?=__('allow_upload')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('allow_upload_tips')?></div>
	<div><input type="radio" name="set[allow_upload]" value="1" {#ifchecked(1,$settings['allow_upload'])#} /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="set[allow_upload]" value="0" {#ifchecked(0,$settings['allow_upload'])#}/><?=__('no')?></div>
	</td></tr>
	<tr><td>
	<label class="mt-3 text-dark"><?=__('h5_max_filesize')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('h5_max_filesize_tips')?></div>
	<div class=" col-md-6 col-sm-12"><input type="text" name="set[h5_max_filesize]" value="{$settings['h5_max_filesize']}" maxlength="50" class="form-control form-control-sm" autocomplete="off" /></div>
	</td></tr>
	<tr><td>
	<label class="mt-3 text-dark"><?=__('h5_upload_ext')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('h5_upload_ext_tips')?></div>
	<div class=" col-md-6 col-sm-12"><input type="text" name="set[h5_upload_ext]" value="{$settings['h5_upload_ext']}" maxlength="50" class="form-control form-control-sm" autocomplete="off" /></div>
	</td></tr>
	</table>
	<!--#}elseif($act=='announce'){#-->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped shadow radius-10">
	<tr><td>
	<label class="mt-3 text-dark"><?=__('announce')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('announce_tips')?></div>
	<div><textarea name="set[announce]" class="form-control form-control-sm" id="announce" style="height:50px"  ondblclick="resize_textarea('announce','expand');">{$settings['announce']}</textarea></div>
	</td></tr>
	<!--#if($auth['pd_a']||$auth['pd_p']){#-->
	<tr><td>
	<label class="mt-3 text-dark"><?=__('announce_bg')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('announce_bg_tips')?></div>
	<div class="d-flex m-3">
	<label class="col-3 alert alert-none me-1 mb-1"><input type="radio" name="set[announce_bg]" value="none" {#ifchecked('none',$settings['announce_bg'],'str')#} /></label>
	<label class="col-3 alert alert-danger me-1 mb-1"><input type="radio" name="set[announce_bg]" value="danger" {#ifchecked('danger',$settings['announce_bg'],'str')#} /></label>
	<label class="col-3 alert alert-success me-1 mb-1"><input type="radio" name="set[announce_bg]" value="success" {#ifchecked('success',$settings['announce_bg'],'str')#} /></label>
	<label class="col-3 alert alert-warning me-1 mb-1"><input type="radio" name="set[announce_bg]" value="warning" {#ifchecked('warning',$settings['announce_bg'],'str')#} /></label>
	</div>
	<div class="d-flex m-3">
	<label class="col-3 alert alert-dark me-1 mb-1"><input type="radio" name="set[announce_bg]" value="dark" {#ifchecked('dark',$settings['announce_bg'],'str')#} /></label>
	<label class="col-3 alert alert-info me-1 mb-1"><input type="radio" name="set[announce_bg]" value="info" {#ifchecked('info',$settings['announce_bg'],'str')#} /></label>
	<label class="col-3 alert alert-primary me-1 mb-1"><input type="radio" name="set[announce_bg]" value="primary" {#ifchecked('primary',$settings['announce_bg'],'str')#} /></label>
	<label class="col-3 alert alert-secondary me-1 mb-1"><input type="radio" name="set[announce_bg]" value="secondary" {#ifchecked('secondary',$settings['announce_bg'],'str')#} /></label>
	</div>
	</td></tr>
	<!--#}#-->
	</table>

	<!--#}else{#-->
	<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped shadow radius-10">
	<tr><td>
	<label class=" text-dark"><?=__('site_title')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('site_title_tips')?></div>
	<div class=" col-md-6 col-sm-12"><input type="text" name="set[site_title]" value="{$settings['site_title']}" maxlength="50" class="form-control form-control-sm" autocomplete="off" /></div>
	</td></tr>
	<!--#if($auth['pd_a']||$auth['pd_p']){#-->
	<tr><td>
	<label class="mt-3 text-dark"><?=__('user_tpl_dir')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('user_tpl_dir_tips')?></div>
	<div class=" col-md-6 col-sm-12"><input type="text" name="set[user_tpl_dir]" value="{$settings['user_tpl_dir']}" maxlength="50" class="form-control form-control-sm" autocomplete="off" /></div>
	</td></tr>
	<!--#}#-->
	<tr><td>
	<label class="mt-3 text-dark"><?=__('encrypt_key')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('encrypt_key_tips')?></div>
	<div class=" col-md-6 col-sm-12"><div class="input-group"><input type="text" id="encrypt_key" name="set[encrypt_key]" value="{$settings['encrypt_key']}" maxlength="50" class="form-control form-control-sm" autocomplete="off" /><input type="button" value="<?=__('make_random')?>" class="btn btn-secondary btn-sm" onclick="make_code();" /></div></div>
	</td></tr>
	<!--#if($in_china){#-->
	<tr><td>
	<label class="mt-3 text-dark"><?=__('miibeian')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('miibeian_tips')?></div>
	<div class=" col-md-6 col-sm-12"><input type="text" name="set[miibeian]" value="{$settings['miibeian']}" maxlength="50" class="form-control form-control-sm" autocomplete="off" /></div>
	</td></tr>
	<!--#}#-->
	<tr><td>
	<label class="mt-3 text-dark"><?=__('contact_us')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('contact_us_tips')?></div>
	<div class=" col-md-6 col-sm-12"><input type="text" name="set[contact_us]" value="{$settings['contact_us']}" maxlength="50" class="form-control form-control-sm" autocomplete="off" /></div>
	</td></tr>
	<tr><td>
	<label class="mt-3 text-dark"><?=__('meta_ext')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('meta_ext_tips')?></div>
	<div class=" col-md-6 col-sm-12"><textarea name="set[meta_ext]" class="form-control form-control-sm" id="meta_ext" style="height:50px"  ondblclick="resize_textarea('meta_ext','expand');">{$settings['meta_ext']}</textarea></div>
	</td></tr>
	<!--#if($auth['pd_a']||$auth['pd_p']){#-->
	<tr><td>
	<label class="mt-3 text-dark"><?=__('open_xsendfile')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('open_xsendfile_tips')?></div>
	<div><input type="radio" name="set[open_xsendfile]" value="0" {#ifchecked(0,$settings['open_xsendfile'])#} /><?=__('php_flow')?>&nbsp;&nbsp;<input type="radio" name="set[open_xsendfile]" value="1" {#ifchecked(1,$settings['open_xsendfile'])#}/><?=__('apache_flow')?>&nbsp;&nbsp;<input type="radio" name="set[open_xsendfile]" value="2" {#ifchecked(2,$settings['open_xsendfile'])#}/><?=__('nginx_flow')?></div>
	</td></tr>
	<tr><td>
	<label class="mt-3 text-dark"><?=__('hide_license')?>:</label>
	<div class="mb-1 text-black-50 small"><?=__('hide_license_tips')?></div>
	<div><input type="radio" name="set[hide_license]" value="1" {#ifchecked(1,$settings['hide_license'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="set[hide_license]" value="0" {#ifchecked(0,$settings['hide_license'])#}/> <?=__('no')?></div>
	</td></tr>
	<!--#}#-->
	</table>
	
	<!--#}#-->
	<div class="mt-2"><input type="submit" class="btn btn-primary shadow" value="<?=__('btn_submit')?>" /></div>
	</form>
</div>

</div>


</div>
</div>
</div>

<div class="lo_box shadow col-3" id="update_msgbox" style="display:none">
<div class="tit f14"><span style="float:right;cursor:pointer; margin-right:5px;" onclick="$('#update_msgbox').hide(300);" title="<?=__('close')?>">X</span><div id="sp_txt"></div></div>
  <div class="ann_list" id="ann_list" style="padding:3px;">
	<ul></ul>
	<div align="center" style="padding-bottom:5px;"><input type="hidden" id="last_u_day" /><input type="button" onclick="close_update_msgbox()" class="btn btn-primary btn-pill" value="<?=__('I know hide this upgrade tips')?>" /></div>
</div>
</div>
<script type="text/javascript">
function make_code(){
   var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   var tmp = "";
   var code = "";
   for(var i=0;i<12;i++){
	   code += chars.charAt(Math.ceil(Math.random()*100000000)%chars.length);
   }
   $('#encrypt_key').val( code);
}

function close_update_msgbox(){
	layer.confirm('<?=__('confirm to hide this upgrade tips')?>', {
		btn: ['<?=__('confirm')?>','<?=__('cancel')?>'] 
	}, function(){
		
		var last_u_day = $.trim($('#last_u_day').val());
		$.ajax({
			type : 'post',
			url : '_phpdisk/adm_ajax.php',
			data : 'act=close_update_msgbox&day='+last_u_day,
			dataType : 'json',
			success:function(cb){
				if(cb.success){
					$('#update_msgbox').hide(300);
				}else{
					atips(cb.msg);
				}
				layer.closeAll();
			},
			error:function(e){
			//console.log(e)
			}
	
		});
	})
}

function autoupdate(){
	$('body').after("<img src='{PHPDISK_SITE}autoupdate.php?edition={#rawurlencode(PHPDISK_EDITION)#}&version={#rawurlencode(PHPDISK_VERSION)#}&release={#rawurlencode(PHPDISK_RELEASE)#}&server=<?=rawurlencode($_SERVER['HTTP_HOST'])?>' width=0 height=0 style=\"display:none\">");
}
autoupdate();
function get_news(){
	$.getScript('{$auth[com_news_url]}',function(){
		var arr = cb.split('|');
		if(arr[2]!=''){	
			layer.open({
				title:arr[1],
				content:arr[2]
			});		
		}
		$('#phpdisk_news').html(arr[0]);
		$('#phpdisk_news').addClass(' alert alert-{$alert_bg} small')
	});
}
setTimeout(function(){get_news()},2250);
setTimeout(function(){
	$.getScript('{$auth[com_upgrade_url]}?pr={PHPDISK_RELEASE}',function(){	
		if(dt!=''){
			var arr2 = dt.split('|');
			if({$show_update_tips} && arr2[2]!='{$last_up_day}'){
				$('#last_u_day').val('{PHPDISK_RELEASE}');
				$('#sp_txt').html(arr2[0]);
				$('#ann_list > ul').html(arr2[1]);
				$('#update_msgbox').show(300);
			}
		}
	});
},3000);

</script>

