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

if ($nv_Request->isset_request('location_reload', 'post,get')) {
    $data_config = array(
        'select_countryid' => $nv_Request->get_int('select_countryid', 'post,get', 0),
        'allow_country' => $nv_Request->get_title('allow_country', 'post,get', ''),
        'allow_province' => $nv_Request->get_title('allow_province', 'post,get', ''),
        'allow_district' => $nv_Request->get_title('allow_district', 'post,get', ''),
        'allow_ward' => $nv_Request->get_title('allow_ward', 'post,get', ''),
        'multiple_province' => $nv_Request->get_int('multiple_province', 'post,get', 0),
        'multiple_district' => $nv_Request->get_int('multiple_district', 'post,get', 0),
        'multiple_ward' => $nv_Request->get_int('multiple_ward', 'post,get', 0),
        'is_district' => $nv_Request->get_int('is_district', 'post,get', 0),
        'is_ward' => $nv_Request->get_int('is_ward', 'post,get', 0),
        'blank_title_country' => $nv_Request->get_int('blank_title_country', 'post,get', 0),
        'blank_title_province' => $nv_Request->get_int('blank_title_province', 'post,get', 0),
        'blank_title_district' => $nv_Request->get_int('blank_title_district', 'post,get', 0),
        'blank_title_ward' => $nv_Request->get_int('blank_title_ward', 'post,get', 0),
        'name_country' => $nv_Request->get_title('name_country', 'post,get', 'countryid'),
        'name_province' => $nv_Request->get_title('name_province', 'post,get', 'provinceid'),
        'name_district' => $nv_Request->get_title('name_district', 'post,get', 'districtid'),
        'name_ward' => $nv_Request->get_title('name_ward', 'post,get', 'wardid'),
        'index' => $nv_Request->get_int('index', 'post,get', 0),
        'col_class' => $nv_Request->get_title('col_class', 'post,get', 'col-xs-24 col-sm-12 col-md-12')
    );
    
    $data_config['select_provinceid'] = $nv_Request->get_title('select_provinceid', 'post,get', '');
    $data_config['select_districtid'] = $nv_Request->get_title('select_districtid', 'post,get', '');
    $data_config['select_wardid'] = $nv_Request->get_title('select_wardid', 'post,get', '');
    
    if ($data_config['multiple_province']) {
        $data_config['select_provinceid'] = explode(',', $data_config['select_provinceid']);
        $data_config['select_districtid'] = explode(',', $data_config['select_districtid']);
        $data_config['select_wardid'] = explode(',', $data_config['select_wardid']);
    }
    
    $location = new Location();
    $location->set('SelectCountryid', $data_config['select_countryid']);
    $location->set('SelectProvinceid', $data_config['select_provinceid']);
    $location->set('SelectDistrictid', $data_config['select_districtid']);
    $location->set('SelectWardid', $data_config['select_wardid']);
    $location->set('AllowCountry', $data_config['allow_country']);
    $location->set('AllowProvince', $data_config['allow_province']);
    $location->set('AllowDistrict', $data_config['allow_district']);
    $location->set('AllowWard', $data_config['allow_ward']);
    $location->set('MultipleProvince', $data_config['multiple_province']);
    $location->set('MultipleDistrict', $data_config['multiple_district']);
    $location->set('MultipleWard', $data_config['multiple_ward']);
    $location->set('IsDistrict', $data_config['is_district']);
    $location->set('IsWard', $data_config['is_ward']);
    $location->set('BlankTitleCountry', $data_config['blank_title_country']);
    $location->set('BlankTitleProvince', $data_config['blank_title_province']);
    $location->set('BlankTitleDistrict', $data_config['blank_title_district']);
    $location->set('BlankTitleWard', $data_config['blank_title_ward']);
    $location->set('NameCountry', $data_config['name_country']);
    $location->set('NameProvince', $data_config['name_province']);
    $location->set('NameDistrict', $data_config['name_district']);
    $location->set('NameWard', $data_config['name_ward']);
    $location->set('Index', $data_config['index']);
    $location->set('ColClass', $data_config['col_class']);
    
    die($location->buildInput());
}	
if ( $nv_Request->isset_request( 'get_alias_title', 'post' ) )
{
	$alias = $nv_Request->get_title( 'get_alias_title', 'post', '' );
	$alias = change_alias( $alias );
	$alias = str_replace('Thanh-Pho', 'tp', $alias);
	$alias = nv_strtolower($alias);
	$link = NV_BASE_SITEURL . $alias;
	die($link);
}


$page_title = 'Tin dành cho bạn';
$description = $array_cat[$catid]['description'];

$page = 1;
if( isset( $array_op[0] ) and substr( $array_op[0], 0, 5 ) == 'page-' )
{
	$page = intval( substr( $array_op[0], 5 ) );
}

if (! defined('NV_IS_MODADMIN') and $page < 5) {
    $cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_' . $catid . '_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
    if (($cache = $nv_Cache->getItem($module_name, $cache_file)) != false) {
        $contents = $cache;
    }
}

if (empty($contents)) {
    $array_data = array();
    $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
	
			$db->sqlreset()
			->select('COUNT(*) ')
			->from(NV_PREFIXLANG . '_' . $module_data.' t1')
			->where('t1.status=1 AND t1.status_admin=1 AND t1.is_queue=0 AND t1.inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0)');
		
			$num_items = $db_slave->query($db_slave->sql())->fetchColumn();
		
		$db_slave->select('t1.id, t1.catid, t1.group_id, t1.title, t1.alias, t1.price, t1.showprice, t1.edittime, t1.ordertime, t1.area, t1.homeimgfile, t1.homeimgthumb, t1.address, t1.provinceid, t1.districtid, t1.wardid, t2.image') 
			->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data .'_block_cat t2 ON t2.bid = t1.group_id')
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
	
    $contents = nv_theme_viewcat($page_title,$array_data, $generate_page);
    
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
