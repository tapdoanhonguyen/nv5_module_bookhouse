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

if (!defined('NV_IS_USER'))
{
	Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
		die();
}

// change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);
    $content = 'NO_' . $id;
    
    $query = 'SELECT status FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $id . ' AND admin_id=' . $user_info['userid'];
    $row = $db->query($query)->fetch();
    if (isset($row['status'])) {
        $status = ($row['status']) ? 0 : 1;
        $query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET status=' . intval($status) . ' WHERE id=' . $id . ' AND admin_id=' . $user_info['userid'];
        $db->query($query);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

// Xoa doi tuong
if ($nv_Request->isset_request('del', 'post,get')) {
    $id = $nv_Request->get_int('id', 'post,get', 0);
    $listid = $nv_Request->get_string('listid', 'post,get', '');
    
    if ($id and empty($listid)) {
        nv_user_del_items($id);
        die('OK');
    }
    
    if (! empty($listid) and ! $id) {
        $listid = array_map("intval", explode(",", $listid));
        foreach ($listid as $id) {
            if ($id > 0)
                nv_user_del_items($id);
        }
        die('OK');
    }
    
    $nv_Cache->delMod($module_name);
    
    die('NO');
}

if ($nv_Request->isset_request('get_alias', 'post')) {
    $title = $nv_Request->get_title('title', 'post', '');
    $alias = change_alias($title);
    die($alias);
}

if (count($array_cat) == 0) {
    $contents = nv_theme_alert($lang_module['listcat_empty_title'], $lang_module['listcat_empty_content'], 'info');
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$array_data = array();
$is_search = false;
$search = array(
    'keyword' => '',
    'catid' => 0,
    'status' => - 1
);
$where = '';

if ($nv_Request->isset_request('search', 'get')) {
    $is_search = true;
    
    $search['keyword'] = $nv_Request->get_title('keyword', 'get', '');
    $search['catid'] = $nv_Request->get_int('catid', 'get', 0);
    $search['status'] = $nv_Request->get_int('status', 'get', - 1);
    
    if (! empty($search['keyword'])) {
        $where .= ' AND title like "%' . $search['keyword'] . '%" OR code like "%' . $search['keyword'] . '%" OR hometext like "%' . $search['keyword'] . '%" OR bodytext like "%' . $search['keyword'] . '%"';
    }
    
    if ($search['catid'] > 0) {
        $where .= ' AND catid = ' . $search['catid'];
    }
    
    if ($search['status'] >= 0) {
        $where .= ' AND status = ' . $search['status'];
    }
}


if ($nv_Request->isset_request('is_queue', 'get')) {
	$is_queue = $nv_Request->get_int('is_queue', 'get', 0);
	$where .= ' AND is_queue = ' . $is_queue;
}
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;

if ($nv_Request->isset_request('is_queue', 'get')) 
{
	$is_queue = $nv_Request->get_int('is_queue', 'get', 0);
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op .'&is_queue='.$is_queue;
}
$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data)
    ->where('admin_id = ' . $user_info['userid'] . $where);

$num_items = $db->query($db->sql())
    ->fetchColumn();

$page = $nv_Request->get_int('page', 'get', 1);
$per_page = 10;

$db->select('id, title, alias, catid, code, price, money_unit, status, is_queue, status_admin, price_time, homeimgfile, homeimgthumb, hitstotal, hits_phone, ordertime, groupid')
    ->order('ordertime DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$result2 = $db->query($db->sql());
//print_r($db->sql());die;
while ($row = $result2->fetch()) {
    $array_data[$row['id']] = $row;
}

$url_add = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['content'] . '&amp;t=1';
$lang_module['items_note1'] = $num_items < $array_config['post_user_limit'] ? $lang_module['items_note1'] : $lang_module['items_note4'];
$lang_module['items_note1'] = sprintf($lang_module['items_note1'], $num_items . '/' . $array_config['post_user_limit'], $url_add);
$lang_module['items_note2'] = sprintf($lang_module['items_note2'], nv_convertfromBytes($array_config['maxfilesize']), $array_config['image_upload_size']);
$lang_module['items_note3'] = sprintf($lang_module['items_note3'], nv_convertfromBytes($array_config['post_image_limit']));

$array_groups = array();
$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat WHERE useradd=1 ORDER BY weight ASC');
while ($_row = $result->fetch()) {
    $array_groups[$_row['bid']] = $_row;
}

$xtpl = new XTemplate('items_list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
$xtpl->assign('ADD_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=items&add');

if (! empty($array_data)) {
	$listcat = nv_listcats();
    foreach ($array_data as $row) {
        $row['checkss'] = md5($global_config['sitekey'] . '-' . $user_info['userid'] . '-' . $row['id']);
        $row['cat'] = $listcat[$row['catid']]['title'];
        $row['ordertime'] = nv_date('H:i d/m/Y', $row['ordertime']);
        $row['price'] = ! empty($row['price']) ? nv_price_format($row['price'], $row['price_time']) : $lang_module['items_price_contact'];
        $row['edit_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $row['id'];
        $row['view_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $listcat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
		$row['url_upgrade'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['upgrade'] . '/' . $row['alias'] . '-' . $row['id'];
        $row['images_link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=images&amp;rows_id=' . $row['id'];
        $row['images_count'] = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE rows_id=' . $row['id'])->fetchColumn();
        
        if (! empty($row['groupid'])) {
            $row['groupid'] = explode(',', $row['groupid'])[0];
            $row['color'] = $array_groups[$row['groupid']]['color'];
			if(!empty($array_groups[$row['groupid']]['image']))
			{
			$image_icon = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array_groups[$row['groupid']]['image'];
			$xtpl->assign('image_icon', $image_icon);
			$xtpl->parse('main.loop.image_icon');
			
			}
        }
        
        if ($row['homeimgthumb'] == 1) {
            //image thumb
            $row['imghome'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
        } elseif ($row['homeimgthumb'] == 2) {
            //image file
            $row['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
        } elseif ($row['homeimgthumb'] == 3) {
            //image url
            $row['imghome'] = $row['homeimgfile'];
        } else {
            $row['imghome'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/bookhouse/no-image.jpg';
        }
        
        if ($row['is_queue'] == 1) {
            $row['status_s'] = $lang_module['items_status_queue'] . ' - tin bị trùng';
			$row['tintrung'] = 'class="tintrung"';
        } elseif ($row['is_queue'] == 2) {
            $row['status_s'] = $lang_module['items_status_queue_decline'];
        } elseif ($row['status_admin'] == 0) {
            $row['status_s'] = $lang_module['status_admin_0'];
        } else {
            $row['status_s'] = $lang_module['items_status'];
        }
       
        $xtpl->assign('CHECK', $row['status'] == 1 ? 'checked' : '');
        $xtpl->assign('DATA', $row);
        
         if ($array_config['refresh_allow']) {
            $count_refresh = nv_count_refresh($module_name);
            $count_refresh_free = nv_count_refresh_free($module_name);
            if ($count_refresh + $count_refresh_free > 0) {
                $xtpl->parse('main.loop.refresh_allow.refresh');
            } else {

                $xtpl->parse('main.loop.refresh_allow.refresh_label');
            }
            $xtpl->parse('main.loop.refresh_allow');
        }
        
        if (! empty($array_groups) and ! empty($array_config['payport'])) {
            $xtpl->assign('ALL', $array_config['payment_style']);
            foreach ($array_groups as $group) {
                $xtpl->assign('GROUP', $group);
                $xtpl->parse('main.loop.group_buy.loop');
            }
            $xtpl->parse('main.loop.group_buy');
            $xtpl->parse('main.loop.group_buy1');
        }
        
        $xtpl->parse('main.loop');
    }
}


if (! empty($array_cat)) {
    foreach ($array_cat as $catid => $value) {
        $value['space'] = '';
        if ($value['lev'] > 0) {
            for ($i = 1; $i <= $value['lev']; $i ++) {
                $value['space'] .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
        }
        




        $value['selected'] = $catid == $search['catid'] ? ' selected="selected"' : '';
        
        $xtpl->assign('CAT', $value);

        $xtpl->parse('main.cat');
    }
}

$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (! empty($generate_page)) {
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}

if ($is_search) {
    $xtpl->assign('KEYWORD', $search['keyword']);
}

if ($array_config['post_queue']) {
    $xtpl->parse('main.post_queue');
}

if ($nv_Request->isset_request('ok', 'get')) {
	$ok = $nv_Request->get_int('ok', 'get', 0);
	if($ok == 1)
		$xtpl->parse('main.ok');
	else $xtpl->parse('main.no_ok');

}
$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['items'];
$array_mod_title[] = array(
    'title' => $page_title
);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
