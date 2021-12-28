<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 27-11-2010 14:43
 */
if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$is_refresh = false;
$array_province_admin = nv_array_province_admin($module_data);

$module_admin = explode(',', $module_info['admins']);
// Xoa cac dieu hanh vien khong co quyen tai module
foreach ($array_province_admin as $userid_i => $value) {
    if (! in_array($userid_i, $module_admin)) {
        $db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_admins WHERE userid = " . $userid_i);
        $is_refresh = true;
    }
}
// Het Xoa cac dieu hanh vien khong co quyen tai module

if (empty($module_info['admins'])) {
    // Thong bao khong co nguoi dieu hanh chung
    $contents = nv_theme_alert($lang_module['admin_no_user_title'], $lang_module['admin_no_user_item']);
}

foreach ($module_admin as $userid_i) {
    $userid_i = intval($userid_i);
    if ($userid_i > 0 && ! isset($array_province_admin[$userid_i])) {
        // Them nguoi dieu hanh chung, voi quyen han Quan ly module
        $sql = "SELECT userid FROM " . NV_PREFIXLANG . "_" . $module_data . "_admins WHERE userid=" . $userid_i . " AND provinceid=0";
        $numrows = $db->query($sql)->fetchColumn();
        if ($numrows == 0) {
            $db->query("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_admins (userid, provinceid, admin, add_item, pub_item, edit_item, del_item, app_item) VALUES ('" . $userid_i . "', '0', '1', '1', '1', '1', '1', '1')");
            $is_refresh = true;
        }
    }
}
if ($is_refresh) {
    $array_province_admin = nv_array_province_admin($module_data);
}

if (defined('NV_IS_ADMIN_FULL_MODULE')) {
    $orders = array(
        'userid',
        'username',
        'full_name',
        'email'
    );
    
    $orderby = $nv_Request->get_string('sortby', 'get', 'userid');
    // die($orderby);
    $ordertype = $nv_Request->get_string('sorttype', 'get', 'DESC');
    if ($ordertype != "ASC") {
        $ordertype = "DESC";
    }
    
    $base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "";
    
    $userid = $nv_Request->get_int('userid', 'get', 0);
    
    $array_permissions_mod = array(
        $lang_module['admin_cat'],
        $lang_module['admin_module'],
        $lang_module['admin_full_module']
    );
    
    if ($nv_Request->isset_request("submit", "post") and $userid > 0) {
        $admin_module = $nv_Request->get_int('admin_module', 'post', 0);
        if ($admin_module == 1 or $admin_module == 2) {
            if (! defined('NV_IS_SPADMIN')) {
                $admin_module = 1;
            }
            $db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_admins WHERE userid = " . $userid);
            $db->query("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_admins (userid, provinceid, admin, add_item, pub_item, edit_item, del_item, app_item) VALUES ('" . $userid . "', '0', '" . $admin_module . "', '1', '1', '1', '1', '1')");
        } else {
            $db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_admins WHERE userid = " . $userid);
            $array_add_item = $nv_Request->get_typed_array('add_item', 'post', 'int', array());
            $array_pub_item = $nv_Request->get_typed_array('pub_item', 'post', 'int', array());
            $array_edit_item = $nv_Request->get_typed_array('edit_item', 'post', 'int', array());
            $array_del_item = $nv_Request->get_typed_array('del_item', 'post', 'int', array());
            $array_app_item = $nv_Request->get_typed_array('app_item', 'post', 'int', array());
            
            $location = new Location();
            $array_province = $location->getArrayProvince('', 1);
            
            if (! empty($array_province)) {
                foreach ($array_province as $provinceid => $provinceinfo) {
                    $add_item_i = (in_array($provinceid, $array_add_item)) ? 1 : 0;
                    $pub_item_i = (in_array($provinceid, $array_pub_item)) ? 1 : 0;
                    $edit_item_i = (in_array($provinceid, $array_edit_item)) ? 1 : 0;
                    $del_item_i = (in_array($provinceid, $array_del_item)) ? 1 : 0;
                    $app_item_i = (in_array($provinceid, $array_app_item)) ? 1 : 0;
                    $db->query("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_admins (userid, provinceid, admin, add_item, pub_item, edit_item, del_item, app_item) VALUES ('" . $userid . "', '" . $provinceid . "', '" . $admin_module . "', '" . $add_item_i . "', '" . $pub_item_i . "', '" . $edit_item_i . "', '" . $del_item_i . "', '" . $app_item_i . "')");
                }
            }
        }
        $base_url = str_replace("&amp;", "&", $base_url) . "&userid=" . $userid;
        Header("Location: " . $base_url . "");
        die();
    }
    $users_list = array();
    if (! empty($module_info['admins'])) {
        $sql = "SELECT * FROM " . NV_USERS_GLOBALTABLE . " where userid IN (" . $module_info['admins'] . ")";
        if (! empty($orderby) and in_array($orderby, $orders)) {
            $orderby_sql = $orderby != 'full_name' ? $orderby : ($global_config['name_show'] == 0 ? "concat(first_name,' ',last_name)" : "concat(last_name,' ',first_name)");
            $sql .= " ORDER BY " . $orderby_sql . " " . $ordertype;
            $base_url .= "&amp;sortby=" . $orderby . "&amp;sorttype=" . $ordertype;
        }
        $result = $db->query($sql);
        while ($row = $result->fetch()) {
            $userid_i = (int) $row['userid'];
            $admin_module = (isset($array_province_admin[$userid_i][0])) ? intval($array_province_admin[$userid_i][0]['admin']) : 0;
            $admin_module_cat = $array_permissions_mod[$admin_module];
            $is_edit = true;
            if ($admin_module == 2 and ! defined('NV_IS_SPADMIN')) {
                $is_edit = false;
            }
            
            $users_list[$row['userid']] = array(
                'userid' => $userid_i,
                'username' => (string) $row['username'],
                'full_name' => nv_show_name_user($row['first_name'], $row['last_name'], $row['username']),
                'email' => (string) $row['email'],
                'admin_module_cat' => $admin_module_cat,
                'is_edit' => $is_edit
            );
        }
    }
    
    if (! empty($users_list)) {
        $head_tds = array();
        $head_tds['userid']['title'] = $lang_module['admin_userid'];
        $head_tds['userid']['href'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;sortby=userid&amp;sorttype=ASC";
        $head_tds['username']['title'] = $lang_module['admin_username'];
        $head_tds['username']['href'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;sortby=username&amp;sorttype=ASC";
        $head_tds['full_name']['title'] = $global_config['name_show'] == 0 ? $lang_module['lastname_firstname'] : $lang_module['firstname_lastname'];
        $head_tds['full_name']['href'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;sortby=full_name&amp;sorttype=ASC";
        $head_tds['email']['title'] = $lang_module['admin_email'];
        $head_tds['email']['href'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;sortby=email&amp;sorttype=ASC";
        
        foreach ($orders as $order) {
            if ($orderby == $order and $ordertype == 'ASC') {
                $head_tds[$order]['href'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;sortby=" . $order . "&amp;sorttype=DESC";
                $head_tds[$order]['title'] .= " &darr;";
            } elseif ($orderby == $order and $ordertype == 'DESC') {
                $head_tds[$order]['href'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;sortby=" . $order . "&amp;sorttype=ASC";
                $head_tds[$order]['title'] .= " &uarr;";
            }
        }
        
        $xtpl = new XTemplate("admin.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
        $xtpl->assign('LANG', $lang_module);
        foreach ($head_tds as $head_td) {
            $xtpl->assign('HEAD_TD', $head_td);
            $xtpl->parse('main.head_td');
        }
        
        foreach ($users_list as $u) {
            $xtpl->assign('CONTENT_TD', $u);
            if ($u['is_edit']) {
                $xtpl->assign('EDIT_URL', $base_url . "&amp;userid=" . $u['userid']);
                $xtpl->parse('main.xusers.is_edit');
            }
            $xtpl->parse('main.xusers');
        }
        
        if ($userid > 0 and $userid != $admin_id) {
            $admin_module = (isset($array_province_admin[$userid][0])) ? intval($array_province_admin[$userid][0]['admin']) : 0;
            $is_edit = true;
            if ($admin_module == 2 and ! defined('NV_IS_SPADMIN')) {
                $is_edit = false;
            }
            
            if ($is_edit) {
                if (! defined('NV_IS_SPADMIN')) {
                    unset($array_permissions_mod[2]);
                }
                
                foreach ($array_permissions_mod as $value => $text) {
                    $u = array(
                        'value' => $value,
                        'text' => $text,
                        'checked' => ($value == $admin_module) ? " checked=\"checked\"" : ""
                    );
                    $xtpl->assign('ADMIN_MODULE', $u);
                    $xtpl->parse('main.edit.admin_module');
                }
                
                $location = new Location();
                $array_province = $location->getArrayProvince('', 1);
                
                $xtpl->assign('ADMINDISPLAY', ($admin_module > 0) ? "display:none;" : "");
                
                if (! empty($array_province)) {
                    foreach ($array_province as $provinceid => $provinceinfo) {
                        $u = array();
                        $u['provinceid'] = $provinceid;
                        $u['title'] = $provinceinfo['title'];
                        $u['type'] = $provinceinfo['type'];
                        $u['checked_add_item'] = (isset($array_province_admin[$userid][$provinceid]) and $array_province_admin[$userid][$provinceid]['add_item'] == 1) ? " checked=\"checked\"" : "";
                        $u['checked_pub_item'] = (isset($array_province_admin[$userid][$provinceid]) and $array_province_admin[$userid][$provinceid]['pub_item'] == 1) ? " checked=\"checked\"" : "";
                        $u['checked_edit_item'] = (isset($array_province_admin[$userid][$provinceid]) and $array_province_admin[$userid][$provinceid]['edit_item'] == 1) ? " checked=\"checked\"" : "";
                        $u['checked_del_item'] = (isset($array_province_admin[$userid][$provinceid]) and $array_province_admin[$userid][$provinceid]['del_item'] == 1) ? " checked=\"checked\"" : "";
                        $u['checked_app_item'] = (isset($array_province_admin[$userid][$provinceid]) and $array_province_admin[$userid][$provinceid]['app_item'] == 1) ? " checked=\"checked\"" : "";
                        $xtpl->assign('CONTENT', $u);
                        $xtpl->parse('main.edit.province');
                    }
                }
                $xtpl->assign('CAPTION_EDIT', $lang_module['admin_edit_user'] . ": " . $users_list[$userid]['username']);
                $xtpl->parse('main.edit');
            }
        }
        
        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    }
} elseif (defined('NV_IS_ADMIN_MODULE')) {
    $contents = nv_theme_alert($lang_module['admin_no_premission'], $lang_module['admin_module_for_user']);
} else {
    $countryid = 1; // Viet Nam
    $location = new Location();
    $array_province = $location->getArrayProvince('', $countryid);
    
    $xtpl = new XTemplate("admin.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('CAPTION_EDIT', $lang_module['admin_cat_for_user']);
    
    if (! empty($array_province)) {
        foreach ($array_province as $provinceid => $provinceinfo) {
            if (isset($array_province_admin[$admin_id][$provinceid])) {
                $u = array();
                $check_show = false;
                if ($array_province_admin[$admin_id][$provinceid]['admin'] == 1) {
                    $check_show = true;
                } else {
                    if ($array_province_admin[$admin_id][$provinceid]['add_item'] == 1) {
                        $check_show = true;
                    } elseif ($array_province_admin[$admin_id][$provinceid]['pub_item'] == 1) {
                        $check_show = true;
                    } elseif ($array_province_admin[$admin_id][$provinceid]['edit_item'] == 1) {
                        $check_show = true;
                    } elseif ($array_province_admin[$admin_id][$provinceid]['app_item'] == 1) {
                        $check_show = true;
                    }
                }
                if ($check_show) {
                    $u['provinceid'] = $provinceid;
                    $u['title'] = $xtitle_i . $row['title'];
                    $u['checked_add_item'] = (isset($array_province_admin[$admin_id][$provinceid]) and $array_province_admin[$admin_id][$provinceid]['add_item'] == 1) ? "X" : "";
                    $u['checked_pub_item'] = (isset($array_province_admin[$admin_id][$provinceid]) and $array_province_admin[$admin_id][$provinceid]['pub_item'] == 1) ? "X" : "";
                    $u['checked_edit_item'] = (isset($array_province_admin[$admin_id][$provinceid]) and $array_province_admin[$admin_id][$provinceid]['edit_item'] == 1) ? "X" : "";
                    $u['checked_del_item'] = (isset($array_province_admin[$admin_id][$provinceid]) and $array_province_admin[$admin_id][$provinceid]['del_item'] == 1) ? "X" : "";
                    $u['checked_app_item'] = (isset($array_province_admin[$admin_id][$provinceid]) and $array_province_admin[$admin_id][$provinceid]['app_item'] == 1) ? "X" : "";
                    $xtpl->assign('CONTENT', $u);
                    $xtpl->parse('view_user.catid');
                }
            }
        }
    }
    
    $xtpl->parse('view_user');
    $contents = $xtpl->text('view_user');
}

$page_title = $lang_module['admin'];
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
