<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */
if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$page_title = $lang_module['groups'];

if ($nv_Request->isset_request('get_alias_title', 'post')) {
    $alias = $nv_Request->get_title('get_alias_title', 'post', '');
    $alias = change_alias($alias);
    die($alias);
}

if ($nv_Request->isset_request('del_block_cat', 'post')) {
    $bid = $nv_Request->get_int('bid', 'post', 0);
    
    $contents = "NO_" . $bid;
    $bid = $db->query("SELECT bid FROM " . NV_PREFIXLANG . "_" . $module_data . "_block_cat WHERE bid=" . intval($bid))->fetchColumn();
    if ($bid > 0) {
        nv_insert_logs(NV_LANG_DATA, $module_name, 'log_del_blockcat', "block_catid " . $bid, $admin_info['userid']);
        $query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_block_cat WHERE bid=" . $bid;
        if ($db->exec($query)) {
            $query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_block WHERE bid=" . $bid;
            $db->query($query);
            nv_fix_block_cat();
            $nv_Cache->delMod($module_name);
            $contents = "OK_" . $bid;
        }
    }
    
    include NV_ROOTDIR . '/includes/header.php';
    echo $contents;
    include NV_ROOTDIR . '/includes/footer.php';
}

$error = '';
$savecat = 0;
list ($bid, $title, $alias, $description, $image, $keywords, $color) = array(
    0,
    '',
    '',
    '',
    '',
    '',
    ''
);
$currentpath = NV_UPLOADS_DIR . '/' . $module_upload;

$savecat = $nv_Request->get_int('savecat', 'post', 0);
if (! empty($savecat)) {
    $bid = $nv_Request->get_int('bid', 'post', 0);
    $title = $nv_Request->get_title('title', 'post', '', 1);
    $keywords = $nv_Request->get_title('keywords', 'post', '', 1);
    $alias = $nv_Request->get_title('alias', 'post', '');
    $description = $nv_Request->get_string('description', 'post', '');
    $description = nv_nl2br(nv_htmlspecialchars(strip_tags($description)), '<br />');
    $alias = ($alias == '') ? change_alias($title) : change_alias($alias);
    $color = $nv_Request->get_title('group_color', 'post', '', 1);
    
    $image = $nv_Request->get_string('image', 'post', '');
    if (is_file(NV_DOCUMENT_ROOT . $image)) {
        $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/');
        $image = substr($image, $lu);
    } else {
        $image = '';
    }
    
    if (empty($title)) {
        $error = $lang_module['error_name'];
    } elseif ($bid == 0) {
        $weight = $db->query("SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_block_cat")->fetchColumn();
        $weight = intval($weight) + 1;
        
        $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_block_cat (adddefault, numbers, title, alias, description, color, image, weight, keywords, add_time, edit_time) VALUES (0, 4, :title , :alias, :description, :color, :image, :weight, :keywords, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";
        $data_insert = array();
        $data_insert['title'] = $title;
        $data_insert['alias'] = $alias;
        $data_insert['description'] = $description;
        $data_insert['color'] = $color;
        $data_insert['image'] = $image;
        $data_insert['weight'] = $weight;
        $data_insert['keywords'] = $keywords;
        
        if ($db->insert_id($sql, 'bid', $data_insert)) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_add_blockcat', " ", $admin_info['userid']);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            die();
        } else {
            $error = $lang_module['errorsave'];
        }
    } else {
        $stmt = $db->prepare("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_block_cat SET title= :title, alias = :alias, description= :description, color = :color, image= :image, keywords= :keywords, edit_time=" . NV_CURRENTTIME . " WHERE bid =" . $bid);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':keywords', $keywords, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->execute()) {
            $nv_Cache->delMod($module_name);
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_edit_blockcat', "blockid " . $bid, $admin_info['userid']);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            die();
        } else {
            $error = $lang_module['errorsave'];
        }
    }
}

$bid = $nv_Request->get_int('bid', 'get', 0);
if ($bid > 0) {
    list ($bid, $title, $alias, $description, $image, $keywords, $color) = $db->query("SELECT bid, title, alias, description, image, keywords, color FROM " . NV_PREFIXLANG . "_" . $module_data . "_block_cat where bid=" . $bid)->fetch(3);
    $lang_module['add_block_cat'] = $lang_module['edit_block_cat'];
}

$xtpl = new XTemplate('groups.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('BLOCK_GROUPS_LIST', nv_show_groups_list());
$xtpl->assign('bid', $bid);
$xtpl->assign('title', $title);
$xtpl->assign('alias', $alias);
$xtpl->assign('keywords', $keywords);
$xtpl->assign('description', nv_htmlspecialchars(nv_br2nl($description)));
$xtpl->assign('color', $color);

if (! empty($image) and file_exists(NV_UPLOADS_REAL_DIR . "/" . $module_upload . "/" . $image)) {
    $image = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_upload . "/" . $image;
    $currentpath = dirname($image);
}
$xtpl->assign('image', $image);
$xtpl->assign('UPLOAD_CURRENT', $currentpath);
$xtpl->assign('UPLOAD_PATH', NV_UPLOADS_DIR . '/' . $module_upload);

if (! empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

if (empty($bid)) {
    $xtpl->parse('main.auto_get_alias');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';