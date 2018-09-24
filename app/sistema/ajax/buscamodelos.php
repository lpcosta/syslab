<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();

if(isset($fabricante) && empty($modelo)):
    $sql->FullRead("SELECT * FROM tb_sys022 where fabricante_id = :IDFAB ORDER BY modelo ", "IDFAB={$fabricante}");
    foreach ($sql->getResult() as $res):
        print "<option value=".$res['id_modelo']." class='cmbv_modelos'>".ucfirst($res['modelo'])."</option>";
    endforeach;
elseif(isset($modelo)):
    $sql->FullRead("SELECT * FROM tb_sys022 where fabricante_id = :IDFAB AND id_modelo = :MOD", "IDFAB={$fabricante}&MOD={$modelo}");
    foreach ($sql->getResult() as $res):
        print "<option value=".$res['id_modelo']." class='cmbv_modelos'>".ucfirst($res['modelo'])."</option>";
    endforeach;
endif;
