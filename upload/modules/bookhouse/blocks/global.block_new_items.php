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


if (! nv_function_exists('nv_block_global_new_items')) {

    function nv_block_config_new_items($module, $data_block, $lang_block)
    {
        $array_temnplate = array(
            'vertical' => $lang_block['vertical'],
            'list' => $lang_block['list']
        );
        
        $html = '<tr>';
        $html .= '	<td>' . $lang_block['template'] . '</td>';
        $html .= '	<td><select name="config_template" class="form-control w200">';
        foreach ($array_temnplate as $index => $value) {
            $sl = (isset($data_block['template']) and $data_block['template'] == $index) ? 'selected="selected"' : '';
            $html .= '<option value="' . $index . '" ' . $sl . ' >' . $value . '</option>';
        }
        $html .= '  </select></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '	<td>' . $lang_block['numrow'] . '</td>';
        $html .= '	<td><input type="text" name="config_numrow" class="form-control w100" size="5" value="' . $data_block['numrow'] . '"/></td>';
        $html .= '</tr>';
        
        return $html;
    }

    function nv_block_config_new_items_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['template'] = $nv_Request->get_title('config_template', 'post', 'vertical');
        return $return;
    }

    function nv_block_global_new_items($block_config)
    {
        global $module_array_cat, $site_mods, $module_info, $db, $db_config, $module_config, $global_config, $array_config, $nv_Cache, $module_name, $lang_module, $my_head, $nv_Request, $module_array_groups;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        if($module != $module_name){
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }
        
        $template = 'block_new_items_vertical.tpl';
        if ($block_config['template'] == 'list') {
            $template = 'block_new_items_list.tpl';
        }
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/' . $template)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $cache_file = NV_LANG_DATA . '_block_new_items_' . $block_config['bid'] . '-' . NV_CACHE_PREFIX . '.cache';
        if (($cache = $nv_Cache->getItem($module, $cache_file)) != false) {
            $array_block_new_items = unserialize($cache);
        } else {
            require_once NV_ROOTDIR . '/modules/location/location.class.php';
            $location = new Location();
            $module_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module;
            
            $array_block_new_items = array();
            
            $db->sqlreset()
                ->select('id, catid, title, alias, homeimgfile, homeimgalt, homeimgthumb, price, price_time, money_unit, size_v, size_h, provinceid, districtid, wardid, group_config')
                ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'])
                ->where('status=1 AND status_admin=1 AND is_queue=0 AND (inhome=1 OR exptime = 0) AND exptime > ' . NV_CURRENTTIME)
                ->order('ordertime DESC')
                ->limit($block_config['numrow']);
            
            $result = $db->query($db->sql());
            
            while ($row = $result->fetch()) {
                $link = $module_array_cat[$row['catid']]['link'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
                $imgurl = nv_bookhouse_get_image($row['homeimgfile'], $row['homeimgthumb'], $module, $block_theme);
                
                if (! empty($row['group_config'])) {
                    $group_config = unserialize($row['group_config']);
                    foreach ($group_config as $groupid => $exptime) {
                        if ($exptime == 0 or $exptime > NV_CURRENTTIME) {
                            $row['color'] = $module_array_groups[$groupid]['color'];
                            break;
                        }
                    }
                }
                
                $array_block_new_items[] = array(
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'link' => $link,
                    'imgurl' => $imgurl,
                    'size_v' => $row['size_v'],
                    'size_h' => $row['size_h'],
                    'location' => $location->locationString($row['provinceid'], $row['districtid'], $row['wardid'], ' » ', $module_url),
                    'price' => nv_price_format($row['price'], $row['price_time']),
                    'color' => $row['color']
                );
            }
            
            if (! defined('NV_IS_MODADMIN')) {
                $cache = serialize($array_block_new_items);
                $nv_Cache->setItem($module, $cache_file, $cache);
            }
        }
        
        if($module != $module_name){
            $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/bookhouse.css">';
        }
        
        $xtpl = new XTemplate($template, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
        $xtpl->assign('THUMB_HEIGHT', $array_config['thumb_height']);
            
        foreach ($array_block_new_items as $array_new_items) {
            
            $xtpl->assign('blocknew_items', $array_new_items);
            
            if ($array_config['sizetype'] == 0) {
                $xtpl->parse('main.newloop.area');
            } elseif ($array_config['sizetype'] == 1) {
                if(!empty($array_new_items['size_v']) and !empty($array_new_items['size_h'])){
                    $xtpl->parse('main.newloop.size.content');
                }
                $xtpl->parse('main.newloop.size');
            }
            
            $xtpl->parse('main.newloop');
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $array_cat, $module_array_cat, $array_config, $module_array_groups, $array_groups;
    
    $module = $block_config['module'];
    
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $array_cat;
            $module_array_groups = $array_groups;
        } else {
            $module_array_cat = array();
            
            $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_categories ORDER BY parentid, weight ASC';
            $list = $nv_Cache->db($sql, 'id', $module);
            foreach ($list as $l) {
                $module_array_cat[$l['id']] = $l;
                $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
            }
            
            $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_block_cat ORDER BY weight ASC';
            $module_array_groups = $nv_Cache->db($sql, 'bid', $module);
            
            $sql = "SELECT config_name, config_value FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_config";
            $list = $nv_Cache->db($sql, '', $module);
            foreach ($list as $ls) {
                $array_config[$ls['config_name']] = $ls['config_value'];
            }
        }
        $content = nv_block_global_new_items($block_config);
    }
}