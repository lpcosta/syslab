<?php
require_once '../../config/autoload.inc.php';
require_once '../../funcoes/func.inc.php';
$sql = new Read();
extract(filter_input_array(INPUT_POST, FILTER_DEFAULT));
$busca = strip_tags(trim($busca));

if($acao == 'patrimonio'):
    $sql->FullRead("SELECT 
    EQ.patrimonio,
    C.descricao equipamento,
    EQ.andar,
    EQ.sala,
    EQ.status baixa,
    L.local,
    F.nome_fabricante fabricante,
    M.modelo
FROM
    tb_sys004 EQ
        JOIN
    tb_sys003 C ON C.id = EQ.id_categoria
        JOIN
    tb_sys018 F ON F.id_fabricante = EQ.fabricante
        JOIN
    tb_sys022 M ON M.id_modelo = EQ.modelo
        JOIN
    tb_sys008 L ON L.id = EQ.id_local
        AND EQ.patrimonio = :PAT", "PAT="."{$busca}"."");
elseif($acao=='os'):
    $sql->FullRead("SELECT 
    EQ.patrimonio,
    C.descricao equipamento,
    EQ.andar,
    EQ.sala,
    EQ.status baixa,
    L.local,
    F.nome_fabricante fabricante,
    M.modelo
FROM
    tb_sys004 EQ
        JOIN
    tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
        JOIN
    tb_sys003 C ON C.id = EQ.id_categoria
        JOIN
    tb_sys018 F ON F.id_fabricante = EQ.fabricante
        JOIN
    tb_sys022 M ON M.id_modelo = EQ.modelo
        JOIN
    tb_sys008 L ON L.id = EQ.id_local
        AND IE.os_sti = :OS", "OS="."{$busca}"."");
endif;


if($sql->getResult()):
?>

<div class="row">
    <div class="col">
        <label>Patrimonio</label>
        <input type="text" class="form-control" disabled="" value="<?=$sql->getResult()[0]['patrimonio']?>"/>
    </div>
    <div class="col">
        <label>Equipamento</label>
        <input type="text" class="form-control text-capitalize" disabled="" value="<?=$sql->getResult()[0]['equipamento'].' '.$sql->getResult()[0]['fabricante'].' '.$sql->getResult()[0]['modelo']?>"/>
    </div>
</div>
<div class="row">
    <div class="col">
        <label>Localidade</label>
        <input type="text" class="form-control text-capitalize" disabled=""value="<?=$sql->getResult()[0]['local']?>"/>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <label>Andar</label><br />
                <input type="text" class="form-control" disabled="" style="max-width: 100px;" value="<?=$sql->getResult()[0]['andar']?>"/>
            </div>
            <div class="col">
                <label>Sala</label>
                <input type="text" class="form-control" disabled="" value="<?=$sql->getResult()[0]['sala']?>"/>
            </div>
        </div>
    </div>
</div>
<hr />
<div class="text-center" style="background-color: #E9E9E9;">
    <p class="text-uppercase">histórico de laboratório</p>
</div>
<table class="tabela-dados table-hover">
    <tr class="text-uppercase">
        <th class="text-center">data</th>
        <th class="text-center">entrada</th>
        <th class="text-center" style="width: 60px;">os</th>
        <th style="min-width: 190px;">técnico</th>
        <th style="min-width: 150px;">motivo</th>
        <th>Observação</th>
        <th style="width: 115px;">status</th>
    </tr>
    <?php 
        $sql->FullRead("SELECT 
            IE.id_entrada entrada,
            IE.motivo,
            IE.os_sti os,
            IE.observacao,
            STS.descricao status,
            STS.cor,
            TEC.nome tecnico,
            ENT.data
        FROM
            tb_sys006 IE
                JOIN
            tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio
                JOIN
            tb_sys005 ENT ON ENT.identrada = IE.id_entrada
                JOIN
            tb_sys001 TEC ON TEC.id = ENT.id_tecnico
                JOIN
            tb_sys002 STS ON STS.id = IE.status AND IE.patrimonio = :PAT order by IE.id desc;", "PAT={$sql->getResult()[0]['patrimonio']}");
        foreach ($sql->getResult() as $res):
    ?>
    <tr style="background-color: <?=$res['cor']?>;">
        <td class="text-center"><?=date('d/m/Y',strtotime($res['data']));?></td>
        <td class="text-center"><?=$res['entrada']?></td>
        <td class="text-center"><?=$res['os']?></td>
        <td class="text-capitalize"><?=$res['tecnico']?></td>
        <td><?=$res['motivo']?></td>
        <td><?=$res['observacao']?></td>
        <td class="text-capitalize"><?=$res['status']?></td>
    </tr>
    <?php endforeach;?>
</table>
<?else:?>
<h1 class="text-center text-uppercase alert alert-warning" role="alert">nenhum registro encontrado! <br />para <?php 
    if($acao=='os'):
        print "a os ".$busca;
    else:
        print "o patrimônio ".$busca;
    endif;?>
</h1>
<?php endif;?>
