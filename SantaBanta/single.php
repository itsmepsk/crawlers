<?php
include('/simple_html_dom.php');
$url = "http://www.santabanta.com/wallpapers/{celebrity name as on SantaBanta}/?page=";
//e.g. "http://www.santabanta.com/wallpapers/paget-brewster/?page=";
$domain = "http://www.santabanta.com";
do {
    $html = @file_get_html($url);
}
while ($html == FALSE);
//echo $html;
$celeb = "Paget Brewster";
$name = $celeb;
$dir = "D:/Wallpapers/Actress/Hollywood/";
$dir.= $celeb;
$dir.= "/";
$celeb = strtolower($celeb);
$celeb = explode(" ", $celeb);

/*
 * Priority
 * ->Full 5 1920x1080
 * ->Full 6 1920x1200
 * ->Full 3 1280x800
 * ->Full 1 1024x768
 * ->Full 2 1280x1024
 * ->Full   800x600
 */
$mdir = explode($dir, "/");
if(!file_exists($dir)) {
    mkdir($dir,0777,true);
}
$max = 1;
foreach($html->find('div[class="paging-div-new"]') as $page) {
    $num = $page->find('a');
    $max = 1;
    foreach($num as $pin) {
        $pg = $pin->innertext;
        //echo $pg."<br>";
        if(is_numeric($pg) && $pg > $max) {
            $max = $pg;
        }
    }
}
//$max = ($max==0)?1:$max;
$counter = 01;
$t = $url;
for($i=1;$i<=$max;$i++) {
    $url = $t;
    $url.=$i;
    $ln = strlen($url)+25;
    for($j=0;$j<$ln;$j++) {
        printf("#");
    }
    printf("\n");
    //printf("####################################################################################################\n");
    printf("# Extracting from page %s #\n",$url);
    //printf("####################################################################################################\n");
    for($j=0;$j<$ln;$j++) {
        printf("#");
    }
    printf("\n");
    do {
        $html = @file_get_html($url);
    }
    while ($html == FALSE);
    foreach($html->find('a') as $link) {
        if(preg_match("/".$celeb[0]."/", $link->href) || preg_match("/".$celeb[1]."/", $link->href)) {
            if($link->find('img')) {
                //echo $link. "<br>" .$link->innertext;
                $newlink = $domain;
                $newlink.= $link->href;
                //echo $link."<br>";
                
                do {
                    $ftml = file_get_html($newlink);
                }
                while ($ftml == FALSE);
                //echo $ftml;
                $arr = array();
                foreach($ftml->find('div[class="social-bar-2a wall-right-links a"]') as $var) {
                    foreach ($var->find('a') as $res) {
                        //echo $res."<br>";
                        array_push($arr, array($res->innertext => $res->href));
                    }
                    if(!empty($arr)){
                        rsort($arr);
                        //$lnk = var_dump($arr[0]);
                        //var_dump($arr);
                        foreach($arr as $temp=>$data) {
                            foreach ($data as $index=>$key) {
                                $img = $key;
                                break;
                            }
                            break;
                        }
                        $link = $img;
                        $img = $domain;
                        $img.= $link;
                        do {
                            $image = file_get_html($img);
                        }
                        while ($image == FALSE);
                        $dest = $image->find('img[id="wall"]');
                        if(!$dest) {
                            $dest = $image->find('img[id="wall"]');
                        }
                        if($dest[0]->attr) {
                            $attr = $dest[0]->attr;
                            $src = $attr["src"];
                        }
                        else {
                            break;
                        }
                        //var_dump($dest);
                    }
                    else {
                        $dest = $ftml->find('img[id="wall"]');
                        $attr = $dest[0]->attr;
                        $src = $attr["src"];
                    }
                    if(get_http_response_code($src) != "404") {
                        if(null_file($src)){
                            do {
                                $file = file_get_contents($src);
                            }
                            while ($file == FALSE);
                        }
                        else {
                            goto fail;
                        }
                    }
                    else{
                        goto fail;
                    }
                    $coun = " ".str_pad($counter, 3,'0',STR_PAD_LEFT);
                    file_put_contents($dir.$name.$coun.".jpg", $file);
                    printf("Source Url -- %s\n",$newlink);
                    printf("%s -- Done\n\n",$src);
                    //echo $src."<br> Done";
                    $counter++;
                    fail:{
                        $cc = 1;
                    }
                }
                //break;
                printf("\n");
                
                ##
            }        
        }          
    }
}

function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

function null_file($url) {
    $headers = get_headers($url);
    if(substr($headers[3], 16) == "0") {
        return false;
    }
    else {
        return true;
    }
}
