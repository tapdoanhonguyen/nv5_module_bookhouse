<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (! defined('NV_IS_MOD_BOOKHOUSE'))
    die('Stop!!!');

/**
 *
 * nv_theme_viewhome()
 *
 * @param mixed $array_data            
 * @param mixed $generate_page            
 * @param mixed $viewtype            
 * @return
 *
 */
function nv_theme_viewhome( $page_title,$array_data, $generate_page = '', $viewtype = 'viewlist')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config, $array_cat;
    
    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    
    if ($array_config['display_data'] == 0) {
        // Hiển thị tất cả
		
        $xtpl->assign('DATA', call_user_func('nv_theme_viewlist', $page_title, $array_data));
        
        if (! empty($generate_page)) {
            $xtpl->assign('PAGE', $generate_page);
            $xtpl->parse('main.viewall.page');
        }
        $xtpl->parse('main.viewall');
    } elseif ($array_config['display_data'] == 1) {
        // Hiển thị theo chủ đề
        if (! empty($array_data)) {
            foreach ($array_data as $catid => $catdata) {
                if (! empty($catdata['data'])) {
                    $xtpl->assign('CAT', $array_cat[$catid]);
                    $xtpl->assign('DATA', call_user_func('nv_theme_' . $viewtype, $page_title, $catdata['data']));
                    $xtpl->parse('main.viewcat.loop');
                }
            }
        }
        $xtpl->parse('main.viewcat');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 *
 * nv_theme_viewcat()
 *
 * @param mixed $array_data            
 * @return
 *
 */
 
 function nv_theme_viewhome_orther( $page_title,$array_data, $generate_page = '', $viewtype = 'viewlist')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config, $array_cat;
    
    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('TEMPLATE', $module_info['template']);
    
    if ($array_config['display_data'] == 0) {
        // Hiển thị tất cả
		
        $xtpl->assign('DATA', call_user_func('nv_theme_viewlist_orther', $page_title, $array_data));
        
        if (! empty($generate_page)) {
            $xtpl->assign('PAGE', $generate_page);
            $xtpl->parse('main.viewall.page');
        }
        $xtpl->parse('main.viewall');
    } elseif ($array_config['display_data'] == 1) {
        // Hiển thị theo chủ đề
        if (! empty($array_data)) {
            foreach ($array_data as $catid => $catdata) {
                if (! empty($catdata['data'])) {
                    $xtpl->assign('CAT', $array_cat[$catid]);
                    $xtpl->assign('DATA', call_user_func('nv_theme_' . $viewtype, $page_title, $catdata['data']));
                    $xtpl->parse('main.viewcat.loop');
                }
            }
        }
        $xtpl->parse('main.viewcat');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 *
 * nv_theme_viewcat()
 *
 * @param mixed $array_data            
 * @return
 *
 */
 
function nv_theme_viewcat($page_title,$array_data, $generate_page = '', $viewtype = 'viewlist')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config, $catid, $array_cat;
    
    $xtpl = new XTemplate('viewcat.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('CAT', $array_cat[$catid]);
    
    if (! empty($array_data)) {
        $xtpl->assign('DATA', call_user_func('nv_theme_' . $viewtype,$page_title, $array_data));
        
        if (! empty($generate_page)) {
            $xtpl->assign('PAGE', $generate_page);
            $xtpl->parse('main.page');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 *
 * nv_theme_viewlocation()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_viewlocation($page_title,$array_data, $location_info, $generate_page = '', $viewtype = 'viewlist')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config, $catid, $array_cat;
    
    $xtpl = new XTemplate('viewlocation.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('LOCATION', $location_info);
   
    if (! empty($array_data)) {
        $xtpl->assign('DATA', call_user_func('nv_theme_' . $viewtype, $page_title, $array_data));
        
        if (! empty($generate_page)) {
            $xtpl->assign('PAGE', $generate_page);
            $xtpl->parse('main.page');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}


/**
 *
 * nv_theme_viewlist()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_viewlist($page_title,$array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config, $page, $per_page, $op;
    
    $xtpl = new XTemplate('viewlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
    $xtpl->assign('TEMPLATE',$module_info['template']);
    $xtpl->assign('TITLE', $page_title);
    $xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
   
    if (! empty($array_data)) {
		
       if($op == 'main')
		$per_page = 19;
	  
		$count = count($array_data);
		$batdau = (($page - 1) * $per_page);
		$dung = $batdau + $per_page;
		if($dung > $count )
			$dung = $count;
			
		$tam = 0;
		foreach($array_data as $row)
		{
            $row['size'] = '';
            if ($array_config['sizetype'] == 0) {
                $row['size'] = $row['area'];
            } elseif ($array_config['sizetype'] == 1) {
                if (! empty($row['size_v']) and ! empty($row['size_h'])) {
                    $row['size'] = $row['size_h'] . 'x' . $row['size_v'];
                }
            }
			
			// gắn icon tin mới
			$moi  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
			
			if($row['groupid'] == 0 and $row['ordertime'] >= $moi )
			{
			$image_block = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/icon_tin_moi.png';
			$xtpl->assign('image_block', $image_block);
			$xtpl->parse('main.loop.image');
			$xtpl->parse('main.loop.image_mobile');
			$tam++;
			}
			//print_r($row['ordertime']);die;
            $row['ordertime'] = nv_date('d/m/Y- h:i', $row['ordertime']);
            $xtpl->assign('DATA', $row);
			
			if(!empty($row['icon_block']))
			{
			$row['icon_block'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['icon_block'];
			$xtpl->assign('image_block', $row['icon_block']);
			$xtpl->parse('main.loop.image');
			$xtpl->parse('main.loop.image_mobile');
			}
			
			
            
            if (! empty($row['size'])) {
                if ($array_config['sizetype'] == 0) {
                    $xtpl->parse('main.loop.size_0');
                } elseif ($array_config['sizetype'] == 1) {
                    $xtpl->parse('main.loop.size_1');
                }
            }
            
            if ($array_config['view_on_main']) {
                $xtpl->parse('main.loop.view_on_main_content');
                $xtpl->parse('main.loop.view_on_main_link');
            } else {
                $xtpl->parse('main.loop.link');
            }
            
            if ($row['showprice'] and $row['price'] > 0 ) {
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
            
            $xtpl->parse('main.loop');
        }
    }
    
    if ($array_config['sizetype'] == 0) {
        $xtpl->parse('main.area');
    } elseif ($array_config['sizetype'] == 1) {
        $xtpl->parse('main.size');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}


/**
 *
 * nv_theme_viewlist()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_search_viewlist($page_title,$array_data_vip,$array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config, $page, $per_page;
   
    $xtpl = new XTemplate('viewlist_search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('TEMPLATE', $module_info['template']); 
    $xtpl->assign('TITLE', $page_title);
    $xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
	
	if($page == 1)
	{
		$xtpl->parse('main.qc1');
		$xtpl->parse('main.qc2');		
	}
	// bđs vip
	
	 if (! empty($array_data_vip)) {
        foreach ($array_data_vip as $items) {
            $items['size'] = '';
            if ($array_config['sizetype'] == 0) {
                $items['size'] = $items['area'];
            } elseif ($array_config['sizetype'] == 1) {
                if (! empty($items['size_v']) and ! empty($items['size_h'])) {
                    $items['size'] = $items['size_h'] . 'x' . $items['size_v'];
                }
            }
            
            $xtpl->assign('DATA', $items);
			
			if(!empty($items['icon_block']))
			{
			$items['icon_block'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $items['icon_block'];
			$xtpl->assign('image_block', $items['icon_block']);
			$xtpl->parse('main.loop_vip.image');
			}
            
            if (! empty($items['size'])) {
                if ($array_config['sizetype'] == 0) {
                    $xtpl->parse('main.loop_vip.size_0');
                } elseif ($array_config['sizetype'] == 1) {
                    $xtpl->parse('main.loop_vip.size_1');
                }
            }
            
            if ($array_config['view_on_main']) {
                $xtpl->parse('main.loop_vip.view_on_main_content');
                $xtpl->parse('main.loop_vip.view_on_main_link');
            } else {
                $xtpl->parse('main.loop_vip.link');
            }
            
            if ($items['showprice'] and $items['price'] > 0) {
                $xtpl->parse('main.loop_vip.price');
            } else {
                $xtpl->parse('main.loop_vip.contact');
            }
            
            $xtpl->parse('main.loop_vip');
        }
    }
	// kết thúc bđs vip

	// xuất danh sách tin rao
	 if (! empty($array_data)) {
		
		$tam = 0;
		foreach($array_data as $row)
		{
            $row['size'] = '';
            if ($array_config['sizetype'] == 0) {
                $row['size'] = $row['area'];
            } elseif ($array_config['sizetype'] == 1) {
                if (! empty($row['size_v']) and ! empty($row['size_h'])) {
                    $row['size'] = $row['size_h'] . 'x' . $row['size_v'];
                }
            }
			
			$moi  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
			
			if($row['groupid'] == 0 and $row['ordertime'] >= $moi )
			{
			
			$image_block = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/icon_tin_moi.png';
			$xtpl->assign('image_block', $image_block);
			$xtpl->parse('main.loop.image');
			$xtpl->parse('main.loop.image_mobile');
		
			}
            $row['ordertime'] = date('d/m/Y',$row['ordertime']);
            $xtpl->assign('DATA', $row);
			
			if(!empty($row['icon_block']))
			{
			$row['icon_block'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['icon_block'];
			$xtpl->assign('image_block', $row['icon_block']);
			$xtpl->parse('main.loop.image');
			$xtpl->parse('main.loop.image_mobile');
			}
		
			
            
            if (! empty($row['size'])) {
                if ($array_config['sizetype'] == 0) {
                    $xtpl->parse('main.loop.size_0');
                } elseif ($array_config['sizetype'] == 1) {
                    $xtpl->parse('main.loop.size_1');
                }
            }
            
            if ($array_config['view_on_main']) {
                $xtpl->parse('main.loop.view_on_main_content');
                $xtpl->parse('main.loop.view_on_main_link');
            } else {
                $xtpl->parse('main.loop.link');
            }
            
            if ($row['showprice'] and $row['price'] > 0) {
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
            
            $xtpl->parse('main.loop');
        }
    }
	// kết thúc danh sách tin rao
   
    
    if ($array_config['sizetype'] == 0) {
        $xtpl->parse('main.area');
    } elseif ($array_config['sizetype'] == 1) {
        $xtpl->parse('main.size');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 *
 * nv_theme_viewlist_simple()
 *
 * @param mixed $array_data            
 * @return
 *
 */

function nv_theme_viewlist_orther($page_title,$array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config;
    
    $xtpl = new XTemplate('viewlist_orther.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('TITLE', $page_title);
	$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('TEMPLATE', $module_info['template']);
    $xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
    
    if (! empty($array_data)) {
		$stt = 1;
		$tam = 1;
        foreach ($array_data as $items) {
            $items['size'] = '';
            if ($array_config['sizetype'] == 0) {
                $items['size'] = $items['area'];
            } elseif ($array_config['sizetype'] == 1) {
                if (! empty($items['size_v']) and ! empty($items['size_h'])) {
                    $items['size'] = $items['size_h'] . 'x' . $items['size_v'];
                }
            }
           
			
			if(!empty($items['icon_block']))
			{
			$items['icon_block'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $items['icon_block'];
			$xtpl->assign('image_block', $items['icon_block']);
			$xtpl->parse('main.loop.image');
			$xtpl->parse('main.loop.image_mobile');
			}
			// gắn icon tin mới
			
			$moi  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
			
			if($items['groupid'] == 0 and $items['ordertime'] >= $moi )
			{
			
			$image_block = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/icon_tin_moi.png';
			$xtpl->assign('image_block', $image_block);
			$xtpl->parse('main.loop.image');
			$xtpl->parse('main.loop.image_mobile');
		
			}
            
            if (! empty($items['size'])) {
                if ($array_config['sizetype'] == 0) {
                    $xtpl->parse('main.loop.size_0');
                } elseif ($array_config['sizetype'] == 1) {
                    $xtpl->parse('main.loop.size_1');
                }
            }
            
            if ($array_config['view_on_main']) {
                $xtpl->parse('main.loop.view_on_main_content');
                $xtpl->parse('main.loop.view_on_main_link');
            } else {
                $xtpl->parse('main.loop.link');
            }
            
            if ($items['showprice'] and $items['price'] > 0) {
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
			
			$items['ordertime'] = nv_date('d/m/Y', $items['ordertime']);
            $xtpl->assign('DATA', $items);
			
            $xtpl->parse('main.loop');
		
        }
    }
    
    if ($array_config['sizetype'] == 0) {
        $xtpl->parse('main.area');
    } elseif ($array_config['sizetype'] == 1) {
        $xtpl->parse('main.size');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 *
 * nv_theme_viewlist_simple()
 *
 * @param mixed $array_data            
 * @return
 *
 */
 
function nv_theme_viewlist_simple($array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config;
   
    $xtpl = new XTemplate('viewlist_simple.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    
    if (! empty($array_data)) {
        foreach ($array_data as $items) {
            if ($items['showprice']) {
                $items['price'] = nv_price_format($items['price']);
            }
            
            $xtpl->assign('DATA', $items);
            
            if ($array_config['sizetype'] == 0) {
                $xtpl->parse('main.loop.area');
            } elseif ($array_config['sizetype'] == 1) {
                if (! empty($items['size_v']) and ! empty($items['size_h'])) {
                    $xtpl->parse('main.loop.size.content');
                }
                $xtpl->parse('main.loop.size');
            }
            
            if ($array_config['view_on_main']) {
                $xtpl->parse('main.loop.view_on_main_content');
                $xtpl->parse('main.loop.view_on_main_link');
            } else {
                $xtpl->parse('main.loop.link');
            }
            
            if ($items['showprice']) {
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
            
            $xtpl->parse('main.loop');
        }
    }
    
    if ($array_config['sizetype'] == 0) {
        $xtpl->parse('main.area');
    } elseif ($array_config['sizetype'] == 1) {
        $xtpl->parse('main.size');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 *
 * nv_theme_viewgrid()
 *
 * @param mixed $array_data            
 * @param mixed $generate_page            
 * @return
 *
 */
function nv_theme_viewgrid($page_title,$array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config;
    
    $xtpl = new XTemplate('viewgrid.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('TITLE', $page_title);
    $xtpl->assign('thumb_width', $array_config['thumb_width']);
    $xtpl->assign('thumb_height', $array_config['thumb_height']);
    $xtpl->assign('CONTACT_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=contact');
    
    if (! empty($array_data)) {
        foreach ($array_data as $items) {
            $items['title1'] = nv_clean60($items['title'], 40);
            if ($items['showprice']) {
                $items['price'] = nv_price_format($items['price'], $items['price_time']);
            }
            $xtpl->assign('DATA', $items);
            
            if ($items['showprice']) {
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
            
            $xtpl->parse('main.loop');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_bookhouse_detail()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_bookhouse_detail($base_url, $tt_nhom, $array_data, $array_keyword, $data_others, $checkss, $content_comment, $generate_page)
{
    global $global_config, $module_name, $module_file, $module_upload, $lang_module, $lang_global, $module_config, $module_info, $array_cat, $listroom, $client_info, $my_footer, $array_config, $array_way, $array_legal, $array_money_unit, $location_array_config, $page, $all;
   
    $array_data['cat_title'] = $array_cat[$array_data['catid']]['title'];
    $array_data['cat_link'] = $array_cat[$array_data['catid']]['link'];
    if (! empty($array_data['way_id'])) {
        $array_data['way'] = $array_way[$array_data['way_id']]['title'];
    }
    if (! empty($array_data['legal_id'])) {
        $array_data['legal'] = $array_legal[$array_data['legal_id']]['title'];
    }
    
   // $array_data['price'] = nv_price_format($array_data['price'], $array_data['price_time']);
    $array_data['money_unit'] = $array_money_unit[$array_data['money_unit']];
    
    // google maps
    $is_maps = 0;
    if (! empty($array_data['maps']) and $array_config['allow_maps'] and ! empty($array_config['maps_appid'])) {
        $is_maps = 1;
        $array_data['maps'] = unserialize($array_data['maps']);
    }
    
   
    if($all == 0)
	{
		$xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
	}
	else
	{
		$xtpl = new XTemplate('detail_lienquan.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
	}
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('MODULE_FILE', $module_file);
    $xtpl->assign('CONTACT_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=contact');
    $xtpl->assign('SELFURL', $client_info['selfurl']);
    $xtpl->assign('CHECKSS', $checkss);
    $xtpl->assign('base_url', $base_url. '/all');
    $xtpl->assign('CAPTCHA_REFRESH', $lang_global['captcharefresh']);
    $xtpl->assign('CAPTCHA_REFR_SRC', NV_BASE_SITEURL . 'images/refresh.png');
    $xtpl->assign('SELFURL', $client_info['selfurl']);
	if($array_data['showprice'] == 0 or $array_data['price'] == 0 )
	{
		$array_data['price'] = $lang_module['contact'];
		$array_data['price_time'] = '';
	}
	
	//$array_data['bodytext'] = htmlspecialchars(nv_editor_br2nl($array_data['bodytext']));
	//print_r($array_data['bodytext']);die;
    $xtpl->assign('DATA', $array_data);
	
	if(!empty($array_data['ten_duan']))
	{
		$xtpl->parse('main.duan');
	}
	//print_r($tt_nhom);die;
	
	if(!empty($tt_nhom))
	{
		$xtpl->assign('image_block', $tt_nhom['image']);
		$xtpl->parse('main.icon');
		$xtpl->assign('color', $tt_nhom['color']);
	}
	else{
		// gắn icon tin mới
			$moi  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
			
			if($array_data['groupid'] == 0 and $array_data['ordertime'] >= $moi )
			{
				$image_block = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/icon_tin_moi.png';
				$xtpl->assign('image_block', $image_block);
				$xtpl->parse('main.icon');
			}
	}
    
    if (! empty($array_data['project'])) {
        $xtpl->parse('main.project');
    }
    
    if (! empty($array_data['way_id'])) {
        $xtpl->parse('main.way');
    }
    
    if (! empty($array_data['legal_id'])) {
        $xtpl->parse('main.legal');
    }
    
    if (! empty($array_data['front'])) {
        $xtpl->parse('main.front');
    }
    
    if (! empty($array_data['road'])) {
        $xtpl->parse('main.road');
    }
    
	 $image = array();
    if (! empty($array_data['homeimgfile'])) {
        $image[] = $array_data['homeimgfile'];
    }
    
    if (! empty($array_data['other_image'])) {
        foreach ($array_data['other_image'] as $otherimage_i) {
            if (! empty($otherimage_i['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $otherimage_i['homeimgfile'])) {
                $otherimage_i['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $otherimage_i['homeimgfile'];
                $image[] = $otherimage_i['homeimgfile'];
            }
        }
    }
	
    if (! empty($image)) { //print_r($image);die;
        foreach ($image as $image_i) {
            $xtpl->assign('IMAGE', $image_i);
            $xtpl->parse('main.image.loop');
        }
      
        $xtpl->parse('main.image');
    }
    
    if ($array_data['showprice'] and $array_data['price'] > 0) {
        $xtpl->parse('main.price');
    } else {
        $xtpl->parse('main.contact');
    }
    
    if ($array_config['sizetype'] == 0 and ! empty($array_data['area'])) {
        $xtpl->parse('main.area');
    } elseif ($array_config['sizetype'] == 1 and ! empty($array_data['size_v']) and ! empty($array_data['size_h'])) {
        $xtpl->parse('main.size');
    }
    
    if (! empty($array_data['code'])) {
        $xtpl->parse('main.code');
    }
    
    if (! empty($array_data['structure'])) {
        $xtpl->parse('main.structure');
    }
    
    if (! empty($array_data['type'])) {
        $xtpl->parse('main.type');
    }
    
    // Comment
    if (! empty($content_comment)) {
        $xtpl->assign('COMMENT', $content_comment);
        $xtpl->parse('main.comment');
    }
    
    if (! empty($array_keyword)) {
        foreach ($array_keyword as $i => $value) {
            $xtpl->assign('KEYWORD', $value['keyword']);
            $xtpl->assign('LINK_KEYWORDS', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=tag/' . urlencode($value['alias']));
            $xtpl->parse('main.keywords.loop');
        }
        $xtpl->parse('main.keywords');
    }
    
    if (defined('NV_IS_MODADMIN')) {
        $xtpl->assign('EDIT_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=items&amp;edit&amp;id=' . $array_data['id']);
        $xtpl->parse('main.adminlink');
    }
    
    if ($is_maps) {
        $array_data['maps']['maps_appid'] = $array_config['maps_appid'];
        $xtpl->assign('MAPS', $array_data['maps']);
        $xtpl->parse('main.google_maps_title');
        $xtpl->parse('main.google_maps_div');
    }
    
    if (! empty($data_others)) {
        $hmtl = nv_theme_viewhome_orther($lang_module['bds_lien_quan'],$data_others);
        $xtpl->assign('OTHER', $hmtl);
		if (! empty($generate_page) and $page > 0) {
            $xtpl->assign('PAGE', $generate_page);
            $xtpl->parse('main.other.page');
        }
        $xtpl->parse('main.other');
    }
	
	if (! empty($array_data['so_tang']))
	{
		$xtpl->parse('main.so_tang');
	}
	
	if (! empty($array_data['so_phong']))
	{
		$xtpl->parse('main.so_phong');
	}
	
	if (! empty($array_data['hometext']))
	{
		$xtpl->parse('main.hometext');
	}
    
    if (! empty($array_data['location'])) {
        if(!empty($array_data['address'])){
            $address = $array_data['address'] . ', ' . $array_data['location'];
        }else{
            $address = $array_data['location'];
        }
        $xtpl->assign('ADDRESS', $address);
        $xtpl->parse('main.address');
    }
    
    if ($array_config['allow_contact_info']) {
        $xtpl->parse('main.contact_info');
    }
    
    if ($array_config['itemsave']) {
        $xtpl->parse('main.save');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_viewcat_column()
 *
 * @param mixed $array_data            
 * @param mixed $view            
 * @return
 *
 */
function nv_theme_viewcat_column($array_data, $view, $generate_page)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $array_config;
    
    $xtpl = new XTemplate('viewcat_column.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('thumb_width', $array_config['thumb_width']);
    $xtpl->assign('thumb_height', $array_config['thumb_height']);
    
    if (! empty($array_data)) {
        foreach ($array_data as $items) {
            $items['title1'] = nv_clean60($items['title'], 40);
            if ($items['showprice']) {
                $items['price'] = nv_price_format($items['price'], $items['price_time']);
            }
            
            $xtpl->assign('DATA', $items);
            
            if ($items['showprice']) {
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
            
            $xtpl->parse('main.loop');
        }
    }
    
    if (! empty($generate_page)) {
        $xtpl->assign('PAGE', $generate_page);
        $xtpl->parse('main.page');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_bookhouse_search()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_bookhouse_search($array_search, $link_sapxep, $sap_xep, $diadiem, $array_data_vip,$array_data, $is_search, $generate_page, $viewtype = 'viewlist')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_config, $array_cat, $page_title;
    
    $xtpl = new XTemplate('search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
   
    $xtpl->assign('macdinh', $link_sapxep.'/sapxep-0');
    $xtpl->assign('moi', $link_sapxep.'/sapxep-1');
    $xtpl->assign('tangdan', $link_sapxep.'/sapxep-2');
    $xtpl->assign('giamdan', $link_sapxep.'/sapxep-3');
	
	if($sap_xep == 0)
		$xtpl->assign('s0', 'selected="selected"');
	if($sap_xep == 1)
		$xtpl->assign('s1', 'selected="selected"');
	if($sap_xep == 2)
		$xtpl->assign('s2', 'selected="selected"');
	if($sap_xep == 3)
		$xtpl->assign('s3', 'selected="selected"');
	
	$page_title = $array_cat[$array_search['catid']]['title'];
	
    $xtpl->assign('MODULE_NAME', $module_name);
	
	 $xtpl->assign('SEARCH', $array_search);
	 
	if(!empty($array_search['keywords']))
	{
		$xtpl->parse('main.keywords');
	}
	if($array_search['catid'] > 0)
	{
		$xtpl->assign('title_catid', $array_cat[$array_search['catid']]['title']);
		$xtpl->parse('main.title_catid');
		$xtpl->parse('main.title_catid1');
		$xtpl->parse('main.title_catid2');
	}
	if($array_search['districtid'] > 0)
	{
		$location = new Location();
		$districtid = $location->getDistricInfo($array_search['districtid']);
		$xtpl->assign('districtid', $districtid['name']);
		$xtpl->parse('main.districtid');
		$xtpl->parse('main.districtid_tai');
		$page_title = $page_title . ' tại '. $districtid['name'];
	}
	//print_r($array_search['area']);die;
	if(!empty($array_search['area']))
	{
		$page_title = $page_title . ', diện tích: '. $array_search['area'].' m2';
		$dt = explode('-',$array_search['area']);
		if($dt[1] > 0)
		$xtpl->parse('main.area');
		
	}
	if(!empty($array_search['price_spread']))
	{
		$mang_gia = explode('-',$array_search['price_spread']);
		if($mang_gia[1]/1000000000 > 0)
		{
			$xtpl->assign('so1', $mang_gia[0]/1000000000);
			$xtpl->assign('so2', $mang_gia[1]/1000000000);
			$xtpl->assign('donvi', 'tỉ');
			$page_title = $page_title . ', giá: '. $mang_gia[0]/1000000000 . '-' . $mang_gia[1]/1000000000 . ' tỉ';
		}
		else {
			$xtpl->assign('so1', $mang_gia[0]/1000000);
			$xtpl->assign('so2', $mang_gia[1]/1000000);
			$xtpl->assign('donvi', 'triệu');
			$page_title = $page_title . ', giá: '. $mang_gia[0]/1000000 . '-' . $mang_gia[1]/1000000 . ' triệu';
		}
		$xtpl->parse('main.price_spread');
		
	}
	if($array_search['provinceid'] > 0)
	{
		$location = new Location();
		$provinceid = $location->locationString($array_search['provinceid']);
		$xtpl->assign('provinceid', $provinceid);
		$xtpl->parse('main.provinceid');
	}
	
	
	
	if(empty($diadiem))
		$diadiem = 'Toàn quốc';
    $xtpl->assign('diadiem', $diadiem);
    $xtpl->assign('OP_NAME', $op);
    $title_page = $lang_module['ket_qua_tk'];
    if (! empty($array_data)) {
        $xtpl->assign('DATA', call_user_func('nv_theme_search_' . $viewtype, $title_page, $array_data_vip, $array_data));
        
        if (! empty($generate_page)) {
            $xtpl->assign('PAGE', $generate_page);
            $xtpl->parse('main.page');
        }
    }
    
    if ($is_search) {
        $xtpl->assign('NOTE', $lang_module['search_result']);
        $xtpl->parse('main.note');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * redict_link()
 *
 * @param mixed $lang_view            
 * @param mixed $lang_back            
 * @param mixed $nv_redirect            
 * @return
 *
 */
function redict_link($lang_view, $lang_back, $nv_redirect)
{
    $contents = "<div class=\"text-center\">";
    $contents .= $lang_view . "<br /><br />\n";
    $contents .= "<em class=\"fa fa-spinner fa-spin fa-4x\">&nbsp;</em><br /><br />\n";
    $contents .= "<a href=\"" . $nv_redirect . "\">" . $lang_back . "</a>";
    $contents .= "</div>";
    $contents .= "<meta http-equiv=\"refresh\" content=\"2;url=" . $nv_redirect . "\" />";
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

/**
 * nv_theme_market_saved()
 *
 * @param mixed $array_data            
 * @param mixed $page            
 * @return
 *
 */
function nv_theme_market_saved($array_data, $page)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_market_cat, $catid, $lang_global, $user_info;
    
    $xtpl = new XTemplate('saved.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('ACTION_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax');
    $xtpl->assign('CHECKSS', md5($global_config['sitekey'] . '-' . $user_info['userid'] . '-' . NV_CACHE_PREFIX));
    
    if (! empty($array_data)) {
        foreach ($array_data as $data) {
            $xtpl->assign('DATA', $data);
            $xtpl->parse('main.loop');
        }
    }
    
    if (! empty($page)) {
        $xtpl->assign('PAGE', $page);
        $xtpl->parse('main.page');
    }
    
    $array_action = array(
        'delete_list_id' => $lang_global['delete']
    );
    
    foreach ($array_action as $key => $value) {
        $xtpl->assign('ACTION', array(
            'key' => $key,
            'value' => $value
        ));
        $xtpl->parse('main.action');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}


/**
 * nv_theme_payment()
 *
 * @param mixed $array_info            
 * @param mixed $array_option            
 * @param mixed $id            
 * @param mixed $mod            
 * @param mixed $all            
 * @return
 *
 */
function nv_theme_payment($array_info, $array_option, $id, $mod, $all, $show_row_info)
{
    global $global_config, $module_name, $module_file, $lang_module, $lang_global, $module_config, $module_info, $op, $array_config, $user_info, $array_groups, $group_list, $db, $array_time_unit;
    
    if (empty($array_info)) {
        $array_info['id'] = 0;
        $array_info['title'] = $lang_module['payment_' . $mod];
    }
    
    $template = $all ? 'payment_all' : 'payment';
    
    $xtpl = new XTemplate($template . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
	
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('INFO', $array_info);
    $xtpl->assign('MONEY_UNIT', 'k');
    $xtpl->assign('MOD', $mod);
$xtpl->assign('USER_INFO', $user_info);
    $xtpl->assign('URL_ITEM', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $module_info['alias']['items'], true));
	
	// lấy tên nhóm ra
	//PRINT_R('SELECT title FROM nv4_vi_users_groups WHERE group_id ='.$array_info['user_groupid']);DIE;
	if($array_info['user_groupid'])
	{
		$tennhom = $db->query('SELECT title FROM nv4_users_groups WHERE group_id ='.$array_info['user_groupid'])->fetchColumn();
		
		$xtpl->assign('NHOM', $tennhom);
		 
		// lấy ngày hết hạn ra
		
		$xtpl->assign('NGAYHETHAN', date('d/m/Y',$array_info['exptime']));
		if($array_info['exptime'] < NV_CURRENTTIME)
		{
		$xtpl->assign('class', 'red');	
		}
		else
		{
		$xtpl->assign('class', 'xanh');	
		}
		$xtpl->parse('main.taikhoan');
	}
    if ($all) {
        if (! empty($array_option['group'])) {
            
            $count = sizeof($array_option['group']);
            if ($mod == 'group') {
                $count += 1;
            }
            $xtpl->assign('COL_CLASS', nv_caculate_bootstrap_grid($count));
            
            foreach ($array_option['group'] as $index => $value) {
                
                $xtpl->assign('GROUP', $mod == 'group' ? $array_groups[$index] : array(
                    'bid' => $index,
                    'title' => $group_list[$index]['title'],
                    'description' => $group_list[$index]['description']
                ));
                
                $i = 0;
                foreach ($value as $option) {
                    if ($mod == 'upgrade_group') {
                        $array_info['id'] = $index;
                    }
                    $option['tokenkey'] = md5($array_info['id'] . $option['price'] . 'VND');
                    $option['checksum'] = md5($global_config['sitekey'] . '-' . $user_info['userid'] . '-' . $array_info['id'] . '-' . $option['time']);
                    $option['selected'] = '';
                    if ($i == 0) {
                        $option['selected'] = 'selected="selected"';
                        $xtpl->assign('FIRST', array(
                            'number' => isset($option['number']) ? $option['number'] : 0,
                            'price' => $option['price'],
                            'tokenkey' => $option['tokenkey'],
                            'checksum' => $option['checksum']
                        ));
                    }
                    $option['price_format'] = nv_number_format($option['price']);
                    $xtpl->assign('OPTION', $option);
                    $xtpl->parse('main.group.option');
                    $i ++;
                }
                
                $xtpl->parse('main.group');
            }
        }
        
        if (! empty($array_option['refresh'])) {
            $i = 0;
            foreach ($array_option['refresh'] as $option) {
                $option['tokenkey'] = md5($array_info['id'] . $option['price'] . 'VND');
                $option['checksum'] = md5($global_config['sitekey'] . '-' . $user_info['userid'] . '-' . $array_info['id'] . '-' . $option['number']);
                $option['checked'] = '';
                if ($i == 0) {
                    $option['checked'] = 'checked="checked"';
                    $xtpl->assign('FIRST', array(
                        'number' => isset($option['number']) ? $option['number'] : 0,
                        'price' => $option['price'],
'price_sale' => $option['price_sale'],
                        'tokenkey' => $option['tokenkey'],
                        'checksum' => $option['checksum']
                    ));
                }
                $option['price_format'] = nv_number_format($option['price']);
$option['price_discount'] = ! empty($option['price_discount']) ? nv_number_format($option['price_discount']) : '';
                $xtpl->assign('OPTION', $option);
                $xtpl->parse('main.refresh.option');
                $i ++;
            }
            $xtpl->parse('main.refresh');
        }
    } else {
        if (! empty($array_option)) {
            
            if ($mod == 'group') {
                $xtpl->assign('GROUP', $array_groups);
            }elseif($mod == 'upgrade_group'){
                $xtpl->assign('GROUP', $array_info);
            }
            
            $i = 0;
            foreach ($array_option as $option) {
                $option['tokenkey'] = md5($array_info['id'] . $option['price_sale'] . 'VND');
                if ($mod == 'refresh') {
                    $option['checksum'] = md5($global_config['sitekey'] . '-' . $user_info['userid'] . '-' . $array_info['id'] . '-' . $option['number']);
                } elseif ($mod == 'group' or $mod == 'upgrade_group') {
                    $option['checksum'] = md5($global_config['sitekey'] . '-' . $user_info['userid'] . '-' . $array_info['id'] . '-' . $option['time']);
                }
                
                $option['checked'] = '';
                if ($i == 0) {
                    $option['checked'] = 'checked="checked"';
                    $xtpl->assign('FIRST', array(
                        'number' => isset($option['number']) ? $option['number'] : 0,
                        'price' => $option['price'],
'price_sale' => $option['price_sale'],
                        'tokenkey' => $option['tokenkey'],
                        'checksum' => $option['checksum']
                    ));
                }
                $option['price_format'] = nv_number_format($option['price']/1000);
$option['price_discount'] = ! empty($option['price_discount']) ? nv_number_format($option['price_discount']/1000) : '';
$option['unit'] = $array_time_unit[$option['unit']];
                $xtpl->assign('OPTION', $option);

                if (! empty($option['price_discount'])) {
                    $xtpl->parse('main.' . $mod . '.option.discount');
                }

                $xtpl->parse('main.' . $mod . '.option');
                $i ++;
            }
            $xtpl->parse('main.' . $mod);
        }
    }

    if ($show_row_info) {
        $xtpl->parse('main.show_row_info');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 *
 * nv_theme_upgrade()
 *
 * @param mixed $mod            
 * @param mixed $array_data            
 * @param mixed $content            
 * @return
 *
 */
function nv_theme_upgrade($mod, $array_data, $content)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info;
    
    $xtpl = new XTemplate('upgrade.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('DATA', $array_data);
    $xtpl->assign('CONTENT', $content);
    $xtpl->assign('MOD', $mod);
    
    if ($mod == 'group') {
        $xtpl->parse('main.rowinfo');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}
