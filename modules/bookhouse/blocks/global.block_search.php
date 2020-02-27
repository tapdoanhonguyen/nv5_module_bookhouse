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

if (! nv_function_exists('nv_block_search12')) {
    
    if (! nv_function_exists('nv_bookhouse_numoney_to_strmoney1')) {

        function nv_tours_numoney_to_strmoney1($money)
        {
            global $lang_module;
            
            if ($money > 1000 and $money < 1000000) {
                $money = $money / 1000;
                return $money . ' ' . $lang_module['thousand'];
            } elseif ($money >= 1000000) {
                $money = $money / 1000000;
                return $money . ' ' . $lang_module['million'];
            }
            return $money;
        }
    }

    function nv_block_config_search12($module, $data_block, $lang_block)
    {
        global $site_mods, $global_config;
        
        $array_styletype = array(
            0 => $lang_block['styletype_0'],
            1 => $lang_block['styletype_1'],
            2 => $lang_block['styletype_2'],
            3 => $lang_block['styletype_3']
        );
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $site_mods[$module]['module_file'] . '/block_search_config.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $xtpl = new XTemplate('block_search_config.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $site_mods[$module]['module_file']);
        $xtpl->assign('LANG', $lang_block);
        $xtpl->assign('DATA', $data_block);
        $xtpl->assign('MODULE_NAME', $module);
        
        foreach ($array_styletype as $index => $value) {
            $sl = $index == $data_block['styletype'] ? 'selected="selected"' : '';
            $xtpl->assign('STYLE', array(
                'index' => $index,
                'value' => $value,
                'selected' => $sl
            ));
            $xtpl->parse('main.styletype');
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    function nv_block_config_search_submit12($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['styletype'] = $nv_Request->get_int('config_styletype', 'post', 0);
        $return['config']['price_begin'] = $nv_Request->get_title('config_price_begin', 'post', 1000000);
        $return['config']['price_end'] = $nv_Request->get_title('config_price_end', 'post', 20000000);
        $return['config']['price_step'] = $nv_Request->get_title('config_price_step', 'post', 1000000);
        return $return;
    }

    function nv_block_search12($block_config)
    {
        global $db, $db_config, $site_mods, $module_info, $module_name, $module_config, $global_config, $array_config, $lang_module, $module_module_way, $nv_Request, $op, $module_file, $module_array_cat, $nv_Cache;
        
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        
        if ($module != $module_name) {
            require_once NV_ROOTDIR . '/modules/location/location.class.php';
            require_once NV_ROOTDIR . '/modules/' . $site_mods[$module]['module_file'] . '/language/' . NV_LANG_INTERFACE . '.php';
        }
        
        $themetype = 'block_search_vertical.tpl';
        if ($block_config['styletype'] == 1) {
            $themetype = 'block_search_horizontal.tpl';
        } elseif ($block_config['styletype'] == 2) {
            $themetype = 'block_search_area.tpl';
        } elseif ($block_config['styletype'] == 3) {
            $themetype = 'block_search_type_tab.tpl';
            
            $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_type WHERE status=1 ORDER BY weight';
            $array_type = $nv_Cache->db($sql, 'id', $module);
            
            if (empty($array_type)) {
                return '';
            }
        }
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/' . $themetype)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $array_search = array(
            'keywords' => $nv_Request->get_title('keywords', 'get,post', ''),
            'provinceid' => $nv_Request->get_int('provinceid', 'get,post', 0),
            'districtid' => $nv_Request->get_int('districtid', 'get,post', 0),
            'wardid' => $nv_Request->get_int('wardid', 'get,post', 0),
            'typeid' => $nv_Request->get_int('typeid', 'get,post', 0)
        );
        
        $xtpl = new XTemplate($themetype, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('MODULE_NAME', $module);
        $xtpl->assign('OP_NAME', 'search');
        $xtpl->assign('SEARCH', $array_search);
        $xtpl->assign('DES_POINT', $array_config['dec_point']);
        $xtpl->assign('THOUSANDS_SEP', $array_config['thousands_sep']);
        
        if ($block_config['styletype'] == 3) {
            $array_catid = array();
            $typeid = !empty($array_search['typeid']) ? $array_search['typeid'] : array_keys($array_type)[0];
            $result = $db->query('SELECT catid FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_type_catid WHERE typeid=' . $typeid);
            while (list ($catid) = $result->fetch(3)) {
                $array_catid[] = $catid;
            }
        }
        
        if (! empty($module_array_cat)) {
            foreach ($module_array_cat as $catid => $value) {
                
                if (! empty($array_catid) and ! in_array($catid, $array_catid)) {
                    continue;
                }
                
                $value['space'] = '';
                if ($value['lev'] > 0) {
                    for ($i = 1; $i <= $value['lev']; $i ++) {
                        $value['space'] .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                }
                $value['selected'] = $catid == $array_search['catid'] ? ' selected="selected"' : '';
                
                $xtpl->assign('CAT', $value);
                $xtpl->parse('main.cat');
            }
        }
        
        if (! empty($module_module_way)) {
            foreach ($module_module_way as $way) {
                $way['selected'] = $way['id'] == $array_search['way'] ? 'selected="selected"' : '';
                $xtpl->assign('WAY', $way);
                $xtpl->parse('main.way');
            }
        }
        
        $location = new Location();
        $location->set('IsDistrict', 1);
		$location->set('Index', $block_config['bid']);
        $location->set('SelectProvinceid', $array_search['provinceid']);
        $location->set('SelectDistrictid', $array_search['districtid']);
        $location->set('BlankTitleProvince', 1);
        $location->set('BlankTitleDistrict', 1);
        
        if ($block_config['styletype'] == 2) {
            $location->set('IsDistrict', 0);
            $location->set('ColClass', 'col-xs-24 col-sm-24 col-md-24');
        }
        
        $xtpl->assign('LOCATION', $location->buildInput());
        
        if ($array_config['sizetype'] == 0) {
            $xtpl->parse('main.area');
        } elseif ($array_config['sizetype'] == 1) {
            $xtpl->parse('main.size');
        }
        
        // Chon khoang gia
        $array_price_spread = array();
        $val = $block_config['price_begin'];
        while (true) {
            $price1 = $val;
            $price2 = $val + $block_config['price_step'];
            if ($val < $block_config['price_end']) {
                $array_price_spread[] = array(
                    'index' => $price1 . '-' . $price2,
                    'title' => nv_tours_numoney_to_strmoney1($price1, $mod_file) . ' - ' . nv_tours_numoney_to_strmoney1($price2, $mod_file)
                );
            } elseif ($val >= $block_config['price_end']) {
                $array_price_spread[] = array(
                    'index' => $price1 . '-0',
                    'title' => $lang_module['from'] . ' ' . nv_tours_numoney_to_strmoney1($val, $mod_file)
                );
            }
            
            if ($val >= $block_config['price_end']) {
                break;
            }
            $val += $block_config['price_step'];
        }
        
        if (! empty($array_price_spread)) {
            foreach ($array_price_spread as $price_spread) {
                $price_spread['selected'] = $array_search['price_spread'] == $price_spread['index'] ? 'selected="selected"' : '';
                $xtpl->assign('PRICE_SPREAD', $price_spread);
                $xtpl->parse('main.price_spread');
            }
        }
        
        if ($block_config['styletype'] == 3) {
            $i = 0;
            foreach ($array_type as $type) {
                if (! empty($array_search['typeid'])) {
                    if ($type['id'] == $array_search['typeid']) {
                        $type['active'] = 'active';
                        $type['checked'] = 'checked="checked"';
                    }
                } elseif ($i == 0) {
                    $type['active'] = 'active';
                    $type['checked'] = 'checked="checked"';
                }
                $xtpl->assign('TYPE', $type);
                $xtpl->parse('main.type');
                $i ++;
            }
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $array_cat, $array_config, $module_array_cat, $array_way, $module_module_way;
    
    $module = $block_config['module'];
   
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $array_cat;
            $module_module_way = $array_way;
        } else {
            $module_array_cat = array();
            $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_categories ORDER BY parentid, weight ASC';
            $list = $nv_Cache->db($sql, 'id', $module);
            foreach ($list as $l) {
                $module_array_cat[$l['id']] = $l;
                $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
            }
            
            $sql = "SELECT config_name, config_value FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_config";
            $list = $nv_Cache->db($sql, '', $module);
            foreach ($list as $ls) {
                $array_config[$ls['config_name']] = $ls['config_value'];
            }
            
            $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_way WHERE status=1';
            $module_module_way = $nv_Cache->db($sql, 'id', $module);
        }
        $content = nv_block_search12($block_config);
    }
}