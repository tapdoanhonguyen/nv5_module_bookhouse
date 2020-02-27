<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 07/30/2013 10:27
 */
if (! defined('NV_ADMIN'))
    die('Stop!!!');

if (! function_exists('nv_array_province_admin')) {

    function nv_array_province_admin($module_data)
    {
        global $db_slave;
        
        $array_province_admin = array();
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins ORDER BY userid ASC';
        $result = $db_slave->query($sql);
        
        while ($row = $result->fetch()) {
            $array_province_admin[$row['userid']][$row['provinceid']] = $row;
        }
        
        return $array_province_admin;
    }
}

$is_refresh = false;
$array_province_admin = nv_array_province_admin($module_data);

if (! empty($module_info['admins'])) {
    $module_admin = explode(',', $module_info['admins']);
    foreach ($module_admin as $userid_i) {
        if (! isset($array_province_admin[$userid_i])) {
            $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_admins (userid, provinceid, admin, add_item, pub_item, edit_item, del_item) VALUES (' . $userid_i . ', 0, 1, 1, 1, 1, 1)');
            $is_refresh = true;
        }
    }
}
if ($is_refresh) {
    $array_province_admin = nv_array_province_admin($module_data);
}

$admin_id = $admin_info['admin_id'];
$NV_IS_ADMIN_MODULE = false;
$NV_IS_ADMIN_FULL_MODULE = false;
if (defined('NV_IS_SPADMIN')) {
    $NV_IS_ADMIN_MODULE = true;
    $NV_IS_ADMIN_FULL_MODULE = true;
} else {
    if (isset($array_province_admin[$admin_id][0])) {
        $NV_IS_ADMIN_MODULE = true;
        if (intval($array_province_admin[$admin_id][0]['admin']) == 2) {
            $NV_IS_ADMIN_FULL_MODULE = true;
        }
    }
}

$allow_func = array(
    'main',
    'items',
    'alias',
    'getitemid',
    'images',
    'queue',
    'duplicate',
    'projects',
    'projects-content',
    'reason',
    'type',
'pricetype'
);

$submenu['items&add'] = $lang_module['items_add'];
$submenu['queue'] = $lang_module['items_queue'];
$submenu['duplicate'] = $lang_module['duplicate'];
if ($NV_IS_ADMIN_MODULE) {
    $submenu['groups'] = $lang_module['groups'];
    $submenu['tags'] = $lang_module['tags'];
    $submenu['cat'] = $lang_module['cat_manage'];
    $submenu['projects'] = $lang_module['projects'];
    $submenu['way'] = $lang_module['way'];
    $submenu['legal'] = $lang_module['legal'];
    $submenu['roomtype'] = $lang_module['roomtype'];
    $submenu['reason'] = $lang_module['reason'];
    $submenu['type'] = $lang_module['type'];
    $submenu['pricetype'] = $lang_module['pricetype'];
    $submenu['admins'] = $lang_module['admin'];
    $submenu['econtent'] = $lang_module['econtent'];
    $submenu['config'] = $lang_module['config'];
    
    $allow_func[] = 'config';
    $allow_func[] = 'cat';
    $allow_func[] = 'roomtype';
    $allow_func[] = 'tags';
    $allow_func[] = 'tagsajax';
    $allow_func[] = 'way';
    $allow_func[] = 'legal';
    $allow_func[] = 'admins';
    $allow_func[] = 'groups';
    $allow_func[] = 'list_block_cat';
    $allow_func[] = 'chang_block_cat';
    $allow_func[] = 'block';
    $allow_func[] = 'blockcat';
    $allow_func[] = 'change_block';
    $allow_func[] = 'list_block';
    $allow_func[] = 'econtent';
}
