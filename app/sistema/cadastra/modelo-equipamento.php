<?php
 paginaSegura();
    
$sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-modelo">Cadastrar Modelo de Equipamento</a></li>
    </ul>
    <div id="cad-modelo">
        <h2>Cadastro de Modelo de Equipamento</h2>
        <form class="form-cadastra" id="cadastra-modelo-equipamento" onsubmit="return false;">
            <input type="hidden" name="acao" value="modelo" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Modelo</label>
                    <input type="text" id="txtNomeStatus" name="modelo" size="40" class="form-control" placeholder="Modelo do Equipamento..." />
                </div>
                <div class="col-md form-inline">
                    <label>fabricante</label>
                    <select class="form-control" id="txtFab" name="fabricante_id">
                        <?php $sql->ExeRead("tb_sys018 ORDER BY nome_fabricante")?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id_fabricante'].">".ucfirst($res['nome_fabricante'])."</option>";
                        endforeach;
                        ?>
                    </select>
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