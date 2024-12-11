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
#	$Id: phpdisk.tpl.php 35 2024-12-11 06:21:34Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script>
<!--#if(phpdisk_user_login()){#-->
function del_file(encode_fname,id){
	layer.confirm('<?=__('delete_file_confirm')?>', {
		btn: ['<?=__('confirm')?>','<?=__('cancel')?>'] 
	}, function(){
		layer.closeAll()
		$('#fl_'+id).html('<div class="bg-transparent col-12"><i class="bx bx-loader bx-spin"></i> Loading...</div>')

		$.ajax({
			type : 'post',
			url : '_phpdisk/ajax.php',
			data : 'act=del_file&fn='+encode_fname,
			dataType : 'json',
			success:function(cb){
				//console.log(cb)
				if(cb.ok){			
					$('#fl_'+id).html('<div class="bg-transparent col-12 text-success"><i class="bx bx-check-circle "></i><?=__('delete file success')?></div>')
		
					setTimeout(function(){$('#fl_'+id).hide(200)},500)									
				}else{
					$('#fl_'+id).html(cb.msg)
					$('#fl_'+id).addClass('text-danger')
				}
			},
			error:function(e){
			}
		});

	});
}
function del_folder(encode_fname,id){
	layer.confirm('<?=__('delete_folder_confirm')?>', {
		btn: ['<?=__('confirm')?>','<?=__('cancel')?>'] 
	}, function(){
		layer.closeAll()
		$('#fd_'+id).html('<div class="bg-transparent col-12"><i class="bx bx-loader bx-spin"></i> Loading...</div>')

		$.ajax({
			type : 'post',
			url : '_phpdisk/ajax.php',
			data : 'act=del_folder&fn='+encode_fname,
			dataType : 'json',
			success:function(cb){
				//console.log(cb)
				if(cb.ok){			
					$('#fd_'+id).html('<div class="bg-transparent col-12 text-success"><i class="bx bx-check-circle "></i><?=__('delete folder success')?></div>')
		
					setTimeout(function(){$('#fd_'+id).hide(200)},500)									
				}else{
					$('#fd_'+id).html(cb.msg)
					$('#fd_'+id).addClass('text-danger')
				}
			},
			error:function(e){
			}
		});

	});
}
function logout_act(){
	layer.confirm('<?=__('confirm logout')?>', {
		btn: ['<?=_('confirm')?>','<?=__('cancel')?>'] 
	}, function(){
		$.ajax({
			type : 'post',
			url : '_phpdisk/ajax.php',
			data : 'act=logout_act',
			dataType : 'json',
			success:function(cb){
				//console.log(cb)
				if(cb.ok){
					atips('<?=__('logout success')?>',1)
					location.reload()	
						
				}else{
					layer.alert(cb.msg)
				}
			},
			error:function(e){
			}
		});
	})
}
function click_up_btn(){
	if ($("#up_box").is(":hidden")) {
		$('.a_up_btn').removeClass('btn-outline-success').addClass('btn-success')
	}else{
		$('.a_up_btn').removeClass('btn-success').addClass('btn-outline-success')
	}
	$('#up_box').slideToggle(100)
}
<!--#}#-->
function view_qr2(url,v_url,b4){
	let url2 = b4==1 ? atob(url) : url;
	let v_url2 = b4==1 ? atob(v_url) : v_url;
	let html = ''
	html += '<div class="container row p-1">'
	html += '<div class="col-md-6 col-sm-12">'
	html += '<div align="center"><?=__('scan to view')?></div>'
	html += '<div align="center" class="p-1"><a href="'+v_url2+'" target="_view"><img id="img_v" src="_phpdisk/qr.php?url='+v_url+'&b4='+b4+'" border="0" width="180" /></a></div>'
	html += '<div align="center" class="p-1 mb-2"><a href="javascript:;" class="cp_btn" data-clipboard-text="'+v_url2+'"><i class="bx bx-link"></i><?=__('copy view link')?></a></div>'
	html += '</div>'
	html += '<div class="col-md-6 col-sm-12">'
	html += '<div align="center"><?=__('scan to down')?></div>'
	html += '<div align="center" class="p-1"><a href="'+url2+'" target="_down"><img src="_phpdisk/qr.php?url='+url+'&b4='+b4+'" border="0" width="180" /></a></div>'
	html += '<div align="center" class="p-1 mb-2"><a href="javascript:;" class="cp_btn" data-clipboard-text="'+url2+'"><i class="bx bx-link"></i><?=__('copy download link')?></a></div>'
	html += '</div>'
	html += '</div>'
	if(is_phone() && window.screen.availWidth<550){
		layer_m.open({
			type:1,
			title:'<?=__('scan to')?>',
			area:['50%','60%'],
			shadeClose:true,
			content: html
		});
	}else{
		layer.open({
			type:1,
			title:'<?=__('scan to')?>',
			area:['520px','320px'],
			shadeClose:true,
			content: html
		});
	}
}
function view_qr1(url,b4){
	let url2 = b4==1 ? atob(url) : url;
	let html = ''
	html += '<div align="center" class="p-1"><a href="'+url2+'" target="_view"><img src="_phpdisk/qr.php?url='+url+'&b4='+b4+'" border="0" width="180" /></a></div>'
	html += '<div align="center" class="p-1"><a href="javascript:;" class="cp_btn" data-clipboard-text="'+url2+'"><i class="bx bx-link"></i><?=__('copy link')?></a></div>'
	layer.open({
		type:1,
		title:'<?=__('scan to view')?>',
		area:['320px','300px'],
		shadeClose:true,
		content: html
	});
}

//var p_index;
function preview_file(url){
	var p_index = layer.open({
		type: 2,
		title: '<?=__('file preview')?>',
		content: url,
		area: ['100%', '100%'],
		shadeClose:true,
		maxmin: true
	});
	layer.full(p_index);
}

function folder_stat(encode_fname,id){
	$('#fds_'+id).html('<i class="bx bx-loader bx-spin"></i>...')
	$.ajax({
		type : 'post',
		url : '_phpdisk/ajax.php',
		data : 'act=folder_stat&d='+encode_fname,
		dataType : 'json',
		success:function(cb){
			//console.log(cb)
			if(cb.ok){
				$('#fds_'+id).html('<?=__('folder_count')?> : '+cb.dt.folder_count+' , <?=__('file_count')?> : '+cb.dt.file_count+' , <?=__('used_size')?> : '+cb.dt.used_size)	
					
			}else{
				$('#fds_'+id).html(cb.msg)
				$('#fds_'+id).addClass('text-danger')
			}
		},
		error:function(e){
		}
	});

}
function login_act(){
	layer.prompt({title: '<?=__('input your login code')?>', formType: 1}, function(pass, index){
		layer.close(index);

		$.ajax({
			type : 'post',
			url : '_phpdisk/ajax.php',
			data : 'act=login_act&pass='+$.trim(pass),
			dataType : 'json',
			success:function(cb){
				//console.log(cb)
				if(cb.ok){
					atips('<?=__('login success')?>',1)
					location.reload()
						
				}else{
					layer.alert(cb.msg)
				}
			},
			error:function(e){
			}
		});
	});
}
function login_admin(){
	layer.prompt({title: '<?=__('input your admin login code')?>', formType: 1}, function(pass, index){
		layer.close(index);

		$.ajax({
			type : 'post',
			url : '_phpdisk/ajax.php',
			data : 'act=login_admin&pass='+$.trim(pass),
			dataType : 'json',
			success:function(cb){
				//console.log(cb)
				if(cb.ok){
					atips('<?=__('admin login success')?>',1)
					setTimeout(function(){document.location = '_phpdisk/admin.php'},1000)
						
				}else{
					layer.alert(cb.msg)
				}
			},
			error:function(e){
			}
		});
	});
}

</script>
<link href="{$user_tpl_dir}css/index.css" rel="stylesheet" type="text/css">
<div class="container my-2">
            <div class="row">
                <div class="col-lg-12 ">
<!--breadcrumb-->
<div class="page-breadcrumb  d-flex align-items-center mb-3">
	<div class="">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0 p-0">
				<li class="breadcrumb-item active"><a href="javascript:;" onclick="view_qr1('{$curr_page}',0)"><i class="bx bx-customize text-danger"></i></a>
				<a href="./?grid={$grid}"><i class="bx bx-home"></i><?=__('root folder')?></a></li>
			<!--#foreach($nav_arr as $k=> $name){
					if($k==count($nav_arr)-1){
			#-->
				<li class="breadcrumb-item active"><i class="bx bx-folder-open"></i>{$name}</li>
					<!--#}else{#-->
				<li class="breadcrumb-item"><a href="{$cfg['phpdisk_url']}?d={#nav_txt($nav_arr,$k)#}&grid={$grid}"><i class="bx bx-folder-open"></i>{$name}</a></li>
					<!--#}#-->
				<!--#}#-->
			</ol>
		</nav>
	</div>
	<div class="ms-auto d-none d-sm-flex bx-xs">
		<!--#if(phpdisk_user_login()){#-->
		<a href="javascript:;" onclick="abox('_phpdisk/folder.php?act=add_folder&d={$d}','<?=__('new folder')?>',350,220);" class="btn btn-outline-success btn-sm me-1 mb-1"><i class="bx bx-folder-plus"></i><?=__('new folder')?></a>
		<!--#if($settings['allow_upload']){#-->
		<a href="javascript:;" onclick="click_up_btn()" class="btn btn-outline-success btn-sm me-1 mb-1 a_up_btn"><i class="bx bx-upload"></i><?=__('upload')?></a>
		<!--#}#-->
			<!--#if(phpdisk_admin_login()){#-->
			<a href="_phpdisk/admin.php" class="btn btn-outline-primary btn-sm me-1 mb-1" target="_blank"><i class="bx bx-cog"></i><?=__('settings')?></a>
			<!--#}else{#-->
			<a href="javascript:;" onclick="login_admin()" class="btn btn-outline-primary btn-sm me-1 mb-1"><i class="bx bx-cog"></i><?=__('settings')?></a>
			<!--#}#-->
		<a href="javascript:;" onclick="logout_act()" class="btn btn-outline-danger btn-sm me-1 mb-1"><?=__('welcome')?> {$cfg['username']} , <?=__('Logout')?></a>
		<!--#}else{#-->
		<a href="javascript:;" onclick="login_act()" class="btn btn-primary btn-sm me-1 mb-1"><?=__('Login to manage')?></a>
		<!--#}#-->
	</div>
</div>
<!-- sm show or hide-->
<div class="d-sm-none d-sm-flex bx-xs">
		<!--#if(phpdisk_user_login()){#-->
		<a href="javascript:;" onclick="abox('_phpdisk/folder.php?act=add_folder&d={$d}','<?=__('new folder')?>',350,220);" class="btn btn-outline-success btn-sm me-1 mb-1"><i class="bx bx-folder-plus"></i><?=__('new folder')?></a>
		<a href="javascript:;" onclick="click_up_btn()" class="btn btn-outline-success btn-sm me-1 mb-1 a_up_btn"><i class="bx bx-upload"></i><?=__('upload')?></a>
			<!--#if(phpdisk_admin_login()){#-->
			<a href="_phpdisk/admin.php" class="btn btn-outline-primary btn-sm me-1 mb-1"><i class="bx bx-cog"></i><?=__('settings')?></a>
			<!--#}else{#-->
			<a href="javascript:;" onclick="login_admin()" class="btn btn-outline-primary btn-sm me-1 mb-1"><i class="bx bx-cog"></i><?=__('settings')?></a>
			<!--#}#-->
		<a href="javascript:;" onclick="logout_act()" class="btn btn-outline-danger btn-sm me-1 mb-1"><?=__('welcome')?> {$cfg['username']} , <?=__('Logout')?></a>
		<!--#}else{#-->
		<a href="javascript:;" onclick="login_act()" class="btn btn-primary btn-sm me-1 mb-1"><?=__('Login to manage')?></a>
		<!--#}#-->

</div>
<!--end breadcrumb-->
<hr />
<!--#if(phpdisk_user_login() && $settings['allow_upload']){#-->
<!-- upload -->
<div class="mb-4" id="up_box" style="display:none">
	<div id="up_area" class="up_area shadow radius-10 border-bottom border-0 border-3 border-warning" ondragenter="over_area()" ondragover="over_area()" ondragleave="out_area()" title="<?=__('drag file to upload')?>" >
	<div class="col-12 text-center p-4">
		<button class="btn btn-primary bg-gradient-blues btn-lg p-3" id="sel_cover_btn"><i class="bx bx-upload bx-md"></i><?=__('upload file')?></button>&nbsp;&nbsp;
			<span class="align-bottom"><input class="form-check-input" type="checkbox" id="replace_file_checked" value="1"><label for="replace_file_checked"><?=__('replace_file')?></label></span>
		<div id="up_list"></div>
		</div>
	</div>
	
</div>
<div class="alert alert-success"><i class="bx bx-laugh bx-burst"></i><?=__('dir_stats')?> <i class="bx bx-bar-chart bx-flashing"></i><?=__('file_count')?>: {$disk_stats[file_count]} , <?=__('folder_count')?>: {$disk_stats[folder_count]} ,<?=__('used_size')?>: {$disk_stats[used_size]} / {$disk_stats[total_space]}</div>
<!--#}#-->

<!--#if($settings['announce']){#-->
<div class="alert alert-{$settings['announce_bg']}"><i class="bx bx-info-circle bx-burst"></i>{#base64_decode($settings['announce'])#}</div>
<!--#}#-->

<div class="float-end bx-xs">
<a href="{$list_page}" title="<?=__('list show')?>"><i class="bx bx-spreadsheet" id="grid_0"></i></a>
<a href="{$grid_page}" title="<?=__('grid show')?>"><i class="bx bx-border-all" id="grid_1"></i></a></div>
<script>$('#grid_{$grid}').addClass('text-danger')</script>
<div class="clear"></div>
<!--#if($grid){#-->
<div style="min-height:300px" class=" border border-1 rounded mb-2">
<div class="shadow">
<div class="p-2 row row-cols-1 row-cols-sm-2 row-cols-lg-4">
<!--#
if(count($folders_array)){
	foreach($folders_array as $k => $v){
#-->
<div class="mb-3 col-12" id="fd_{$k}">
<div class="rounded p-2 border border-1 border-warning">
	<div><img src="_phpdisk/static/img/folder.gif" border="0" /><a href="{$v['a_folder']}&grid=1">{$v['filename']}</a></div>
	<div id="fds_{$k}" class="my-1 small"><a href="javascript:;" onclick="folder_stat('{$v[encode_fname]}','{$k}')"><i class="bx bx-data bx-xs"></i>...</a></div>
	<div class="my-1 text-secondary small"><i>{$v['file_time']}</i></div>
	<div class="bx-xs">
	<a href="javascript:;" onclick="view_qr1('{$v['a_qr_folder']}',1)" title="<?=__('scan code')?>"><i class="bx bx-customize"></i></a>
	<!--#if(phpdisk_user_login()){#-->
	<a href="javascript:;" onclick="abox('_phpdisk/folder.php?act=rename_folder&d={$d}&old_folder_name={$v['sys_fname']}','<?=__('rename folder')?>',350,220);" title="<?=__('edit folder')?>"><i class="bx bx-edit"></i></a>
	<a href="javascript:;" onclick="del_folder('{$v['encode_fname']}',{$k})" title="<?=__('delete folder')?>"><i class="bx bx-trash text-danger"></i></a>
	<!--#}#-->

	
	</div>
</div>
</div>
<!--#	
	}
	unset($folders_array);
}	
#-->
<!--#
if(count($files_array)){
	foreach($files_array as $k => $v){
#-->
<div class="mb-3 col-12" id="fl_{$k}">
<div class="rounded p-2 border">
	<div>{#file_icon($v['extension'])#} <a href="javascript:;" onclick="preview_file('{$v['a_view']}')">{$v['filename']}</a></div>
	<div class="my-1 small">{$v['file_size']}</div>
	<div class="my-1 text-secondary small"><i>{$v['file_time']}</i></div>
	<div class="bx-xs">
	<a href="javascript:;" onclick="preview_file('{$v['a_view']}')" title="<?=__('view file')?>"><i class="bx bx-show"></i></a>
	<a href="javascript:;" onclick="view_qr2('{$v['a_qr_down']}','{$v['a_qr_view']}',1)" title="<?=__('scan code')?>"><i class="bx bx-customize"></i></a>
	<a href="{$v['a_down']}" target="_blank" onclick="atips('<?=__('down tips')?>',1)" title="<?=__('download')?>"><i class="bx bx-download"></i></a>
	<!--#if(phpdisk_user_login()){#-->
	<a href="javascript:;" onclick="abox('_phpdisk/file.php?act=rename_file&d={$d}&old_file_name={$v['sys_fname']}','<?=__('rename file')?>',350,220);" title="<?=__('edit file')?>"><i class="bx bx-edit"></i></a>
	<a href="javascript:;" onclick="del_file('{$v['encode_fname']}',{$k})" title="<?=__('delete file')?>"><i class="bx bx-trash text-danger"></i></a>
	<!--#}#-->
	</div>
</div>
</div>

<!--#	
	}
	unset($files_array);
}	
#-->

</div>
</div>
</div>
<!--#}else{#-->
<div style="min-height:300px" class="table-responsive border border-1 p-2 rounded mb-2">
<table id="fd_table" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover table-striped shadow col-12">
<!--#
if(count($folders_array)){
#-->
<thead class="table-secondary">
<tr>
	<th width="30%"><?=__('folder_name')?></th>
	<th width="22%"><?=__('file_size')?></th>
	<th width="20%"><?=__('update time')?></th>
	<th><?=__('operate')?></th>
</tr>
</thead>
<tbody>
<!--#
	foreach($folders_array as $k => $v){
#-->
<tr id="fd_{$k}">
	<td valign="middle" style="max-width:200px;" class="text-truncate" title="{$v['filename']}"><img src="_phpdisk/static/img/folder.gif" border="0" /><a href="{$v['a_folder']}&grid=0">{$v['filename']}</a></td>
	<td valign="middle" class="small"><div id="fds_{$k}"><a href="javascript:;" onclick="folder_stat('{$v[encode_fname]}','{$k}')"><i class="bx bx-data bx-xs"></i>...</a></div></td>
	<td valign="middle" class="small">{$v['file_time']}</td>
	<td valign="middle" class="bx-xs">
	<a href="javascript:;" onclick="view_qr1('{$v['a_qr_folder']}',1)" title="<?=__('scan code')?>"><i class="bx bx-customize"></i></a>
	<!--#if(phpdisk_user_login()){#-->
	<a href="javascript:;" onclick="abox('_phpdisk/folder.php?act=rename_folder&d={$d}&old_folder_name={$v['sys_fname']}','<?=__('rename folder')?>',350,220);" title="<?=__('edit folder')?>"><i class="bx bx-edit"></i></a>
	<a href="javascript:;" onclick="del_folder('{$v['encode_fname']}',{$k})" title="<?=__('delete folder')?>"><i class="bx bx-trash text-danger"></i></a>
	<!--#}#-->
	</td>
</tr>
<!--#	
	}
	unset($folders_array);
}else{	
#-->
<tr>
	<td colspan="6"><?=__('no folder')?></td>
</tr>
<!--#
}
#-->
</tbody>
</table>
<br /><a name="fl_tag" id="fl_tag"></a>
<table id="fl_table" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover table-striped shadow col-12">
<!--#
if(count($files_array)){
#-->
<thead class="table-secondary">
<tr>
	<th width="30%"><?=__('file_name')?></th>
	<th width="22%"><?=__('file_size')?></th>
	<th width="20%"><?=__('update time')?></th>
	<th><?=__('operate')?></th>
</tr>
</thead>
<tbody>
<!--#
	foreach($files_array as $k => $v){
#-->
<tr id="fl_{$k}">
	<td valign="middle" style="max-width:200px;" class="text-truncate" title="{$v['filename']}"><a href="{$v['a_down']}" target="_blank" onclick="atips('<?=__('down tips')?>',1)" title="<?=__('download')?>"><i class="bx bx-download bx-xs"></i></a>
	{#file_icon($v['extension'])#} <a href="javascript:;" onclick="preview_file('{$v['a_view']}')">{$v['filename']}</a></td>
	<td valign="middle" class="small">{$v['file_size']}</td>
	<td valign="middle" class="small">{$v['file_time']}</td>
	<td valign="middle" class="bx-xs">
	<a href="javascript:;" onclick="preview_file('{$v['a_view']}')" title="<?=__('view file')?>"><i class="bx bx-show"></i></a>
	<a href="javascript:;" onclick="view_qr2('{$v['a_qr_down']}','{$v['a_qr_view']}',1)" title="<?=__('scan code')?>"><i class="bx bx-customize"></i></a>
	<a href="{$v['a_down']}" target="_blank" onclick="atips('<?=__('down tips')?>',1)" title="<?=__('download')?>"><i class="bx bx-download"></i></a>
	<!--#if(phpdisk_user_login()){#-->
	<a href="javascript:;" onclick="abox('_phpdisk/file.php?act=rename_file&d={$d}&old_file_name={$v['sys_fname']}','<?=__('rename file')?>',350,220);" title="<?=__('edit file')?>"><i class="bx bx-edit"></i></a>
	<a href="javascript:;" onclick="del_file('{$v['encode_fname']}',{$k})" title="<?=__('delete file')?>"><i class="bx bx-trash text-danger"></i></a>
	<!--#}#-->
	</td>
</tr>
<!--#
	}
	unset($files_array);
}else{	
#-->
<tr>
	<td colspan="6"><?=__('no file')?></td>
</tr>
<!--#
}
#-->
</tbody>
</table>
</div>
<!--#}#--> <!-- end list-->


</div>
</div>
</div>
<script src="{$user_tpl_dir}assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{$user_tpl_dir}assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#fd_table').DataTable({lengthChange: false});
})
$(document).ready(function() {
	$('#fl_table').DataTable();
})
</script>
<!--#if(phpdisk_user_login()){#-->
<script type="text/javascript" src="{$user_tpl_dir}plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="{$user_tpl_dir}plupload/i18n/{DEFAULT_LANG}.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#up_area').mouseover(function(){over_area()}
	).mouseout(function(){out_area()})

})
function over_area(){
	$('#up_area').removeClass("border-warning").addClass("border-primary")
}
function out_area(){
	$('#up_area').removeClass("border-primary").addClass("border-warning")
	
}
var uploader1 = new plupload.Uploader({
	multi_selection : true,
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'sel_cover_btn', 
	url : '{$file_rc_upload_url}',

	flash_swf_url : '{$user_tpl_dir}plupload/Moxie.swf',
	silverlight_xap_url : '{$user_tpl_dir}plupload/Moxie.xap',
	
	filters : {
		<!--#if($h5_upload_ext){#-->
		mime_types: [{title : "supported files", extensions : "{$h5_upload_ext}"}],
		<!--#}#-->
		max_file_size : '{$h5_max_filesize}'
		//prevent_duplicates : true
	},
	dragdrop: true,
	drop_element: 'up_area',
	
	/*multipart_params: {
		
	},*/

	init:{
		PostInit: function() {
			/*$('#up_cover_btn').click(function() {
				uploader1.start();
				return false;
			});*/
		},
		BeforeUpload: function(up, file) {
			//console.log(file.name)
			var replace_file = 0
			if($('#replace_file_checked').is(':checked')){
				replace_file = 1
			}
			uploader1.setOption("multipart_params", {
			"replace_file": replace_file,
			"act": "rc_upload",
			"d":"{$d}",
			"up_token":"{$up_token}"
			});
		},
		FilesAdded: function(up, files) {
			let str = ''
			plupload.each(files, function(file) {
				//console.log(file.id)
				str += '<div id="' + file.id + '">'
				str += '<div class="pt-2 text-break col-12" ><span class=" float-start"><i class="bx bx-file text-primary"></i>'+file.name+'</span><span class="float-end" style="cursor:pointer;" onclick="uploader1.removeFile('+file.id+')" title="<?=__('delete')?>"><i class="bx bx-x-circle text-danger"></i></span></div>'
				str += '<div class="clear"></div>'
				str += '<div class="progress" style="height:16px;">'
				str += '<div class="progress-bar bg-gradient-blues" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>'
				str += '</div>'
				str += '</div>'
				
			})
			$('#up_list').html($('#up_list').html()+str)
			$('#up_list').show()

			up.start();
		},
		UploadProgress: function(up, file) {
			var d = document.getElementById(file.id);

			var prog = d.getElementsByTagName('div')[2];
			var progBar = prog.getElementsByTagName('div')[0]
			progBar.style.width= progBar.innerHTML = file.percent+'%'; // filled progress bar length
			progBar.setAttribute('aria-valuenow', file.percent);

		},
		FileUploaded: function(up, file, res) {
		//console.log(res)
			var obj = JSON.parse(res.response);
			if(obj.ok){
				setTimeout(function(){
					atips(obj.dt.file_name+'...<?=__('upload success')?>',1);				
				},800);
				setTimeout(function(){
					$('#'+file.id).slideUp(100)		
				},3000);
				
			}else{
				atips(obj.msg)
			}
		},
		UploadComplete: function(up, files) {

			let currentUrl = new URL(window.location.href);
			let params = new URLSearchParams(currentUrl.search);
			params.set('t',Math.random());
			let newSearchString = params.toString();
			let newUrl = currentUrl.origin + currentUrl.pathname + '?' + newSearchString;

			setTimeout(function(){
				document.location = newUrl+'#fl_tag'
			},800);
		},
		FilesRemoved: function(up, files) {
		//console.log(files)
			plupload.each(files, function(file) {
				$('#'+file.id).hide(10)
			})
		},
		Error: function(up, err) {
			atips("Error #" + err.code + ": " + err.message)
		}
	}

});
uploader1.init();
</script>
<!--#}#-->
