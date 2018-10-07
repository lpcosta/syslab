<?php
   paginaSegura();
    $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#cad-entrada" id="nentrada">
                Entrada de Equipamento
            </a></li>
    </ul>
    <div id="cad-entrada">
        <form class="form-cadastra titulo-entrada entrada" onsubmit="return false;">
            <input type="hidden" id="numeroEntrada" value="" />
            <div class="row">
                <div class="col-md form-inline">
                     <label>Responsavel &nbsp;</label>
                    <input type="text" size="30" class="text-capitalize" disabled="" id="txtResp" name="responsavel" value="<?=$_SESSION['UserLogado']['nome']?>" />
                </div>
                <div class="col-md form-inline">
                    <label>Técnico &nbsp;</label>
                    <select id="txtTecnico" name="tecnico" onchange="verificaEntrada(this.value)">
                         <?php $sql->FullRead("SELECT id,nome FROM tb_sys001 WHERE situacao ='l' ORDER BY nome"); ?>
                         <option selected value="">Selecione...</option>
                         <?php foreach ($sql->getResult() as $res):
                         print "<option value=".$res['id'].">".ucfirst($res['nome'])."</option>";
                         endforeach;
                         ?>
                    </select>
                </div>
            </div>
        </form>     
    <form class="form-cadastra entrada" id="iten-entrada" onsubmit="return false;" style="display: none;">
        <hr />
            <h2>Entrada de Equipamento</h2>
        <div class="row">
            <div class="col form-inline">
                <label>O.S</label>
                <input type="text" id="txtOs" name="txtOs" onkeydown="if(event.keyCode === 13){$('#txtPatrimonio').focus()}"/>
            </div>
            <div class="col form-inline">
                <label>Patrimônio</label>
                <input type="text" id="txtPatrimonio" name="txtPatrimonio" maxlength="7" onblur="checaCadastroPatrimonio(this.value)" onkeydown="if(event.keyCode === 13){$('#txtMotivo').focus()}"/>
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label>Equipamento</label>
                <input type="text" class="text-capitalize" id="txtEquipamento"/>
            </div>
            <div class="col form-inline">
               <label>modelo</label>
               <select id="txtModelo" class="text-capitalize">
                   <option selected value="" class="cmbv_modelos">Selecione</option>
               </select>
            </div>
        </div>
        <div class="row">
           <div class="col form-inline">
                <label>Fabricante</label>
                <input type="text" id="txtFabricante" class="text-capitalize"/>
            </div>
            <div class="col form-inline">
                <label>Checklist</label>
                <input type="text" id="txtChecklist" name="txtChecklist" />
            </div>
            
        </div>
<!--        <div class="row mostra-dados-printer" style="display: none;">
            <div class="col form-inline">
                <label>USB/IP</label>
                <select name="ip" id="txtIp">
                     <option selected value="">Selecione...</option>
                     <option value="ip">Rede</option>
                     <option value="usb">Usb</option>
                 </select>
            </div>
            <div class="col form-inline">
                 <label>Veio Toner?</label>
                 <select>
                     <option selected value="">Selecione...</option>
                     <option value="sim">Sim</option>
                     <option value="nao">Não</option>
                 </select>
            </div>
        </div>
        <div class="row mostra-dados-mobile" style="display: none;">
            <div class="col form-inline">
                <label>Veio Fonte?</label>
                <select>
                     <option selected value="">Selecione...</option>
                     <option value="sim">Sim</option>
                     <option value="nao">Não</option>
                 </select>
            </div>
           
        </div>-->
        <div class="row">
            <div class="col form-inline">
               <label>Localidade</label>
               <input type="text" id="txtCr" style="width: 20px;" />-<input type="text" id="txtLocalidade" class="text-capitalize" style="min-width: 550px;" />
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
               <label>Andar</label>
               <input type="text" id="txtAndar" size="5" maxlength="10" class="text-capitalize" onkeydown="if(event.keyCode === 13){$('#txtSala').focus();}" placeholder="Andar..." style="margin-right: 10px;"/>
            </div>
            <div class="col form-inline">
                <label>Sala</label>
                <input type="text" id="txtSala" size="15" maxlength="20" class="text-capitalize" onkeydown="if(event.keyCode === 13){$('#txtMotivo').focus();}" placeholder="Sala..." />
            </div>
        </div>
        <div class="row">
           
            <div class="col form-inline">
                <label>Motivo</label>
                <select id="txtMotivo" name="txtMotivo" class="text-capitalize" onkeydown="if (event.keyCode === 13){$('#txtObservacoes').focus();}">
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
                
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label for="txtObservacoes">Observações</label>
                <textarea id="txtObservacoes" name="txtObservacoes" wrap="hard"></textarea>
            </div>
     
            <div class="col btn-entrada">
                <div>
                    <button type="button" onclick="validaItemEntrada($('#txtTecnico').val(),$('#numeroEntrada').val(),$('#txtEquipamento').val()); $('#iten-entrada').submit();">Adicionar Equipamento</button>
                </div>
                <div>
                    <button type="button" onclick="finalizaEntrada($('#numeroEntrada').val());" >Finalizar Entrada</button>
                </div>
            </div>
        </div>
        <hr />
    </form>
        <div id="resposta-entrada" class="row">
        
        </div>
    </div>
</div>