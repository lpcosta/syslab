<div id="login">
    <div class="boxin">
        <h1>Login no Sistema</h1>
        <div class="j_Aviso text-center"></div>
        <form name="login" method="post" class="j_Cadastra" action="javascript:void(0)" onkeydown="if(event.keyCode == 13){$('#btnLoga').trigger('click');}" >
            <label>
                <span>Login:</span>
                <input type="text" name="login" />
            </label>

            <label>
                <span>Senha:</span>
                <input type="password" name="senha" />
            </label>  
            <input type="button" value="Logar" id="btnLoga" name="btn_logar" class="btn btn-primary btn-md" onclick="fctLogin()"/>
            <input type="button" value="Esqueci Minha Senha" class="btn btn-primary btn-md" onclick="redefineSenha();" />
            <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
        </form>
    </div>
    <div id="modal-redefine-login" style="display: none;" title="Redefinir Senha">
        <p class="text-primary">Redefina Sua senha!</p>
        <hr />
        <form name="form-reseta-login" id="form-reseta-login" onsubmit="return false">
            <label>Login</label>
            <input type="text" size="12" id="txtLogin" name="txtLogin">
            <br />
            <label>E-mail</label>
            <input type="text" size="30" id="txtLogin" name="txtEmail">
            <div id="error" class="alert alert-warning" role="alert" style="display: none;"> Dados Informados não Conferem! </div>
            
            <hr />
            <img src="./app/imagens/load.gif" class="frm_load" alt="[CARREGANDO...]" title="CARREGANDO.." style="display: none;" /> 
            <button type="submit">Confirmar Dados</button>
            <button type="button" onclick="$('#modal-redefine-login').dialog('close');">Concelar Operação</button>
            
        </form>
    </div>
</div>

<style>
    form#form-reseta-login label{width: 80px; font-weight: bolder;}
    form#form-reseta-login button{float: right; margin-left: 10px;}
</style>
    