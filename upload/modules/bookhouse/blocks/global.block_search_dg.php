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

if (! nv_function_exists('nv_block_search_dg')) {
 
    function nv_block_search_dg($block_config)
    {
        global $db, $db_config, $site_mods, $module_info, $module_name, $module_config, $global_config, $array_config, $lang_module, $array_way, $nv_Request, $op, $module_file, $module_array_cat;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        
        if ($module != $module_name) {
            require_once NV_ROOTDIR . '/modules/location/location.class.php';
            require_once NV_ROOTDIR . '/modules/' . $site_mods[$module]['module_file'] . '/language/' . NV_LANG_INTERFACE . '.php';
        }
        
        $themetype = 'block_search_vertical_dg.tpl';
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/' . $themetype)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $xtpl = new XTemplate($themetype, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('MODULE_NAME', $module);
        $xtpl->assign('OP_NAME', 'search');
        
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $array_cat, $array_config, $module_array_cat;
    
    $module = $block_config['module'];
        $content = nv_block_search_dg($block_config);
    }