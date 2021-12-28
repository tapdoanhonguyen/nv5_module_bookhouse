<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2016 mynukeviet. All rights reserved
 * @Createdate Sun, 20 Nov 2016 07:31:04 GMT
 */
if (! defined('NV_IS_MOD_BOOKHOUSE'))
    die('Stop!!!');

/*
$result = $db->query('select id, addtime from nv4_vi_nha_dat');
while($row = $result->fetch())
{
$db->query('update nv4_vi_nha_dat_block set addtime=' . $row['addtime'] . ' where id=' . $row['id']);
}
die('1');
*/

// Xóa tin hết hạn khỏi block
if ($nv_Request->isset_request('groupdel', 'get')) {
    try {
       $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE exptime < ' . NV_CURRENTTIME);
	   
        while ($row = $result->fetch()) {
            $count = $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE bid=' . $row['bid'] . ' AND id=' . $row['id']);
            if ($count) {
                // $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET group_config = "" WHERE id=' . $row['id']);
                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET groupid = 0 WHERE id=' . $row['id']);
            }
        }
        $nv_Cache->delMod($module_name);
    } catch (Exception $e) {
        trigger_error($e->getMessage());
    }
} else {
    // Gửi mail trong hàng đợi
    $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_mail_queue');
	
    while ($row = $result->fetch()) {
        $from = array(
            $global_config['site_name'],
            $global_config['site_email']
        );
        
        if (nv_sendmail($from, $row['tomail'], $row['subject'], $row['message'])) {
            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_mail_queue WHERE id=' . $row['id']);
        }
    }

   // Tự động làm mới
    if (!empty($array_config['refresh_auto_config'])) {
        $refresh_auto_config = unserialize($array_config['refresh_auto_config']);
        foreach ($refresh_auto_config as $groupid => $min) {
            if (!empty($min)) {
                $result = $db->query('SELECT bid, id, refresh_lasttime FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE bid=' . $groupid . '  AND addtime <= ' . NV_CURRENTTIME . ' AND (exptime = 0 OR exptime > ' . NV_CURRENTTIME . ') ORDER BY refresh_lasttime DESC');
                $stt = 1;
                while (list ($bid, $id, $refresh_lasttime) = $result->fetch(3)) {
                    $interval = $min * 60;
                    if ($interval > 0 && $refresh_lasttime + $interval <= NV_CURRENTTIME) {
                        echo $id . '<br />';
                        $ordertime = NV_CURRENTTIME + $stt;
                        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET ordertime=' . $ordertime . ' WHERE id=' . $id);
                        $stt++;
                        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block SET refresh_lasttime=' . $ordertime . ' WHERE bid=' . $bid . ' AND id=' . $id);
                        $cronjobs_next_time = NV_CURRENTTIME + $interval;
                        if ($db->exec("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = '" . $cronjobs_next_time . "' WHERE lang = '" . NV_LANG_DATA . "' AND module = '" . $module_name . "' AND config_name = 'refresh_next_time' AND (config_value < '" . NV_CURRENTTIME . "' OR config_value > '" . $cronjobs_next_time . "')")) {
                            $nv_Cache->delMod('settings');
                        }
                    }
                }

            }
        }
        $nv_Cache->delMod($module_name);
    }
}
die('OK');
