<?php
require_once '../../config/autoload.inc.php';

$getPost = filter_input_array(INPUT_POST,FILTER_DEFAULT);
$setPost = array_map("strip_tags", $getPost);
$post   = array_map("trim", $setPost);

$lgn = new Login();

$lgn->ExeLogin($post);

echo $lgn->getResult();



