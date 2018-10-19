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
        <li><a href="#estoque">Estoque Lorac</a></li>
    </ul>
    <div id="estoque">
        <div class="row">
            <div class="col form-inline">
                <label style="width:50px;">Peça</label>
                &nbsp;
                <input type="text" id="busca" name="peca" class="form-control text-capitalize" style="width: calc(100% - 55px);" />
            </div>
            <div class="col form-inline">
                <div class="col btn-edita-peca" style="display:none;">
                    <button type="button" id="btnEditarPeca"        class="btn btn-primary" onclick="liberaCamposEdicaoPeca();">Editar</button>
                    <button type="button" id="btnSalvaEdicaoPeca"   class="btn btn-primary" style="display: none;" onclick="editaPeca()">Salvar</button>
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." />
                </div>
                <div class="col">
                    <button type="button"  class="btn btn-primary" onclick="window.location.reload();">Voltar</button>
                </div>
            </div>
        </div>
        <div class="dados-edita"></div>
    </div>
</div>