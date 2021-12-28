<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (! defined('NV_ADMIN') or ! defined('NV_MAINFILE') or ! defined('NV_IS_MODADMIN'))
    die('Stop!!!');

define('NV_IS_FILE_ADMIN', true);
if ($NV_IS_ADMIN_MODULE) {
    define('NV_IS_ADMIN_MODULE', true);
}

if ($NV_IS_ADMIN_FULL_MODULE) {
    define('NV_IS_ADMIN_FULL_MODULE', true);
}

require_once NV_ROOTDIR . '/modules/' . $module_file . '/site.functions.php';
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

if (! function_exists('nv_array_province_admin')) {

    function nv_array_province_admin($module_data)
    {
        global $db_slave;
        
        $array_province_admin = array();
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins ORDER BY userid ASC';
        $result = $db_slave->query($sql);
        
        while ($row = $result->fetch()) {
            $array_province_admin[$row['userid']][$row['provinceid']] = $row;
        }
        
        return $array_province_admin;
    }
}

/**
 * nv_show_groups_list()
 *
 * @return
 *
 */
function nv_show_groups_list()
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $module_info;
    
    $groups_list = nv_groups_list();
    
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
    $_array_block_cat = $db->query($sql)->fetchAll();
    $num = sizeof($_array_block_cat);
    
    if ($num > 0) {
        $array_useradd = $array_adddefault = array(
            $lang_global['no'],
            $lang_global['yes']
        );
        
        $xtpl = new XTemplate('blockcat_lists.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('GLANG', $lang_global);
        
        foreach ($_array_block_cat as $row) {
            $numnews = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $row['bid'])->fetchColumn();
            
            $xtpl->assign('ROW', array(
                'bid' => $row['bid'],
                'title' => $row['title'],
                'numnews' => $numnews,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=block&amp;bid=' . $row['bid'],
                'linksite' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $row['alias'],
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;bid=' . $row['bid'] . '#edit'
            ));
            
            for ($i = 1; $i <= $num; ++ $i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }
            
            foreach ($array_useradd as $key => $val) {
                $xtpl->assign('USERADD', array(
                    'key' => $key,
                    'title' => $val,
                    
                    'selected' => $key == $row['useradd'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.useradd');
            }
            
            for ($i = 0; $i <= $num; ++ $i) {
                $xtpl->assign('PRIOR', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['prior'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.prior');
            }
            
            foreach ($array_adddefault as $key => $val) {
                $xtpl->assign('ADDDEFAULT', array(
                    'key' => $key,
                    'title' => $val,
                    'selected' => $key == $row['adddefault'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.adddefault');
            }
            
            for ($i = 1; $i <= 30; ++ $i) {
                $xtpl->assign('NUMBER', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['numbers'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.number');
            }
            
            foreach ($groups_list as $groupid => $grouptitle) {
                $xtpl->assign('GROUPS', array(
                    'groupid' => $groupid,
                    'title' => $grouptitle,
                    'selected' => $groupid == $row['groups'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.groups');
            }
            
            $xtpl->parse('main.loop');
        }
        
        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }
    
    return $contents;
}

/**
 * nv_fix_block_cat()
 *
 * @return
 *
 */
function nv_fix_block_cat()
{
    global $db, $module_data;
    
    $sql = 'SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
    $weight = 0;
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        ++ $weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat SET weight=' . $weight . ' WHERE bid=' . intval($row['bid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_show_block_list()
 *
 * @param mixed $bid            
 * @return
 *
 */
function nv_show_block_list($bid)
{
    global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $array_cat;
    
    $xtpl = new XTemplate('block_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('BID', $bid);
    
    $array_jobs[0] = array(
        'alias' => 'Other'
    );
    
    $sql = 'SELECT t1.id, t1.catid, t1.title, t1.alias, t2.weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_block t2 ON t1.id = t2.id WHERE t2.bid= ' . $bid . ' AND t1.status=1 ORDER BY t2.weight ASC';
    $array_block = $db->query($sql)->fetchAll();
    
    $num = sizeof($array_block);
    if ($num > 0) {
        foreach ($array_block as $row) {
            $xtpl->assign('ROW', array(
                'id' => $row['id'],
                'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'],
                'title' => $row['title']
            ));
            
            for ($i = 1; $i <= $num; ++ $i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }
            
            $xtpl->parse('main.loop');
        }
        
        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }
    
    return $contents;
}

/**
 * nv_fix_block()
 *
 * @param mixed $bid            
 * @param bool $repairtable            
 * @return
 *
 */
function nv_fix_block($bid, $repairtable = true)
{
    global $db, $module_data;
    
    $bid = intval($bid);
    
    if ($bid > 0) {
        $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $bid . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch()) {
            ++ $weight;
            if ($weight <= 100) {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block SET weight=' . $weight . ' WHERE bid=' . $bid . ' AND id=' . $row['id'];
            } else {
                $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE bid=' . $bid . ' AND id=' . $row['id'];
            }
            $db->query($sql);
        }
        $result->closeCursor();
        if ($repairtable) {
            $db->query('OPTIMIZE TABLE ' . NV_PREFIXLANG . '_' . $module_data . '_block');
        }
    }
}

function nv_admin_del_items($id)
{
    global $db, $module_data, $admin_info, $module_name, $array_province_del_item;
    
    $result = $db->query('SELECT id, title, provinceid, homeimgfile FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id = ' . $id);
    $num = $result->rowCount();
    
    if ($num < 1) {
        return false;
    }
    
    $items = $result->fetch();
    
  //  if (in_array($items['provinceid'], $array_province_del_item)) {
    if (true) {
        if (nv_del_items($id, $items['homeimgfile'])) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete items', 'Title: ' . $items['title'], $admin_info['userid']);
            return true;
        }
        return false;
    }
    return false;
}

/**
 * nv_fix_order()
 *
 * @param integer $parentid            
 * @param integer $order            
 * @param integer $lev            
 * @return
 *
 */
function nv_fix_order($table_name, $parentid = 0, $sort = 0, $lev = 0)
{
    global $db, $db_config, $module_data;
    
    $sql = 'SELECT id, parentid FROM ' . $table_name . ' WHERE parentid=' . $parentid . ' ORDER BY weight ASC';
    $result = $db->query($sql);
    $array_order = array();
    while ($row = $result->fetch()) {
        $array_order[] = $row['id'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++ $lev;
    } else {
        $lev = 0;
    }
    foreach ($array_order as $order_i) {
        ++ $sort;
        ++ $weight;
        
        $sql = 'UPDATE ' . $table_name . ' SET weight=' . $weight . ', sort=' . $sort . ', lev=' . $lev . ' WHERE id=' . $order_i;
        $db->query($sql);
        
        $sort = nv_fix_order($table_name, $order_i, $sort, $lev);
    }
    
    $numsub = $weight;
    
    if ($parentid > 0) {
        $sql = "UPDATE " . $table_name . " SET numsub=" . $numsub;
        if ($numsub == 0) {
            $sql .= ",subid=''";
        } else {
            $sql .= ",subid='" . implode(",", $array_order) . "'";
        }
        $sql .= " WHERE id=" . intval($parentid);
        $db->query($sql);
    }
    return $sort;
}

function nv_delete_projects($projectid)
{
    global $db, $module_data;
    
    $count = $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_projects  WHERE id=' . $projectid);
    if ($count > 0) {
        //
    }
}
