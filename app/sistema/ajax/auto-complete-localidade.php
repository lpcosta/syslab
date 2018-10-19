<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';
require_once '../../funcoes/func.inc.php';

$sql = new Read();
$texto = new Check();

$local = $texto->setTexto($p);

$sql->FullRead("SELECT id,local FROM tb_sys008 WHERE local LIKE :LOCAL","LOCAL=%".$local."%");

$response="[";
    foreach($sql->getResult() as $row){
        if($response !="[")$response.=",";
        $response.='{"label":"'. ucwords($row["local"]).'","value":"'.$row["id"].'"}';
    }
    $response.="]";
       print $response;