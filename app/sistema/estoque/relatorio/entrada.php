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
        <li><a href="#r-e-e">Relatório de Entrada de Peça </a></li>
    </ul>
    <div id="r-e-e" class="header-report">
        <form id="form-header-report" onsubmit="return false">
            <input type="hidden" name="acao" value="entrada-peca" />
            <div class="row">
                <div class="col form-inline">
                    <label>Data Inicial</label>
                    <input type="text"  name="dt_inicial" id="txtDtIni" class="data form-control" />
                    &nbsp;
                    <label>Data Final</label>
                    <input type="text"  name="dt_final" id="txtDtFim" class="data form-control" />
                </div>
                <div class="col form-inline">
                    <input type="submit" class="btn btn-primary" value="Gerar Relatório">
                    &nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                    
                    <button type="button" class="btn btn-primary btnPrinter" style="display: none;" onclick="imprime();">Imprimir</button>
                </div>
            </div>
            <hr />
        </form>
    </div>

    <div id="printArea" class="relatorio printTable">
        
    </div>
</div>