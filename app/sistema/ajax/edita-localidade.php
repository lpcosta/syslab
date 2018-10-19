<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();
$texto  = new Check();
$atu    = new Update();

if(!empty($id)):
    unset($post['id']);
    $post['cr']     = $texto->setTexto($post['cr']);
    $post['local']  = $texto->setTexto($post['local']);
    $post['rua']    = $texto->setTexto($post['rua']);
    $post['cep']    = $texto->setTexto($post['cep']);
    $post['bairro'] = $texto->setTexto($post['bairro']);
    
    $atu->ExeUpdate("tb_sys008", $post, "WHERE id = :ID", "ID={$id}");
    if($atu->getResult()):
        print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
    else:
        print "Erro <code>".$atu->getError()."</code>";
    endif;
else:
    print "Erro <code>Não foi possivel atualizar  a localidade! não foi possivel encontrar o codigo para atualização!</code>";
endif;
