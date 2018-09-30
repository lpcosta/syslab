<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';
session_start();
$sql = new Read();
$atu = new Update();
$cria = new Create();
$hoje = date('Y-m-d');
$texto = new Check();

if($tiposaida):
    $id_tecnico = $tiposaida;
endif;

$sql->FullRead("SELECT id,data FROM tb_sys007 WHERE id_tecnico = :TEC AND id_status = :STS", "TEC={$id_tecnico}&STS=1");
if($sql->getRowCount() == 0):
    $cria->ExeCreate("tb_sys007", ["id_tecnico"=>$id_tecnico,
                                   "data"=>date('Y-m-d'),
                                   "hora"=>date('H:i:s'),
                                   "id_status"=>1,
                                   "nome_fun"=>$texto->setTexto($post['nome_fun']),
                                   "doc_fun"=>$texto->setTexto($post['doc_fun']),
                                   "responsavel"=>$post['responsavel']
                                   ]);
    print $cria->getResult();

else:
    if($sql->getResult()[0]['data']== $hoje):
        print $sql->getResult()[0]['id'];
    else:
        $saida = $sql->getResult()[0]['id'];
        $sql->FullRead("SELECT id,id_saida FROM tb_sys009 WHERE id_saida = :ID", "ID:{$saida}");
        if($sql->getRowCount() > 0):
            $atu->ExeUpdate("tb_sys007", ['id_status'=>3], "WHERE id = :IDSAIDA", "IDSAIDA={$saida}");
            $cria->ExeCreate("tb_sys007", ["id_tecnico"=>$id_tecnico,
                                   "data"=>date('Y-m-d'),
                                   "hora"=>date('H:i:s'),
                                   "id_status"=>1,
                                   "nome_fun"=>$texto->setTexto($post['nome_fun']),
                                   "doc_fun"=>$texto->setTexto($post['doc_fun']),
                                   "responsavel"=>$post['responsavel']
                                   ]);
            print $cria->getResult();
        else:
            $atu->ExeUpdate("tb_sys007", ['data'=>date('Y-m-d'),"hora"=>date('H:i:s'),"responsavel"=>$post['responsavel']], "WHERE id = :IDSAIDA", "IDSAIDA={$saida}");
            print $saida;
        endif;
    endif;
endif;