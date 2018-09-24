<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$post['ip']= $_SERVER['REMOTE_ADDR'];
$post['host']=gethostbyaddr($post['ip']);

$lgn = new Login();

$lgn->ExeLogin($post);

echo $lgn->getResult();


