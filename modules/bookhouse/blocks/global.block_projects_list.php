<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */
if (!defined('NV_MAINFILE')) die('Stop!!!');

if (!nv_function_exists('nv_block_projects_list')) {

    function nv_block_config_projects_list($module, $data_block, $lang_block)
    {
        global $db, $site_mods, $nv_Cache;

        $html = '';
        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['numrow'] . ':</label>';
        $html .= '<div class="col-sm-18"><input type="text" class="form-control" name="config_numrow" size="5" value="' . $data_block['numrow'] . '"/></div>';
        $html .= '</div>';
        return $html;
    }

    function nv_block_config_projects_list_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        return $return;
    }

    function nv_block_projects_list($block_config)
    {
        global $site_mods, $module_info, $global_config, $nv_Cache, $module_name, $lang_module, $my_head;

        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];

        if ($module != $module_name) {
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/bookhouse.css">';
			require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            require_once NV_ROOTDIR . '/modules/location/location.class.php';
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/block_projects_list.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
		
	
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_projects WHERE status=1 AND inhome=1 ORDER BY id DESC LIMIT ' . $block_config['numrow'];
        $array_data = $nv_Cache->db($sql, 'id', $module);

        $xtpl = new XTemplate('block_projects_list.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
		
		$location = new Location();

        if (!empty($array_data)) {
            foreach ($array_data as $data) {
                if (!empty($data['homeimg']) && file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $mod_upload . '/' . $data['homeimg'])) {
                    $data['homeimg'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $mod_upload . '/' . $data['homeimg'];
                } elseif (!empty($data['homeimg']) && file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $data['homeimg'])) {
                    $data['homeimg'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $data['homeimg'];
                } else {
                    $data['homeimg'] = '';
                }
                $data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $site_mods[$module]['alias']['project-detail'] . '/' . $data['alias'] . '-' . $data['id'];
				
				$data['location'] = $location->locationString($data['provinceid'], $data['districtid'], $data['wardid'], ' » ', $module_url);
				
		
                $xtpl->assign('DATA', $data);
                if (!empty($data['homeimg'])) {
                    $xtpl->parse('main.loop.homeimg');
                }
                $xtpl->parse('main.loop');
            }
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods;

    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        $content = nv_block_projects_list($block_config);
    }
}
