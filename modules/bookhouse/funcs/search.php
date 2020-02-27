<?php
// Start the session
session_start();

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (! defined('NV_IS_MOD_BOOKHOUSE'))
    die('Stop!!!');

$key_words = $module_info['keywords'];

$array_data = array();
$where = $generate_page = '';
$is_search = 0;

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=search';
$base_url_rewrite = $request_uri = urldecode($_SERVER['REQUEST_URI']);
$array_mod_title[] = array(
    'title' => $lang_module['search'],
    'link' => $base_url
);


    $is_search = 1;
    $page = intval(substr($array_op[1], 5));
	if(empty($page))
		$page = 1;
    $num_items = 0;
    
	 $area = $nv_Request->get_title('area', 'post,get', '');
	 if(!empty($area))
	 {
		$mang_area = explode("-",$area);
		$area_from = $mang_area[0];
		$area_to = $mang_area[1];
	 }
	 

	   $array_search_goc = array(
            'keywords' => $nv_Request->get_title('keywords', 'get,post', ''),
            'catid' => $nv_Request->get_int('catid', 'get,post', 0),
            'area' => $nv_Request->get_title('area', 'get,post', ''),
			'price_spread' => $nv_Request->get_title('price_spread', 'post,get', ''),
            'provinceid' => $nv_Request->get_int('provinceid', 'get,post', 0),
            'districtid' => $nv_Request->get_int('districtid', 'get,post', 0)
        );
		
		
	 
    $array_search = array(
        'q' => $nv_Request->get_title('keywords', 'get,post', ''),
        'catid' => $nv_Request->get_int('catid', 'get,post', 0),
        'price_spread' => $nv_Request->get_title('price_spread', 'post,get', ''),
        'area_from' => $area_from,
        'area_to' => $area_to,
        'provinceid' => $nv_Request->get_int('provinceid', 'get,post', 0),
        'districtid' => $nv_Request->get_int('districtid', 'get,post', 0)
    );
//print_r($array_search );die;
	$location = new Location();
	$diadiem = $location->locationString($array_search['provinceid']);
	

    if (! empty($array_search['q'])) {
        $where .= ' AND t1.title like "%' . $array_search['q'] . '%"';
        $base_url .= '&q=' . $array_search['q'];
    }
    
    if (! empty($array_search['catid'])) {
	
		if(!empty($array_cat[$array_search['catid']]['subid']))
		$where .= ' AND (catid='.$array_search['catid'].' OR catid IN ('.$array_cat[$array_search['catid']]['subid'].'))';	
		else
		 $where .= ' AND t1.catid = '.$array_search['catid'];
		 
       // $where .= ' AND catid = ' . $array_search['catid'];
        $base_url .= '&catid=' . $array_search['catid'];
    }else{
        $base_url_rewrite = str_replace('&catid=' . $array_search['catid'], '', $base_url_rewrite);
    }
    
    if(!empty($array_search['price_spread'])){
        $base_url .= 'price_spread=' . $array_search['price_spread'];
    
        $price_spread = explode('-', $array_search['price_spread']);
        if(sizeof($price_spread) == 2){
            if(!empty($price_spread[0]) and !empty($price_spread[1])){
                $where .= ' AND (t1.price >= ' . $price_spread[0] . ' AND t1.price <= ' . $price_spread[1] . ')';
            }elseif(!empty($price_spread[0]) and empty($price_spread[1])){
                $where .= ' AND t1.price >= ' . $price_spread[0];
            }
        }
    }else{
        $base_url_rewrite = str_replace('&price_spread=' . $array_search['price_spread'], '', $base_url_rewrite);
    }
    
    if (! empty($array_search['area_from'])) {
        $where .= ' AND t1.area >= ' . doubleval($array_search['area_from']);
        $base_url .= 'area_from=' . $array_search['area_from'];
    }else{
        $base_url_rewrite = str_replace('&area_from=' . $array_search['area_from'], '', $base_url_rewrite);
    }
    
    if (! empty($array_search['area_to'])) {
        $where .= ' AND t1.area <= ' . doubleval($array_search['area_to']);
        $base_url .= 'area_to=' . $array_search['area_to'];
    }else{
        $base_url_rewrite = str_replace('&area_to=' . $array_search['area_to'], '', $base_url_rewrite);
    }
    
    if (! empty($array_search['provinceid'])) {
        $where .= ' AND t1.provinceid = ' . $array_search['provinceid'];
        $where_diadiem = ' AND provinceid = ' . $array_search['provinceid'];
        $base_url .= '&provinceid=' . $array_search['provinceid'];
    }else{
        $base_url_rewrite = str_replace('&provinceid=' . $array_search['provinceid'], '', $base_url_rewrite);
    }
    
    if (! empty($array_search['districtid'])) {
        $where .= ' AND t1.districtid = ' . $array_search['districtid'];
        $base_url .= '&districtid=' . $array_search['districtid'];
    }else{
        $base_url_rewrite = str_replace('&districtid=' . $array_search['districtid'], '', $base_url_rewrite);
    }
	
    $base_url_rewrite = nv_url_rewrite($base_url_rewrite, true);
    if ($request_uri != $base_url_rewrite and NV_MAIN_DOMAIN . $request_uri != $base_url_rewrite) {
        header('Location: ' . $base_url_rewrite);
        die();
    }
    
    $location = new Location();
	
	$sap_xep = intval(substr($array_op[2], 7));
	if(!empty($sap_xep))
	{
	if($sap_xep == 0)
		$order_sapxep = 't1.ordertime DESC';
	if($sap_xep == 1)
		$order_sapxep = 't1.ordertime DESC';
	if($sap_xep == 2)
		$order_sapxep = 't1.price ASC';
	if($sap_xep == 3)
		$order_sapxep = 't1.price DESC';
		
	 $_SESSION["sapxep"] = $order_sapxep;
	 $_SESSION["tt"] = $sap_xep;
	 
	}
	elseif(!empty($_SESSION["sapxep"])){
		$sap_xep = $_SESSION["tt"];
		$order_sapxep = $_SESSION["sapxep"] ;
	}
	else{
		$sap_xep == 0;
		$order_sapxep = 't1.edittime DESC';
	}
	
	if(!empty($where))	
    $_SESSION["where"] = $where;
	
	
	if(!$nv_Request->isset_request('keywords', 'get,post'))
	{
		$where = $_SESSION["where"];
		if(!empty($_SESSION["sapxep"]))
		{
		$order_sapxep = $_SESSION["sapxep"];
		$sap_xep = $_SESSION["tt"];
		}
	}
	if($nv_Request->isset_request('tinhthanh', 'get'))
	{
		$tinhthanh = $nv_Request->get_title('tinhthanh', 'get', '');
		if(!empty($tinhthanh))
		{
			// LẤY ID TỈNH THÀNH RA
			$id_tinhthanh = $db->query("SELECT provinceid FROM nv4_location_province WHERE title like '". $tinhthanh ."'")->fetchColumn();
		
			if($id_tinhthanh > 0)
			{
				$where .= ' AND t1.provinceid = ' . $id_tinhthanh;
				$base_url .= '&provinceid=' . $id_tinhthanh;
			}
		}
	}
	
	
		// lấy bđs vip
		
		$db->sqlreset()
            ->select('COUNT(*) ')
            ->from(NV_PREFIXLANG . '_' . $module_data.' t1')
            ->where('t1.status=1 AND t1.groupid = 4 AND t1.status_admin=1 AND t1.is_queue=0 AND t1.inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0) ' . $where_diadiem);
        
        $db->select('id, catid, title, alias, code, area, price, addtime, edittime, admin_id, provinceid, districtid, price_time , homeimgfile, homeimgthumb, showprice, groupid')
        ->order($order_sapxep);
        
        $result_vip = $db->query($db->sql());
        while ($item = $result_vip->fetch()) {
			$item['edittime'] = date('d/m/Y',$item['edittime']);
            $array_data_vip[] = nv_data_show($item);
        }
		//print_r($array_data_vip);die;
		// kết thúc bđs vip
		
		// lấy danh sách tin rao
		
			$db->sqlreset()
			->select('COUNT(*) ')
			->from(NV_PREFIXLANG . '_' . $module_data.' t1')
			->where('t1.status=1 AND t1.status_admin=1 AND t1.is_queue=0 AND t1.inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0)' .$where);
		
			$num_items = $db_slave->query($db_slave->sql())->fetchColumn();
			
		$db_slave->select('t1.id, t1.catid, t1.groupid, t1.title, t1.alias, t1.price, t1.showprice, t1.edittime, t1.ordertime, t1.area, t1.homeimgfile, t1.homeimgthumb, t1.provinceid, t1.districtid, t2.image') 
			->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data .'_block_cat t2 ON t2.bid = t1.groupid')
			->order(' t2.weight DESC,'. $order_sapxep) 
			->limit($per_page)
			->offset(($page - 1) * $per_page);
		//print_r($db_slave->sql());die;
		$result = $db_slave->query($db_slave->sql());
		
		while ($item = $result->fetch()) {
			$item['icon_block'] = $item['image'];
			$array_data[] = nv_data_show($item);
		}
		
		// kết thúc lấy danh sách tin rao
        
        $generate_page = '';
			
        if ($num_items > $per_page) {
            $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=search'; 
			$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
		
        }
		$link_sapxep = NV_BASE_SITEURL . $module_name . '/search/page-'.$page;
        
    
    $lang_module['search_result'] = 'Kết quả 1-10 trong '. $num_items;

$contents = nv_theme_bookhouse_search($array_search_goc, $link_sapxep, $sap_xep, $diadiem,$array_data_vip,$array_data, $is_search, $generate_page);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';