<?php
    require_once './app/config/pagina-segura.php';
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-equipamento">Cadastrar Equipamento</a></li>
    </ul>
    <div id="cad-equipamento">
        <h2>Dados do Equipamento</h2>
        <form name="cadastra-equipamento" class="form-cadastra" action="javascript:void(0);">
            <div class="row">
                <div class="col-md form-inline">
                    <label>equipamento</label>
                    <select class="form-control" id="txtEqpmt" onchange="setCadEquipamento(this.value)">
                        <?php $sql->ExeRead("tb_sys003"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".ucfirst($res['descricao'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md form-inline">
                    <label>fabricante</label>
                    <select class="form-control" id="txtFab" onchange="getModelos(this.value);" onblur="getModelos(this.value);">
                        <?php $sql->FullRead("SELECT FAB.id_fabricante,FAB.nome_fabricante FROM tb_sys022 MDL JOIN tb_sys018 FAB ON FAB.id_fabricante = MDL.fabricante_id GROUP BY FAB.id_fabricante"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id_fabricante'].">".ucfirst($res['nome_fabricante'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                   <label>modelo</label>
                   <select class="form-control" id="txtModelo" disabled="">
                       <option selected value="" class="cmbv_modelos">Selecione</option>
                   </select>
                </div>
                
                <div class="col-md form-inline">
                    <label>Série</label>
                    <input type="text" id="txtSerie" class="form-control" size="8" required="" placeholder="Nº de Série" />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>patrimônio</label>
                    <input type="text" id="txtPatrimonio" class="form-control" size="12" placeholder="Patrimônio..." />
                </div>
   
                <div class="col-md form-inline cmb-localidade">
                    <label>Localidade</label>
                   <select class="form-control" id="txtLocalidade">
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
                    <div class="col-md form-inline">
                        <label>IP</label>
                        <input type="text" id="txtIp" class="form-control" size="12" placeholder="IP..." />
                    </div>
                     
                </div>
            </div><!-- fim campos impressora --> 
            
            <div class="opcao-cad-cpu"> <!-- campos CPU --> 
                <hr />
                <p class="text-center">Dados Opcionais</p>
                <hr />
                <div class="row" >
                    <div class="col-md form-inline">
                        <label title="Sistema Operacional">S.O</label>
                        <select class="form-control" id="txtSo">
                            <?php $sql->ExeRead("tb_sys025"); ?>
                            <option selected value="">Selecione...</option>
                            <?php foreach ($sql->getResult() as $res):
                                print "<option value=".$res['id'].">".ucfirst($res['descricao_so'].' '.$res['versao_so'].' '.$res['arquitetura_so'])."</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                     <div class="col-md form-inline">
                        <label title="Chave de Ativação">Chave</label>
                        <input type="text" id="txtKeySo" class="form-control m_key" size="25"placeholder="Chave de Ativação Windows" />
                    </div>
                </div>
                <div class="row" >
                    <div class="col-md form-inline">
                        <label title="Office">Office</label>
                        <select class="form-control" id="txtOffice">
                            <?php $sql->ExeRead("tb_sys026"); ?>
                            <option selected value="">Selecione...</option>
                            <?php foreach ($sql->getResult() as $res):
                                print "<option value=".$res['id'].">".ucfirst($res['descricao_office'].' '.$res['versao_office'].' '.$res['arquitetura_office'])."</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                     <div class="col-md form-inline">
                        <label title="Chave de Ativação do Office">Chave</label>
                        <input type="text" id="txtKeyOffice" class="form-control m_key" size="25"placeholder="Chave de Ativação Office" />
                    </div>
                </div>
                <div class="row" >
                    <div class="col-md form-inline">
                        <label title="Office">Memória</label>
                        <input type="text" id="txtMemoria" class="form-control " size="5"placeholder="ram..." />
                    </div>
                     <div class="col-md form-inline">
                        <label title="Chave de Ativação do Office">HD</label>
                        <input type="text" id="txtHd" class="form-control " size="5"placeholder="hd..." />
                    </div>
                </div>
            </div><!-- Fim campos CPU --> 
            <div class="opcao-cad-monitor"><!-- opção Monitor -->
                <hr />
                <p class="text-center">Dados Opcionais</p>
                <hr />
                <div class="row">
                    <div class="col-md form-inline">
                        <label title="Office">Tela</label>
                        <input type="text" id="txtTela" class="form-control " size="5"placeholder="pol.." />
                    </div>
                    <div class="col-md form-inline">
                        <label title="Chave de Ativação do Office">Tipo Tela</label>
                        <select class="form-control" id="txtTipoTela">
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
                    <div class="col-md form-inline">
                        <label>Volt-Ampere</label>
                        <input type="text" id="txtVa" class="form-control" size="8" placeholder="(VA)" />
                    </div>
                </div>
            </div><!-- fim Opção estabilizador --> 
            <hr />
            <div class="row">
                <div class="col-md form-inline">
                    <button type="button" class="btn btn-primary" onclick="cadastra('equipamento')">Cadastrar</button>
                    &nbsp;&nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                </div>
                <div class="col-md form-inline">
                    <button type="button" class="btn btn-primary" onclick="history.back()">Cancelar</button>
                </div>
            </div>
            <hr />
        </form>
    </div>
</div>