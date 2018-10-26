<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';
require_once '../../funcoes/func.inc.php';

switch ($acao):
    case 'peca':
        buscaResultado(["descricao_peca","id_peca"], "tb_sys015", "descricao_peca", "{$p}");
        break;
    case 'localidade':
        buscaResultado(["local","id"], "tb_sys008", "local", "{$p}");
        break;
    case 'patrimonio':
        buscaResultado(["patrimonio","id"], "tb_sys004", "patrimonio", "{$p}");
        break;
    case 'serie':
        buscaResultado(["serie","id"], "tb_sys004", "serie", "{$p}");
        break;
    case 'usuario':
        buscaResultado(["nome","id"], "tb_sys001", "nome", "{$p}");
        break;
    case 'avalia':
        buscaResultado(["patrimonio","id"], "tb_sys006", "status != 3 AND patrimonio", "{$p}");
    default :
        NULL;
endswitch;

function buscaResultado(array $campos,$tabela,$cond,$valor) {
    $sql    = new Read();
    $texto  = new Check();
    $lista  = $texto->setTexto($valor);
    $fields = implode(",", $campos);
    $sql->FullRead("SELECT {$fields} FROM {$tabela} WHERE {$cond} LIKE :COND ORDER BY {$campos[0]} limit 20","COND=".$lista."%");
    $json = [];
    foreach ($sql->getResult() as $row):
        array_push($json, ["label" => ucwords($row[$campos[0]]),"value" =>$row[$campos[1]]]);
    endforeach;
    return print json_encode($json);
}
