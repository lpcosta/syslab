<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';
require_once '../../funcoes/func.inc.php';
paginaSegura();

$sql    = new Read();
$texto  = new Check();
$atu    = new Update();

foreach ($post as $key => $value):
    $post[$key]=$texto->setTexto($value);
endforeach;

switch ($acao):
    case 'equipamento':
        $sql->FullRead("SELECT patrimonio FROM tb_sys004 WHERE serie = :SERIE AND patrimonio != :PAT", "SERIE="."{$serie}"."&PAT="."{$patrimonio}"."");
        if($sql->getRowCount() == 0):
            unset($post['id']);
            unset($post['acao']);
            $atu->ExeUpdate("tb_sys004", $post, "WHERE id = :ID", "ID={$id}");
            if($atu->getResult()):
                print "<span class='alert alert-success' role='alert'>Equipamento atualizado!</span>";
            else:
                print "Erro: <code>".$atu->getError()."</code>";
            endif;
        else:
            print "<span class='alert alert-warning' role='alert'>NUMERO DE SÉRIE INFORMADO JÁ ESTA EM USO POR OUTRO EQUIPAMENTO</span>";
        endif;
        break;
    case 'peca':
        unset($post['id_peca']);unset($post['id']);unset($post['acao']);
        $atu->ExeUpdate("tb_sys015", $post, "WHERE id_peca = :ID", "ID={$id_peca}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "Erro <code>".$atu->getError()."</code>";
        endif;
        break;
    case 'localidade':
        unset($post['id']);unset($post['acao']);
        $atu->ExeUpdate("tb_sys008", $post, "WHERE id = :ID", "ID={$id}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "Erro <code>".$atu->getError()."</code>";
        endif;
        break;
    case 'usuario':
        unset($post['id']);unset($post['acao']);
        $atu->ExeUpdate("tb_sys001", $post, "WHERE id = :ID", "ID={$id}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "Erro <code>".$atu->getError()."</code>";
        endif;
        break;
    case 'avaliacao':
        unset($post['id']); unset($post['acao']);
        $atu->ExeUpdate("tb_sys010", $post, "WHERE id = :ID", "ID={$id}");
        if(!$atu->getResult()):
            print $sql->getError();
        endif;
        break;
    default :
        print "<h1>Erro desconhecido! <code>acao default da condição de pesquisa</code></h1>";
endswitch;
