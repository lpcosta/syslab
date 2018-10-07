<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();
$texto  = new Check();
$atu    = new Update();

switch ($acao):
    case 'pesquisa':
        $sql->FullRead("SELECT id_peca FROM tb_sys015 WHERE id_peca = :ID", "ID={$id_peca}");
        if($sql->getRowCount()> 0):
            print intval($sql->getResult()[0]['id_peca']);
        endif;
        break;
    case 'edita':
            unset($post['id']);
            unset($post['acao']);
            $post['descricao_peca'] = $texto->setTexto($post['descricao_peca']);
            intval($id);
            $atu->ExeUpdate("tb_sys015", $post, "WHERE id_peca = :ID", "ID={$id}");
            if($atu->getResult()):
                print "<span class='alert alert-success' role='alert'>Equipamento atualizado com sucesso!</span>";
            else:
                print $atu->getError();
            endif;
        break;
    default :
        print "<h1>Erro desconhecido! <code>acao default da condição de pesquisa</code></h1>";
endswitch;
