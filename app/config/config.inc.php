<?php 
// TRATAMENTO DE ERROS #####################
//CSS constantes :: Mensagens de Erro
define('WS_ACCEPT', 'accept');
define('WS_INFOR', 'infor');
define('WS_ALERT', 'alert');
define('WS_ERROR', 'error');
define('HOJE',date('d/m/Y'));

// DEFINE IDENTIDADE DO SITE ################
define('SITENAME', 'https://localhost/syslab');
define('SITEDESC', 'Sistema responsavel pelo controle de equipamentos em Laboratorio da prefeitura de santo andre - sp');

// DEFINE A BASE DO SITE ####################
define('HOME', 'https://syslab.lpcosta.com.br/');
//define('THEME', 'cidadeonline');
define('IP',$_SERVER['REMOTE_ADDR']);
define('HOST',gethostbyaddr(IP));

//define('INCLUDE_PATH', HOME . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . THEME);
//define('REQUIRE_PATH', 'themes' . DIRECTORY_SEPARATOR . THEME);
define('REQUIRE_PATH', HOME . DIRECTORY_SEPARATOR .'app' . DIRECTORY_SEPARATOR .'sistema');
if(isset($_SESSION['UserLogado'])):

    define ('ID_TECNICO',  intval($_SESSION['UserLogado']['id']));//ID DO TÉCNICO LOGADO
    define ('GRUPO', intval($_SESSION['UserLogado']['grupo_id']));//GRUPO DE ACESSO A RECURSOS
    define ('LOGIN',$_SESSION['UserLogado']['login']);
else:
    define("GRUPO", 0);
    define("ID_TECNICO", 0);
    define("LOGIN",NULL);
endif;
// AUTO LOAD DE CLASSES ####################
spl_autoload_register(function($class){
    if (file_exists("./app/classes/".$class.".class.php")):
        require_once("./app/classes/".$class.".class.php");
    elseif(file_exists("../app/classes/".$class.".class.php")):
        require_once("../app/classes/".$class.".class.php");
    elseif(file_exists("../classes/".$class.".class.php")):
         require_once("../classes/".$class.".class.php");
    elseif(file_exists("../../classes/".$class.".class.php")):
        require_once("../../classes/".$class.".class.php");
    else:
        echo "<div class=\"alert alert-warning\" role=\"alert\">"
            ."Não foi possível incluir $Class.class.php!"
            ."</div>";
        die;
    endif;
});

/*DEFINICOES DO CLIENTE*/
define('LOGO_PSA'   ,'./app/imagens/logos/logo_psa.bmp');
define('LOGO_LORAC' ,'./app/imagens/logos/logo_lorac.png');
define('LOGO_SYSLAB','./app/imagens/logos/syslab_logo.PNG');
define('PREFEITURA' ,'prefeitura de santo andré');
define('SECRETARIA' ,'sia - secretaria de inovação e modernização');
define('DIRETORIA'  ,'dti - departamente de tecnologia e inovação');
define('GERENCIA'   ,'gsti - gerência de suporte técnico em informática');