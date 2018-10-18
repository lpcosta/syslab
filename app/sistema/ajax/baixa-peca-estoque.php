<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';
$sqlCad  = new Create();
$sqlCons = new Read();
$texto   = new Check();
$atu     = new Update();

session_start();
$post['dt_baixa'] = date('Y-m-d H:i:s');
$post['responsavel'] = $_SESSION['UserLogado']['nome'];
$id_item_entrada = $bancada;
unset($post['bancada']);
$sqlCons->FullRead("SELECT quantidade FROM tb_sys027 WHERE codigo_peca = :CODIGO","CODIGO={$peca_id}");
if($sqlCons->getResult()[0]['quantidade'] > 0):
   $quantidade = ($sqlCons->getResult()[0]['quantidade'] - 1);
   $sqlCad->ExeCreate("tb_sys016", $post);
            if($sqlCad->getResult()):
                $atu->ExeUpdate("tb_sys027", ["quantidade"=>$quantidade], "WHERE codigo_peca = :CODIGOPECA", "CODIGOPECA={$peca_id}");
                if($id_item_entrada != 0):
                    $sqlCons->fullRead("SELECT id FROM tb_sys010 WHERE id_item_entrada = :IDITEM AND id_status = :STS AND peca_id = :PECA","IDITEM={$id_item_entrada}&STS=5&PECA={$peca_id}");
                    $atu->ExeUpdate("tb_sys010", ["id_status"=>3,"dt_baixa"=>date('Y-m-d')], "WHERE id = :ID", "ID={$sqlCons->getResult()[0]['id']}");
                endif;
                print "<span class=\"alert alert-success\" role=\"alert\">Baixa Realizado com sucesso!";
            else:
                print "<p>{$sqlCad->getError()}</p>";
            endif;
else:
    print "Baixa <b>Não</b> Realizada <b><br />Motivo: </b>Peça Indisponível";
endif;