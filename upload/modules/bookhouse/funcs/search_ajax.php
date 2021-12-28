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

$page_title = $lang_module['search'];
$key_words = $module_info['keywords'];

$array_data = array();
$array_search = array(
    'q' => '',
    'catid' => 0,
    'price_from' => 0,
    'price_to' => 0,
    'area_from' => 0,
    'area_to' => 0,
    'size_v' => 0,
    'size_h' => 0,
    'way' => 0,
    'provinceid' => 0,
    'districtid' => 0,
    'wardid' => 0,
    'typeid' => 0
);
$where = $generate_page = '';
$is_search = 0;

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=search';
$base_url_rewrite = $request_uri = urldecode($_SERVER['REQUEST_URI']);
$array_mod_title[] = array(
    'title' => $lang_module['search'],
    'link' => $base_url
);

if ($nv_Request->isset_request('catid', 'get,post')) {
    $is_search = 1;
    $page = $nv_Request->get_int('page', 'get', 1);
    $num_items = 0;
   
    $array_search = array(
        'catid' => $nv_Request->get_title('catid', 'get,post', 0),
        'huong_bds' => $nv_Request->get_title('huong_bds', 'get,post', 0),
        'chonphongngu' => $nv_Request->get_title('chonphongngu', 'get,post', 0),
        'phong_khach' => $nv_Request->get_title('phong_khach', 'get,post', 0),
        'phong_tam' => $nv_Request->get_title('phong_tam', 'get,post', 0),
        'price_spread' => $nv_Request->get_title('price_spread', 'get,post', 0)
    );

    
    if (! empty($array_search['catid'])) {
			$where .= ' AND catid IN (' . $array_search['catid'] . ')';		
    }
	
	// hướng bất động sản 
	if (! empty($array_search['huong_bds'])) {
		$where .= ' AND way_id IN (' . $array_search['chonphongngu'] . ')';
	}
	
	// phòng ngủ 
	if (! empty($array_search['chonphongngu'])) {
		$where .= ' AND phong_ngu IN (' . $array_search['chonphongngu'] . ')';
	}
	
	// phòng khách 
	if (! empty($array_search['phong_khach'])) {
		$where .= ' AND phong_khach IN (' . $array_search['phong_khach'] . ')';
	}
	
	// phòng tắm
	if (! empty($array_search['phong_tam'])) {
		$where .= ' AND phong_tam IN (' . $array_search['phong_tam'] . ')';
	}
	
	// giá bất động sản
	if (! empty($array_search['price_spread'])) {
	 
		$list_gia = explode(',',$array_search['price_spread']);
		$where1 = '';
		foreach($list_gia as $gia)
		{
			if(!empty($where1))
			{
				$where1 .= ' OR';
			}
			else
			{
				$where1 .= ' AND';
			}
			
			$price_spread = explode('-', $gia);
			
			if(sizeof($price_spread) == 2){
			
				if($price_spread[0] >= 0 and $price_spread[1] > 0){
					$where1 .= ' (price >= ' . $price_spread[0] . ' AND price <= ' . $price_spread[1] . ')';
					
				}elseif($price_spread[0] > 0 and $price_spread[1] == 0){
					$where1 .= ' ( price <= ' . $price_spread[1] . ')';
				}
			}
			
		}

	}
	
	
    $location = new Location();
    
    if (! empty($where) or ! empty($where1) ) {
        $db->sqlreset()
            ->select('COUNT(*) ')
            ->from(NV_PREFIXLANG . '_' . $module_data)
            ->where('status=1 AND status_admin=1 AND is_queue=0 AND inhome=1 AND (exptime > ' . NV_CURRENTTIME . ' OR exptime = 0) ' . $where. $where1);
      //  die($db->sql());
        $num_items = $db->query($db->sql())
            ->fetchColumn();
       
        $db->select('id, catid, title, alias, code, area, size_v, size_h, price, addtime, admin_id, provinceid, districtid, wardid, way_id, address, structure, price_time, bodytext, homeimgfile, homeimgthumb, showprice, group_config')
            ->order('ordertime DESC')
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);
     // die($db->sql());
        $result = $db->query($db->sql());
        while ($item = $result->fetch()) {
            $array_data[] = nv_data_show($item);
        }
        
        $generate_page = '';
        if ($num_items > $per_page) {
            $url_link = $_SERVER['REQUEST_URI'];
            if (strpos($url_link, '&page=') > 0) {
                $url_link = substr($url_link, 0, strpos($url_link, '&page='));
            } elseif (strpos($url_link, '?page=') > 0) {
                $url_link = substr($url_link, 0, strpos($url_link, '?page='));
            }
            $_array_url = array( 'link' => $url_link, 'amp' => '&page=' );
            $generate_page = nv_generate_page($_array_url, $num_items, $per_page, $page);
        }
        
    }
    $lang_module['search_result'] = sprintf($lang_module['search_result'], $num_items);
}

$contents = nv_theme_bookhouse_search($array_data, $is_search, $generate_page);

echo $contents; die;