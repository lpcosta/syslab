<?php
require_once '../../config/autoload.inc.php';

$getPost = filter_input_array(INPUT_POST,FILTER_DEFAULT);
$setPost = array_map("strip_tags", $getPost);
$post    = array_map("trim", $setPost);
extract($post);

$sql = new Read();
$update = new Update();
$senha = new Senha();
$sql->FullRead("SELECT login,email,nome,email FROM tb_sys001 WHERE login = :LOGIN AND email = :EMAIL", "LOGIN="."{$txtLogin}"."&EMAIL="."{$txtEmail}"."");
    if($sql->getResult()):
        
        $mail = new Email();            

    
        //$mail->enviaMail("Redefinição de Senha do Syslab", $sql->getResult()[0]['email'], "Usuario do syslab redefinido clique no link abaixo para desbloquer seu usuário!");
        
        if($mail->getError()):
            print $mail->getError();
        endif;
       /* 
        $hash = md5(date('Y-m-d'));
        $sql->FullRead("SELECT login FROM tb_sys001 WHERE login = :LOGIN AND hash = :HASH", "LOGIN="."{$txtLogin}"."&HASH="."{$hash}"."");
        if($sql->getResult()):
            print "Seu usuario já foi redefinido hoje! por favor cheque seu e-mail";
        else:
            $update->ExeUpdate("tb_sys001", ["hash" => $hash,
                                         "senha_padrao"=>'sim',
                                         "senha"=>$senha->setSenha("syslabab")            
                                        ], "WHERE login = :LOGIN", "LOGIN="."{$txtLogin}"."");
            
            $mail = new Email();                                                 
            $mail->Enviar($dado);
            
            if($mail->getError()):
                WSErro($mail->getError()[0], $mail->getError()[1]);
            endif;
        endif;*/
    else:
        print "login e/ou E-mail iformado nao conferem!";
    endif;


/*c00706f7a179940ec887e434303785dafc450ae8fb87b5d2cd7a1eb56ed7129d81c10aa0d5d55cfedfa970fd26829645d9acfb2f4b6110bd6aeabc08d98dfb07*/