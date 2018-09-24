<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();
$combo  = new Read();
$texto  = new Check();
$atu    = new Update();

switch ($acao):
    case 'pesquisa':
        $sql->FullRead("SELECT * FROM tb_sys004 WHERE patrimonio = :PAT", "PAT="."{$patrimonio}"."");
        if($sql->getRowCount()> 0):
            print intval($sql->getResult()[0]['id']);
        endif;
        break;
    case 'edita':
        $sql->FullRead("SELECT patrimonio FROM tb_sys004 WHERE serie = :SERIE AND patrimonio != :PAT", "SERIE="."{$serie}"."&PAT="."{$patrimonio}"."");
        if($sql->getRowCount() == 0):
            unset($post['id']);
            unset($post['acao']);
            $atu->ExeUpdate("tb_sys004", $post, "WHERE id = :ID", "ID={$id}");
            if($atu->getResult()):
                print "<span class='alert alert-success' role='alert'>Equipamento atualizado com sucesso!</span>";
            else:
                print $atu->getError();
            endif;
        else:
            print "<span class='alert alert-warning' role='alert'>NUMERO DE SÉRIE INFORMADO JÁ ESTA EM USO POR OUTRO EQUIPAMENTO</span>";
        endif;
        break;
    default :
        print "<h1>Erro desconhecido! <code>acao default da condição de pesquisa</code></h1>";
endswitch;

