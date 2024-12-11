/**
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
#	$Id: notice.js 21 2024-12-09 07:51:27Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##
*/
function notice(act,str) {
	let act_arr = ["default", "info", "warning","error","success"];
	let idx = 0
	for (var i = 0; i < act_arr.length; i++) {
	  var element = act_arr[i]
	  	  if(element==act){
	  	  	idx = i
	  	  }
	}
	var act_icon = ["","bx bx-info-circle","bx bx-error","bx bx-x-circle","bx bx-check-circle"]
	//console.log(act_icon[idx])

	Lobibox.notify(act, {
		pauseDelayOnHover: true,
		continueDelayOnInactiveTab: false,
		rounded: true,
		position: 'center top',
		icon: act_icon[idx],
		msg: str
	});
}