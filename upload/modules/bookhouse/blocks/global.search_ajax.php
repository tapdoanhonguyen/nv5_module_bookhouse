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

		
function search_ajax($block_config)
{
    global $db, $module_name, $module_info, $array_way, $array_groups, $global_config, $array_cat, $module_data, $lang_global, $block_config, $lang_module, $catid, $site_mods;
	
		 $template = 'block.search_ajax.tpl';
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/' . $template)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
  
        $xtpl = new XTemplate('block.search_ajax.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
		
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('TEMPLATE', $block_theme);
        
        $xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
		
		if($catid > 0)
		{
			$mang = explode(',',$array_cat[$catid]['subid']);
			 foreach ($mang as $row) {
				
					//print_r($array_cat[$row]);die;
					$xtpl->assign('row', $array_cat[$row]);
					
					$xtpl->parse('main.loop');
			}
		}
		else
		{
			foreach ($array_cat as $row) {
				if($row['lev'] == 0 and $row['id'] != 9)
				{//print_r($row);die;
					$xtpl->assign('row', $row);
					if($row['numsub'] > 0)
					$mang_catid = explode(',',$row['subid']);
					foreach($mang_catid as $con)
					{
						$xtpl->assign('con', $array_cat[$con]);
						$xtpl->parse('main.loop.con');
					}
					$xtpl->parse('main.loop');
				
				}
			}
		
		}
		
		// HƯỚNG BẤT ĐỘNG SẢN
		
		$list_huong = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module_name]['module_data'] . '_way')->fetchAll();
		
		foreach($list_huong as $huong)
		{
			$xtpl->assign('huong', $huong);
            $xtpl->parse('main.huong');
		}
		
		$xtpl->parse('main.language_search_' . NV_LANG_DATA);
		
        
        $xtpl->parse('main');
        return $xtpl->text('main');
	
}

$content = search_ajax($block_config);