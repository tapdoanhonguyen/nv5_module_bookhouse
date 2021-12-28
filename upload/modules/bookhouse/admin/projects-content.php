<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2017 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 03 Jan 2017 03:28:49 GMT
 */
if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

if ($nv_Request->isset_request('get_alias_title', 'post')) {
    $alias = $nv_Request->get_title('get_alias_title', 'post', '');
    $alias = change_alias($alias);
    die($alias);
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['alias'] = $nv_Request->get_title('alias', 'post', '');
    $row['alias'] = (empty($row['alias'])) ? change_alias($row['title']) : change_alias($row['alias']);
    $row['description'] = $nv_Request->get_string('description', 'post', '');
    $row['descriptionhtml'] = $nv_Request->get_editor('descriptionhtml', '', NV_ALLOWED_HTML_TAGS);
	$row['provinceid'] = $nv_Request->get_int('provinceid', 'post', 0);
    $row['districtid'] = $nv_Request->get_int('districtid', 'post', 0);
    $row['wardid'] = $nv_Request->get_int('wardid', 'post', 0);

    if (empty($row['title'])) {
        $error[] = $lang_module['error_required_title'];
    } elseif (empty($row['description'])) {
        $error[] = $lang_module['error_required_description'];
    }elseif (empty($row['provinceid'])) {
        $error[] = $lang_module['error_required_location'];
    }
    
    if (empty($error)) {
        try {
            if (empty($row['id'])) {
                $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_projects (title, alias, description, descriptionhtml, provinceid, districtid, wardid) VALUES (:title, :alias, :description, :descriptionhtml, :provinceid, :districtid, :wardid)');
            } else {
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_projects SET title = :title, alias = :alias, description = :description, descriptionhtml = :descriptionhtml, provinceid = :provinceid, districtid = :districtid, wardid = :wardid WHERE id=' . $row['id']);
            }
            $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
            $stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR, strlen($row['description']));
            $stmt->bindParam(':descriptionhtml', $row['descriptionhtml'], PDO::PARAM_STR, strlen($row['descriptionhtml']));
            $stmt->bindParam(':provinceid', $row['provinceid'], PDO::PARAM_STR);
            $stmt->bindParam(':districtid', $row['districtid'], PDO::PARAM_STR);
            $stmt->bindParam(':wardid', $row['wardid'], PDO::PARAM_STR);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=projects');
                die();
            }
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); // Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $lang_module['projects_add'] = $lang_module['projects_edit'];
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_projects WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
} else {
    $row['id'] = 0;
    $row['title'] = '';
    $row['alias'] = '';
    $row['description'] = '';
    $row['descriptionhtml'] = '';
    $row['provinceid'] = 0;
    $row['districtid'] = 0;
    $row['wardid'] = 0;
}

if (defined('NV_EDITOR'))
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
$row['descriptionhtml'] = htmlspecialchars(nv_editor_br2nl($row['descriptionhtml']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $row['descriptionhtml'] = nv_aleditor('descriptionhtml', '100%', '300px', $row['descriptionhtml']);
} else {
    $row['descriptionhtml'] = '<textarea style="width:100%;height:300px" name="descriptionhtml">' . $row['descriptionhtml'] . '</textarea>';
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

$location = new Location();
$location->set('IsDistrict', 1);
$location->set('IsWard', 1);
$location->set('SelectProvinceid', $row['provinceid']);
$location->set('SelectDistrictid', $row['districtid']);
$location->set('SelectWardid', $row['wardid']);
$location->set('BlankTitleProvince', 1);
$location->set('BlankTitleDistrict', 1);
$location->set('BlankTitleWard', 1);
$location->set('ColClass', 'col-xs-24 col-sm-8 col-md-8');
$xtpl->assign('LOCATION', $location->buildInput());

if (! empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}
if (empty($row['id'])) {
    $xtpl->parse('main.auto_get_alias');
}

// lấy danh sách nội thất ra
$ds_noithat = $db->query('SELECT * FROM '. NV_PREFIXLANG . '_' . $module_data . '_furniture ORDER BY id DESC')->fetchAll();

if(!empty($ds_noithat))
{
	$mang_noithat = explode(',', $row['noithat']); 
	foreach($ds_noithat as $ti)
	{
		if(in_array($ti['id'],$mang_noithat))
		$xtpl->assign( 'checked', 'checked=checked');
		else $xtpl->assign( 'checked', '');
		$xtpl->assign( 'noithat', $ti );
		$xtpl->parse( 'main.noithat' );
	}

}
	
	// lấy danh sách tiện ích ra
$ds_tienich = $db->query('SELECT * FROM '. NV_PREFIXLANG . '_' . $module_data . '_convenient ORDER BY id DESC')->fetchAll();

if(!empty($ds_tienich))
{
	$mang_tienich = explode(',',$row['tienich']);
	foreach($ds_tienich as $ti)
	{
		if(in_array($ti['id'],$mang_tienich))
		$xtpl->assign( 'checked', 'checked=checked');
		else $xtpl->assign( 'checked', '');
		$xtpl->assign( 'tienich', $ti );
		$xtpl->parse( 'main.tienich' );
	}

}
$xtpl->parse('main');
$contents = $xtpl->text('main');

$set_active_op = 'projects';
$page_title = $lang_module['projects_add'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
