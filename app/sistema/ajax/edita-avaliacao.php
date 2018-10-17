<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Update();
$texto  = new Check();

$sql->ExeUpdate("tb_sys010", ["avaliacao"=>$texto->setTexto($nova_avaliacao),"id_status"=>$novo_status], "WHERE id = :ID", "ID={$id}");
    if(!$sql->getResult()):
        print $sql->getError();
    endif;