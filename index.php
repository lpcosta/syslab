<?php
ob_start();
/*if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header("Location: $redirect_url");
    exit();
}
*/
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
        <title>.:SysLab - homolog :.</title>         
        <link rel="shortcut icon" href="./app/imagens/icons/syslab-logo.PNG" type="image/x-icon">
        <link rel="stylesheet" href="./app/libs/BootStrap-4.0/css/bootstrap.css" />
        <link rel="stylesheet" href="./app/libs/JQuery-ui-1.12.1/jquery-ui.css" />
        <link rel="stylesheet" href="./app/libs/JQuery-ui-1.12.1/jquery-ui.theme.css" />
        <link rel="stylesheet" href="./app/libs/JQuery-ui-1.12.1/jquery-ui.structure.css" />
        <link rel="stylesheet" href="./app/css/menu.css" />
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
            <nav class="navbar nav-menu">
                <ul class="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Laboratório</a>
                        <ul class="submenu-1">
                            <li><a href="#" onclick="$('#searchos').slideDown(500);$('#txtBuscaOs').focus();">Consulta por OS</a></li>
                            <li><a href="index.php?ref=laboratorio">Laboratório</a></li>
                            <li><a href="#">Entrada</a></li>
                            <li><a href="#">Saída</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Relatorios</a>
                        <ul class="submenu-1">
                            <li><a href="#">Relatorio001</a></li>
                            <li><a href="#">Relatorio002</a></li>
                            <li><a href="#">Relatorio003</a></li>
                            <li><a href="#">Relatorio004</a></li>
                            <li><a href="#">Relatorio005</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Administração</a>
                        <ul class="submenu-1">
                            <li><a href="#">Cadastrar</a>
                                <ul class="submenu-2">
                                    <li><a href="index.php?ref=cadastra/categoria">Categoria</a></li>
                                    <li><a href="index.php?ref=cadastra/equipamento">Equipamento</a></li>
                                    <li><a href="index.php?ref=cadastra/empresa">Empresa</a></li>
                                    <li><a href="index.php?ref=cadastra/localidade">Localidade</a></li>
                                    <li><a href="index.php?ref=cadastra/motivo-entrada">Motivo de Entrada</a></li>
                                    <li><a href="index.php?ref=cadastra/secretaria">Secretaria</a></li>
                                    <li><a href="index.php?ref=cadastra/status">Status</a></li>
                                    <li><a href="index.php?ref=cadastra/usuario">Usuario</a></li>                                    
                                    <li><a href="index.php?ref=cadastra/software">Windows/Office</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Gerenciar</a>
                                <ul class="submenu-2">
                                    <li><a href="#">Equipamento</a>
                                        <ul class="submenu-3">
                                            <li><a href="#">Cadastrar Modelo</a></li>
                                            <li><a href="#">Editar</a></li>
                                            <li><a href="#">Excluir</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Windows/Office</a>
                                        <ul class="submenu-3">
                                            <li><a href="#">Editar Windows</a></li>
                                            <li><a href="#">Excluir Windows</a></li>
                                            <li><a href="#">Editar Office</a></li>
                                            <li><a href="#">Excluir Office</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Localidade</a>
                                        <ul class="submenu-3">
                                            <li><a href="#">Editar</a></li>
                                            <li><a href="#">Excluir</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Usuario</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Alterar Senha</a></li>
                            <li><a href="#">Backup</a></li>
                            <li><a href="#">Logs</a></li>
                            <li><a href="#">Tabelas de Apoio</a></li>
                        </ul>
                    </li>
                </ul> 
                <form name="formSearch" id="formSearch" class="text-right" onsubmit="return false;">
                    <input type="hidden" name="acao" value="patrimonio" />
                    <label for="txtBusca">Pesquisar:</label>
                    <input type="search" size="7" placeholder="patrimonio.." name="busca" maxlength="7" id="txtBusca" required="" autofocus="">
                    <button type="submit" name="btnSearch" id="btnSearch">Buscar</button>
                </form>
            </nav>
            <? endif;?>
        </header>
        <nav class="navbar" id="searchos">
                <a></a>
                <form name="formSearchOs" id="formSearchOs" onsubmit="return false;">
                     <input type="hidden" name="acao" value="os" />
                    <label for="txtBusca">Pesquisar:</label>
                    <input type="search" size="7" placeholder="os..." name="busca" maxlength="7" id="txtBuscaOs" required="" autofocus="">
                    <button type="submit" name="btnSearch" id="btnSearch">Buscar</button>
                </form>
            </nav>
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
        <div id="modal-busca-patrimonio" title="PESQUISA DE PATRIMONIO" style="display: none; z-index: 5000;"></div>
        <div id="dialog" title="AVISO"></div>
    </body>
    
    <footer>
        <div>
            <p>syslab 6.0 - &copy; by Leandro Pereira</p>
        </div>
    </footer>
    <script src="./app/libs/JQuery/jquery-3.3.1.min.js" /></script>
    <script src="./app/libs/BootStrap-4.0/js/bootstrap.js" /></script>
    <script src="./app/libs/JQuery-ui-1.12.1/jquery-ui.js" /></script>
    <script src="./app/libs/JQuery-Masked-Input/src/jquery.maskedinput.js" /></script>
    <script src="./app/libs/JQuery-Validate/jquery.validate.js"></script>
    <script src="./app/libs/JQuery-Validate/additional-methods.js"></script>
    <script src="./app/libs/JQuery-Validate/localization/messages_pt_BR.js" /></script>
    <script src="./app/js/gobal.js" /></script>
    
</html>
<?php 
$html = ob_get_clean ();
echo preg_replace('/\s+/', ' ', $html);

#ob_end_flush();