<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';
paginaSegura();
$sql = new Read();
$dt = new Datas();
$dt_fim = date('d/m/Y');

    $sql->FullRead("SELECT 
            C.descricao equipamento,
            F.nome_fabricante fabricante,
            M.modelo,
            EQ.andar,
            EQ.sala,
            EQ.patrimonio,
            IE.os_sti os,
            L.local localidade,
            L.rua endereco,
            T.nome tecnico,
            E.data,
            A.data dtava,
            A.dt_last_update
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
                AND IE.status = :STS AND L.regiao_id = :REGIAO GROUP BY EQ.patrimonio ORDER BY L.local","STS=4&REGIAO={$id}");
?>
<table class="table table-hover">
    <tr class="text-uppercase text-primary">
        <th class="text-left">localidade</th>
        <th class="text-left">endereço</th>       
        <th class="text-left">equipamento</th>
        <th class="text-center">os</th>
        <th class="text-center">patrimônio</th>
        <th class="text-center">Dt.Entrada</th>
        <th class="text-center">Dt.Avaliacao</th>
        <th class="text-center">dias</th>
    </tr>
<?foreach ($sql->getResult() as $rowEquipamento): ?>
    <tr class="text-capitalize">
        <td class="text-left"><?=$rowEquipamento['localidade'].' '.$rowEquipamento['andar'];if(!empty($rowEquipamento['sala'])){print " - Sala ".$rowEquipamento['sala'];}?></td>
        <td class="text-left"><?=$rowEquipamento['endereco']?></td>
        <td class="text-left"><?= $rowEquipamento['equipamento'] . ' ' . $rowEquipamento['fabricante'] . ' ' . $rowEquipamento['modelo'] ?></td>
        <td class="text-center"><?= $rowEquipamento['os'] ?></td>
        <td class="text-center cursor-pointer" onclick="mostraModal('<?=$rowEquipamento['patrimonio']?>')"><?= $rowEquipamento['patrimonio'] ?></td>
        <td class="text-center"><?= date('d/m/Y', strtotime($rowEquipamento['data']));?></td>
        <td class="text-center"><?= date('d/m/Y', strtotime($rowEquipamento['dtava']));?></td>
        <td class="text-center"><?=$dt->setData($rowEquipamento['data'], HOJE) ?></td>
    </tr>
<?endforeach;?>
</table>