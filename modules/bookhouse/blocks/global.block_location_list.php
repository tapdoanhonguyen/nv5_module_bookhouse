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

if (! nv_function_exists('nv_block_location_list')) {

    function nv_block_config_location_list($module, $data_block, $lang_block)
    {
        global $db, $db_config, $global_config, $nv_Request;
        
        require_once NV_ROOTDIR . '/modules/location/location.class.php';
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/block_location_list.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/bookhouse/block_location_list.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $xtpl = new XTemplate('block_location_list.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse');
        $xtpl->assign('LANG', $lang_block);
        
        $location = new Location();
        $location->set('IsDistrict', 1);
        $location->set('SelectCountryid', $data_block['countryid']);
        $location->set('SelectProvinceid', $data_block['provinceid']);
        $location->set('SelectDistrictid', $data_block['districtid']);
        $location->set('BlankTitleProvince', 1);
        $location->set('BlankTitleDistrict', 1);
        $xtpl->assign('LOCATION', $location->buildInput());
        
        $xtpl->parse('config');
        return $xtpl->text('config');
    }

    function nv_block_config_location_list_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['countryid'] = $nv_Request->get_int('countryid', 'post', 0);
        $return['config']['provinceid'] = $nv_Request->get_int('provinceid', 'post', 0);
        $return['config']['districtid'] = $nv_Request->get_int('districtid', 'post', 0);
        return $return;
    }

    function nv_block_location_list($block_config)
    {
        global $site_mods, $module_info, $db, $db_config, $module_config, $global_config, $nv_Cache, $module_name, $lang_module, $location_array_config;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
        $location_array_config = $module_config['location'];
        
        if ($module != $module_name) {
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
        }
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/block_location_list.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $cache_file = NV_LANG_DATA . '_block_location_list_' . $block_config['bid'] . '-' . NV_CACHE_PREFIX . '.cache';
        if (($cache = $nv_Cache->getItem($module, $cache_file)) != false) {
            $array_block_location_list = unserialize($cache);
        } else {
            $array_block_location_list = array();
            
            if (! empty($block_config['districtid'])) {
                $result = $db->query('SELECT wardid, title, type FROM ' . $db_config['prefix'] . '_location_ward WHERE districtid=' . $block_config['districtid']);
                while ($_row = $result->fetch()) {
                    $array_block_location_list[] = array(
                        'id' => $_row['wardid'],
                        'title' => $location_array_config['allow_type'] ? $_row['type'] . ' ' . $_row['title'] : $_row['title'],
                        'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=search&amp;countryid=' . $block_config['countryid'] . '&amp;provinceid=' . $block_config['provinceid'] . '&amp;districtid=' . $block_config['districtid'] . '&amp;wardid=' . $_row['wardid'] 
                    );
                }
            } elseif (! empty($block_config['provinceid'])) {
                $result = $db->query('SELECT districtid, title, type FROM ' . $db_config['prefix'] . '_location_district WHERE provinceid=' . $block_config['provinceid']);
                while ($_row = $result->fetch()) {
                    $array_block_location_list[] = array(
                        'id' => $_row['districtid'],
                        'title' => $location_array_config['allow_type'] ? $_row['type'] . ' ' . $_row['title'] : $_row['title'],
                        'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=search&amp;countryid=' . $block_config['countryid'] . '&amp;provinceid=' . $block_config['provinceid'] . '&amp;districtid=' . $_row['districtid']
                    );
                }
            } elseif (! empty($block_config['countryid'])) {
                $result = $db->query('SELECT provinceid, title, type FROM ' . $db_config['prefix'] . '_location_province WHERE countryid=' . $block_config['countryid']);
                while ($_row = $result->fetch()) {
                    $array_block_location_list[] = array(
                        'id' => $_row['provinceid'],
                        'title' => $location_array_config['allow_type'] ? $_row['type'] . ' ' . $_row['title'] : $_row['title'],
                        'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=search&amp;countryid=' . $block_config['countryid'] . '&amp;provinceid=' . $_row['provinceid']
                    );
                }
            }
            
            if (! defined('NV_IS_MODADMIN')) {
                $cache = serialize($array_block_location_list);
                $nv_Cache->setItem($module, $cache_file, $cache);
            }
        }
        
        $xtpl = new XTemplate('block_location_list.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        
        if (! empty($array_block_location_list)) {
            foreach ($array_block_location_list as $location) {
                $location['link'] = $location['link'] . '&amp;search=1';
                $xtpl->assign('LOCATION', $location);
                $xtpl->parse('main.location');
            }
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods;
    
    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        $content = nv_block_location_list($block_config);
    }
}