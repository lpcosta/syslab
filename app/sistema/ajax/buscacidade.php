<?php
require_once '../../config/autoload.inc.php';
$sql = new Read();

extract(filter_input_array(INPUT_POST, FILTER_DEFAULT));

$estado = strip_tags(trim(intval($estado)));

if(!empty($estado)):

        $sql->FullRead("SELECT id_cidade,nome from tb_sys014 WHERE id_estado = :ESTADO", "ESTADO={$estado}");
        foreach ($sql->getResult() as $rowCidade)
            {
                print "<option value=".$rowCidade['id_cidade']." class='cidades'>".$rowCidade['nome']."</option>";
            }
endif;
   
    

