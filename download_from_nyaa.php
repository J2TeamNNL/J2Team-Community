<?php
set_time_limit(0);
$links = "https://nyaa.si/?f=0&c=1_0&q=";
$page  = 0;
while (true) {
    $curls = curl_init();
    curl_setopt_array($curls, array(
        CURLOPT_URL => $links,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));
    $reply = curl_exec($curls);
    curl_close($curls);
    preg_match_all('/\w*\.torrent/', $reply, $matches);
    foreach ($matches as $array) {
        foreach ($array as $each) {
            $fp = fopen ("download/$each" , 'w+');
            $links = "https://nyaa.si/download/$each";
            $curls = curl_init();
            curl_setopt_array($curls, array(
                CURLOPT_URL => $links,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_FILE => $fp
            ));
            curl_exec($curls);
            curl_close($curls);
        }
    }
    if(curl_error($curls)){
        break;
    }
    else{
        $links = "https://nyaa.si/?f=0&c=1_0&q=&p=$page";
        $page++;
    }
}
