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

if (! nv_function_exists('nv_bookhouse_category')) {

    function nv_block_config_bookhouse_category($module, $data_block, $lang_block)
    {
        global $site_mods;
        
        $html_input = '';
        $html .= '<tr>';
        $html .= '<td>' . $lang_block['title_length'] . '</td>';
        $html .= '<td>';
        $html .= "<select name=\"config_title_length\" class=\"form-control w200\">\n";
        $html .= "<option value=\"\">" . $lang_block['title_length'] . "</option>\n";
        for ($i = 0; $i < 100; ++ $i) {
            $html .= "<option value=\"" . $i . "\" " . (($data_block['title_length'] == $i) ? " selected=\"selected\"" : "") . ">" . $i . "</option>\n";
        }
        $html .= "</select>\n";
        $html .= '</td>';
        $html .= '</tr>';
        return $html;
    }

    function nv_block_config_bookhouse_category_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['catid'] = $nv_Request->get_int('config_catid', 'post', 0);
        $return['config']['title_length'] = $nv_Request->get_int('config_title_length', 'post', 0);
        return $return;
    }

    function nv_bookhouse_category($block_config)
    {
        global $module_info, $lang_module, $global_config, $array_cat;
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/block_category.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $xtpl = new XTemplate('block_category.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse');
        
        if (! empty($array_cat)) {
            $title_length = $block_config['title_length'];
            $xtpl->assign('LANG', $lang_module);
            $xtpl->assign('BLOCK_ID', $block_config['bid']);
            $xtpl->assign('TEMPLATE', $block_theme);
            
            $html = '';
            foreach ($array_cat as $cat) {
                if ($block_config['catid'] == 0 && $cat['parentid'] == 0 || ($block_config['catid'] > 0 && $cat['parentid'] == $block_config['catid'])) {
                    $cat['title0'] = nv_clean60($cat['title'], $title_length);
                    
                    $xtpl->assign('CAT', $cat);
                    
                    if (! empty($cat['subcat'])) {
                        $xtpl->assign('SUBCAT', nv_bookhouse_sub_category($cat['subcat'], $title_length, $block_theme));
                        $xtpl->parse('main.cat.subcat');
                    }
                    $xtpl->parse('main.cat');
                }
            }
            $xtpl->assign('MENUID', $block_config['bid']);
            
            $xtpl->parse('main');
            return $xtpl->text('main');
        }
    }

    function nv_bookhouse_sub_category($list_sub, $title_length, $block_theme)
    {
        global $array_cat;
        
        if (empty($list_sub)) {
            return "";
        } else {
            $xtpl = new XTemplate('block_category.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse');
            
            foreach ($list_sub as $catid) {
                $subcat = $array_cat[$catid];
                $subcat['title0'] = nv_clean60($subcat['title'], $title_length);
                
                $xtpl->assign('SUBCAT', $subcat);
                
                if (! empty($subcat['subcat'])) {
                    $xtpl->assign('SUB', nv_bookhouse_sub_category($subcat['subcat'], $title_length, $block_theme));
                    $xtpl->parse('subcat.loop.sub');
                }
                $xtpl->parse('subcat.loop');
            }
            $xtpl->parse('subcat');
            return $xtpl->text('subcat');
        }
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_bookhouse_category($block_config);
}