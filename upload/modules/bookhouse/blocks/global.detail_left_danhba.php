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

if (! nv_function_exists('nv_detail_danhba')) {

    /**
     * nv_detail_danhba()
     *
     * @return
     */
    function nv_detail_danhba($block_config)
	{
        global $module_array_cat, $site_mods, $module_info, $db, $db_config, $module_config, $global_config, $array_config, $nv_Cache, $module_name, $lang_module, $nv_Request, $my_head, $id, $array_groups, $db_slave, $user_info;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        if($module != $module_name){
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }
        
        $template = 'block_detail_danhba.tpl';
        
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
			$row = $db->query('SELECT groupid, provinceid, districtid, wardid FROM '.NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].' WHERE id='.$id)->fetch();
			
			if($row['districtid'] > 0)
			{	
				// lấy danh sách các nhà môi giới cùng quận ra
				
				$list_moigioi = $db->query('SELECT alias, company, logo, address, email, phone, tinhthanh, quanhuyen FROM nv4_danh_ba_rows t1, '.NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].'_users_groups t2 WHERE t1.userid = t2.userid AND t2.exptime > ' . NV_CURRENTTIME.' AND quanhuyen = '. $row['districtid']  .' ORDER BY groupid DESC limit 0,4 ')->fetchAll();
				
				if(count($list_moigioi < 4))
				{
				//DIE(date('d/m/Y',1713269753));
				//DIE('SELECT alias, company, logo, address, email, phone, tinhthanh, quanhuyen FROM nv4_danh_ba_rows t1, '.NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].'_users_groups t2 WHERE t1.userid = t2.userid AND t2.exptime > ' . NV_CURRENTTIME.' AND tinhthanh ='.$row['provinceid'] .' limit 0,4');
					$list_moigioi = $db->query('SELECT alias, company, logo, address, email, phone, tinhthanh, quanhuyen FROM nv4_danh_ba_rows t1, '.NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'].'_users_groups t2 WHERE t1.userid = t2.userid AND t2.exptime > ' . NV_CURRENTTIME.' AND tinhthanh ='.$row['provinceid'] .'  ORDER BY groupid DESC limit 0,4')->fetchAll();
				
				}
				// ĐỊA CHỈ 
				$thongtinhthanh = $location->getProvinceInfo($row['provinceid']);
				$thongtin_quan = $location->getDistricInfo($row['districtid']);
				
				// LẤY THÔNG TIN QUẬN, HUYỆN RA
				
				//$thongtin_quan = $db->query('SELECT type, title FROM nv4_location_district WHERE districtid = '. $row['districtid'])->fetch();
			
			}
		
	
		
        if(!empty($list_moigioi))
		{
			$xtpl = new XTemplate($template, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
			$xtpl->assign('LANG', $lang_module);
			
			$xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
			$xtpl->assign('thongtin_quan', $thongtin_quan['name']);
			$xtpl->assign('thongtinhthanh', $thongtinhthanh['name']);
			
			
			
			$stt = 1;
			 foreach ($list_moigioi as $item) {
			 
				if(empty($item['logo']))
				{
					$item['logo'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/danh-ba/no-logo.png';
				}
				else{
				$item['logo'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/danh-ba/' . $item['logo'];
				}
				
				$tinhthanh = $location->getProvinceInfo($item['tinhthanh']);
				$quanhuyen = $location->getDistricInfo($item['quanhuyen']);
				
				$xtpl->assign('quanhuyen', $quanhuyen['name']);
				$xtpl->assign('tinhthanh', $tinhthanh['name']);
				
				$item['link'] = NV_BASE_SITEURL . 'danh-ba/nha-moi-gioi/'.$item['alias'];
				$xtpl->assign('item', $item);
				$xtpl->parse('main.newloop');
			
				
			}
			
			$xtpl->assign('xemtatca', NV_BASE_SITEURL . 'danh-ba/nha-moi-gioi/');
			
			$xtpl->parse('main');
			return $xtpl->text('main');
		}
		}

  }
}
$content = nv_detail_danhba($block_config);