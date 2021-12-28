<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 06 Jan 2016 01:50:09 GMT
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

if ($nv_Request->isset_request('delete_other_images_tmp', 'post')) {
    $path = $nv_Request->get_title('path', 'post', '');
    $thumb = $nv_Request->get_title('thumb', 'post', '');
    
    if (empty($path))
        die('NO');
    
    if (! nv_delete_other_images_tmp(NV_ROOTDIR . '/' . $path, NV_ROOTDIR . '/' . $thumb))
        die('NO');
    
    die('OK');
}

$array_data = array();
$error = array();
$array_id_old = array();
$array_id_new = array();

// Tao cấu trúc thư mục thành viên
$uploadpath = nv_create_folder_member();

$rows_id = $nv_Request->get_int('rows_id', 'get', 0);
$place_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $rows_id)->fetch();
if (empty($place_info)) {
    $url_back = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['items'];
    $contents = nv_theme_alert($lang_module['rows_empty_title'], $lang_module['rows_empty_content'], 'danger', $url_back);
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE rows_id=' . $rows_id);
while ($row = $result->fetch()) {
    $array_data[$row['id']] = $row;
    $array_id_old[] = $row['id'];
}

$row = array();
if ($nv_Request->isset_request('submit', 'post')) {
    $row['rows_id'] = $nv_Request->get_int('rows_id', 'post', 0);
    $row['otherimage'] = $nv_Request->get_array('otherimage', 'post');
    
    $count = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE rows_id=' . $rows_id)->fetchColumn();
    
    if (empty($row['rows_id'])) {
        $error[] = $lang_module['images_error_rows_empty'];
    } elseif ($count + sizeof($row['otherimage']) > $array_config['post_image_limit']) {
        $error[] = $lang_module['images_error_image_limit'];
    }
    
    if (empty($error)) {
        foreach ($row['otherimage'] as $otherimage) {
            $array_id_new[] = intval($otherimage['id']);
        }
        
        foreach ($row['otherimage'] as $otherimage) {
            if ($otherimage['id'] == 0) {
                if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'])) {
                    // Copy file từ thư mục tmp sang uploads
                    if (@nv_copyfile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'], NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $uploadpath['currentpath'] . '/' . $otherimage['homeimgfile'])) {
                        $otherimage['homeimgfile'] = str_replace($module_upload . '/', '', $uploadpath['currentpath'] . '/' . $otherimage['homeimgfile']);
                        
                        $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_images( rows_id, title, description, homeimgfile, weight ) VALUES ( :rows_id, :title, :description, :homeimgfile, 0)');
                        $sth->bindParam(':rows_id', $rows_id, PDO::PARAM_INT);
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
        Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&rows_id=' . $rows_id);
        die();
    }
}

$maxfilesize = min($global_config['nv_max_size'], nv_converttoBytes(ini_get('upload_max_filesize')), nv_converttoBytes(ini_get('post_max_size')));
$page_title = sprintf($lang_module['images_of'], $place_info['title']);

$lang_module['items_note2'] = sprintf($lang_module['items_note2'], nv_convertfromBytes($array_config['maxfilesize']), $array_config['image_upload_size']);
$lang_module['items_note6'] = sprintf($lang_module['items_note6'], $array_config['post_image_limit']);

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('UPLOAD_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=upload&token=' . md5($nv_Request->session_id . $global_config['sitekey']));
$xtpl->assign('ID', $rows_id);
$xtpl->assign('MAXFILESIZE', $array_config['maxfilesize']);
$xtpl->assign('MAXIMAGESIZE', explode('x', $array_config['image_upload_size']));
$xtpl->assign('PAGE_TITLE', $page_title);
$xtpl->assign('URL_LIST', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['items'], true));

$i = 0;
if (! empty($array_data)) {
    foreach ($array_data as $data) {
        $data['number'] = $i;
        $data['filepath'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data['homeimgfile'];
        $data['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data['homeimgfile'];
        $data['homeimgfile'] = str_replace(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/', '', $data['homeimgfile']);
        $xtpl->assign('DATA', $data);
        $xtpl->parse('main.data.loop');
        $i ++;
    }
    $xtpl->parse('main.data');
    $xtpl->parse('main.btn_submit');
    $xtpl->parse('main.btn_add_images');
} else {
    $xtpl->parse('main.empty');
}
$xtpl->assign('COUNT', $i);

if ($nv_Request->isset_request('add', 'get')) {
    $xtpl->parse('main.images_add');
} else {
    $xtpl->parse('main.alert_image_add');
}

$count = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE rows_id=' . $rows_id)->fetchColumn();
if ($count >= $array_config['post_image_limit']) {
    $xtpl->parse('main.disabled_add');
}

if (! empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';