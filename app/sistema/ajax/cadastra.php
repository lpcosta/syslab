<?php
require_once '../../config/autoload.inc.php';
require_once '../../funcoes/func.inc.php';
$getPost = filter_input_array(INPUT_POST,FILTER_DEFAULT);
$setPost = array_map("strip_tags", $getPost);
$post   = array_map("trim", $setPost);
extract($post);//extraindo os dados
$sqlCad = new Create();
$sqlCons = new Read();
switch ($acao):
    case 'equipamento':
            print "cadastro de equipamento!";
        break;
    case 'software':
        if($tipo == "windows" && !empty($software) && !empty($versao) && !empty($arquitetura)):
            $sqlCons->FullRead("SELECT descricao_so, versao_so,arquitetura_so FROM tb_sys025 WHERE descricao_so = :DESCRICAO AND versao_so = :VERSAO AND arquitetura_so = :ARQUI",
                               "DESCRICAO="."{$software}"."&VERSAO="."{$versao}"."&ARQUI="."{$arquitetura}"."");
            if($sqlCons->getRowCount() <=0):
                $sqlCad->ExeCreate("tb_sys025",["descricao_so"=>$software,"versao_so"=>$versao,"arquitetura_so"=>$arquitetura]);
                if($sqlCad->getResult()):
                    print "Cadastro Realizado com sucesso!";
                endif;
            else:
                print "Software {$software} {$versao} {$arquitetura}, já Cadastrado!";
            endif;
        elseif($tipo =="office"):
            print 'cadastro de Office!';
        else:
            print "erro ao cadastrar Software!";
        endif;
        break;
    default :
        print "erro ao cadastrar!";
endswitch;




