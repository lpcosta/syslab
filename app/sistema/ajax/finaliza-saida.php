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

$sql->FullRead("SELECT * FROM tb_sys009 WHERE id_saida = :SAIDA", "SAIDA={$saida}");
if($sql->getRowCount() > 0):
    $atu->ExeUpdate("tb_sys007",["id_status"=>3], "WHERE id = :SAIDA", "SAIDA={$saida}");
    
    $bscMail->FullRead("SELECT T.email,T.nome FROM tb_sys001 T JOIN tb_sys007 S ON S.id_tecnico = T.id AND S.id = :SAIDA","SAIDA={$saida}");
    
    $emails = [$bscMail->getResult()[0]['email'],$mailResp];
    
    $data = date('d/m/Y H:i:s');

    $msg = "<table style=\"margin: 0 auto;\">
            <tr>
                <th colspan=\"6\" style=\"text-align: center;\">STI - SAÍDA DE EQUIPAMENTO DO LABORATÓRIO</th>
            </tr>
            <tr>
                <th style=\"width:120px;\">SAIDA Nº</th>
                <td colspan='5'>".$saida."</td>
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
                <th colspan='6' style=\"text-align: center;\">EQUIPAMENTOS DESSA SAIDA</th>
            </tr>
            <tr>
                <th style=\"width: 100px;text-align: center;\">Patrimônio</th>
                <th style=\"width: 100px;text-align: center;\">OS</th>
                <th style=\"text-align: left;\">Equipamento</th>
                <th style=\"text-align: left;\">Localidade</th>
                <th style=\"width: 100px;text-align: center;\">Endereço</th>
            </tr>";
    $sql->FullRead("SELECT 
                        EQ.patrimonio,
                        M.modelo,
                        EQ.andar,
                        EQ.sala,
                        IE.os_sti os,
                        C.descricao equipamento,
                        F.nome_fabricante fabricante,
                        L.local,
                        L.rua
                    FROM
                        tb_sys006 IE
                            JOIN
                        tb_sys009 SAIDA ON SAIDA.id_item_entrada = IE.id
                            JOIN
                        tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio
                            JOIN
                        tb_sys022 M ON M.id_modelo = EQ.modelo
                            JOIN
                        tb_sys003 C ON C.id = EQ.id_categoria
                            JOIN
                        tb_sys008 L ON L.id = EQ.id_local
                            JOIN
                        tb_sys018 F ON F.id_fabricante = EQ.fabricante
                            JOIN
                        tb_sys007 S ON S.id = SAIDA.id_saida
                            JOIN
                        tb_sys001 T ON T.id = S.id_tecnico AND S.id = :ID","ID={$saida}");
    
    foreach ($sql->getResult() as $res):
        $endereco = $res['local'].' '.$res['andar'];
    if(!empty($res['sala'])){$endereco .=" - Sala ".$res['sala'];}
    $msg .="<tr>
                <td style=\"text-align: center;\">".strtoupper($res['patrimonio'])."</td>
                <td style=\"text-align: center;\">".$res['os']."</td>
                <td style=\"text-align: left;\">".ucwords($res['equipamento'].' '.$res['fabricante'].' '.$res['modelo'])."</td>
                <td style=\"text-align: center;\">".ucwords($endereco)."</td>
                <td style=\"text-align: center;\">".ucwords($res['rua'])."</td>
            </tr>";
    endforeach;
            
    $msg .="</table>";
    $mail->enviaMail("Saída de Equipamento - Syslab",$emails,$msg);
    print intval($saida);
else:
    print "Saida <b>vazia</b> não pode ser finalizada.";
endif;