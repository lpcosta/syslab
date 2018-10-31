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
                <div class="col-md form-inline">
                    <button type="submit" class="btn btn-primary" >Cadastrar</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" onclick="history.back()">Cancelar</button>
                </div>
            </div>
            <hr />
            <div class="alert alert-success msg text-center" role="alert" style="display: none;">
                
            </div>
        </form>
        <h2>Editar</h2>
    <?$sql->ExeRead("tb_sys025");$i=1;foreach($sql->getResult() as $soft):?>
        <form class="edita edita-win-<?=$i?>" onsubmit="return false">
            <input type="hidden" name="acao" value="windows" />
            <input type="hidden" name="id" value="<?=$soft['id_so']?>" />
            <div class="row">
                <div class="col form-inline">
                    <label>S.O</label>
                    <input type="text" name="descricao_so" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$soft['descricao_so']?>"/>
                </div>
                <div class="col form-inline">
                    <label>Versão</label>
                    <input type="text" name="versao_so" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$soft['versao_so']?>"/>
                </div>
                <div class="col form-inline">
                    <label>Arquitetura</label>
                    <input type="text" name="arquitetura_so" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$soft['arquitetura_so']?>" style="width:90px;"/>
                    &nbsp;
                    <button type="button" class="btn btn-primary btn-edita-<?=$i?>" onclick="liberaEdicao(<?=$i?>)">Editar</button>
                    <button type="button" class="btn btn-primary btn-salva-<?=$i?>" onclick="editaWindows(<?=$i?>);" style="display:none;">Salvar</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-primary btn-deleta-<?=$i?>" onclick="">Excluir</button>
                </div>
            </div>
        </form>
    <?$i++;endforeach;?>
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
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" onclick="history.back()">Cancelar</button>
                </div>
            </div>
            <hr />
            <div class="alert alert-success msg text-center" role="alert" style="display: none;">
                
            </div>
        </form>
        <h2>Editar</h2>
        <?$sql->ExeRead("tb_sys026");$i=1;foreach($sql->getResult() as $office):?>
        <form class="edita edita-office-<?=$i?>" onsubmit="return false">
            <input type="hidden" name="acao" value="office" />
            <input type="hidden" name="id" value="<?=$office['id_office']?>" />
            <div class="row">
                <div class="col form-inline">
                    <label>Office</label>
                    <input type="text" name="descricao_office" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$office['descricao_office']?>"/>
                </div>
                <div class="col form-inline">
                    <label>Versão</label>
                    <input type="text" name="versao_office" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$office['versao_office']?>"/>
                </div>
                <div class="col form-inline">
                    <label>Arquitetura</label>
                    <input type="text" name="arquitetura_office" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$office['arquitetura_office']?>" style="width:90px;"/>
                    &nbsp;
                    <button type="button" class="btn btn-primary btn-edita-<?=$i?>" onclick="liberaEdicao(<?=$i?>)">Editar</button>
                    <button type="button" class="btn btn-primary btn-salva-<?=$i?>" onclick="editaOffice(<?=$i?>);" style="display:none;">Salvar</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-primary btn-deleta-<?=$i?>" onclick="">Excluir</button>
                </div>
            </div>
        </form>
    <?$i++;endforeach;?>
    </div>
</div>