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
//print_r(date('d/m/Y',1509999959));die;
$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];
//print_r(date('d/m/Y - H:I',1407704548));die;
// XỬ LÝ THÊM LƯỢT XEM ĐIỆN THOẠI
$hits_phone = $nv_Request->get_int('hits_phone', 'post,get', 0);
if($hits_phone > 0)
{
	 $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET hits_phone=hits_phone+1 WHERE id=' . $hits_phone);
	 print(1);die;
}
$array_data = array();

if (empty($id)) {
    Header('Location: ' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name, true));
    exit();
}

// lấy id của nhóm tin ra dựa vào id tin
	$id_nhomtin = $db->query('SELECT groupid FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id='.$id.' LIMIT 0,1')->fetchColumn();
	
// LẤY MÀU VÀ ICON RA
	if($id_nhomtin > 0)
	{
		$tt_nhom['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $array_groups[$id_nhomtin]['image'];
		$tt_nhom['color'] = $array_groups[$id_nhomtin]['color'];
	}
	

$sql = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id = ' . $id . ' AND status=1 AND status_admin=1 AND is_queue=0');
$data_content = $sql->fetch();

if (empty($data_content)) {
    $nv_redirect = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true);
    redict_link($lang_module['detail_do_not_view'], $lang_module['redirect_to_back_home'], $nv_redirect);
}

$location = new Location();
$module_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$data_content['location'] = $location->locationString($data_content['provinceid'], $data_content['districtid'], $data_content['wardid'], ' , ', $module_url);
$data_content['addtime'] = nv_date('H:i d/m/Y', $data_content['addtime']);
$data_content['ordertime'] = nv_date('H:i d/m/Y', $data_content['ordertime']);

$data_content['poster'] = $lang_global['guests'];
if ($data_content['admin_id'] > 0) {
    $result = $db->query('SELECT username, first_name, last_name FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $data_content['admin_id']);
    if ($result->rowCount()) {
        list ($username, $first_name, $last_name) = $result->fetch(3);
        $data_content['poster'] = nv_show_name_user($first_name, $last_name, $username);
    }
}

// So luot xem tin
$time_set = $nv_Request->get_int($module_data . '_' . $op . '_' . $id, 'session');
if (empty($time_set)) {
    $nv_Request->set_Session($module_data . '_' . $op . '_' . $id, NV_CURRENTTIME);
    $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET hitstotal=hitstotal+1 WHERE id=' . $id);
}

$catid = $data_content['catid'];
$base_url_rewrite = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_cat[$catid]['alias'] . '/' . $data_content['alias'] . '-' . $data_content['id'] . $global_config['rewrite_exturl'], true);


// Xac dinh anh lon
$homeimgfile = $data_content['homeimgfile'];
if ($data_content['homeimgthumb'] == 1 and ! empty($homeimgfile)) {
    $data_content['homeimgthumb'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $homeimgfile;
    $data_content['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $homeimgfile;
} elseif ($data_content['homeimgthumb'] == 2) {
    $data_content['homeimgthumb'] = $data_content['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $homeimgfile;
} elseif ($data_content['homeimgthumb'] == 3) {
    $data_content['homeimgthumb'] = $data_content['homeimgfile'] = $homeimgfile;
} else {
    $data_content['homeimgthumb'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_file . '/no-image.jpg';
}

// Hinh anh khac
$data_content['other_image'] = array();
$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE rows_id=' . $id);
while ($row = $result->fetch()) {
    $data_content['other_image'][] = $row;
}

// metatag image facebook
$meta_property['og:image'] = NV_MY_DOMAIN . $data_content['homeimgthumb'];

$array_keyword = array();
$key_words = array();
$_query = $db->query('SELECT a1.keyword, a2.alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id a1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_tags a2 ON a1.tid=a2.tid WHERE a1.id=' . $data_content['id']);
while ($row = $_query->fetch()) {
    $array_keyword[] = $row;
    $key_words[] = $row['keyword'];
}

if ($array_config['othertype'] == 0) {
    $where = 'id != ' . $id . ' AND groupid =4  AND catid = ' . $data_content['catid'] . '  AND status=1 AND status_admin=1 AND is_queue=0';
	$moi  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
	$where_tinlammoi = 'id != ' . $id . ' AND groupid =0 AND ordertime >= '.$moi.'  AND status=1 AND status_admin=1 AND is_queue=0 AND catid = ' . $data_content['catid'];
	$where_tinmoi = 'id != ' . $id . ' AND groupid =0  AND catid = ' . $data_content['catid'] . '  AND status=1 AND status_admin=1 AND is_queue=0';
	
	$where_tinngdang = 'id != ' . $id . ' AND catid = ' . $data_content['catid'] . ' AND admin_id ='.$user_info['userid'].' AND status=1 AND status_admin=1 AND is_queue=0';
} elseif ($array_config['othertype'] == 3) {
    // cùng quận và giá tiền tăng 30%
    $price = $data_content['price'] + ($data_content['price'] * 30) / 100;
    $where = 'id != ' . $id . ' AND price > 0 AND wardid > 0 AND wardid = ' . $data_content['wardid'] . ' AND status=1 AND status_admin=1 AND is_queue=0 AND price <= ' . $price . ' AND price >= ' . $data_content['price'];
}

// Du an
$data_content['project'] = '';
if($data_content['projectid'] > 0){
    $data_content['project'] = nv_get_project($data_content['projectid'])['title'];
}

// Kiem tra luu tin
$data_content['is_user'] = 0;
$data_content['style_save'] = $data_content['style_saved'] = '';
if (defined('NV_IS_USER')) {
    $data_content['is_user'] = 1;
    $count = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_saved WHERE itemid=' . $data_content['id'] . ' AND userid=' . $user_info['userid'])->fetchColumn();
    if ($count) {
        $data_content['style_save'] = 'style="display: none"';
    } else {
        $data_content['style_saved'] = 'style="display: none"';
    }
} else {
    $data_content['style_saved'] = 'style="display: none"';
}
$sl = 0;
$data_others = array();
$sql = ''; 
// lấy tin vip cùng loại theo xã wardid
			$db->sqlreset()
			->from(NV_PREFIXLANG . '_' . $module_data)
			->select('id, catid, title, showprice, alias, price, addtime, edittime, ordertime, admin_id, provinceid, districtid, wardid, way_id, address, homeimgfile, homeimgthumb, groupid') 
			->where($where . ' AND districtid = '.$data_content['districtid'].' AND wardid = '.$data_content['wardid']);
	$sql = $db->sql();
// lấy tin rao mới nhất cùng loại cùng xã wardid


// lấy tin vip cùng loại theo quận districtid

			$db->sqlreset()
			->from(NV_PREFIXLANG . '_' . $module_data)
			->select('id, catid, title, showprice, alias, price, addtime, edittime, ordertime, admin_id, provinceid, districtid, wardid, way_id, address, homeimgfile, homeimgthumb, groupid') 
			->where($where . ' AND wardid != '.$data_content['wardid'].' AND districtid = '.$data_content['districtid']);
	
	
// lấy tin rao mới nhất cùng loại cùng quận districtid

// lấy tin vip cùng loại theo thành phố provinceid

			$db->sqlreset()
			->from(NV_PREFIXLANG . '_' . $module_data)
			->select('id, catid, title, showprice, alias, price, addtime, edittime, ordertime, admin_id, provinceid, districtid, wardid, way_id, address, homeimgfile, homeimgthumb, groupid') 
			->where($where . ' AND wardid != '.$data_content['wardid'].' AND districtid != '.$data_content['districtid'].' AND provinceid = '.$data_content['provinceid']);
			
	$sql = $sql . ' UNION ' .$db->sql();	
// lấy tin rao mới nhất cùng loại cùng thành phố provinceid
// ---------------------------------------------------------
// tin mới cùng xã

	$db->sqlreset()
    ->select('id, catid, title, showprice, alias, price, addtime, edittime, ordertime, admin_id, provinceid, districtid, wardid, way_id, address, homeimgfile, homeimgthumb, groupid')
    ->from(NV_PREFIXLANG . '_' . $module_data)
    ->where($where_tinlammoi . ' AND districtid = '.$data_content['districtid'].' AND  wardid = '.$data_content['wardid'] );
	
	$sql = $sql . ' UNION ' .$db->sql();	
// tin mới cùng xã

// tin mới cùng huyện

	$db->sqlreset()
    ->select('id, catid, title, showprice, alias, price, addtime, edittime, ordertime, admin_id, provinceid, districtid, wardid, way_id, address, homeimgfile, homeimgthumb, groupid')
    ->from(NV_PREFIXLANG . '_' . $module_data)
    ->where($where_tinlammoi . ' AND wardid != '.$data_content['wardid'].' AND districtid = '.$data_content['districtid'] );
	
	$sql = $sql . ' UNION ' .$db->sql();	

// tin mới cùng huyện

// tin mới cùng tỉnh thành phố

	$db->sqlreset()
    ->select('id, catid, title, showprice, alias, price, addtime, edittime, ordertime, admin_id, provinceid, districtid, wardid, way_id, address, homeimgfile, homeimgthumb, groupid')
    ->from(NV_PREFIXLANG . '_' . $module_data)
    ->where($where_tinlammoi . ' AND wardid != '.$data_content['wardid'].' AND districtid != '.$data_content['districtid'].' AND provinceid = '.$data_content['provinceid'] );

// tin mới cùng tỉnh thành phố

// ------------------------------------- tin mới

// tin mới cùng xã

	$db->sqlreset()
    ->select('id, catid, title, showprice, alias, price, addtime, edittime, ordertime, admin_id, provinceid, districtid, wardid, way_id, address, homeimgfile, homeimgthumb, groupid')
    ->from(NV_PREFIXLANG . '_' . $module_data)
    ->where($where_tinmoi . '  AND districtid = '.$data_content['districtid'].' AND  wardid = '.$data_content['wardid'] );
	
	$sql = $sql . ' UNION ' .$db->sql();	
// tin mới cùng xã

// tin mới cùng huyện

	$db->sqlreset()
    ->select('id, catid, title, showprice, alias, price, addtime, edittime, ordertime, admin_id, provinceid, districtid, wardid, way_id, address, homeimgfile, homeimgthumb, groupid')
    ->from(NV_PREFIXLANG . '_' . $module_data)
    ->where($where_tinmoi . ' AND wardid != '.$data_content['wardid'].' AND districtid = '.$data_content['districtid'] );
	
	$sql = $sql . ' UNION ' .$db->sql();	

// tin mới cùng huyện

// tin mới cùng tỉnh thành phố

	$db->sqlreset()
    ->select('id, catid, title, showprice, alias, price, addtime, edittime, ordertime, admin_id, provinceid, districtid, wardid, way_id, address, homeimgfile, homeimgthumb, groupid')
    ->from(NV_PREFIXLANG . '_' . $module_data)
    ->where($where_tinmoi . ' AND wardid != '.$data_content['wardid'].' AND districtid != '.$data_content['districtid'].' AND provinceid = '.$data_content['provinceid'] );

// tin mới cùng tỉnh thành phố

//-------------------- tin mới
	$per_page = 5 ;
	$dem = 'SELECT COUNT(id) from (' . $sql . ' UNION ' .$db->sql().') as T ORDER BY ordertime DESC ';
	$sql = 'SELECT * from ('.$sql . ' UNION ' .$db->sql().') as T ORDER BY ordertime DESC limit '.($page - 1) * $per_page .', '.$per_page ;
	

	$num_items = $db->query($dem)->fetchColumn();
	$result = $db->query($sql); 

	while ($row = $result->fetch()) {
		$row['icon_block'] = $array_groups[$row['groupid']]['image'];
		$data_others[] = nv_data_show($row);
	}
	
// kết thúc tin mới cùng tỉnh thành phố	


// lấy thông tin dự án ra


if($data_content['projectid'] > 0)
{
	$du_an = $db->query('SELECT ten_du_an, alias , id, chuyen_muc FROM nv4_du_an_rows WHERE id ='.$data_content['projectid'])->fetch();
	
	// lấy thông tin chuyên mục ra
	$chuyen_muc = $db->query('SELECT alias , id FROM nv4_du_an_chuyen_muc WHERE id ='.$du_an['chuyen_muc'])->fetch();
	$data_content['link_duan'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=du-an&amp;' . NV_OP_VARIABLE . '=' . $chuyen_muc['alias'] . '/' . $du_an['alias'] . $global_config['rewrite_exturl'];
	$data_content['ten_duan'] = $du_an['ten_du_an'];
	
	
}
// lấy thông tin đơn vị ra

if($data_content['price_time'])
{
$data_content['price_time'] = $array_pricetype[$data_content['price_time']]['title'];
}
else
{
		$data_content['price_time'] = 'Thỏa thuận';
		$data_content['price'] = '';
}
$base_url = $array_cat[$data_content['catid']]['link'] . '/' . $data_content['alias'] . '-' . $data_content['id'];
$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
	
$checkss = md5($data_content['id'] . $client_info['session_id'] . $global_config['sitekey']);
$contents = nv_theme_bookhouse_detail($base_url,$tt_nhom,$data_content, $array_keyword, $data_others, $checkss, $content_comment, $generate_page);

$page_title = $data_content['title'];
$key_words = implode(', ', $key_words);
$description = $data_content['bodytext'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
