<?php
   paginaSegura();
  $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#r-e-e">Relatório de Saída de Equipamento </a></li>
    </ul>
    <div id="r-e-e" class="header-report">
        <form id="form-header-report-saida" onsubmit="return false">
            <div class="row">
                <div class="col form-inline">
                    <label>Tipo de Relatório</label>
                    <select id="tipoRel" name="tipoRel">
                        <option selected value="">Selecione...</option>
                        <option value="tecnico">Técnico</option>
                        <option value="periodo">Período</option>
                        <option value="codigo">Nº da Saída</option>
                    </select>
                </div>
                <div class="col form-inline options-rel">
                    <input type="text" name="txtCodSaida" id="txtCodSaida" placeholder="Nº saída..." />
                </div>
                <div class="col form-inline">
                    <input type="submit" class="btn btn-primary" value="Gerar Relatório">
                    &nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                    
                    <button type="button" class="btn btn-primary btnPrinter" style="display: none;" onclick="imprimi();">Imprimir</button>
                </div>
            </div>
            <hr />
        </form>
    </div>
    <div class="relatorio printTable">
        
    </div>
</div>