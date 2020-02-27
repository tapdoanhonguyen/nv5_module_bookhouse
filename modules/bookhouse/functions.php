<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
if (! defined('NV_SYSTEM'))
    die('Stop!!!');

define('NV_IS_MOD_BOOKHOUSE', true);

require_once NV_ROOTDIR . '/modules/' . $module_file . '/site.functions.php';
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

//tai lai trang neu co cau hinh lon hon 0
if( $module_config[$module_name]['time_reloadpage'] > 0){
    $time_reload = $module_config[$module_name]['time_reloadpage'] * 60;
    $my_head .= '<meta http-equiv="refresh" content="' . $time_reload . '; URL=' . $client_info['selfurl'] . '">';
}

$page = 1;
$per_page = $array_config['num_item_page'];

$catid = $parentid = 0;
$alias_cat_url = isset($array_op[0]) ? $array_op[0] : '';
$array_mod_title = array();
$listroom = nv_listrooms();

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_pricetype ORDER BY weight ASC';
$array_pricetype = $nv_Cache->db($sql, 'id', $module_name);

// Categories
foreach ($array_cat as $row) {
    $array_cat[$row['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'];
    if ($alias_cat_url == $row['alias']) {
        $catid = $row['id'];
        $parentid = $row['parentid'];
    }
}

$count_op = sizeof($array_op);
$array_location_code = array(
    'w',
    'p',
    'd'
);
//print_r($array_op);die; 
if (! empty($array_op) and $op == 'main') {
    if ($catid == 0 and count($array_op) < 2) {
		$page = intval(substr($array_op[0], 5));
		if($page < 0)
        $contents = $lang_module['nocatpage'] . $array_op[0];
        if (isset($array_op[0]) and substr($array_op[0], 0, 5) == 'page-') {
            $page = intval(substr($array_op[0], 5));
        } elseif (! empty($alias_cat_url)) {
            $op = 'search';
        }
		
		
    } else {
        $op = 'main';
        if (sizeof($array_op) == 2 and in_array($array_op[0], $array_location_code) and preg_match('/^([a-z0-9\-]+)\-([0-9]+)$/i', $array_op[1], $m3)) {
            $op = 'viewlocation';
            $id = $m3[2];
        } elseif ($count_op == 1 or substr($array_op[1], 0, 5) == 'page-') {
            $op = 'viewcat';
			//$page = intval(substr($array_op[1], 5));
			
			
            if ($count_op > 1) {
                $page = intval(substr($array_op[1], 5));
            }
        } elseif ($count_op == 2) {
            $array_page = explode('-', $array_op[1]);
            $id = intval(end($array_page));
            $number = strlen($id) + 1;
            $alias_url = substr($array_op[1], 0, - $number);
            if ($id > 0 and $alias_url != '') {
                $op = 'detail';
				$all = 0;
            }
        }
		elseif ($count_op == 3) {
            $array_page = explode('-', $array_op[1]);
            $id = intval(end($array_page));
            $number = strlen($id) + 1;
            $alias_url = substr($array_op[1], 0, - $number); 
			
            if ($id > 0 and $alias_url != '') {
			
				$tinrao = $db->query("SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data ." WHERE alias = '". $alias_url ."'")->fetchColumn();
				if($tinrao == $id)
				{
					$all = 1;
					$op = 'detail';
					$id = $tinrao;
					if($array_op[2] == 'all')
					{
						$page = 1;
						
					}
					else
					{
					 $page = intval(substr($array_op[2], 5)); 
					 
					}
					
				}
				else
				{
                $op = 'viewlocation';
				$page = intval(substr($array_op[2], 5));
				}
            }
			
        }
		
		
		if($array_op[0] == 'group')
		{
			$op = 'group';
			if(!empty($array_op[2]))
			$page = intval(substr($array_op[2], 5));
		}
			
		
        $parentid = $catid;
        while ($parentid > 0) {
            $array_cat_i = $array_cat[$parentid];
            $array_mod_title[] = array(
                'catid' => $parentid,
                'title' => $array_cat_i['title'],
                'link' => $array_cat_i['link']
            );
            $parentid = $array_cat_i['parentid'];
        }
        sort($array_mod_title, SORT_NUMERIC);
    }
	
	if($op == 'main' and $page == 1)
		$op = 'search';
}

function nv_resize_crop_images($img_path, $width, $height, $module_name = '', $id = 0)
{
    $new_img_path = str_replace(NV_ROOTDIR, '', $img_path);
    if (file_exists($img_path)) {
        $imginfo = nv_is_image($img_path);
        $basename = basename($img_path);
        
        $basename = preg_replace('/^\W+|\W+$/', '', $basename);
        $basename = preg_replace('/[ ]+/', '_', $basename);
        $basename = strtolower(preg_replace('/\W-/', '', $basename));
        
        if ($imginfo['width'] > $width or $imginfo['height'] > $height) {
            $basename = preg_replace('/(.*)(\.[a-zA-Z]+)$/', $module_name . '_' . $id . '_\1_' . $width . '-' . $height . '\2', $basename);
            if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $basename)) {
                $new_img_path = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $basename;
            } else {
                $img_path = new NukeViet\Files\Image($img_path, NV_MAX_WIDTH, NV_MAX_HEIGHT);
                
                $thumb_width = $width;
                $thumb_height = $height;
                $maxwh = max($thumb_width, $thumb_height);
                if ($img_path->fileinfo['width'] > $img_path->fileinfo['height']) {
                    $width = 0;
                    $height = $maxwh;
                } else {
                    $width = $maxwh;
                    $height = 0;
                }
                
                $img_path->resizeXY($width, $height);
                $img_path->cropFromCenter($thumb_width, $thumb_height);
                $img_path->save(NV_ROOTDIR . '/' . NV_TEMP_DIR, $basename);
                
                if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $basename)) {
                    $new_img_path = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $basename;
                }
            }
        }
    }
    return $new_img_path;
}

function gltJsonResponse($error = array(), $data = array())
{
    $contents = array(
        'jsonrpc' => '2.0',
        'error' => $error,
        'data' => $data
    );
    
    header('Content-Type: application/json');
    echo json_encode($contents);
    die();
}

function nv_create_folder_member()
{
    global $db, $module_upload, $user_info, $array_config;
    
    $array = array(
        'currentpath' => '',
        'uploadrealdir' => ''
    );
    
    $username = ! empty($user_info) ? $user_info['username'] : md5($module_upload);
    $username_alias = change_alias($username);
    
    $array_structure_user = array();
    $array_structure_user['username'] = $module_upload . '/users/' . $username_alias;
    $array_structure_user['username_Y'] = $module_upload . '/users/' . $username_alias . '/' . date('Y');
    $array_structure_user['username_Ym'] = $module_upload . '/users/' . $username_alias . '/' . date('Y_m');
    $array_structure_user['username_Y_m'] = $module_upload . '/users/' . $username_alias . '/' . date('Y/m');
    $array_structure_user['username_Ym_d'] = $module_upload . '/users/' . $username_alias . '/' . date('Y_m/d');
    $array_structure_user['username_Y_m_d'] = $module_upload . '/users/' . $username_alias . '/' . date('Y/m/d');
    $structure_user_upload = isset($array_config['structure_upload_user']) ? $array_config['structure_upload_user'] : "username_Y";
    $array['currentpath'] = isset($array_structure_user[$structure_user_upload]) ? $array_structure_user[$structure_user_upload] : '';
    
    if (file_exists(NV_UPLOADS_REAL_DIR . '/' . $array['currentpath'])) {
        $array['uploadrealdir'] = NV_UPLOADS_REAL_DIR . '/' . $array['currentpath'];
    } else {
        $array['uploadrealdir'] = NV_UPLOADS_REAL_DIR . '/' . $module_upload;
        $e = explode('/', $array['currentpath']);
        if (! empty($e)) {
            $cp = '';
            foreach ($e as $p) {//print_r($e);die;
                if (! empty($p) and ! is_dir(NV_UPLOADS_REAL_DIR . '/' . $cp . $p)) {
                    $mk = nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $cp, $p);
                    if ($mk[0] > 0) {
                        $array['uploadrealdir'] = $mk[2];
                        $db->query("INSERT INTO " . NV_UPLOAD_GLOBALTABLE . "_dir (dirname, time) VALUES ('" . NV_UPLOADS_DIR . "/" . $cp . $p . "', 0)");
                    }
                } elseif (! empty($p)) {
                    $array['uploadrealdir'] = NV_UPLOADS_REAL_DIR . '/' . $cp . $p;
                }
                $cp .= $p . '/';
            }
        }
        $array['uploadrealdir'] = str_replace('\\', '/', $array['uploadrealdir']);
    }
  
    return $array;
}

function nv_user_del_items($id)
{
    global $db, $module_data, $module_name, $user_info;
    
    $userid = ! empty($user_info) ? $user_info['userid'] : 0;
    $homeimgfile = $db->query('SELECT homeimgfile FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id = ' . $id . ' AND admin_id=' . $userid)->fetchColumn();
    
    if (nv_del_items($id, $homeimgfile)) {
        die('OK');
    }
    die('NO');
}

function nv_delete_saved($id)
{
    global $db, $module_data, $user_info;
    
    $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_saved WHERE itemid=' . $id . ' AND userid=' . $user_info['userid']);
}

function nv_data_show($item)
{
    global $db, $module_name, $module_info, $array_way, $array_groups, $global_config, $array_cat, $module_data, $lang_global, $array_pricetype;
    
    $location = new Location();
    
    $item['imghome'] = nv_bookhouse_get_image($item['homeimgfile'], $item['homeimgthumb'], $module_name, $module_info['template']);
    $item['link'] = $array_cat[$item['catid']]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
    $item['addtime'] = nv_date('d/m/Y', $item['addtime']);
  
    $item['way'] = ! empty($item['way_id']) ? $array_way[$item['way_id']]['title'] : '';
    
    if ($item['showprice']) {
       // $item['price'] = nv_price_format($item['price']);
    }
    
    $module_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
    $item['location'] = $location->locationString($item['provinceid'], $item['districtid'], $item['wardid'], ' » ', $module_url);
    
    if (! empty($item['groupid'])) {
        $item['groupid'] = explode(',', $item['groupid'])[0];
        $item['color'] = $array_groups[$item['groupid']]['color'];
    }
    
    $item['rooms'] = array();
    $sql = $db->query('SELECT iid, rid, num FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rooms_detail WHERE iid = ' . $item['id']);
    while ($row = $sql->fetch()) {
        $item['rooms'][$row['rid']] = $row;
    }
    
    $item['poster'] = $lang_global['guests'];
    if ($item['admin_id'] > 0) {
        $_result = $db->query('SELECT username, first_name, last_name FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $item['admin_id']);
        if ($_result->rowCount()) {
            list ($username, $first_name, $last_name) = $_result->fetch(3);
            $item['poster'] = nv_show_name_user($first_name, $last_name, $username);
        }
    }
    
	if($item['price_time'])
	{
	$item['price_time'] = $array_pricetype[$item['price_time']]['title'];
	}
	else 
	{
		$item['price_time'] = 'Thỏa thuận';
		$item['price'] = '';
	}

    return $item;
}


function nv_image_logo($fileupload)
{
    global $global_config, $module_upload;
    
    if (empty($fileupload) or ! file_exists($fileupload)) {
        return;
    }
    
    $autologomod = explode(',', $global_config['autologomod']);
    
    if ($global_config['autologomod'] == 'all' or in_array($module_upload, $autologomod)) {
        if (! empty($global_config['upload_logo']) and file_exists(NV_ROOTDIR . '/' . $global_config['upload_logo'])) {
            
            $logo_size = getimagesize(NV_ROOTDIR . '/' . $global_config['upload_logo']);
            $file_size = getimagesize($fileupload);
            
            if ($file_size[0] <= 150) {
                $w = ceil($logo_size[0] * $global_config['autologosize1'] / 100);
            } elseif ($file_size[0] < 350) {
                $w = ceil($logo_size[0] * $global_config['autologosize2'] / 100);
            } else {
                if (ceil($file_size[0] * $global_config['autologosize3'] / 100) > $logo_size[0]) {
                    $w = $logo_size[0];
                } else {
                    $w = ceil($file_size[0] * $global_config['autologosize3'] / 100);
                }
            }
            
            $h = ceil($w * $logo_size[1] / $logo_size[0]);
            $x = $file_size[0] - $w - 5;
            $y = $file_size[1] - $h - 5;
            
            $config_logo = array();
            $config_logo['w'] = $w;
            $config_logo['h'] = $h;
            
            $config_logo['x'] = $file_size[0] - $w - 5; // Horizontal: Right
            $config_logo['y'] = $file_size[1] - $h - 5; // Vertical: Bottom
                                                        
            // Logo vertical
            if (preg_match("/^top/", $global_config['upload_logo_pos'])) {
                $config_logo['y'] = 5;
            } elseif (preg_match("/^center/", $global_config['upload_logo_pos'])) {
                $config_logo['y'] = round(($file_size[1] / 2) - ($h / 2));
            }
            
            // Logo horizontal
            if (preg_match("/Left$/", $global_config['upload_logo_pos'])) {
                $config_logo['x'] = 5;
            } elseif (preg_match("/Center$/", $global_config['upload_logo_pos'])) {
                $config_logo['x'] = round(($file_size[0] / 2) - ($w / 2));
            }
            
            $createImage = new NukeViet\Files\Image($fileupload, NV_MAX_WIDTH, NV_MAX_HEIGHT);
            $createImage->addlogo(NV_ROOTDIR . '/' . $global_config['upload_logo'], '', '', $config_logo);
            $createImage->save(dirname($fileupload), basename($fileupload), 90);
        }
    }
}


/**
 * nv_groups_list()
 *
 * @return
 *
 */
function nv_groups_list($mod_data = 'users')
{
    global $nv_Cache, $module_name;
    
    $cache_file = NV_LANG_DATA . '_' . $module_name . '_groups_list_' . NV_CACHE_PREFIX . '.cache';
    if (($cache = $nv_Cache->getItem($mod_data, $cache_file)) != false) {
        return unserialize($cache);
    } else {
        global $db, $db_config, $global_config, $lang_global;
        
        $groups = array();
        $_mod_table = ($mod_data == 'users') ? NV_USERS_GLOBALTABLE : $db_config['prefix'] . '_' . $mod_data;
        $result = $db->query('SELECT group_id, title, idsite, content FROM ' . $_mod_table . '_groups WHERE (idsite = ' . $global_config['idsite'] . ' OR (idsite =0 AND siteus = 1)) ORDER BY idsite, weight');
        while ($row = $result->fetch()) {
            if ($row['group_id'] < 9) {
                $row['title'] = $lang_global['level' . $row['group_id']];
            }
            $groups[$row['group_id']] = array(
                'title' => ($global_config['idsite'] > 0 and empty($row['idsite'])) ? '<strong>' . $row['title'] . '</strong>' : $row['title'],
                'description' => $row['content']
            );
        }
        $nv_Cache->setItem($mod_data, $cache_file, serialize($groups));
        
        return $groups;
    }
}

function nv_caculate_bootstrap_grid($col, $maxcol = 24)
{
    if ($col == 1) {
        return 'col-xs-24 col-sm-24 col-md-24';
    } elseif ($col == 2) {
        return 'col-xs-24 col-sm-12 col-md-12';
    } elseif ($col == 3) {
        return 'col-xs-24 col-sm-8 col-md-8';
    } elseif ($col == 3) {
        return 'col-xs-24 col-sm-6 col-md-6';
    }
}


