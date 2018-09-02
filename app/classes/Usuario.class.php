<?php 

class Usuario {

	private $idusuario;
	private $login;
        private $nome;
	private $senha;
	private $dtcadastro;

        
	public function getIdusuario(){
		return $this->idusuario;
	}

	public function setIdusuario($value){
		$this->idusuario = $value;
	}
        
        public function getNome(){
            return $this->nome;
        }
        
        public function setNome($value){
            $this->nome = $value;
        }

        public function getLogin(){
		return $this->login;
	}

	public function setLogin($value){
		$this->login = $value;
	}

	public function getSenha(){
		return $this->senha;
	}

	public function setSenha($value){
		$this->senha = $value;
	}

	public function getDtcadastro(){
		return $this->dtcadastro;
	}

	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}
	
	public function loadById($id){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_sys001 WHERE id = :ID", array(
			":ID"=>$id
		));

		if (count($results) > 0) {

			$this->setData($results[0]);

		}

	}

	public static function getList(){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_sys001 ORDER BY login;");

	}

	public static function search($login){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_sys001 WHERE login LIKE :SEARCH ORDER BY login", array(
			':SEARCH'=>"%".$login."%"
		));

	}

	public function login($login, $password){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_sys001 WHERE login = :LOGIN AND senha = :PASSWORD", array(
			":LOGIN"=>$login,
			":PASSWORD"=>$password
		));

		if (count($results) > 0) {

			$this->setData($results[0]);

		} else {

			throw new Exception("Login e/ou senha inválidos.");

		}

	}

	public function setData($data){

		$this->setIdusuario($data['id']);
		$this->setNome($data['nome']);
		$this->setLogin($data['login']);
		$this->setSenha($data['senha']);
		$this->setDtcadastro(new DateTime($data['dt_cadastro']));

	}

	public function insert(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha()
		));

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function update($login, $password){

		$this->setDeslogin($login);
		$this->setDessenha($password);

		$sql = new Sql();

		$sql->query("UPDATE  tb_sys001 SET login = :LOGIN, senha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha(),
			':ID'=>$this->getIdusuario()
		));

	}

	public function delete(){

		$sql = new Sql();

		$sql->query("DELETE FROM tb_sys001 WHERE idusuario = :ID", array(
			':ID'=>$this->getIdusuario()
		));

		$this->setIdusuario(0);
		$this->setDeslogin("");
		$this->setDessenha("");
		$this->setDtcadastro(new DateTime());

	}

	public function __construct($login = "", $password = ""){

		$this->setLogin($login);
		$this->setSenha($password);

	}

	public function __toString(){

		return json_encode(array(
			"Id"=>$this->getIdusuario(),
                        "nome"=> $this->getNome(),
			"Login"=>$this->getLogin(),
			"Senha"=>$this->getSenha(),
			"Dt.Cadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
		));

	}

} 	
 ?>