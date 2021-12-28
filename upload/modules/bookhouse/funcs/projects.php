<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (!defined('NV_IS_MOD_BOOKHOUSE')) die('Stop!!!');

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['projects'];
$array_data = array();
$per_page = 15;
$where = '';

if (isset($array_op[1]) and substr($array_op[1], 0, 5) == 'page-') {
    $page = intval(substr($array_op[1], 5));
}

$array_search = array(
    'q' => $nv_Request->get_title('q', 'get', ''),
    'typeid' => $nv_Request->get_int('typeid', 'get', 0),
    'provinceid' => $nv_Request->get_int('provinceid', 'get', 0),
    'districid' => $nv_Request->get_int('districid', 'get', 0),
    'wardid' => $nv_Request->get_int('wardid', 'get', 0)
);

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (title LIKE "%' . $array_search['q'] . '%"
        OR alias LIKE "%' . $array_search['q'] . '%"
        OR description LIKE "%' . $array_search['q'] . '%"
        OR descriptionhtml LIKE "%' . $array_search['q'] . '%")';
}

if ($array_search['typeid'] > 0) {
    $base_url .= '&typeid=' . $array_search['typeid'];
    $where .= ' AND typeid=' . $array_search['typeid'];
}

if ($array_search['provinceid'] > 0) {
    $base_url .= '&provinceid=' . $array_search['provinceid'];
    $where .= ' AND provinceid=' . $array_search['provinceid'];
}

if ($array_search['districid'] > 0) {
    $base_url .= '&districid=' . $array_search['districid'];
    $where .= ' AND districid=' . $array_search['districid'];
}

if ($array_search['wardid'] > 0) {
    $base_url .= '&wardid=' . $array_search['wardid'];
    $where .= ' AND wardid=' . $array_search['wardid'];
}

$db->sqlreset()
    ->select('COUNT(*) ')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_projects')
    ->where('status=1' . $where);

$num_items = $db->query($db->sql())
    ->fetchColumn();

$db->select('id, typeid, title, alias, vondautu, soblock, chudautu, sotang, dientich, socanho, sophong, giaban, giathue, description, homeimg, provinceid, districtid, wardid, maps')
    ->order('id DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$result = $db->query($db->sql());

$location = new Location();

$module_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

while ($item = $result->fetch()) {
    if (!empty($item['homeimg']) && file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $module_upload . '/' . $item['homeimg'])) {
        $item['homeimg'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $item['homeimg'];
    } elseif (!empty($item['homeimg']) && file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['homeimg'])) {
        $item['homeimg'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['homeimg'];
    } else {
        $item['homeimg'] = '';
    }

    $item['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['project-detail'] . '/' . $item['alias'] . '-' . $item['id'];
	
	$item['location'] = $location->locationString($item['provinceid'], $item['districtid'], $item['wardid'], ' » ', $module_url);
	
	$item['maps'] = ! empty($item['maps']) ? unserialize($item['maps']) : array();
	
    $array_data[$item['id']] = $item;
	
}

$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);

$contents = nv_theme_bookhouse_projects($array_data, $generate_page);

$page_title = $lang_module['projects'];
$array_mod_title[] = array(
    'title' => $page_title,
    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op
);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
