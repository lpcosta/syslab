<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql = new Read();

$sql->ExeRead("tb_sys004 WHERE id = {$id}");

if($sql->getResult()[0]['serie']==null):
    print "<div class=\"alert alert-info text-primary\">Por favor Informar o Número de Série do Equipamento!<br />
            para isso, vá em, <b>Menu</b> > <b>Administração</b> > <b>Gerenciar</b> > <b>Equipamento</b> > <b>Editar</b> e informe o número de serie!<br >
            Se preferir pode <a href=\"index.php?pg=edita/equipamento&id={$sql->getResult()[0]['id']}\"><span class='text-primary'><b>clicar aqui!</b></span></a> que você sera redirecionado a tela de edição!.
           </div>";
else:
    switch ($equipamento):
        case 2:
            extract($sql->getResult()[0]);
           if(empty($so_id) || empty($key_so)|| empty($key_office) || empty($office_id) || empty($hd) || empty($memoria_ram_id) || empty($processador_id)):
               print "<div class=\"alert alert-info text-primary\">Notamos que essa CPU esta sem alguns dos dados que são importantes para manter um melhor controle dos equipamentos que passam pelo laboratorio.<br />
                    por favor verifique se <b>Memória Ram</b>,<b>Processador</b>, <b>HD</b>, <b>Sistema Operacional</b>, <b>Office</b> e suas Respectivas chaves estão corretas e cadastradas. Se não tiver por favor corrija-os.<br />
                    Para isso vá em <b>Menu</b> > <b>Administração</b> > <b>Gerenciar</b> > <b>Equipamento</b> > <b>Editar</b> e informe os dados acima!<br >
                    Se preferir pode <a href=\"index.php?pg=edita/equipamento&id={$sql->getResult()[0]['id']}\"><span class='text-primary'><b>clicar aqui!</b></span></a> que você sera redirecionado a tela de edição!.
                   </div>";
           endif;
            break;
        default :
    endswitch;
endif;


