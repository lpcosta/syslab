<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();

 $sql->FullRead("SELECT * FROM db_syslab.tb_sys015 where categoria_id = :ID and id_peca = :PECA", "ID=0&PECA={$post['peca']}");
   
if($sql->getResult()):
    print $sql->getResult()[0]['id_peca'];
endif;

