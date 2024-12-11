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
#	$Id: ajax.php 21 2024-12-09 07:51:27Z along $
#
#	Copyright (C) 2008-2083 PHPDisk Team. All Rights Reserved.
#
*/
include "includes/commons.inc.php";

// auth check
if (in_array($act, array('del_file', 'del_folder','login_admin')) && !$pd_uid) {
    echo json_encode(array('ok' => false, 'msg' => __('check auth error')));
    exit;
}

switch ($act) {
    case 'login_admin':
        $pass = trim(gpc('pass', 'P', ''));
        if (!$pass || $pass != $cfg['admin_login_pass']) {
            echo json_encode(array('ok' => false, 'msg' => __('admin_login_pass error')));
            exit;
        }
        $login_state = 1; // 1:login success
        pd_setcookie(PHPDISK_COOKIE_ADMIN, pd_encode("$login_state\t" . phpdisk_md5($pass)));

        echo json_encode(array('ok' => true));
        exit;

        break;   
    case 'login_act':
        $pass = trim(gpc('pass', 'P', ''));
        if (!$pass || $pass != $cfg['login_pass']) {
            echo json_encode(array('ok' => false, 'msg' => __('login_pass error')));
            exit;
        }
        $login_state = 1; // 1:login success
        pd_setcookie(PHPDISK_COOKIE, pd_encode("$login_state\t" . phpdisk_md5($pass)), 86400 * 7);

        echo json_encode(array('ok' => true));
        exit;

        break;

    case 'logout_act':
        pd_setcookie(PHPDISK_COOKIE, '', -86400);
        echo json_encode(array('ok' => true));
        exit;
        break;

    case 'folder_stat':
        $fn = rawurldecode(base64_decode(trim(gpc('d', 'P', ''))));

        $base_dir = PHPDISK_ROOT . $cfg['phpdisk_dir'];
        if ($fn) {
            $dir = $base_dir . '/' . $fn;
        }

        echo json_encode(array('ok' => true, 'dt' => getDirSize($dir)));
        exit;
        break;

    case 'del_file':
        $fn = rawurldecode(base64_decode(trim(gpc('fn', 'P', ''))));

        $base_dir = PHPDISK_ROOT . $cfg['phpdisk_dir'];
        if ($fn) {
            $dir = $base_dir . '/' . $fn;
        }
        if (!@unlink($dir)) {
            echo json_encode(array('ok' => false, 'msg' => __('delete file failed')));
            exit;
        }
        echo json_encode(array('ok' => true));
        exit;

        break;

    case 'del_folder':
        $fn = rawurldecode(base64_decode(trim(gpc('fn', 'P', ''))));

        $base_dir = PHPDISK_ROOT . $cfg['phpdisk_dir'];
        if ($fn) {
            $dir = $base_dir . '/' . $fn;
        }
        if (!delDir($dir)) {
            echo json_encode(array('ok' => false, 'msg' => __('delete folder failed')));
            exit;
        }
        echo json_encode(array('ok' => true));
        exit;

        break;
    default:
		header('Location: ../');

}