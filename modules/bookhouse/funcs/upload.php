<?php

/**
 * @Project PHOTOS 4.x
 * @Author KENNY NGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2015 tradacongnghe.com. All rights reserved
 * @Based on NukeViet CMS
 * @License GNU/GPL version 2 or any later version
 * @Createdate  Fri, 18 Sep 2015 11:52:59 GMT
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');
    
    // Khong cho phep cache
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Cross domain
// header("Access-Control-Allow-Origin: *");

// Kiem tra phien lam viec
$token = $nv_Request->get_title('token', 'get', '');
if ($token != md5($nv_Request->session_id . $global_config['sitekey'])) {
    gltJsonResponse(array(
        'code' => 200,
        'message' => $lang_module['uploadErrorSess']
    ));
}

// Tang thoi luong phien lam viec
if ($sys_info['allowed_set_time_limit']) {
    set_time_limit(5 * 3600);
}

// Get request value
$fileName = $nv_Request->get_title('name', 'post', '');
$fileExt = nv_getextension($fileName);
$fileName = change_alias(substr($fileName, 0, - (strlen($fileExt) + 1))) . '.' . $fileExt;

$chunk = $nv_Request->get_int('chunk', 'post', 0);
$chunks = $nv_Request->get_int('chunks', 'post', 0);

$fileupload = '';
if (isset($_FILES['file']) and is_uploaded_file($_FILES['file']['tmp_name'])) {
    if (defined('NV_IS_MODADMIN')) {
        $maxfilesize = min($global_config['nv_max_size'], nv_converttoBytes(ini_get('upload_max_filesize')), nv_converttoBytes(ini_get('post_max_size')));
        $width = NV_MAX_WIDTH;
        $height = NV_MAX_HEIGHT;
    } else {
        $maxfilesize = $array_config['maxfilesize'];
list ($width, $height) = explode('x', $array_config['image_upload_size']);
    }
    $file_allowed_ext = $global_config['file_allowed_ext'];
    $upload = new NukeViet\Files\Upload($file_allowed_ext, $global_config['forbid_extensions'], $global_config['forbid_mimes'], $maxfilesize, $width, $height);
    $upload_info = $upload->save_file($_FILES['file'], NV_ROOTDIR . '/' . NV_TEMP_DIR, false, $array_config['auto_resize']);
    @unlink($_FILES['file']['tmp_name']);
    if (empty($upload_info['error'])) {

        // auto_resize
        if ($array_config['auto_resize'] and ($upload_info['img_info'][0] > $width or $upload_info['img_info'][0] > $height)) {
            $createImage = new NukeViet\Files\Image(NV_ROOTDIR . '/' . NV_TEMP_DIR. '/' . $upload_info['basename'], $upload_info['img_info'][0], $upload_info['img_info'][1]);
            $createImage->resizeXY($width, $height);
            $createImage->save(NV_ROOTDIR . '/' . NV_TEMP_DIR, $upload_info['basename'], 90);
            $createImage->close();
            $info = $createImage->create_Image_info;
            $upload_info['img_info'][0] = $info['width'];
            $upload_info['img_info'][1] = $info['height'];
        }

        mt_srand((double) microtime() * 1000000);
        $maxran = 1000000;
        $random_num = mt_rand(0, $maxran);
        $random_num = md5($random_num);
        $nv_pathinfo_filename = nv_pathinfo_filename($upload_info['name']);
        $new_name = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $nv_pathinfo_filename . '.' . $random_num . '.' . $upload_info['ext'];
        $rename = nv_renamefile($upload_info['name'], $new_name);
        if ($rename[0] == 1) {
            $fileupload = $new_name;
        } else {
            $fileupload = $upload_info['name'];
        }
        $uploadfilename = str_replace(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/', '', $fileupload);
        @chmod($fileupload, 0644);
        
        // Đóng dấu logo
        nv_image_logo($fileupload);
    } else {
        gltJsonResponse(array(
            'code' => 200,
            'message' => $upload_info['error']
        ));
    }
    unset($upload, $upload_info);
}

$thumb = nv_resize_crop_images($fileupload, 150, 100, $module_name);
$image_url = str_replace(NV_ROOTDIR, '', $fileupload);

$token_image = md5($global_config['sitekey'] . session_id() . $image_url);
$token_thumb = md5($global_config['sitekey'] . session_id() . $thumb);
$token = md5($global_config['sitekey'] . session_id());
gltJsonResponse(array(), array(
    'row_id' => 0,
    'token' => $token,
    'token_image' => $token_image,
    'token_thumb' => $token_thumb,
    'basename' => $fileName,
    'homeimgfile' => $uploadfilename,
    'image_url' => $image_url,
    'thumb' => $thumb,
    'ext' => $fileExt
));
