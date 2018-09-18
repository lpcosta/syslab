<?php
function __autoload($class){require_once"../../classes/{$class}.class.php";}

// DEFINE SERVIDOR DE E-MAIL ################
define('MAILUSER', 'syslab@lpcosta.com.br');
define('MAILPASS', '@syslab@');
define('MAILPORT', '465');
define('MAILHOST', 'br24.hostgator.com.br');

