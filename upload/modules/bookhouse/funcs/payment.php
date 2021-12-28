<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2016 mynukeviet. All rights reserved
 * @Createdate Sun, 20 Nov 2016 07:31:04 GMT
 */
if (! defined('NV_IS_MOD_BOOKHOUSE'))
    die('Stop!!!');

if (! defined('NV_IS_USER') or ! nv_user_in_groups($array_config['post_groups'])) {
    $url_redirect = $client_info['selfurl'];
    $url_back = NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($url_redirect);
    $contents = nv_theme_alert($lang_module['is_user_title'], $lang_module['is_user_content'], 'info', $url_back, $lang_module['login']);
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$id = $nv_Request->get_int('id', 'post,get', 0);
$all = $nv_Request->get_int('all', 'post,get', 0);
$array_option = array();
$mod = $nv_Request->get_title('mod', 'post,get', '');
$array_info = array();
$show_row_info = 1;

if ($all) {
    $array_info = $db->query('SELECT id, title, catid, code FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $id)->fetch();
    if ($array_info) {
        $array_info['checksum'] = md5($global_config['sitekey'] . $user_info['userid'] . $array_info['id']);
        $array_info['cat'] = $array_cat[$array_info['catid']]['title'];
        $array_option['group'] = array();
        $_array_option = unserialize($array_config['specialgroup_config']);
        $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat WHERE useradd=1 ORDER BY weight ASC');
        while ($_row = $result->fetch()) {
            if (isset($_array_option[$_row['bid']]) and isset($array_block_cat[$_row['bid']]) and $array_block_cat[$_row['bid']]['useradd']) {
                $array_option['group'][$_row['bid']] = $_array_option[$_row['bid']];
            }
        }
    }
    
    if ($array_config['refresh_allow']) {
        $array_option['refresh'] = unserialize($array_config['refresh_config']);
    }
} else {
    $groupid = $nv_Request->get_int('groupid', 'post,get', 0);
    $contents = '';
    
    $array_info = $db->query('SELECT id, title, catid FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $id)->fetch();
    if ($array_info) {
        $array_info['checksum'] = md5($global_config['sitekey'] . $user_info['userid'] . $array_info['id']);
        $array_info['mod'] = $mod;
        $array_info['cat'] = $array_cat[$array_info['catid']]['title'];
        
        if ($mod == 'group') {
            $_array_option = unserialize($array_config['specialgroup_config']);
            $array_groups = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat WHERE useradd=1 AND bid=' . $groupid . ' ORDER BY weight ASC')->fetch();
			//print_r($_array_option[$groupid]);die;
            if ($array_groups) {
                $array_groups['id'] = $id;
                if (isset($_array_option[$groupid]) and isset($array_block_cat[$groupid]) and $array_block_cat[$groupid]['useradd']) {
                    $array_option = $_array_option[$groupid];
                }
            }
        }
    } elseif ($mod == 'refresh') {
        if ($array_config['refresh_allow']) {
            $array_option = unserialize($array_config['refresh_config']);
        }
    } elseif ($mod == 'upgrade_group') {
        $group_list = nv_groups_list();
        if (! empty($group_list)) {
            $_array_option = unserialize($array_config['upgrade_group_config']);
            
            if (isset($_array_option[$groupid])) {
                $array_option = $_array_option[$groupid];
                
                $array_info['id'] = $groupid;
                $array_info['title'] = $lang_module['payment_' . $mod];
                $array_info['bid'] = $groupid;
                $array_info['description'] = $group_list[$groupid]['description'];
            }
        }
    }
}


$contents = nv_theme_payment($array_info, $array_option, $id, $mod, $all, $show_row_info);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents, false);
include NV_ROOTDIR . '/includes/footer.php';
