<?php
paginaSegura();
    if(isset($_GET['cid'])):
        require_once './app/config/get.inc.php';
        if(!empty($cid)):
            $sql = new Read();
            $checa = new Check();
            $dt    = new Datas();
            $sql->FullRead("SELECT C.descricao,
                                   F.nome_fabricante fabricante,
                                   M.modelo,
                                   L.local,
                                   EQ.patrimonio,
                                   IE.os_sti os,
                                   S.descricao status,
                                   E.data
                             FROM tb_sys004 EQ
                                JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                                JOIN tb_sys018 F ON F.id_fabricante = EQ.fabricante
                                JOIN tb_sys002 S ON S.id = IE.status
                                JOIN tb_sys022 M ON M.id_modelo = EQ.modelo
                                JOIN tb_sys008 L ON L.id = EQ.id_local
                                JOIN tb_sys003 C ON C.id = EQ.id_categoria
                                JOIN tb_sys005 E ON E.identrada = IE.id_entrada AND C.id = :ID AND IE.status != :STS","ID={$cid}&STS=3");
        endif;
        print_r($sql->getError());
    endif;
?>
<div class="tabs">
    <ul>
        <li><a class="text-capitalize" href="#<?=$checa->Url($sql->getResult()[0]['descricao'])?>"><?=$sql->getResult()[0]['descricao']?></a></li>
    </ul>
    <div id="<?=$checa->Url($sql->getResult()[0]['descricao'])?>">
        <table class="table-responsive-sm tabela-tab table-hover">
            <tr class="text-uppercase text-primary">
                <th>Equipamento</th>
                <th>Localidade</th>
                <th class="text-center">Patrimonio</th>
                <th class="text-center">OS</th>
                <th class="text-center">Status</th>
                <th>Dt.Entrada</th>
                <th class="text-center">Pendência</th>                
            </tr>
        <? foreach ($sql->getResult() as $res):?>
            <tr class="text-capitalize">
                <td><?=$res['fabricante'].' '.$res['modelo']?></td>
                <td><?=$res['local']?></td>
                <td class="text-center cursor-pointer" onclick="mostraModal(<?=$res['patrimonio']?>)"><?=$res['patrimonio']?></td>
                <td class="text-center"><?=$res['os']?></td>
                <td class="text-center"><?=$res['status']?></td>
                <td><?=date("d/m/Y",strtotime($res['data']))?></td>
                <td class="text-center"><?=$dt->setData($res['data'], HOJE) ?></td>
            </tr>
        <? endforeach;?>
        </table>
    </div>
</div>
