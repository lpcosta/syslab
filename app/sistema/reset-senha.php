<?php
require_once './app/funcoes/func.inc.php';
paginaSegura();
$sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a class="text-capitalize" href="#reset-senha">Redefinir Senha</a></li>
    </ul>
    <div id="reset-senha">
        <h2>Redefine sua Senha</h2>
        <form class="reset-senha" id="form-reset-senha" onsubmit="return false;">
            <input type="hidden" name="login" value="<?=LOGIN?>" />
            <input type="hidden" name="acao" value="password" />
            <div class="row">
                <div class="col form-inline">
                    <label>Senha Atual</label>
                    <input type="password" class="form-control" name="pass_atu" />
                </div>
            </div>
            <div class="row">
                <div class="col form-inline">
                    <label>nova Senha</label>
                    <input type="password" id="txtPassNew" class="form-control" name="novo_pass" />
                </div>
            </div>
            <div class="row">
                <div class="col form-inline">
                    <label>Repete a Senha</label>
                    <input type="password" id="txtConfPassNew" class="form-control" name="conf_novo_pass" />
                </div>
            </div>
            <div class="row">
                <div class="col form-inline">
                    <button class="btn btn-primary" style=" margin-left: 135px; margin-right: 10px;">Redefinir Senha</button>
                    <button type="button" class="btn btn-primary">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>