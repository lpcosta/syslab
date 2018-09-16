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

//var_dump($post);

switch ($acao):
    case 'equipamento':
            print "cadastro de equipamento!";
        break;
    case 'software':
        if($tipo == "windows" && !empty($windows) && !empty($VersaoWindows) && !empty($ArquiteturaSo)):
            $sqlCons->FullRead("SELECT descricao_so, versao_so,arquitetura_so FROM tb_sys025 WHERE descricao_so = :DESCRICAO AND versao_so = :VERSAO AND arquitetura_so = :ARQUI",
                               "DESCRICAO="."{$texto->setTexto($windows)}"."&VERSAO="."{$texto->setTexto($VersaoWindows)}"."&ARQUI="."{$texto->setTexto($ArquiteturaSo)}"."");
            if($sqlCons->getRowCount() <=0):
                $sqlCad->ExeCreate("tb_sys025",["descricao_so"=>$texto->setTexto($windows),"versao_so"=>$texto->setTexto($VersaoWindows),"arquitetura_so"=>$texto->setTexto($ArquiteturaSo)]);
                if($sqlCad->getResult()):
                   print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
                else:
                   print "<p>{$sqlCad->getError()}</p>";
                endif;
            else:
                print "<span class=\"alert alert-warning\" role=\"alert\">Software {$windows} {$VersaoWindows} {$ArquiteturaSo}, já Cadastrado!</span>";
            endif;
        elseif($tipo =="office" && !empty($office) && !empty($versaoOffice) && !empty($arquiteturaOffice)):
            $sqlCons->FullRead("SELECT descricao_office, versao_office,arquitetura_office FROM tb_sys026 WHERE descricao_office = :DESCRICAO AND versao_office = :VERSAO AND arquitetura_office = :ARQUI",
                               "DESCRICAO="."{$texto->setTexto($office)}"."&VERSAO="."{$texto->setTexto($versaoOffice)}"."&ARQUI="."{$texto->setTexto($arquiteturaOffice)}"."");
            if($sqlCons->getRowCount() <=0):
                $sqlCad->ExeCreate("tb_sys026",["descricao_office"=>$texto->setTexto($office),"versao_office"=>$texto->setTexto($versaoOffice),"arquitetura_office"=>$texto->setTexto($arquiteturaOffice)]);
                if($sqlCad->getResult()):
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
            else:
                print "<span class=\"alert alert-warning\" role=\"alert\">Software {$office} {$versaoOffice} {$arquiteturaOffice}, já Cadastrado!</span>";
            endif;
        else:
            print "Erro ao cadastrar o Software (erro de parametro, contate o analista do sistema!)";
        endif;
        break;
    case 'usuario':
        $sqlCons->FullRead("SELECT email,login FROM tb_sys001 WHERE email= :EMAIL or login = :LOGIN", "EMAIL="."{$texto->setTexto($mailUser)}"."&LOGIN="."{$texto->setTexto($loginUser)}"."");
       
        if($sqlCons->getRowCount() > 0):
            if($sqlCons->getResult()[0]['email'] === $mailUser):
                print "<span class=\"alert alert-warning\" role=\"alert\">o e-mail informado já esta em uso!</span>";
            elseif($sqlCons->getResult()[0]['login'] === $loginUser):
               print "<span class=\"alert alert-warning\" role=\"alert\">o login informado não esta disponivel</span>";
            else:
                print "<p>error!<br /> não faço idéia de como você veio parar aqui...</p>";
            endif;
        else:
            $password = new Senha();
            $sqlCad->ExeCreate("tb_sys001",["nome"=>$texto->setTexto($nomeUser),
                                            "email"=>$texto->setTexto($mailUser),
                                            "contato"=>$texto->setTexto($contatoUser),
                                            "celular"=>$texto->setTexto($celularUser),
                                            "login"=>$texto->setTexto($loginUser),
                                            "senha"=>$password->setSenha('syslabab'),
                                            "dt_cadastro"=>date('Y-m-d H:i:s'),
                                            "situacao"=>"l",
                                            "tipo"=>$texto->setTexto($tipoUser),
                                            "grupo_id"=>$texto->setTexto($grupoUser),
                                            "senha_padrao"=>$texto->setTexto('sim'),
                                            "id_empresa"=>$texto->setTexto($empresaUser)
                                            ]);
            if($sqlCad->getResult()):
                print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
            else:
                print "<p>{$sqlCad->getError()}</p>";
            endif;
        endif;
        break;
    default :
          print "<span class=\"alert alert-warning\" role=\"alert\">Erro ao cadastrar! ação nao encontrada!,
                Contate o desenvolvedor do sistema 
                e que deus o ajude... </span>";
endswitch;