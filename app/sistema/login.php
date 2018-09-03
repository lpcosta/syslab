<div id="login">
    <div class="boxin">
        <h1>Login no Sistema</h1>
        <form name="login" method="post" class="j_Cadastra" action="javascript:void(0)" >
            <label>
                <span>Login:</span>
                <input type="text" name="login" />
            </label>

            <label>
                <span>Senha:</span>
                <input type="password" name="senha" />
            </label>  

            <input type="button" value="Logar" name="btn_logar" class="btn btn-primary btn-md" onclick="fctLogin()"/>
            <input type="button" value="Esqueci Minha Senha" class="btn btn-primary btn-md" onclick="location.href='<?=HOME?>/app/reset'" />
            <img src="./app/images/loader-sm.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
        </form>
    </div>
</div>