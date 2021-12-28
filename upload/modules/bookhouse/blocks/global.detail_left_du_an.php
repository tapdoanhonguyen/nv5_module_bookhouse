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

if (! nv_function_exists('nv_detail_duan')) {

    /**
     * nv_detail_duan()
     *
     * @return
     */
    function nv_detail_duan($block_config)
	{
        global $module_array_cat, $site_mods, $module_info, $db, $db_config, $module_config, $global_config, $array_config, $nv_Cache, $module_name, $lang_module, $nv_Request, $my_head, $id, $array_groups, $db_slave, $user_info;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        if($module != $module_name){
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }
        
        $template = 'block_detail_duan.tpl';
        
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
			
			// LẤY DANH SÁCH DỰ ÁN HOT VIP RA
				
				$list_duan_hotvip = $db->query("SELECT alias, ten_du_an, anh_dai_dien, chuyen_muc, nhom FROM nv4_du_an_rows WHERE nhom > 0 order by nhom desc limit 0,4 ")->fetchAll();
			
			if($row['districtid'] > 0)
			{	
					
				// lấy danh sách các nhà môi giới cùng quận ra
				
				$list_duan = $db->query('SELECT alias, ten_du_an, anh_dai_dien, chuyen_muc, nhom FROM nv4_du_an_rows WHERE districtid = '. $row['districtid']  .' limit 0,4')->fetchAll();
				if(count($list_duan < 4))
				{
					$list_duan = $db->query('SELECT alias, ten_du_an, anh_dai_dien, chuyen_muc FROM nv4_du_an_rows WHERE districtid = '. $row['districtid'] .' or provinceid ='.$row['provinceid'] .' limit 0,4')->fetchAll();
				
				}
				// ĐỊA CHỈ 
				$thongtinhthanh = $location->getProvinceInfo($row['provinceid']);
				$thongtin_quan = $location->getDistricInfo($row['districtid']);
				
			
			}
		
		
		
        if((!empty($list_duan)) or (!empty($list_duan_hotvip)))
		{
			$xtpl = new XTemplate($template, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
			$xtpl->assign('LANG', $lang_module);
			
			$xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
			$xtpl->assign('thongtin_quan', $thongtin_quan['name']);
			$xtpl->assign('thongtinhthanh', $thongtinhthanh['name']);
			
			
			$stt = 0;
			 foreach ($list_duan_hotvip as $item) {
			 
				if(empty($item['anh_dai_dien']))
				{
					$item['anh_dai_dien'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/du-an/no-logo.png';
				}
				else{
				$item['anh_dai_dien'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/du-an/' . $item['anh_dai_dien'];
				}
				
				$alias_catid = $db->query("SELECT alias FROM nv4_du_an_chuyen_muc WHERE id=".$item['chuyen_muc'])->fetchColumn();
				
				$item['link'] = nv_url_rewrite( NV_BASE_SITEURL ."du-an/".$alias_catid ."/" . $item['alias']. $global_config['rewrite_exturl'], true );
				
				if($item['nhom'] == 2)
				$xtpl->assign( 'mau_duan', 'duan_hot');
				elseif($item['nhom'] == 1)
					$xtpl->assign( 'mau_duan', 'duan_vip');	
				else
					$xtpl->assign( 'mau_duan', '');
				
				$xtpl->assign('ROW', $item);
				$xtpl->parse('main.loop');
			
				$stt++;
			}
			
			 foreach ($list_duan as $item) {
			 
				if($stt < 4)
				{
			 
					if(empty($item['anh_dai_dien']))
					{
						$item['anh_dai_dien'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/du-an/no-logo.png';
					}
					else{
					$item['anh_dai_dien'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/du-an/' . $item['anh_dai_dien'];
					}
					
					$alias_catid = $db->query("SELECT alias FROM nv4_du_an_chuyen_muc WHERE id=".$item['chuyen_muc'])->fetchColumn();
					
					$item['link'] = nv_url_rewrite( NV_BASE_SITEURL ."du-an/".$alias_catid ."/" . $item['alias']. $global_config['rewrite_exturl'], true );
					$xtpl->assign( 'mau', '');
					$xtpl->assign('ROW', $item);
					$xtpl->parse('main.loop');
					
					$stt++;
					
				}
			}
			
			$xtpl->assign('xemtatca', NV_BASE_SITEURL . 'danh-ba/nha-moi-gioi/');
			
			$xtpl->parse('main');
			return $xtpl->text('main');
		}
		}

  }
}
$content = nv_detail_duan($block_config);