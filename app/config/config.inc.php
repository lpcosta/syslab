<?php 
// TRATAMENTO DE ERROS #####################
//CSS constantes :: Mensagens de Erro
define('WS_ACCEPT', 'accept');
define('WS_INFOR', 'infor');
define('WS_ALERT', 'alert');
define('WS_ERROR', 'error');
define('HOJE',date('d/m/Y'));

// DEFINE IDENTIDADE DO SITE ################
define('SITENAME', 'Syslab');
define('SITEDESC', 'Sistema responsavel pelo controle de equipamentos em Laboratorio da prefeitura de santo andre - sp');

// DEFINE A BASE DO SITE ####################
define('HOME', 'https://localhost/syslab');
//define('THEME', 'cidadeonline');
define('IP',$_SERVER['REMOTE_ADDR']);
define('HOST',gethostbyaddr(IP));

//define('INCLUDE_PATH', HOME . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . THEME);
//define('REQUIRE_PATH', 'themes' . DIRECTORY_SEPARATOR . THEME);
define('REQUIRE_PATH', HOME . DIRECTORY_SEPARATOR .'app' . DIRECTORY_SEPARATOR .'sistema');

// AUTO LOAD DE CLASSES ####################
spl_autoload_register(function($class){
    if (file_exists("./app/classes/".$class.".class.php")):
        require_once("./app/classes/".$class.".class.php");
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
