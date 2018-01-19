<?php
    $k = $_POST['search'];
    $limit = $_POST['limit'];
    if($_POST['key']!=='{TOKEN}') die('TOKEN FAIL');
    
    $i=0;
    $url = "http://images.google.it/images?as_q=##query##&hl=it&imgtbs=z&btnG=Cerca+con+Google&as_epq=&as_oq=&as_eq=&imgtype=&imgsz=m&imgw=&imgh=&imgar=&as_filetype=&imgc=&as_sitesearch=&as_rights=&safe=images&as_st=y&biw=1366&bih=682&dpr=1&as_st=y&tbs=isz:m,sur:fc&tbm=isch&source=lnt&sa=X";
    $web_page = file_get_contents( str_replace("##query##",urlencode($k), $url ));
    $td = explode('id="resultStats"',$web_page);
    $td_i = explode('<td',$td[1]);

    unset($td_i[0]);
    foreach ($td_i as $elem) {
        if($i>=$limit) continue;
        $one = explode('src="',$elem);
        if(!isset($one[1])) continue;
        $two = explode('"',$one[1]);
        $img = $two[0];
        $one = explode('href="/url?q=',$elem);
        if(!isset($one[1])) continue;
        $two = explode('&',$one[1]);
        $array[] = array(
            'thumbnail_src'=> $img,
            'link'=>$two[0]
        );
        $i++;
    }
    echo json_encode($array);

?>
