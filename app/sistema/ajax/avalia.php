<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();
$cria       = new Create();
$texto      = new Check();
$atu        = new Update();

if(isset($busca)):
    $sql->FullRead("SELECT id,status FROM tb_sys006 WHERE patrimonio =:PAT ORDER BY id DESC limit 1","PAT="."{$busca}"."");
    if($sql->getRowCount() > 0):
        $busca = intval($sql->getResult()[0]['id']);
    else:
        $sql->FullRead("SELECT id,status FROM tb_sys006 WHERE os_sti =:OS ","OS="."{$busca}"."");
        if($sql->getRowCount() > 0):
            $busca = intval($sql->getResult()[0]['id']);
        else:
         $busca = "<div class='text-uppercase alert alert-info'><p>Equipamento nao pode ser avaliado!</p>
                    <p><b>Motivo:</b>nenhum registro de entrada encontrado!</p></div>";   
        endif;
    endif;
    if($sql->getResult()):
        switch ($sql->getResult()[0]['status']):
             case 2:
                    print "<span class='text-uppercase alert alert-info'>EQUIPAMENTO BLOQUEADO! POR FAVOR VERIFIQUE!</span>";
                    break;
                case 3:
                    print "<span class='text-uppercase alert alert-info'>NÃO EXISTE ENTRADA EM ABERTO PARA O PATRIMONIO E/OU ORDEM INFORMADO!</span>";
                    break;
                case 4:
                    print "<span class='text-uppercase alert alert-info'>EQUIPAMENTO JÁ FOI AVALIADO!</span>";
                    break;
                case 7:
                    print "<span class='text-uppercase alert alert-info'>BEM INSERVÍVEL!</span>";
                    break;
            default :
                print $busca;
        endswitch;
    else:
        print $busca;
    endif;
endif;

if(isset($id)):
        $sql->FullRead("SELECT 
                        IE.id,
                        IE.status,
                        IE.motivo,
                        IE.observacao,
                        IE.os_sti os,
                        IE.local_uso,
                        E.identrada entrada,
                        E.data,
                        E.nome_responsavel responsavel,
                        T.id idTecnicoEntrada,
                        T.nome tecnico,
                        T.email,
                        C.id categoria,
                        C.descricao equipamento,
                        F.nome_fabricante fabricante,
                        M.modelo,
                        L.local,
                        EQ.ip,
                        EQ.patrimonio,
                        EQ.serie,
                        EQ.id id_equipamento,
                        EQ.so_id,
                        EQ.office_id,
                        EQ.key_so,
                        EQ.key_office,
                        EQ.memoria_ram_id,
                        EQ.processador_id,
                        EQ.hd
                    FROM tb_sys004 EQ
                        JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                        JOIN tb_sys022 M ON M.id_modelo = EQ.modelo
                        JOIN tb_sys005 E ON E.identrada = IE.id_entrada
                        JOIN tb_sys001 T ON T.id = E.id_tecnico
                        JOIN tb_sys008 L ON L.id = EQ.id_local
                        JOIN tb_sys003 C ON C.id = EQ.id_categoria
                        JOIN tb_sys018 F ON F.id_fabricante = EQ.fabricante AND IE.id = :ID", "ID={$id}");
    $categorias=[2,5,17,22,23,26];
    $categoria = $sql->getResult()[0]['categoria'];
   if($sql->getResult()):?>
<div class="avalia">
<!--    <p class="text-capitalize">infomações da entrada</p>-->
    <div class="row">
        <div class="col form-inline">
            <label>Entrada</label>
            <input type="text" value="<?=$sql->getResult()[0]['entrada']?>" class="text-capitalize" disabled="" />
        </div>
        <div class="col form-inline">
            <label>Feita Por</label>
            <input type="text" value="<?=$sql->getResult()[0]['responsavel']?>" class="  text-capitalize" disabled=""/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Data</label>
            <input type="text" value="<?=date("d/m/Y",strtotime($sql->getResult()[0]['data']))?>" class="text-capitalize" disabled="" />
        </div>
        <div class="col form-inline">
            <label>Técnico</label>
            <input type="text" value="<?=$sql->getResult()[0]['tecnico']?>" class="text-capitalize" disabled=""/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>O.S</label>
            <input type="text" value="<?=$sql->getResult()[0]['os']?>" disabled=""/>
        </div>
        <div class="col form-inline">
            <label>Motivo</label>
            <input type="text" value="<?=$sql->getResult()[0]['motivo']?>" class="text-capitalize" disabled=""/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Patrimônio</label>
            <input type="text" id="valPatrimonio" value="<?=$sql->getResult()[0]['patrimonio']?>" class="text-capitalize" disabled="" />
        </div>
        <div class="col form-inline">
            <label>Equipamento</label>
            <input type="text" value="<?=$sql->getResult()[0]['equipamento'].' '.$sql->getResult()[0]['fabricante'].' '.$sql->getResult()[0]['modelo']?>" class="text-capitalize" disabled=""/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Nº de Série</label>
            <input type="text" id="valPatrimonio" value="<?=$sql->getResult()[0]['serie']?>" class="text-capitalize" disabled="" />
        </div>
        <div class="col form-inline">
            <label>Localidade</label>
            <input type="text" value="<?=$sql->getResult()[0]['local']?>" class="text-capitalize" disabled=""  />
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label  style="border-right: none; height: 60px;" >Observação</label>
            <textarea disabled=""><?= ucfirst($sql->getResult()[0]['observacao'])?></textarea>
        </div>
    </div>

    <p class="text-capitalize">infomações adicionais do equipamento</p>
    <?
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
        else:
            $memoria = "";
        endif;
        if($sql->getResult()[0]['processador_id'] !=0):
            $sqlProc = new Read();
            $sqlProc->ExeRead("tb_sys028 WHERE id = {$sql->getResult()[0]['processador_id']}");
            $processador = $sqlProc->getResult()[0]['processador'].' ';
            if($sqlProc->getResult()[0]['geracao']!=0):
                $processador .=$sqlProc->getResult()[0]['geracao'].'ªGeração';
            endif;
        else:
            $processador = "";
        endif;
    ?>
          <div class="row">
        <div class="col form-inline">
            <label>S.O</label>
            <?if(isset($so)):?>
                <input type="text" value="<?=$so?>" class="text-capitalize" style="min-width: 250px;" disabled="" />
            <?else:print "<input type='text' disabled='' style=\"min-width: 250px;\" />";endif;?>
        </div>
        <div class="col form-inline">
            <label>Chave S.O</label>
            <input type="text" value="<?=$sql->getResult()[0]['key_so']?>" class="text-uppercase" disabled=""/>
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
                <input type="text" value="<?=$sql->getResult()[0]['key_office']?>" class="text-uppercase" disabled=""/>
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label>memoria Ram</label>
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
                <label>Processador</label>
                <?if(isset($memoria)):?>
                <input type="text" class="text-capitalize" value="<?=$processador?>" style="min-width: 250px;" disabled="" />
                <?else:print "<input type='text' disabled='' style=\"min-width: 250px;\" />";endif;?>
            </div>
            <div class="col form-inline">
                <label class="text-uppercase text-danger"><b>Padrão</b></label>
                <input type="text" class="text-uppercase text-danger" value="<?=$sql->getResult()[0]['local_uso']?>" style="min-width: 250px; font-weight: bolder;" disabled="" />
            </div>
        </div>
<?elseif($categoria==1):?>
    <div class="row">
        <div class="col form-inline">
            <label>Uso:</label>
            <input type="text" value="<?=$sql->getResult()[0]['ip']?>" class="text-capitalize" style="min-width: 250px;" disabled="" />
        </div>
    </div>
    <?endif;
    if($sql->getResult()[0]['status']==5):
    $agpeca = new Read();
    $agpeca->FullRead("SELECT 
                            T.nome tecnico,
                            A.id,
                            A.data,
                            A.avaliacao,
                            S.descricao status,
                            P.descricao_peca,
                            P.id_peca
                        FROM
                            tb_sys010 A 
                            JOIN tb_sys001 T ON T.id = A.id_tecnico_bancada
                            JOIN tb_sys002 S ON S.id = A.id_status
                            JOIN tb_sys015 P ON P.id_peca = A.peca_id AND A.id_item_entrada = :ID AND A.id_status = :STS", "ID={$id}&STS=5");
    endif;
    if(isset($agpeca)):
        $pecas = $agpeca->getRowCount();
    else:
        $pecas = 0;
    endif;
    $avaBancada = new Read();
    $avaBancada->FullRead("SELECT
                                T.nome tecnico,
                                S.descricao status,
                                A.data,
                                A.hora,
                                A.avaliacao,
                                A.dt_last_update
                            FROM tb_sys010 A
                                JOIN
                                tb_sys001 T ON T.id = A.id_tecnico_bancada
                                JOIN
                                tb_sys002 S ON S.id = A.id_status AND A.id_item_entrada = :ID AND A.id_status != :STS ","ID={$id}&STS=5");
    
  if($pecas > 0 || $avaBancada->getRowCount() > 0):?>
    <p class="text-center text-capitalize">histórico de bancada</p>
    <?if(isset($agpeca)):?>
    <table class="table-hover">
        <tr class="text-capitalize">
            <th style="min-width: 150px;">técnico</th>
            <th class="text-center">data</th>
            <th class="text-center"style="min-width: 120px;">status</th>
            <th>avaliação</th>
            <th style="min-width: 200px;">peça</th>
            <th style="min-width: 100px;">&nbsp;</th>
        </tr>
        <?foreach ($agpeca->getResult() as $agp):?>
        <tr>
            <td  class="text-capitalize"><?=$agp['tecnico']?></td>
            <td class="text-center"><?=date("d/m/Y",strtotime($agp['data']))?></td>
            <td class="text-center text-capitalize"><?=$agp['status']?></td>
            <td><?= ucfirst($agp['avaliacao'])?></td>
            <td  class="text-capitalize"><?=$agp['id_peca'].' - '.$agp['descricao_peca']?></td>
            <?if($agp['status'] != 'fechado'):?>
            <td class="text-center" style="width: 110px;">
                <?if($_SESSION['UserLogado']['grupo_id'] == 4):?>
                <button onclick="buscaAvaliacao(<?=$agp['id']?>);">Editar</button>
                <?endif;?>
                <button onclick="baixaPeca(<?=$agp['id_peca']?>,<?=$sql->getResult()[0]['os']?>,<?=$sql->getResult()[0]['id']?>);">Baixar</button>
            </td>
            <?endif;?>
        </tr>
        <?endforeach;?>
    </table>
    <div class="edita-avaliacao"></div>
    <?endif;?><!-- fim aguardo de peça -->
    <!-- outras avaliações de bancada-->
    <hr />
    <?if($avaBancada->getRowCount() > 0):?>
    <table class="table-hover">
        <tr class="text-capitalize">
            <th style="min-width: 150px;">técnico</th>
            <th class="text-center">data</th>
            <th class="text-center"style="min-width: 120px;">status</th>
            <th>avaliação</th>
            <th>Atualização</th>
        </tr>
        <?foreach ($avaBancada->getResult() as $ava):?>
        <tr class="text-left">
            <td class="text-capitalize"><?=$ava['tecnico']?></td>
            <td class="text-center"><?=date("d/m/Y",strtotime($ava['data']))?></td>
            <td class="text-capitalize text-center"><?=$ava['status']?></td>
            <td><?= ucfirst($ava['avaliacao'])?></td>
            <td><?= date("d/m/Y H:i:s",strtotime($ava['dt_last_update']))?></td>
        </tr>
        <?endforeach;?>
    </table>
        <?endif;
        endif;
    endif;//fim outras avaliações de bancada?>
    <hr />
    <form id="form-avalia-equipamento" onsubmit="return false;" >
        <input type="hidden" name="id_item_entrada" value="<?=$sql->getResult()[0]['id']?>" />
        <input type="hidden" name="id_tecnico_bancada" value="<?=ID_TECNICO?>" />
        <input type="hidden" name="email_tecnico_entrada" value="<?=$sql->getResult()[0]['email']?>" />
        <div class="row">
            <div class="col form-inline">
                <select id="txtStatus" name="id_status" class="text-capitalize" onchange="validaAvaliacao(this.value,<?=$categoria?>,<?=$sql->getResult()[0]['id_equipamento']?>,<?=$pecas?>,'<?=$_SESSION['UserLogado']['tipo']?>')" style="max-width:165px; " >
                    <option value="">Avaliar...</option>
                    <?$sql->ExeRead("tb_sys002");
                    foreach ($sql->getResult() as $res):
                        if($res['id'] <= 3):
                            continue;
                        else:?>
                        <option value="<?= $res['id'] ?>"><?=$res['descricao']?></option>
                    <? endif;endforeach;?>
                </select>
            </div>
             <div class="col form-inline aguardo-peca" style="display: none">
                <label>Peça</label>
                <input type="text" id="txtCodPeca" onblur="setaPeca(this.value,'true');" onkeyDown="if (event.keyCode == 13){$('#txtAvalia').focus();}" placeholder="Código..." size="3" autofocus="" style="max-width: 190px;"/>
                    <select id="txtPeca" name="peca_id" onkeydown="if (event.keyCode === 13) {
                                       $('#txtAndar').focus();
                                   }" onchange="setaPeca(this.value);$('#txtAvalia').focus();" class="text-capitalize" style="width: 60%; min-width: 300px;">
                        <option value="" class="localidade">Selecione</option>                        
                        <?$sql->FullRead("SELECT id_peca,descricao_peca FROM tb_sys015 WHERE categoria_id = :CATEG ORDER BY descricao_peca","CATEG={$categoria}");foreach($sql->getResult()as $peca):?>
                        <option value="<?= $peca['id_peca'] ?>" class="localidade"><?= $peca['descricao_peca']; ?></option>
                        <?endforeach;?>
                    </select>
            </div>
            <div class="col form-inline avaliacao" style="display: none">
                <label  style="border-right: none; height: 60px;" >Avaliação</label>
                <textarea id="txtAvalia" name="avaliacao"></textarea>
            </div>
        </div>
        <div class="row text-center">
            <div class="col btn-avalia" style="display: none;margin: 0 auto;">
                <button type="button" class="btn btn-primary" onclick="avalia($('#txtStatus').val(),$('#txtAvalia').val(),$('#txtPeca').val())">Avaliar Equipamento</button>

               <button class="btn btn-primary" onclick="window.location.reload();">Cancelar Avaliação</button>
            </div>
        </div>
    </form>
</div>
 <?endif;
