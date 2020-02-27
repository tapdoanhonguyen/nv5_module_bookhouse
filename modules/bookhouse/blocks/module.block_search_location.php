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

if (! nv_function_exists('nv_block_search_location')) {

    function nv_block_search_location($block_config)
    {
        global $db, $db_config, $nv_Request, $site_mods, $module_info, $module_name, $module_config, $global_config, $array_config, $array_cat, $lang_module, $array_search;
        
        $module = $block_config['module'];
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/bookhouse/block_search_location.tpl')) {
            $block_theme = $module_info['template'];
        } else {
            $block_theme = 'default';
        }
        
        $xtpl = new XTemplate('block_search_location.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('MODULE_NAME', $module_name);
        $xtpl->assign('OP_NAME', 'search');
        
        $data_config = array(
            'is_district' => true,
            'is_ward' => true,
            'select_provinceid' => isset($array_search['provinceid']) ? $array_search['provinceid'] : 0,
            'select_districtid' => isset($array_search['districtid']) ? $array_search['districtid'] : 0,
            'select_wardid' => isset($array_search['wardid']) ? $array_search['wardid'] : 0,
            'blank_title_province' => true,
            'blank_title_district' => true,
            'blank_title_ward' => true
        );
        $location = new Location();
        $location->set('IsDistrict', 1);
        $location->set('IsWard', 1);
        $location->set('SelectProvinceid', isset($array_search['provinceid']) ? $array_search['provinceid'] : 0);
        $location->set('SelectDistrictid', isset($array_search['districtid']) ? $array_search['districtid'] : 0);
        $location->set('SelectWardid', isset($array_search['wardid']) ? $array_search['wardid'] : 0);
        $location->set('BlankTitleProvince', 1);
        $location->set('BlankTitleDistrict', 1);
        $location->set('BlankTitleWard', 1);
        $xtpl->assign('LOCATION', $location->buildInput());
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_search_location($block_config);
}