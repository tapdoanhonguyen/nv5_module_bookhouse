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

if (! nv_function_exists('nv_block_groups_items_new')) {


    function nv_block_groups_items_new($block_config)
    {
        global $module_array_cat, $site_mods, $module_info, $db, $db_config, $module_config, $global_config, $array_config, $nv_Cache, $module_name, $lang_module, $nv_Request, $my_head, $id, $array_groups;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        if($module != $module_name){
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }
        
        $template = 'block_new_items_list.tpl';
        
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/' . $template)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
                
        $cache_file = NV_LANG_DATA . '_block_groups_items_' . $block_config['bid'] . '_' . NV_CACHE_PREFIX . '.cache';
        if (($cache = $nv_Cache->getItem($module, $cache_file)) != false) {
            $array_block_new_items = unserialize($cache);
        } else {
            require_once NV_ROOTDIR . '/modules/location/location.class.php';
            $location = new Location();
            
            $array_block_new_items = array();
			
            $db->sqlreset()
                ->select('t1.id, catid, showprice, title, alias, homeimgfile, homeimgalt, homeimgthumb, edittime, ordertime, price, price_time, contact_phone, money_unit, size_v, size_h, area, provinceid, districtid, wardid')
                ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . ' t1')
                ->where('status=1 AND status_admin=1 AND groupid = 0 AND is_queue=0 AND inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0)')
                ->order('ordertime DESC')
                ->limit(6); 
        
            $result = $db->query($db->sql());
			
			 $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_pricetype ORDER BY weight ASC';
			$array_pricetype = $nv_Cache->db($sql, 'id', $module);
            
            while ($row = $result->fetch()) {
                $link = $module_array_cat[$row['catid']]['link'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
                $imgurl = nv_bookhouse_get_image($row['homeimgfile'], $row['homeimgthumb'], $module, $block_theme);
              
                $array_block_new_items[] = array(
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'link' => $link,
                    'showprice' => $row['showprice'],
                    'area' => $row['area'],
                    'imgurl' => $imgurl,
                    'contact_phone' => $row['contact_phone'],
                    'edittime' => date('d/m/Y',$row['edittime']),
                    'ordertime' => $row['ordertime'],
                    'size_v' => $row['size_v'],
                    'size_h' => $row['size_h'],
                    'location' => $location->locationString($row['provinceid'], $row['districtid'], $row['wardid']),
                    'price' => $row['price']. ' '. $array_pricetype[$row['price_time']]['title']
                );
				
				
            }
            if(!defined('NV_IS_MODADMIN')){
                $cache = serialize($array_block_new_items);
                $nv_Cache->setItem($module, $cache_file, $cache);
            }
        }
        
        if($module != $module_name){
            $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/bookhouse.css">';
        }
        
        $xtpl = new XTemplate($template, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('TEMPLATE', $block_theme);
        
        $xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
		
        $i = 0;
        foreach ($array_block_new_items as $array_new_items) {
           
            
            if ($array_config['sizetype'] == 0) {
                $xtpl->parse('main.newloop.area');
            } elseif ($array_config['sizetype'] == 1) {
                if(!empty($array_new_items['size_v']) and !empty($array_new_items['size_h'])){
                    $xtpl->parse('main.newloop.size.content');
                }
                $xtpl->parse('main.newloop.size');
            }
			
			$moi  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
			
			if($array_new_items['groupid'] == 0 and $array_new_items['ordertime'] >= $moi and $i < 3 )
			{	
				$i++;
				$image_block = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/icon_tin_moi.png';
				$xtpl->assign('image_block', $image_block);
				$xtpl->parse('main.newloop.image');
				$xtpl->parse('main.newloop.image_mobile');
			}
			
			$array_new_items['ordertime'] = date('d/m/Y',$array_new_items['ordertime']);
			$xtpl->assign('blocknew_items', $array_new_items);
			//print_r($array_new_items);die;
			if ($array_new_items['showprice'] and $array_new_items['price'] > 0) {
                $xtpl->parse('main.newloop.price');
            } else {
                $xtpl->parse('main.newloop.contact');
            }
			
            $xtpl->parse('main.newloop');
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $listcat, $array_config, $module_array_cat, $array_groups;

    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $listcat;
        } else {
			
			$array_groups = array();
            $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_block_cat ORDER BY weight ASC';
            $array_groups = $nv_Cache->db($sql, 'bid', $module);
			
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
        }
        $content = nv_block_groups_items_new($block_config);
    }
}