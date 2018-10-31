<?php
paginaSegura();
$sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#cad-entrada" id="nentrada">Entrada de Equipamento</a></li>
    </ul>
    <div id="cad-entrada">
        <form class="form-cadastra titulo-entrada entrada" id="form-cria-entrada" onsubmit="return false;" >
            <input type="hidden" id="numeroEntrada" value="" />
            <div class="row">
                <div class="col-md form-inline">
                     <label>Responsavel &nbsp;</label>
                    <input type="text" size="30" class="text-capitalize" disabled="" id="txtResp" name="responsavel" value="<?=$_SESSION['UserLogado']['nome']?>" />
                </div>
                <div class="col-md form-inline">
                    <label>Entregue Por </label>
                    <select onchange="checaSaidaEntrada(this.value);" id="chooseSaida" style="width: 115px;">
                        <option selected="" value="">Selecione...</option>
                        <option value="tecnico">Técnico</option>
                        <option value="funcionario">Funcionário</option>
                    </select>
                    &nbsp;&nbsp;
                    <select name="id_tecnico" id="txtTecnico" style="display: none; width: 250px;" onchange="verificaEntrada(this.value)">
                        <?php $sql->FullRead("SELECT id,nome FROM tb_sys001 WHERE situacao ='l' ORDER BY nome"); ?>
                         <option selected value="">Selecione...</option>
                         <?php foreach ($sql->getResult() as $res):
                         print "<option value=".$res['id'].">".ucfirst($res['nome'])."</option>";
                         endforeach;
                        ?>
                    </select>
                    <span id="txtFunc" style="display: none; margin-top: -3px;">
                        <input type="text" size="5" name="doc_fun" id="txtDocFun" placeholder="IF/RG.." />
                        <input type="text" name="nome_fun" id="txtNomeFun"  placeholder="Nome Completo..." />
                        <input type="button" value="ok" style="height: 25px; padding: 0; width: 30px; border: 1px solid #09f;" onclick="verificaEntrada(<?=$_SESSION['UserLogado']['id']?>);" />
                    </span>
                </div>
            </div>
        </form>     
        <form class="form-cadastra entrada" id="iten-entrada" onsubmit="return false;" style="display: none;">
        <hr />
            <div class="row">
                <div class="col form-inline">
                    <label>O.S</label>
                    <input type="text" id="txtOs" name="os_sti" onkeydown="if(event.keyCode === 13){$('#txtPatrimonio').focus()}"/>
                </div>
                <div class="col form-inline">
                    <label>Patrimônio</label>
                    <input type="text" id="txtPatrimonio" name="patrimonio" maxlength="7" onblur="checaCadastroPatrimonio(this.value)" onkeydown="if(event.keyCode === 13){$('#txtMotivo').focus()}"/>
                </div>
            </div>
            <div class="row">
                <div class="col form-inline">
                    <label>Equipamento</label>
                    <select class="text-capitalize" id="txtEquipamento" name="id_categoria" style="max-width: 200px;">
                        <?php $sql->ExeRead("tb_sys003"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".ucfirst($res['descricao'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col form-inline">
                    <label>Fabricante</label>
                    <select class="text-capitalize" id="txtFabricante" name="fabricante" onchange="getModelos(this.value);" onblur="getModelos(this.value);" style="max-width: 203px;">
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
                   <select id="txtModelo" name="modelo" class="text-capitalize" style="max-width: 250px;">
                       <option selected value="" class="cmbv_modelos">Selecione</option>
                   </select>
                </div>
                <div class="col form-inline">
                    <label>Checklist</label>
                    <input type="text" id="txtChecklist" name="checklist" />
                </div>

            </div>
            <div class="row">
                <div class="col form-inline">
                   <label>Localidade</label>
                   <input type="text" id="txtCr" onblur="setaLocalidade(this.value,true);" style="width: 20px;" />-<select id="txtLocalidade" name="id_local" onkeydown="if (event.keyCode === 13){$('#txtAndar').focus();}" class="text-capitalize" style="width: calc(100% - 300px);">
                        <option selected value="" class="localidade">Selecione...</option>                        
                        <?$sql->FullRead("SELECT id,local FROM tb_sys008 ORDER BY local");
                        foreach($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".$res['local']."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col form-inline">
                    <label>Andar</label>
                    <input type="text" id="txtAndar" name="andar" size="5" maxlength="10" class="text-capitalize" onkeydown="if(event.keyCode === 13){$('#txtSala').focus();}" placeholder="Andar..." style="margin-right: 10px;"/>
                    <label style="width: 50px;">Sala</label>
                    <input type="text" id="txtSala" name="sala" size="15" maxlength="20" class="text-capitalize" onkeydown="if(event.keyCode === 13){$('#txtMotivo').focus();}" placeholder="Sala..." />
                </div>
            </div>
            <div class="row">
                <div class="col form-inline">
                    <label>Motivo</label>
                    <select id="txtMotivo" name="motivo" class="text-capitalize" onkeydown="if (event.keyCode === 13){$('#txtObservacoes').focus();}" style="width: 300px;">
                        <option selected value="">Selecione</option>  
                        <optgroup label="Motivos Gerais">
                            <?$sql->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=0");
                            foreach ($sql->getResult() as $mg):?>
                                <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                            <?endforeach;?>
                        </optgroup>
                        <optgroup label="Computador">
                            <?$sql->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=2");
                            foreach ($sql->getResult() as $mg):?>
                                <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                            <?endforeach;?>
                        </optgroup>
                        <optgroup label="Estabilizador">
                            <?$sql->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=3");
                            foreach ($sql->getResult() as $mg):?>
                                <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                            <?endforeach;?>
                        </optgroup>
                        <optgroup label="Impressora">
                            <?$sql->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=1");
                            foreach ($sql->getResult() as $mg):?>
                                <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                            <?endforeach;?>
                        </optgroup>
                        <optgroup label="Monitor">
                            <?$sql->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=4");
                            foreach ($sql->getResult() as $mg):?>
                                <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                            <?endforeach;?>
                        </optgroup>                            
                    </select>     
                </div>
                <div class="col form-inline">
                    <label>Local de Uso</label>
                    <select name="local_uso" style="width: 200px;" >
                        <option selected="" value="">Selecione</option>
                        <option value="rede laboratorio">Rede Laboratorio</option>
                        <option value="rede adm (AD)">Rede Adm (AD)</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col form-inline">
                    <label for="txtObservacoes">Observações</label>
                    <textarea id="txtObservacoes" name="observacao" wrap="hard"></textarea>
                </div>

                <div class="col btn-entrada">
                    <div>
                        <button type="button" onclick="validaItemEntrada($('#txtTecnico').val(),$('#numeroEntrada').val(),$('#txtEquipamento').val()); $('#iten-entrada').submit();">Adicionar Equipamento</button>
                    </div>
                    <div>
                        <button type="button" onclick="finalizaEntrada($('#numeroEntrada').val(),'<?=$_SESSION['UserLogado']['email']?>','<?=$_SESSION['UserLogado']['nome']?>');" >Finalizar Entrada</button>
                        <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                    </div>
                </div>
            </div>
        <hr />
        </form>
        <div id="resposta-entrada" class="row">
        
        </div>
    </div>
    </div>
</div>