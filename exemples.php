<?php 

require_once("config.php");

//Carrega um usuário
//$root = new Usuario();
//$root->loadbyId(3);
//echo $root;

//Carrega uma lista de usuários
//$lista = Usuario::getList();
//echo json_encode($lista);

//Carrega uma lista de usuários buscando pelo login
//$search = Usuario::search("lpcosta");
//echo json_encode($search);

//carrega um usuário usando o login e a senha
//$usuario = new Usuario();
//$senha = new Senha();
//$usuario->login("lpcosta", "{$senha->setSenha("par4ting4")}");

//echo $usuario;
/*
//Criando um novo usuário
$aluno = new Usuario("aluno", "@lun0");
$aluno->insert();
echo $aluno;
*/
/*
//Alterar um usuário
$usuario = new Usuario();

$usuario->loadById(8);

$usuario->update("professor", "!@#$%¨&*");

echo $usuario;
*/
$sql = new Sql();

$user = $sql->select("Select * from tb_sys001");
/*
$header = [];
foreach ($user[0] as $key => $value ):
    array_push($header, ucfirst($key));
endforeach;

$file = fopen("entradas.csv", "w+");

fwrite($file, implode(";", $header)."\r\n");

foreach ($user as $row):
    $dados =[];
    foreach ($row as $key => $value):
        array_push($dados, $value);
    endforeach;//fim foreach de coluna
    
    fwrite($file, implode(";", $dados)."\r\n");
    
    
endforeach;//fim foreach de linha

fclose($file);*/

print_r($user[21]);

