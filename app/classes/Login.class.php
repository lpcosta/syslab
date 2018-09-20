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
    private $ip;
    private $host;
    private $Tentativa;
    private $isuser;
    /**
     * <b>Efetuar Login:</b> Envelope um array atribuitivo com índices STRING user [email], STRING pass.
     * Ao passar este array na ExeLogin() os dados são verificados e o login é feito!
     * @param ARRAY $UserData = user [email], pass
     */
    public function ExeLogin(array $UserData) {
        $this->Login = (string) strip_tags(trim($UserData['login']));
        $this->Senha = (string) strip_tags(trim($UserData['senha']));
        $this->ip    = (string) strip_tags(trim($UserData['ip']));
        $this->host  = (string) strip_tags(trim($UserData['host']));
        
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
        $atualiza = new Update();
        $log = new Create();
        if (!$this->Login || !$this->Senha):
            $this->Result = 'Informe seu Login e Senha!';
        elseif (!$this->getUser()):
            if($this->isuser):
                if($this->Tentativa < 4):
                    $this->Result = 'Login ou senha Inválidos!';
                    $atualiza->ExeUpdate("tb_sys001", ["tentativa_login" => $this->Tentativa ], "WHERE login = :LOGIN ", "LOGIN={$this->Login}");
                    $log->ExeCreate("tb_sys024",["tecnico"=> $this->Login,"data" =>date('Y-m-d H:i:s'),"ip" => $this->ip,"host" => $this->host,"acao" =>0,"msg"=>'login falhou']);
                else:
                    $this->Result = "usuario bloqueado! por exceder o numero de tentativas de login!";
                    $atualiza->ExeUpdate("tb_sys001", ["situacao" =>'b'], "WHERE login = :LOGIN ", "LOGIN={$this->Login}");
                endif;
            else:
                $this->Result = 'Login nao encontrado!';    
            endif;
        else:
            if($this->Tentativa < 3):
                if($this->Result['situacao']==='l' && $this->Result['senha_padrao']==='sim'):
                    $hash = md5(sha1(date('d-m-Y')));
                    $this->Result = "SUA SENHA DEVE SER ALTERADA!<br /><a href=".HOME."/app/reset/index.php?hash=".$hash."&login=".$this->Result['login'].">ALTERAR</a>";
                else:
                    $this->Execute();
                endif;
            else:
                $this->Result = "usuario bloqueado! por exceder o numero de tentativas de login!";
                $atualiza->ExeUpdate("tb_sys001", ["situacao" =>'b'], "WHERE login = :LOGIN ", "LOGIN={$this->Login}");
            endif;
            
        endif;
    }

    //Vetifica usuário e senha no banco de dados!
    private function getUser() {
        $senha = new Senha();
        $sql = new Read();      
        $sql->FullRead("SELECT id,nome,login,situacao,tentativa_login,senha_padrao,grupo_id FROM tb_sys001 WHERE login = :LOGIN AND senha = :SENHA", "LOGIN={$this->Login}&SENHA={$senha->setSenha($this->Senha)}");

        if ($sql->getResult()):
            $this->Result = $sql->getResult()[0];
            $this->Tentativa = $sql->getResult()[0]['tentativa_login'];
            return true;
        else:
            $sql->ExeRead("tb_sys001", "WHERE login = :LOGIN", "LOGIN={$this->Login}");
            if($sql->getResult()):
                $this->Tentativa = ($sql->getResult()[0]['tentativa_login']+1);
                $this->isuser = true;
            else:
                $this->isuser = false;
            endif;
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
