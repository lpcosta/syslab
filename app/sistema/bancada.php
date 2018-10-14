<?php
require_once './app/funcoes/func.inc.php';
paginaSegura();
$sqlEqpmt   = new Read();
$checa      = new Check();

$sqlEqpmt->FullRead("SELECT C.id,C.descricao equipamento, COUNT(*) total FROM
                        tb_sys006 IE
                            JOIN
                        tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio
                            JOIN 
                        tb_sys003 C ON C.id = EQ.id_categoria AND IE.status = :STS group by C.id ORDER BY equipamento", "STS=1");

$sql = new Read();
$dt  = new Datas();

?>

<div class="tabs">
    <ul>
        <?php foreach ($sqlEqpmt->getResult() as $res): ?>
        <li><a class="text-capitalize" href="#<?=$checa->Url($res['equipamento'])?>"><?=$res['equipamento'].' '."(".$res['total'].")";?></a></li>
        <? endforeach;?>
    </ul>
    <div class="bancada-top">
        <form id="form-bancada-search" onsubmit="return false;" style="width: 98%;">
            <div class="row">
                <div class="col-lg form-inline">
                    <label>Patrimonio/OS</label>
                    <input type="text" name="patrimonio" class="form-control auto-focus" id="txtPatrimonio" autofocus="" />
                    &nbsp;
                    <input type="submit" class="btn btn-primary" id="btnAvalia" name="btnBancada" value="Pesquisar" />&nbsp;
                    <input type="button" class="btn btn-primary" name="btnBancada" value="Carregar" onclick="history.go(0);" />
                    &nbsp;
                </div>
            </div>
        </form>
    </div>
    <div class="dados-avalia"></div>
    <?php $form=0; foreach ($sqlEqpmt->getResult() as $res): ?>
        <div id="<?=$checa->Url($res['equipamento'])?>" class="conteudo-bancada">
            <table class="table-responsive-sm tabela-tab table-hover">
                <tr class="text-uppercase text-primary">
                    <th class="text-left">Modelo</th>
                    <th class="text-center">Patrimonio</th>
                    <th class="text-center">O.S</th>
                    <th>Motivo</th>
                    <th>Localidade</th>
                    <th class="text-center">Dt.Entrada</th>
                    <th class="text-center">Pendência</th>
                </tr>
            <?php $sql->FullRead("SELECT
                                        IE.id,
                                        IE.os_sti os,
                                        EQ.patrimonio,
                                        IE.motivo,
                                        L.local localidade,
                                        E.data dtentrada,
                                        M.modelo
                                    FROM
                                        tb_sys006 IE
                                            JOIN
                                        tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio
                                        JOIN
                                        tb_sys003 C ON C.id = EQ.id_categoria
                                        JOIN
                                        tb_sys022 M ON M.id_modelo = EQ.modelo
                                        JOIN
                                        tb_sys008 L ON L.id = EQ.id_local
                                        JOIN
                                        tb_sys005 E ON E.identrada = IE.id_entrada AND IE.status = :STS AND C.id = :CATEG", "STS=1&CATEG={$res['id']}"); 
               foreach($sql->getResult() as $row):
            ?>
                <tr style="cursor:pointer;" onclick="avaliaEquipamento(<?=$row['id']?>);" title="Clique para Avaliar">
                    <td class="text-left text-capitalize"><?=$row['modelo']?></td>
                    <td class="text-center"><?=$row['patrimonio']?></td>
                    <td class="text-center"><?=$row['os']?></td>
                    <td class="text-capitalize"><?=$row['motivo']?></td>
                    <td class="text-capitalize "><?=$row['localidade']?></td>
                    <td class="text-center"><?=date("d/m/Y",strtotime($row['dtentrada']))?></td>
                    <td class="text-center"><?=$dt->setData($row['dtentrada'], HOJE) ?></td>
                </tr>
                <?php endforeach?>
            </table>
        </div>
    <?$form++; endforeach;?> 
    <div style="width: 40px; margin: 0 auto;"><img src="./app/imagens/load.gif" class="form_load"  alt="[CARREGANDO...]" title="CARREGANDO.." /></div>
</div>
