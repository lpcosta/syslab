<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql = new Read();
$dt  = new Datas();
$texto  = new Check();
foreach ($post as $key => $value):
    $post[$key]=$texto->setTexto($value);
endforeach;

switch ($acao):
    case 'saida':
        switch ($tipoRel):
            case 'codigo':
                $sql->ExeRead("tb_sys007 WHERE id ={$id_saida}");
                if($sql->getResult() && $sql->getRowCount() > 0):
                     $sql->FullRead("SELECT nome,data,hora,nome_fun,doc_fun,responsavel FROM tb_sys007 saida
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
                    $dtperiodo = 'data';?>
               <table class="relatorio">
                    <tr>
                        <th rowspan="5" style="width:110px;"><img src="<?= LOGO_PSA ?>"/></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center text-uppercase"><?= PREFEITURA ?></th>
                        <th rowspan="4" style="width:110px;">&nbsp;</th>
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
                   <tr>
                        <td colspan="5">
                            <table class="relatorio">
                                <tr class="left">
                                    <td><b>Saída</b></td>
                                    <td><?=$id_saida?></td>
                                    <td><b>Data</b></td>
                                    <td><?=date("d/m/Y",strtotime($dadosTecnico['data'])).' '.$dadosTecnico['hora']?></td>
                                </tr>
                                <tr class="left">
                                    <td><b>Feita Por</b></td>
                                    <td class="text-capitalize"><?=$dadosTecnico['responsavel']?></td>
                                    <td><b>Em Nome de</b></td>
                                <?if(empty($dadosTecnico['nome_fun'])):?>
                                    <td colspan="2" class="text-capitalize"><?=$dadosTecnico['nome']?></td>
                                <?elseif(!empty($dadosTecnico['nome_fun'])):?>
                                    <td colspan="2" class="text-capitalize"><?=$dadosTecnico['nome_fun'].' <b>RG/IF</b> '.$dadosTecnico['doc_fun']?></td>
                                <?endif;?>
                                </tr>
                            </table>                    
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">            
                            <table class="relatorio">
                                <tr>
                                    <th class="text-center">OS</th>
                                    <th class="text-center">PATRIMONIO</th>
                                    <th class="left">EQUIPAMENTO</th>
                                    <th class="left">LOCAL</th>
                                    <th class="left">ENDEREÇO</th>
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
                <table class="relatorio" style="margin-top:50px;">
                    <tr>
                        <th class="text-center">_______________________________________</th>

                        <th class="text-center">_______________________________________</th>
                    </tr>
                    <tr>
                        <th class="text-center">Técnico</th>

                        <th class="text-center">Responsável</th>
                    </tr>
                </table>
                <?else:
                    print "<h1 class='alert alert-info text-primary text-center'>Saída não encontrada!</h1>";
                    endif;
                break;
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
            case 'periodo':
                $timeZone = new DateTimeZone('UTC');
                if(!empty($dt_inicial) && !empty($dt_final)):
                    $dtini = $dt->validarData($dt_inicial);
                    $dtfim = $dt->validarData($dt_final);
                    if($dtini && $dtfim):
                        $data1 = DateTime::createFromFormat ('d/m/Y', $dt_inicial, $timeZone);
                        $data2 = DateTime::createFromFormat ('d/m/Y', $dt_final, $timeZone);
                        if($data1<= $data2):
                            $sql->FullRead("SELECT saida.id,
                                        saida.data,
                                        saida.hora,
                                        T.nome,
                                        S.descricao status,
                                        COUNT(*) total_itens
                                    FROM tb_sys007 saida 
                                        JOIN tb_sys009 itens ON itens.id_saida = saida.id
                                        JOIN tb_sys001 T ON T.id = saida.id_tecnico
                                        JOIN tb_sys002 S ON S.id = saida.id_status AND saida.data BETWEEN :DTINI AND :DTFIM
                                    GROUP BY itens.id_saida ORDER BY saida.id desc","DTINI=".$dt->setDt($dt_inicial)."&DTFIM=".$dt->setDt($dt_final)."");
                        else:
                            print "<h1 class='text-center alert alert-info'>A data inicial nao pode ser maior que a final</h1>";
                            exit();
                        endif;
                    else:
                        print "<h1 class='text-center alert alert-info'>Uma das Datas Informadas não é válida!</h1>";
                    endif;
                elseif(!empty($dt_inicial)):
                    $dtini = $dt->validarData($dt_inicial);
                    if($dtini):
                        $sql->FullRead("SELECT saida.id,saida.data,saida.hora, T.nome,S.descricao status, COUNT(*) total_itens
                                    FROM tb_sys007 saida 
                                        JOIN tb_sys009 itens ON itens.id_saida = saida.id 
                                        JOIN tb_sys001 T ON T.id = saida.id_tecnico
                                        JOIN tb_sys002 S ON S.id = saida.id_status AND saida.data = :DATA
                                    GROUP BY itens.id_saida ORDER BY saida.id desc","DATA=".$dt->setDt($dt_inicial)."");
                    else:
                        print "<h1 class='text-center alert alert-info'>A data Inicial Informada e Inválida!</h1>";
                    endif;
                elseif(!empty($dt_final)):
                    $dtfim = $dt->validarData($dt_final);
                    if($dtfim):
                        $sql->FullRead("SELECT saida.id,saida.data,saida.hora, T.nome,S.descricao status, COUNT(*) total_itens
                                    FROM tb_sys007 saida 
                                        JOIN tb_sys009 itens ON itens.id_saida = saida.id 
                                        JOIN tb_sys001 T ON T.id = saida.id_tecnico
                                        JOIN tb_sys002 S ON S.id = saida.id_status AND saida.data = :DATA
                                    GROUP BY itens.id_saida ORDER BY saida.id desc","DATA=".$dt->setDt($dt_final)."");
                    else:
                        print "<h1 class='text-center alert alert-info'>A data Final Informada e Inválida!</h1>";
                    endif;
                endif;?>
                <table class="table-hover">
                    <tr>
                        <th class="text-center">NÚMERO</th>
                        <th class="text-left">TÉCNICO</th>
                        <th class="text-center">DATA</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">EQUIPAMENTO(S)</th>
                   </tr>
                    <?foreach ($sql->getResult() as $res):?>
                    <tr class="bg-tab-tr" onclick="location.href='index.php?pg=relatorio/saida&id='+<?=$res['id'];?>" style="cursor: pointer;">
                         <td class="text-center"><?=$res['id'];?></td>
                         <td class="text-left text-capitalize"><?=$res['nome'];?></td>
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
       switch ($tipoRel):
            case 'codigo':
                $sql->ExeRead("tb_sys005 WHERE identrada ={$id_entrada}");
                if($sql->getResult() && $sql->getRowCount() > 0):
                     $sql->FullRead("SELECT nome,data,hora,nome_fun,doc_fun,nome_responsavel FROM tb_sys005 entrada
                                    JOIN tb_sys001 tecnico ON tecnico.id = entrada.id_tecnico AND entrada.identrada = :ID ","ID={$id_entrada}");
                    $dadosTecnico = $sql->getResult()[0];
                    $sql->FullRead("SELECT EQ.patrimonio, C.descricao equipamento,IE.os_sti,L.local,L.rua,L.bairro,F.nome_fabricante fabricante,M.modelo,EQ.andar,EQ.sala
                                    FROM tb_sys004 EQ
                                        JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                                        JOIN tb_sys022 M  ON M.id_modelo = EQ.modelo
                                        JOIN tb_sys003 C  ON C.id = EQ.id_categoria
                                        JOIN tb_sys008 L  ON L.id = EQ.id_local
                                        JOIN tb_sys018 F  ON F.id_fabricante = EQ.fabricante
                                        JOIN tb_sys005 E  ON E.identrada = IE.id_entrada AND  E.identrada= :ID","ID={$id_entrada}");
                    $dtperiodo = 'data';?>
                <table class="relatorio">
                    <tr>
                        <th rowspan="5" style="width:110px;"><img src="<?= LOGO_PSA ?>"/></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center text-uppercase"><?= PREFEITURA ?></th>
                        <th rowspan="4" style="width:110px;">&nbsp;</th>
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
                        <th colspan="4" class="text-center text-uppercase">entrada de equipamento</th>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <table class="relatorio">
                                <tr class="left">
                                    <td><b>Entrada</b></td>
                                    <td><?=$id_entrada?></td>
                                    <td><b>Data</b></td>
                                    <td><?=date("d/m/Y",strtotime($dadosTecnico['data'])).' '.$dadosTecnico['hora']?></td>
                                </tr>
                                <tr class="left">
                                    <td><b>Feita Por</b></td>
                                    <td class="text-capitalize"><?=$dadosTecnico['nome_responsavel']?></td>
                                    <td><b>Em Nome de</b></td>
                                <?if(empty($dadosTecnico['nome_fun'])):?>
                                    <td colspan="2" class="text-capitalize"><?=$dadosTecnico['nome']?></td>
                                <?elseif(!empty($dadosTecnico['nome_fun'])):?>
                                    <td colspan="2" class="text-capitalize"><?=$dadosTecnico['nome_fun'].' <b>RG/IF</b> '.$dadosTecnico['doc_fun']?></td>
                                <?endif;?>
                                </tr>
                            </table>                    
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">            
                            <table class="relatorio">
                                <tr>
                                    <th class="text-center">OS</th>
                                    <th class="text-center">PATRIMONIO</th>
                                    <th class="left" style="min-width: 180px;">EQUIPAMENTO</th>
                                    <th class="left">LOCAL</th>
                                    <th class="left">ENDEREÇO</th>
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
                <table class="relatorio" style="margin-top:50px;">
                    <tr>
                        <th class="text-center">_______________________________________</th>

                        <th class="text-center">_______________________________________</th>
                    </tr>
                    <tr>
                        <th class="text-center">Técnico</th>

                        <th class="text-center">Responsável</th>
                    </tr>
                </table>
                <?else:
                    print "<h1 class='alert alert-info text-primary text-center'>Entrada não encontrada!</h1>";
                    endif;
                break;
            case 'tecnico':
                $sql->FullRead("SELECT entrada.identrada,entrada.data,entrada.hora,S.descricao status, COUNT(*) total_itens
                                    FROM tb_sys005 entrada 
                                        JOIN tb_sys006 itens ON itens.id_entrada = entrada.identrada 
                                        JOIN tb_sys002 S ON S.id = entrada.id_status AND entrada.id_tecnico = :TECNICO
                                    GROUP BY itens.id_entrada ORDER BY entrada.identrada desc;","TECNICO={$id_tecnico}");
                ?>
            <table class="relatorio">
                <tr>
                    <th class="text-center">NÚMERO</th>
                    <th class="text-center">DATA</th>
                    <th class="text-center">STATUS</th>
                    <th class="text-center">EQUIPAMENTO(S)</th>
               </tr>
               <? foreach ($sql->getResult() as $res):?>
               <tr class="bg-tab-tr" onclick="location.href='index.php?pg=relatorio/entrada&id='+<?=$res['identrada'];?>" style="cursor: pointer;">
                    <td class="text-center"><?=$res['identrada'];?></td>
                    <td class="text-center"><?= date('d/m/Y',strtotime($res['data'])).' '.$res['hora'];?></td>
                    <td class="text-center"><?=$res['status']?></td>
                    <td class="text-center"><?=$res['total_itens'];?></td>
                </tr>
                <? endforeach;?>
            </table>
             <?break;
            case 'periodo':
                $timeZone = new DateTimeZone('UTC');
                if(!empty($dt_inicial) && !empty($dt_final)):
                    $dtini = $dt->validarData($dt_inicial);
                    $dtfim = $dt->validarData($dt_final);
                    if($dtini && $dtfim):
                        $data1 = DateTime::createFromFormat ('d/m/Y', $dt_inicial, $timeZone);
                        $data2 = DateTime::createFromFormat ('d/m/Y', $dt_final, $timeZone);
                        if($data1<= $data2):
                            $sql->FullRead("SELECT entrada.identrada,
                                        entrada.data,
                                        entrada.hora,
                                        T.nome,
                                        S.descricao status,
                                        COUNT(*) total_itens
                                    FROM tb_sys005 entrada 
                                        JOIN tb_sys006 itens ON itens.id_entrada = entrada.identrada
                                        JOIN tb_sys001 T ON T.id = entrada.id_tecnico
                                        JOIN tb_sys002 S ON S.id = entrada.id_status AND entrada.data BETWEEN :DTINI AND :DTFIM
                                    GROUP BY itens.id_entrada ORDER BY entrada.identrada desc","DTINI=".$dt->setDt($dt_inicial)."&DTFIM=".$dt->setDt($dt_final)."");
                        else:
                            print "<h1 class='text-center alert alert-info'>A data inicial nao pode ser maior que a final</h1>";
                            exit();
                        endif;
                    else:
                        print "<h1 class='text-center alert alert-info'>Uma das Datas Informadas não é válida!</h1>";
                    endif;
                elseif(!empty($dt_inicial)):
                    $dtini = $dt->validarData($dt_inicial);
                    if($dtini):
                        $sql->FullRead("SELECT entrada.identrada,entrada.data,entrada.hora, T.nome,S.descricao status, COUNT(*) total_itens
                                    FROM tb_sys005 entrada 
                                        JOIN tb_sys006 itens ON itens.id_entrada = entrada.identrada 
                                        JOIN tb_sys001 T ON T.id = entrada.id_tecnico
                                        JOIN tb_sys002 S ON S.id = entrada.id_status AND entrada.data = :DATA
                                    GROUP BY itens.id_entrada ORDER BY entrada.identrada desc","DATA=".$dt->setDt($dt_inicial)."");
                    else:
                        print "<h1 class='text-center alert alert-info'>A data Inicial Informada e Inválida!</h1>";
                    endif;
                elseif(!empty($dt_final)):
                    $dtfim = $dt->validarData($dt_final);
                    if($dtfim):
                        $sql->FullRead("SELECT entrada.identrada,entrada.data,entrada.hora, T.nome,S.descricao status, COUNT(*) total_itens
                                    FROM tb_sys005 entrada 
                                        JOIN tb_sys006 itens ON itens.id_entrada = entrada.identrada 
                                        JOIN tb_sys001 T ON T.id = entrada.id_tecnico
                                        JOIN tb_sys002 S ON S.id = entrada.id_status AND entrada.data = :DATA
                                    GROUP BY itens.id_entrada ORDER BY entrada.identrada desc","DATA=".$dt->setDt($dt_final)."");
                    else:
                        print "<h1 class='text-center alert alert-info'>A data Final Informada e Inválida!</h1>";
                    endif;
                endif;?>
                <table class="relatorio">
                    <tr>
                        <th class="text-center">NÚMERO</th>
                        <th class="text-left">TÉCNICO</th>
                        <th class="text-center">DATA</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">EQUIPAMENTO(S)</th>
                   </tr>
                    <?foreach ($sql->getResult() as $res):?>
                    <tr class="bg-tab-tr" onclick="location.href='index.php?pg=relatorio/entrada&id='+<?=$res['identrada'];?>" style="cursor: pointer;">
                         <td class="text-center"><?=$res['identrada'];?></td>
                         <td class="text-left text-capitalize"><?=$res['nome'];?></td>
                         <td class="text-center"><?= date('d/m/Y',strtotime($res['data'])).' '.$res['hora'];?></td>
                         <td class="text-center"><?=$res['status']?></td>
                         <td class="text-center"><?=$res['total_itens'];?></td>
                     </tr>
                <? endforeach;?>
                </table>
            <?break;
            default:
                print "<h1 class='text-center alert alert-info'>Erro desconhecido!<br /><code> nenhuma das condições inposta para mostrar relatorio de entrada foi encontrada</code></h1>";
        endswitch;
        break;
    case 'agpeca':
        unset($post['acao']);
        if($categoria == 0 && empty($secretaria)):
            $sql->FullRead("SELECT C.descricao equipamento,F.nome_fabricante fabricante,
                                   M.modelo,EQ.patrimonio,IE.os_sti os,L.local localidade,
                                   P.descricao_peca peca,A.data dtava
                            FROM   tb_sys004 EQ JOIN
                                tb_sys006 IE ON IE.patrimonio = EQ.patrimonio JOIN
                                tb_sys022 M ON M.id_modelo = EQ.modelo        JOIN
                                tb_sys003 C ON C.id = EQ.id_categoria         JOIN
                                tb_sys008 L ON L.id = EQ.id_local             JOIN
                                tb_sys010 A ON A.id_item_entrada = IE.id      JOIN
                                tb_sys015 P ON P.id_peca = A.peca_id          JOIN
                                tb_sys018 F ON F.id_fabricante = EQ.fabricante
                                AND IE.status = :STATUS ORDER BY A.data", "STATUS=5");
            $equipamento = "todos";                    
            $_secretaria = "todas";             
        elseif($categoria != 0 && empty($secretaria)):
            $sql->FullRead("SELECT C.descricao equipamento,F.nome_fabricante fabricante,
                                   M.modelo,EQ.patrimonio,IE.os_sti os,L.local localidade,
                                   P.descricao_peca peca,A.data dtava
                            FROM   tb_sys004 EQ JOIN
                                tb_sys006 IE ON IE.patrimonio = EQ.patrimonio JOIN
                                tb_sys022 M ON M.id_modelo = EQ.modelo        JOIN
                                tb_sys003 C ON C.id = EQ.id_categoria         JOIN
                                tb_sys008 L ON L.id = EQ.id_local             JOIN
                                tb_sys010 A ON A.id_item_entrada = IE.id      JOIN
                                tb_sys015 P ON P.id_peca = A.peca_id          JOIN
                                tb_sys018 F ON F.id_fabricante = EQ.fabricante
                                AND IE.status = :STATUS AND C.id = :CATEG ORDER BY A.data", "STATUS=5&CATEG={$categoria}");
            $equipamento = $sql->getResult()[0]['equipamento'];
            $_secretaria = "todas";     
        elseif(empty($categoria) && !empty($secretaria)):
            $sql->FullRead("SELECT C.descricao equipamento,F.nome_fabricante fabricante,
                                   M.modelo,EQ.patrimonio,IE.os_sti os,L.local localidade,
                                   P.descricao_peca peca,A.data dtava,S.nome_secretaria
                            FROM   tb_sys004 EQ JOIN
                                tb_sys006 IE ON IE.patrimonio = EQ.patrimonio       JOIN
                                tb_sys022 M ON M.id_modelo = EQ.modelo              JOIN
                                tb_sys003 C ON C.id = EQ.id_categoria               JOIN
                                tb_sys008 L ON L.id = EQ.id_local                   JOIN
                                tb_sys011 S ON S.id_secretaria = L.secretaria_id    JOIN
                                tb_sys010 A ON A.id_item_entrada = IE.id            JOIN
                                tb_sys015 P ON P.id_peca = A.peca_id                JOIN
                                tb_sys018 F ON F.id_fabricante = EQ.fabricante
                                AND IE.status = :STATUS AND S.id_secretaria = :SEC ORDER BY A.data", "STATUS=5&SEC={$secretaria}");
            $equipamento = "todos";
            $_secretaria = $sql->getResult()[0]['nome_secretaria']; 
        elseif(!empty($categoria) && !empty($secretaria)):
            $sql->FullRead("SELECT C.descricao equipamento,F.nome_fabricante fabricante,
                                   M.modelo,EQ.patrimonio,IE.os_sti os,L.local localidade,
                                   P.descricao_peca peca,A.data dtava,S.nome_secretaria
                            FROM   tb_sys004 EQ JOIN
                                tb_sys006 IE ON IE.patrimonio = EQ.patrimonio       JOIN
                                tb_sys022 M ON M.id_modelo = EQ.modelo              JOIN
                                tb_sys003 C ON C.id = EQ.id_categoria               JOIN
                                tb_sys008 L ON L.id = EQ.id_local                   JOIN
                                tb_sys011 S ON S.id_secretaria = L.secretaria_id    JOIN
                                tb_sys010 A ON A.id_item_entrada = IE.id            JOIN
                                tb_sys015 P ON P.id_peca = A.peca_id                JOIN
                                tb_sys018 F ON F.id_fabricante = EQ.fabricante
                                AND IE.status = :STATUS AND S.id_secretaria = :SEC AND C.id = :CATEG ORDER BY A.data", "STATUS=5&SEC={$secretaria}&CATEG={$categoria}");
            $equipamento = $sql->getResult()[0]['equipamento'];
            $_secretaria = $sql->getResult()[0]['nome_secretaria']; 
        else:
            $sql->FullRead("SELECT C.descricao equipamento,F.nome_fabricante fabricante,
                                   M.modelo,EQ.patrimonio,IE.os_sti os,L.local localidade,
                                   P.descricao_peca peca,A.data dtava
                            FROM   tb_sys004 EQ JOIN
                                tb_sys006 IE ON IE.patrimonio = EQ.patrimonio JOIN
                                tb_sys022 M ON M.id_modelo = EQ.modelo        JOIN
                                tb_sys003 C ON C.id = EQ.id_categoria         JOIN
                                tb_sys008 L ON L.id = EQ.id_local             JOIN
                                tb_sys010 A ON A.id_item_entrada = IE.id      JOIN
                                tb_sys015 P ON P.id_peca = A.peca_id          JOIN
                                tb_sys018 F ON F.id_fabricante = EQ.fabricante
                                AND IE.status = :STATUS ORDER BY A.data", "STATUS=5");
            $equipamento = "todos";
            $_secretaria = "todas";
        endif;
        if($sql->getResult()):?>
            <table class="relatorio">
                <tr>
                    <th rowspan="5" style="width:110px;"><img src="<?= LOGO_PSA ?>"/></th>
                </tr>
                <tr>
                    <th colspan="2" class="text-center text-uppercase"><?= PREFEITURA ?></th>
                    <th rowspan="4" style="width:110px;">&nbsp;</th>
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
                    <th colspan="4" class="text-center text-uppercase">relatório de aguardo de peças</th>
                </tr>
                <tr>
                    <td colspan="5">
                        <table class="relatorio">
                            <tr class="left">
                                <td><b>Data</b></td>
                                <td><?=date("d/m/Y H:i:s")?></td>
                                <td><b>Secretaria</b></td>
                                <td class="text-capitalize"><?=$_secretaria?></td>
                            </tr>
                            <tr class="left">
                                <td><b>Equipamento</b></td>
                                <td class="text-capitalize"><?=$equipamento?></td>
                                <td><b>Registros</b></td>
                                <td colspan="2" class="text-capitalize"><?=$sql->getRowCount()?></td>
                            </tr>
                        </table>                    
                    </td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">            
                        <table class="relatorio">
                            <tr>
                                <th class="text-center">OS</th>
                                <th class="text-center">PATRIMONIO</th>
                                <th class="left" style="min-width: 180px;">EQUIPAMENTO</th>
                                <th class="left">LOCALIDADE</th>
                                <th class="left">PEÇA</th>
                                <th class="text-center">DT.AVALIAÇÂO</th>
                            </tr>
                            <? foreach ($sql->getResult() as $res):?>
                            <tr class="text-capitalize">
                                <td class="text-center"><?=$res['os']?></td>
                                <td class="text-center"><?=$res['patrimonio']?></td>
                                <td><?=$res['equipamento'] . ' ' . $res['fabricante'] . ' ' . $res['modelo'];?></td>
                                <td><?=$res['localidade']?></td>
                                <td><?=$res['peca']?></td>
                                <td class="text-center"><?=date("d/m/Y",strtotime($res['dtava']))?></td>
                            </tr>
                            <? endforeach;?>
                        </table>
                    </td>
                </tr>
            </table>
        <?else:?>
        <h1 class="text-center text-capitalize text-danger">nenhum registro encontrado!</h1>    
        <?endif;?>
       <?break;
    case 'entrada-peca':
        unset($post['acao']);
        $dtini  = $dt->setDt($post['dt_inicial']);
        $dtfim  = $dt->setDt($post['dt_final']);
        $sql->FullRead("SELECT P.descricao_peca peca,P.id_peca,R.peca_serie serie,
                        R.responsavel,R.preco_peca preco,R.observacao,
                        sum(R.quantidade) quantidade,R.dt_recebimento data,
                        F.nome_fornecedor fornecedor
                    FROM
                        tb_sys020 R JOIN
                        tb_sys015 P ON P.id_peca = R.peca_id JOIN
                        tb_sys019 F ON F.id_fornecedor = R.fornecedor_id
                    AND R.dt_recebimento between :DTINI AND :DTFIM GROUP BY P.id_peca ORDER BY R.dt_recebimento DESC", "DTINI="."{$dtini}"."&DTFIM="."{$dtfim}"."");
        ?>
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
                <th colspan="4" class="text-center">RELATÓRIO DE RECEBIMENTO DE PEÇA</th>
            </tr>
            <tr>
                <th>Período</th>
                <td colspan="3"><?=$dt_inicial.' À '.$dt_final?></td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">            
                    <table class="table-bordered">
                        <tr class="text-uppercase">
                            <th class="text-center">código</th>
                            <th class="text-left">peça</th>
                            <th class="text-center">preço</th>
                            <th class="text-center">qtde.</th>
                            <th class="text-left">fornecedor</th>
                            <th class="text-center">data</th>
                            <th class="text-center">série</th>
                        </tr>
                        <? foreach ($sql->getResult() as $res):?>
                        <tr>
                            <td class="text-center"><?=$res['id_peca']?></td>
                            <td class="text-capitalize"><?=$res['peca']?></td>
                            <td class="text-center">R$ <?=str_replace(".",",",$res['preco'])?></td>
                            <td class="text-center"><?=$res['quantidade']?></td>
                            <td class="text-capitalize"><?=$res['fornecedor']?></td>
                            <td><?=date("d/m/Y",strtotime($res['data']))?></td>
                            <td class="text-center text-uppercase"><?=$res['serie']?></td>
                        </tr>
                        <? endforeach;?>
                    </table>
                </td>
            </tr>
        </table>
        <?break;
    case 'saida-peca':
        unset($post['acao']);
        $dtini  = $dt->setDt($post['dt_inicial']);
        $dtfim  = $dt->setDt($post['dt_final']);
        if(isset($resumo)):
            $sql->FullRead("SELECT B.dt_baixa,B.ordem_servico os,B.peca_id,P.descricao_peca peca,count(peca_id) quantidade
                            FROM tb_sys015 P 
                            JOIN tb_sys016 B ON B.peca_id = P.id_peca
                        AND B.dt_baixa between :DTINI and :DTFIM GROUP BY B.peca_id", "DTINI="."{$dtini}"."&DTFIM="."{$dtfim}"."");
        else:
            $sql->FullRead("SELECT B.dt_baixa,B.ordem_servico os,B.peca_id,P.descricao_peca peca
                            FROM tb_sys015 P 
                            JOIN tb_sys016 B ON B.peca_id = P.id_peca
                        AND B.dt_baixa between :DTINI and :DTFIM", "DTINI="."{$dtini}"."&DTFIM="."{$dtfim}"."");                    
        endif;
        ?>
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
                <th colspan="4" class="text-center">RELATÓRIO DE SAÍDA DE PEÇA</th>
            </tr>
            <tr>
                <th>Período</th>
                <td colspan="3"><?=$dt_inicial.' À '.$dt_final?></td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">            
                    <table class="table-bordered">
                        <tr class="text-uppercase">
                            <th class="text-center">código</th>
                            <th class="text-left">peça</th>
                        <?if(isset($resumo)):?>
                            <th class="text-center">Quantidade</th>
                        <?else:?>
                            <th class="text-center">os</th>
                            <th class="text-center">dt.saida</th>
                        <?endif;?>
                        </tr>
                        <? foreach ($sql->getResult() as $res):?>
                        <tr>
                            <td class="text-center"><?=$res['peca_id']?></td>
                            <td class="text-capitalize"><?=$res['peca']?></td>
                         <?if(isset($resumo)):?>
                            <td class="text-center"><?=$res['quantidade']?></td>
                         <?else:?>
                            <td class="text-center"><?=$res['os']?></td>
                            <td class="text-center"><?=date("d/m/Y",strtotime($res['dt_baixa']))?></td>
                        <?endif;?>
                        </tr>
                        <? endforeach;?>
                    </table>
                </td>
            </tr>
        </table>
        <?break;
    case 'bancada':
        unset($post['acao']);
        $dtini  = $dt->setDt($post['dt_inicial']);
        $dtfim  = $dt->setDt($post['dt_final']);
        if(intval($id_tecnico)):
            $sql->FullRead("SELECT tecnico.nome, C.descricao equipamento, COUNT(*) total
                            FROM
                                tb_sys001 tecnico
                                    JOIN
                                tb_sys010 avaliacao ON tecnico.id = avaliacao.id_tecnico_bancada
                                    JOIN
                                tb_sys006 IE ON IE.id = avaliacao.id_item_entrada
                                    JOIN
                                tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio
                                    JOIN
                                tb_sys003 C ON C.id = EQ.id_categoria
                                    AND avaliacao.data BETWEEN :DTINI AND :DTFIM
                                    AND tecnico.id = :IDTEC
                            GROUP BY C.id ORDER BY tecnico.nome", "DTINI="."{$dtini}"."&DTFIM="."{$dtfim}"."&IDTEC={$id_tecnico}");
                $tecnico = $sql->getResult()[0]['nome'];
                $total = 0;
                foreach ($sql->getResult() as $res):
                    $total += $res['total'];
                endforeach;
        ?>
        <hr />
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
                <th colspan="4" class="text-center">RELATÓRIO DE BANCADA</th>
            </tr>
            <tr>
                <td colspan="5">
                    <table class="relatorio">
                        <tr class="left">
                            <td><b>Emissão</b></td>
                            <td><?=date("d/m/Y H:i:s")?></td>
                            <td><b>Período</b></td>
                            <td><?=$dt_inicial.' À '.$dt_final?></td>
                        </tr>
                        <tr class="left">
                            <td><b>Técnico</b></td>
                            <td class="text-capitalize"><?=$tecnico?></td>
                            <td><b>Avaliações</b></td>
                            <td><?=$total?></td>
                        </tr>
                    </table>                    
                </td>
            </tr>
            <tr>
                <td colspan="5">            
                    <table class="table-bordered">
                        <tr class="text-uppercase">
                            <th class="text-center">Equipamento</th>
                            <th class="text-center">Total</th>
                        </tr>
                        <?foreach ($sql->getResult() as $res):?>
                        <tr class="text-capitalize">
                            <td class="text-center"><?=$res['equipamento']?></td>
                            <td class="text-center"><?=$res['total']?></td>
                        </tr>
                        <?endforeach;?>
                    <?$sql->FullRead("SELECT 
                                    tecnico.nome, S.descricao status, COUNT(*) total
                                FROM
                                    tb_sys001 tecnico
                                        JOIN
                                    tb_sys010 avaliacao ON tecnico.id = avaliacao.id_tecnico_bancada
                                        JOIN
                                    tb_sys006 IE ON IE.id = avaliacao.id_item_entrada
                                        JOIN
                                    tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio
                                        JOIN
                                    tb_sys002 S ON S.id = avaliacao.id_status
                                        AND avaliacao.data BETWEEN :DTINI AND :DTFIM
                                        AND tecnico.id = :IDTEC
                                GROUP BY S.id
                                ORDER BY tecnico.nome;", "DTINI="."{$dtini}"."&DTFIM="."{$dtfim}"."&IDTEC={$id_tecnico}");
                    ?>
                        <tr class="text-uppercase">
                            <th class="text-center">Status</th>
                            <th class="text-center">Total</th>
                        </tr>
                        <?foreach ($sql->getResult() as $res):?>
                        <tr class="text-capitalize">
                            <td class="text-center"><?=$res['status']?></td>
                            <td class="text-center" style="width: 200px;"><?=$res['total']?></td>
                        </tr>
                        <?endforeach;?>
                    </table>
                </td>
            </tr>
        </table>
        <?endif;?>
      <?break;
    default :
        print "<h1>ERRO! parametro que especifica o tipo de relatório nao passado!</h1>";
endswitch;
