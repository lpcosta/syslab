<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();
$texto  = new Check();
$atu    = new Update();

if(!empty($id_peca)):
    unset($post['id_peca']);
    $post['descricao_peca'] = $texto->setTexto($post['descricao_peca']);
    
    $atu->ExeUpdate("tb_sys015", $post, "WHERE id_peca = :ID", "ID={$id_peca}");
    if($atu->getResult()):
        print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
    else:
        print "Erro <code>".$atu->getError()."</code>";
    endif;
else:
    print "Erro <code>Não foi possivel atualizar  a peça! não foi possivel encontrar o codigo para atualização!</code>";
endif;