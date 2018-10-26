<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();

 $sql->FullRead("SELECT id_peca,preco_refencia FROM tb_sys015 WHERE flag = :ID AND id_peca = :PECA", "ID=0&PECA={$peca}");
   
if($sql->getResult()):
    //print $sql->getResult()[0]['id_peca'];
    print_r(implode(",",$sql->getResult()[0]));
endif;

