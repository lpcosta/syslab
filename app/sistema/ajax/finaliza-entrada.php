<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql = new Read();
$atu = new Update();

$sql->FullRead("SELECT * FROM tb_sys006 WHERE id_entrada = :ENTRADA", "ENTRADA={$entrada}");
if($sql->getRowCount() > 0):
    $atu->ExeUpdate("tb_sys005",["id_status"=>3], "WHERE identrada = :ENTRADA", "ENTRADA={$entrada}");
    print "Entrada Finalizada!";
else:
    print "Entrada <b>vazia</b> não pode ser finalizada.";
endif;