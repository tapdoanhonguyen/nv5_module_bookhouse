<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:14
 */
if (! defined('NV_IS_MOD_BOOKHOUSE'))
    die('Stop!!!');

$alias = $nv_Request->get_title('alias', 'get');
$array_op = explode('/', $alias);
$alias = $array_op[0];

if (isset($array_op[1])) {
    if (sizeof($array_op) == 2 and preg_match('/^page\-([0-9]+)$/', $array_op[1], $m)) {
        $page = intval($m[1]);
    } else {
        $alias = '';
    }
}
$page_title = trim(str_replace('-', ' ', $alias));

if (! empty($page_title) and $page_title == strip_punctuation($page_title)) {
    $stmt = $db->prepare('SELECT tid, image, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags WHERE alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    list ($tid, $image_tag, $description, $key_words) = $stmt->fetch(3);
    
    if ($tid > 0) {
        $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=tag/' . $alias;
        if ($page > 1) {
            $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
        }
        
        $array_data = array();
        
        $db->sqlreset()
            ->select('COUNT(*) ')
            ->from(NV_PREFIXLANG . '_' . $module_data)
            ->where('status=1 AND status_admin=1 AND is_queue=0 AND inhome=1 AND (exptime > ' . NV_CURRENTTIME . ' OR exptime = 0) AND id IN (SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE tid=' . $tid . ')');
        
        $num_items = $db->query($db->sql())
            ->fetchColumn();
        
        $db->select('id, catid, title, alias, code, area, size_v, size_h, price, addtime, edittime, admin_id, provinceid, districtid, wardid, way_id, address, structure, price_time, bodytext, homeimgfile, homeimgthumb, showprice')
            ->order('ordertime DESC')
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);
        
        $result = $db->query($db->sql());
        while ($item = $result->fetch()) {
			$item['edittime'] = date('d/m/Y',$item['edittime']);
            $array_data[] = nv_data_show($item);
        }
       
       
        if (! empty($image_tag)) {
            $image_tag = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/topics/' . $image_tag;
        }
        
        $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '='.$op.'/'.$alias;
        $html_pages = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
        
        $contents = call_user_func('nv_theme_viewcat',$page_title, $array_data, $html_pages);
        
        $array_mod_title[] = array(
            'title' => $page_title,
            'link' => $base_url
        );
        
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_site_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    }
}

$redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);