<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (! defined('NV_IS_FILE_SITEINFO'))
    die('Stop!!!');

$lang_siteinfo = nv_get_lang_module($mod);
/*
 * // Tong so bai viet
 * $number = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_rows where status= 1 AND publtime < ' . NV_CURRENTTIME . ' AND (exptime=0 OR exptime>' . NV_CURRENTTIME . ')' )->fetchColumn();
 * if ( $number > 0 )
 * {
 * $siteinfo[] = array(
 * 'key' => $lang_siteinfo['siteinfo_publtime'], 'value' => $number
 * );
 * }
 */

// Nhac nho cac tu khoa chua co mo ta
if (! empty($module_config[$mod]['tags_remind'])) {
    $number = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_tags WHERE description = \'\'')->fetchColumn();
    
    if ($number > 0) {
        $pendinginfo[] = array(
            'key' => $lang_siteinfo['siteinfo_tags_incomplete'],
            'value' => $number,
            'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $mod . '&amp;' . NV_OP_VARIABLE . '=tags&amp;incomplete=1'
        );
    }
}