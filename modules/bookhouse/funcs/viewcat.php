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

$page_title = $array_cat[$catid]['title'];
$description = $array_cat[$catid]['description'];


if (empty($contents)) {
    $array_data = array();
    $base_url = $array_cat[$catid]['link'];
	
	if(!empty($array_cat[$catid]['subid']))
	{
		$in_catid = ' OR catid IN ('.$array_cat[$catid]['subid'].')';
	}
	
			$db->sqlreset()
			->select('COUNT(*) ')
			->from(NV_PREFIXLANG . '_' . $module_data.' t1')
			->where('t1.status=1 AND t1.status_admin=1 AND t1.is_queue=0 AND t1.inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0) AND (t1.catid='.$catid. $in_catid.')');
		
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
	//die($base_url);
    $generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
	
   
    $contents = nv_theme_viewcat($page_title,$array_data, $generate_page);
  
}

if ($page > 1) {
    $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
    $description .= ' ' . $page;
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
