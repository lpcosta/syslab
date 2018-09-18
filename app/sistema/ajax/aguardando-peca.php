<?php
require_once '../../config/autoload.inc.php';
require_once '../../funcoes/func.inc.php';

$sql = new Read();

$sql->FullRead("SELECT 
            C.descricao equipamento,
            F.nome_fabricante fabricante,
            M.modelo,
            EQ.andar,
            EQ.sala,
            EQ.patrimonio,
            IE.os_sti os,
            L.local localidade,
            T.nome tecnico,
            E.data,
            A.data dtava
        FROM
            tb_sys004 EQ
                JOIN
            tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                JOIN
            tb_sys022 M ON M.id_modelo = EQ.modelo
                JOIN
            tb_sys005 E ON E.identrada = IE.id_entrada
                JOIN
            tb_sys001 T ON T.id = E.id_tecnico
                JOIN
            tb_sys003 C ON C.id = EQ.id_categoria
                JOIN
            tb_sys008 L ON L.id = EQ.id_local
                JOIN
            tb_sys010 A ON A.id_item_entrada = IE.id
                JOIN
            tb_sys018 F ON F.id_fabricante = EQ.fabricante
                AND IE.status = :STATUS
        ORDER BY E.data", "STATUS=5");

$dt = new Datas();
?>

<h2>Aguardando Peça - <?=$sql->getRowCount();?> </h2>
    <table class="table-responsive-sm tabela-tab table-hover">
        <tr class="text-uppercase">
            <th class="text-center cursor-pointer">os</th>
            <th class="text-center cursor-pointer">patrimônio</th>
            <th class="text-left">equipamento</th>
            <th class="text-left">localidade</th>
            <th class="text-left">técnico entrada</th>
            <th class="text-center">entrada</th>
            <th class="text-center">avaliacao</th>
            <th class="text-center">dias</th>
        </tr>
        <? foreach ($sql->getResult() as $rowEquipamento) { ?>
            <tr class="text-capitalize">
                <td class="text-center cursor-pointer" onclick="show_modal('modal', '/require/paginas/pesquisa/pesquisa.php?dado='+<?=$rowEquipamento['os']?>+'&opt=os', 'PESQUISA DE EQUIPAMENTO ');"><?= $rowEquipamento['os'] ?></td>
                <td class="text-center cursor-pointer" onclick="show_modal('modal', '/require/paginas/pesquisa/pesquisa.php?dado='+<?=$rowEquipamento['patrimonio']?>+'&opt=p', 'PESQUISA DE EQUIPAMENTO ');"><?= $rowEquipamento['patrimonio'] ?></td>
                <td class="text-left"><?= $rowEquipamento['equipamento'] . ' ' . $rowEquipamento['fabricante'] . ' ' . $rowEquipamento['modelo'] ?></td>
                <td class="text-left"><?=$rowEquipamento['localidade'].' '.$rowEquipamento['andar'];if(!empty($rowEquipamento['sala'])){print " - Sala ".$rowEquipamento['sala'];}?></td>
                <td class="text-left"><?= $rowEquipamento['tecnico'] ?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($rowEquipamento['data']));?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($rowEquipamento['dtava']));?></td>
                <td class="text-center"><?=$dt->setData($rowEquipamento['data'], HOJE) ?></td>
            </tr>
        <? } ?>
    </table>
