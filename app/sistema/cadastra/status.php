<?php
   paginaSegura();
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-user">Cadastrar Status</a></li>
    </ul>
    <div id="cad-user">
        <h2 class="text-uppercase">novo satus</h2>
        <form class="form-cadastra" id="cadastra-status" onsubmit="return false;">
            <input type="hidden" name="acao" value="status" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Status</label>
                    <input type="text" id="txtNomeStatus" name="nomeStatus" size="40" class="form-control" placeholder="Nome da Categoria" />
                </div>
                <div class="col-md form-inline">
                    <label>Cor</label>
                    <input type="color" id="txtCorStatus" name="corStatus"size="8" class="form-control"/>
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