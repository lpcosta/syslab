<?php
require_once '../../config/autoload.inc.php';
$sql = new Read();

extract(filter_input_array(INPUT_POST, FILTER_DEFAULT));

$fab = strip_tags(trim(intval($fabricante)));

if(isset($fab) && !empty($fab)):
    $sql->FullRead("SELECT * FROM tb_sys022 where fabricante_id = :IDFAB ORDER BY modelo ", "IDFAB={$fab}");
    foreach ($sql->getResult() as $res):
        print "<option value=".$res['id_modelo']." class='cmbv_modelos'>".ucfirst($res['modelo'])."</option>";
    endforeach;
endif;
