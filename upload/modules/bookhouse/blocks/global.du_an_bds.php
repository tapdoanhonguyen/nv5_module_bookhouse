<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/25/2010 18:6
 */

if (! defined('NV_SYSTEM')) {
    die('Stop!!!');
}

session_start();

if (! nv_function_exists('nv_du_an_bds')) {

    /**
     * nv_du_an_bds()
     *
     * @return
     */
    function nv_du_an_bds($block_config)
	{
        global $module_array_cat, $site_mods, $module_info, $db, $db_config, $module_config, $global_config, $array_config, $nv_Cache, $module_name, $lang_module, $nv_Request, $my_head, $id, $array_groups, $db_slave, $page , $per_page, $array_cat ;
        $page = 1;
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
       
       
        if($module != $module_name){
            $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/bookhouse.css">';
        }
		
		 require_once NV_ROOTDIR . '/modules/location/location.class.php';
         $location = new Location();
		
		if($module != $module_name){
		$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_categories ORDER BY parentid, weight ASC';
		
		$array_cat = $nv_Cache->db($sql, 'id', $module_name);
		foreach ($array_cat as $row) 
		{
			$array_cat[$row['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'];
			if ($alias_cat_url == $row['alias']) {
				$catid = $row['id'];
				$parentid = $row['parentid'];
			}
		}

		}
		
function nv_data_show_duan($item)
{
    global $db, $module_name, $module_info, $array_way, $array_groups, $global_config, $array_cat, $module_data, $lang_global, $block_config;
    $location = new Location();
	
	
   
    $item['link'] = $array_cat[$item['catid']]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
	//print_r( $array_cat[$item['catid']]);die;
    $item['addtime'] = nv_date('d/m/Y', $item['addtime']);
  
    $item['way'] = ! empty($item['way_id']) ? $array_way[$item['way_id']]['title'] : '';
    
    if ($item['showprice']) {
        $item['price'] = nv_price_format($item['price']);
    }
    
    $module_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
    $item['location'] = $location->locationString($item['provinceid'], $item['districtid'], $item['wardid'], ' » ', $module_url);
    
    if (! empty($item['groupid'])) {
        $item['groupid'] = explode(',', $item['groupid'])[0];
        $item['color'] = $array_groups[$item['groupid']]['color'];
    }
    
    $item['rooms'] = array();
    $sql = $db->query('SELECT iid, rid, num FROM ' . NV_PREFIXLANG . '_nha_dat_rooms_detail WHERE iid = ' . $item['id']);
    while ($row = $sql->fetch()) {
        $item['rooms'][$row['rid']] = $row;
    }
    
    $item['poster'] = $lang_global['guests'];
    if ($item['admin_id'] > 0) {
        $_result = $db->query('SELECT username, first_name, last_name FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $item['admin_id']);
        if ($_result->rowCount()) {
            list ($username, $first_name, $last_name) = $_result->fetch(3);
            $item['poster'] = nv_show_name_user($first_name, $last_name, $username);
        }
    }
    
    return $item;
}

		$projectid = $_SESSION['id_duan'];
			if($projectid > 0)
			{
				$array_data = array();
				 $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
	
					$db->sqlreset()
					->select('COUNT(*) ')
					->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].' t1')
					->where(' projectid = '.$projectid.' AND t1.status=1 AND t1.status_admin=1 AND t1.is_queue=0 AND t1.inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0)');
				
				
				$db_slave->select('t1.id, t1.catid, t1.groupid, t1.title, t1.alias, t1.price, t1.showprice, t1.edittime, t1.ordertime, t1.area, t1.homeimgfile, t1.homeimgthumb, t1.address, t1.provinceid, t1.districtid, t1.wardid, t2.image') 
					->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] .'_block_cat t2 ON t2.bid = t1.groupid')
					->order(' t2.weight DESC,t1.ordertime DESC') ;
				//print($page);die;
				$result = $db_slave->query($db_slave->sql());
				
				 while ($row = $result->fetch()) {
                $link = $module_array_cat[$row['catid']]['link'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
              
                $array_data[] = array(
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'link' => $link,
                    'showprice' => $row['showprice'],
                    'area' => $row['area'],
                    'homeimgthumb' => $row['homeimgthumb'],
                    'homeimgfile' => $row['homeimgfile'],
                    'contact_phone' => $row['contact_phone'],
                    'edittime' => date('d/m/Y',$row['edittime']),
                    'ordertime' => $row['ordertime'],
                    'size_v' => $row['size_v'],
                    'size_h' => $row['size_h'],
                    'location' => $location->locationString($row['provinceid'], $row['districtid'], $row['wardid']),
                    'price' => nv_price_format($row['price'], $row['price_time'])
                );
            }
				
			}
    if(!empty($array_data))
	{
        $xtpl = new XTemplate($template, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('TEMPLATE', $block_theme);
        
        $xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
        
		 foreach ($array_data as $array_new_items) {
		
			 if (! empty($array_new_items['homeimgfile'])) {
				if ($array_new_items['homeimgthumb'] == 1) // image thumb
				{
					$img_path = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $array_new_items['homeimgfile'];
				} elseif ($array_new_items['homeimgthumb'] == 2) // image file
				{
					$img_path = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $array_new_items['homeimgfile'];
				} elseif ($array_new_items['homeimgthumb'] == 3) // image url
				{
					$img_path = $image;
				} else {
					$img_path = NV_BASE_SITEURL . 'themes/' . $block_theme . '/images/' . $site_mods[$module]['module_file'] . '/no-image.jpg';
				}
			} else {
				$img_path = NV_BASE_SITEURL . 'themes/' . $block_theme . '/images/' . $site_mods[$module]['module_file'] . '/no-image.jpg';
				//$img_path = NV_BASE_SITEURL . $logo;
			}
			//die($img_path);
			$array_new_items['imgurl'] = $img_path;
			
           
            $array_new_items['ordertime'] = nv_date('d/m/Y', $array_new_items['ordertime']);
			$xtpl->assign('blocknew_items', $array_new_items);
            if ($array_config['sizetype'] == 0) {
                $xtpl->parse('main.newloop.area');
            } elseif ($array_config['sizetype'] == 1) {
                if(!empty($array_new_items['size_v']) and !empty($array_new_items['size_h'])){
                    $xtpl->parse('main.newloop.size.content');
                }
                $xtpl->parse('main.newloop.size');
            }
			
			
			if($array_new_items['groupid'] == 0 and $array_new_items['ordertime'] >= $moi )
			{
			$image_block = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/icon_tin_moi.png';
			$xtpl->assign('image_block', $image_block);
			$xtpl->parse('main.loop.image');
			$xtpl->parse('main.loop.image_mobile');
			$tam++;
			}
            
            if(!empty($array_new_items['groupid'] > 0))
			{
			$image_block = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $array_new_items['icon_block'];
			$xtpl->assign('image_block', $image_block);
			$xtpl->parse('main.newloop.image');
			$xtpl->parse('main.newloop.image_mobile');
			}
			//print_r($array_new_items);die;
			if ($array_new_items['showprice'] and $array_new_items['price'] > 0) {
                $xtpl->parse('main.newloop.price'); //print_r($array_new_items);die;
            } else {
                $xtpl->parse('main.newloop.contact');
            }
			
            $xtpl->parse('main.newloop');
        }
		
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
	
	}

  }

$content = nv_du_an_bds($block_config);