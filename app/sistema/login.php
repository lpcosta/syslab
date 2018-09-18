<div id="login">
    <div class="boxin">
        <h1>Login no Sistema</h1>
        <div class="j_Aviso" role="alert"></div>
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
            <input type="button" value="Esqueci Minha Senha" class="btn btn-primary btn-md" onclick="location.href='<?=HOME?>/app/reset'" />
            <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
        </form>
    </div>
</div>