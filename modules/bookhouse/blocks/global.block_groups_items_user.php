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

if (! nv_function_exists('nv_block_groups_items_user')) {



    function nv_block_groups_items_user($block_config)
    {
        global $module_array_cat, $site_mods, $module_info, $db, $db_config, $module_config, $global_config, $array_config, $nv_Cache, $module_name, $lang_module, $nv_Request, $my_head, $id, $array_groups, $per_page;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        if($module != $module_name){
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }
        
		$page = 1;
		if( isset( $array_op[0] ) and substr( $array_op[0], 0, 5 ) == 'page-' )
		{
			$page = intval( substr( $array_op[0], 5 ) );
		}

        $template = 'block_new_items_list.tpl';
        
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/' . $template)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
                
        $cache_file = NV_LANG_DATA . '_block_groups_items_' . $block_config['bid'] . '_' . NV_CACHE_PREFIX . '.cache';
        if (($cache = $nv_Cache->getItem($module, $cache_file)) != false) {
            $array_block_user_items = unserialize($cache);
        } else {
            require_once NV_ROOTDIR . '/modules/location/location.class.php';
            $location = new Location();
            
            $array_block_user_items = array();
			
			session_start();
			
           $db->sqlreset()
			->select('COUNT(*) ')
			->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].' t1')
			->where('t1.status=1 AND t1.admin_id ='. $_SESSION["id"] .' AND t1.status_admin=1 AND t1.is_queue=0 AND t1.inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0)');
		
			$num_items = $db->query($db->sql())->fetchColumn();
			
			
			//foreach($list_nhom as )
			$db->select('t1.id, t1.catid, t1.groupid, t1.title, t1.alias, t1.price, t1.price_time, t1.showprice, t1.edittime, t1.ordertime, t1.area, t1.homeimgfile, t1.homeimgthumb, t1.address, t1.provinceid, t1.districtid, t1.wardid, t2.image') 
			->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] .'_block_cat t2 ON t2.bid = t1.groupid')
			->order(' t2.weight DESC,t1.ordertime DESC');
            $result = $db->query($db->sql());
           //die($db->sql());
            while ($row = $result->fetch()) {
                $link = $module_array_cat[$row['catid']]['link'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
                $imgurl = nv_bookhouse_get_image($row['homeimgfile'], $row['homeimgthumb'], $module, $block_theme);
               
                $array_block_user_items[] = array(
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'link' => $link,
                    'showprice' => $row['showprice'],
                    'area' => $row['area'],
                    'imgurl' => $imgurl,
                    'icon_block' => $row['image'],
                    'edittime' => date('d/m/Y',$row['edittime']),
                    'ordertime' => date('d/m/Y',$row['ordertime']),
                    'location' => $location->locationString($row['provinceid'], $row['districtid'], $row['wardid']),
                    'price' => nv_price_format($row['price'], $row['price_time'])
                );
            }
            if(!defined('NV_IS_MODADMIN')){
                $cache = serialize($array_block_user_items);
                $nv_Cache->setItem($module, $cache_file, $cache);
            }
        }
		
		$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=nha-moi-gioi/'. $alias . $global_config['rewrite_exturl'];
		
		$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
		
       
        if($module != $module_name){
            $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/bookhouse.css">';
        }
        
        $xtpl = new XTemplate($template, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse');
		//die(sfd);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('TEMPLATE', $block_theme);
        
        $xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
		
        $i = 0; 
        foreach ($array_block_user_items as $array_user_items) {
            $xtpl->assign('blocknew_items', $array_user_items);
          
          
           	$moi  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
			
			if($array_user_items['groupid'] == 0 and $array_user_items['ordertime'] >= $moi )
			{
			
			$image_block = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module . '/icon_tin_moi.png';
			$xtpl->assign('image_block', $image_block);
			$xtpl->parse('main.newloop.image');
		
			}
          //  print_r($array_user_items);die;  
			if(!empty($array_user_items['icon_block']))
			{
			$array_user_items['icon_block'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module . '/' . $array_user_items['icon_block'];
			$xtpl->assign('image_block', $array_user_items['icon_block']);
			$xtpl->parse('main.newloop.image');
			}
			
			if ($array_user_items['showprice'] and $array_user_items['price'] > 0) {
                $xtpl->parse('main.newloop.price');
            } else {
                $xtpl->parse('main.newloop.contact');
            }
			
            $xtpl->parse('main.newloop');
        }
		
		if (! empty($generate_page)) {
            $xtpl->assign('PAGE', $generate_page);
            $xtpl->parse('main.page');
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
        $content = nv_block_groups_items_user($block_config);
    }
}