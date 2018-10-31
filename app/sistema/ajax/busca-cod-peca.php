<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();

 $sql->FullRead("SELECT id_peca,preco_refencia,flag FROM tb_sys015 WHERE id_peca = :PECA", "PECA={$peca}");
   
if($sql->getResult()):
    print_r(implode(",",$sql->getResult()[0]));
endif;

