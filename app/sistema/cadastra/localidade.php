<?php
   paginaSegura();
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-user">Cadastrar Localidade</a></li>
    </ul>
    <div id="cad-user">
        <h2 class="text-uppercase">nova localidade</h2>
        <form class="form-cadastra" id="cadastra-localidade" onsubmit="return false;">
            <input type="hidden" name="acao" value="localidade" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Localidade</label>
                    <input type="text" id="txtNomeLocalidade" name="nomeLocalidade" size="40" class="form-control" placeholder="Nome da Localidade..." />
                </div>
                <div class="col-md form-inline">
                    <label>C.R</label>
                    <input type="number" id="txtCrLocalidade" name="crLocalidade" size="8" class="form-control"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Endereço</label>
                    <input type="text" id="txtEndereco" name="txtEndereco" size="40" class="form-control" placeholder="Nome da Localidade..." />
                </div>
                <div class="col-md form-inline">
                    <label>Bairro</label>
                    <input type="text" id="txtBairro" name="txtBairro" class="form-control"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>C.E.P</label>
                    <input type="text" id="txtCep" name="txtCep" size="15" class="form-control" placeholder="Cep..." />
                </div>
                <div class="col-md form-inline">
                    <label>Secretaria</label>
                    <select class="form-control" id="txtSecretaria" name="secretaria">
                        <?php $sql->FullRead("SELECT id_secretaria,nome_secretaria FROM tb_sys011 ORDER BY nome_secretaria"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                        print "<option value=".$res['id_secretaria'].">".ucfirst($res['nome_secretaria'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Região</label>
                    <select id="txtRegiao" name="txtRegiao" class="form-control text-capitalize">
                        <option selected value="">Selecione</option>
                        <?php
                        $sql->FullRead("SELECT id_regiao,nome_regiao FROM tb_sys023 ORDER BY nome_regiao");
                        foreach ($sql->getResult() as $res):?>
                            <option value="<?=$res['id_regiao']?>"><?=$res['nome_regiao'];?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div class="col-md form-inline">
                    
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md form-inline">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
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