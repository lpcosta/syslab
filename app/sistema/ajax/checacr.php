<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();

$sql->FullRead("SELECT id FROM tb_sys008 WHERE cr = :CR", "CR={$cr}");
    
    if($sql->getRowCount() > 0):
        print (int)$sql->getResult()[0]['id'];
    else:
        print "código ou cr não encontrado!";
    endif;