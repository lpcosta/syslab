<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../libs/PHPMailer/src/PHPMailer.php';
require_once '../../libs/PHPMailer/src/Exception.php';
require_once '../../libs/PHPMailer/src/SMTP.php';
require_once '../../config/post.inc.php';
$sql    = new Read();
$update = new Update();
$senha  = new Senha();
$sql->FullRead("SELECT login,email,nome,email FROM tb_sys001 WHERE login = :LOGIN AND email = :EMAIL", "LOGIN="."{$txtLogin}"."&EMAIL="."{$txtEmail}"."");
    if($sql->getResult()):
        $email =  $sql->getResult()[0]['email'];
        $hash = md5(sha1(date('d-m-Y')));
        $sql->FullRead("SELECT login FROM tb_sys001 WHERE login = :LOGIN AND hash = :HASH", "LOGIN="."{$txtLogin}"."&HASH="."{$hash}"."");
        if($sql->getResult()):
            print "Seu usuario já foi redefinido hoje! por favor cheque seu e-mail";
        else:
            $update->ExeUpdate("tb_sys001", ["hash" => $hash,
                                         "senha_padrao"=>'sim',
                                         "senha"=>$senha->setSenha("syslabab")            
                                        ], "WHERE login = :LOGIN", "LOGIN="."{$txtLogin}"."");
            
            $mail = new Email();  
            
            $mail->enviaMail("Redefinição de Senha do Syslab",$email,
                    "Usuario do syslab redefinido clique no link abaixo para desbloquer seu usuário!<br /><br />"
                    . "<a href='".HOME."/app/reset/index.php?hash={$hash}&login={$txtLogin}'>"
                    . "Desbloquer Usuário</a><br /><br />"
                    . "<p>Syslab - Controle de Equipamento</p>");
            if($mail->getResult()):
                print $mail->getResult();
            else:
                print $mail->getError();
            endif;
        endif;
    else:
        print "login e/ou E-mail iformado nao conferem!";
    endif;


/*c00706f7a179940ec887e434303785dafc450ae8fb87b5d2cd7a1eb56ed7129d81c10aa0d5d55cfedfa970fd26829645d9acfb2f4b6110bd6aeabc08d98dfb07*/