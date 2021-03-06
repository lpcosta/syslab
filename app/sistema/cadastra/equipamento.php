<?php
 paginaSegura();
    
$sql = new Read();

?>
<script src="../../libs/JQuery-Masked-Input/src/jquery.maskedinput.js"></script>
<div class="tabs">
    <ul>
        <li><a href="#cad-equipamento">Cadastrar Equipamento</a></li>
    </ul>
    <div id="cad-equipamento">
        <h2>Dados do Equipamento</h2>
        <form name="cadastra-equipamento" id="cad-equip" class="form-cadastra" onsubmit="return false;">
            <input type="hidden" name="acao" value="equipamento" />
            <div class="row">
                <div class="col form-inline">
                    <label>equipamento</label>
                    <select class="form-control" id="txtEqpmt" name="id_categoria" onchange="setCadEquipamento(this.value)">
                        <?php $sql->ExeRead("tb_sys003"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".ucfirst($res['descricao'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col form-inline">
                    <label>fabricante</label>
                    <select class="form-control" id="txtFab" name="fabricante" onchange="getModelos(this.value);" onblur="getModelos(this.value);">
                        <?php $sql->FullRead("SELECT FAB.id_fabricante,FAB.nome_fabricante FROM tb_sys022 MDL JOIN tb_sys018 FAB ON FAB.id_fabricante = MDL.fabricante_id GROUP BY FAB.id_fabricante ORDER BY FAB.nome_fabricante"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id_fabricante'].">".ucfirst($res['nome_fabricante'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col form-inline">
                   <label>modelo</label>
                   <select class="form-control" id="txtModelo" name="modelo">
                       <option selected value="" class="cmbv_modelos">Selecione</option>
                   </select>
                </div>
                
                <div class="col form-inline">
                    <label>Série</label>
                    <input type="text" id="txtSerie" name="serie" class="form-control" size="8" placeholder="Nº de Série" />
                </div>
            </div>
            <div class="row">
                <div class="col form-inline">
                    <label>patrimônio</label>
                    <input type="text" id="txtPatrimonio" name="patrimonio" maxlength="7" value="<?if(isset($_GET['p'])){print $_GET['p'];}?>" class="form-control" size="12" placeholder="Patrimônio..." />
                </div>
   
                <div class="col form-inline cmb-localidade">
                    <label>Localidade</label>
                    <select class="form-control" id="txtIdLocal" name="id_local">
                        <?php $sql->FullRead("SELECT id,local FROM tb_sys008 ORDER BY local"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".ucfirst($res['local'])."</option>";
                        endforeach;
                        ?>
                   </select>
                </div>
            </div>
           
            <div class="opcao-cad-printer"> <!-- opção impressora -->
                <hr />
                <p class="text-center">Dado Opcional</p>
                <hr />
                <div class="row" >
                    <div class="col form-inline">
                        <label>IP</label>
                        <input type="text" id="txtIp" name="ip" class="form-control" size="15" maxlength="15" placeholder="IP..."/>
                    </div>
                     
                </div>
            </div><!-- fim campos impressora --> 
            
            <div class="opcao-cad-cpu"> <!-- campos CPU --> 
                <hr />
                <p class="text-center">Dados Opcionais</p>
                <hr />
                <div class="row" >
                    <div class="col form-inline">
                        <label title="Sistema Operacional">S.O</label>
                        <select class="form-control" id="txtSo" name="so_id">
                            <?php $sql->ExeRead("tb_sys025"); ?>
                            <option selected value="">Selecione...</option>
                            <?php foreach ($sql->getResult() as $res):
                                print "<option value=".$res['id_so'].">".ucfirst($res['descricao_so'].' '.$res['versao_so'].' '.$res['arquitetura_so'])."</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                     <div class="col form-inline">
                        <label title="Chave de Ativação">Chave</label>
                        <input type="text" id="txtKeySo" name="key_so" class="form-control" size="33" maxlength="30" placeholder="Chave de Ativação Windows" />
                    </div>
                </div>
                <div class="row" >
                    <div class="col form-inline">
                        <label title="Office">Office</label>
                        <select class="form-control" id="txtOffice" name="office_id">
                            <?php $sql->ExeRead("tb_sys026"); ?>
                            <option selected value="">Selecione...</option>
                            <?php foreach ($sql->getResult() as $res):
                                print "<option value=".$res['id_office'].">".ucfirst($res['descricao_office'].' '.$res['versao_office'].' '.$res['arquitetura_office'])."</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                     <div class="col form-inline">
                        <label title="Chave de Ativação do Office">Chave</label>
                        <input type="text" id="txtKeyOffice" name="key_office" class="form-control" size="33" maxlength="30" placeholder="Chave de Ativação Office" />
                    </div>
                </div>
                <div class="row" >
                    <div class="col form-inline">
                        <label title="Office">Memória</label>
                        <select id="txtMemoria" name="memoria_ram_id" class="form-control text-uppercase">
                            <option selected="" value="">Selecione...</option>
                        <?$sql->ExeRead("tb_sys029");foreach($sql->getResult() as $mem):?>
                            <option value="<?=$mem['id']?>"><?=$mem['tipo_memoria'].' '.$mem['capacidade']?></option>    
                        <?endforeach;?>
                        </select>
                        &nbsp;
                        <label title="HD" style="width: 20px;">HD</label>
                        <select id="txtHd" name="hd" class="form-control">
                            <option selected="" value="">Selecione...</option>
                            <option value="80gb">80GB</option>
                            <option value="160gb">160GB</option>
                            <option value="320gb">320GB</option>
                            <option value="480gb">480GB</option>
                            <option value="500gb">500GB</option>
                            <option value="720gb">720GB</option>
                            <option value="1tb">1TB</option>
                        </select>
                    </div>
                    <div class="col form-inline">
                        <label>Processador</label>
                        <select id="txtProcessador" name="processador_id" class="form-control">
                            <option selected="" value="">Selecione...</option>
                        <?$sql->ExeRead("tb_sys028");foreach($sql->getResult() as $proc):?>
                            <option value="<?=$proc['id']?>"><?=$proc['processador'].' ';if($proc['geracao']!=0){print $proc['geracao'].'ª Geração';}?></option> 
                        <?endforeach;?>
                        </select>
                    </div>
                </div>
            </div><!-- Fim campos CPU --> 
            <div class="opcao-cad-monitor"><!-- opção Monitor -->
                <hr />
                <p class="text-center">Dados Opcionais</p>
                <hr />
                <div class="row">
                    <div class="col form-inline">
                        <label title="Office">Tela</label>
                        <input type="text" id="txtTela" name="tela" class="form-control " size="5"placeholder="pol.." />
                    </div>
                    <div class="col form-inline">
                        <label title="Chave de Ativação do Office">Tipo Tela</label>
                        <select class="form-control" id="txtTipoTela" name="tipo_tela">
                            <option selected value="">Selecione...</option>
                            <option value="normal">Normal</option>
                            <option value="wide">WideScreen</option>
                            <option value="super-wide">Super Wide-Screen</option>
                        </select>
                    </div>
                </div>
            </div><!-- Fim opção Monitor -->
            <div class="opcao-cad-estabilizador"> <!-- opção Estabilizador -->
                <hr />
                <p class="text-center">Dado Opcional</p>
                <hr />
                <div class="row" >
                    <div class="col form-inline">
                        <label>Volt-Ampere</label>
                        <input type="text" id="txtVa" name="va" class="form-control" size="8" placeholder="(VA)" />
                    </div>
                </div>
            </div><!-- fim Opção estabilizador --> 
            <hr />
            <div class="row">
                <div class="col form-inline">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    &nbsp;&nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                </div>
                <div class="col form-inline">
                    <button type="button" class="btn btn-primary" onclick="history.back()">Cancelar</button>
                </div>
            </div>
            <hr />
        </form>
    </div>
</div>