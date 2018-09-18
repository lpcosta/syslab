<?php
session_start();
require_once '../config/config.inc.php';
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
                <img src ='../imagens/logos/logo-sistema.png' alt="Logo do Sistema" title="Logo do Sistema" onclick="location.href='http://localhost/syslab/'" />
            </div>
            <div id="div-nome-sistema">
                <p>syslab</p>
            </div>
            <div id="div-user-logado">
                <?php if(isset($_SESSION['UserLogado'])):?>
                <img src="app/imagens/icons/avatar.png" alt="Avatar" />
                <p>tbpdomingos</p>
                <p><a href="index.php?ref=logoff">sair</a></p>
                <? endif;?>
            </div>
            
        </header>
        <main>
            
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