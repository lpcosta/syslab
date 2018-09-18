<?php

/**
 * Login.class [ MODEL ]
 * Responável por autenticar, validar, e checar usuário do sistema de login!
 * 
 * @copyright (c) 2014, Robson V. Leite UPINSIDE TECNOLOGIA
 */
class Login {

    private $Login;
    private $Senha;
    private $Result;

    /**
     * <b>Efetuar Login:</b> Envelope um array atribuitivo com índices STRING user [email], STRING pass.
     * Ao passar este array na ExeLogin() os dados são verificados e o login é feito!
     * @param ARRAY $UserData = user [email], pass
     */
    public function ExeLogin(array $UserData) {
        $this->Login = (string) strip_tags(trim($UserData['login']));
        $this->Senha = (string) strip_tags(trim($UserData['senha']));
        $this->setLogin();
    }

    /**
     * <b>Verificar Login:</b> Executando um getResult é possível verificar se foi ou não efetuado
     * o acesso com os dados.
     * @return BOOL $Var = true para login e false para erro
     */
    public function getResult() {
        return $this->Result;
    }
    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida os dados e armazena os erros caso existam. Executa o login!
    private function setLogin() {
        if (!$this->Login || !$this->Senha):
            $this->Result = 'Informe seu Login e Senha!';
        elseif (!$this->getUser()):
            $this->Result = 'Login ou senha Inválidos!';
        else:
            $this->Execute();
        endif;
    }

    //Vetifica usuário e senha no banco de dados!
    private function getUser() {
        $this->Senha = hash('whirlpool',hash('sha512',hash('sha384',hash('sha256',sha1(md5('mjll'.$this->Senha))))));

        $read = new Read;
        //$read->ExeRead("tb_sys001", "WHERE login = :LOGIN AND senha = :SENHA", "LOGIN={$this->Login}&SENHA={$this->Senha}");
        $read->FullRead("SELECT id,nome,login,situacao,tentativa_login,senha_padrao,grupo_id FROM tb_sys001 WHERE login = :LOGIN AND senha = :SENHA", "LOGIN={$this->Login}&SENHA={$this->Senha}");

        if ($read->getResult()):
            $this->Result = $read->getResult()[0];
            return true;
        else:
            return false;
        endif;
    }

    //Executa o login armazenando a sessão!
    private function Execute() {
        if (!session_id()):
            session_start();
        endif;
        $_SESSION['UserLogado']=true;
        $_SESSION['UserLogado'] = $this->Result;
        
        $this->Result = true;
    }

}
