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

if (! nv_function_exists('nv_block_search')) {

    function nv_block_config_search($module, $data_block, $lang_block)
    {
        global $db, $site_mods;
        
        $array_styletype = array(
            0 => $lang_block['styletype_0'],
            1 => $lang_block['styletype_1']
        );
        
        $html = '';
        $html .= '<tr>';
        $html .= '	<td>' . $lang_block['styletype'] . '</td>';
        $html .= '	<td><select class="form-control" name="config_styletype">';
        foreach ($array_styletype as $index => $value) {
            $sl = $index == $data_block['styletype'] ? 'selected="selected"' : '';
            $html .= '<option value="' . $index . '" ' . $sl . '>' . $value . '</option>';
        }
        $html .= '  </select></td>';
        $html .= '</tr>';
        
        return $html;
    }

    function nv_block_config_search_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['styletype'] = $nv_Request->get_int('config_styletype', 'post', 0);
        return $return;
    }

    function nv_block_search($block_config)
    {
        global $db, $db_config, $site_mods, $module_info, $module_name, $module_config, $global_config, $array_config, $lang_module, $array_way, $nv_Request, $op, $module_file;
        
        $listcat = nv_listcats();
        $themetype = 'block_search_vertical.tpl';
        if ($block_config['styletype'] == 1) {
            $themetype = 'block_search_horizontal.tpl';
        }
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/bookhouse/' . $themetype)) {
            $block_theme = $module_info['template'];
        } else {
            $block_theme = 'default';
        }
        
        $array_search = array(
            'q' => $nv_Request->get_title('q', 'get', ''),
            'catid' => $nv_Request->get_int('catid', 'get', 0),
            'price_from' => preg_replace('/[^0-9]/', '', $nv_Request->get_title('price_from', 'get', '')),
            'price_to' => preg_replace('/[^0-9]/', '', $nv_Request->get_title('price_to', 'get', '')),
            'area_from' => preg_replace('/[^0-9]/', '', $nv_Request->get_title('area_from', 'get', '')),
            'area_to' => preg_replace('/[^0-9]/', '', $nv_Request->get_title('area_to', 'get', '')),
            'size_v' => str_replace(',', '.', $nv_Request->get_title('size_v', 'get', '')),
            'size_h' => str_replace(',', '.', $nv_Request->get_title('size_h', 'get', '')),
            'way' => $nv_Request->get_int('way', 'get', 0),
            'provinceid' => $nv_Request->get_int('provinceid', 'get', 0),
            'districtid' => $nv_Request->get_int('districtid', 'get', 0),
            'wardid' => $nv_Request->get_int('wardid', 'get', 0)
        );
        
        $xtpl = new XTemplate($themetype, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('MODULE_NAME', $module_name);
        $xtpl->assign('OP_NAME', 'search');
        $xtpl->assign('SEARCH', $array_search);
        $xtpl->assign('DES_POINT', $array_config['dec_point']);
        $xtpl->assign('THOUSANDS_SEP', $array_config['thousands_sep']);
        
        if (! empty($listcat)) {
            foreach ($listcat as $cat) {
                $xtpl->assign('CAT', array(
                    'key' => $cat['id'],
                    'title' => $cat['name'],
                    'selected' => $cat['id'] == $array_search['catid'] ? 'selected="selected"' : ''
                ));
                $xtpl->parse('main.cat');
            }
        }
        
        if (! empty($array_way)) {
            foreach ($array_way as $way) {
                $way['selected'] = $way['id'] == $array_search['way'] ? 'selected="selected"' : '';
                $xtpl->assign('WAY', $way);
                $xtpl->parse('main.way');
            }
        }
        
        $data_config = array(
            'is_district' => true,
            'select_provinceid' => $array_search['provinceid'],
            'select_districtid' => $array_search['districtid'],
            'blank_title_province' => true,
            'blank_title_district' => true
        );
        $location = new Location();
        $location->set('IsDistrict', 1);
        $location->set('SelectProvinceid', $array_search['provinceid']);
        $location->set('SelectDistrictid', $array_search['districtid']);
        $location->set('BlankTitleProvince', 1);
        $location->set('BlankTitleDistrict', 1);
        $xtpl->assign('LOCATION', $location->buildInput());
        
        if ($array_config['sizetype'] == 0) {
            $xtpl->parse('main.area');
        } elseif ($array_config['sizetype'] == 1) {
            $xtpl->parse('main.size');
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_search($block_config);
}