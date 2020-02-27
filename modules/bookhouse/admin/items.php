<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');


if($nv_Request->isset_request('id_tinhthanh', 'get'))
{
	$id_tinhthanh = $nv_Request->get_int('id_tinhthanh','get', 0);
	if($id_tinhthanh > 0)
	{
		$list_quan = $db->query('SELECT * FROM nv4_location_district WHERE status = 1 and provinceid = '. $id_tinhthanh .' ORDER BY weight ASC')->fetchAll();
		$html = '<option value=0>-- Chọn quận huyện --</option>';
					foreach($list_quan as $l)
					{
						$html .= '<option value='.$l['districtid'].'>'.$l['type'] . ' '. $l['title'].'</option>';
					}
		print $html;die;
	}

}

if($nv_Request->isset_request('id_quanhuyen', 'get'))
{
	$id_quanhuyen = $nv_Request->get_int('id_quanhuyen','get', 0);
	if($id_quanhuyen > 0)
	{//print($id_quanhuyen);die;
		$list_quan = $db->query('SELECT * FROM nv4_location_ward WHERE status = 1 and districtid = '. $id_quanhuyen .' ORDER BY title ASC')->fetchAll();
		$html = '<option value=0>-- Chọn xã phường --</option>';
					foreach($list_quan as $l)
					{
						$html .= '<option value='.$l['wardid'].'>'.$l['type'] . ' '. $l['title'].'</option>';
					}
		print $html;die;
	}

}

if($nv_Request->isset_request('id_tinrao', 'get'))
{
	$id_tinrao = $nv_Request->get_int('id_tinrao','get', 0);
	if($id_tinrao > 0)
	{
		$tinhthanh = $nv_Request->get_int('tinhthanh','get', 0);
		$quanhuyen = $nv_Request->get_int('quanhuyen','get', 0);
		$xaphuong = $nv_Request->get_int('xaphuong','get', 0);
		// UPDATE TỈNH THÀNH QUẬN HUYỆN TIN RAO
		$db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET provinceid = '. $tinhthanh .', districtid = '. $quanhuyen .', wardid = '. $xaphuong .' WHERE id = '.$id_tinrao);
		print(1);die;
	}

}




// xử lý đơn vị tin
if(false)
{
$list_t = $db->query('SELECT id, typeid, price, price_time FROM ' . NV_PREFIXLANG . '_' . $module_data)->fetchAll();

foreach($list_t as $row)
{
	// CẬP NHẬT LẠI GIÁ 
	// NẾU LÀ typeid LÀ NHÀ ĐÂT BÁN = 1
	if($row['typeid'] == 1 and $row['price'] > 0)
	{
		// ĐƠN VỊ TỈ
		if($row['price'] >= 1000000000)
		{
		  $row['price'] = $row['price']/1000000000;
		 
		  $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET price = '. $row['price'] .', price_time = 3  WHERE id = '.$row['id']);
		}
		elseif($row['price'] >= 1000000){
		
			$row['price'] = $row['price']/1000000;
		  $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET price = '. $row['price'] .', price_time = 2  WHERE id = '.$row['id']);
		
		}
	}
	// NẾU LÀ typeid LÀ NHÀ ĐÂT THUÊ = 2
	if($row['typeid'] == 2 and $row['price'] > 0)
	{
		// ĐƠN VỊ TRIỆU/THÁNG
		if($row['price'] >= 1000000)
		{
		  $row['price'] = $row['price']/1000000;
		 
		  $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET price = '. $row['price'] .', price_time = 5  WHERE id = '.$row['id']);
		}
		elseif($row['price'] >= 10000){
			// TRĂM NGHÌN/THÁNG
			$row['price'] = $row['price']/10000;
		  $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET price = '. $row['price'] .', price_time = 4  WHERE id = '.$row['id']);
		
		}
	}
}

}
// kết thúc xử lý đơn vị tin

$duplicate = $nv_Request->isset_request('duplicate', 'get');
$queue = $nv_Request->isset_request('queue', 'get');
$queue_url = $queue ? '&queue=1' : '';
$allow_province = '';
$currentpath = NV_BASE_SITEURL . NV_UPLOADS_DIR;

// change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);
    $content = 'NO_' . $id;
    
    $query = 'SELECT status_admin FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $id;
    $row = $db->query($query)->fetch();
    if (isset($row['status_admin'])) {
        $status = ($row['status_admin']) ? 0 : 1;
        $query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET status_admin=' . intval($status) . ' WHERE id=' . $id;
        $db->query($query);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

$id_block_content = $array_block_cat_module = array();
$sql = 'SELECT bid, adddefault, title, prior FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
$result = $db->query($sql);
while (list ($bid_i, $adddefault_i, $title_i, $prior_i) = $result->fetch(3)) {
    $array_block_cat_module[$bid_i] = array(
        'title' => $title_i,
        'prior' => $prior_i
    );
    if ($adddefault_i) {
        $id_block_content[] = $bid_i;
    }
}

// List cat
$listcat = nv_listcats();
if (count($listcat) == 0) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat');
    die();
}

$location = new Location();
$country_id = 1; // Viet Nam
$array_province = $location->getArrayProvince('', $country_id);

$array_province_add_item = $array_province_pub_item = $array_province_edit_item = $array_province_app_item = $array_province_del_item = array();

foreach ($array_province as $provinceid => $array_value) {
    $check_add_item = $check_pub_item = $check_edit_item = $check_del_item = $check_app_item = false;
    if (defined('NV_IS_ADMIN_MODULE')) {
        $check_add_item = $check_pub_item = $check_edit_item = $check_app_item = $check_del_item = true;
    } elseif (isset($array_province_admin[$admin_id][$provinceid])) {
        if ($array_province_admin[$admin_id][$provinceid]['admin'] == 1) {
            $check_add_item = $check_pub_item = $check_edit_item = $check_app_item = $check_del_item = true;
        } else {
            if ($array_province_admin[$admin_id][$provinceid]['add_item'] == 1) {
                $check_add_item = true;
            }
            
            if ($array_province_admin[$admin_id][$provinceid]['pub_item'] == 1) {
                $check_pub_item = true;
            }
            
            if ($array_province_admin[$admin_id][$provinceid]['app_item'] == 1) {
                $check_app_item = true;
            }
            
            if ($array_province_admin[$admin_id][$provinceid]['edit_item'] == 1) {
                $check_edit_item = true;
            }
            
            if ($array_province_admin[$admin_id][$provinceid]['del_item'] == 1) {
                $check_del_item = true;
            }
        }
    }
    if ($check_add_item) {
        $array_province_add_item[] = $provinceid;
    }
    
    if ($check_pub_item) {
        $array_province_pub_item[] = $provinceid;
    }
    if ($check_app_item) {
        $array_province_app_item[] = $provinceid;
    }
    
    if ($check_edit_item) {
        $array_province_edit_item[] = $provinceid;
    }
    
    if ($check_del_item) {
        $array_province_del_item[] = $provinceid;
    }
}

// Xoa doi tuong
if ($nv_Request->isset_request('del', 'post,get')) {
    $id = $nv_Request->get_int('id', 'post,get', 0);
    $listid = $nv_Request->get_string('listid', 'post,get', '');
    
    if ($id and empty($listid)) { 
        if (nv_admin_del_items($id)) {
            $nv_Cache->delMod($module_name);
            nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['logs_delete_items'], '', $admin_info['userid']);
            die('OK');
        }
    }
    die('NO');
} elseif ($nv_Request->isset_request('delete_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);
    
    if (! empty($array_id)) {
        foreach ($array_id as $id) {
            nv_admin_del_items($id);
        }
        $nv_Cache->delMod($module_name);
        die('OK');
    }
    die('NO');
}elseif ($nv_Request->isset_request('duyet_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);
    
    if (! empty($array_id)) {
        foreach ($array_id as $id) {
			// duyệt tin
            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET is_queue = 0 , admin_duyet = 1 WHERE id = ' . $id); 
        }
        $nv_Cache->delMod($module_name);
        die('OK');
    }
    die('NO');
}

if ($nv_Request->isset_request('add', 'get') or $nv_Request->isset_request('edit', 'get')) {
    $id = $nv_Request->get_int('id', 'get', 0);
    
    // Neu sua ma khong co id thi khong cho phep
    if ($nv_Request->isset_request('edit', 'get') and ! $id) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items' . $queue_url);
        die();
    }
    
    $page_title = $id ? $lang_module['items_edit'] : $lang_module['items_add'];
    $data = $room_detail = $array_keywords_old = array();
    
    if (! $id) {
        $data['title'] = '';
        $data['alias'] = '';
        $data['code'] = '';
        $data['catid'] = 0;
        $data['room'] = array();
        $data['area'] = 0;
        $data['size_v'] = 0;
        $data['size_h'] = 0;
        $data['price'] = 0;
        $data['price_time'] = 0;
        $data['money_unit'] = '';
        $data['homeimgfile'] = '';
        $data['front'] = 0;
        $data['road'] = 0;
        $data['so_tang'] = 0;
        $data['so_phong'] = 0;
        $data['structure'] = '';
        $data['type'] = '';
        $data['hometext'] = '';
        $data['bodytext'] = '';
        $data['typeid'] = 0;
        $data['projectid'] = 0;
        $data['groupid'] = '';
        $data['way_id'] = 0;
        $data['legal_id'] = 0;
        $data['maps'] = '';
        $data['inhome'] = 1;
        $data['allowed_comm'] = 6;
        $data['showprice'] = 1;
        $data['keywords'] = '';
        $data['keywords_old'] = '';
        $data['provinceid'] = 0;
        $data['districtid'] = 0;
        $data['wardid'] = 0;
        $data['status'] = 1;
        $data['admin_duyet'] = 1;
        $data['is_queue'] = 0;
        $data['queue_reasonid'] = 0;
        $data['queue_reason'] = '';
        $data['queue_time'] = 0;
        $data['queue_userid'] = 0;
        $data['exptime'] = 0;
        $data['ordertime'] = NV_CURRENTTIME;
        $data['contact_fullname'] = '';
        $data['contact_email'] = '';
        $data['contact_phone'] = '';
        $data['contact_address'] = '';
        $array_projects = $array_price_time = $listcat = array();

        $action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items&add' . $queue_url;
        $allow_province = ! empty($array_province_add_item) ? implode(',', $array_province_add_item) : '';
        
        $id_block_content = array();
    } else {
        $action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items&edit&id=' . $id . $queue_url;
        $allow_province = ! empty($array_province_edit_item) ? implode(',', $array_province_edit_item) : '';
        
        // Get data items
        $data = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id = ' . $id)->fetch();
        
        // Kiem tra quyen sua tin
       // if (! in_array($data['provinceid'], $array_province_edit_item)) {
        if (false) {
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items');
            die();
        }
        
        // Get keywords
        $_query = $db->query('SELECT tid, keyword FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE id=' . $data['id'] . ' ORDER BY keyword ASC');
        while ($row = $_query->fetch()) {
            $array_keywords_old[$row['tid']] = $row['keyword'];
        }
        $data['keywords'] = implode(', ', $array_keywords_old);
        $data['keywords_old'] = $data['keywords'];
        
        if ($data['is_queue']) {
            nv_status_notification(NV_LANG_DATA, $module_name, 'items_new', $data['id']);
        }
        
        $id_block_content = array();
        $sql = 'SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where id=' . $data['id'];
        $result = $db->query($sql);
        while (list ($bid_i) = $result->fetch(3)) {
            $id_block_content[] = $bid_i;
        }
        
        // Lich su kiem duyet
        $array_users = $row['queue_logs'] = array();
        if ($data['is_queue'] != 0) {
            $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_queue_logs WHERE itemid=' . $data['id'] . ' ORDER BY addtime DESC');
            while ($_row = $result->fetch()) {
                if($_row['userid'] > 0){
                    if (! isset($array_users[$_row['userid']])) {
                        $user_info = $db->query('SELECT userid, first_name, last_name, username FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $_row['userid'])->fetch();
                        $array_users[$user_info['userid']] = $user_info;
                    } else {
                        $user_info = $array_users[$_row['userid']];
                    }
                    $_row['name'] = nv_show_name_user($user_info['first_name'], $user_info['last_name'], $user_info['username']);
                }else{
                    $_row['name'] = $lang_module['system'];
                }

                $data['queue_logs'][] = $_row;
            }
        }
        
        if (! empty($data['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR)) {
            $currentpath = NV_UPLOADS_DIR . '/' . $module_upload . '/' . dirname($data['homeimgfile']);
        }

// Danh sách catid thuộc Hình thức
        $array_catid = array();
        $result = $db->query('SELECT catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_type_catid WHERE typeid=' . $data['typeid']);
        while (list ($catid) = $result->fetch(3)) {
            $array_catid[] = $catid;
        }
        $array_price_time = $listcat = nv_listcats($data['catid'], 0, $array_catid);
$array_price_time = nv_get_pricetype($data['typeid']);
$array_projects = nv_get_projetcs($data['provinceid'], $data['districtid'], $data['wardid']);
    }
    
    // Neu la nguoi quan ly theo dia diem va khong co dia diem nao dc cap phep
    if (! $NV_IS_ADMIN_MODULE and ! $NV_IS_ADMIN_FULL_MODULE and empty($allow_province)) {
        $contents = nv_theme_alert($lang_module['admin_empty_province_title'], $lang_module['admin_empty_province_message']);
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_admin_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    }
    
    $error = '';
    $data['queue'] = 0;
   
    // Group list
    $groups_list = nv_groups_list();
    
    if ($nv_Request->isset_request('submit', 'post')) {
        $data['title'] = $nv_Request->get_string('title', 'post', '');
        $alias = nv_substr($nv_Request->get_title('alias', 'post', '', 1), 0, 255);
        $data['alias'] = ($alias == '') ? change_alias($data['title']) : change_alias($alias);
        $data['code'] = $nv_Request->get_string('code', 'post', '');
        $data['catid'] = $nv_Request->get_int('catid', 'post', 0);
        $data['room'] = $nv_Request->get_typed_array('room', 'post', 'string');
        $data['area'] = $nv_Request->get_string('area', 'post', '');
        $data['area'] = str_replace(',', '.', $data['area']);
        $data['area'] = doubleval(preg_replace('/[^0-9\.]/', '', $data['area']));
        $data['size_v'] = $nv_Request->get_string('size_v', 'post', '');
        $data['size_v'] = str_replace(',', '.', $data['size_v']);
        $data['size_v'] = doubleval(preg_replace('/[^0-9\.]/', '', $data['size_v']));
        $data['size_h'] = $nv_Request->get_string('size_h', 'post', '');
        $data['size_h'] = str_replace(',', '.', $data['size_h']);
        $data['size_h'] = doubleval(preg_replace('/[^0-9\.]/', '', $data['size_h']));
        $data['price'] = $nv_Request->get_float('price', 'post', '');
		$data['price'] = str_replace(',', '.', $data['price']);
       // $data['price'] = preg_replace('/[^0-9]/', '', $data['price']);
        $data['price_time'] = $nv_Request->get_int('price_time', 'post', 0);
        $data['money_unit'] = $nv_Request->get_string('money_unit', 'post', 'vnd');
        $data['homeimgfile'] = $nv_Request->get_string('image', 'post', '');
        $data['homeimgalt'] = $nv_Request->get_string('homeimgalt', 'post', '');
        $data['front'] = $nv_Request->get_string('front', 'post', '');
        $data['front'] = str_replace(',', '.', $data['front']);
        $data['road'] = $nv_Request->get_string('road', 'post', '');
        $data['road'] = str_replace(',', '.', $data['road']);
		$data['so_tang'] = $nv_Request->get_int('so_tang', 'post', 0);
		$data['so_phong'] = $nv_Request->get_int('so_phong', 'post', 0);
        $data['structure'] = $nv_Request->get_textarea('structure', '', NV_ALLOWED_HTML_TAGS);
        $data['type'] = $nv_Request->get_textarea('type', '', NV_ALLOWED_HTML_TAGS);
        $data['hometext'] = $nv_Request->get_string('hometext', 'post', '');
        $data['hometext'] = nv_nl2br(nv_htmlspecialchars(strip_tags($data['hometext'])), '<br />');
        $data['bodytext'] = $nv_Request->get_editor('bodytext', '', NV_ALLOWED_HTML_TAGS);
        $data['typeid'] = $nv_Request->get_int('typeid', 'post', 0);
        $data['projectid'] = $nv_Request->get_int('projectid', 'post', 0);
        $data['way_id'] = $nv_Request->get_int('way', 'post', 0);
        $data['legal_id'] = $nv_Request->get_int('legal', 'post', 0);
        $data['provinceid'] = $nv_Request->get_int('provinceid', 'post', 0);
        $data['districtid'] = $nv_Request->get_int('districtid', 'post', 0);
        $data['wardid'] = $nv_Request->get_int('wardid', 'post', 0);
        $data['address'] = $nv_Request->get_string('address', 'post', '');
        $data['maps'] = '';
        if ($array_config['allow_maps']) {
            $data['maps'] = $nv_Request->get_array('maps', 'post', array());
            $data['maps'] = serialize($data['maps']);
        }
        $data['inhome'] = (int) $nv_Request->get_bool('inhome', 'post');
        $data['queue'] = $nv_Request->get_int('queue', 'post', 0);
        $data['queue_reasonid'] = $nv_Request->get_int('queue_reasonid', 'post', 0);
        $data['queue_reason'] = $nv_Request->get_textarea('queue_reason', '');
        $_groups_post = $nv_Request->get_array('allowed_comm', 'post', array());
        $data['allowed_comm'] = ! empty($_groups_post) ? implode(',', nv_groups_post(array_intersect($_groups_post, array_keys($groups_list)))) : '';
        $data['showprice'] = (int) $nv_Request->get_bool('showprice', 'post');
        $data['keywords'] = $nv_Request->get_array('keywords', 'post', '');
        $data['keywords'] = implode(', ', $data['keywords']);
        $data['id_block_content_post'] = array_unique($nv_Request->get_typed_array('bids', 'post', 'int', array()));
        
        $data['contact_fullname'] = $nv_Request->get_title('contact_fullname', 'post', '');
        $data['contact_email'] = $nv_Request->get_title('contact_email', 'post', '');
        $data['contact_phone'] = $nv_Request->get_title('contact_phone', 'post', '');
        $data['contact_address'] = $nv_Request->get_title('contact_address', 'post', '');
        
        if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('exptime', 'post'), $m)) {
            $hour = $nv_Request->get_int('exptime_hour', 'post', 0);
            $min = $nv_Request->get_int('exptime_min', 'post', 0);
            $data['exptime'] = mktime($hour, $min, 59, $m[2], $m[1], $m[3]);
        } else {
            $data['exptime'] = 0;
        }
        
        // Tu dong xac dinh keywords
        if ($data['keywords'] == '' and ! empty($array_config['auto_tags'])) {
            $keywords = ($data['hometext'] != '') ? $data['hometext'] : $data['bodytext'];
            $keywords = nv_get_keywords($keywords, 100);
            $keywords = explode(',', $keywords);
            
            // Ưu tiên lọc từ khóa theo các từ khóa đã có trong tags thay vì đọc từ từ điển
            $keywords_return = array();
            $sth = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id where keyword = :keyword');
            foreach ($keywords as $keyword_i) {
                $sth->bindParam(':keyword', $keyword_i, PDO::PARAM_STR);
                $sth->execute();
                if ($sth->fetchColumn()) {
                    $keywords_return[] = $keyword_i;
                    if (sizeof($keywords_return) > 20) {
                        break;
                    }
                }
            }
            
            if (sizeof($keywords_return) < 20) {
                foreach ($keywords as $keyword_i) {
                    if (! in_array($keyword_i, $keywords_return)) {
                        $keywords_return[] = $keyword_i;
                        if (sizeof($keywords_return) > 20) {
                            break;
                        }
                    }
                }
            }
            $data['keywords'] = implode(',', $keywords);
        }
       
        
        if (empty($error)) {
           
            $data['homeimgthumb'] = 0;
            if (! nv_is_url($data['homeimgfile']) and nv_is_file($data['homeimgfile'], NV_UPLOADS_DIR . '/' . $module_upload) === true) {
                $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/');
                $data['homeimgfile'] = substr($data['homeimgfile'], $lu);
                if (file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $data['homeimgfile'])) {
                    $data['homeimgthumb'] = 1;
                } else {
                    $data['homeimgthumb'] = 2;
                }
            } elseif (nv_is_url($data['homeimgfile'])) {
                $data['homeimgthumb'] = 3;
            } else {
                $data['homeimgfile'] = '';
            }
        //  die($data['homeimgfile']);
            if ($id > 0) {
                if ($data['queue'] == 1) {
                    $data['is_queue'] = 0;
                    $data['admin_duyet'] = 1;
                    $data['queue_time'] = NV_CURRENTTIME;
                    $data['queue_userid'] = $admin_info['userid'];
                    $data['queue_userid'] = $admin_info['userid'];
                    $data['ordertime'] = NV_CURRENTTIME;
                } elseif ($data['queue'] == 2) {
                    $data['is_queue'] = 2;
                }
                
				
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET
					title = :title,
					alias = :alias,
					catid = :catid,
					hometext = :hometext,
					bodytext = :bodytext,
					admin_id = :admin_id,
					edittime = ' . NV_CURRENTTIME . ',
					exptime = :exptime,
					code = :code,
					area = :area,
					size_v = :size_v,
					size_h = :size_h,
					price = :price,
				    price_time = :price_time,
					money_unit = :money_unit,
					typeid = :typeid,
					projectid = :projectid,
					way_id = :way_id,
					legal_id = :legal_id,
					homeimgfile = :homeimgfile,
					homeimgthumb = ' . $data['homeimgthumb'] . ',
					homeimgalt = :homeimgalt,
					front = :front,
					road = :road,
					so_tang = :so_tang,
					so_phong = :so_phong,
					structure = :structure,
				    type = :type,
					provinceid = :provinceid,
					districtid = :districtid,
					wardid = :wardid,
					address = :address,
					maps = :maps,
					inhome = :inhome,
					allowed_comm = :allowed_comm,
					showprice = :showprice,
					contact_fullname = :contact_fullname, 
				    contact_email = :contact_email, 
				    contact_phone = :contact_phone, 
				    contact_address = :contact_address,
					ordertime = :ordertime,
					admin_duyet = :admin_duyet,
					is_queue = :is_queue
					WHERE id = ' . $id . '';
                
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
                $stmt->bindParam(':alias', $data['alias'], PDO::PARAM_STR);
                $stmt->bindParam(':catid', $data['catid'], PDO::PARAM_INT);
                $stmt->bindParam(':hometext', $data['hometext'], PDO::PARAM_STR);
                $stmt->bindParam(':bodytext', $data['bodytext'], PDO::PARAM_STR);
                $stmt->bindParam(':admin_id', $admin_info['admin_id'], PDO::PARAM_INT);
                $stmt->bindParam(':exptime', $data['exptime'], PDO::PARAM_INT);
                $stmt->bindParam(':code', $data['code'], PDO::PARAM_STR);
                $stmt->bindParam(':area', $data['area'], PDO::PARAM_STR);
                $stmt->bindParam(':size_v', $data['size_v'], PDO::PARAM_STR);
                $stmt->bindParam(':size_h', $data['size_h'], PDO::PARAM_STR);
                $stmt->bindParam(':price', $data['price'], PDO::PARAM_STR);
                $stmt->bindParam(':price_time', $data['price_time'], PDO::PARAM_INT);
                $stmt->bindParam(':money_unit', $data['money_unit'], PDO::PARAM_STR);
                $stmt->bindParam(':way_id', $data['way_id'], PDO::PARAM_INT);
                $stmt->bindParam(':typeid', $data['typeid'], PDO::PARAM_INT);
                $stmt->bindParam(':projectid', $data['projectid'], PDO::PARAM_INT);
                $stmt->bindParam(':legal_id', $data['legal_id'], PDO::PARAM_INT);
                $stmt->bindParam(':homeimgfile', $data['homeimgfile'], PDO::PARAM_STR);
                $stmt->bindParam(':homeimgalt', $data['homeimgalt'], PDO::PARAM_STR);
                $stmt->bindParam(':front', $data['front'], PDO::PARAM_STR);
                $stmt->bindParam(':road', $data['road'], PDO::PARAM_STR);
                $stmt->bindParam(':so_tang', $data['so_tang'], PDO::PARAM_INT);
                $stmt->bindParam(':so_phong', $data['so_phong'], PDO::PARAM_INT);
                $stmt->bindParam(':structure', $data['structure'], PDO::PARAM_STR);
                $stmt->bindParam(':type', $data['type'], PDO::PARAM_STR);
                $stmt->bindParam(':provinceid', $data['provinceid'], PDO::PARAM_INT);
                $stmt->bindParam(':districtid', $data['districtid'], PDO::PARAM_INT);
                $stmt->bindParam(':wardid', $data['wardid'], PDO::PARAM_INT);
                $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
                $stmt->bindParam(':maps', $data['maps'], PDO::PARAM_STR);
                $stmt->bindParam(':inhome', $data['inhome'], PDO::PARAM_INT);
                $stmt->bindParam(':allowed_comm', $data['allowed_comm'], PDO::PARAM_INT);
                $stmt->bindParam(':showprice', $data['showprice'], PDO::PARAM_INT);
                $stmt->bindParam(':contact_fullname', $data['contact_fullname'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_email', $data['contact_email'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_phone', $data['contact_phone'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_address', $data['contact_address'], PDO::PARAM_STR);
                $stmt->bindParam(':ordertime', $data['ordertime'], PDO::PARAM_INT);
                $stmt->bindParam(':is_queue', $data['is_queue'], PDO::PARAM_INT);
                $stmt->bindParam(':admin_duyet', $data['admin_duyet'], PDO::PARAM_INT);
                
                if ($stmt->execute()) {
                    // Xu ly loai phong
                    if (! empty($data['room'])) {
                        foreach ($data['room'] as $rid => $r_num) {
                            $sql = '';
                            if (empty($r_num)) {
                                if (isset($room_detail[$rid])) {
                                    // Delete
                                    $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rooms_detail WHERE rid = ' . $rid;
                                }
                            } else {
                                if (isset($room_detail[$rid])) {
                                    // Update
                                    $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rooms_detail SET num = ' . $r_num . ' WHERE rid = ' . $rid . ' AND iid = ' . $id;
                                } else {
                                    // Insert
                                    $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rooms_detail VALUES( NULL, ' . $id . ', ' . $rid . ', ' . $r_num . ' )';
                                }
                            }
                            if (! empty($sql))
                                $db->query($sql);
                        }
                    }
                    
                    // Xoa file tam
                    nv_deletefile(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/tmp/' . $data['homeimgfile']);
                    
                    // Cap nhat lich su duyet tin
                    if ($data['queue'] > 0) {
                        if ($data['queue'] == 1) {
                            $queue = 1;
                        } elseif ($data['queue'] == 2) {
                            $queue = 0;
                        }
                        $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_queue_logs(itemid, queue, reasonid, reason, addtime, userid) VALUES (' . $id . ', ' . $queue . ', :reasonid, :reason, ' . NV_CURRENTTIME . ', ' . $admin_info['userid'] . ')');
                        $sth->bindParam(':reasonid', $data['queue_reasonid'], PDO::PARAM_INT);
                        $sth->bindParam(':reason', $data['queue_reason'], PDO::PARAM_STR);
                        $sth->execute();
                    }
                    
                    $nv_Cache->delMod($module_name);
                    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['logs_edit_items'], $data['title'], $admin_info['userid']);
                } else {
                    $error = $lang_module['error_database'];
                }
            } else {
                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (title, alias, catid, hometext, bodytext, admin_id, addtime, edittime, exptime, code, area, size_v, size_h, price, price_time, money_unit, typeid, projectid, way_id, legal_id, homeimgfile, homeimgthumb, 
                homeimgalt, front, road, so_tang, so_phong, structure, type, provinceid, districtid, wardid, address, maps, inhome, allowed_comm, hitstotal, showprice, contact_fullname, contact_email, contact_phone, contact_address, ordertime)
				VALUES (:title, :alias, :catid, :hometext, :bodytext, :admin_id, ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . ', :exptime,
				:code, :area, :size_v, :size_h, :price, :price_time, :money_unit, :typeid, :projectid, :way_id, :legal_id, :homeimgfile, ' . $data['homeimgthumb'] . ', :homeimgalt, :front, :road, :so_tang, :so_phong, :structure, :type, :provinceid, :districtid, :wardid, :address, :maps, :inhome,
				:allowed_comm, 0, :showprice, :contact_fullname, :contact_email, :contact_phone, :contact_address, :ordertime)';
                
                $data_insert = array();
                $data_insert['title'] = $data['title'];
                $data_insert['alias'] = $data['alias'];
                $data_insert['catid'] = $data['catid'];
                $data_insert['hometext'] = $data['hometext'];
                $data_insert['bodytext'] = $data['bodytext'];
                $data_insert['admin_id'] = $admin_info['admin_id'];
                $data_insert['exptime'] = $data['exptime'];
                $data_insert['code'] = $data['code'];
                $data_insert['area'] = $data['area'];
                $data_insert['size_v'] = $data['size_v'];
                $data_insert['size_h'] = $data['size_h'];
                $data_insert['price'] = $data['price'];
                $data_insert['price_time'] = $data['price_time'];
                $data_insert['money_unit'] = $data['money_unit'];
                $data_insert['typeid'] = $data['typeid'];
                $data_insert['projectid'] = $data['projectid'];
                $data_insert['way_id'] = $data['way_id'];
                $data_insert['legal_id'] = $data['legal_id'];
                $data_insert['homeimgfile'] = $data['homeimgfile'];
                $data_insert['homeimgalt'] = $data['homeimgalt'];
                $data_insert['front'] = $data['front'];
                $data_insert['road'] = $data['road'];
                $data_insert['so_tang'] = $data['so_tang'];
                $data_insert['so_phong'] = $data['so_phong'];
                $data_insert['structure'] = $data['structure'];
                $data_insert['type'] = $data['type'];
                $data_insert['provinceid'] = $data['provinceid'];
                $data_insert['districtid'] = $data['districtid'];
                $data_insert['wardid'] = $data['wardid'];
                $data_insert['address'] = $data['address'];
                $data_insert['maps'] = $data['maps'];
                $data_insert['inhome'] = $data['inhome'];
                $data_insert['allowed_comm'] = $data['allowed_comm'];
                $data_insert['showprice'] = $data['showprice'];
                $data_insert['contact_fullname'] = $data['contact_fullname'];
                $data_insert['contact_email'] = $data['contact_email'];
                $data_insert['contact_phone'] = $data['contact_phone'];
                $data_insert['contact_address'] = $data['contact_address'];
                $data_insert['ordertime'] = $data['ordertime'];
                
                $data['id'] = $db->insert_id($sql, 'id', $data_insert);
                
                if ($data['id'] > 0) {
                    // Xu ly loai phong
                    if (! empty($data['room'])) {
                        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rooms_detail VALUES( NULL, ' . $data['id'] . ', :room_id, :num )');
                        foreach ($data['room'] as $rid => $r_num) {
                            if (! empty($r_num)) {
                                $stmt->bindParam(':room_id', $rid, PDO::PARAM_STR);
                                $stmt->bindParam(':num', $r_num, PDO::PARAM_STR);
                                $stmt->execute();
                            }
                        }
                    }
                    
                    $nv_Cache->delMod($module_name);
                    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['logs_add_items'], $data['title'], $admin_info['userid']);
                } else {
                    $error = $lang_module['error_database'];
                }
            }
            
            if (empty($error)) {
                if ($data['keywords'] != $data['keywords_old']) {
                    $keywords = explode(',', $data['keywords']);
                    $keywords = array_map('strip_punctuation', $keywords);
                    $keywords = array_map('trim', $keywords);
                    $keywords = array_diff($keywords, array(
                        ''
                    ));
                    $keywords = array_unique($keywords);
                    
                    foreach ($keywords as $keyword) {
                        if (! in_array($keyword, $array_keywords_old)) {
                            $alias_i = ($array_config['tags_alias']) ? change_alias($keyword) : str_replace(' ', '-', $keyword);
                            $alias_i = nv_strtolower($alias_i);
                            $sth = $db->prepare('SELECT tid, alias, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags where alias= :alias OR FIND_IN_SET(:keyword, keywords)>0');
                            $sth->bindParam(':alias', $alias_i, PDO::PARAM_STR);
                            $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                            $sth->execute();
                            
                            list ($tid, $alias, $keywords_i) = $sth->fetch(3);
                            if (empty($tid)) {
                                $array_insert = array();
                                $array_insert['alias'] = $alias_i;
                                $array_insert['keyword'] = $keyword;
                                
                                $tid = $db->insert_id("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_tags (numnews, alias, description, image, keywords) VALUES (1, :alias, '', '', :keyword)", "tid", $array_insert);
                            } else {
                                if ($alias != $alias_i) {
                                    if (! empty($keywords_i)) {
                                        $keyword_arr = explode(',', $keywords_i);
                                        $keyword_arr[] = $keyword;
                                        $keywords_i2 = implode(',', array_unique($keyword_arr));
                                    } else {
                                        $keywords_i2 = $keyword;
                                    }
                                    if ($keywords_i != $keywords_i2) {
                                        $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET keywords= :keywords WHERE tid =' . $tid);
                                        $sth->bindParam(':keywords', $keywords_i2, PDO::PARAM_STR);
                                        $sth->execute();
                                    }
                                }
                                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET numnews = numnews+1 WHERE tid = ' . $tid);
                            }
                            
                            // insert keyword for table _tags_id
                            try {
                                $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id (id, tid, keyword) VALUES (' . $data['id'] . ', ' . intval($tid) . ', :keyword)');
                                $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                                $sth->execute();
                            } catch (PDOException $e) {
                                $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id SET keyword = :keyword WHERE id = ' . $data['id'] . ' AND tid=' . intval($tid));
                                $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                                $sth->execute();
                            }
                            unset($array_keywords_old[$tid]);
                        }
                    }
                    
                    foreach ($array_keywords_old as $tid => $keyword) {
                        if (! in_array($keyword, $keywords)) {
                            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET numnews = numnews-1 WHERE tid = ' . $tid);
                            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE id = ' . $data['id'] . ' AND tid=' . $tid);
                        }
                    }
                }
                
                // nhom bat dong san
                $id_block_content_new = array_diff($data['id_block_content_post'], $id_block_content);
                $id_block_content_del = array_diff($id_block_content, $data['id_block_content_post']);
                
                $array_block_fix = array();
                foreach ($id_block_content_new as $bid_i) {
                    nv_item_group($bid_i, $data['id']);
                    $array_block_fix[] = $bid_i;
                }
                foreach ($id_block_content_del as $bid_i) {
                    nv_item_group($bid_i, $data['id'], 1);
                    $array_block_fix[] = $bid_i;
                }
                
                $array_block_fix = array_unique($array_block_fix);
                foreach ($array_block_fix as $bid_i) {
                    nv_fix_block($bid_i, false);
                }
                
                // Cập nhật độ ưu tin cho tin bđs
                $array_prior = array();
                if (! empty($data['id_block_content_post'])) {
                    foreach ($data['id_block_content_post'] as $bid_i) {
                        $array_prior[] = $array_block_cat_module[$bid_i]['prior'];
                    }
                }
                
                $prior = ! empty($array_prior) ? max($array_prior) : 0;
                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET prior=' . $prior . ' WHERE id=' . $data['id']);
                
                // Cap nhat ma tin dang
                if ($array_config['code_auto']) {
                    $auto_code = '';
                    if (empty($data['code'])) {
                        $i = 1;
                        $code_format = ! empty($array_config['code_format']) ? $array_config['code_format'] : 'TD%06s';
                        $auto_code = vsprintf($code_format, $data['id']);
                        
                        $stmt = $db->prepare('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE code= :code');
                        $stmt->bindParam(':code', $auto_code, PDO::PARAM_STR);
                        $stmt->execute();
                        while ($stmt->rowCount()) {
                            $auto_code = vsprintf($code_format, ($data['id'] + $i ++));
                        }
                        
                        $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET code= :code WHERE id=' . $data['id']);
                        $stmt->bindParam(':code', $auto_code, PDO::PARAM_STR);
                        $stmt->execute();
                    }
                }
                
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items' . $queue_url);
                die();
            }
        }
    }
    
    // Editor
    if (defined('NV_EDITOR'))
        require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
    
    $data['bodytext'] = htmlspecialchars(nv_editor_br2nl($data['bodytext']));
    if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
        $data['bodytext'] = nv_aleditor('bodytext', '100%', '300px', $data['bodytext']);
    } else {
        $data['bodytext'] = '<textarea style="width:100%;height:300px" name="bodytext">' . $data['bodytext'] . '</textarea>';
    }
    
    
    $data['maps'] = ! empty($data['maps']) ? unserialize($data['maps']) : array();
    
    if (! empty($data['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $data['homeimgfile'])) {
        $data['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data['homeimgfile'];
    }
    
    if ($data['is_queue'] and in_array($data['provinceid'], $array_province_app_item)) {
        $_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_queue_reason WHERE status=1';
        $array_reason = $nv_Cache->db($_sql, 'id', $module_name);
    }
    
    $data['front'] = ! empty($data['front']) ? $data['road'] : '';
    $data['road'] = ! empty($data['road']) ? $data['road'] : '';
    $data['so_tang'] = $data['so_tang'] == 0 ? '' : $data['so_tang'];
    $data['so_phong'] = $data['so_phong'] == 0 ? '' : $data['so_phong'];
	
    $data['exptime_f'] = ! empty($data['exptime']) ? nv_date('d/m/Y', $data['exptime']) : '';
    $data['queue_reason_style'] = $data['queue'] != 2 ? 'style="display: none"' : '';
    
    if (! empty($data['homeimgfile']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $data['homeimgfile'])) {
        $data['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data['homeimgfile'];
    }
    
    $xtpl = new XTemplate('items.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('ACTION', $action);
    $xtpl->assign('BODYTEXT', $data['bodytext']);
    $xtpl->assign('UPLOAD_DIR', NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload);
    $xtpl->assign('TEMPLATE', $global_config['module_theme']);
    $xtpl->assign('CURRENTPATH', $currentpath);
    $xtpl->assign('DES_POINT', $array_config['dec_point']);
    $xtpl->assign('THOUSANDS_SEP', $array_config['thousands_sep']);
    
    // List cat
    foreach ($listcat as $cat) {
        $xtpl->assign('CAT', $cat);
        $xtpl->parse('main.cat');
    }
    
    // allowed comm
    $allowed_comm = explode(',', $data['allowed_comm']);
    foreach ($groups_list as $_group_id => $_title) {
        $xtpl->assign('ALLOWED_COMM', array(
            'value' => $_group_id,
            'checked' => in_array($_group_id, $allowed_comm) ? ' checked="checked"' : '',
            'title' => $_title
        ));
        $xtpl->parse('main.allowed_comm');
    }
    
    // Keywords
    if (! empty($data['keywords'])) {
        $keywords_array = explode(',', $data['keywords']);
        foreach ($keywords_array as $keywords) {
            $xtpl->assign('KEYWORDS', $keywords);
            $xtpl->parse('main.keywords');
        }
    }
    
    if (! empty($array_type)) {
        foreach ($array_type as $type) {
            $type['selected'] = $type['id'] == $data['typeid'] ? 'selected="selected"' : '';
            $xtpl->assign('TYPE', $type);
            $xtpl->parse('main.type');
        }
    }
    
    if (! empty($array_projects)) {
        foreach ($array_projects as $projects) {
            $projects['selected'] = $projects['id'] == $data['projectid'] ? 'selected="selected"' : '';
            $xtpl->assign('PROJECTS', $projects);
            $xtpl->parse('main.projects.projects');
        }
    }
    
    if (! empty($array_way)) {
        foreach ($array_way as $way) {
            $way['selected'] = $way['id'] == $data['way_id'] ? 'selected="selected"' : '';
            $xtpl->assign('WAY', $way);
            $xtpl->parse('main.way');
        }
    }
    
    if (! empty($array_legal)) {
        foreach ($array_legal as $legal) {
            $legal['selected'] = $legal['id'] == $data['legal_id'] ? 'selected="selected"' : '';
            $xtpl->assign('LEGAL', $legal);
            $xtpl->parse('main.legal');
        }
    }
    
    foreach ($array_money_unit as $key => $value) {
        $sl = $key == $data['money_unit'] ? 'selected="selected"' : '';
        $xtpl->assign('UNIT', array(
            'key' => $key,
            'value' => $value,
            'selected' => $sl
        ));
        $xtpl->parse('main.money_unit');
    }
    
    if (! empty($error)) {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }
    
    $data['area'] = ! empty($data['area']) ? $data['area'] : '';
    $data['size_v'] = ! empty($data['size_v']) ? $data['size_v'] : '';
    $data['size_h'] = ! empty($data['size_h']) ? $data['size_h'] : '';
    $data['inhome'] = $data['inhome'] ? 'checked="checked"' : '';
    $data['allowed_comm'] = $data['allowed_comm'] ? 'checked="checked"' : '';
    $data['showprice'] = $data['showprice'] ? 'checked="checked"' : '';
    
    if (! empty($data['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $data['homeimgfile'])) {
        $data['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data['homeimgfile'];
    }
    
    $xtpl->assign('DATA', $data);
    
    if (empty($data['alias'])) {
        $xtpl->parse('main.change_alias');
    }
    
    $location = new Location();
    $location->set('AllowProvince', $allow_province);
    $location->set('IsDistrict', 1);
    $location->set('IsWard', 1);
    $location->set('SelectProvinceid', $data['provinceid']);
    $location->set('SelectDistrictid', $data['districtid']);
    $location->set('SelectWardid', $data['wardid']);
    $location->set('BlankTitleProvince', 1);
    $location->set('BlankTitleDistrict', 1);
    $location->set('BlankTitleWard', 1);
    $location->set('ColClass', 'col-xs-24 col-sm-8 col-md-8');
    $xtpl->assign('LOCATION', $location->buildInput());
    
    if ($array_config['allow_maps']) {
        if (! empty($array_config['maps_appid'])) {
            $xtpl->assign('MAPS_APPID', $array_config['maps_appid']);
            $xtpl->parse('main.maps');
        } else {
            $xtpl->parse('main.required_maps_appid');
        }
    }
    
    if (sizeof($array_block_cat_module)) {
        foreach ($array_block_cat_module as $bid_i => $block) {
            $xtpl->assign('BLOCKS', array(
                'title' => $block['title'],
                'bid' => $bid_i,
                'checked' => in_array($bid_i, $id_block_content) ? 'checked="checked"' : ''
            ));
            $xtpl->parse('main.block_cat.loop');
        }
        $xtpl->parse('main.block_cat');
    }
    
    if ($array_config['sizetype'] == 0) {
        $xtpl->parse('main.area');
    } elseif ($array_config['sizetype'] == 1) {
        $xtpl->parse('main.size');
    }
    
    foreach ($array_price_time as $index => $value) {
        $sl = $index == $data['price_time'] ? 'selected="selected"' : '';
        $xtpl->assign('PRICETIME', array(
            'index' => $index,
            'value' => $value['title'],
            'selected' => $sl
        ));
        $xtpl->parse('main.price_time');
    }
    
    $data['exptime_hour'] = ! empty($data['exptime']) ? nv_date('H', $data['exptime']) : - 1;
    for ($i = 0; $i <= 23; $i ++) {
        $sl = $i == $data['exptime_hour'] ? 'selected="selected"' : '';
        $xtpl->assign('HOUR', array(
            'index' => $i,
            'selected' => $sl
        ));
        $xtpl->parse('main.exptime_hour');
    }
    
    $data['exptime_min'] = ! empty($data['exptime']) ? nv_date('i', $data['exptime']) : - 1;
    for ($i = 1; $i <= 59; $i ++) {
        $sl = $i == $data['exptime_min'] ? 'selected="selected"' : '';
        $xtpl->assign('MIN', array(
            'index' => $i,
            'selected' => $sl
        ));
        $xtpl->parse('main.exptime_min');
    }
    
    if ($data['is_queue'] or !$data['admin_duyet'] and in_array($data['provinceid'], $array_province_app_item)) {
        $array_queue_action = array(
            0 => $lang_module['queue_action_0'],
            1 => $lang_module['queue_action_1'],
            2 => $lang_module['queue_action_2']
        );
        foreach ($array_queue_action as $index => $value) {
            $sl = $index == $data['queue'] ? 'checked="checked"' : '';
            $xtpl->assign('QUEUE_ACTION', array(
                'index' => $index,
                'value' => $value,
                'checked' => $sl
            ));
            $xtpl->parse('main.queue.queue_action');
        }
        
        if (! empty($array_reason)) {
            foreach ($array_reason as $reason) {
                $xtpl->assign('REASON', $reason);
                $xtpl->parse('main.queue.reason');
            }
        }
        
        if (! empty($data['queue_logs'])) {
            foreach ($data['queue_logs'] as $queue_logs) {
                $queue_logs['type'] = $lang_module['queue_type_' . $queue_logs['queue']];
                $queue_logs['reasonid'] = ! empty($queue_logs['reasonid']) ? $array_reason[$queue_logs['reasonid']]['title'] : '-';
                $queue_logs['addtime'] = nv_date('H:i d/m/Y', $queue_logs['addtime']);
                $xtpl->assign('QUEUE_LOGS', $queue_logs);
                $xtpl->parse('main.queue.queue_logs.loop');
            }
            $xtpl->parse('main.queue.queue_logs');
        }
        
        $xtpl->parse('main.queue');
    }
    
    if ($array_config['allow_contact_info']) {
        $xtpl->parse('main.contact_info');
    }
    
    if ($array_config['code_auto']) {
        $xtpl->parse('main.code_auto');
    }
    
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    
    $set_active_op = 'items&add';
    
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
    
    die();
} else {
    $is_search = false;
    $where = $status = '';
	
	if($queue)
	{
		 $status = ' AND is_queue= 0  AND admin_duyet = 0';
	}
	else if($duplicate)
	{
		$status = ' AND is_queue > 0  AND admin_duyet = 0';
	}
	else
	{
		 $status = ' AND is_queue=0 AND admin_duyet = 1';
	}
    $array_data = array();
  
    $array_search = array();
    $array_search['keyword'] = $nv_Request->get_title('keyword', 'get', '');
    $array_search['catid'] = $nv_Request->get_int('catid', 'get', 0);
    $array_search['status'] = $nv_Request->get_int('status', 'get', - 1);
    
    if (! empty($array_search['keyword'])) {
        $where .= ' AND title like "%' . $array_search['keyword'] . '%" OR code like "%' . $array_search['keyword'] . '%" OR hometext like "%' . $array_search['keyword'] . '%" OR bodytext like "%' . $array_search['keyword'] . '%"';
    }
    
    if ($array_search['catid'] > 0) {
        $where .= ' AND catid = ' . $array_search['catid'];
    }
    
    if ($array_search['status'] >= 0) {
        $status = ' AND status = ' . $array_search['status'];
    }
    
    // List items
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items';
    if ($queue) {
        $base_url .= '&queue';
    }
    
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data)
        ->where('1=1 ' . $status . $where);
    $num_items = $db->query($db->sql())
        ->fetchColumn();
    
    $page = $nv_Request->get_int('page', 'get', 1);
    $per_page = 30;
    
    $db->select('id, title, alias, catid, price, provinceid, districtid, wardid, money_unit, status, is_queue, status_admin, addtime, address')
        ->order('addtime DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
   // die($db->sql());
    $result2 = $db->query($db->sql());
   
    while ($row = $result2->fetch()) {
        $array_data[$row['id']] = $row;
    }
    
    $xtpl = new XTemplate('items_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('BASE_URL', $base_url);
    $xtpl->assign('BASE_URL', $base_url);
    
    // List cat
    foreach ($listcat as $cat) {
        $xtpl->assign('CAT', array(
            'key' => $cat['id'],
            'title' => $cat['name'],
            'selected' => $cat['id'] == $array_search['catid'] ? 'selected="selected"' : ''
        ));
        $xtpl->parse('main.category');
    }
    
    if (! empty($array_data)) {
        $location = new Location();
        $array_province_display_item = $array_province_edit_item + $array_province_del_item;
        $array_province_display_item = array_unique($array_province_display_item);
		$a =1;
        foreach ($array_data as $row) {
            if (defined('NV_IS_SPADMIN') or in_array($row['provinceid'], $array_province_display_item)) {
                $row['price'] = ! empty($row['price']) ? $row['price'] : $lang_module['items_price_contact'];
                $row['cattitle'] = $listcat[$row['catid']]['title'];
                $row['caturl'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=items&amp;catid=' . $row['catid'];
                $row['location'] = $location->locationString($row['provinceid'], $row['districtid'], $row['wardid']);
                $row['addtime'] = nv_date('H:i d/m/Y', $row['addtime']);
                $row['edit_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=items&amp;edit&amp;id=' . $row['id'] . $queue_url;
                $row['view_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $listcat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
                $row['images_link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=images&amp;rows_id=' . $row['id'];
                $row['images_count'] = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE rows_id=' . $row['id'])->fetchColumn();
                
                $xtpl->assign('CHECK', $row['status_admin'] == 1 ? 'checked' : '');
                $xtpl->assign('DATA', $row);
                
                //if (in_array($row['provinceid'], $array_province_edit_item)) {
                if (true) {
                    $xtpl->parse('main.loop.url_edit');
                } else {
                    $xtpl->parse('main.loop.label_edit');
                }
                
               // if (in_array($row['provinceid'], $array_province_del_item)) {
                if (true) {
                    $xtpl->parse('main.loop.url_del');
                } else {
                    $xtpl->parse('main.loop.label_del');
                }
				
				if($queue)
				{				
					// lấy tất cả tỉnh thành ra
					$list_tinh = $db->query('SELECT * FROM nv4_location_province WHERE status = 1 ORDER BY weight ASC')->fetchAll();
					foreach($list_tinh as $l)
					{
						if($l['provinceid'] == $row['provinceid'])
						$l['selected'] = 'selected=selected';
						else $l['selected'] = '';
						$xtpl->assign('l', $l);
						$xtpl->parse('main.loop.choduyet.tinh');
					}
					 
					
					if($row['districtid'] > 0 and $row['provinceid'] > 0)
					{
						// lấy tất cả quận thuộc tỉnh thành đó ra thành ra
						$list_quan = $db->query('SELECT * FROM nv4_location_district WHERE status = 1 and provinceid = '. $row['provinceid'] .' ORDER BY weight ASC')->fetchAll();
						foreach($list_quan as $l)
						{
							if($l['districtid'] == $row['districtid'])
							$l['selected'] = 'selected=selected';
							else $l['selected'] = '';
							$xtpl->assign('l', $l);
							$xtpl->parse('main.loop.choduyet.quan');
						}
					}
					
					if($row['districtid'] > 0 and $row['provinceid'] > 0 and $row['wardid'] > 0)
					{
						// lấy tất cả xã thuộc quận đó ra thành ra
						$list_xa = $db->query('SELECT * FROM nv4_location_ward WHERE status = 1 and districtid = '. $row['districtid'] .' ORDER BY title ASC')->fetchAll();
						foreach($list_xa as $l)
						{
							if($l['wardid'] == $row['wardid'])
							$l['selected'] = 'selected=selected';
							else $l['selected'] = '';
							$xtpl->assign('l', $l);
							$xtpl->parse('main.loop.choduyet.xa');
						}
					}
			$xtpl->parse('main.loop.choduyet');
				}
				
				
			
				
                $xtpl->parse('main.loop');
            }
        }
    }
    
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (! empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }
    
    $array_status = array(
        1 => $lang_module['status_1'],
        0 => $lang_module['status_0']
    );
    foreach ($array_status as $index => $value) {
        $sl = $index == $array_search['status'] ? 'selected="selected"' : '';
        $xtpl->assign('STATUS', array(
            'index' => $index,
            'value' => $value,
            'selected' => $sl
        ));
        $xtpl->parse('main.status');
    }
    
    $array_action = array(
        'delete_list_id' => $lang_global['delete'],
		'duyet_list_id' => 'Duyệt'
    );
    foreach ($array_action as $key => $value) {
        $xtpl->assign('ACTION', array(
            'key' => $key,
            'value' => $value
        ));
        $xtpl->parse('main.action');
    }
    
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    
    if ($queue) {
        $set_active_op = 'queue';
        $page_title = $lang_module['items_queue'];
    } else {
        $page_title = $lang_module['items'];
    }
    
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
