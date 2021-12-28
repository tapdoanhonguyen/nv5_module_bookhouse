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

$array_search = array(
    'keywords' => '',
    'catid' => 0,
    'code' => ''
);

$array_data = array();
$where = '';
$listcat = nv_listcats();

if ($nv_Request->isset_request('search', 'get')) {
    $page = $nv_Request->get_int('page', 'get', 1);
    $per_page = $array_config['num_item_page'];
    $base_url = '&search';
    
    $array_search['keywords'] = $nv_Request->get_title('keywords', 'get', '');
    $array_search['catid'] = $nv_Request->get_int('catid', 'get', 0);
    $array_search['code'] = $nv_Request->get_title('code', 'get', '');
    
    if (! empty($array_search['keywords'])) {
        $where .= ' AND title like "%' . $array_search['keywords'] . '%" OR hometext like "%' . $array_search['keywords'] . '%" OR bodytext like "%' . $array_search['keywords'] . '%"';
        $base_url .= '&keywords=' . $array_search['keywords'];
    }
    
    if (! empty($array_search['catid'])) {
        $where .= ' AND catid = ' . $array_search['catid'];
        $base_url .= '&catid=' . $array_search['catid'];
    }
    
    if (! empty($array_search['code'])) {
        $where .= ' AND code like "%' . $array_search['code'] . '%"';
        $base_url .= 'code=' . $array_search['code'];
    }
    
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=getitemid' . $base_url;
    
    if (! empty($where)) {
        $db->sqlreset()
            ->select('COUNT(*) ')
            ->from(NV_PREFIXLANG . '_' . $module_data)
            ->where('1=1' . $where);
        
        $num_items = $db->query($db->sql())
            ->fetchColumn();
        
        $db->select('id, catid, title, alias, code, status')
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);
        
        $result = $db->query($db->sql());
        while ($item = $result->fetch()) {
            $array_data[] = $item;
        }
        
        $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    }
}

$xtpl = new XTemplate('getitemid.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP_NAME', $op);
$xtpl->assign('ARRAY_SEARCH', $array_search);

if (! empty($array_data)) {
    foreach ($array_data as $data) {
        $data['status'] = $liststatus[$data['status']];
        $data['cat_title'] = $listcat[$data['catid']]['title'];
        $data['code'] = ! empty($data['code']) ? $data['code'] : 'N/A';
        $xtpl->assign('DATA', $data);
        $xtpl->parse('main.result.loop');
    }
    $xtpl->parse('main.result');
} else {
    $xtpl->parse('main.no_result');
}

if (! empty($listcat)) {
    foreach ($listcat as $cat) {
        $xtpl->assign('CAT', array(
            'key' => $cat['id'],
            'title' => $cat['title'],
            'selected' => $array_search['catid'] == $cat['id'] ? 'selected="selected"' : ''
        ));
        $xtpl->parse('main.cat');
    }
}

if (! empty($generate_page)) {
    $xtpl->assign('PAGE', $generate_page);
    $xtpl->parse('main.page');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['search'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents, false);
include NV_ROOTDIR . '/includes/footer.php';