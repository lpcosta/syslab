<?php
//tratamento de url amigavel.... não mexer aqui.....
define('R_QUERY_STRING',isset($_SERVER['REDIRECT_QUERY_STRING'])?$_SERVER['REDIRECT_QUERY_STRING']:NULL);
define('R_URL',  isset($_SERVER['REDIRECT_URL'])?$_SERVER['REDIRECT_URL']:NULL);
$paramget = explode('?', $_SERVER['REQUEST_URI']);
if(isset($paramget[1]))
    define('R_URI',$paramget[1]);
else
    define('R_URI',NULL);
            

//DEFINIÇÃO DECONSTANTES DO SISTEMA
define('LOGO','/img/logos/');
if(isset($_SESSION['logado']))
{
    define ('ID_TECNICO',  intval($_SESSION['logado']['id']));//ID DO TÉCNICO LOGADO
    define ('EMPRESA', intval($_SESSION['logado']['id_empresa']));//ID DA EMPRESA DO TECNICO LOGADO
    define ('NIVEL', intval ($_SESSION['logado']['nivel']));//DEFINE O NIVEL DE ACESSO AO RECURSOS DO SISTEMA
    define ('GRUPO', intval($_SESSION['logado']['grupo_id']));//GRUPO DE ACESSO A RECURSOS

}
define('LOGO_PSA'   ,'/require/img/projeto/logo_psa.bmp');
define('LOGO_LORAC' ,'/require/img/projeto/logo_lorac.png');
define('LOGO_SYSLAB','/require/img/projeto/syslab_logo.PNG');
define('PREFEITURA' ,'prefeitura de santo andré');
define('SECRETARIA' ,'sia - secretaria de inovação e modernização');
define('DIRETORIA'  ,'dti - departamente de tecnologia e inovação');
define('GERENCIA'   ,'gsti - gerência de suporte técnico em informática');



//FIM DAS DEFINIÇÕES DE CONSTANTES DO SISTEMA

