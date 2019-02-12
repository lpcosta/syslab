<?php
ob_start();
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header("Location: $redirect_url");
    exit();
}
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
        <title>.:SysLab:.</title>         
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
                <p><a href="index.php?pg=logoff">sair</a></p>
                <? endif;?>
            </div>
            <?php if(isset($_SESSION['UserLogado'])):?>
            <nav class="navbar nav-menu">
                <ul class="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Laboratório</a>
                        <ul class="submenu-1">
                            <li><a href="index.php?pg=bancada">Bancada</a></li>
                            <li><a href="index.php?pg=laboratorio">Laboratório</a></li>
                            <li><a href="index.php?pg=laboratorio/entrada">Entrada</a></li>
                            <li><a href="index.php?pg=laboratorio/saida">Saída</a></li>
                        </ul>
                    </li>
                    <?if(GRUPO == 4):?>
                    <li><a href="#">Estoque</a>
                        <ul class="submenu-1">
                            <li><a href="#">Peça</a>
                                <ul class="submenu-2">
                                    <li><a href="index.php?pg=estoque/recebimento">Receber</a></li>
                                    <li><a href="index.php?pg=estoque/baixa">Baixar</a></li>
                                    <li><a href="index.php?pg=cadastra/peca">Cadastrar</a></li>
                                    <li><a href="index.php?pg=edita/peca">Editar</a></li>
                                </ul>
                            </li>
                            <li><a href="index.php?pg=estoque/estoque">Estoque Lorac</a></li>
                            <li><a href="#">Relatórios</a>
                                <ul class="submenu-2">
                                    <li><a href="index.php?pg=estoque/relatorio/entrada">Entrada</a></li>
                                    <li><a href="index.php?pg=estoque/relatorio/saida">Saida</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?endif;?>
                    <li><a href="#">Relatorios</a>
                        <ul class="submenu-1">
                            <li><a href="index.php?pg=relatorio/saida">Saídas</a></li>
                            <li><a href="index.php?pg=relatorio/entrada">Entradas</a></li>
                            <li><a href="index.php?pg=relatorio/aguardo-de-peca">Aguardo de Peça</a></li>
                            <li><a href="index.php?pg=relatorio/bancada">Bancada</a></li>
                            <li><a href="index.php?pg=relatorio/equipamento">Equipamento</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Administração</a>
                        <ul class="submenu-1">
                            <li><a href="#">Cadastrar</a>
                                <ul class="submenu-2">
                                    <li><a href="index.php?pg=cadastra/equipamento">Equipamento</a></li>
                                    <li><a href="index.php?pg=cadastra/localidade">Localidade</a></li>
                                <?if(GRUPO >= 3):?>    
                                    <li><a href="index.php?pg=cadastra/secretaria">Secretaria</a></li>
                                    <li><a href="index.php?pg=cadastra/empresa">Empresa</a></li>
                                <? endif;if(GRUPO == 4):?>    
                                    <li><a href="index.php?pg=cadastra/categoria">Categoria</a></li>
                                    <li><a href="index.php?pg=cadastra/usuario">Usuario</a></li>  
                                <?endif;if(GRUPO >= 3):?>
                                    <li><a href="#">Tabelas de Apoio</a>
                                        <ul class="submenu-3">
                                            <li><a href="index.php?pg=cadastra/memoria">Memória Ram</a></li>
                                            <li><a href="index.php?pg=cadastra/processador">Processador</a></li>
                                            <?if(GRUPO == 4):?>
                                            <li><a href="index.php?pg=cadastra/fornecedor">Fornecedor</a></li>
                                            <li><a href="index.php?pg=cadastra/motivo-entrada">Motivo de Entrada</a></li>
                                            <li><a href="index.php?pg=cadastra/status">Status</a></li>  
                                            <li><a href="index.php?pg=cadastra/software">Windows/Office</a></li>
                                            <li><a href="index.php?pg=cadastra/modelo-equipamento">Modelo Equipamento</a></li>
                                            <?endif;?>
                                        </ul>
                                         <?endif;?>
                                    </li>  
                                </ul>
                            </li>
                            <li><a href="#">Gerenciar</a>
                                <ul class="submenu-2">
                                    <li><a href="index.php?pg=gerenciar/equipamento">Equipamento</a></li>
                                    <li><a href="index.php?pg=gerenciar/windows-office">Windows/Office</a></li>
                                    <li><a href="index.php?pg=gerenciar/localidade">Localidade</a></li>
                                    <li><a href="index.php?pg=gerenciar/entrada">Entrada</a></li>
                                    <?if(GRUPO == 4):?>
                                    <li><a href="index.php?pg=gerenciar/usuarios">Usuario</a></li>
                                    <li><a href="index.php?pg=edita/atualiza-banco">Atualizar Banco</a></li>
                                    <?endif;?>
                                </ul>
                            </li>
                            <li><a href="#">Documentar</a>
                                <ul class="submenu-2">
                                    <li><a href="#">Switch</a></li>
                                    <li><a href="#">Router</a></li>
                                </ul>
                            </li>
                            <li><a href="index.php?pg=reset-senha">Alterar Senha</a></li>
                            <li><a href="#">Backup</a></li>
                            <li><a href="index.php?pg=logs">Logs</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Consultar</a>
                        <ul class="submenu-1">
                            <li><a href="index.php?pg=consulta/localidade">Localidade</a></li>
                            <li><a href="#">Equipamento</a></li>
                        </ul>
                    </li>
                </ul> 
                
                <form name="formSearchOs" id="formSearchOs" onsubmit="return false;" style="max-width: 300px !important;">
                     <input type="hidden" name="acao" value="os" />
                    <label for="txtBusca">OS:</label>
                    <input type="search" size="7" placeholder="Pesquisar..." name="busca" maxlength="7" id="txtBuscaOs" required="">
                    <button type="submit" name="btnSearch" id="btnSearch">Buscar</button>
                </form>
                
                <form name="formSearch" id="formSearch" class="text-right" onsubmit="return false;" style="max-width: 300px !important;">
                    <input type="hidden" name="acao" value="patrimonio" />
                    <input type="search" onkeydown="autoCompletar(this,'patrimonio','pesquisaPatrimonioId')" size="7" placeholder="sn,pat..." name="busca" id="txtBusca" required="">
                    <!--<button type="submit" name="btnSearch" id="btnSearch">Buscar</button>-->
                    <img src="app/imagens/icons/img-search.PNG" alt="search..." title="pesquisar" onclick="$('#formSearch').submit();"/>
                </form>
            </nav>
            <? endif;?>
        </header>
        <main>

            <?php
            if (isset($_GET['pg']) && !empty($_GET['pg'])):
                $includepatch = "./app/sistema/" . strip_tags(trim($_GET['pg']) . '.php');
            else:
                $includepatch = "./app/sistema/home.php";
            endif;
            
            if(!isset($_SESSION['UserLogado'])):
                require_once './app/sistema/login.php';
            
            elseif(isset($_SESSION['UserLogado'])&& file_exists($includepatch)):
                
                    require_once("{$includepatch}");
            elseif(isset($_SESSION['UserLogado']) && !isset($_GET['pg'])):
                   require_once("{$includepatch}");
            else:
                echo "<div class=\"alert alert-warning text-center \" role=\"alert\">";
                print "Erro ao incluir tela";
                echo "</div>";
                include_once './app/sistema/404.php';
            endif;
            ?>
        </main>
        <div id="modal-busca-patrimonio" title="PESQUISA DE PATRIMONIO" style="display: none; z-index: 5000;"></div>
        <div id="dialog" title="AVISO"></div>
        <div id="modal"></div>
    </body>
    
    <footer>
        <div>
            <p>syslab 6.0 - &copy; by Leandro Pereira</p>
        </div>
    </footer>
    <script src="./app/libs/JQuery/jquery-3.3.1.min.js" /></script>
<!--<script src="./app/libs/BootStrap-4.0/js/bootstrap.js" /></script>-->
    <script src="./app/libs/JQuery-ui-1.12.1/jquery-ui.js" /></script>
    <script src="./app/libs/JQuery-Masked-Input/src/jquery.maskedinput.js" /></script>
    <script src="./app/libs/JQuery-Validate/jquery.validate.js"></script>
    <script src="./app/libs/JQuery-Validate/additional-methods.js"></script>
    <script src="./app/libs/JQuery-Validate/localization/messages_pt_BR.js" /></script>
    <script src="./app/libs/PrintArea/demo/jquery.PrintArea.js"></script>
    <script src="./app/js/gobal.js" /></script>
    
</html>
<?php 
$html = ob_get_clean ();
echo preg_replace('/\s+/', ' ', $html);

#ob_end_flush();