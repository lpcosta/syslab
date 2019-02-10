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
                print "<code>".$atu->getError()."</code>";
            endif;
        else:
            print "<span class='alert alert-warning' role='alert'>NUMERO DE SÉRIE INFORMADO JÁ ESTA EM USO POR OUTRO EQUIPAMENTO</span>";
        endif;
        break;
    case 'peca':
        unset($post['id_peca']);unset($post['id']);unset($post['acao']);
        $post['preco_refencia'] = str_replace(",",".",$post['preco_refencia']);
        $atu->ExeUpdate("tb_sys015", $post, "WHERE id_peca = :ID", "ID={$id_peca}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "<code>".$atu->getError()."</code>";
        endif;
        break;
    case 'localidade':
        unset($post['id']);unset($post['acao']);
        $atu->ExeUpdate("tb_sys008", $post, "WHERE id = :ID", "ID={$id}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "<code>".$atu->getError()."</code>";
        endif;
        break;
    case 'usuario':
        unset($post['id']);unset($post['acao']);
        $atu->ExeUpdate("tb_sys001", $post, "WHERE id = :ID", "ID={$id}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "<code>".$atu->getError()."</code>";
        endif;
        break;
    case 'avaliacao':
        unset($post['id']); unset($post['acao']);
        $atu->ExeUpdate("tb_sys010", $post, "WHERE id = :ID", "ID={$id}");
        if(!$atu->getResult()):
            print $sql->getError();
        endif;
        break;
    case 'memoria':
        unset($post['id']); unset($post['acao']);
          $atu->ExeUpdate("tb_sys029", $post, "WHERE id = :ID", "ID={$id}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "<code>".$atu->getError()."</code>";
        endif;
        break;
    case 'processador':
        unset($post['id']); unset($post['acao']);
        $atu->ExeUpdate("tb_sys028", $post, "WHERE id = :ID", "ID={$id}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "<code>".$atu->getError()."</code>";
        endif;
        break;
    case 'windows':
        unset($post['id']); unset($post['acao']);
        $atu->ExeUpdate("tb_sys025", $post, "WHERE id_so = :ID", "ID={$id}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "<code>".$atu->getError()."</code>";
        endif;
        break;
    case 'office':
        unset($post['id']); unset($post['acao']);
        $atu->ExeUpdate("tb_sys026", $post, "WHERE id_office = :ID", "ID={$id}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "<code>".$atu->getError()."</code>";
        endif;
        break;
    case 'password':
        unset($post['login']); unset($post['acao']);
        $senha = new Senha();
        $sql->FullRead("SELECT id FROM tb_sys001 WHERE login = :LGN AND senha = :PASS", "LGN=".$login."&PASS=".$senha->setSenha($pass_atu)."");
        if($sql->getResult()):
            $senha = $senha->setSenha($novo_pass);
            $atu->ExeUpdate("tb_sys001", ["senha"=>$senha], "WHERE login = :LGN", "LGN={$login}");
            if($atu->getResult()):
                print "<span class='alert alert-success' role='alert'>Senha Redefinida!</span>";
            else:
                print "<code>".$atu->getError()."</code>";
            endif;
        else:
             print "<span class='alert alert-warning'>Senha atual Informada Não confere!</span>";
        endif;
        break;
    case 'entrada':
        unset($post['id']); unset($post['acao']);
        $atu->ExeUpdate("tb_sys006", $post, "WHERE id = :ID", "ID={$id}");
        if($atu->getResult()):
            print "<span class='alert alert-success' role='alert'>Atualização Realizada!</span>";
        else:
            print "<code>".$atu->getError()."</code>";
        endif;
        break;
    default :
        print "<h1>Erro desconhecido! <code>acao default da condição de pesquisa</code></h1>";
endswitch;
