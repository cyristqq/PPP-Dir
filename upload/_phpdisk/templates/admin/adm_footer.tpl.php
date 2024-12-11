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
#	$Id: adm_footer.tpl.php 31 2024-12-10 15:04:54Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--Start Back To Top Button--> 
<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		
	<!-- Bootstrap JS -->
	<script src="{$admin_tpl_dir}assets/js/bootstrap.bundle.min.js"></script>
	<script>
$(document).ready(function() {
		$(window).on("scroll", function() {
			$(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
		}), $(".back-to-top").on("click", function() {
			return $("html, body").animate({
				scrollTop: 0
			}, 600), !1
		})
	})
</script>

<div class="foot_box">

<div class="foot_info py-4 text-center">
Powered by <a href="{PHPDISK_SITE}" target="_blank">PHPDisk Team</a>
{PHPDISK_EDITION} v{PHPDISK_VERSION} 2008-{NOW_YEAR} &copy; All Rights Reserved.</div>
</div>

</body>
</html>
