<?php
   paginaSegura();
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-user">Cadastrar Empresa</a></li>
    </ul>
    <div id="cad-user">
        <h2 class="text-uppercase">nova empresa</h2>
        <form class="form-cadastra" id="cadastra-empresa" onsubmit="return false;">
            <input type="hidden" name="acao" value="empresa" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Razão Social</label>
                    <input type="text" id="txtRazaoSocial" name="txtRazaoSocial" size="40" class="form-control" placeholder="Razão Social..." />
                </div>
                <div class="col-md form-inline">
                    <label>C.N.P.J</label>
                    <input type="text" id="txtCnpj" name="txtCnpj" size="20" class="form-control" placeholder="cnpj..." onblur="validarCNPJ(this.value)" />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Fantasia</label>
                    <input type="text" id="txtFantasia" name="txtFantasia" size="30" class="form-control" placeholder="Fantasia..." onfocus="validarCNPJ($('#txtCnpj').val())" />
                </div>
                <div class="col-md form-inline">
                    <label>I.E</label>
                    <input type="text" id="txtIe" name="txtIe" size="20" class="form-control" placeholder="Inscrição estadual" />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Estado</label>
                    <select id="txtEstado" name="txtEstado" onchange="buscaCidade(this)" class="form-control"> 
                        <option value="">Selecione o Estado</option> 
                        <optgroup label="Região Norte" >
                            <option value=1>Acre</option>
                            <option value=4>Amazonas</option>
                            <option value=3>Amapá</option>
                            <option value=15>Pará</option>
                            <option value=23>Rondônia</option> 
                            <option value=9>Roraima</option> 
                            <option value=24>Tocantins</option> 
                        </optgroup>
                        <optgroup label="Região Nordeste" >
                            <option value=2>Alagoas</option> 
                            <option value=5>Bahia</option> 
                            <option value=6>Ceará</option> 
                            <option value=11>Maranhão</option>
                            <option value=16>Paraíba</option> 
                            <option value=18>Pernambuco</option> 
                            <option value=19>Piauí</option> 
                            <option value=21>Rio Grande do Norte</option>
                            <option value=27>Sergipe</option> 
                        </optgroup>
                        <optgroup label="Região Centro Oeste" >
                            <option value=12>Mato Grosso</option> 
                            <option value=13>Mato Grosso do Sul</option>
                            <option value=10>Goiás</option>
                            <option value=7>Distrito Federal</option>
                        </optgroup>
                        <optgroup label="Região Sudeste" >
                            <option value=26>São Paulo</option> 
                            <option value=20>Rio de Janeiro</option>                          
                            <option value=8>Espírito Santo</option> 
                            <option value=14>Minas Gerais</option>
                        </optgroup>
                        <optgroup label="Região Sul" >
                            <option value=17>Paraná</option>
                            <option value=25>Santa Catarina</option>
                            <option value=22>Rio Grande do Sul</option> 
                        </optgroup>
                    </select>
                </div>
                <div class="col-md form-inline">
                    <label>Cidade</label>
                    <select id="txtCidade" name="txtCidade" disabled="" class="form-control" onchange="buscaCep(this)">
                        <option value="">Selecione um Estado...</option>                            
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Bairro</label>
                    <input type="text" id="txtBairro" name="txtBairro" class="form-control" placeholder="bairro..."/>
                </div>
                <div class="col-md form-inline">
                    <label>CEP</label>
                    <input type="text"  id="txtCep" name="txtCep" size="9" maxlength="9" disabled="" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Rua</label>
                    <input type="text" id="txtRuaEmpresa" name="txtRuaEmpresa" class="form-control" placeholder="Rua..."/>
                </div>
                <div class="col-md form-inline">
                    <label>E-mail</label>
                    <input type="text"  id="txtEmailEmpresa" name="txtEmailEmpresa" class="form-control" placeholder="E-mail..." />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Contato</label>
                    <input type="text" id="txtContato" name="txtContatoEmpresa" class="form-control" placeholder="Contato..."/>
                </div>
                <div class="col-md form-inline">
                    <label>Site</label>
                    <input type="url"  id="txtSiteEmpresa" name="txtSiteEmpresa" class="form-control" placeholder="http://site.empresa.com" />
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