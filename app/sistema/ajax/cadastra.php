<?php
require_once '../../config/autoload.inc.php';
require_once '../../funcoes/func.inc.php';
$getPost = filter_input_array(INPUT_POST,FILTER_DEFAULT);
$setPost = array_map("strip_tags", $getPost);
$post   = array_map("trim", $setPost);
extract($post);//extraindo os dados
$sqlCad = new Create();
$sqlCons = new Read();
$texto = new Check();
switch ($acao):
    case 'equipamento':
            print "cadastro de equipamento!";
        break;
    case 'software':
        if($tipo == "windows" && !empty($software) && !empty($versao) && !empty($arquitetura)):
            $sqlCons->FullRead("SELECT descricao_so, versao_so,arquitetura_so FROM tb_sys025 WHERE descricao_so = :DESCRICAO AND versao_so = :VERSAO AND arquitetura_so = :ARQUI",
                               "DESCRICAO="."{$texto->Texto($software)}"."&VERSAO="."{$texto->Texto($versao)}"."&ARQUI="."{$texto->Texto($arquitetura)}"."");
            if($sqlCons->getRowCount() <=0):
                $sqlCad->ExeCreate("tb_sys025",["descricao_so"=>$texto->Texto($software),"versao_so"=>$texto->Texto($versao),"arquitetura_so"=>$texto->Texto($arquitetura)]);
                if($sqlCad->getResult()):
                    print "Cadastro Realizado com sucesso!";
                endif;
            else:
                print "Software {$software} {$versao} {$arquitetura}, já Cadastrado!";
            endif;
        elseif($tipo =="office" && !empty($software) && !empty($versao) && !empty($arquitetura)):
            $sqlCons->FullRead("SELECT descricao_office, versao_office,arquitetura_office FROM tb_sys026 WHERE descricao_office = :DESCRICAO AND versao_office = :VERSAO AND arquitetura_office = :ARQUI",
                               "DESCRICAO="."{$texto->Texto($software)}"."&VERSAO="."{$texto->Texto($versao)}"."&ARQUI="."{$texto->Texto($arquitetura)}"."");
            if($sqlCons->getRowCount() <=0):
                $sqlCad->ExeCreate("tb_sys026",["descricao_office"=>$texto->Texto($software),"versao_office"=>$texto->Texto($versao),"arquitetura_office"=>$texto->Texto($arquitetura)]);
                if($sqlCad->getResult()):
                    print "Cadastro Realizado com sucesso!";
                endif;
            else:
                print "Software {$software} {$versao} {$arquitetura}, já Cadastrado!";
            endif;
        else:
            print "Software {$software} {$versao} {$arquitetura}, já Cadastrado!";
        endif;
        break;
    default :
        print "erro ao cadastrar!";
endswitch;




