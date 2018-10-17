<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../libs/PHPMailer/src/PHPMailer.php';
require_once '../../libs/PHPMailer/src/Exception.php';
require_once '../../libs/PHPMailer/src/SMTP.php';
require_once '../../config/post.inc.php';
$sql     = new Read();
$bscMail = new Read();
$atu     = new Update();
$mail    = new Email(); 

$sql->FullRead("SELECT * FROM tb_sys006 WHERE id_entrada = :ENTRADA", "ENTRADA={$entrada}");
if($sql->getRowCount() > 0):
    $atu->ExeUpdate("tb_sys005",["id_status"=>3], "WHERE identrada = :ENTRADA", "ENTRADA={$entrada}");
                 
    $bscMail->FullRead("SELECT T.email,T.nome FROM tb_sys001 T JOIN tb_sys005 E ON E.id_tecnico = T.id AND E.identrada = :ENTRADA","ENTRADA={$entrada}");
    
    $emails = [$bscMail->getResult()[0]['email'],$mailResp];
    
    $data = date('d/m/Y H:i:s');

    $msg = "<table style=\"margin: 0 auto;\">
            <tr>
                <th colspan=\"6\" style=\"text-align: center;\">STI - ENTRADA DE EQUIPAMENTO NO LABORATÓRIO</th>
            </tr>
            <tr>
                <th style=\"width:120px;\">ENTRADA Nº</th>
                <td colspan='5'>".$entrada."</td>
            </tr>
            <tr>
                <th style=\"width:120px;\">FEITA POR</th>
                <td colspan='5'>".ucwords($responsavel)."</td>
            </tr>
            <tr>
                <th style=\"width:120px;\">TÉCNICO</th>
                <td colspan='5'>".ucwords($bscMail->getResult()[0]['nome'])."</td>
            </tr>
            <tr>
                <th style=\"width:120px;\">DATA</th>
                <td colspan='5'>".$data."</td>
            </tr>
            <tr>
                <th colspan='6' style=\"text-align: center;\">EQUIPAMENTOS DESSA ENTRADA</th>
            </tr>
            <tr>
                <th style=\"width: 100px;text-align: center;\">Patrimônio</th>
                <th style=\"width: 100px;text-align: center;\">OS</th>
                <th style=\"text-align: left;\">Equipamento</th>
                <th style=\"text-align: left;\">Localidade</th>
                <th style=\"width: 100px;text-align: center;\">Secretaria</th>
                <th>Observação</th>
            </tr>";
    $sql->FullRead("SELECT 
                        EQ.patrimonio,
                          M.modelo,
                          EQ.andar,
                          EQ.sala,
                          C.descricao equipamento,
                          IE.os_sti os,
                          IE.observacao,
                          L.local,
                          S.sigla,
                          F.nome_fabricante fabricante
                        FROM tb_sys004 EQ
                            JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                            JOIN tb_sys022 M ON M.id_modelo = EQ.modelo
                            JOIN tb_sys003 C ON C.id = EQ.id_categoria
                            JOIN tb_sys008 L ON L.id = EQ.id_local
                            JOIN tb_sys011 S ON S.id_secretaria = L.secretaria_id
                            JOIN tb_sys018 F ON F.id_fabricante = EQ.fabricante
                            JOIN tb_sys005 E ON E.identrada = IE.id_entrada
                            JOIN tb_sys001 T ON T.id = E.id_tecnico AND  E.identrada = :ID","ID={$entrada}");
    foreach ($sql->getResult() as $res):
    $msg .="<tr>
                <td style=\"text-align: center;\">".strtoupper($res['patrimonio'])."</td>
                <td style=\"text-align: center;\">".$res['os']."</td>
                <td style=\"text-align: left;\">".ucwords($res['equipamento'].' '.$res['fabricante'].' '.$res['modelo'])."</td>
                <td style=\"text-align: left;\">".ucwords($res['local'])."</td>
                <td style=\"text-align: center;\">".ucwords($res['sigla'])."</td>
                <td>". ucfirst($res['observacao'])."</td>
            </tr>";
    endforeach;
            
    $msg .="</table>";
    $mail->enviaMail("Entrada de Equipamento no Syslab",$emails,$msg);
    print intval($entrada);
    
else:
    print "<span class='alert alert-warning text-danger'>Entrada <b>vazia</b> não pode ser finalizada.</span>";
endif;
