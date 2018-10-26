<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sqlCad     = new Create();
$sqlCons    = new Read();
$texto  = new Check();
foreach ($post as $key => $value):
    $post[$key]=$texto->setTexto($value);
endforeach;

switch ($acao):
    case 'equipamento':
            $sqlCons->FullRead("SELECT patrimonio,serie FROM tb_sys004 WHERE patrimonio = :PAT or serie = :SERIE", "PAT="."{$texto->setTexto($patrimonio)}"."&SERIE="."{$texto->setTexto($serie)}"."");
            if($sqlCons->getRowCount() > 0):
               if($sqlCons->getResult()[0]['patrimonio'] === $patrimonio){
                    print "<span class=\"alert alert-warning\" role=\"alert\">Consta um registro para esse Patrimônio!</span>";
               }else if($sqlCons->getResult()[0]['serie'] === $serie){
                   print "<span class=\"alert alert-warning\" role=\"alert\">Número de serie já esta em uso!</span>";
                }else{
                    print "<span class=\"alert alert-warning\" role=\"alert\">Não faço idéia do porque esta aparecendo essa msg!</span>";
                }
            else:
                unset($post['acao']);
                $post['data_cad']= date('Y-m-d');
                $sqlCad->ExeCreate("tb_sys004",$post);
                if($sqlCad->getResult()):
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
            endif; 
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
    case 'secretaria':
         $sqlCons->FullRead("SELECT nome_secretaria,sigla FROM tb_sys011 WHERE nome_secretaria = :SEC or sigla = :SIGLA", "SEC="."{$texto->setTexto($nomeSecretaria)}"."&SIGLA="."{$texto->setTexto($siglaSecretaria)}"."");
        if($sqlCons->getRowCount() > 0):
            if($sqlCons->getResult()[0]['nome_secretaria'] === $nomeSecretaria):
                print "<span class=\"alert alert-warning\" role=\"alert\">o nome da secretaria já esta em uso!</span>";
            elseif($sqlCons->getResult()[0]['sigla'] === $siglaSecretaria):
               print "<span class=\"alert alert-warning\" role=\"alert\">a sigla informada já esta em uso</span>";
            else:
                print "<p>error!<br /> não faço idéia de como você veio parar aqui...</p>";
            endif;
        else:
            $sqlCad->ExeCreate("tb_sys011",["nome_secretaria"=>$texto->setTexto($nomeSecretaria),
                                            "sigla"=>$texto->setTexto($siglaSecretaria)
                                            ]);
            if($sqlCad->getResult()):
                print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
            else:
                print "<p>{$sqlCad->getError()}</p>";
            endif;
        endif;         
        break;
    case 'categoria':
            $sqlCons->FullRead("SELECT descricao FROM tb_sys003 WHERE descricao = :DESC", "DESC="."{$texto->setTexto($nomeCategoria)}"."");
            if($sqlCons->getRowCount() > 0):
               print "<span class=\"alert alert-warning\" role=\"alert\">categoria já existe!</span>";
            else:
                $sqlCad->ExeCreate("tb_sys003",["descricao"=>$texto->setTexto($nomeCategoria)]);
                if($sqlCad->getResult()):
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
            endif; 
        break;
    case 'status':
        $sqlCons->FullRead("SELECT descricao,cor FROM tb_sys002 WHERE descricao = :DESC or cor = :COR", "DESC="."{$texto->setTexto($nomeStatus)}"."&COR="."{$texto->setTexto($corStatus)}"."");
            if($sqlCons->getRowCount() > 0):
                if($sqlCons->getResult()[0]['descricao'] === $nomeStatus):
                 print "<span class=\"alert alert-warning\" role=\"alert\">Status já existe!</span>";
                elseif($sqlCons->getResult()[0]['cor'] === $corStatus):
                   print "<span class=\"alert alert-warning\" role=\"alert\">A cor escolhida já esta em uso por outro status</span>";
                else:
                    print "<p>error!<br /> não faço idéia de como você veio parar aqui...</p>";
                endif;
            else:
                $sqlCad->ExeCreate("tb_sys002",["descricao"=>$texto->setTexto($nomeStatus),"cor"=>$texto->setTexto($corStatus)]);
                if($sqlCad->getResult()):
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
            endif; 
        break;
    case 'empresa':
        $sqlCons->FullRead("SELECT cnpj FROM tb_sys012 WHERE cnpj = :CNPJ", "CNPJ="."{$texto->setTexto($txtCnpj)}"."");
            if($sqlCons->getRowCount() > 0):
               print "<span class=\"alert alert-warning\" role=\"alert\">CNPJ já Cadastrado!</span>";
            else:
                $sqlCad->ExeCreate("tb_sys012",["cnpj"        => $texto->setTexto($txtCnpj),
                                                "ie"          => $texto->setTexto($txtIe),
                                                "razaosocial" => $texto->setTexto($txtRazaoSocial),
                                                "fantasia"    => $texto->setTexto($txtFantasia),
                                                "estado"      => $texto->setTexto($txtEstado),
                                                "cidade"      => $texto->setTexto($txtCidade),
                                                "bairro"      => $texto->setTexto($txtBairro),
                                                "rua"         => $texto->setTexto($txtRuaEmpresa),
                                                "telefone"    => $texto->setTexto($txtContatoEmpresa),
                                                "email"       => $texto->setTexto($txtEmailEmpresa),
                                                "cep"         => $texto->setTexto($txtCep),
                                                "site"        => $texto->setTexto($txtSiteEmpresa)
                                               ]);
                if($sqlCad->getResult()):
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
            endif;        
        break;
    case 'motivo':
            $sqlCons->FullRead("SELECT motivo FROM tb_sys017 WHERE motivo = :MOTIVO", "MOTIVO="."{$texto->setTexto($motivoEntrada)}"."");
            if($sqlCons->getRowCount() > 0):
               print "<span class=\"alert alert-warning\" role=\"alert\">Motivo já Cadastrado!</span>";
            else:
                $sqlCad->ExeCreate("tb_sys017",["motivo"=>$texto->setTexto($motivoEntrada),"categoria"=>$texto->setTexto($categoriaMotivoEntrada)]);
                if($sqlCad->getResult()):
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
            endif;            
        break;
    case 'localidade':
        $sqlCons->FullRead("SELECT local,cr FROM tb_sys008 WHERE local = :LOCAL or cr = :CR", "LOCAL="."{$texto->setTexto($nomeLocalidade)}"."&CR={$crLocalidade}");
            if($sqlCons->getRowCount() > 0):
                if($sqlCons->getResult()[0]['local'] === $nomeLocalidade):
                    print "<span class=\"alert alert-warning\" role=\"alert\">Localidade já Cadastrada!</span>";
                elseif($sqlCons->getResult()[0]['cr'] === $crLocalidade):
                   print "<span class=\"alert alert-warning\" role=\"alert\">CR já Cadastrado!</span>";
                else:
                    print "<p>error!<br /> não faço idéia de como você veio parar aqui...</p>";
                endif;
            else:
                $sqlCad->ExeCreate("tb_sys008",["local"         => $texto->setTexto($nomeLocalidade),
                                                "rua"           => $texto->setTexto($txtEndereco),
                                                "cep"           => $texto->setTexto($txtCep),
                                                "bairro"        => $texto->setTexto($txtBairro),
                                                "regiao_id"     => $texto->setTexto($txtRegiao),
                                                "cr"            => $texto->setTexto($crLocalidade),
                                                "secretaria_id" => $texto->setTexto($secretaria)
                                               ]);
                if($sqlCad->getResult()):
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
            endif;            
        break;
    case 'modelo':
        unset($post['acao']);
        $post['modelo'] = $texto->setTexto($post['modelo']);
        $sqlCons->FullRead("SELECT modelo FROM tb_sys022 WHERE modelo = :MODELO", "MODELO="."{$post['modelo']}"."");
        if($sqlCons->getRowCount()==0):
            $sqlCad->ExeCreate("tb_sys022",$post);
                if($sqlCad->getResult()):
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!</span>";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
        else:
           print "<span class=\"alert alert-warning\" role=\"alert\">Modelo informado já possui cadastro!</span>";
        endif;
        break;
    case 'peca':
            unset($post['acao']);
            $post['dt_cadastro']=date('Y-m-d H:i:s');$post['tec_cad_nome']=$_SESSION['UserLogado']['nome'];$post['ip_cadastro'] = IP;$post['host_cadastro']=HOST;
            $post['descricao_peca']=$texto->setTexto($post['descricao_peca']);
            $sqlCons->FullRead("SELECT id_peca FROM tb_sys015 WHERE descricao_peca = :DESCP", "DESCP="."{$post['descricao_peca']}"."");
            if($sqlCons->getRowCount()== 0):
                $sqlCad->ExeCreate("tb_sys015",$post);
                if($sqlCad->getResult()):
                    $codigoPeca = $sqlCad->getResult();
                    $sqlCad->ExeCreate("tb_sys027", ["codigo_peca"=>$codigoPeca,"quantidade"=>0]);
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso! <b>Código: </b>{$codigoPeca}</span>";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
            else:    
                print "<span class=\"alert alert-warning\" role=\"alert\">peça informada já possui cadastro!</span>";
            endif;
        break;
    case 'fornecedor':
            unset($post['acao']);
            $post['nome_fornecedor']=$texto->setTexto($post['nome_fornecedor']);
            $sqlCons->FullRead("SELECT nome_fornecedor FROM tb_sys019 WHERE nome_fornecedor = :FORNE", "FORNE="."{$post['nome_fornecedor']}"."");
            if($sqlCons->getRowCount()== 0):
                $sqlCad->ExeCreate("tb_sys019",$post);
                if($sqlCad->getResult()):
                    print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado com sucesso!";
                else:
                    print "<p>{$sqlCad->getError()}</p>";
                endif;
            else:    
                print "<span class=\"alert alert-warning\" role=\"alert\">Fornecedor já possui cadastro!</span>";
            endif;
        break;
    case 'recebepeca':
        $data   = new Datas();
        $atu    = new Update();
        if(isset($post['qtde'])):
            $post['quantidade'] =$post['qtde'];
        endif;
        $post['preco_peca']     = str_replace(",",".",$post['preco_peca']);
        $post['dt_recebimento'] = $data->setDt($post['dt_recebimento']);
        $post['peca_serie']     = $texto->setTexto($post['peca_serie']);
        $post['observacao']     = $texto->setTexto($post['observacao']);
        $post['responsavel']    = $_SESSION['UserLogado']['nome'];
        $sqlCons->FullRead("SELECT quantidade FROM tb_sys027 WHERE codigo_peca = :CP", "CP={$post['peca_id']}");
        $quantidade = ((int)$sqlCons->getResult()[0]['quantidade'] + $post['quantidade']);
        $sqlCons->FullRead("SELECT peca_serie FROM tb_sys020 WHERE peca_serie = :PECASERIE", "PECASERIE={$post['peca_serie']}");  
        unset($post['acao']);
        unset($post['qtde']);
        if($sqlCons->getRowCount() == 0):
            $sqlCad->ExeCreate("tb_sys020", $post);
            if($sqlCad->getResult()):
                $atu->ExeUpdate("tb_sys027", ["quantidade"=>$quantidade], "WHERE codigo_peca = :CODIGOPECA", "CODIGOPECA={$post['peca_id']}");
                print "<span class=\"alert alert-success\" role=\"alert\">Recebimento Realizado com sucesso!";
            else:
                print "<p>{$sqlCad->getError()}</p>";
            endif;
        else:
            print "Sua entrada nao pode ser feita porque consta um registro com número de série informado! por favor verifique!";
        endif;
        break;
    case 'memoria':
        unset($post['acao']);
        $sqlCons->ExeRead("tb_sys029 WHERE tipo_memoria = '{$tipo_memoria}'AND capacidade = '{$capacidade}'");
        if($sqlCons->getRowCount()== 0):
            $sqlCad->ExeCreate("tb_sys029", $post);
            if($sqlCad->getResult()):
                print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado!";
            else:
                print "<p>{$sqlCad->getError()}</p>";
            endif;
        else:
            print "<span class=\"alert alert-info\">tipo de memoria e capacidade já cadastrado</span>";
        endif;
        break;
    case 'processador':
        unset($post['acao']);
        $sqlCons->ExeRead("tb_sys028 WHERE processador = '{$processador}'AND geracao = '{$geracao}'");
        if($sqlCons->getRowCount()== 0):
            $sqlCad->ExeCreate("tb_sys028", $post);
            if($sqlCad->getResult()):
                print "<span class=\"alert alert-success\" role=\"alert\">Cadastro Realizado!";
            else:
                print "<p>{$sqlCad->getError()}</p>";
            endif;
        else:
            print "<span class=\"alert alert-info\">tipo de processador e geração já cadastrado</span>";
        endif;
        break;
    default :
          print "<span class=\"alert alert-warning\" role=\"alert\">Erro ao cadastrar! ação nao encontrada!,
                Contate o desenvolvedor do sistema 
                e que deus o ajude... </span>";
endswitch;