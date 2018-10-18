<?php
   paginaSegura();
  $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#r-e-e">Relatório de Saída de Equipamento </a></li>
    </ul>
    <div id="r-e-e" class="header-report">
        <form id="form-header-report-saida" onsubmit="return false">
            <input type="hidden" name="acao" value="saida" />
            <div class="row">
                <div class="col form-inline">
                    <label>Tipo de Relatório</label>
                    <select id="tipoRel" name="tipoRel" onchange="setaTipoRel(this.value);">
                        <option selected value="codigo">Nº da Saída</option>
                        <option value="tecnico">Técnico</option>
                        <option value="periodo">Período</option>
                    </select>
                </div>
                <div class="col form-inline">
                    <div class="cod-rel form-inline">
                        <label>Nº da Saída</label>
                        <input type="text" name="id_saida" id="txtCodSaida" placeholder="Nº saída..." />
                    </div>
                    <div class="tecnico-rel form-inline" style="display: none;">
                        <label></label>
                        <select name="id_tecnico" id="txtTecnico" class="text-capitalize">
                            <option selected value="">Selecione...</option>
                            <?$sql->FullRead("SELECT id,nome FROM tb_sys001 WHERE situacao = :SIT ORDER BY nome","SIT=".'l'."");
                            foreach ($sql->getResult() as $res):?>
                            <option value="<?=$res['id']?>" class="text-capitalize"><?=$res['nome']?></option>   
                            <?endforeach;?>
                        </select>
                    </div>
                     <div class="periodo-rel form-inline" style="display: none;">
                        <label>Data Inicial</label>
                        <input type="text"  name="dt_inicial" id="dtInicial" class="data" />
                            &nbsp;&nbsp;
                        <label>Data Final</label>
                        <input type="text"  name="dt_final" id="dtFinal" class="data" />
                    </div>
                </div>
                <div class="col form-inline">
                    <input type="button" class="btn btn-primary" value="Gerar Relatório" onclick="validaRelatorio('saida','#form-header-report-saida')" style="margin-right: 5px;">
                    
                    <span style="width: 38px;"><img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /></span>
                    
                    <button type="button" class="btn btn-primary btnPrinter" onclick="imprimi();">Imprimir</button>
                
                </div>
            </div>
            <hr />
        </form>
    </div>
<?if(isset($_GET['id'])):
    $getId    = filter_input_array(INPUT_GET,FILTER_DEFAULT);
    $setget    = array_map("strip_tags", $getId);
    $get    = array_map("trim", $setget);
extract($get);
unset($get['pg']);
    $sql->ExeRead("tb_sys007 WHERE id ={$id}");
    $entrada = $sql->getRowCount();
        if($sql->getRowCount() > 0):
             $sql->FullRead("SELECT nome,data,hora,nome_fun,doc_fun FROM tb_sys007 saida
                            JOIN tb_sys001 tecnico ON tecnico.id = saida.id_tecnico AND saida.id = :ID ","ID={$id}");
            $dadosTecnico = $sql->getResult()[0];
            $sql->FullRead("SELECT EQ.patrimonio, C.descricao equipamento,IE.os_sti,L.local,L.rua,L.bairro,F.nome_fabricante fabricante,M.modelo,EQ.andar,EQ.sala
                            FROM tb_sys004 EQ
                                JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                                JOIN tb_sys022 M ON M.id_modelo = EQ.modelo
                                JOIN tb_sys003 C ON C.id = EQ.id_categoria
                                JOIN tb_sys008 L ON L.id = EQ.id_local
                                JOIN tb_sys018 F ON F.id_fabricante = EQ.fabricante
                                JOIN tb_sys009 ISA ON ISA.id_item_entrada = IE.id
                                JOIN tb_sys007 S ON S.id = ISA.id_saida AND  ISA.id_saida= :IDSAIDA","IDSAIDA={$id}");
            $dtperiodo = 'data';  
        endif;
endif;
?>
    <div class="relatorio printTable">
        <?if(isset($id) && $entrada > 0):?>
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
                <th colspan="4" class="text-center text-uppercase">saída de equipamento</th>
            </tr>
            <tr class="text-uppercase">
                <th>Saída nº</th>
                <td colspan="2"><?=$id?></td>
            </tr>
            <tr class="text-uppercase">
                <th>técnico</th>
                <td colspan="2"><?=$dadosTecnico['nome']?></td>
            </tr>
            <tr class="text-uppercase">
                <th><?=$dtperiodo?></th>
                <td colspan="2"><?=date("d/m/Y",strtotime($dadosTecnico['data'])).' '.$dadosTecnico['hora']?></td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">            
                    <table class="table-hover">
                        <tr>
                            <th class="text-center">OS</th>
                            <th class="text-center">PATRIMONIO</th>
                            <th>EQUIPAMENTO</th>
                            <th>LOCAL</th>
                            <th>ENDEREÇO</th>
                        </tr>
                        <? foreach ($sql->getResult() as $res):?>
                        <tr class="text-capitalize">
                            <td class="text-center"><?=$res['os_sti']?></td>
                            <td class="text-center"><?=$res['patrimonio']?></td>
                            <td><?=$res['equipamento'] . ' ' . $res['fabricante'] . ' ' . $res['modelo'];?></td>
                            <td><?=$res['local']?></td>
                            <td><?=$res['rua'].' '.$res['andar'];if(!empty($res['sala'])){print " - Sala ".$res['sala'];}?></td>
                        </tr>
                        <? endforeach;?>
                    </table>
                </td>
            </tr>
        </table>
        <?endif;?>
    </div>
</div>