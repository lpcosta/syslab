<?php
   paginaSegura();
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-user">Cadastrar Usuário</a></li>
    </ul>
    <div id="cad-user">
        <h2 class="text-uppercase">novo usuário</h2>
        <form class="form-cadastra" id="cadastra-user" onsubmit="return false;">
            <input type="hidden" name="acao" value="usuario" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Nome</label>
                    <input type="text" id="txtNomeUser" name="nomeUser" size="40" class="form-control" placeholder="Nome Completo" />
                </div>
                <div class="col-md form-inline">
                    <label>E-mail</label>
                    <input type="email" id="txtEmailUser" name="mailUser" size="40" class="form-control" placeholder="E-mail..." />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                   <label>Empresa</label>
                   <select class="form-control" id="txtEmpresaUser" name="empresaUser">
                        <?php $sql->ExeRead("tb_sys012"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['idEmpresa'].">".ucfirst($res['fantasia'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md form-inline">
                    <label>Contato</label>
                    <input type="tel" id="txtContatoUser" name="contatoUser" class="form-control" placeholder="(xx)xxxx-xxxx" />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                   <label>Login</label>
                   <input type="text" id="txtLoginUser" name="loginUser" class="form-control" placeholder="login..." />
                </div>
                <div class="col-md form-inline">
                    <label>Celular</label>
                    <input type="tel" id="txtCelularUser" name="celularUser" class="form-control" placeholder="(xx)xxxxx-xxxx" />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>Tipo</label>
                    <select id="txtTipo" name="tipoUser" class="form-control">
                        <option selected value=''>Selecione...</option>
                        <option value="usuario">Usuário</option>
                        <option value="tecnico">Técnico</option>
                    </select>
                </div>
                <div class="col-md form-inline">
                    <label>Grupo</label>
                    <select id="txtGrupo" name="grupoUser"  class="form-control">
                        <option selected value=''>Selecione...</option>
                            <?$sql->ExeRead("tb_sys021");
                            foreach ($sql->getResult() as $gp):?>
                            <option value="<?= $gp['id_grupo'] ?>"><?= ucwords($gp['descricao'])?></option>
                        <? endforeach;?>
                    </select>
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