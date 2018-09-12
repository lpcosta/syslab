<?php
    require_once './app/config/pagina-segura.php';
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-windows">Cadastrar Windows</a></li>
        <li><a href="#cad-office">Cadastrar Office</a></li>
    </ul>
    <div id="cad-windows">
        <h2>Dados do Windows</h2>
        <form name="cadastra-software" class="form-cadastra" action="javascript:void(0);">
            
            <div class="row">
                <div class="col-md form-inline">
                    <label>Windows</label>
                    <input type="text" id="txtWindows" class="form-control" required="" placeholder="Windows..." />
                </div>
                <div class="col-md form-inline">
                    <label>Versão</label>
                    <input type="text" id="txtVersaoWindows" class="form-control" required="" placeholder="Versão..." />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                   <label>Arquitetura</label>
                   <select class="form-control" id="txtArquiteturaSo">
                       <option selected value="">Selecione</option>
                       <option value="x64">64 Bits</option>
                       <option value="x86">32 Bits</option>
                   </select>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md form-inline">
                    <button type="button" class="btn btn-primary" onclick="cadastra('software','windows')">Cadastrar</button>
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
        <form name="cadastra-software" class="form-cadastra" action="javascript:void(0);">
          
            <div class="row">
                <div class="col-md form-inline">
                    <label>Office</label>
                    <input type="text" id="txtOffice" class="form-control" required="" placeholder="Office..." />
                </div>
                <div class="col-md form-inline">
                    <label>Versão</label>
                    <input type="text" id="txtVersaoOffice" class="form-control" required="" placeholder="Versão..." />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                   <label>Arquitetura</label>
                   <select class="form-control" id="txtArquiteturaOffice">
                       <option selected value="">Selecione</option>
                       <option selected value="x64">64 Bits</option>
                       <option selected value="x86">32 Bits</option>
                   </select>
                </div>
                <div class="col-md form-inline">
                    
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md form-inline">
                    <button type="button" class="btn btn-primary" onclick="cadastra('software','office')">Cadastrar</button>
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