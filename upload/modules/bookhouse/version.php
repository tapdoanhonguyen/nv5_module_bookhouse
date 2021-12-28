<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');

$module_version = array(
    'name' => 'Bookhouse',
    'modfuncs' => 'main,detail,search,tag,viewcat,items,images,upload,groups,content,ajax,saved,payment,viewlocation,cronjobs,upgrade',
    'change_alias' => 'items,images,groups,content,saved,upgrade',
    'submenu' => 'items,search',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '2.0.01',
    'date' => 'Wed, 13 Aug 2014 00:24:32 GMT',
    'author' => 'mynukeviet (contact@mynukeviet.net)',
    'uploads_dir' => array(
        $module_upload
    ),
    'note' => 'Module đặt thuê nhà, đất'
);