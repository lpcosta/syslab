<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';
$sqlCad = new Create();
$sqlCons = new Read();
$texto = new Check();
session_start();
$post['dt_baixa'] = date('Y-m-d H:i:s');
$post['responsavel'] = $_SESSION['UserLogado']['nome'];

$sqlCons->FullRead("SELECT quantidade FROM tb_sys027 WHERE codigo_peca = :CODIGO","CODIGO={$post['peca_id']}");
if($sqlCons->getResult()[0]['quantidade'] > 0):
    print "realizar baixa";
else:
    print "Baixa <b>Não</b> Realizada <b><br />Motivo: </b>Peça Indisponível";
endif;