<?php
   paginaSegura();
    if(GRUPO != 4):
       header("Location:".HOME."");
       exit();
   endif;
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-user">Cadastrar Categoria</a></li>
    </ul>
    <div id="cad-user">
        <h2 class="text-uppercase">nova categoria</h2>
        <form class="form-cadastra" id="cadastra-categoria" onsubmit="return false;">
            <input type="hidden" name="acao" value="categoria" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Categoria</label>
                    <input type="text" id="txtNomeCategoria" name="nomeCategoria" size="40" class="form-control" placeholder="Nome da Categoria" />
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