<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';
session_start();
$sql = new Read();
$texto = new Check();

$busca = $texto->setTexto($busca);

$sql->FullRead("SELECT 
    EQ.patrimonio,
    EQ.serie,
    C.descricao equipamento,
    C.id categoria,
    EQ.andar,
    EQ.sala,
    EQ.status baixa,
    EQ.ip,
    EQ.so_id,
    EQ.office_id,
    EQ.key_so,
    EQ.key_office,
    EQ.memoria_ram_id,
    EQ.processador_id,
    EQ.hd,
    EQ.status situacao,
    L.local,
    L.cr,
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
        
if(!$sql->getResult()){
    $sql->FullRead("SELECT 
        EQ.patrimonio,
        EQ.serie,
        C.descricao equipamento,
        C.id categoria,
        EQ.andar,
        EQ.sala,
        EQ.status baixa,
        EQ.ip,
        EQ.so_id,
        EQ.office_id,
        EQ.key_so,
        EQ.key_office,
        EQ.memoria_ram_id,
        EQ.processador_id,
        EQ.hd,
        EQ.status situacao,
        L.local,
        L.cr,
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
}

if(!$sql->getResult()){
    $sql->FullRead("SELECT 
        EQ.patrimonio,
        EQ.serie,
        C.descricao equipamento,
        C.id categoria,
        EQ.andar,
        EQ.sala,
        EQ.status baixa,
        EQ.ip,
        EQ.so_id,
        EQ.office_id,
        EQ.key_so,
        EQ.key_office,
        EQ.memoria_ram_id,
        EQ.processador_id,
        EQ.hd,
        EQ.status situacao,
        L.local,
        L.cr,
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
            AND EQ.serie = :SERIE", "SERIE="."{$busca}"."");   
}
    $categorias=[2,5,17,22,23,26];
    
    if(isset($sql->getResult()[0]['categoria'])):
        $categoria = $sql->getResult()[0]['categoria'];
    else:
        $categoria = 0;
    endif;
    if(in_array($categoria,$categorias)):
        if($sql->getResult()[0]['so_id'] !=0):
            $sqlSo = new Read();
            $sqlSo->ExeRead("tb_sys025 WHERE id_so = {$sql->getResult()[0]['so_id']}");
            $so = $sqlSo->getResult()[0]['descricao_so'].' '.$sqlSo->getResult()[0]['versao_so'].' '.$sqlSo->getResult()[0]['arquitetura_so'];
        endif;
        if($sql->getResult()[0]['office_id'] !=0):
            $sqlOf = new Read();
            $sqlOf->ExeRead("tb_sys026 WHERE id_office = {$sql->getResult()[0]['office_id']}");
            $office = $sqlOf->getResult()[0]['descricao_office'].' '.$sqlOf->getResult()[0]['versao_office'].' '.$sqlOf->getResult()[0]['arquitetura_office'];
        endif;
        if($sql->getResult()[0]['memoria_ram_id'] !=0):
            $sqlMem = new Read();
            $sqlMem->ExeRead("tb_sys029 WHERE id = {$sql->getResult()[0]['memoria_ram_id']}");
            $memoria = $sqlMem->getResult()[0]['capacidade'].' '.$sqlMem->getResult()[0]['tipo_memoria'];
        endif;
        if($sql->getResult()[0]['processador_id'] !=0):
            $sqlProc = new Read();
            $sqlProc->ExeRead("tb_sys028 WHERE id = {$sql->getResult()[0]['processador_id']}");
            $processador = $sqlProc->getResult()[0]['processador'].' ';
            if($sqlProc->getResult()[0]['geracao']!=0):
                $processador .=$sqlProc->getResult()[0]['geracao'].'ªGeração';
            endif;
        endif;
    endif;
        
if($sql->getResult()):
?>
<div class="dados-pesquisa">
    <div class="row">
        <div class="col form-inline">
            <label>Patrimonio</label>
            <input type="text" class="text-uppercase"disabled="" value="<?=$sql->getResult()[0]['patrimonio']?>" style="width:90px;"/>
            <label style="width:40px;border-left: none;">N/S</label>
            <input type="text" class="text-uppercase"disabled="" value="<?=$sql->getResult()[0]['serie']?>" style="width: calc(100% - 242px);"/>
        </div>
        <div class="col form-inline">
            <label>Equipamento</label>
            <input type="text" class="text-capitalize" disabled="" value="<?=$sql->getResult()[0]['equipamento'].' '.$sql->getResult()[0]['fabricante'].' '.$sql->getResult()[0]['modelo']?>" style="width: calc(100% - 112px);"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Localidade</label>
            <input type="text" class="text-capitalize" disabled=""value="<?=$sql->getResult()[0]['cr']. ' - ' .$sql->getResult()[0]['local']?>" style="width: calc(100% - 112px);"/>
        </div>
        <div class="col form-inline">
            <label>Andar</label>
            <input type="text" class="text-uppercase" disabled="" style="max-width: 100px;" value="<?=$sql->getResult()[0]['andar']?>"/>
            <label style="width:60px; border-left: none;">Sala</label>
                <input type="text" class="text-capitalize" disabled="" value="<?=$sql->getResult()[0]['sala']?>" style="width: calc(100% - 272px);"/>
        </div>
    </div>
<?switch ($sql->getResult()[0]['categoria']):
    case 1:?>
    <div class="row">
        <div class="col form-inline">
            <label>IP</label>
            <input type="text" value="<?=$sql->getResult()[0]['ip']?>" disabled="">
        </div> 
    </div>
<?break;
    case  2:
    case  5:
    case 17:
    case 23:
    case 22:
    case 26:?>
        <div class="row">
            <div class="col form-inline">
                <label>S.O</label>
                <?if(isset($so)):?>
                    <input type="text" value="<?=$so?>" class="text-capitalize" style="min-width: 250px;" disabled="" />
                <?else:print "<input type='text' disabled='' style=\"min-width: 250px;\" />";endif;?>
            </div>
            <div class="col form-inline">
                <label>Chave S.O</label>
                <input type="text" value="<?=$sql->getResult()[0]['key_so']?>" class="text-uppercase m_key" disabled=""/>
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label>Office</label>
                <?if(isset($office)):?>
                    <input type="text" value="<?=$office?>" class="text-capitalize" style="min-width: 250px;" disabled="" />
               <?else:print "<input type='text' disabled='' style=\"min-width: 250px;\" />";endif;?>
            </div>
            <div class="col form-inline">
                <label>Chave office</label>
                <input type="text" value="<?=$sql->getResult()[0]['key_office']?>" class="text-uppercase m_key" disabled=""/>
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label>memória</label>
                <?if(isset($memoria)):?>
                    <input type="text" value="<?=$memoria?>" class="text-capitalize" style="min-width: 250px;" disabled="" />
               <?else:print "<input type='text' disabled='' style=\"min-width: 250px;\" />";endif;?>
            </div>
            <div class="col form-inline">
                <label>HD</label>
                <input type="text" value="<?=$sql->getResult()[0]['hd']?>" class="text-capitalize" disabled=""/>
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label>processador</label>
                <?if(isset($processador)):?>
                    <input type="text" value="<?=$processador?>" class="text-capitalize" style="min-width: 250px;" disabled="" />
               <?else:print "<input type='text' disabled='' style=\"min-width: 250px;\" />";endif;?>
            </div>
            <div class="col form-inline">
                <label>situação</label>
                <input type="text" value="<?=$sql->getResult()[0]['situacao']?>" class="text-capitalize" disabled=""/>
            </div>
        </div>
<?break;
    default :
               NULL;         
?>
    
    <?endswitch;
    $patrimonio = $sql->getResult()[0]['patrimonio'];
    $sql->FullRead("SELECT 
                        IE.id,
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
                        tb_sys002 STS ON STS.id = IE.status AND IE.patrimonio = :PAT order by IE.id desc;", "PAT="."$patrimonio"."");
    ?>
</div>
<hr />
<div class="text-center" style="background-color: #E9E9E9;">
    <p class="text-uppercase">histórico de laboratório (<?=$sql->getRowCount() ?>)</p>
</div>
<table class="tabela-dados table-hover">
    <tr class="text-uppercase">
        <th class="text-center">data</th>
        <th class="text-center">entrada</th>
        <th class="text-center" style="width: 60px;">os</th>
        <th style="min-width: 190px;">técnico</th>
        <th style="min-width: 150px;">motivo</th>
        <th>Observação</th>
        <th class="text-center" style="width:50px;">saída</th>
        <th style="width: 115px;">status</th>
    </tr>
    <?foreach ($sql->getResult() as $res):?>
    <tr style="background-color: <?=$res['cor']?>;">
        <td class="text-center"><?=date('d/m/Y',strtotime($res['data']));?></td>
        <td class="text-center cursor-pointer" onclick="location.href='index.php?pg=relatorio/entrada&id='+<?=$res['entrada']?>"><?=$res['entrada']?></td>
        <td class="text-center"><?=$res['os']?></td>
        <td class="text-capitalize"><?=$res['tecnico']?></td>
        <td><?=$res['motivo']?></td>
        <td><?=$res['observacao']?></td>
    <?if($res['status']=='fechado'):
        $sql->FullRead("SELECT id_saida FROM tb_sys009 WHERE id_item_entrada = :ITEM","ITEM={$res['id']}");
        ?>
        <td class="text-center cursor-pointer" onclick="location.href='index.php?pg=relatorio/saida&id='+<?=$sql->getResult()[0]['id_saida']?>"><?=$sql->getResult()[0]['id_saida']?></td>
    <?else:?>
        <td>&nbsp;</td>
    <?endif;?>
        <td class="text-capitalize"><?=$res['status']?></td>
    </tr>
    <?php endforeach;?>
</table>
<hr/>
<?
    $sql->FullRead("SELECT 
                    A.id,
                    A.data,
                    IE.id_entrada entrada,
                    IE.os_sti os,
                    IE.status sts,
                    T.nome tecnico,
                    A.avaliacao,
                    S.descricao status,
                    S.cor,
                    A.peca_id
                FROM
                    tb_sys010 A
                        JOIN
                    tb_sys006 IE ON IE.id = A.id_item_entrada
                        JOIN
                    tb_sys001 T ON T.id = A.id_tecnico_bancada
                        JOIN
                    tb_sys002 S ON S.id = A.id_status
                        AND IE.patrimonio = :PAT ORDER BY A.id DESC","PAT="."$patrimonio"."");
?>
    <p class="text-uppercase text-center" style="background-color: #E9E9E9;">histórico de bancada</p>
    <?if($sql->getRowCount() > 0):?>
    <table class="tabela-dados table-hover">
        <tr class="text-uppercase">
            <th class="text-center">data</th>
            <th class="text-center">entrada</th>
            <th class="text-center" style="width: 60px;">os</th>
            <th style="min-width: 190px;">técnico</th>
            <th style="max-width: 300px;">avaliação</th>
            <th>&nbsp;</th>
            <th style="width: 115px;">status</th>
            <th>peça</th>
        </tr>
    <? foreach ($sql->getResult() as $res):?>
        <tr style="background-color: <?=$res['cor']?>;">
            <td class="text-center"><?=date("d/m/Y",strtotime($res['data']))?></td>
            <td class="text-center"><?=$res['entrada']?></td>
            <td class="text-center"><?=$res['os']?></td>
            <td class="text-left text-capitalize"><?=$res['tecnico']?></td>
            <td style="max-width: 300px;" class="text-left"><?= ucfirst($res['avaliacao'])?></td>
        <?if($res['sts'] != 3 && $_SESSION['UserLogado']['grupo_id'] == 4):?>
            <td class="text-left"><a href="index.php?pg=edita/edita-avaliacao&id=<?=$res['id']?>"><button>Editar</button></a></td>
        <?else:?>
            <td class="text-left">&nbsp;</td>
        <?endif;?>
            <td><?=$res['status']?></td>
        <?if(!empty($res['peca_id'])):
            $sql->FullRead("SELECT id_peca,descricao_peca FROM tb_sys015 WHERE id_peca = :PECA","PECA={$res['peca_id']}");?>
            <td class="text-left text-capitalize"><?=$sql->getResult()[0]['id_peca'].' - '.$sql->getResult()[0]['descricao_peca']?></td>
        <?else:?>
            <td class="text-left">&nbsp;</td>
        <?endif;?>
        </tr> 
    <?endforeach;endif;?>
    </table>
<?else:?>
<h1 class="text-center text-uppercase alert alert-info" role="alert">nenhum registro encontrado!</h1>
<?endif;
