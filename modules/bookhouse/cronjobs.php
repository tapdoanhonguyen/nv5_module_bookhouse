<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
define('NV_SYSTEM', true);

// Xac dinh thu muc goc cua site
define('NV_ROOTDIR', pathinfo(str_replace(DIRECTORY_SEPARATOR, '/', __file__), PATHINFO_DIRNAME));

require NV_ROOTDIR . '/includes/mainfile.php';
require NV_ROOTDIR . '/includes/core/user_functions.php';

$language_query = $db->query('SELECT lang FROM ' . $db_config['prefix'] . '_setup_language WHERE setup = 1');
while (list ($lang) = $language_query->fetch(3)) {
    $mquery = $db->query("SELECT title, module_data FROM " . $db_config['prefix'] . "_" . $lang . "_modules WHERE module_file = 'bookhouse'");
    while (list ($mod, $mod_data) = $mquery->fetch(3)) {
        
        // Nhóm tin: xóa tin hết hạn
        $result = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_block WHERE exptime > 0 AND exptime <= ' . NV_CURRENTTIME);
        while (list ($id) = $result->fetch(3)) {
            $count = $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_block WHERE id=' . $id);
            if ($count) {
                $db->exec('UPDATE ' . NV_PREFIXLANG . '_' . $mod_data . ' SET group_config = "", prior = 0 WHERE id=' . $id);
            }
        }
    }
}