<?php
require_once '../../config/autoload.inc.php';
require_once '../../funcoes/func.inc.php';

$sql = new Read();

$sql->FullRead("SELECT I_ENT.os_sti os,EQP.patrimonio,CAT.descricao equipamento,LOC.local,ENT.data dtent,ENT.hora hrent,FAB.nome_fabricante fabricante,MO.modelo
                            FROM tb_sys004 EQP
                            JOIN tb_sys006 I_ENT ON I_ENT.patrimonio = EQP.patrimonio
                            JOIN tb_sys005 ENT ON ENT.identrada = I_ENT.id_entrada
                            JOIN tb_sys003 CAT ON CAT.id = EQP.id_categoria 
                            JOIN tb_sys018 FAB ON FAB.id_fabricante = EQP.fabricante
                            JOIN tb_sys022 MO ON MO.id_modelo = EQP.modelo
                            JOIN tb_sys008 LOC ON LOC.id = EQP.id_local AND I_ENT.status = :STATUS", "STATUS=1");     

$data = new Datas();
$dt_fim = date('d/m/Y');
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
