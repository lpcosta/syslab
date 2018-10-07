<?php
   paginaSegura();
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#baixa">Baixa de Peça</a></li>
    </ul>
    <div id="baixa">
        <form class="form-cadastra" id="baixa-peca" onsubmit="return false;">
            <input type="hidden" name="bancada" value="0" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Peça</label>
                    <input type="text" id="txtCodPeca" class="form-control" onblur="setaPeca(this.value,'true');" onkeyup="if (event.keyCode == 13){$('#txtOrdem').focus();}" placeholder="Código..." size="3" autofocus="" />-<select id="txtPeca" name="peca_id" onkeydown="if (event.keyCode === 13) {
                                       $('#txtAndar').focus();
                                   }" onchange="setaPeca(this.value)" class="text-capitalize form-control" style="width: 60%; min-width: 300px;">
                    <option value="" class="localidade">Selecione</option>                        
                    <?$sql->FullRead("SELECT id_peca,descricao_peca FROM tb_sys015 ORDER BY descricao_peca");foreach($sql->getResult()as $peca):?>
                    <option value="<?= $peca['id_peca'] ?>" class="localidade"><?= $peca['descricao_peca']; ?></option>
                    <?endforeach;?>
                </select>
                </div>
                
                <div class="col-md form-inline" id="txtObservacao">
                    <label>Ordem de Serviço</label>
                    <input type="text" id="txtOrdem"  name="ordem_servico" class="form-control" />
                </div>
            </div>
   
            <hr />
            <div class="row">
                <div class="col-md form-inline">
                    <button type="submit" class="btn btn-primary">Baixar</button>
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