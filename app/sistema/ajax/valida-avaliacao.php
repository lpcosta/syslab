<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql = new Read();

$sql->ExeRead("tb_sys004 WHERE id = {$id}");

if($sql->getResult()[0]['serie']==null):
    print "<p>por favor Informe o Número de Série<br />para manter uma melhor integridade dos dados...</p>";
else:
    switch ($equipamento):
        case 2:
            extract($sql->getResult()[0]);
           if(empty($so_id) || empty($key_so)|| empty($key_office) || empty($office_id) || empty($hd) || empty($memoria_ram)):
               print "por favor verifique se HD,MEMORIA RAM Sistema operacional Office e seus seriais estao corretos e preenchidos!";
           endif;
            break;
        default :
            print "Ops! houve um erro no sistema e... eu nao faço ideia de como veio parar aqui";
    endswitch;
endif;