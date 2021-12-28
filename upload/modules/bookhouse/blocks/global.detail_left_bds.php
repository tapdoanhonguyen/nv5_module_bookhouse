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

if (! nv_function_exists('nv_detail_bds')) {

    /**
     * nv_detail_bds()
     *
     * @return
     */
    function nv_detail_bds($block_config)
	{
        global $module_array_cat, $site_mods, $module_info, $db, $db_config, $module_config, $global_config, $array_config, $nv_Cache, $module_name, $lang_module, $nv_Request, $my_head, $id, $array_groups, $db_slave;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        if($module != $module_name){
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }
        
        $template = 'block_detail_bds.tpl';
        
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
		
		// lấy id loại bds dựa vào id chi tiết
			if($id > 0)
			{
			$row = $db->query('SELECT catid, provinceid, districtid, wardid FROM '.NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].' WHERE id='.$id)->fetch();
			
			if($row['catid'] > 0)
			{	
				$sl = 0;
				$where = 't1.id != ' . $id . ' AND groupid =3  AND catid = ' . $row['catid'] . '  AND status=1 AND status_admin=1 AND is_queue=0';
				$array_data = array();
				 
				// lấy tin hot cùng loại theo xã wardid
				$db->sqlreset()
							->select('COUNT(*) ')
							->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].' t1')
							->limit(10);
							$db_slave->select('t1.id, t1.catid, t1.groupid, t1.title, t1.alias, t1.price, t1.showprice, t1.edittime, t1.area, t1.homeimgfile, t1.homeimgthumb, t1.address, t1.contact_phone') 
							->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] .'_block t2 ON t2.id = t1.id')
							->where($where . ' AND wardid = '.$row['wardid'] . ' AND ( t2.exptime > '.NV_CURRENTTIME . ' or t2.exptime = 0)')
							->order('t1.ordertime DESC');	
					
						$result = $db_slave->query($db_slave->sql());
						
						
						while ($item = $result->fetch()) {
							$item['edittime'] = date('d/m/Y',$item['edittime']);
							$item['icon_block'] = $array_groups[3]['image'];
							$array_data[] = nv_data_show($item);
							$sl++;
						}
				// lấy tin rao mới nhất cùng loại cùng xã wardid

				// lấy tin hot cùng loại theo quận districtid
				if($sl < 10)
				{
							$db->sqlreset()
							->select('COUNT(*) ')
							->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].' t1')
							->limit(10);
							$db_slave->select('t1.id, t1.catid, t1.groupid, t1.title, t1.alias, t1.price, t1.showprice, t1.edittime, t1.area, t1.homeimgfile, t1.homeimgthumb, t1.address, t1.contact_phone') 
							->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] .'_block t2 ON t2.id = t1.id')
							->where($where . ' AND wardid != '.$row['wardid'] . ' AND districtid = '.$row['districtid'] . ' AND ( t2.exptime > '.NV_CURRENTTIME . ' or t2.exptime = 0)')
							->order('t1.ordertime DESC');		
						$result = $db_slave->query($db_slave->sql());
						//print($db_slave->sql());die; 
						
						while ($item = $result->fetch()) {
							$item['edittime'] = date('d/m/Y',$item['edittime']);
							$item['icon_block'] = $array_groups[3]['image'];
							$array_data[] = nv_data_show($item);
							$sl++;
						}
				}
				// lấy tin rao mới nhất cùng loại cùng quận districtid

				// lấy tin hot cùng loại theo thành phố provinceid
				if($sl < 10)
				{
							$db->sqlreset()
							->select('COUNT(*) ')
							->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].' t1')
							->limit(10);
							$db_slave->select('t1.id, t1.catid, t1.groupid, t1.title, t1.alias, t1.price, t1.showprice, t1.edittime, t1.area, t1.homeimgfile, t1.homeimgthumb, t1.address, t1.contact_phone') 
							->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] .'_block t2 ON t2.id = t1.id')
							->where($where . ' AND wardid != '.$row['wardid'] . ' AND districtid != '.$row['districtid'] . ' AND provinceid = '.$row['provinceid'] .' AND ( t2.exptime > '.NV_CURRENTTIME . ' or t2.exptime = 0)')
							->order('t1.ordertime DESC');		
						$result = $db_slave->query($db_slave->sql());
						//print($db_slave->sql());die; 
						
						while ($item = $result->fetch()) {
							$item['edittime'] = date('d/m/Y',$item['edittime']);
							$item['icon_block'] = $array_groups[3]['image'];
							$array_data[] = nv_data_show($item);
							$sl++;
						}
				}
				// lấy tin rao mới nhất cùng loại cùng thành phố provinceid
			}
			
			}
        if(!empty($array_data))
		{
			$xtpl = new XTemplate($template, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
			$xtpl->assign('LANG', $lang_module);
			
			$xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
			
			$stt = 1;
			 foreach ($array_data as $array_new_items) {
			 
				$xtpl->assign('blocknew_items', $array_new_items);
				
				if ($array_config['sizetype'] == 0) {
					$xtpl->parse('main.newloop.area');
				} elseif ($array_config['sizetype'] == 1) {
					if(!empty($array_new_items['size_v']) and !empty($array_new_items['size_h'])){
						$xtpl->parse('main.newloop.size.content');
					}
					$xtpl->parse('main.newloop.size');
				}
			//	print_r($array_block_new_items);die;
				 if ($array_new_items['showprice'] and $array_new_items['price'] > 0) {
					$xtpl->parse('main.newloop.price');
				} else {
					$xtpl->parse('main.newloop.contact');
				}
				
			   
				if(!empty($array_new_items['icon_block']))
				{
				$array_new_items['icon_block'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $array_new_items['icon_block'];
				$xtpl->assign('image_block', $array_new_items['icon_block']);
				$xtpl->parse('main.newloop.image');
				}
				if($stt == 10)
				 $xtpl->assign('none_boder', 'none_boder');
				else $xtpl->assign('none_boder', '');
				
				if($stt > 10)
				$xtpl->assign('none', 'none');
				else $xtpl->assign('none', '');
				
				
				if($stt <= 10)
				$xtpl->parse('main.newloop');
				
				$stt++; 
				
			}
			
			
			$xtpl->parse('main');
			return $xtpl->text('main');
		}
		}

  }

$content = nv_detail_bds($block_config);