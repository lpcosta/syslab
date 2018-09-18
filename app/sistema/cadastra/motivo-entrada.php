<?php
   paginaSegura();
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-user">Cadastrar Motivo de Entrada</a></li>
    </ul>
    <div id="cad-user">
        <h2 class="text-uppercase">Motivo</h2>
        <form class="form-cadastra" id="cadastra-motivo" onsubmit="return false;">
            <input type="hidden" name="acao" value="motivo" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Status</label>
                    <input type="text" id="txtMotivoEntrada" name="motivoEntrada" class="form-control" placeholder="Motivo..." />
                </div>
                <div class="col-md form-inline">
                    <label>Categoria</label>
                    <select id="txtCategoriaMotivo" name="categoriaMotivoEntrada" class="text-capitalize form-control">
                        <option selected value="">selecione...</option>
                        <option value=0>geral</option>
                        <option value=3>estabilizador</option>
                        <option value=1>impressora</option>
                        <option value=2>computador</option>
                        <option value=4>monitor</option>
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