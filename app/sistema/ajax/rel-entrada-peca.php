<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();
$dt     = new Datas();
$dtini  = $dt->setDt($post['dt_inicial']);
$dtfim  = $dt->setDt($post['dt_final']);

$sql->FullRead("SELECT 
                P.descricao_peca peca,
                P.id_peca,
                R.peca_serie serie,
                R.responsavel,
                R.preco_peca preco,
                R.observacao,
                sum(R.quantidade) quantidade,
                R.dt_recebimento data,
                F.nome_fornecedor fornecedor
            FROM
                tb_sys020 R
                    JOIN
                tb_sys015 P ON P.id_peca = R.peca_id
                            JOIN
                    tb_sys019 F ON F.id_fornecedor = R.fornecedor_id
                AND R.dt_recebimento between :DTINI AND :DTFIM GROUP BY P.id_peca ORDER BY R.dt_recebimento DESC", "DTINI="."{$dtini}"."&DTFIM="."{$dtfim}"."");
                
?>
<table>
    <tr>
        <th rowspan="5" style="width: 78px;"><img src="<?= LOGO_LORAC ?>"/></th>
    </tr>
    <tr>
        <th colspan="2" class="text-center text-uppercase"><?= PREFEITURA ?></th>
        <th rowspan="4" style="width: 78px;"><img src="<?= LOGO_SYSLAB ?>"/></th>
    </tr>
    <tr>
        <th colspan="2" class="text-center text-uppercase"><?= SECRETARIA ?></th>
    </tr>
    <tr>
        <th colspan="2" class="text-center text-uppercase"><?= DIRETORIA ?></th>
    </tr>
    <tr>
        <th class="text-center text-uppercase"><?= GERENCIA ?></th>
    </tr>
    <tr>
        <th colspan="4">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="4" class="text-center">RELATÓRIO DE RECEBIMENTO DE PEÇA</th>
    </tr>
    <tr>
        <th>Período</th>
        <td colspan="3"><?=$dt_inicial.' À '.$dt_final?></td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">            
            <table class="table-bordered">
                <tr class="text-uppercase">
                    <th class="text-center">código</th>
                    <th class="text-left">peça</th>
                    <th class="text-center">preço</th>
                    <th class="text-center">qtde.</th>
                    <th class="text-left">fornecedor</th>
                    <th class="text-center">data</th>
                    <th class="text-center">série</th>
                </tr>
                <? foreach ($sql->getResult() as $res):?>
                <tr>
                    <td class="text-center"><?=$res['id_peca']?></td>
                    <td class="text-capitalize"><?=$res['peca']?></td>
                    <td class="text-center">R$ <?=str_replace(".",",",$res['preco'])?></td>
                    <td class="text-center"><?=$res['quantidade']?></td>
                    <td class="text-capitalize"><?=$res['fornecedor']?></td>
                    <td><?=date("d/m/Y",strtotime($res['data']))?></td>
                    <td class="text-center text-uppercase"><?=$res['serie']?></td>
                </tr>
                <? endforeach;?>
            </table>
        </td>
    </tr>
</table>