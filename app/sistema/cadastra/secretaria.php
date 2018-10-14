<?php
   paginaSegura();
    if(GRUPO >= 3):
       header("Location:".HOME."");
       exit();
   endif;
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-user">Cadastrar Secretaria</a></li>
    </ul>
    <div id="cad-user">
        <h2 class="text-uppercase">nova secretaria</h2>
        <form class="form-cadastra" id="cadastra-secretaria" onsubmit="return false;">
            <input type="hidden" name="acao" value="secretaria" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Secretaria</label>
                    <input type="text" id="txtNomeSecretaria" name="nomeSecretaria" size="40" class="form-control" placeholder="Nome da secretaria" />
                </div>
                <div class="col-md form-inline">
                    <label>Sigla</label>
                    <input type="text" id="txtSiglaSecretaria" name="siglaSecretaria" size="10" class="form-control" placeholder="Sigla..." />
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
            <div class="alert alert-success msg text-center" role="alert" style="display: none;">
                
            </div>
            <hr />
        </form>
    </div>
</div>