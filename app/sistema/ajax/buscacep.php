<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();

    if(!empty($cidade)):

        $sql->FullRead("SELECT cep FROM tb_sys014 WHERE id_cidade = :CID", "CID={$cidade}");
        foreach ($sql->getResult() as $rowCep)
            {
                print $rowCep['cep'];
            }
    endif;
   
    