<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../libs/PHPMailer/src/PHPMailer.php';
require_once '../../libs/PHPMailer/src/Exception.php';
require_once '../../libs/PHPMailer/src/SMTP.php';
require_once '../../config/post.inc.php';
$sql    = new Read();
$cria   = new Create();
$texto  = new Check();
$atu    = new Update();
$mail   = new Email();
$sql->FullRead("SELECT email FROM tb_sys001 WHERE id = :ID","ID={$id_tecnico_bancada}");
$emailbancada = $sql->getResult()[0]['email'];
$post['data'] = date("Y-m-d");
$post['hora'] = date("H:i:s");

$emails = [$emailbancada,$email_tecnico_entrada];

if($id_status != 5):
    $post['peca_id']=null;
endif;
if($id_status == 7):
    array_push($emails, 'GDSSilva@santoandre.sp.gov.br');
endif;
unset($post['email_tecnico_entrada']);   
$cria->ExeCreate("tb_sys010", $post);
if($cria->getResult()):
    $data_avaliacao = date('d/m/Y H:i');
    $atu->ExeUpdate("tb_sys006", ["status"=>$id_status], "WHERE id = :ID","ID={$id_item_entrada}");
    $sql->FullRead("SELECT T.nome,
                           EQ.patrimonio,
                           EQ.andar,
                           EQ.sala,
                           M.modelo,
                           IE.os_sti os,
                           IE.motivo,
                           IE.observacao,
                           S.descricao status,
                           C.descricao equipamento,
                           L.local,
                           F.nome_fabricante fabricante
                        FROM tb_sys004 EQ
                            JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                            JOIN tb_sys022 M ON M.id_modelo = EQ.modelo
                            JOIN tb_sys003 C ON C.id = EQ.id_categoria
                            JOIN tb_sys010 A ON A.id_item_entrada = IE.id
                            JOIN tb_sys002 S ON S.id = A.id_status
                            JOIN tb_sys018 F ON F.id_fabricante = EQ.fabricante
                            JOIN tb_sys001 T ON T.id = A.id_tecnico_bancada
                            JOIN tb_sys008 L ON L.id = EQ.id_local AND IE.id = :ITEM order by A.id desc limit 1","ITEM={$id_item_entrada}");

$msg = "<table style=\"margin: 0 auto;\">
            <tr>
                <th colspan=\"2\" style=\"text-align: center;\">STI - AVISO DE AVALIAÇÃO DE EQUIPAMENTO</th>
            </tr>
            <tr>
                <th style=\"width: 200px;text-align: left;\">EQUIPAMENTO</th>
                <td>".ucwords($sql->getResult()[0]['equipamento'].' '.$sql->getResult()[0]['fabricante'].' '.$sql->getResult()[0]['modelo'])."</td>
            </tr>
            <tr>
                <th style=\"width: 200px;text-align: left;\">LOCALIDADE</th>
                <td>". ucwords($sql->getResult()[0]['local']) ."</td>
            </tr>
            <tr>
                <th style=\"width: 200px;text-align: left;\">ORDEM DE SERVIÇO</th>
                <td>{$sql->getResult()[0]['os']} <b> PATRIMÔNIO </b>".strtoupper($sql->getResult()[0]['patrimonio'])."</td>
            </tr>
            <tr>
                <th style=\"width: 200px;text-align: left;\">MOTIVO DA ENTRADA</th>
                <td>". ucwords($sql->getResult()[0]['motivo'])."</td>
            </tr>
            <tr>
                <th style=\"width: 200px;text-align: left;\">OBSERVAÇOES</th>
                <td>". ucfirst($sql->getResult()[0]['observacao'])."</td>
            </tr>
            <tr>
                <th style=\"width: 200px;text-align: left;\">STATUS</th>
                <td>". ucwords($sql->getResult()[0]['status'])."</td>
            </tr>";
    if($id_status == 5):
        $bscpeca = new Read();
        $bscpeca->FullRead("SELECT descricao_peca FROM tb_sys015 WHERE id_peca = :ID","ID={$peca_id}");
        $msg .="<tr>
                <th style=\"width: 200px;text-align: left;\">PEÇA</th>
                <td>{$peca_id} -".ucwords($bscpeca->getResult()[0]['descricao_peca'])."</td>
                </tr>";
            endif;
        $msg .="
            <tr>
                <th style=\"width: 200px;text-align: left;\">AVALIAÇÃO</th>
                <td>". ucfirst($texto->setTexto($avaliacao))."</td>
            </tr>
             <tr>
                 <th colspan=\"2\">&nbsp;</th>
            </tr>
             <tr>
                <th style=\"width: 200px;text-align: left;\">Avaliação Feita por </th>
                <td>". ucwords($sql->getResult()[0]['nome'])." Em ".$data_avaliacao."</td>
            </tr>
        </table>";
        $mail->enviaMail("Avaliação de Equipamento - Syslab",$emails,$msg);
        print "<span class=\"alert alert-success text-primary\">Avaliação Realizada com sucesso!</span>";
else:
    print "Error <code>".$cria->getError()."</code><br /><hr />";
endif;