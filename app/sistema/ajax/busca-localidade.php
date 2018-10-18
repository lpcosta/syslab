<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();

$sql->ExeRead("tb_sys008 WHERE id = {$id}");

?>

<hr />
<form class="edita" onsubmit="return false">
      <?print_r($sql->getResult())?>
</form>
