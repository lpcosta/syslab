<?php
    paginaSegura();
    $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#r-e-e">Relatório de Entrada de Equipamento </a></li>
    </ul>
    <div id="r-e-e" class="header-report">
        <form id="form-header-report-entrada" onsubmit="return false">
            <input type="hidden" name="acao" value="entrada" />
            <div class="row">
                <div class="col form-inline">
                    <label>Tipo de Relatório</label>
                    <select id="tipoRel" name="tipoRel" onchange="setaTipoRel(this.value);" style="width: 150px;">
                        <option selected value="codigo">Nº da Entrada</option>
                        <option value="tecnico">Técnico</option>
                        <option value="periodo">Período</option>
                    </select>
                </div>
                <div class="col form-inline">
                    <div class="cod-rel form-inline">
                        <label>Nº da Entrada</label>
                        <input type="text" name="id_entrada" id="txtCodEntrada" placeholder="Nº Entrada..." onkeydown="if(event.keyCode == '13'){validaRelatorio('entrada','#form-header-report-entrada');}" />
                    </div>
                    <div class="tecnico-rel form-inline" style="display: none;">
                        <label></label>
                        <select name="id_tecnico" id="txtTecnico" class="text-capitalize" style="width: 100%;">
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
                    <input type="button" class="btn btn-primary" value="Gerar Relatório" onclick="validaRelatorio('entrada','#form-header-report-entrada')" style="margin-right: 5px;">
                    
                    <span style="width: 38px;"><img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /></span>
                    
                    <button type="button" class="btn btn-primary" onclick="imprime();">Imprimir</button>
                
                </div>
            </div>
            <hr />
        </form>
    </div>
<?if(isset($_GET['id'])):
    require_once './app/config/get.inc.php';
    if(!empty($id)):
        $sql->ExeRead("tb_sys005 WHERE identrada ={$id}");
        $entrada = $sql->getRowCount();
        if($sql->getRowCount() > 0):
             $sql->FullRead("SELECT nome,data,hora,nome_fun,doc_fun,nome_responsavel FROM tb_sys005 entrada
                            JOIN tb_sys001 tecnico ON tecnico.id = entrada.id_tecnico AND entrada.identrada = :ID ","ID={$id}");
            $dadosTecnico = $sql->getResult()[0];
            $sql->FullRead("SELECT EQ.patrimonio, C.descricao equipamento,IE.os_sti,L.local,L.rua,L.bairro,F.nome_fabricante fabricante,M.modelo,EQ.andar,EQ.sala
                            FROM tb_sys004 EQ
                                JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                                JOIN tb_sys022 M  ON M.id_modelo = EQ.modelo
                                JOIN tb_sys003 C  ON C.id = EQ.id_categoria
                                JOIN tb_sys008 L  ON L.id = EQ.id_local
                                JOIN tb_sys018 F  ON F.id_fabricante = EQ.fabricante
                                JOIN tb_sys005 E  ON E.identrada = IE.id_entrada AND  E.identrada= :ID","ID={$id}");
            $dtperiodo = 'data';  
        endif;
    endif;
endif;
?>
    <div id="printArea" class="relatorio printTable">
        <?if(isset($entrada) && $entrada > 0):?>
        <table class="relatorio">
            <tr>
                <th rowspan="5" style="width:110px;"><img src="<?= LOGO_PSA ?>"/></th>
            </tr>
            <tr>
                <th colspan="2" class="text-center text-uppercase"><?= PREFEITURA ?></th>
                <th rowspan="4" style="width:110px;">&nbsp;</th>
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
                <th colspan="4" class="text-center text-uppercase">entrada de equipamento</th>
            </tr>
            <tr>
                <td colspan="5">
                    <table class="relatorio">
                        <tr class="left">
                            <td><b>Entrada</b></td>
                            <td><?=$id?></td>
                            <td><b>Data</b></td>
                            <td><?=date("d/m/Y",strtotime($dadosTecnico['data'])).' '.$dadosTecnico['hora']?></td>
                        </tr>
                        <tr class="left">
                            <td><b>Feita Por</b></td>
                            <td class="text-capitalize"><?=$dadosTecnico['nome_responsavel']?></td>
                            <td><b>Em Nome de</b></td>
                        <?if(empty($dadosTecnico['nome_fun'])):?>
                            <td colspan="2" class="text-capitalize"><?=$dadosTecnico['nome']?></td>
                        <?elseif(!empty($dadosTecnico['nome_fun'])):?>
                            <td colspan="2" class="text-capitalize"><?=$dadosTecnico['nome_fun'].' <b>RG/IF</b> '.$dadosTecnico['doc_fun']?></td>
                        <?endif;?>
                        </tr>
                    </table>                    
                </td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">            
                    <table class="relatorio">
                        <tr>
                            <th class="text-center">OS</th>
                            <th class="text-center">PATRIMONIO</th>
                            <th class="left" style="min-width:180px;">EQUIPAMENTO</th>
                            <th class="left">LOCAL</th>
                            <th class="left">ENDEREÇO</th>
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
        <table class="relatorio" style="margin-top:50px;">
            <tr>
                <th class="text-center">_______________________________________</th>

                <th class="text-center">_______________________________________</th>
            </tr>
            <tr>
                <th class="text-center">Técnico</th>

                <th class="text-center">Responsável</th>
            </tr>
        </table>
        <?endif;?>
    </div>
</div>