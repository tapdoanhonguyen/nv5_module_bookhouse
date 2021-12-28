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

	
if (! nv_user_in_groups($array_config['post_groups'])) {
    $url_redirect = $client_info['selfurl'];
    $url_back = NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($url_redirect);
    $contents = nv_theme_alert($lang_module['is_user_title'], $lang_module['is_user_content'], 'info', $url_back, $lang_module['login']);
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
 
if ($nv_Request->isset_request('get_alias', 'post')) {
    $title = $nv_Request->get_title('title', 'post', '');
    $alias = change_alias($title);
    die($alias);
}

// List cat
$listcat = nv_listcats();
if (count($listcat) == 0) {
    $contents = nv_theme_alert($lang_module['listcat_empty_title'], $lang_module['listcat_empty_content'], 'info');
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$uploadpath = nv_create_folder_member();

$id = $nv_Request->get_int('id', 'get', 0);

if (defined('NV_IS_USER')) {
    $count = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE admin_id=' . $user_info['userid'])->fetchColumn();
    if ($count >= $array_config['post_user_limit'] and empty($id)) {
        $url_back = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['items'];
        $contents = nv_theme_alert($lang_module['post_is_limit_title'], $lang_module['post_is_limit_content'], 'danger', $url_back);
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_site_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    }
}

$data = $room_detail = $array_keywords_old = array();
$array_id_old = array();
$array_id_new = array();
$array_otherimage = array();
$lang_module['error_required_otherimage'] = sprintf($lang_module['error_required_otherimage'], $array_config['post_image_limit']);
$lang_module['image_other_add_note'] = sprintf($lang_module['image_other_add_note'], $array_config['post_image_limit']);

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
    $data['typeid'] = 0;
    $data['projectid'] = 0;
    $data['homeimgfile'] = '';
    $data['front'] = 0;
    $data['floor'] = 0;
    $data['num_room'] = 0;
    $data['road'] = 0;
    $data['structure'] = '';
    $data['type'] = '';
    $data['hometext'] = '';
    $data['bodytext'] = '';
    $data['way_id'] = 0;
    $data['legal_id'] = 0;
    $data['maps'] = '';
    $data['inhome'] = 1;
    $data['allowed_comm'] = 6;
    $data['showprice'] = 1;
    $data['keywords'] = '';
    $data['keywords_old'] = '';
    $data['status'] = 1;
    $data['status_admin'] = 1;
    $data['is_queue'] = 0;
    $data['provinceid'] = 0;
    $data['districtid'] = 0;
    $data['wardid'] = 0;
    $data['otherimage'] = '';
    $data['exptime'] = 0;
    $data['requeue'] = 0;
    $data['ordertime'] = NV_CURRENTTIME;
    $data['contact_fullname'] = '';
    $data['contact_email'] = '';
    $data['contact_phone'] = '';
    $data['contact_address'] = '';
	$array_projects = $array_price_time = $listcat = array();
    
    if (defined('NV_IS_USER')) {
        $data['contact_fullname'] = nv_show_name_user($user_info['first_name'], $user_info['last_name']);
        $data['contact_email'] = $user_info['email'];
        $data['contact_phone'] = isset($user_info['phone']) ? $user_info['phone'] : '';
        $data['contact_address'] = isset($user_info['address']) ? $user_info['address'] : '';

    }
} else {

    // Get data items
    $data = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id = ' . $id)->fetch();
    

    // Get rooms
    $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rooms_detail WHERE iid = ' . $id);
    while ($row = $result->fetch()) {
        $room_detail[$row['rid']] = $row;
    }
    

    // Get keywords
    $_query = $db->query('SELECT tid, keyword FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE id=' . $data['id'] . ' ORDER BY keyword ASC');
    while ($row = $_query->fetch()) {
        $array_keywords_old[$row['tid']] = $row['keyword'];
    }
    $data['keywords'] = implode(', ', $array_keywords_old);
    $data['keywords_old'] = $data['keywords'];
    
    $images_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['images'] . '&amp;rows_id=' . $id;
    $lang_module['image_other_note1'] = sprintf($lang_module['image_other_note2'], $images_url);
    
    $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE rows_id=' . $data['id']);
    while ($other = $result->fetch()) {
        $array_otherimage[$other['id']] = $other;
        $array_id_old[] = $other['id'];
    }

    // Danh sách catid thuộc Hình thức
    $array_catid = array();
    $result = $db->query('SELECT catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_type_catid WHERE typeid=' . $data['typeid']);
    while (list ($catid) = $result->fetch(3)) {
        $array_catid[] = $catid;
    }
    $listcat = nv_listcats($data['catid'], 0, $array_catid);
    $array_price_time = nv_get_pricetype($data['typeid']);
$array_projects = nv_get_projetcs($data['provinceid'], $data['districtid'], $data['wardid']);
}

$error = '';
if ($nv_Request->isset_request('submit', 'post')) {
    $data['title'] = $nv_Request->get_string('title', 'post', '');
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
    $data['price'] = $nv_Request->get_string('price', 'post', '');
    $data['price'] = str_replace(',', '.', $data['price']);
    ;
	//print_r($data['price']);die;
    $data['price_time'] = $nv_Request->get_int('price_time', 'post', 0);
    $data['money_unit'] = $nv_Request->get_string('money_unit', 'post', 'vnd');
    $data['typeid'] = $nv_Request->get_int('typeid', 'post', 0);
    $data['projectid'] = $nv_Request->get_int('projectid', 'post', 0);
    $data['homeimgfile'] = $nv_Request->get_string('homeimgfile', 'post', '');
    $data['homeimgalt'] = $nv_Request->get_string('homeimgalt', 'post', '');
    $data['front'] = $nv_Request->get_string('front', 'post', '');
    $data['front'] = str_replace(',', '.', $data['front']);
    $data['road'] = $nv_Request->get_string('road', 'post', '');
    $data['road'] = str_replace(',', '.', $data['road']);
    $data['structure'] = $nv_Request->get_textarea('structure', '', NV_ALLOWED_HTML_TAGS);
    $data['type'] = $nv_Request->get_textarea('type', '', NV_ALLOWED_HTML_TAGS);
    $data['hometext'] = $nv_Request->get_string('hometext', 'post', '');
    $data['hometext'] = nv_nl2br(nv_htmlspecialchars(strip_tags($data['hometext'])), '<br />');
    //$data['bodytext'] = $nv_Request->get_editor('bodytext', '', NV_ALLOWED_HTML_TAGS);
    $data['bodytext'] = $nv_Request->get_textarea('bodytext', '', 'br', 1);
    $data['way_id'] = $nv_Request->get_int('way', 'post', 0);
    $data['floor'] = $nv_Request->get_int('floor', 'post', 0);
    $data['num_room'] = $nv_Request->get_int('num_room', 'post', 0);
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
    $data['showprice'] = (int) $nv_Request->get_bool('showprice', 'post');
    $data['keywords'] = $nv_Request->get_array('keywords', 'post', '');
	$data['keywords'] = implode(', ', $data['keywords']);
    $data['otherimage'] = $nv_Request->get_array('otherimage', 'post');
    $data['requeue'] = $nv_Request->get_int('requeue', 'post', 0);
    
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
    
    $data['alias'] = change_alias($data['title']);
    $stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id !=' . $id . ' AND alias = :alias');
    $stmt->bindParam(':alias', $data['alias'], PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->fetchColumn()) {
        $weight = $db->query('SELECT MAX(id) FROM ' . NV_PREFIXLANG . '_' . $module_data)->fetchColumn();
        $weight = intval($weight) + 1;
        $data['alias'] = $data['alias'] . '-' . $weight;
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
    
    if (empty($data['alias']))
        $data['alias'] = change_alias($data['title']);
    
    if (empty($data['typeid'])) {
        $error = $lang_module['items_error_typeid'];
    }elseif (empty($data['title'])) {
        $error = $lang_module['items_error_title'];
    } elseif (empty($data['catid'])) {
        $error = $lang_module['items_error_catid'];
    } elseif ((! is_numeric($data['price'])) and $data['showprice']) {
        $error = $lang_module['items_error_price'];
    } elseif (empty($data['money_unit']) and $data['showprice']) {
        $error = $lang_module['items_error_money_unit'];
   } elseif (($data['districtid'] == 0) or ($data['districtid'] == 0)) {
       $error = $lang_module['items_error_districtid'];
    } elseif (empty($data['provinceid'])) {
        $error = $lang_module['items_error_provinceid'];
    } elseif (sizeof($data['otherimage']) > $array_config['post_image_limit']) {
        $error = $lang_module['error_required_otherimage'];
    }
    
    if (empty($error) and $array_config['allow_contact_info']) {
        if (empty($data['contact_fullname'])) {
            $error = $lang_module['error_required_contact_fullname'];
        } elseif (empty($data['contact_phone'])) {
            $error = $lang_module['error_required_contact_phone'];
        } elseif (! empty($data['contact_email']) and ($error_email = nv_check_valid_email($data['contact_email'])) != '') {
            $error = $error_email;
        }
    }
	
	if(empty($error)){
		$fileupload = '';
        $array_config['upload_filetype'] = array(
            'images'
        );
        if (isset($_FILES['upload_fileupload']) and is_uploaded_file($_FILES['upload_fileupload']['tmp_name'])) {
            // Xoa file cu neu ton tai
            if (! empty($data['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $uploadpath['currentpath'] . '/' . $data['homeimgfile'])) {
                nv_deletefile($uploadpath['uploadrealdir'] . '/' . $data['homeimgfile']);
            }
            
             $file_allowed_ext = ! empty($array_config['upload_filetype']) ? $array_config['upload_filetype'] : $global_config['file_allowed_ext'];
list ($width, $height) = explode('x', $array_config['image_upload_size']);
            $upload = new NukeViet\Files\Upload($file_allowed_ext, $global_config['forbid_extensions'], $global_config['forbid_mimes'], $array_config['maxfilesize'], $width, $height); // ok chay thu
            $upload_info = $upload->save_file($_FILES['upload_fileupload'], NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $uploadpath['currentpath'], false, $array_config['auto_resize']);
            @unlink($_FILES['upload_fileupload']['tmp_name']);
            if (empty($upload_info['error'])) {

                // auto_resize
                if ($array_config['auto_resize'] and ($upload_info['img_info'][0] > $width or $upload_info['img_info'][0] > $height)) {
                    $createImage = new NukeViet\Files\Image(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $uploadpath['currentpath']. '/' . $upload_info['basename'], $upload_info['img_info'][0], $upload_info['img_info'][1]);
                    $createImage->resizeXY($width, $height);
                    $createImage->save(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $uploadpath['currentpath'], $upload_info['basename'], 90);
                    $createImage->close();
                    $info = $createImage->create_Image_info;
                    $upload_info['img_info'][0] = $info['width'];
                    $upload_info['img_info'][1] = $info['height'];
                }

                mt_srand((double) microtime() * 1000000);
                $maxran = 1000000;
                $random_num = mt_rand(0, $maxran);
                $random_num = md5($random_num);
                $nv_pathinfo_filename = nv_pathinfo_filename($upload_info['name']);
                $new_name = NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $uploadpath['currentpath'] . '/' . $nv_pathinfo_filename . '.' . $random_num . '.' . $upload_info['ext'];
                $rename = nv_renamefile($upload_info['name'], $new_name);
                if ($rename[0] == 1) {
                    $fileupload = $new_name;
                } else {
                    $fileupload = $upload_info['name'];
                }
                @chmod($fileupload, 0644);
                
                // Đóng dấu logo
                nv_image_logo($fileupload);

				
				// Tao anh thumb
                nv_bookhouse_viewImage(str_replace(NV_ROOTDIR . NV_BASE_SITEURL, '', $fileupload));
                
                $fileupload = str_replace(NV_ROOTDIR, '', $fileupload);
            } else {
                $error = 'Hình ảnh đính kèm vượt quá dung lượng cho phép. Hình ảnh upload không vượt quá 6Mb'; 
            }
            
            $data['homeimgfile'] = str_replace(NV_ROOTDIR, '', $fileupload);
            unset($upload, $upload_info);
        }

}
	
    
    if (empty($error)) {
        
		$data['homeimgthumb'] = 0;
         if (! nv_is_url($data['homeimgfile']) and nv_is_file($data['homeimgfile'], NV_UPLOADS_DIR . '/' . $uploadpath['currentpath']) === true) {
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
        
        if ($id > 0) {
            
            if ($data['requeue']) {
                $data['is_queue'] = 1;
            }
            
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET
					title = :title,
					alias = :alias,
					catid = :catid,
					hometext = :hometext,
					bodytext = :bodytext,
					edittime = ' . NV_CURRENTTIME . ',
				    exptime = :exptime,
					area = :area,
					size_v = :size_v,
					size_h = :size_h,
					price = :price,
					price_time = :price_time,
					money_unit = :money_unit,
					typeid = :typeid,
					projectid = :projectid,
					way_id = :way_id,
					floor = :floor,
					num_room = :num_room,
					legal_id = :legal_id,
					homeimgfile = :homeimgfile,
					homeimgthumb = ' . $data['homeimgthumb'] . ',
					homeimgalt = :homeimgalt,
					front = :front,
					road = :road,
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
					is_queue = :is_queue
					WHERE id = ' . $id . '';
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':alias', $data['alias'], PDO::PARAM_STR);
            $stmt->bindParam(':catid', $data['catid'], PDO::PARAM_INT);
            $stmt->bindParam(':hometext', $data['hometext'], PDO::PARAM_STR);
            $stmt->bindParam(':bodytext', $data['bodytext'], PDO::PARAM_STR);
            $stmt->bindParam(':exptime', $data['exptime'], PDO::PARAM_INT);
            $stmt->bindParam(':area', $data['area'], PDO::PARAM_STR);
            $stmt->bindParam(':size_v', $data['size_v'], PDO::PARAM_STR);
            $stmt->bindParam(':size_h', $data['size_h'], PDO::PARAM_STR);
            $stmt->bindParam(':price', $data['price'], PDO::PARAM_STR);
            $stmt->bindParam(':price_time', $data['price_time'], PDO::PARAM_INT);
            $stmt->bindParam(':money_unit', $data['money_unit'], PDO::PARAM_STR);
            $stmt->bindParam(':typeid', $data['typeid'], PDO::PARAM_INT);
            $stmt->bindParam(':projectid', $data['projectid'], PDO::PARAM_INT);
            $stmt->bindParam(':way_id', $data['way_id'], PDO::PARAM_INT);
            $stmt->bindParam(':floor', $data['floor'], PDO::PARAM_INT);
            $stmt->bindParam(':num_room', $data['num_room'], PDO::PARAM_INT);
            $stmt->bindParam(':legal_id', $data['legal_id'], PDO::PARAM_INT);
            $stmt->bindParam(':homeimgfile', $data['homeimgfile'], PDO::PARAM_STR);
            $stmt->bindParam(':homeimgalt', $data['homeimgalt'], PDO::PARAM_STR);
            $stmt->bindParam(':front', $data['front'], PDO::PARAM_STR);
            $stmt->bindParam(':road', $data['road'], PDO::PARAM_STR);
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
            $stmt->bindParam(':is_queue', $data['is_queue'], PDO::PARAM_INT);
            
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
                
                // Xu ly hinh anh khac
                foreach ($data['otherimage'] as $otherimage) {
                    $array_id_new[] = intval($otherimage['id']);
                }
                
                foreach ($data['otherimage'] as $otherimage) {
                    if ($otherimage['id'] == 0) {
                        if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'])) {
                            // Copy file từ thư mục tmp sang uploads
                            if (@nv_copyfile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'], NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $uploadpath['currentpath'] . '/' . $otherimage['homeimgfile'])) {
                                $otherimage['homeimgfile'] = str_replace($module_upload . '/', '', $uploadpath['currentpath'] . '/' . $otherimage['homeimgfile']);
                                
                                $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_images( rows_id, title, description, homeimgfile, weight ) VALUES ( :rows_id, :title, :description, :homeimgfile, 0)');
                                $sth->bindParam(':rows_id', $id, PDO::PARAM_INT);
                                $sth->bindParam(':title', $otherimage['name'], PDO::PARAM_STR, strlen($otherimage['name']));
                                $sth->bindParam(':description', $otherimage['description'], PDO::PARAM_STR, strlen($otherimage['description']));
                                $sth->bindParam(':homeimgfile', $otherimage['homeimgfile'], PDO::PARAM_STR, strlen($otherimage['homeimgfile']));
                                if ($sth->execute()) {
                                    nv_delete_other_images_tmp(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'], NV_ROOTDIR . $otherimage['thumb']);
                                }
                            }
                        }
                    } else {
                        $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_images SET title = :title, description = :description, homeimgfile = :homeimgfile WHERE id=' . $otherimage['id']);
                        $sth->bindParam(':title', $otherimage['name'], PDO::PARAM_STR, strlen($otherimage['name']));
                        $sth->bindParam(':description', $otherimage['description'], PDO::PARAM_STR, strlen($otherimage['description']));
                        $sth->bindParam(':homeimgfile', $otherimage['homeimgfile'], PDO::PARAM_STR, strlen($otherimage['homeimgfile']));
                        $sth->execute();
                    }
                }
                
                foreach ($array_id_old as $id_old) {
                    if (! in_array($id_old, $array_id_new)) {
                        $rows = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE id=' . $id_old)->fetch();
                        if (! empty($rows)) {
                            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE id = ' . $id_old);
                            @nv_deletefile(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rows['homeimgfile']);
                        }
                    }
                }
                
                $nv_Cache->delMod($module_name);
            } else {
                $error = $lang_module['error_database'];
            }
        } else {
            $userid = ! empty($user_info) ? $user_info['userid'] : 0;
            $is_queue = $array_config['post_queue'] ? 1 : 0;
           
			
			 // Nếu nội dung spam thì từ chối, đưa vào kiểm duyệt
            if(!nv_check_similar_content($data['bodytext'])){
                $is_queue = 1;
                $is_spam = 1;

            }
			
           
            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (title, alias, catid, hometext, bodytext, admin_id, addtime, edittime, exptime, area, size_v, size_h, price, price_time, money_unit, typeid, projectid, way_id, floor, num_room, legal_id, homeimgfile, homeimgthumb, homeimgalt, 
                front, road, structure, type, provinceid, districtid, wardid, address, maps, inhome, allowed_comm, hitstotal, showprice, contact_fullname, contact_email, contact_phone, contact_address, ordertime, is_queue )
				VALUES (:title, :alias, :catid, :hometext, :bodytext, :admin_id, ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . ', :exptime,
				:area, :size_v, :size_h, :price, :price_time, :money_unit, :typeid, :projectid, :way_id, :floor, :num_room, :legal_id, :homeimgfile, ' . $data['homeimgthumb'] . ', :homeimgalt, :front, :road, :structure, :type, :provinceid, :districtid, :wardid, :address, :maps, :inhome,
				:allowed_comm, 0, :showprice, :contact_fullname, :contact_email, :contact_phone, :contact_address, :ordertime, :is_queue )';
            
            $data_insert = array();
            $data_insert['title'] = $data['title'];
            $data_insert['alias'] = $data['alias'];
            $data_insert['catid'] = $data['catid'];
            $data_insert['hometext'] = $data['hometext'];
            $data_insert['bodytext'] = $data['bodytext'];
            $data_insert['admin_id'] = $userid;
            $data_insert['exptime'] = $data['exptime'];
            $data_insert['area'] = $data['area'];
            $data_insert['size_v'] = $data['size_v'];
            $data_insert['size_h'] = $data['size_h'];
            $data_insert['price'] = $data['price'];
            $data_insert['price_time'] = $data['price_time'];
            $data_insert['money_unit'] = $data['money_unit'];
            $data_insert['typeid'] = $data['typeid'];
            $data_insert['projectid'] = $data['projectid'];
            $data_insert['way_id'] = $data['way_id'];
            $data_insert['floor'] = $data['floor'];
            $data_insert['num_room'] = $data['num_room'];
            $data_insert['legal_id'] = $data['legal_id'];
            $data_insert['homeimgfile'] = $data['homeimgfile'];
            $data_insert['homeimgalt'] = $data['homeimgalt'];
            $data_insert['front'] = $data['front'];
            $data_insert['road'] = $data['road'];
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
            $data_insert['is_queue'] = $is_queue;
            
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
                
                // Xu ly hinh anh khac
                foreach ($data['otherimage'] as $otherimage) {
                    $array_id_new[] = intval($otherimage['id']);
                }
                
                foreach ($data['otherimage'] as $otherimage) {
                    if ($otherimage['id'] == 0) {
                        if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'])) {
                            // Copy file từ thư mục tmp sang uploads
                            if (@nv_copyfile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'], NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $uploadpath['currentpath'] . '/' . $otherimage['homeimgfile'])) {
                                $otherimage['homeimgfile'] = str_replace($module_upload . '/', '', $uploadpath['currentpath'] . '/' . $otherimage['homeimgfile']);
                                
                                $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_images( rows_id, title, description, homeimgfile, weight ) VALUES ( :rows_id, :title, :description, :homeimgfile, 0)');
                                $sth->bindParam(':rows_id', $data['id'], PDO::PARAM_INT);
                                $sth->bindParam(':title', $otherimage['name'], PDO::PARAM_STR, strlen($otherimage['name']));
                                $sth->bindParam(':description', $otherimage['description'], PDO::PARAM_STR, strlen($otherimage['description']));
                                $sth->bindParam(':homeimgfile', $otherimage['homeimgfile'], PDO::PARAM_STR, strlen($otherimage['homeimgfile']));
                                if ($sth->execute()) {
                                    nv_delete_other_images_tmp(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'], NV_ROOTDIR . $otherimage['thumb']);
                                }
                            }
                        }
                    } else {
                        $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_images SET title = :title, description = :description, homeimgfile = :homeimgfile WHERE id=' . $otherimage['id']);
                        $sth->bindParam(':title', $otherimage['name'], PDO::PARAM_STR, strlen($otherimage['name']));
                        $sth->bindParam(':description', $otherimage['description'], PDO::PARAM_STR, strlen($otherimage['description']));
                        $sth->bindParam(':homeimgfile', $otherimage['homeimgfile'], PDO::PARAM_STR, strlen($otherimage['homeimgfile']));
                        $sth->execute();
                    }
                }
                
                foreach ($array_id_old as $id_old) {
                    if (! in_array($id_old, $array_id_new)) {
                        $rows = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE id=' . $id_old)->fetch();
                        if (! empty($rows)) {
                            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE id = ' . $id_old);
                            @nv_deletefile(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rows['homeimgfile']);
                        }
                    }
                }
                 
			// Căn cứ vào nhóm thành viên để cập nhật nhóm bđs
                if (defined('NV_IS_USER')) {

                    /*
                     * $result = $db->query('SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat WHERE groups IN (' . implode(',', $user_info['in_groups']) . ')');
                     * while (list ($bid) = $result->fetch(3)) {
                     * nv_item_group($bid, $data['id']);
                     * }
                     */
                    
                    $user_groupid = $db->query('SELECT groupid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_users_groups WHERE userid=' . $user_info['userid'] . ' AND exptime > ' . NV_CURRENTTIME)->fetchColumn();
                    $user_groupid = intval($user_groupid);
                    $result = $db->query('SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat WHERE groups=' . $user_groupid);
                    while (list ($bid) = $result->fetch(3)) {
						
                        nv_item_group($bid, $data['id']);
                    }
                }
                    
                // Thêm lịch sử kiểm duyệt
                if($is_spam){
                    $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_queue_logs(itemid, queue, reason, addtime) VALUES (' . $data['id'] . ', 0, :reason, ' . NV_CURRENTTIME . ')');
                    $sth->bindParam(':reason', $lang_module['queue_reason'], PDO::PARAM_STR);
                    $sth->execute();
                    
                    // Gửi mail thông báo cho người đăng
                    if (defined('NV_IS_USER')) {
                        $queue_info = array();
                        $queue_info['site_name'] = $global_config['site_name'];
                        $queue_info['site_description'] = $global_config['site_description'];
                        $queue_info['title'] = $data['title'];
                        $queue_info['link'] = NV_MY_DOMAIN . nv_url_rewrite($array_cat[$data['catid']]['link'] . '/' . $data['alias'] . '-' . $data['id'] . $global_config['rewrite_exturl'], true);
                        $queue_info['fullname'] = ! empty($data['contact_fullname']) ? $data['contact_fullname'] : $user_info['email'];
                        $queue_info['reason'] = '';
                        $queue_info['reason_note'] = $lang_module['queue_reason'];
                        $queue_info['queue_status'] = $lang_module['queue_type_0'];
                        $queue_info['queue'] = 0;

                        $message = nv_sendmail_queue($queue_info);
                        
                        $subject = $global_config['site_name'] . ' - ' . $lang_module['queue_mail_subject'];
                        nv_add_mail_queue($user_info['email'], $subject, $message);
                    }
                }
                
                $nv_Cache->delMod($module_name);
            } else {
                $error = $lang_module['error_database'];
            }
        }
        
        $data['keywords'] = explode(',', $data['keywords']);
        $data['keywords'] = array_map('strip_punctuation', $data['keywords']);
        $data['keywords'] = array_map('trim', $data['keywords']);
        $data['keywords'] = array_diff($data['keywords'], array(
            ''
        ));
        $data['keywords'] = array_unique($data['keywords']);
        if ($data['keywords'] != $data['keywords_old']) {
            $keywords = $data['keywords'];
            
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
        
        if ($id > 0) {
            $lang_module['insert_success_title'] = $lang_module['update_success_title'];
            $lang_module['insert_success_content'] = $lang_module['update_success_content'];
        } else {
            // Them thong bao
            nv_insert_notification($module_name, 'items_new', array(
                'title' => $data['title']
            ), $data['id']);
        }
        
        if (defined('NV_IS_USER')) {
            $url_back = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['items'], true);
        } else {
            $url_back = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content', true);
        }
		
		 if($is_spam){
			 $lang_module['insert_success_title'] = 'Đăng tin rao thất bại';
			 $lang_module['insert_success_content'] = 'Tin rao của bạn bị trùng,vui lòng chỉnh sửa lại nội dung!';
			 if(!empty($data['contact_email']))
			 {
			 
                        $queue_info = array();
                        $queue_info['site_name'] = $global_config['site_name'];
                        $queue_info['site_description'] = $global_config['site_description'];
                        $queue_info['title'] = $data['title'];
                        $queue_info['link'] = NV_MY_DOMAIN . nv_url_rewrite($array_cat[$data['catid']]['link'] . '/' . $data['alias'] . '-' . $data['id'] . $global_config['rewrite_exturl'], true);
                        $queue_info['fullname'] = ! empty($data['contact_fullname']) ? $data['contact_fullname'] : $user_info['email'];
                        $queue_info['reason'] = '';
                        $queue_info['reason_note'] = $lang_module['queue_reason'];
                        $queue_info['queue_status'] = $lang_module['queue_type_0'];
                        $queue_info['queue'] = 0;

                        $message = nv_sendmail_queue($queue_info);
                        
                        $subject = $global_config['site_name'] . ' - ' . $lang_module['queue_mail_subject'];
				$from = array( $global_config['site_name'], $global_config['site_email'] );
				
				 // Gửi mail thông báo cho người đăng
					
						@nv_sendmail( $from, $data['contact_email'], "Thông báo muanha.com.vn", $message ); 
			 }
			
		 }
		 else{
			
			if(!empty($data['contact_email']))
			 {
			 
                        $queue_info = array();
                        $queue_info['site_name'] = $global_config['site_name'];
                        $queue_info['site_description'] = $global_config['site_description'];
                        $queue_info['title'] = $data['title'];
                        $queue_info['link'] = NV_MY_DOMAIN . nv_url_rewrite($array_cat[$data['catid']]['link'] . '/' . $data['alias'] . '-' . $data['id'] . $global_config['rewrite_exturl'], true);
                        $queue_info['fullname'] = ! empty($data['contact_fullname']) ? $data['contact_fullname'] : $user_info['email'];
                        $queue_info['reason'] = '';
                        $queue_info['reason_note'] = $lang_module['queue_reason'];
                        $queue_info['queue_status'] = $lang_module['queue_type_1'];
                        $queue_info['queue'] = 1;

                        $message = nv_sendmail_queue($queue_info);
                        
                        $subject = $global_config['site_name'] . ' - ' . $lang_module['queue_mail_subject'];
				$from = array( $global_config['site_name'], $global_config['site_email'] );
				@nv_sendmail( $from, $data['contact_email'], "Thông báo muanha.com.vn", $message ); 
			 }
		 
		 }
		 
		/*  // THÊM NHÀ MÔI GIỚI TẠI ĐÂY
		 // KIỂM TRA NẾU SĐT CHƯA CÓ TRONG ĐĂNG KÝ NHÀ MÔI GIỚI THÌ ĐĂNG THÌ NHÀ MÔI GIỚI MỚI
		 $tontai_moigioi = $db->query("SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_contact WHERE company like '".$data['contact_phone']."'")->fetchColumn();
		 if(!$tontai_moigioi)
		 {
			// THÊM NHÀ MÔI GIỚI
			
				$data['alias'] = change_alias( $data['contact_phone'] );
				$row['add_date'] = NV_CURRENTTIME;
				$row['nhomtin'] = 0;
				if($user_groupid == 13 )
				$row['nhomtin'] = 1;
				if($user_groupid == 14 )
				$row['nhomtin'] = 2;
				
	
				
				
				$sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_contact (company, tenkhac, alias, address, tinhthanh, quanhuyen, xaphuong, phone, telephone, fax, email, website, vatcode, logo, description, userid, add_date, nhom_hotvip) VALUES ('".$data['contact_phone']."', '".$data['contact_phone']."','".$data['alias']."', '".$data['contact_address']."', ".$data['provinceid'].", ".$data['districtid'].", ".$data['wardid'].", '".$data['contact_phone']."', '".$data['contact_phone']."', '', '".$data['contact_email']."', '', '', '', '', '".$user_info['userid']."', ".$row['add_date'].", ".$row['nhomtin'].")";
				
				//die($sql);
				// THÊM KHU VỰC HOẠT ĐỘNG CỦA NHÀ MÔI GIỚI
				
				$id_danhba = $db->insert_id($sql, 'id', $data_insert);
				
				
				
				$thuchien = $db->query( "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_area (id_tv, title) VALUES ( '".$data['contact_phone']."', '".$data['contact_address']."')" ); 
				
				

		 } */
      
		 if (defined('NV_IS_USER')) {
			if($is_spam)
			{
				Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items&ok=0');
			}
			else{
				Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items&ok=1');
			
			}
		}
		else{
		
			$link = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $array_cat[$data['catid']]['alias'] . '/' . $data['alias'] . '-' . $data['id'] . $global_config['rewrite_exturl'], true);
			Header('Location: ' . $link);
		
		}
		
		 
    }
}

// Editor
if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
} elseif (! nv_function_exists('nv_aleditor') and file_exists(NV_ROOTDIR . '/' . NV_EDITORSDIR . '/ckeditor/ckeditor.js')) {
    define('NV_EDITOR', true);
    define('NV_IS_CKEDITOR', true);
    $my_head .= '<script type="text/javascript" src="' . NV_BASE_SITEURL . NV_EDITORSDIR . '/ckeditor/ckeditor.js"></script>';

    function nv_aleditor($textareaname, $width = '100%', $height = '450px', $val = '', $customtoolbar = '')
    {
        global $module_data;
        $return = '<textarea style="width: ' . $width . '; height:' . $height . ';" id="' . $module_data . '_' . $textareaname . '" name="' . $textareaname . '">' . $val . '</textarea>';
        $return .= "<script type=\"text/javascript\">
			CKEDITOR.replace( '" . $module_data . "_" . $textareaname . "', {" . (! empty($customtoolbar) ? 'toolbar : "' . $customtoolbar . '",' : '') . " width: '" . $width . "',height: '" . $height . "',});
			</script>";
        return $return;
    }
}

//$data['bodytext'] = htmlspecialchars(nv_editor_br2nl($data['bodytext']));
$data['bodytext'] = nv_htmlspecialchars(nv_br2nl($data['bodytext']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
  //  $data['bodytext'] = nv_aleditor('bodytext', '100%', '300px', $data['bodytext'], '');
   $data['bodytext'] = '<textarea style="width:100%;height:300px" name="bodytext">' . $data['bodytext'] . '</textarea>';
} else {
    $data['bodytext'] = '<textarea style="width:100%;height:300px" name="bodytext">' . $data['bodytext'] . '</textarea>';
}

$data['maps'] = ! empty($data['maps']) ? unserialize($data['maps']) : array();

$is_uploaded = 0;
if (! empty($data['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $data['homeimgfile'])) {
    $data['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data['homeimgfile'];
    $is_uploaded = 1;
}

$data['front'] = ! empty($data['front']) ? $data['road'] : '';
$data['road'] = ! empty($data['road']) ? $data['road'] : '';
$data['exptime_f'] = ! empty($data['exptime']) ? nv_date('d/m/Y', $data['exptime']) : '';

$xtpl = new XTemplate('content.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('ACTION', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=content&id=' . $id);
$xtpl->assign('QUAN_LY_TIN', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items');

$xtpl->assign('BODYTEXT', $data['bodytext']);
$xtpl->assign('UPLOAD_DIR', NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('MAXFILESIZE', nv_convertfromBytes($array_config['maxfilesize']));
$xtpl->assign('UPLOAD_IMG_SIZE', $array_config['image_upload_size']);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('UPLOAD_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=upload&token=' . md5($nv_Request->session_id . $global_config['sitekey']));
$xtpl->assign('MAXFILESIZEULOAD', $array_config['maxfilesize']);
$xtpl->assign('MAXIMAGESIZEULOAD', explode('x', $array_config['image_upload_size']));
$xtpl->assign('PLACE_IMAGE_LIMIT', $array_config['post_image_limit']);
$xtpl->assign('DES_POINT', $array_config['dec_point']);
$xtpl->assign('THOUSANDS_SEP', $array_config['thousands_sep']);

$i = 0;
if (! empty($array_otherimage)) {
    foreach ($array_otherimage as $otherimage) {
        $otherimage['number'] = $i;
        $otherimage['filepath'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $otherimage['homeimgfile'];
        $otherimage['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $otherimage['homeimgfile'];
        $otherimage['homeimgfile'] = str_replace(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/', '', $otherimage['homeimgfile']);
        $xtpl->assign('DATA', $otherimage);
        $xtpl->parse('main.data');
        $i ++;
    }
}
$xtpl->assign('COUNT', $i);
$xtpl->assign('COUNT_UPLOAD', $array_config['post_image_limit'] - $i);

 // Keywords
    if (! empty($data['keywords'])) {
        $keywords_array = explode(',', $data['keywords']);
        foreach ($keywords_array as $keywords) {
            $xtpl->assign('KEYWORDS', $keywords);
            $xtpl->parse('main.keywords');
        }
    }

// List cat
foreach ($listcat as $cat) {
    $xtpl->assign('CAT', $cat);
    $xtpl->parse('main.cat');
}

// List room
$listroom = nv_listrooms();
if (count($listroom)) {
    foreach ($listroom as $room) {
        $room['value'] = isset($room_detail[$room['id']]) ? $room_detail[$room['id']]['num'] : '';
        $xtpl->assign('ROOM', $room);
        $xtpl->parse('main.room.loop');
    }
    $xtpl->parse('main.room');
}

// Keywords
if (! empty($data['keywords'])) {
    $xtpl->assign('KEYWORDS', $data['keywords']);
}


if (! empty($array_projects)) {
    foreach ($array_projects as $projects) {
        $projects['selected'] = $projects['id'] == $data['projectid'] ? 'selected="selected"' : '';
        $xtpl->assign('PROJECTS', $projects);
        $xtpl->parse('main.projects');
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
//print_r($data);die;
if (! empty($array_type)) {
    foreach ($array_type as $type) {
        $type['selected'] = $type['id'] == $data['typeid'] ? 'selected="selected"' : '';
        $xtpl->assign('TYPE', $type);
        $xtpl->parse('main.type');
    }
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
$location = new Location();
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

// LẤY SĐT ĐỊA CHỈ CỦA USER
if(defined('NV_IS_USER') and empty($id))
{
	$field= $db->query("SELECT count(field) FROM nv4_users_field WHERE field = 'phone' OR field = 'address'")->fetchColumn();
	if($field){
		$dc_sdt = $db->query("SELECT phone, address FROM nv4_users_info WHERE userid =".$user_info['userid'])->fetch();
		$data['contact_phone'] = $dc_sdt['phone'];
		$data['contact_address'] = $dc_sdt['address'];
	}
}
$xtpl->assign('DATA', $data);

if ($is_uploaded) {
    $xtpl->parse('main.image');
}

if (empty($data['alias'])) {
    $xtpl->parse('main.change_alias');
}

$location = new Location();
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

if ($array_config['sizetype'] == 0) {
    $xtpl->parse('main.area');
} elseif ($array_config['sizetype'] == 1) {
    $xtpl->parse('main.size');
}

if ($data['is_queue'] == 2) {
    $xtpl->parse('main.re_queue');
}

if ($array_config['allow_contact_info']) {
    $xtpl->parse('main.contact_info');
}

$page_title = $id ? $lang_module['items_edit'] . ' ' . $data['title'] : $lang_module['items_add'];
$array_mod_title[] = array(
    'title' => $page_title
);

if ($nv_Request->isset_request('ok', 'get')) {
	$ok = $nv_Request->get_int('ok', 'get', 0);
	if($ok == 1)
		$xtpl->parse('main.ok');
	else $xtpl->parse('main.no_ok');

}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
die(); 
