<?php

    $get_url=$_SERVER['REQUEST_URI'];
    $URL_COUNT=mb_strlen($get_url);
    
    if($URL_COUNT>100){
      echo 'this URL not allow!';exit;
    }
    $parse = parse_url($get_url);

    $path = ltrim($parse['path'], '/');

    
    //路由违禁词
    $prohibit=[
    
      'S=','*','-','^','./','!','>','<','"','.php','..','think','.vbs','script','.java','node','root','linux','cmd','.jsp','eval','(',')'

    ];

    $testing='SB'.$get_url;

    foreach($prohibit as $k=>$v){

      if(strpos($testing,$v)){

        echo "{$v} This url no! Length:{$URL_COUNT}";exit;

      }

    }
  


?>