<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Update();
$texto  = new Check();


unset($post['id']);

$sql->ExeUpdate("tb_sys010", $post, "WHERE id = :ID", "ID={$id}");
    if(!$sql->getResult()):
        print $sql->getError();
    endif;