<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (! defined('NV_IS_MOD_BOOKHOUSE'))
    die('Stop!!!');

$url = array();
$cacheFile = NV_ROOTDIR . '/' . NV_CACHEDIR . '/' . NV_LANG_DATA . '_' . $module_name . '_Sitemap.cache';
$pa = NV_CURRENTTIME - 7200;

if (($cache = $nv_Cache->getItem($cacheFile)) != false and filemtime($cacheFile) >= $pa) {
    $url = unserialize($cache);
} else {
    $db->sqlreset()
        ->select('id, catid, addtime, alias')
        ->from(NV_PREFIXLANG . '_' . $module_data)
        ->where('status=1 AND status_admin=1 AND is_queue=0 AND inhome=1 AND (exptime > ' . NV_CURRENTTIME . ' OR exptime = 0)')
        ->order('ordertime DESC')
        ->limit(1000);
    $result = $db->query($db->sql());
    
    $url = array();
    
    while (list ($id, $catid_i, $addtime, $alias) = $result->fetch(3)) {
        $catalias = $array_cat[$catid_i]['alias'];
        $url[] = array(
            'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $catalias . '/' . $alias . '-' . $id . $global_config['rewrite_exturl'],
            'publtime' => $addtime
        );
    }
    
    $cache = serialize($url);
    $nv_Cache->setItem($cacheFile, $cache);
}

nv_xmlSitemap_generate($url);
die();