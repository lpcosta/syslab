<?php
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    header('HTTP/1.1 301 Moved Permanently');
    header("Location: $redirect_url");
    exit();
}
ob_start();
session_start();
require_once './app/composer/vendor/autoload.php';
require_once './app/config/config.inc.php';
require_once './app/funcoes/func.inc.php';

?>

<!DOCTYPE html> 
<html lang="pt-br">   
    <head>
        <meta charset="utf-8">     
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <title>SysLab</title>         
        <link rel="shortcut icon" href="./app/imagens/icons/syslab-logo.PNG" type="image/x-icon">
        <link rel="stylesheet" href="./app/libs/BootStrap-4.0/css/bootstrap.css" />
        <link rel="stylesheet" href="./app/libs/JQuery-ui-1.12.1/jquery-ui.css" />
        <link rel="stylesheet" href="./app/css/estilo.css" />
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5
        elements and media queries -->     <!-- WARNING: Respond.js doesn't work if you
        view the page via file:// -->     <!--[if lt IE 9]>       <script
        src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
       <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    </head>

    <body>
        <header>
            <div id="div-logo">
                <img src ='./app/imagens/logos/logo-sistema.png' alt="Logo do Sistema" title="Logo do Sistema" onclick="location.href='http://localhost/syslab/'" />
            </div>
            <div id="div-nome-sistema">
                <p>syslab</p>
            </div>
            <div id="div-user-logado">
                <?php if(isset($_SESSION['UserLogado'])):?>
                <img src="app/imagens/icons/avatar.png" alt="Avatar" title="<?= ucfirst($_SESSION['UserLogado']['nome'])?>" />
                <p title="<?= ucfirst($_SESSION['UserLogado']['nome'])?>"><?=$_SESSION['UserLogado']['login']; ?></p>
                <p><a href="index.php?ref=logoff">sair</a></p>
                <? endif;?>
            </div>
            <?php if(isset($_SESSION['UserLogado'])):?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="<?=HOME?>">Menu</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="<?=HOME?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown"><!-- Inicio Menu Cadasto -->
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cadastro
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="index.php?ref=cadastra/equipamento">Equipamento</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/secretaria">Secretaria</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/fabricante">Fabricante</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/localidade">Localidade</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/categoria">Categoria</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/empresa">Empresa</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/usuario">Usuário</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/cidade">Cidade</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/status">Status</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/motivo_entrada">Motivo Entrada</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/modelo_equipamento">Modelo de Equipamento</a>
                        <a class="dropdown-item" href="index.php?ref=cadastra/baixa_equipamento">Baixa de Equipamento</a>
                        <!--
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                        -->
                      </div>
                    </li><!--Fim do menu Cadastro -->
                    
                    <li class="nav-item dropdown"><!-- Inicio Menu Laboratório -->
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Laboratório
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Bancada</a>
                        <a class="dropdown-item" href="#">Entrada</a>
                        <a class="dropdown-item" href="#">Saida</a>
                        <a class="dropdown-item" href="#">Entregas</a>
                      </div>
                    </li><!--Fim do menu Laboratório -->
                    
                    <li class="nav-item dropdown"><!-- Inicio Menu Estoque -->
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Estoque
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Entrada de Peça</a>
                        <a class="dropdown-item" href="#">Cadastrar Peça</a>
                        <a class="dropdown-item" href="#">Baixar Peça</a>
                        <a class="dropdown-item" href="#">Consultar</a>
                      </div>
                    </li><!--Fim do menu Estoque -->
                    
                    <li class="nav-item dropdown"><!-- Inicio Menu Administração -->
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administração
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Redefinir Usuário</a>
                        <a class="dropdown-item" href="#">Trocar Senha</a>
                        <a class="dropdown-item" href="#">Logs</a>
                        <a class="dropdown-item" href="#">Backup</a>
                      </div>
                    </li><!--Fim do menu Administração -->
                    <li class="nav-item dropdown"><!--Inicio do menu Relatorios -->
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Relatório
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Aguardando Peça</a>
                        <a class="dropdown-item" href="#">Equipamento</a>
                        <a class="dropdown-item" href="#">Bancada</a>
                        <a class="dropdown-item" href="#">Estoque</a>
                        <a class="dropdown-item" href="#">Status</a>
                        <a class="dropdown-item" href="#">Entrada</a>
                        <a class="dropdown-item" href="#">Saída</a>
                      </div>
                    </li><!--Fim do menu Relatorios -->
                    <li class="nav-item dropdown"><!--Inicio do menu Consultar -->
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Consultar
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Ordem de Serviço</a>
                        <a class="dropdown-item" href="#">Patrimonio</a>
                        <a class="dropdown-item" href="#">Localidade</a>
                        <a class="dropdown-item" href="#">Usuario</a>
                      </div>
                    </li><!--Fim do menu Consultar -->
                  </ul>
                </div>
            </nav>
            <? endif;?>
        </header>
        <main>
            <?php
            if (isset($_GET['ref']) && !empty($_GET['ref'])):
                $includepatch = "./app/sistema/" . strip_tags(trim($_GET['ref']) . '.php');
            else:
                $includepatch = "./app/sistema/home.php";
            endif;
            
            if(!isset($_SESSION['UserLogado'])):
                require_once './app/sistema/login.php';
            
            elseif(isset($_SESSION['UserLogado'])&& file_exists($includepatch)):
                
                    require_once("{$includepatch}");
            elseif(isset($_SESSION['UserLogado']) && !isset($_GET['ref'])):
                   require_once("{$includepatch}");
            else:
                echo "<div class=\"alert alert-warning \" role=\"alert\">";
                print "Erro ao incluir tela {$_GET['ref']}.php!";
                echo "</div>";
            endif;
            ?>
        </main>
    </body>
    
    <footer>
        <div>
            <p>syslab 6.0 - &copy; by Leandro Pereira</p>
        </div>
    </footer>
    <script src="./app/libs/JQuery/jquery-3.3.1.min.js" /></script>
    <script src="./app/libs/JQuery-ui-1.12.1/jquery-ui.js" /></script>
    <script src="./app/js/gobal.js" /></script>
    <script src="./app/libs/BootStrap-4.0/js/bootstrap.js" /></script>
   
   
</html>
<?php ob_end_flush();