<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 2:29
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');

$allow_upload_dir = array(
    NV_UPLOADS_DIR
);

/**
 * nv_check_path_upload()
 *
 * @param mixed $path            
 * @return
 *
 */
function nv_check_path_upload($path)
{
    global $allow_upload_dir, $global_config;
    
    $path = htmlspecialchars(trim($path), ENT_QUOTES);
    $path = rtrim($path, '/');
    if (empty($path))
        return '';
    
    $path = NV_ROOTDIR . '/' . $path;
    if (($path = realpath($path)) === false)
        return '';
    
    $path = str_replace("\\", '/', $path);
    $path = str_replace(NV_ROOTDIR . '/', '', $path);
    if (preg_match('/^' . nv_preg_quote(NV_UPLOADS_DIR) . '/', $path) or $path = NV_UPLOADS_DIR) {
        return $path;
    }
    return '';
}

/**
 * nv_get_viewImage()
 *
 * @param mixed $fileName            
 * @return
 *
 */
function nv_get_viewImage($fileName)
{
    global $db;
    
    $array_thumb_config = array();
    
    $sql = 'SELECT * FROM ' . NV_UPLOAD_GLOBALTABLE . '_dir ORDER BY dirname ASC';
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        if ($row['thumb_type']) {
            $array_thumb_config[$row['dirname']] = $row;
        }
    }
    
    if (preg_match('/^' . nv_preg_quote(NV_UPLOADS_DIR) . '\/(([a-z0-9\-\_\/]+\/)*([a-z0-9\-\_\.]+)(\.(gif|jpg|jpeg|png|bmp|ico)))$/i', $fileName, $m)) {
        $viewFile = NV_FILES_DIR . '/' . $m[1];
        
        if (file_exists(NV_ROOTDIR . '/' . $viewFile)) {
            $size = @getimagesize(NV_ROOTDIR . '/' . $viewFile);
            return array(
                $viewFile,
                $size[0],
                $size[1]
            );
        } else {
            $m[2] = rtrim($m[2], '/');
            
            if (isset($array_thumb_config[NV_UPLOADS_DIR . '/' . $m[2]])) {
                $thumb_config = $array_thumb_config[NV_UPLOADS_DIR . '/' . $m[2]];
            } else {
                $thumb_config = $array_thumb_config[''];
                $_arr_path = explode('/', NV_UPLOADS_DIR . '/' . $m[2]);
                while (sizeof($_arr_path) > 1) {
                    array_pop($_arr_path);
                    $_path = implode('/', $_arr_path);
                    if (isset($array_thumb_config[$_path])) {
                        $thumb_config = $array_thumb_config[$_path];
                        break;
                    }
                }
            }
            
            $viewDir = NV_FILES_DIR;
            if (! empty($m[2])) {
                if (! is_dir(NV_ROOTDIR . '/' . $m[2])) {
                    $e = explode('/', $m[2]);
                    $cp = NV_FILES_DIR;
                    foreach ($e as $p) {
                        if (is_dir(NV_ROOTDIR . '/' . $cp . '/' . $p)) {
                            $viewDir .= '/' . $p;
                        } else {
                            $mk = nv_mkdir(NV_ROOTDIR . '/' . $cp, $p);
                            if ($mk[0] > 0) {
                                $viewDir .= '/' . $p;
                            }
                        }
                        $cp .= '/' . $p;
                    }
                }
            }
            $image = new NukeViet\Files\Image(NV_ROOTDIR . '/' . $fileName, NV_MAX_WIDTH, NV_MAX_HEIGHT);
            if ($thumb_config['thumb_type'] == 4) {
                $thumb_width = $thumb_config['thumb_width'];
                $thumb_height = $thumb_config['thumb_height'];
                $maxwh = max($thumb_width, $thumb_height);
                if ($image->fileinfo['width'] > $image->fileinfo['height']) {
                    $thumb_config['thumb_width'] = 0;
                    $thumb_config['thumb_height'] = $maxwh;
                } else {
                    $thumb_config['thumb_width'] = $maxwh;
                    $thumb_config['thumb_height'] = 0;
                }
            }
            if ($image->fileinfo['width'] > $thumb_config['thumb_width'] or $image->fileinfo['height'] > $thumb_config['thumb_height']) {
                $image->resizeXY($thumb_config['thumb_width'], $thumb_config['thumb_height']);
                if ($thumb_config['thumb_type'] == 4) {
                    $image->cropFromCenter($thumb_width, $thumb_height);
                }
                $image->save(NV_ROOTDIR . '/' . $viewDir, $m[3] . $m[4], $thumb_config['thumb_quality']);
                $create_Image_info = $image->create_Image_info;
                $error = $image->error;
                $image->close();
                if (empty($error)) {
                    return array(
                        $viewDir . '/' . basename($create_Image_info['src']),
                        $create_Image_info['width'],
                        $create_Image_info['height']
                    );
                }
            } elseif (copy(NV_ROOTDIR . '/' . $fileName, NV_ROOTDIR . '/' . $viewDir . '/' . $m[3] . $m[4])) {
                $return = array(
                    $viewDir . '/' . $m[3] . $m[4],
                    $image->fileinfo['width'],
                    $image->fileinfo['height']
                );
                $image->close();
                return $return;
            } else {
                return false;
            }
        }
    } else {
        $size = @getimagesize(NV_ROOTDIR . '/' . $fileName);
        return array(
            $fileName,
            $size[0],
            $size[1]
        );
    }
    return false;
}

/**
 * nv_getFileInfo()
 *
 * @param mixed $pathimg            
 * @param mixed $file            
 * @return
 *
 */
function nv_getFileInfo($pathimg, $file)
{
    global $array_images, $array_flash, $array_archives, $array_documents;
    
    clearstatcache();
    
    $array_images = array(
        'gif',
        'jpg',
        'jpeg',
        'pjpeg',
        'png',
        'bmp',
        'ico'
    );
    $array_flash = array(
        'swf',
        'swc',
        'flv'
    );
    $array_archives = array(
        'rar',
        'zip',
        'tar'
    );
    $array_documents = array(
        'doc',
        'xls',
        'chm',
        'pdf',
        'docx',
        'xlsx'
    );
    
    unset($matches);
    preg_match("/([a-zA-Z0-9\.\-\_\\s\(\)]+)\.([a-zA-Z0-9]+)$/", $file, $matches);
    
    $info = array();
    $info['name'] = $file;
    if (isset($file{17})) {
        $info['name'] = substr($matches[1], 0, (13 - strlen($matches[2]))) . '...' . $matches[2];
    }
    
    $info['ext'] = $matches[2];
    $info['type'] = 'file';
    
    $stat = @stat(NV_ROOTDIR . '/' . $pathimg . '/' . $file);
    $info['filesize'] = $stat['size'];
    
    $info['src'] = NV_ASSETS_DIR . '/images/file.gif';
    $info['srcwidth'] = 32;
    $info['srcheight'] = 32;
    $info['size'] = '|';
    $ext = strtolower($matches[2]);
    
    if (in_array($ext, $array_images)) {
        $size = @getimagesize(NV_ROOTDIR . '/' . $pathimg . '/' . $file);
        $info['type'] = 'image';
        $info['src'] = $pathimg . '/' . $file;
        $info['srcwidth'] = intval($size[0]);
        $info['srcheight'] = intval($size[1]);
        $info['size'] = intval($size[0]) . '|' . intval($size[1]);
        
        if (preg_match('/^' . nv_preg_quote(NV_UPLOADS_DIR) . '\/([a-z0-9\-\_\.\/]+)$/i', $pathimg . '/' . $file, $m)) {
            if (($thub_src = nv_get_viewImage($pathimg . '/' . $file)) !== false) {
                $info['src'] = $thub_src[0];
                $info['srcwidth'] = $thub_src[1];
                $info['srcheight'] = $thub_src[2];
            }
        }
        
        if ($info['srcwidth'] > 80) {
            $info['srcheight'] = round(80 / $info['srcwidth'] * $info['srcheight']);
            $info['srcwidth'] = 80;
        }
        
        if ($info['srcheight'] > 80) {
            $info['srcwidth'] = round(80 / $info['srcheight'] * $info['srcwidth']);
            $info['srcheight'] = 80;
        }
    } elseif (in_array($ext, $array_flash)) {
        $info['type'] = 'flash';
        $info['src'] = NV_ASSETS_DIR . '/images/flash.gif';
        
        if ($matches[2] == 'swf') {
            $size = @getimagesize(NV_ROOTDIR . '/' . $pathimg . '/' . $file);
            if (isset($size, $size[0], $size[1])) {
                $info['size'] = $size[0] . '|' . $size[1];
            }
        }
    } elseif (in_array($ext, $array_archives)) {
        $info['src'] = NV_ASSETS_DIR . '/images/zip.gif';
    } elseif (in_array($ext, $array_documents)) {
        if ($ext == 'doc' or $ext == 'docx') {
            $info['src'] = NV_ASSETS_DIR . '/images/msword.png';
        } elseif ($ext == 'xls' or $ext == 'xlsx') {
            $info['src'] = NV_ASSETS_DIR . '/images/excel.png';
        } elseif ($ext == 'pdf') {
            $info['src'] = NV_ASSETS_DIR . '/images/pdf.png';
        } else {
            $info['src'] = NV_ASSETS_DIR . '/images/doc.gif';
        }
    }
    
    $info['userid'] = 0;
    $info['mtime'] = $stat['mtime'];
    
    return $info;
}

/**
 * nv_filesListRefresh()
 *
 * @param mixed $pathimg            
 * @return
 *
 */
function nv_filesListRefresh($pathimg)
{
    global $array_hidefolders, $admin_info, $db_config, $db, $module_upload;
    
    $array_hidefolders = array(
        '.',
        '..',
        'index.html',
        '.htaccess',
        '.tmp'
    );
    
    // Xoa anh thumb cu
    nv_deletefile(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $module_upload, true);
    
    $sql = 'SELECT * FROM ' . NV_UPLOAD_GLOBALTABLE . '_dir ORDER BY dirname ASC';
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        $array_dirname[$row['dirname']] = $row['did'];
    }
    unset($array_dirname['']);
    
    $results = array();
    $did = $array_dirname[$pathimg];
    if (is_dir(NV_ROOTDIR . '/' . $pathimg)) {
        $result = $db->query('SELECT * FROM ' . NV_UPLOAD_GLOBALTABLE . '_file WHERE did = ' . $did);
        while ($row = $result->fetch()) {
            $results[$row['title']] = $row;
        }
        
        if ($dh = opendir(NV_ROOTDIR . '/' . $pathimg)) {
            while (($title = readdir($dh)) !== false) {
                if (in_array($title, $array_hidefolders))
                    continue;
                
                if (preg_match('/([a-zA-Z0-9\.\-\_\\s\(\)]+)\.([a-zA-Z0-9]+)$/', $title, $m)) {
                    $info = nv_getFileInfo($pathimg, $title);
                    $info['did'] = $did;
                    $info['title'] = $title;
                    $newalt = preg_replace('/(.*)(\.[a-zA-Z0-9]+)$/', '\1', $title);
                    $newalt = str_replace('-', ' ', change_alias($newalt));
                    if (isset($results[$title])) {
                        $info['userid'] = $results[$title]['userid'];
                        $dif = array_diff_assoc($info, $results[$title]);
                        if (! empty($dif)) {
                            // Cập nhật CSDL file thay đổi
                            $sth = $db->prepare("REPLACE INTO " . NV_UPLOAD_GLOBALTABLE . "_file
								(name, ext, type, filesize, src, srcwidth, srcheight, sizes, userid, mtime, did, title, alt)
								VALUES ('" . $info['name'] . "', '" . $info['ext'] . "', '" . $info['type'] . "', " . $info['filesize'] . ", '" . $info['src'] . "', " . $info['srcwidth'] . ", " . $info['srcheight'] . ", '" . $info['size'] . "', " . $info['userid'] . ", " . $info['mtime'] . ", " . $did . ", '" . $title . "', :newalt)");
                            $sth->bindParam(':newalt', $newalt, PDO::PARAM_STR);
                            $sth->execute();
                        }
                        unset($results[$title]);
                    } else {
                        $info['userid'] = $admin_info['userid'];
                        // Thêm file mới
                        $sth = $db->prepare("INSERT INTO " . NV_UPLOAD_GLOBALTABLE . "_file
							(name, ext, type, filesize, src, srcwidth, srcheight, sizes, userid, mtime, did, title, alt)
							VALUES ('" . $info['name'] . "', '" . $info['ext'] . "', '" . $info['type'] . "', " . $info['filesize'] . ", '" . $info['src'] . "', " . $info['srcwidth'] . ", " . $info['srcheight'] . ", '" . $info['size'] . "', " . $info['userid'] . ", " . $info['mtime'] . ", " . $did . ", '" . $title . "', :newalt)");
                        $sth->bindParam(':newalt', $newalt, PDO::PARAM_STR);
                        $sth->execute();
                    }
                }
            }
            closedir($dh);
            
            if (! empty($results)) {
                // Xóa CSDL file không còn tồn tại
                foreach ($results as $title => $value) {
                    $db->query("DELETE FROM " . NV_UPLOAD_GLOBALTABLE . "_file WHERE did = " . $did . " AND title='" . $title . "'");
                }
            }
            $db->query('UPDATE ' . NV_UPLOAD_GLOBALTABLE . '_dir SET time = ' . NV_CURRENTTIME . ' WHERE did = ' . $did);
        }
    } else {
        // Xóa CSDL thư mục không còn tồn tại
        $db->query('DELETE FROM ' . NV_UPLOAD_GLOBALTABLE . '_file WHERE did = ' . $did);
        $db->query('DELETE FROM ' . NV_UPLOAD_GLOBALTABLE . '_dir WHERE did = ' . $did);
    }
}