
    <form class="form-cadastra" id="iten-entrada" onsubmit="return false;" style="display: none;">
            <h2>Entrada de Equipamento</h2>
        <div class="row">
            <div class="col form-inline">
                <label>O.S</label>
                <input type="text" id="txtOs" name="txtOs" />
            </div>
            <div class="col form-inline">
                <label>Patrimônio</label>
                <input type="text" id="txtPatrimonio" name="txtPatrimonio"  />
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label>Equipamento</label>
                <select id="txtEquipamento" name="txtEquipamento" class="text-capitalize" onkeydown="if(event.keyCode === 13){$('#txtFabricante').focus();}" onchange="pesqEquipEntrada(this.value)" style="min-width:100px;">
                    <option value="" class="categoria">Selecione</option>                        
                    <?$sql->FullRead("SELECT id,descricao FROM tb_sys003 ORDER BY descricao");foreach ($sql->getResult() as $rowequip):?>
                    <option value="<?= $rowequip['id'] ?>" class="categoria"><?=$rowequip['descricao']; ?></option>
                    <?endforeach;?>
                </select>        
            </div>
            <div class="col form-inline">
                <label>Fabricante</label>
                <select id="txtFabricante" name="txtFabricante" class="text-capitalize" onkeydown="if (event.keyCode === 13){$('#txtModelo').focus();}" onchange="getModelos(this.value);" onblur="getModelos(this.value);">
                    <option value="">Selecione</option>
                    <?$sql->FullRead("SELECT id_fabricante,nome_fabricante FROM tb_sys018 ORDER BY nome_fabricante");foreach ($sql->getResult() as $rowFab):
                    if ($rowFab['id_fabricante'] == 30):continue;endif;?>
                        <option value="<?= $rowFab['id_fabricante'] ?>"><?= $rowFab['nome_fabricante']; ?></option>
                    <?endforeach;?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
               <label>modelo</label>
               <select id="txtModelo" name="modelo">
                   <option selected value="" class="cmbv_modelos">Selecione</option>
               </select>
            </div>
            <div class="col form-inline">
                <label>Checklist</label>
                <input type="text" id="txtChecklist" name="txtChecklist" />
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
               <label>Localidade</label>
               <input type="text" id="txtCodLocal" onblur="setaLocalidade(this.value);" onkeyup="if (event.keyCode == 13){$('#txtAndar').focus();}" placeholder="CR" size="3"  />-<select id="txtLocalidade" onkeydown="if (event.keyCode === 13) {
                                       $('#txtAndar').focus();
                                   }" onchange="$('#txtCodLocal').val(this.value);" class="text-capitalize" style="margin-right: 10px;">
                    <option value="" class="localidade">Selecione</option>                        
                    <?$sql->FullRead("SELECT id,local FROM tb_sys008 ORDER BY local");foreach($sql->getResult()as$rowlocal):?>
                    <option value="<?= $rowlocal['id'] ?>" class="localidade"><?= $rowlocal['local']; ?></option>
                    <?endforeach;?>
                </select>      
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
               <label>Andar</label>
                <input type="text" id="txtAndar" size="5" maxlength="10" class="text-uppercase" onkeydown="if(event.keyCode === 13){$('#txtSala').focus();}" placeholder="Andar..." style="margin-right: 10px;"/>
            </div>
            <div class="col form-inline">
                <label>Sala</label>
                <input type="text" id="txtSala" size="15" maxlength="20" class="text-uppercase" onkeydown="if(event.keyCode === 13){$('#txtMotivo').focus();}" placeholder="Sala..." />
            </div>
        </div>
        <div class="row">
           
            <div class="col form-inline">
                <label>Motivo</label>
                <select id="txtMotivo" class="text-capitalize" onkeydown="if (event.keyCode === 13)">
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
        </div>
        <div class="row">
            <div class="col form-inline">
                <label for="txtObservacoes">Observações</label>
                <textarea id="txtObservacoes" wrap="hard"></textarea>
            </div>
        </div>
            <hr />
        <div class="row">
            <div class="col text-center">
                <button type="submit" class="text-center">Adicionar Equipamento</button>
                &nbsp;&nbsp;
                <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
            </div>
            <div class="col form-inline">
                <button type="button"  onclick="verificaEntrada($('#txtTecnico').val())">Atualizar</button>
            </div>
        </div>
    </form>
