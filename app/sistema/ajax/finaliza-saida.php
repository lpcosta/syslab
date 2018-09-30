<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql = new Read();
$atu = new Update();

$sql->FullRead("SELECT * FROM tb_sys009 WHERE id_saida = :SAIDA", "SAIDA={$saida}");
if($sql->getRowCount() > 0):
    $atu->ExeUpdate("tb_sys007",["id_status"=>3], "WHERE id = :SAIDA", "SAIDA={$saida}");
    print "Saida Finalizada!";
else:
    print "Saida <b>vazia</b> não pode ser finalizada.";
endif;