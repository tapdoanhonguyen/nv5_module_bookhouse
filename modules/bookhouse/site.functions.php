<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');
	
function nv_bookhouse_get_image($image, $imagethumb, $module, $template)
{
    global $module_info, $site_mods, $global_config;

    $img_path = '';
	$logo = preg_replace('/\.[a-z]+$/i', '.svg', $global_config['site_logo']);
    if (! file_exists(NV_ROOTDIR . '/' . $logo)) {
        $logo = $global_config['site_logo'];
    }
	
    if (! empty($image)) {
        if ($imagethumb == 1) // image thumb
        {
            $img_path = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $image;
        } elseif ($imagethumb == 2) // image file
        {
            $img_path = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $image;
        } elseif ($imagethumb == 3) // image url
        {
            $img_path = $image;
        } else {
            $img_path = NV_BASE_SITEURL . 'themes/' . $template . '/images/' . $site_mods[$module]['module_file'] . '/no-image.jpg';
        }
    } else {
        $img_path = NV_BASE_SITEURL . 'themes/' . $template . '/images/' . $site_mods[$module]['module_file'] . '/no-image.jpg';
        //$img_path = NV_BASE_SITEURL . $logo;
    }

    return $img_path;
}

/**
 * nv_price_format()
 *
 * @param mixed $price
 * @param mixed $money_unit
 * @return
 *
 */
function nv_price_format($price, $pricetime = 0, $money_unit = 'vnd')
{
    global $array_config, $array_money_unit, $array_price_time, $array_pricetype, $site_mods;
    
    if(in_array($array_config['priceformat'], array(0,1)) and $money_unit == 'vnd'){
        $price = nv_price_number_tostring($price, $pricetime);
    }else{
        $price = nv_number_format($price) . ' ' . $array_money_unit[$money_unit];
    }

    return $price;
}

/**
 * nv_price_number_tostring()
 *
 * @param mixed $num
 * @return
 *
 */
function nv_price_number_tostring($num = false, $pricetime = 0)
{
    global $lang_module, $array_config, $array_price_time;

    $str = '';
    $num = trim($num);

    $arr = str_split($num);
    $count = count($arr);

    $f = number_format($num);
    if ($count < 4) {
        $str = $num;
    } else {
        $r = explode(',', $f);
        switch (count($r)) {
            case 4:
                $str = $r[0] . ' ' . $lang_module['billion'];
                if ((int) $r[1]) {
                    $str .= ' ' . $r[1] . ' ' . $lang_module['million'];
                }else{
                    $str = $r[0];
                    if($array_config['priceformat'] == 1 and $pricetime > 0){
                        $str .= ' (' . $lang_module['billion'] . $array_price_time[$pricetime] . ')';
                    }else{
                        $str .= ' ' . $lang_module['billion'];
                    }
                }
                break;
            case 3:
                $str = $r[0] . ' ' . $lang_module['million'];
                if ((int) $r[1]) {
                    $str .= ' ' . $r[1] . ' ' . $lang_module['thousand'];
                }else{
                    $str = $r[0];
                    if($array_config['priceformat'] == 1 and $pricetime > 0){
                        $str .= ' (' . $lang_module['million'] . $array_price_time[$pricetime] . ')';
                    }else{
                        $str .= ' ' . $lang_module['million'];
                    }
                }
                break;
            case 2:
                $str = $r[0] . ' ' . $lang_module['thousand'];
                if ((int) $r[1]) {
                    $str .= ' ' . $r[1] . ' ' . $lang_module['dong'];
                }else{
                    $str = $r[0];
                    if($array_config['priceformat'] == 1 and $pricetime > 0){
                        $str .= ' (' . $lang_module['thousand'] . $array_price_time[$pricetime] . ')';
                    }else{
                        $str .= ' ' . $lang_module['thousand'];
                    }
                }
                break;
        }
    }
    return ($str);
}


function nv_count_refresh($module)
{
    global $db, $user_info, $site_mods, $array_config;
    
    $count_refresh = $db->query('SELECT count FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_refresh WHERE userid=' . $user_info['userid'])->fetchColumn();
    if ($count_refresh === false) {
        $count_refresh = $array_config['refresh_default'];
    }
    
    return $count_refresh;
}

function nv_count_refresh_free($module)
{
    global $db, $user_info, $site_mods, $array_config;
    
    if (empty($array_config['refresh_free'])) {
        return 0;
    }
    
    $currentdate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
    $count_refresh = $db->query('SELECT free FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_refresh WHERE userid=' . $user_info['userid'] . ' AND free_time > 0 AND free_time=' . $currentdate)->fetchColumn();
    
    if ($count_refresh === false) {
        $count_refresh = $array_config['refresh_free'];
    }
    
    return $count_refresh;
}

