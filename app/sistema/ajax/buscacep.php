<?php
require_once '../../config/config.inc.php';
$sql = new Read();

extract(filter_input_array(INPUT_POST, FILTER_DEFAULT));

$cidade = strip_tags(trim(intval($cidade)));

    if(!empty($cidade)):

        $sql->FullRead("SELECT cep FROM tb_sys014 WHERE id_cidade = :CID", "CID={$cidade}");
        foreach ($sql->getResult() as $rowCep)
            {
                print $rowCep['cep'];
            }
    endif;
   
    