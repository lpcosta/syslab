<?php
require_once './app/funcoes/func.inc.php';
paginaSegura();
$sql = new Read();

$sql->FullRead("SELECT S.id, S.descricao, COUNT(*) total FROM tb_sys006 IE JOIN tb_sys002 S ON S.id = IE.status AND IE.status != :STS   GROUP BY S.id ORDER BY descricao ","STS=3");
$dt = new Datas();
$checa = new Check();
$dt_fim = date('d/m/Y');
$pendentes = new Read();
?>
<div class="tabs">
    <ul>
        <?php foreach ($sql->getResult() as $res):?>
            <li><a class="text-capitalize" href="#<?=$checa->Url($res['descricao'])?>"><?=$res['descricao'].' '."(".$res['total'].")";?></a></li>
        <? endforeach;?>
    </ul>
    <?php foreach ($sql->getResult() as $res):
    if($res['id']==1):
        continue;
    else:?>
    <div id="<?=$checa->Url($res['descricao'])?>" class="conteudo-bancada">
        <table class="table-responsive-sm tabela-tab table-hover">
            <tr class="text-uppercase text-primary">
                <th class="text-left">localidade</th>
                 <?php if($res['id']==4):
                    print "<th class=\"text-left\">endereço</th>";
                else:
                    print "<th class=\"text-left\">técnico entrada</th>";
                endif;?>          
                <th class="text-left">equipamento</th>
                <th class="text-center">os</th>
                <th class="text-center">patrimônio</th>
                <th class="text-center">Dt.Entrada</th>
                <th class="text-center">Dt.Avaliacao</th>
                <th class="text-center">dias</th>
            </tr>
            <?
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
                AND IE.status = :STATUS GROUP BY EQ.patrimonio ORDER BY E.data", "STATUS={$res['id']}");
            foreach ($sql->getResult() as $rowEquipamento): ?>
                <tr class="text-capitalize">
                    <td class="text-left"><?=$rowEquipamento['localidade'].' '.$rowEquipamento['andar'];if(!empty($rowEquipamento['sala'])){print " - Sala ".$rowEquipamento['sala'];}?></td>
                    <?php if($res['id']==4):
                    print "<td class=\"text-left\">" . $rowEquipamento['endereco'] ."</td>";
                    else:
                    print "<td class=\"text-left\">".$rowEquipamento['tecnico']."</td>";
                    endif;?>   
                    <td class="text-left"><?= $rowEquipamento['equipamento'] . ' ' . $rowEquipamento['fabricante'] . ' ' . $rowEquipamento['modelo'] ?></td>
                    <td class="text-center"><?= $rowEquipamento['os'] ?></td>
                    <td class="text-center cursor-pointer" onclick="mostraModal(<?= $rowEquipamento['patrimonio'] ?>)"><?= $rowEquipamento['patrimonio'] ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($rowEquipamento['data']));?></td>
                    <?php if($res['id']==4):
                    print "<td class=\"text-center\">" . date('d/m/Y', strtotime($rowEquipamento['dt_last_update']))."</td>";
                    else:
                    print "<td class=\"text-center\">".date('d/m/Y', strtotime($rowEquipamento['dtava']))."</td>";
                    endif;?>   
                    <td class="text-center"><?=$dt->setData($rowEquipamento['data'], HOJE) ?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
    <?php endif;endforeach;?> 
    <div id="pendente">
        <table class="table-responsive-sm tabela-tab table-hover">
            <tr class="text-uppercase text-primary">
                <th class="text-left">LOCAL</th>
                <th class="text-left">EQUIPAMENTO</th>
                <th class="text-center">OS</th>
                <th class="text-center cursor-pointer">PATRIMONIO</th>
                <th class="text-center">DT.ENTRADA</th>
                <th class="text-center">SECRETARIA</th>
                <th class="text-center">PENDENCIA</th>
            </tr>
            <?php
            $pendentes->FullRead("SELECT I_ENT.os_sti os,EQP.patrimonio,CAT.descricao equipamento,LOC.local,SEC.sigla,ENT.data dtent,ENT.hora hrent,FAB.nome_fabricante fabricante,MO.modelo
                            FROM tb_sys004 EQP
                            JOIN tb_sys006 I_ENT ON I_ENT.patrimonio = EQP.patrimonio
                            JOIN tb_sys005 ENT ON ENT.identrada = I_ENT.id_entrada
                            JOIN tb_sys003 CAT ON CAT.id = EQP.id_categoria 
                            JOIN tb_sys018 FAB ON FAB.id_fabricante = EQP.fabricante
                            JOIN tb_sys022 MO ON MO.id_modelo = EQP.modelo
                            JOIN tb_sys008 LOC ON LOC.id = EQP.id_local
                            JOIN tb_sys011 SEC ON SEC.id_secretaria = LOC.secretaria_id AND I_ENT.status = :STATUS", "STATUS=1");     
            foreach ($pendentes->getResult() as $pendente):
            ?>
            <tr class="text-capitalize">
                <td class="text-left"><?=$pendente['local']?></td>
                <td class="text-left"><?=$pendente['equipamento'].' '.$pendente['fabricante'].' '.$pendente['modelo']?></td>
                <td class="text-center"><?=$pendente['os']?></td>
                <td class="text-center cursor-pointer" onclick="mostraModal(<?= $pendente['patrimonio'] ?>)"><?=$pendente['patrimonio']?></td>
                <td class="text-center"><?=date("d/m/Y",strtotime($pendente['dtent']));?></td>
                <td class="text-center text-uppercase"><?=$pendente['sigla']?></td>
                <td class="text-center"><?=$dt->setData($pendente['dtent'], $dt_fim)?></td>
            </tr>         
            <?php endforeach;?>
        </table>
    </div>
</div>
