<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql = new Read();

switch ($acao):
    case 'saida':
        switch ($tipoRel):
            case 'codigo':
                $sql->ExeRead("tb_sys007 WHERE id ={$id_saida}");
                if($sql->getRowCount() > 0):
                     $sql->FullRead("SELECT nome,data,hora,nome_fun,doc_fun FROM tb_sys007 saida
                                    JOIN tb_sys001 tecnico ON tecnico.id = saida.id_tecnico AND saida.id = :ID ","ID={$id_saida}");
                    $dadosTecnico = $sql->getResult()[0];
                    $sql->FullRead("SELECT EQ.patrimonio, C.descricao equipamento,IE.os_sti,L.local,L.rua,L.bairro,F.nome_fabricante fabricante,M.modelo,EQ.andar,EQ.sala
                                    FROM tb_sys004 EQ
                                        JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                                        JOIN tb_sys022 M ON M.id_modelo = EQ.modelo
                                        JOIN tb_sys003 C ON C.id = EQ.id_categoria
                                        JOIN tb_sys008 L ON L.id = EQ.id_local
                                        JOIN tb_sys018 F ON F.id_fabricante = EQ.fabricante
                                        JOIN tb_sys009 ISA ON ISA.id_item_entrada = IE.id
                                        JOIN tb_sys007 S ON S.id = ISA.id_saida AND  ISA.id_saida= :IDSAIDA","IDSAIDA={$id_saida}");
                    $dtperiodo = 'data';  
                endif;?>
                <table>
                    <tr>
                        <th rowspan="5" style="width: 78px;"><img src="<?= LOGO_LORAC ?>"/></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center text-uppercase"><?= PREFEITURA ?></th>
                        <th rowspan="4" style="width: 78px;"><img src="<?= LOGO_SYSLAB ?>"/></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center text-uppercase"><?= SECRETARIA ?></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center text-uppercase"><?= DIRETORIA ?></th>
                    </tr>
                    <tr>
                        <th class="text-center text-uppercase"><?= GERENCIA ?></th>
                    </tr>
                    <tr>
                        <th colspan="4">&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-center text-uppercase">saída de equipamento</th>
                    </tr>
                    <tr class="text-uppercase">
                        <th>Saída nº</th>
                        <td colspan="2"><?=$id_saida?></td>
                    </tr>
                    <tr class="text-uppercase">
                        <th>técnico</th>
                        <td colspan="2"><?=$dadosTecnico['nome']?></td>
                    </tr>
                    <tr class="text-uppercase">
                        <th><?=$dtperiodo?></th>
                        <td colspan="2"><?=date("d/m/Y",strtotime($dadosTecnico['data'])).' '.$dadosTecnico['hora']?></td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">            
                            <table class="table-hover">
                                <tr>
                                    <th class="text-center">OS</th>
                                    <th class="text-center">PATRIMONIO</th>
                                    <th>EQUIPAMENTO</th>
                                    <th>LOCAL</th>
                                    <th>ENDEREÇO</th>
                                </tr>
                                <? foreach ($sql->getResult() as $res):?>
                                <tr class="text-capitalize">
                                    <td class="text-center"><?=$res['os_sti']?></td>
                                    <td class="text-center"><?=$res['patrimonio']?></td>
                                    <td><?=$res['equipamento'] . ' ' . $res['fabricante'] . ' ' . $res['modelo'];?></td>
                                    <td><?=$res['local']?></td>
                                    <td><?=$res['rua'].' '.$res['andar'];if(!empty($res['sala'])){print " - Sala ".$res['sala'];}?></td>
                                </tr>
                                <? endforeach;?>
                            </table>
                        </td>
                    </tr>
                </table>
                <?break;
            case 'tecnico':
                 $sql->FullRead("SELECT saida.id,saida.data,saida.hora,S.descricao status, COUNT(*) total_itens
                                    FROM tb_sys007 saida 
                                        JOIN tb_sys009 itens ON itens.id_saida = saida.id 
                                        JOIN tb_sys002 S ON S.id = saida.id_status AND saida.id_tecnico = :TECNICO
                                    GROUP BY itens.id_saida ORDER BY saida.id desc;","TECNICO={$id_tecnico}");
                ?>
            <table class="table-hover">
                <tr>
                    <th class="text-center">NÚMERO</th>
                    <th class="text-center">DATA</th>
                    <th class="text-center">STATUS</th>
                    <th class="text-center">EQUIPAMENTO(S)</th>
               </tr>
               <? foreach ($sql->getResult() as $res):?>
               <tr class="bg-tab-tr" onclick="location.href='index.php?pg=relatorio/saida&id='+<?=$res['id'];?>" style="cursor: pointer;">
                    <td class="text-center"><?=$res['id'];?></td>
                    <td class="text-center"><?= date('d/m/Y',strtotime($res['data'])).' '.$res['hora'];?></td>
                    <td class="text-center"><?=$res['status']?></td>
                    <td class="text-center"><?=$res['total_itens'];?></td>
                </tr>
                <? endforeach;?>
            </table>
             <?break;
            default:
                print "<h1 class='text-center alert alert-info'>Erro desconhecido!<br /><code> nenhuma das condições inposta para mostrar relatorio de saida foi encontrada</code></h1>";
        endswitch;
        break;
    case 'entrada':
        break;
    default :
        print "<h1>ERRO! parametro que especifica o tipo de relatroio nao passado!</h1>";
endswitch;
