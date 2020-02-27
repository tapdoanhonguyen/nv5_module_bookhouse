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

$groups_list = nv_groups_list();
$upload_dir = NV_UPLOADS_DIR . '/' . $module_upload;

if ($nv_Request->isset_request('saveconfig', 'post')) {
    $data = array();
    $data['display_data'] = $nv_Request->get_int('display_data', 'post', 0);
    $data['display_type'] = $nv_Request->get_title('display_type', 'post', 'viewgrid');
    $data['num_item_page'] = $nv_Request->get_int('num_item_page', 'post', 0);
    $data['thumb_width'] = $nv_Request->get_int('thumb_width', 'post', 0);
    $data['thumb_height'] = $nv_Request->get_int('thumb_height', 'post', 0);
    $data['socialbutton'] = (int) $nv_Request->get_bool('socialbutton', 'post');
    $data['facebookappid'] = $nv_Request->get_title('facebookappid', 'post', '');
    $data['allow_maps'] = $nv_Request->get_bool('allow_maps', 'post');
    $data['maps_appid'] = $nv_Request->get_title('maps_appid', 'post', '');
    $data['allow_contact_info'] = $nv_Request->get_bool('allow_contact_info', 'post');
    $array_config_global['tags_alias'] = $nv_Request->get_int('tags_alias', 'post', 0);
    $array_config_global['auto_tags'] = $nv_Request->get_int('auto_tags', 'post', 0);
    $array_config_global['tags_remind'] = $nv_Request->get_int('tags_remind', 'post', 0);
$array_config_global['time_reloadpage'] = $nv_Request->get_int('time_reloadpage', 'post', 0);
    $_post_groups = $nv_Request->get_array('post_groups', 'post', array());
    $data['post_groups'] = ! empty($_post_groups) ? implode(',', nv_groups_post(array_intersect($_post_groups, array_keys($groups_list)))) : '';
    $data['post_queue'] = (int) $nv_Request->get_bool('post_queue', 'post', 0);
    $data['maxfilesize'] = $nv_Request->get_title('maxfilesize', 'post', '', 0);
$data['auto_resize'] = $nv_Request->get_int('auto_resize', 'post', 0);
    $data['image_upload_size_w'] = $nv_Request->get_int('image_upload_size_w', 'post', 1000);
    $data['image_upload_size_h'] = $nv_Request->get_int('image_upload_size_h', 'post', 1000);
    $data['image_upload_size'] = $data['image_upload_size_w'] . 'x' . $data['image_upload_size_h'];
    $data['post_image_limit'] = $nv_Request->get_int('post_image_limit', 'post', 10);
    $data['post_user_limit'] = $nv_Request->get_int('post_user_limit', 'post', 10);
    $data['structure_upload'] = $nv_Request->get_title('structure_upload', 'post', '', 'Ym');
    $data['structure_upload_user'] = $nv_Request->get_title('structure_upload_user', 'post', 'username_Y');
    $data['sizetype'] = $nv_Request->get_int('sizetype', 'post', 0);
    $data['itemsave'] = $nv_Request->get_int('itemsave', 'post', 0);
    $data['payport'] = $nv_Request->get_int('payport', 'post', 0);
    $data['priceformat'] = $nv_Request->get_int('priceformat', 'post', 0);
    $data['view_on_main'] = $nv_Request->get_int('view_on_main', 'post', 0);
    $data['code_auto'] = $nv_Request->get_int('code_auto', 'post', 0);
    $data['code_format'] = $nv_Request->get_title('code_format', 'post', 'T%06s');
    $data['similar_content'] = $nv_Request->get_int('similar_content', 'post', 80);
    $data['similar_time'] = $nv_Request->get_int('similar_time', 'post', 5);
    $data['money_unit'] = $nv_Request->get_title('money_unit', 'post', '');

    $data['refresh_allow'] = $nv_Request->get_int('refresh_allow', 'post', 0);
    $data['refresh_default'] = $nv_Request->get_int('refresh_default', 'post', 0);
    $data['refresh_free'] = $nv_Request->get_int('refresh_free', 'post', 0);
    $data['refresh_config'] = $nv_Request->get_array('refresh_config', 'post');
    if (! empty($data['refresh_config'])) {
        foreach ($data['refresh_config'] as $index => $config) {
            if (empty($config['number']) or empty($config['price'])) {
                unset($data['refresh_config'][$index]);
            }else{
$data['refresh_config'][$index]['price_sale'] = ! empty($config['price_discount']) ? $config['price_discount'] : $config['price'];
}
        }
    }
    $data['refresh_config'] = ! empty($data['refresh_config']) ? serialize($data['refresh_config']) : '';
    
    $data['refresh_auto_config'] = $nv_Request->get_array('refresh_auto_config', 'post');
    $data['refresh_auto_config'] = ! empty($data['refresh_auto_config']) ? serialize($data['refresh_auto_config']) : '';
    
    $data['payment_style'] = $nv_Request->get_int('payment_style', 'post', 0);
    
    $data['specialgroup_config'] = $nv_Request->get_array('specialgroup_config', 'post');
    if (! empty($data['specialgroup_config'])) {
        foreach ($data['specialgroup_config'] as $groupid => $config) {
            foreach ($config as $index => $value) {
                if (empty($value['time']) or empty($value['price'])) {
                    unset($data['specialgroup_config'][$groupid][$index]);
                }else{
                    $data['specialgroup_config'][$groupid][$index]['price_sale'] = !empty($data['specialgroup_config'][$groupid][$index]['price_discount'])  ? $data['specialgroup_config'][$groupid][$index]['price_discount'] : $data['specialgroup_config'][$groupid][$index]['price'];
                }
            }
        }
    }
    $data['specialgroup_config'] = ! empty($data['specialgroup_config']) ? serialize($data['specialgroup_config']) : '';
    
    $data['upgrade_group_percent'] = $nv_Request->get_int('upgrade_group_percent', 'post', 0);
    $data['upgrade_group_config'] = $nv_Request->get_array('upgrade_group_config', 'post');
    if (! empty($data['upgrade_group_config'])) {
        foreach ($data['upgrade_group_config'] as $groupid => $config) {
            foreach ($config as $index => $value) {
                if (empty($value['time']) or empty($value['price'])) {
                    unset($data['upgrade_group_config'][$groupid][$index]);
                }else{
                    $data['upgrade_group_config'][$groupid][$index]['price_sale'] = !empty($data['upgrade_group_config'][$groupid][$index]['price_discount'])  ? $data['upgrade_group_config'][$groupid][$index]['price_discount'] : $data['upgrade_group_config'][$groupid][$index]['price'];
                }
            }
        }
    }
    $data['upgrade_group_config'] = ! empty($data['upgrade_group_config']) ? serialize($data['upgrade_group_config']) : '';
    
    $data['dec_point'] = '.';
    $data['thousands_sep'] = ',';
    if ($data['priceformat'] == 2) {
        $data['dec_point'] = ',';
        $data['thousands_sep'] = '.';
    }
    
    $sth = $db->prepare("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value = :config_value WHERE config_name = :config_name");
    foreach ($data as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }
    
    $sth = $db->prepare("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = '" . NV_LANG_DATA . "' AND module = :module_name AND config_name = :config_name");
    $sth->bindParam(':module_name', $module_name, PDO::PARAM_STR);
    foreach ($array_config_global as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }
    
    if ($data['thumb_width'] . 'x' . $data['thumb_height'] != $array_config['thumb_width'] . 'x' . $array_config['thumb_height']) {
        // Cập nhật cấu hình ảnh thumb cho module
        $db->query('UPDATE ' . NV_UPLOAD_GLOBALTABLE . '_dir SET thumb_type = 3,
			thumb_width = ' . $data['thumb_width'] . ', thumb_height = ' . $data['thumb_height'] . ', thumb_quality = 90
			WHERE dirname = ' . $db->quote($upload_dir));
        
        // Tạo lại thumb theo kích thước mới
        require_once NV_ROOTDIR . '/modules/' . $module_file . '/upload.functions.php';
        nv_filesListRefresh($upload_dir);
    }
    
    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['logs_update_config'], '', $admin_info['userid']);
    
    $nv_Cache->delMod('settings');
    $nv_Cache->delMod($module_name);
    
    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op);
    die();
}

list ($array_config['image_upload_size_w'], $array_config['image_upload_size_h']) = explode('x', $array_config['image_upload_size']);
$array_config['ck_refresh_allow'] = $array_config['refresh_allow'] ? 'checked="checked"' : '';
$array_config['ck_allow_contact_info'] = $array_config['allow_contact_info'] ? 'checked="checked"' : '';
$array_config['ck_itemsave'] = $array_config['itemsave'] ? 'checked="checked"' : '';
$array_config['ck_code_auto'] = $array_config['code_auto'] ? 'checked="checked"' : '';
$array_config['ck_auto_resize'] = $array_config['auto_resize'] ? 'checked="checked"' : '';

$xtpl = new XTemplate('config.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
$xtpl->assign('DES_POINT', $array_config['dec_point']);
$xtpl->assign('THOUSANDS_SEP', $array_config['thousands_sep']);

$array_structure_admin = array();
$array_structure_admin[''] = NV_UPLOADS_DIR . '/' . $module_upload;
$array_structure_admin['Y'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y');
$array_structure_admin['Ym'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y_m');
$array_structure_admin['Y_m'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y/m');
$array_structure_admin['Ym_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y_m/d');
$array_structure_admin['Y_m_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y/m/d');
$array_structure_admin['username'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin';
$array_structure_admin['username_Y'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y');
$array_structure_admin['username_Ym'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y_m');
$array_structure_admin['username_Y_m'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y/m');
$array_structure_admin['username_Ym_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y_m/d');
$array_structure_admin['username_Y_m_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y/m/d');
$structure_admin_upload = isset($array_config['structure_upload']) ? $array_config['structure_upload'] : "Ym";

$array_structure_user = array();
$array_structure_user['username'] = NV_UPLOADS_DIR . '/' . $module_upload . '/users/username';
$array_structure_user['username_Y'] = NV_UPLOADS_DIR . '/' . $module_upload . '/users/username/' . date('Y');
$array_structure_user['username_Ym'] = NV_UPLOADS_DIR . '/' . $module_upload . '/users/username/' . date('Y_m');
$array_structure_user['username_Y_m'] = NV_UPLOADS_DIR . '/' . $module_upload . '/users/username/' . date('Y/m');
$array_structure_user['username_Ym_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/users/username/' . date('Y_m/d');
$array_structure_user['username_Y_m_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/users/username/' . date('Y/m/d');
$structure_user_upload = isset($array_config['structure_upload_user']) ? $array_config['structure_upload_user'] : "Ym";

// Thu muc uploads
foreach ($array_structure_admin as $type => $dir) {
    $xtpl->assign('STRUCTURE_UPLOAD', array(
        'key' => $type,
        'title' => $dir,
        'selected' => $type == $array_config['structure_upload'] ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.structure_upload_admin');
}

foreach ($array_structure_user as $type => $dir) {
    $xtpl->assign('STRUCTURE_UPLOAD', array(
        'key' => $type,
        'title' => $dir,
        'selected' => $type == $array_config['structure_upload_user'] ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.structure_upload_user');
}

$display_data = array(
    $lang_module['config_display_data_all'],
    $lang_module['config_display_data_cat'],
    $lang_module['config_display_none']
);
foreach ($display_data as $index => $value) {
    $xtpl->assign('DISPLAY_DATA', array(
        'index' => $index,
        'value' => $value,
        'selected' => $index == $array_config['display_data'] ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.display_data');
}

$display_type = array(
    'viewgrid' => $lang_module['config_display_viewgrid'],
    'viewlist' => $lang_module['config_display_viewlist'],
    'viewlist_simple' => $lang_module['config_display_viewlist_simple']
);
foreach ($display_type as $index => $value) {
    $xtpl->assign('DISPLAY_TYPE', array(
        'index' => $index,
        'value' => $value,
        'selected' => $index == $array_config['display_type'] ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.display_type');
}

$array_config = array_merge($array_config, $module_config[$module_name]);

$array_config['tags_alias'] = $array_config['tags_alias'] ? 'checked="checked"' : '';
$array_config['auto_tags'] = $array_config['auto_tags'] ? 'checked="checked"' : '';
$array_config['tags_remind'] = $array_config['tags_remind'] ? 'checked="checked"' : '';
$array_config['socialbutton'] = $array_config['socialbutton'] ? 'checked="checked"' : '';
$array_config['allow_maps'] = $array_config['allow_maps'] ? 'checked="checked"' : '';
$array_config['post_queue'] = $array_config['post_queue'] ? 'checked="checked"' : '';
$array_config['ck_view_on_main'] = $array_config['view_on_main'] ? 'checked="checked"' : '';
$array_config['style_view_on_main'] = ($array_config['display_type'] == 2) ? '' : 'style="display: none"';
$array_config['style_maps_appid'] = $array_config['allow_maps'] ? '' : 'style="display: none"';

$xtpl->assign('CONFIG', $array_config);

$array_post_groups = explode(',', $array_config['post_groups']);
foreach ($groups_list as $_group_id => $_title) {
    $xtpl->assign('OPTION', array(
        'value' => $_group_id,
        'checked' => in_array($_group_id, $array_post_groups) ? ' checked="checked"' : '',
        'title' => $_title
    ));
    $xtpl->parse('main.post_groups');
}

$sys_max_size = min(nv_converttoBytes(ini_get('upload_max_filesize')), nv_converttoBytes(ini_get('post_max_size')));
$p_size = $sys_max_size / 100;
for ($index = 1; $index <= 100; ++ $index) {
    $size = floor($index * 209715.2);
    
    $xtpl->assign('SIZE', array(
        'key' => $size,
        'title' => nv_convertfromBytes($size),
        'selected' => ($size == $array_config['maxfilesize']) ? ' selected="selected"' : ''
    ));
    
    $xtpl->parse('main.maxfilesize');
}

$array_sizetype = array(
    0 => $lang_module['config_typesize_0'],
    1 => $lang_module['config_typesize_1']
);
foreach ($array_sizetype as $index => $value) {
    $ck = $index == $array_config['sizetype'] ? 'checked="checked"' : '';
    $xtpl->assign('SIZETYPE', array(
        'index' => $index,
        'value' => $value,
        'checked' => $ck
    ));
    $xtpl->parse('main.sizetype');
}

$array_price_format = array(
    0 => '15 ' . $lang_module['million'],
    1 => '15 (' . $lang_module['million'] . '/' . $lang_global['month'] . ')',
    2 => '15.000.000',
    3 => '15,000,000'
);
foreach ($array_price_format as $index => $value) {
    $sl = $index == $array_config['priceformat'] ? 'selected="selected"' : '';
    $xtpl->assign('PFORMAT', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.priceformat');
}

// Lam moi tin
if (! empty($array_config['refresh_config'])) {
    $array_config['refresh_config'] = unserialize($array_config['refresh_config']);
} else {
    $array_config['refresh_config'][0] = array(
        'number' => '',
        'price' => ''
    );
}
foreach ($array_config['refresh_config'] as $index => $config) {
    $config['index'] = $index;
    $xtpl->assign('REFRESH_CONFIG', $config);
    $xtpl->parse('main.refresh_config');
}
$xtpl->assign('REFRESH_COUNT', sizeof($array_config['refresh_config']));

$array_config['refresh_auto_config'] = ! empty($array_config['refresh_auto_config']) ? unserialize($array_config['refresh_auto_config']) : array();
if (! empty($array_block_cat)) {
    foreach ($array_block_cat as $index => $value) {
        if ($value['useradd']) {
            $xtpl->assign('REFRESH_AUTO_COUNT', array(
                'index' => $index,
                'title' => $value['title'],
                'value' => (isset($array_config['refresh_auto_config'][$index]) and ! empty($array_config['refresh_auto_config'][$index])) ? $array_config['refresh_auto_config'][$index] : 0
            ));
            $xtpl->parse('main.refresh_auto_config');
        }
    }
}

$array_payport = array();
if (isset($site_mods['wallet'])) {
    $array_payport = array(
        1 => $lang_module['config_payport_taikhoan']
    );
}
if (! empty($array_payport)) {
    foreach ($array_payport as $index => $value) {
        $sl = $index == $array_config['payport'] ? 'selected="selected"' : '';
        $xtpl->assign('PAYPORT', array(
            'index' => $index,
            'value' => $value,
            'selected' => $sl
        ));
        $xtpl->parse('main.payport');
    }
}

$array_config['specialgroup_config'] = ! empty($array_config['specialgroup_config']) ? unserialize($array_config['specialgroup_config']) : array();
if (! empty($array_block_cat)) {
    foreach ($array_block_cat as $index => $value) {
        if ($value['useradd']) {
            $xtpl->assign('SPECIALGROUP', array(
                'index' => $index,
                'value' => $value['title'],
                'count' => isset($array_config['specialgroup_config'][$index]) ? sizeof($array_config['specialgroup_config'][$index]) : 0
            ));
            
            if (! isset($array_config['specialgroup_config'][$index]) or empty($array_config['specialgroup_config'][$index])) {
                $array_config['specialgroup_config'][$index][0] = array(
                    'time' => '',
'unit' => 0,
                    'price' => ''
                );
            }
            
            $number = 0;
            foreach ($array_config['specialgroup_config'][$index] as $specialgroup_config) {
                $specialgroup_config['number'] = $number ++;
                $xtpl->assign('SPECIALGROUP_CONFIG', $specialgroup_config);

if (! empty($array_time_unit)) {
                        foreach ($array_time_unit as $index => $value) {
                            $sl = $index == $specialgroup_config['unit'] ? 'selected="selected"' : '';
                            $xtpl->assign('UNIT', array(
                                'index' => $index,
                                'value' => $value,
                                'selected' => $sl
                            ));
                            $xtpl->parse('main.specialgroup.specialgroup_config.unit');
                        }
                    }

                $xtpl->parse('main.specialgroup.specialgroup_config');
            }
            
            $xtpl->parse('main.specialgroup');
        }
    }
}

$array_config['upgrade_group_config'] = ! empty($array_config['upgrade_group_config']) ? unserialize($array_config['upgrade_group_config']) : array();
if (! empty($array_block_cat)) {
    foreach ($array_block_cat as $value) {
        $index = $value['groups'];
        if ($index > 0) {
            $xtpl->assign('UPGRADE_GROUP', array(
                'index' => $value['groups'],
                'value' => $groups_list[$value['groups']],
                'count' => isset($array_config['upgrade_group_config'][$index]) ? sizeof($array_config['upgrade_group_config'][$index]) + 1 : 1
            ));
            
            if (! isset($array_config['upgrade_group_config'][$index]) or empty($array_config['upgrade_group_config'][$index])) {
                $array_config['upgrade_group_config'][$index][0] = array(
                    'time' => '',
'unit' => 0,
                    'price' => ''
                );
            }
            
            $number = 0;
            foreach ($array_config['upgrade_group_config'][$index] as $upgrade_group_config) {
                $upgrade_group_config['number'] = $number ++;
                $xtpl->assign('UPGRADE_GROUP_CONFIG', $upgrade_group_config);

if (! empty($array_time_unit)) {
                        foreach ($array_time_unit as $index => $value) {
                            $sl = $index == $upgrade_group_config['unit'] ? 'selected="selected"' : '';
                            $xtpl->assign('UNIT', array(
                                'index' => $index,
                                'value' => $value,
                                'selected' => $sl
                            ));
                            $xtpl->parse('main.upgrade_group.upgrade_group_config.unit');
                        }
                    }

                $xtpl->parse('main.upgrade_group.upgrade_group_config');
            }
            
            $xtpl->parse('main.upgrade_group');
        }
    }
}

    if (! empty($array_time_unit)) {
        foreach ($array_time_unit as $index => $value) {
            $xtpl->assign('UNIT', array(
                'index' => $index,
                'value' => $value
            ));
            $xtpl->parse('main.unit_js');
            $xtpl->parse('main.unit_js1');
        }
    }

$array_group_payment_style = array(
    0 => $lang_module['config_group_payment_style_0'],
    1 => $lang_module['config_group_payment_style_1']
);
foreach ($array_group_payment_style as $index => $value) {
    $sl = $index == $array_config['payment_style'] ? 'selected="selected"' : '';
    $xtpl->assign('PAYMENT_STYLE', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.payment_style');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['config'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
