<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';

$sql = new Read();

            $sql->FullRead("SELECT I_ENT.os_sti os,EQP.patrimonio,EQP.sala,EQP.andar,CAT.descricao equipamento,LOC.local,LOC.rua endereco,ENT.data dtent,ENT.hora hrent,AVA.data dtava,AVA.hora hrava,FAB.nome_fabricante fabricante,MO.modelo
                            FROM tb_sys004 EQP
                            JOIN tb_sys006 I_ENT ON I_ENT.patrimonio = EQP.patrimonio
                            JOIN tb_sys005 ENT ON ENT.identrada = I_ENT.id_entrada
                            JOIN tb_sys003 CAT ON CAT.id = EQP.id_categoria 
                            JOIN tb_sys018 FAB ON FAB.id_fabricante = EQP.fabricante
                            JOIN tb_sys022 MO ON MO.id_modelo = EQP.modelo
                            JOIN tb_sys008 LOC ON LOC.id = EQP.id_local
                            JOIN tb_sys010 AVA ON AVA.id_item_entrada = I_ENT.id AND I_ENT.status = :STATUS GROUP BY EQP.patrimonio ORDER BY local", "STATUS=4");
            
$data = new Datas();
$dt_fim = date("d/m/Y");
          if($sql->getRowCount() > 0):?>


<table class="table-responsive-sm tabela-tab table-hover">
    <tr class="text-uppercase">
        <th class="tab-tam-min-os text-center cursor-pointer">o.s</th>
        <th class="tab-tam-min-pat text-center cursor-pointer">patrimônio</th>
        <th>equipamento</th>
        <th>localidade</th>
        <th>Endereço</th>
        <th class="text-center">dt.entrada</th>
        <th class="text-center">dt.avaliação</th>
        <th>Pendência</th>
    </tr>
<?php foreach ($sql->getResult() as $row):?>
    <tr class="text-uppercase">
        <td class="text-center cursor-pointer"><?php print $row['os']?></td>
        <td class="text-center cursor-pointer"><?php print $row['patrimonio']?></td>
        <td><?php print $row['equipamento']." ".$row['fabricante']." ".$row['modelo']?></td>
        <td><?php print $row['local']?></td>
        <td><?php print $row['endereco'].' '.$row['andar'].' '.$row['sala']?></td>
        <td class="text-center"><?php print date("d/m/Y",strtotime($row['dtent']))."<span class=\"hide\" > ".date("H:i:s", strtotime($row['hrent']))."</span>"?></td>
        <td class="text-center"><?php print date("d/m/Y",strtotime($row['dtava']))."<span class=\"hide\" > ".date("H:i:s", strtotime($row['hrava']))."</span>"?></td>
        <td class="text-center"><?php print $data->setData($row['dtent'], $dt_fim);?></td>
    </tr>
    <?php endforeach;?>
    <tr>
        <th colspan="5">&nbsp;</th>
        <th class="text-center">Total</th>
        <th class="text-center"><?=$sql->getRowCount();?></th>
    </tr>
</table>
<?php endif;
