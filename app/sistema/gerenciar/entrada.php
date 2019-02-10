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
        <li><a href="#g-entrada">Gerenciamento de Entrada</a></li>
    </ul>
    <div id="g-entrada">
        <h2>Pesquisar</h2>
        <form class="form-cadastra" id="frm-g-entrada" onsubmit="return false;">
            <div class="row">
                <div class="col-md form-inline">
                    <label>Nº da Entrada</label>
                    <input type="text" name="entrada" class="form-control"/>
                </div>
                <div class="col-md form-inline">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                    &nbsp;&nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                </div>
            </div>
            <hr />
        </form>
        <div class="dados-edita-entrada">

        </div>
    </div>
</div>