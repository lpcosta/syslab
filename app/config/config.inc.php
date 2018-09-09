<?php 
// DEFINE IDENTIDADE DO SITE ################
define('SITENAME', 'Syslab');
define('SITEDESC', 'Sistema responsavel pelo controle de equipamentos em Laboratorio da prefeitura de santo andre - sp');

// DEFINE A BASE DO SITE ####################
define('HOME', 'http://localhost/syslab');
//define('THEME', 'cidadeonline');

//define('INCLUDE_PATH', HOME . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . THEME);
//define('REQUIRE_PATH', 'themes' . DIRECTORY_SEPARATOR . THEME);
define('REQUIRE_PATH', HOME . DIRECTORY_SEPARATOR .'app' . DIRECTORY_SEPARATOR .'sistema');



// AUTO LOAD DE CLASSES ####################
spl_autoload_register(function($class){
       	$classe = "./app".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR.$class.".class.php";
	if (file_exists(($classe))):
		require_once($classe);
        else:
            echo "<div class=\"alert alert-warning \" role=\"alert\">";
            print "Não foi possível incluir {$Class}.class.php!";
            echo "</div>";
            die;
        endif;
});
