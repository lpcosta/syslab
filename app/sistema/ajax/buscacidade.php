<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();

if(!empty($estado)):

        $sql->FullRead("SELECT id_cidade,nome from tb_sys014 WHERE id_estado = :ESTADO", "ESTADO={$estado}");
        foreach ($sql->getResult() as $rowCidade)
            {
                print "<option value=".$rowCidade['id_cidade']." class='cidades'>".$rowCidade['nome']."</option>";
            }
endif;
   
    

