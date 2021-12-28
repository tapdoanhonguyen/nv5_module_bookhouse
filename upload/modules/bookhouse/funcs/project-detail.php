<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (!defined('NV_IS_MOD_BOOKHOUSE')) die('Stop!!!');

$per_page = 6;
$page = $nv_Request->get_int('page', 'get', 1);

if ($nv_Request->isset_request('ajax', 'get,post')) {
    $id = $nv_Request->get_int('id', 'get', 0);
    $type = $nv_Request->get_int('typeid', 'get', 0);

    $db->sqlreset()
        ->select(' COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data)
        ->where('projectid=' . $id . ' AND status=1 AND status_admin=1 AND is_queue=0 AND inhome=1 AND (exptime > ' . NV_CURRENTTIME . ' OR exptime = 0) AND typeid=' . $type);

    $num_items = $db->query($db->sql())
        ->fetchColumn();

    $db->select('*')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $_query = $db->query($db->sql());

    $array_data = array();
    while ($row = $_query->fetch()) {
        $array_data[$row['id']] = nv_data_show($row);
    }
    $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['project-detail'] . '&amp;id=' . $id . '&amp;typeid=' . $type . '&amp;ajax=1';
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'main_div_' . $type);
    $contents = nv_theme_bookhouse_project_detail_other($array_data, $generate_page);
    nv_htmlOutput($contents);
}

$alias = explode('-', $array_op[1]);
$id = intval(end($alias));

$rows = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_projects WHERE id=' . $id . ' AND status=1')->fetch();
if (empty($rows)) {
    $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect, 404);
}

$location = new Location();

$module_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

if (!empty($rows['homeimg']) && file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $module_upload . '/' . $rows['homeimg'])) {
    $rows['homeimg'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $rows['homeimg'];
} elseif (!empty($rows['homeimg']) && file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rows['homeimg'])) {
    $rows['homeimg'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rows['homeimg'];
} else {
    $rows['homeimg'] = '';
}

$num_items = 0;

if (!empty($array_type)) {
    $array_data = array();
    foreach ($array_type as $type) {
        $db->sqlreset()
            ->select(' COUNT(*)')
            ->from(NV_PREFIXLANG . '_' . $module_data)
            ->order('addtime DESC')
            ->where('projectid=' . $id . ' AND status=1 AND status_admin=1 AND is_queue=0 AND inhome=1 AND (exptime > ' . NV_CURRENTTIME . ' OR exptime = 0) AND typeid=' . $type['id']);

        $num_items = $db->query($db->sql())
            ->fetchColumn();

        $db->select('*')
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);
        $_query = $db->query($db->sql());
        $data = array();



        while ($row = $_query->fetch()) {
            $data[$row['id']] = nv_data_show($row);
            $array_data[$type['id']] = array(
                'id' => $type['id'],
                'title' => $type['title'],
                'count' => $num_items,
                'data' => $data
            );
        }
    }
}



$xtpl = new XTemplate('project-detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);

$rows['location'] = $location->locationString($rows['provinceid'], $rows['districtid'], $rows['wardid'], ' » ', $module_url);

// lấy danh sách tiện ích ra
	$ds_tienich = $db->query('SELECT * FROM '. NV_PREFIXLANG . '_' . $module_data . '_convenient ORDER BY id DESC')->fetchAll();
	
	if(!empty($ds_tienich))
	{
		$mang_tienich = explode(',',$rows['tienich']);
		
		foreach($ds_tienich as $ti)
		{
			if(in_array($ti['id'],$mang_tienich))
				$xtpl->assign( 'checked', '<i class="fa fa-check"></i>');
			else
			{
				$xtpl->assign( 'checked', '<i class="fa fa-times"></i>');
				$tien_ich_daydu = $lang_global['1phan'];
			}
			$xtpl->assign( 'tien_ich', $ti );
			$xtpl->parse( 'main.tien_ich' );
		}
	}
	$xtpl->assign('tien_ich_daydu', $tien_ich_daydu);
	

$xtpl->assign('DATA', $rows);


if (!empty($rows['homeimg'])) {
    $xtpl->parse('main.homeimg');
}

if (!empty($rows['image'])) {
    $rows['image'] = explode("|", $rows['image']);
    foreach ($rows['image'] as $num => $img) {
        $img = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $img;
        $xtpl->assign('NUM', $num);
        $xtpl->assign('IMG', $img);
        $xtpl->parse('main.image.loop_img');
        $xtpl->parse('main.image.loop_control');
    }
    $xtpl->parse('main.image');
}

if (!empty($rows['descriptionhtml'])) {
    $xtpl->parse('main.descriptionhtml');
}

if (!empty($array_data)) {

	foreach ($array_data as $typeid => $type) {
        $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['project-detail'] . '&amp;id=' . $id . '&amp;typeid=' . $typeid . '&amp;ajax=1';
        $generate_page = nv_generate_page($base_url, $type['count'], $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'main_div_' . $typeid);
        if (!empty($type['data'])) {
            $xtpl->assign('TYPE', $array_type[$typeid]);
            if (!empty($type['data'])) {
                $xtpl->assign('OTHER', nv_theme_bookhouse_project_detail_other($type['data'], $generate_page));
            }
        }
        $xtpl->parse('main.head_title');
        $xtpl->parse('main.type');
    }

}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $rows['title'];
$description = $rows['description'];

$array_mod_title[] = array(
    'title' => $lang_module['projects'],
    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['projects']
);
$array_mod_title[] = array(
    'title' => $page_title
);

include NV_ROOTDIR . '/includes/header.php';
// var_dump($ajax); die;
echo nv_site_theme($contents, !$ajax);
include NV_ROOTDIR . '/includes/footer.php';