<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');

if (! nv_function_exists('nv_block_bookhouse_user_groups')) {

    function nv_block_bookhouse_user_groups($block_config)
    {
        global $db, $global_config, $lang_module, $module_name, $module_data, $user_info, $module_info, $module_name;
        
        if (! defined('NV_IS_USER')) {
            return '';
        }
        
        $array_data = array();
        $rows = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_users_groups WHERE userid=' . $user_info['userid'] . ' AND exptime > ' . NV_CURRENTTIME)->fetch();
        if ($rows) {
            // còn thời hạn
            $array_data['exptime'] = nv_convertfromSec($rows['exptime'] - NV_CURRENTTIME);
            $lang_module['user_groups_2'] = sprintf($lang_module['user_groups_2'], $array_data['exptime']);
        }
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/block_user_groups.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $group_list = nv_groups_list();
        $lang_module['user_groups_1'] = sprintf($lang_module['user_groups_1'], $group_list[$user_info['group_id']]['title']);
        
        $xtpl = new XTemplate('block_user_groups.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('URL_UPGRADE', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['upgrade']);

        if (empty($array_data)) {
            $xtpl->parse('main.upgrade');
        }else{
            $xtpl->assign('DATA', $array_data);
            $xtpl->parse('main.info');
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_bookhouse_user_groups($block_config);
}
