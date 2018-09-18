<?php
   paginaSegura();
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-windows">Cadastrar Windows</a></li>
        <li><a href="#cad-office" onclick="$('.msg').hide();">Cadastrar Office</a></li>
    </ul>
    <div id="cad-windows">
        <h2>Dados do Windows</h2>
        <form class="form-cadastra cadastra-software" id="cadastra-windows" onsubmit="return false;">
            <input type="hidden" name="tipo" value="windows" />
            <input type="hidden" name="acao" value="software" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Windows</label>
                    <input type="text" id="txtWindows" name="windows" class="form-control" placeholder="Windows..." autofocus="" />
                </div>
                <div class="col-md form-inline">
                    <label>Versão</label>
                    <input type="text" id="txtVersaoWindows" name="VersaoWindows" class="form-control" placeholder="Versão..." />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                   <label>Arquitetura</label>
                   <select class="form-control" id="txtArquiteturaSo" name="ArquiteturaSo">
                       <option selected value="">Selecione</option>
                       <option value=x64>64 Bits</option>
                       <option value=x86>32 Bits</option>
                   </select>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md form-inline">
                    <button type="submit" class="btn btn-primary" >Cadastrar</button>
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
    <div id="cad-office">
        <h2>Dados do Office</h2>
        <form class="form-cadastra cadastra-software" id="cadastra-office" onsubmit="return false;">
            <input type="hidden" name="tipo" value="office" />
            <input type="hidden" name="acao" value="software" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Office</label>
                    <input type="text" id="txtOffice" name="office" class="form-control" required="" placeholder="Office..." />
                </div>
                <div class="col-md form-inline">
                    <label>Versão</label>
                    <input type="text" id="txtVersaoOffice" name="versaoOffice" class="form-control" required="" placeholder="Versão..." />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                   <label>Arquitetura</label>
                   <select class="form-control" id="txtArquiteturaOffice" name="arquiteturaOffice">
                       <option selected value="">Selecione</option>
                       <option value="x64">64 Bits</option>
                       <option value="x86">32 Bits</option>
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
             <div class="alert alert-success msg text-center" role="alert" style="display: none;">
                
            </div>
        </form>
    </div>
</div>