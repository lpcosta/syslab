<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';

$getPost = filter_input_array(INPUT_POST,FILTER_DEFAULT);
$setPost = array_map("strip_tags", $getPost);
$post   = array_map("trim", $setPost);


$post['ip']= $_SERVER['REMOTE_ADDR'];
$post['host']=gethostbyaddr($post['ip']);

$lgn = new Login();

$lgn->ExeLogin($post);

echo $lgn->getResult();


