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

if (! nv_function_exists('nv_block_groups_items')) {

    function nv_block_config_groups_items($module, $data_block, $lang_block)
    {
        global $db, $site_mods, $nv_Cache;
        
        $array_temnplate = array(
            'vertical' => $lang_block['vertical'],
            'list' => $lang_block['list']
        );
        
        $html_input = '';
        $html = '<tr>';
        $html .= '<td>' . $lang_block['blockid'] . '</td>';
        $html .= '<td><select name="config_blockid" class="form-control w200">';
        $html .= '<option value="0"> -- </option>';
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_block_cat ORDER BY weight ASC';
        $list = $nv_Cache->db($sql, '', $module);
        foreach ($list as $l) {
            $html_input .= '<input type="hidden" id="config_blockid_' . $l['bid'] . '" value="' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $site_mods[$module]['alias']['groups'] . '/' . $l['alias'] . '" />';
            $html .= '<option value="' . $l['bid'] . '" ' . (($data_block['blockid'] == $l['bid']) ? ' selected="selected"' : '') . '>' . $l['title'] . '</option>';
        }
        $html .= '</select>';
        $html .= $html_input;
        $html .= '<script type="text/javascript">';
        $html .= '	$("select[name=config_blockid]").change(function() {';
        $html .= '		$("input[name=title]").val($("select[name=config_blockid] option:selected").text());';
        $html .= '		$("input[name=link]").val($("#config_blockid_" + $("select[name=config_blockid]").val()).val());';
        $html .= '	});';
        $html .= '</script>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '	<td>' . $lang_block['template'] . '</td>';
        $html .= '	<td><select name="config_template" class="form-control w200">';
        foreach($array_temnplate as $index => $value){
            $sl = (isset($data_block['template']) and $data_block['template'] == $index) ? 'selected="selected"' : '';
            $html .= '<option value="' . $index . '" ' . $sl . ' >' . $value . '</option>';
        }
        $html .= '  </select></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '	<td>' . $lang_block['numrow'] . '</td>';
        $html .= '	<td><input type="text" name="config_numrow" class="form-control w200" size="5" value="' . $data_block['numrow'] . '"/></td>';
        $html .= '</tr>';
        return $html;
    }

    function nv_block_config_groups_items_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['blockid'] = $nv_Request->get_int('config_blockid', 'post', 0);
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['template'] = $nv_Request->get_title('config_template', 'post', 'vertical');
        return $return;
    }

    function nv_block_groups_items($block_config)
    {
        global $module_array_cat, $site_mods, $module_info, $db, $db_config, $module_config, $global_config, $array_config, $nv_Cache, $module_name, $lang_module, $nv_Request, $my_head, $id, $array_groups;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        if($module != $module_name){
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }
        
        $template = 'block_new_items_vertical.tpl';
        if($block_config['template'] == 'list'){
            $template = 'block_new_items_list.tpl';
        }
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bookhouse/' . $template)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
		
                
        $cache_file = NV_LANG_DATA . '_block_groups_items_' . $block_config['bid'] . '_' . NV_CACHE_PREFIX . '.cache';
        if (($cache = $nv_Cache->getItem($module, $cache_file)) != false) {
            $array_block_new_items = unserialize($cache);
        } else {
            require_once NV_ROOTDIR . '/modules/location/location.class.php';
            $location = new Location();
            
            $array_block_new_items = array();
			
           if($block_config['blockid'] == 0)
		   {
			$moi  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
            $db->sqlreset()
                ->select('t1.id, catid, showprice, title, alias, homeimgfile, homeimgalt, homeimgthumb, edittime, ordertime, price, price_time, contact_phone, money_unit, size_v, size_h, area, provinceid, districtid, wardid')
                ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . ' t1')
                ->where('status=1 AND groupid = 0 AND ordertime >= '.$moi.' AND status_admin=1 AND is_queue=0 AND inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0)')
                ->order('ordertime DESC')
                ->limit($block_config['numrow']);
            }
			else
			{
				$db->sqlreset()
                ->select('t1.id, catid, showprice, title, alias, homeimgfile, homeimgalt, homeimgthumb, edittime, ordertime, price, price_time, contact_phone, money_unit, size_v, size_h, area, provinceid, districtid, wardid')
                ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . ' t1')
                ->where('status=1 AND groupid = '. $block_config['blockid'] . ' AND status_admin=1 AND is_queue=0 AND inhome=1 AND (t1.exptime > ' . NV_CURRENTTIME . ' OR t1.exptime = 0)')
                ->order('ordertime DESC')
                ->limit($block_config['numrow']);
			}
			
            $result = $db->query($db->sql());
           
		   $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_pricetype ORDER BY weight ASC';
			$array_pricetype = $db->query($sql)->fetchAll();
		
            while ($row = $result->fetch()) {
                $link = $module_array_cat[$row['catid']]['link'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
                $imgurl = nv_bookhouse_get_image($row['homeimgfile'], $row['homeimgthumb'], $module, $block_theme);
             //  print_r($row['price_time']);die;
                $array_block_new_items[] = array(
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'link' => $link,
                    'showprice' => $row['showprice'],
                    'area' => $row['area'],
                    'imgurl' => $imgurl,
                    'contact_phone' => $row['contact_phone'],
                    'edittime' => date('d/m/Y',$row['edittime']),
                    'ordertime' => date('d/m/Y',$row['ordertime']), 
                    'size_v' => $row['size_v'],
                    'size_h' => $row['size_h'],
                    'location' => $location->locationString($row['provinceid'], $row['districtid'], $row['wardid']),
                    'price' => $row['price']. ' '. $array_pricetype[$row['price_time']]['title']
                );
            }
            if(!defined('NV_IS_MODADMIN')){
                $cache = serialize($array_block_new_items);
                $nv_Cache->setItem($module, $cache_file, $cache);
            }
        }
        
        if($module != $module_name){
            $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/bookhouse.css">';
        }
        
        $xtpl = new XTemplate($template, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bookhouse/');
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('TEMPLATE', $block_theme);
        
        $xtpl->assign('THUMB_WIDTH', $array_config['thumb_width']);
		
		// LẤY MÀU CỦA GROUP 
		if($block_config['blockid'] > 0)
		{	
		
		if(!empty($array_groups[$block_config['blockid']]['image']))
		$image_block = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $array_groups[$block_config['blockid']]['image'];
		
		$xtpl->assign('ma_mau', $array_groups[$block_config['blockid']]['color']);
		
		
		}
       // print_r($array_block_new_items);die;
        foreach ($array_block_new_items as $array_new_items) {
            $xtpl->assign('blocknew_items', $array_new_items);
            
            if ($array_config['sizetype'] == 0) {
                $xtpl->parse('main.newloop.area');
            } elseif ($array_config['sizetype'] == 1) {
                if(!empty($array_new_items['size_v']) and !empty($array_new_items['size_h'])){
                    $xtpl->parse('main.newloop.size.content');
                }
                $xtpl->parse('main.newloop.size');
            }
            if(!empty($image_block))
			{
			$xtpl->assign('image_block', $image_block);
			$xtpl->parse('main.newloop.image');
			$xtpl->parse('main.newloop.image_mobile');
			}
			//print_r($array_new_items);die;
			if ($array_new_items['showprice'] and $array_new_items['price'] > 0) {
                $xtpl->parse('main.newloop.price');
            } else {
                $xtpl->parse('main.newloop.contact');
            }
			
            $xtpl->parse('main.newloop');
        }
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $listcat, $array_config, $module_array_cat, $array_groups;

    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $listcat;
        } else {
			
			$array_groups = array();
            $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_block_cat ORDER BY weight ASC';
            $array_groups = $nv_Cache->db($sql, 'bid', $module);
			
            $module_array_cat = array();
            $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_categories ORDER BY parentid, weight ASC';
            $list = $nv_Cache->db($sql, 'id', $module);
            foreach ($list as $l) {
                $module_array_cat[$l['id']] = $l;
                $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
            }
            
            $sql = "SELECT config_name, config_value FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_config";
            $list = $nv_Cache->db($sql, '', $module);
            foreach ($list as $ls) {
                $array_config[$ls['config_name']] = $ls['config_value'];
            }
        }
        $content = nv_block_groups_items($block_config);
    }
}