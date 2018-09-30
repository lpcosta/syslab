<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';
session_start();
$sql = new Read();
$atu = new Update();
$cria = new Create();
$hoje = date('Y-m-d');
$sql->FullRead("SELECT identrada, data, nome, id_tecnico FROM tb_sys005 JOIN tb_sys001 ON tb_sys005.id_tecnico = tb_sys001.id AND id_tecnico = :TEC  AND id_status = :STS", "TEC={$tecnico}&STS=1");
    if($sql->getRowCount() > 0):
        $entrada = $sql->getResult()[0]['identrada'];
        if($hoje == $sql->getResult()[0]['data']):
            print $entrada;
        else:
            $sql->FullRead("SELECT id FROM tb_sys006 WHERE id_entrada = :ENTRADA", "ENTRADA={$entrada}");
            if($sql->getRowCount() > 0):
                $atu->ExeUpdate("tb_sys005", ["id_status"=>3,"data"=>date('Y-m-d'),"hora"=>date('H:i:s'),"nome_responsavel"=>$_SESSION['UserLogado']['nome']], "WHERE identrada = :ENTRADA", "ENTRADA={$entrada}");
                $cria->ExeCreate("tb_sys005", ["id_tecnico"=>$tecnico,"data"=>date('Y-m-d'),"hora"=>date('H:i:s'),"id_status"=>1,"nome_responsavel"=>$_SESSION['UserLogado']['nome']]);     
                print $cria->getResult();
            else:
                $atu->ExeUpdate("tb_sys005", ["data"=>date('Y-m-d'),"hora"=>date('H:i:s'),"nome_responsavel"=>$_SESSION['UserLogado']['nome']], "WHERE identrada = :ENTRADA", "ENTRADA={$entrada}");
                print $entrada;
            endif;
        endif;
    else:
        $cria->ExeCreate("tb_sys005", ["id_tecnico"=>$tecnico,"data"=>date('Y-m-d'),"hora"=>date('H:i:s'),"id_status"=>1,"nome_responsavel"=>$_SESSION['UserLogado']['nome']]);
        print $cria->getResult();          
    endif;