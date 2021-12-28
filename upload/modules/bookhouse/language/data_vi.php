<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC.
 * All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 20:59
 */
if (! defined('NV_ADMIN')) {
    die('Stop!!!');
}

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, parentid, title, alias, description, groups_view, weight, status) VALUES('2', '0', 'Nhà cho thuê', 'Nha-cho-thue', '', '6', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, parentid, title, alias, description, groups_view, weight, status) VALUES('3', '0', 'Đất cho thuê', 'Dat-cho-thue', '', '6', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, parentid, title, alias, description, groups_view, weight, status) VALUES('4', '3', 'Đất nền', 'Dat-nen', '', '6', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, parentid, title, alias, description, groups_view, weight, status) VALUES('5', '3', 'Đất chung cư', 'Dat-chung-cu', '', '6', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, parentid, title, alias, description, groups_view, weight, status) VALUES('6', '3', 'Phố', 'Pho', '', '6', '3', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, parentid, title, alias, description, groups_view, weight, status) VALUES('7', '3', 'Hẽm', 'Hem', '', '6', '4', '1')");

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_legal (id, title, alias, note, weight, status) VALUES('1', 'Sổ đỏ', 'So-do', '', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_legal (id, title, alias, note, weight, status) VALUES('2', 'Sổ hồng', 'So-hong', '', '2', '1')");

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_way (id, title, alias, note, weight, status) VALUES('3', 'Đông', 'Dong', '', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_way (id, title, alias, note, weight, status) VALUES('4', 'Tây', 'Tay', '', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_way (id, title, alias, note, weight, status) VALUES('5', 'Nam', 'Nam', '', '3', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_way (id, title, alias, note, weight, status) VALUES('6', 'Bắc', 'Bac', '', '4', '1')");