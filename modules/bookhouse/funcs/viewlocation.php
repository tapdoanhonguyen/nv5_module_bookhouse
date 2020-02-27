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

$description = $array_cat[$catid]['description'];

require_once NV_ROOTDIR . '/modules/location/location.class.php';
$location = new Location();
$where = '';

switch ($array_op[0]) {
    case 'p':
        $location_info = $location->getProvinceInfo($id);
        $array_local_id = array_keys($location->getArrayDistrict('', $id));
        $where .= ' AND provinceid=' . $id;
        break;
    case 'd':
        $location_info = $location->getDistricInfo($id);
        $array_local_id = array_keys($location->getArrayWard('', $id));
        $where .= ' AND districtid=' . $id;
        break;
	case 'w':
        $location_info = $location->getWardInfo($id);
        $array_local_id = array_keys($location->getArrayWard('', $id));
        $where .= ' AND wardid=' . $id;
        break;
    default:
        $location_info = $location->getWardInfo($id);
        break;
}

if (! defined('NV_IS_MODADMIN') and $page < 5) {
    $cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_' . $catid . '_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
    if (($cache = $nv_Cache->getItem($module_name, $cache_file)) != false) {
        $contents111 = $cache;
    }
}

if (empty($contents)) {
    $array_data = array();
    $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '/' . $array_op[0] . '/' . $array_op[1];
	
	// bắt đầu 
	
	$db->sqlreset()
			->select('COUNT(*) ')
			->from(NV_PREFIXLANG . '_' . $module_data.' t1')
			->where('t1.status=1 AND t1.status_admin=1 AND t1.is_queue=0 AND t1.inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0)'. $where);
		
			$num_items = $db_slave->query($db_slave->sql())->fetchColumn();
			
		$db_slave->select('t1.id, t1.catid, t1.groupid, t1.title, t1.alias, t1.price, t1.price_time, t1.showprice, t1.edittime, t1.ordertime, t1.area, t1.homeimgfile, t1.homeimgthumb, t1.address, t1.provinceid, t1.districtid, t1.wardid, t2.image') 
			->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data .'_block_cat t2 ON t2.bid = t1.groupid')
			->order(' t2.weight DESC,t1.ordertime DESC') 
			->limit($per_page)
			->offset(($page - 1) * $per_page);
		
		$result = $db_slave->query($db_slave->sql());
		//print($db_slave->sql());die; 
		while ($item = $result->fetch()) {
			$item['edittime'] = date('d/m/Y',$item['edittime']);
			$item['icon_block'] = $item['image'];
			$array_data[] = nv_data_show($item);
		}	
		
    $generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
	
   
    $contents = nv_theme_viewcat($location_info['type']." ".$location_info['title'],$array_data, $generate_page);
    
    if (! defined('NV_IS_MODADMIN') and $contents != '' and $cache_file != '') {
        $nv_Cache->setItem($module_name, $cache_file, $contents);
    }
}

if ($page > 1) {
    $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
    $description .= ' ' . $page;
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
