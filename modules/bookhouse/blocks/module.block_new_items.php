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

if (! nv_function_exists('nv_block_new_items')) {

    function nv_block_config_new_items($module, $data_block, $lang_block)
    {
        $html = '<tr>';
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
        return $return;
    }

    function nv_block_new_items($block_config)
    {
        global $module_array_cat, $site_mods, $module_info, $db, $module_config, $global_config, $array_config, $array_cat, $nv_Cache;
        
        $module = $block_config['module'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        $cache_file = NV_LANG_DATA . '__block_new_items_' . NV_CACHE_PREFIX . '.cache';
        if (($cache = $nv_Cache->getItem($module, $cache_file)) != false) {
            $array_block_new_items = unserialize($cache);
        } else {
            $array_block_new_items = array();
            
            $db->sqlreset()
                ->select('id, catid, title, alias, homeimgfile, homeimgalt, homeimgthumb, price, money_unit')
                ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'])
                ->where('status=1 AND status_admin=1 AND is_queue=0 AND (inhome=1 OR exptime = 0) AND exptime > ' . NV_CURRENTTIME)
                ->order('ordertime DESC')
                ->limit($block_config['numrow']);
            
            $result = $db->query($db->sql());
            
            while (list ($id, $catid, $title, $alias, $homeimgfile, $homeimgalt, $homeimgthumb, $price, $money_unit) = $result->fetch(3)) {
                $link = $array_cat[$catid]['link'] . '/' . $alias . '-' . $id . $global_config['rewrite_exturl'];
                
                if ($homeimgthumb == 1) // image thumb
{
                    $imgurl = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $mod_upload . '/' . $homeimgfile;
                } elseif ($homeimgthumb == 2) // image file
{
                    $imgurl = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $homeimgfile;
                } elseif ($homeimgthumb == 3) // image url
{
                    $imgurl = $homeimgfile;
                } elseif (! empty($show_no_image)) // no image
{
                    $imgurl = NV_BASE_SITEURL . $show_no_image;
                } else {
                    $imgurl = '';
                }
                $array_block_new_items[] = array(
                    'id' => $id,
                    'title' => $title,
                    'link' => $link,
                    'imgurl' => $imgurl
                );
            }
            $cache = serialize($array_block_new_items);
            $nv_Cache->setItem($module, $cache_file, $cache);
        }
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/bookhouse/block_new_items.tpl')) {
            $block_theme = $module_info['template'];
        } else {
            $block_theme = 'default';
        }
        $xtpl = new XTemplate('block_new_items.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        
        foreach ($array_block_new_items as $array_new_items) {
            $xtpl->assign('blocknew_items', $array_new_items);
            
            if (! empty($array_new_items['imgurl'])) {
                $xtpl->parse('main.newloop.imgblock');
            }
            
            $xtpl->parse('main.newloop');
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_new_items($block_config);
}