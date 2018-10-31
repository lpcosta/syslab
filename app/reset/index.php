<?php
require_once '../config/config.inc.php';


$senha = new Senha();

$sql = new Read();

$atu = new Update();

$post = false;

if(isset($_POST['btnAltera'])):
   unset($_POST['btnAltera']);
 extract(filter_input_array(INPUT_POST, FILTER_DEFAULT));

 $pass1 = strip_tags(trim($txtPassword1));
 $pass2 = strip_tags(trim($txtPassword2));
 
    if($pass1 === $pass2):
        if(empty($pass1) || empty($pass2) ):
            $msg = "Voce precisa informar uma Senha";
        else:
            if(isset($login) && !empty($login)):
                $atu->ExeUpdate("tb_sys001", ["hash"=>'',
                                          "senha"=>$senha->setSenha($pass1),
                                          "senha_padrao"=>'nao',
                                          "tentativa_login"=>0,
                                          "situacao"=>'l'
                                          ], "WHERE login = :LOGIN", "LOGIN={$login}");
                if($atu->getResult()):
                    $msg = "Senha Alterada!<br />"
                    . "<a href=\"http://syslab.lpcosta.com.br/\">Clique para Logar</a>";          
                else:
                    $msg = "Erro ".$atu->getResult();
                endif;
            else:
                $msg= "<h2 class='text-center text-primary'>Token Inválido!</h2><br />";
            endif;
            endif;
    else:
        $msg = "Senhas Não Conferem!";
    endif;
endif;
?>
<!DOCTYPE html> 
<html lang="pt-br">   
    <head>
        <meta charset="utf-8">     
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <title>SysLab</title>         
        <link rel="shortcut icon" href="../css/images/icons/syslab-logo.PNG" type="image/x-icon">
        <link rel="stylesheet" href="../libs/BootStrap-4.0/css/bootstrap.css" />
        <link rel="stylesheet" href="../libs/JQuery-ui-1.12.1/jquery-ui.css" />
        <link rel="stylesheet" href="../css/estilo.css" />
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5
        elements and media queries -->     <!-- WARNING: Respond.js doesn't work if you
        view the page via file:// -->     <!--[if lt IE 9]>       <script
        src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
       <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
        
    </head>

    <body>
        <header>
            <div id="div-logo">
                <img src ='../imagens/logos/logo-sistema.png' alt="Logo do Sistema" title="Logo do Sistema" onclick="location.href='https://syslab.lpcosta.com.br/'" />
            </div>
            <div id="div-nome-sistema">
                <p>syslab</p>
            </div>
            <div id="div-user-logado">
                <?php if(isset($_SESSION['UserLogado'])):?>
                <img src="app/imagens/icons/avatar.png" alt="Avatar" />
                <p><?=''?></p>
                <p><a href="index.php?ref=logoff">sair</a></p>
                <? endif;?>
            </div>
            
        </header>
        <main>
            <?php
                $get = filter_input_array(INPUT_GET,FILTER_DEFAULT);
                $setGet = array_map("strip_tags", $get);
                $getHash   = array_map("trim", $setGet);
                extract($getHash);
                $hashCompara = md5(sha1(date('d-m-Y')));
            if(!isset($login)):
                $login='';
            endif;
            $sql->FullRead("SELECT nome,login FROM tb_sys001 WHERE hash = :HASH AND login = :LOGIN", "HASH={$hash}&LOGIN="."{$login}"."");
            
            if($sql->getRowCount() > 0):?>
                    <div id="login">
                        <div class="boxin">
                            <h1>Altere sua Senha</h1>
                            <form action="" method="post" form-control>
                                <input type="hidden" name="login" value="<?=$login?>" />
                                <label>Nova Senha:</label>
                                <input type="password" name="txtPassword1" class="form-control" />
                                <label>Confirme a Senha</label>
                                <input type="password" name="txtPassword2" class="form-control" />
                                <?php if(isset($msg)):?>
                               <br />
                               <div class="alert alert-info msg">
                                    <?=$msg;?>
                               </div>
                                <?php endif;?>
                                 <hr />
                                <input type="submit" name="btnAltera" value="Alterar" style="width: 100%;" />
                            </form>
                        </div>
                    </div>                           
                 <?php
                else:?>
                    <div id="login">
                        <div class="boxin">
                            <h1 class="alert alert-info text-uppercase">token inválido</h1>
                             <a href="<?=HOME?>">VOLTAR</a>
                        </div>
                       
                    </div>
               <? endif;?>
            
        </main>
    </body>
    
    <footer>
        <div>
            <p>syslab 6.0 - &copy; by Leandro Pereira</p>
        </div>
    </footer>
    <script src="../libs/JQuery/jquery-3.3.1.min.js" /></script>
    <script src="../libs/JQuery-ui-1.12.1/jquery-ui.js" /></script>
    <script src="../js/gobal.js" /></script>
    <script src="../libs/BootStrap-4.0/js/bootstrap.js" /></script>
</html>