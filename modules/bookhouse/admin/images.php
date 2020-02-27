<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 06 Jan 2016 01:50:09 GMT
 */
if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

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

$username_alias = change_alias($admin_info['username']);
$array_structure_image = array();
$array_structure_image[''] = $module_upload;
$array_structure_image['Y'] = $module_upload . '/' . date('Y');
$array_structure_image['Ym'] = $module_upload . '/' . date('Y_m');
$array_structure_image['Y_m'] = $module_upload . '/' . date('Y/m');
$array_structure_image['Ym_d'] = $module_upload . '/' . date('Y_m/d');
$array_structure_image['Y_m_d'] = $module_upload . '/' . date('Y/m/d');
$array_structure_image['username'] = $module_upload . '/' . $username_alias;

$array_structure_image['username_Y'] = $module_upload . '/' . $username_alias . '/' . date('Y');
$array_structure_image['username_Ym'] = $module_upload . '/' . $username_alias . '/' . date('Y_m');
$array_structure_image['username_Y_m'] = $module_upload . '/' . $username_alias . '/' . date('Y/m');
$array_structure_image['username_Ym_d'] = $module_upload . '/' . $username_alias . '/' . date('Y_m/d');
$array_structure_image['username_Y_m_d'] = $module_upload . '/' . $username_alias . '/' . date('Y/m/d');

$structure_upload = isset($array_config['structure_upload']) ? $array_config['structure_upload'] : 'Ym';
$currentpath = isset($array_structure_image[$structure_upload]) ? $array_structure_image[$structure_upload] : '';

if (file_exists(NV_UPLOADS_REAL_DIR . '/' . $currentpath)) {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $currentpath;
} else {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $module_upload;
    $e = explode('/', $currentpath);
    if (! empty($e)) {
        $cp = '';
        foreach ($e as $p) {
            if (! empty($p) and ! is_dir(NV_UPLOADS_REAL_DIR . '/' . $cp . $p)) {
                $mk = nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $cp, $p);
                if ($mk[0] > 0) {
                    $upload_real_dir_page = $mk[2];
                    $db->query("INSERT INTO " . NV_UPLOAD_GLOBALTABLE . "_dir (dirname, time) VALUES ('" . NV_UPLOADS_DIR . "/" . $cp . $p . "', 0)");
                }
            } elseif (! empty($p)) {
                $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $cp . $p;
            }
            $cp .= $p . '/';
        }
    }
    $upload_real_dir_page = str_replace('\\', '/', $upload_real_dir_page);
}

$currentpath = str_replace(NV_ROOTDIR . '/', '', $upload_real_dir_page);
$uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload;
if (! defined('NV_IS_SPADMIN') and strpos($structure_upload, 'username') !== false) {
    $array_currentpath = explode('/', $currentpath);
    if ($array_currentpath[2] == $username_alias) {
        $uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload . '/' . $username_alias;
    }
}

$rows_id = $nv_Request->get_int('rows_id', 'get', 0);
$place_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $rows_id)->fetch();

$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_images WHERE rows_id=' . $rows_id);
while ($row = $result->fetch()) {
    $array_data[$row['id']] = $row;
    $array_id_old[] = $row['id'];
}

$row = array();
if ($nv_Request->isset_request('submit', 'post')) {
    $row['rows_id'] = $nv_Request->get_int('rows_id', 'post', 0);
    $row['otherimage'] = $nv_Request->get_array('otherimage', 'post');
    
    if (empty($row['rows_id'])) {
        $error[] = $lang_module['images_error_rows_empty'];
    }
    
    if (empty($error)) {
        foreach ($row['otherimage'] as $otherimage) {
            $array_id_new[] = intval($otherimage['id']);
        }
        
        foreach ($row['otherimage'] as $otherimage) {
            if ($otherimage['id'] == 0) {
                if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'])) {
                    // Copy file từ thư mục tmp sang uploads
                    if (@nv_copyfile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $otherimage['homeimgfile'], NV_ROOTDIR . '/' . $currentpath . '/' . $otherimage['homeimgfile'])) {
                        $otherimage['homeimgfile'] = str_replace(NV_UPLOADS_DIR . '/' . $module_upload . '/', '', $currentpath . '/' . $otherimage['homeimgfile']);
                        
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
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&rows_id=' . $rows_id);
        die();
    }
}

$maxfilesize = min($global_config['nv_max_size'], nv_converttoBytes(ini_get('upload_max_filesize')), nv_converttoBytes(ini_get('post_max_size')));

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('UPLOAD_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=upload&token=' . md5($nv_Request->session_id . $global_config['sitekey']));
$xtpl->assign('ID', $rows_id);
$xtpl->assign('MAXFILESIZE', $maxfilesize);

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

if (! empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = sprintf($lang_module['images_of'], $place_info['title']);

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';