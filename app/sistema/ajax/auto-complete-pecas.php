<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';
require_once '../../funcoes/func.inc.php';

$sql = new Read();
$texto = new Check();

$peca = $texto->setTexto($p);

$sql->FullRead("SELECT id_peca,descricao_peca FROM tb_sys015 WHERE descricao_peca LIKE :PECA or id_peca = :ID","PECA=%".$peca."%&ID={$peca}");

$response="[";
    foreach($sql->getResult() as $row){
        if($response !="[")$response.=",";
        $response.='{"label":"'. ucwords($row["descricao_peca"]).'","value":"'.$row["id_peca"].'"}';
    }
    $response.="]";
       print $response;