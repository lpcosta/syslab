<?php
   paginaSegura();
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#estoque-recebimento">Recebimento de Peça</a></li>
    </ul>
    <div id="estoque-recebimento">
        
        <form class="form-cadastra" id="recebe-peca" action="javascript:void(0)" >
            <input type="hidden" name="acao" value="recebepeca" />
            <input type="hidden" id="txtQtde" name="qtde" value=1 />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Data do Recebimento</label>
                    <input type="text"  name="dt_recebimento" id="txtData" class=" data form-control" />
                </div>
                <div class="col-md form-inline">
                    <label>Peça</label>
                    <input type="text" id="txtCodPeca" class="form-control" onblur="setaPeca(this.value);" onkeydown="if (event.keyCode == 13){$('#txtPecaSerie').focus();}" placeholder="Código..." size="3" autofocus=""/>-<select id="txtPeca" name="peca_id" onkeydown="if (event.keyCode === 13) {
                                       $('#txtAndar').focus();
                                   }" onchange="$('#txtCodPeca').val(this.value);" class="text-capitalize form-control" style="width: 60%; min-width: 300px;">
                    <option value="" class="localidade">Selecione</option>                        
                    <?$sql->FullRead("SELECT id_peca,descricao_peca FROM tb_sys015 ORDER BY descricao_peca");foreach($sql->getResult()as $peca):?>
                    <option value="<?= $peca['id_peca'] ?>" class="localidade"><?= $peca['descricao_peca']; ?></option>
                    <?endforeach;?>
                </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Nº de Série da Peça</label>
                    <input type="text" id="txtPecaSerie"  name="peca_serie" class="form-control" onkeydown="if (event.keyCode == 13){$('#txtForne').focus();}"  />
                </div>
                <div class="col-md form-inline">
                    <label>Fornecedor</label>
                    <select name="fornecedor_id" id="txtForne" class="text-capitalize form-control" style="min-width: 300px;" onkeydown="if (event.keyCode == 13){$('#txtDanfe').focus();}">
                      <option value="" class="localidade">Selecione</option>                        
                      <?$sql->ExeRead("tb_sys019");foreach($sql->getResult()as $peca):?>
                      <option value="<?= $peca['id_fornecedor'] ?>" class="localidade"><?= $peca['nome_fornecedor']; ?></option>
                      <?endforeach;?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Danfe</label>
                    <input type="text"  name="danfe" id="txtDanfe" class="form-control" onkeydown="if (event.keyCode == 13){$('#txtPreco').focus();}" />
                </div>
                <div class="col-md form-inline">
                    <label>Preço R$ </label>
                    <input type="text"  name="preco_peca" id="txtPreco" class="form-control" onkeydown="if (event.keyCode == 13){$('#txtObs').focus();}" />
                </div>
            </div>
            <div class="row">
                
                <div class="col-md form-inline"  id="txtObservacao">
                    <label>Observações</label>
                    <textarea name="observacao" id="txtObs" class="form-control" wrap="hard" cols="40"></textarea>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md form-inline">
                    <button type="button" class="btn btn-primary" onclick="$('#recebe-peca').submit();">Registrar recebimento</button>
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