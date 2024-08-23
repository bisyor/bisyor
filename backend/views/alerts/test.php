<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mpic($matches)
{
    $cfg = array(
        'max_width' => 620,    //максимальная ширина минипостера
        'max_height' => 800,  //максимальная высота минипостера
        'quality' => 85,    //качество по умолчанию
        'default' => '/uploads/laylo.jpg',  //картинка по умолчанию
        'allow_remote' => 1,  //разрешить обработку изображений со сторонних серверов
        'zoom' => 0,  //1 - увеличивать маленькие изображения до заданных размеров. 0 - просто обрезать большую сторону при необходимости
        'force_jpg' => 1,  //1 - по умолчанию сохранять только в jpg. 0 - сохранять в исходном типе
    );

    $param_str = trim($matches[1]);
    if (preg_match("#src=['\"]([^'\"]+)['\"]#i", $param_str, $match)) $src = $match[1];
    elseif (preg_match("#default=['\"]([^'\"]+)['\"]#i", $param_str, $match)) return $match[1];
    else return $cfg['default'];

    if (preg_match("#width=['\"](\d+?)['\"]#i", $param_str, $match)) {
        $w = $match[1];
        if ($w > $cfg['max_width']) $w = $cfg['max_width'];
    } else $w = 0;

    if (preg_match("#height=['\"](\d+?)['\"]#i", $param_str, $match)) {
        $h = $match[1];
        if ($h > $cfg['max_height']) $h = $cfg['max_height'];
    } else $h = 0;

    if (preg_match("#q=['\"](\d+?)['\"]#i", $param_str, $match)) {
        $q = $match[1];
        if ($q > 100) $q = 100;
        elseif ($q < 1) $q = 1;
    } else $q = $cfg['quality'];

    if (preg_match("#zoom=['\"]([^'\"]+?)['\"]#i", $param_str, $match)) $z = strtolower($match[1]) == 'yes' ? 1 : 0;
    else $z = $cfg['zoom'];

    if (preg_match("#jpg=['\"]([^'\"]+?)['\"]#i", $param_str, $match)) $jpg = strtolower($match[1]) == 'yes' ? 1 : 0;
    else $jpg = $cfg['force_jpg'];

    $type = explode(".", $src);
    $type = strtolower(end($type));
    if (($type != 'png' and $type != 'gif') or $jpg) $type = 'jpg';

    $image_name = md5($src . $z . $q) . "." . $type;
    $path = "/uploads/posts/{$w}x{$h}/";
    $path2 = $path . substr($image_name, 0, 2) . "/";
    $image_name = substr($image_name, 2, 50);

    if (file_exists(ROOT_DIR . $path2 . $image_name)) {
        @touch(ROOT_DIR . $path2 . $image_name);
        return $path2 . $image_name;
    }
    $f = (substr($src, 0, 1) == "/") ? ROOT_DIR . $src : $src;
    $rm = parse_url($f);
    if ($rm['host'] and clean_url($rm['host']) != clean_url($_SERVER['HTTP_HOST'])) $is_remote = 1;
    else $is_remote = 0;
    if (!$cfg['allow_remote'] and $is_remote) return $cfg['default'];

    if ($is_remote) {
        $cl = curl_init();
        curl_setopt($cl, CURLOPT_URL, $f);
        curl_setopt($cl, CURLOPT_HEADER, 0);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($cl, CURLOPT_TIMEOUT, 3);
        $str = curl_exec($cl);
        curl_close($cl);
    } else $str = @file_get_contents($f);
    if (!$str) return $cfg['default'];

    $image = imagecreatefromstring($str);
    $iw = @imagesx($image);
    $ih = @imagesy($image);
    if ($iw < 1 or $ih < 1) return $cfg['default'];

    if (!$z) {
        if ($iw < $w) $w = $iw;
        if ($ih < $h) $h = $ih;
    }
    if (!$w and !$h) {
        $w = min($iw, $cfg['max_width']);
        $h = min($ih, $cfg['max_height']);
    } elseif ($w and !$h) {
        $h = floor($w / $iw * $ih);
        if ($h > $cfg['max_height']) {
            $h = $cfg['max_height'];
            $w = floor($h / $ih * $iw);
        }
    } elseif ($h and !$w) {
        $w = floor($h / $ih * $iw);
        if ($w > $cfg['max_width']) {
            $w = $cfg['max_width'];
            $h = floor($w / $iw * $ih);
        }
    }

    $poster = imagecreatetruecolor($w, $h);
    if ($type == 'png') {
        imagealphablending($poster, false);
        imagesavealpha($poster, true);
    }

    $size_ratio = max($w / $iw, $h / $ih);
    $nw = ceil($iw * $size_ratio);
    $nh = ceil($ih * $size_ratio);
    $sx = -floor(($nw - $w) / 2);
    $sy = -floor(($nh - $h) / 2);
    imagecopyresampled($poster, $image, $sx, $sy, 0, 0, $nw, $nh, $iw, $ih);
    imagedestroy($image);

    if (!is_dir(ROOT_DIR . $path)) {
        @mkdir(ROOT_DIR . $path, 0777);
        @chmod(ROOT_DIR . $path, 0777);
    }
    if (!is_dir(ROOT_DIR . $path2)) {
        @mkdir(ROOT_DIR . $path2, 0777);
        @chmod(ROOT_DIR . $path2, 0777);
    }


    if ($type == 'gif') imagegif($poster, ROOT_DIR . $path2 . $image_name);
    elseif ($type == 'png') imagepng($poster, ROOT_DIR . $path2 . $image_name, 8);
    else imagejpeg($poster, ROOT_DIR . $path2 . $image_name, $q);

    imagedestroy($poster);
    return $path2 . $image_name;
}

$tpl->result['main'] = preg_replace_callback("#\\{poster(.+?)\\}#i", "mpic", $tpl->result['main']);

?>