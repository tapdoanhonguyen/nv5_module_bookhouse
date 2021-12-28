<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');

if (! nv_function_exists('nv_block_bookhouse_user_tk')) {

	function nv_taikhoan_number_format1($number, $decimals = 0)
	{
		global $array_config;
		
		$str = number_format($number, $decimals, $array_config['thousands_sep'], '.');
		
		return $str;
	}

    function nv_block_bookhouse_user_tk($block_config)
    {
        global $db, $db_config, $site_mods, $module_info, $module_name, $module_config, $global_config, $lang_module, $op, $user_info, $array_config;
        
        if (! defined('NV_IS_USER')) {
            return '';
        }
        
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        
        if ($module != $module_name) {
            require_once NV_ROOTDIR . '/modules/' . $site_mods[$module]['module_file'] . '/language/' . NV_LANG_INTERFACE . '.php';
            require_once NV_ROOTDIR . '/modules/' . $site_mods[$module]['module_file'] . '/site.functions.php';
        }
        $array_data = array(
            'refresh_free' => 0,
            'refresh' => 0,
            'actived' => 0,
            'queue' => 0,
            'decline' => 0
        );
        
        if ($array_config['refresh_allow']) {
            if ($array_config['refresh_free']) {
                $array_data['refresh_free'] = nv_count_refresh_free($module);
            }
            $array_data['refresh'] = nv_count_refresh($module);
        }
        
        $result = $db->query('SELECT status, status_admin, is_queue FROM ' . NV_PREFIXLANG . '_' . $mod_data . ' WHERE admin_id=' . $user_info['userid']);
        while ($_row = $result->fetch()) {
            if ($_row['is_queue'] == 1) {
                $array_data['queue'] ++;
            } elseif ($_row['is_queue'] == 2) {
                $array_data['decline'] ++;
            } elseif ($_row['status']) {
                $array_data['actived'] ++;
            }
        }
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/block_user_tk.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $xtpl = new XTemplate('block_user_tk.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('USER', $user_info);
        $xtpl->assign('DS_TINLUU', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=saved');
		//DIE('SELECT title, exptime FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_users_groups WHERE userid=' . $user_info['userid'] . ' AND exptime > ' . NV_CURRENTTIME);
		// Lấy thông tin nhóm hiện tại
            $groupid = $db->query('SELECT groupid, exptime FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_users_groups WHERE userid=' . $user_info['userid'] . ' AND exptime > ' . NV_CURRENTTIME)->fetch();
			
			if($groupid['groupid'] > 0)
			{
			$tennhom = $db->query('SELECT title FROM nv4_users_groups WHERE group_id ='.$groupid['groupid'])->fetchColumn();
			$xtpl->assign('TITLE', $tennhom);
			$xtpl->assign('NGAYHETHAN', date('d/m/Y',$groupid['exptime']));
			$xtpl->parse('main.hethan');
			
			}
			else{
				$xtpl->assign('TITLE', 'tài khoản thường');
				
			
			}
		
		// ĐẾM SỐ TIN BĐS ĐÃ LƯU CỦA USER NÀY
		$db->sqlreset()
		->select('COUNT(*)')
		->from(NV_PREFIXLANG . '_' . $mod_data . '_saved')
		->where('userid=' . $user_info['userid']);
		//print($db->sql());die;
		$dem = $db->query($db->sql())->fetchColumn();
		
		// tiền còn lại trong tài khoản
		//die('SELECT money FROM ' . NV_PREFIXLANG . '_taikhoan_money WHERE userid=' . $user_info['userid']);
		$tien = $db->query('SELECT money_total FROM nv4_wallet_money WHERE userid=' . $user_info['userid'])->fetchColumn();
		
       
        $xtpl->assign('DATA', $array_data);
        $xtpl->assign('dem', $dem);
        $xtpl->assign('tien', nv_taikhoan_number_format1($tien/1000));
        $xtpl->assign('MODULE_NAME', $module);
        
       if ($array_config['refresh_allow']) {
            
            if (! empty($array_config['payport'])) {
                $xtpl->parse('main.refresh.buy_refresh');
            }
            
            if ($array_config['refresh_free']) {
                $xtpl->parse('main.refresh.refresh_free');
            }
            
            $xtpl->parse('main.refresh');
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $array_config, $module_name, $array_config;
    
    $module = $block_config['module'];
    
    if (isset($site_mods[$module])) {
        if ($module != $module_name) {
            $array_config = array();
            $sql = "SELECT config_name, config_value FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_config";
            $list = $nv_Cache->db($sql, '', $module);
            foreach ($list as $ls) {
                $array_config[$ls['config_name']] = $ls['config_value'];
            }
        }
        $content = nv_block_bookhouse_user_tk($block_config);
    }
}