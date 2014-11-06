<?php

/*
 * 站点列表
 */
$mmlist = array(
    array(
        'name' => 'G广州妈妈网',
        'url' => 'http://www.gzmama.com/'
    ),
    array(
        'name' => 'B北京妈妈网',
        'url' => 'http://www.bjmama.net/'
    ),
    array(
        'name' => 'T天津妈妈网',
        'url' => 'http://www.tjmama.com/'
    ),
    array(
        'name' => 'S上海妈妈网',
        'url' => 'http://www.shmama.net/'
    ),
    array(
        'name' => 'S深圳妈妈网',
        'url' => 'http://www.szmama.com/'
    ),
    array(
        'name' => 'S沈阳妈妈网',
        'url' => 'http://www.symama.com/'
    ),
    array(
        'name' => 'C成都妈妈网',
        'url' => 'http://www.cdmama.cn/'
    ),
    array(
        'name' => 'C重庆妈妈网',
        'url' => 'http://www.cqmama.net/'
    ),
    array(
        'name' => 'X西安妈妈网',
        'url' => 'http://www.xamama.net/'
    ),
    array(
        'name' => 'J济南妈妈网',
        'url' => 'http://www.jnmama.com/'
    ),
    array(
        'name' => 'C长沙妈妈网',
        'url' => 'http://www.csmama.net/'
    ),
    array(
        'name' => 'H杭州妈妈网',
        'url' => 'http://www.hzmama.net/'
    ),
    array(
        'name' => 'W武汉妈妈网',
        'url' => 'http://www.whmama.com/'
    ),
    array(
        'name' => 'H合肥妈妈网',
        'url' => 'http://www.hfmama.com/'
    ),
    array(
        'name' => 'S石家庄妈妈网',
        'url' => 'http://www.sjzmama.com/'
    ),
    array(
        'name' => 'Z郑州妈妈网',
        'url' => 'http://www.zzmama.net/'
    ),
    array(
        'name' => 'C长春妈妈网',
        'url' => 'http://www.ccmama.com/'
    ),
    array(
        'name' => 'N南京妈妈网',
        'url' => 'http://www.njmama.com/'
    ),
    array(
        'name' => 'N南宁妈妈网',
        'url' => 'http://www.nnmama.com/'
    ),
    array(
        'name' => 'W无锡妈妈网',
        'url' => 'http://www.wxmama.com/'
    ),
    array(
        'name' => 'S苏州妈妈网',
        'url' => 'http://www.szmama.net/'
    ),
    array(
        'name' => 'Q青岛妈妈网',
        'url' => 'http://www.qdmama.net/'
    ),
    array(
        'name' => 'K昆明妈妈网',
        'url' => 'http://www.kmmama.com/'
    ),
    array(
        'name' => 'H哈尔滨妈妈网',
        'url' => 'http://www.hrbmama.com/'
    ),
    array(
        'name' => 'F福州妈妈网',
        'url' => 'http://www.fzmama.net/'
    ),
    array(
        'name' => 'X厦门妈妈网',
        'url' => 'http://www.xmmama.com/'
    ),
    array(
        'name' => 'N南昌妈妈网',
        'url' => 'http://www.ncmama.cn/'
    ),
    array(
        'name' => 'Z中山妈妈网',
        'url' => 'http://www.zsmama.com/'
    ),
    array(
        'name' => 'D东莞妈妈网',
        'url' => 'http://www.dgmama.net/'
    ),
    array(
        'name' => 'S汕头妈妈网',
        'url' => 'http://www.shantoumama.com/'
    ),
    array(
        'name' => 'F佛山妈妈网',
        'url' => 'http://www.fsmama.com/'
    ),
    array(
        'name' => 'G贵阳妈妈网',
        'url' => 'http://www.gymama.com/'
    ),
    array(
        'name' => 'M妈妈圈',
        'url' => 'http://quan.mama.cn/'
    ),
);

$bcity = array(
    array(
        'name' => 'C百城',
        'url' => 'http://citybbs.cn/'
    ),
    array(
        'name' => 'Z肇庆',
        'url' => 'http://www.0758life.com/'
    ),
    array(
        'name' => 'Q清远',
        'url' => 'http://qy.city166.com/'
    ),
    array(
        'name' => 'H邯郸',
        'url' => 'http://hd.city166.com/'
    ),
    array(
        'name' => 'S商丘',
        'url' => 'http://sq.city166.com/'
    ),
);
$gbklist=array('http://citybbs.cn/','http://www.0758life.com/', 'http://qy.city166.com/');
$sitelist = array_merge($mmlist, $bcity);
//var_dump($sitelist);
$sitelist =$mmlist;
asort($sitelist);
//var_dump($sitelist);
?>