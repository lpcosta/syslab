<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';

$sql = new Read();



$data = new Datas();

?>

<table class="table-responsive-sm tabela-tab table-hover">
    <tr class="text-uppercase">
        <th class="text-center cursor-pointer">OS</th>
        <th class="text-center cursor-pointer">PATRIMONIO</th>
        <th class="text-left">EQUIPAMENTO</th>
        <th class="text-left">LOCAL</th>
        <th class="text-center">DT.ENTRADA</th>
        <th class="text-center">DIAS PENDENTE</th>
    </tr>
    <?php
    foreach ($sql->getResult() as $res):
    ?>
    <tr class="text-capitalize">
        <td class="text-center cursor-pointer"><?=$res['os']?></td>
        <td class="text-center cursor-pointer"><?=$res['patrimonio']?></td>
        <td class="text-left"><?=$res['equipamento'].' '.$res['fabricante'].' '.$res['modelo']?></td>
        <td class="text-left"><?=$res['local']?></td>
        <td class="text-center"><?=$res['dtent'].' '.$res['hrent']?></td>
        <td class="text-center"><?=$data->setData($res['dtent'], $dt_fim)?></td>
    </tr>         
    <?php endforeach;?>
</table>
