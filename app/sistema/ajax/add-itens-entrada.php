<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();
$cria       = new Create();
$texto      = new Check();

$sql->FullRead("SELECT id_status FROM tb_sys005 WHERE id_tecnico = :TEC AND identrada = :ID", "TEC={$tecnico}&ID={$entrada}");

    if($sql->getResult()[0]['id_status']==1 && !empty($txtPatrimonio)):
        
        $sql->FullRead("SELECT patrimonio FROM tb_sys004 WHERE patrimonio = :PAT", "PAT="."{$txtPatrimonio}"."");
        
        if($sql->getRowCount() != 0):
            
            $sql->FullRead("SELECT * FROM tb_sys006 WHERE patrimonio = :PAT AND status != :STS", "PAT="."{$txtPatrimonio}"."&STS=3");
            
            if($sql->getRowCount() != 0):
               print intval(1);
               $itens = NULL;
            else:
                if($txtOs != 10):
                    $sql->FullRead("SELECT * FROM tb_sys006 WHERE os_sti = :OS AND status != :STS", "OS={$txtOs}&STS=3");
                    if($sql->getRowCount() == 0):
                        $cria->ExeCreate("tb_sys006", ["id_entrada"=>$entrada,
                                                       "patrimonio"=>$texto->setTexto($txtPatrimonio),
                                                       "motivo"=>$texto->setTexto($txtMotivo),
                                                       "os_sti"=>$texto->setTexto($txtOs),
                                                       "observacao"=>$texto->setTexto($txtObservacoes),
                                                       "status"=>1,
                                                       "checklist"=>$texto->setTexto($txtChecklist),
                                                      ]);
                        if($cria->getResult()):
                            $itens = true;
                        else:
                            print $cria->getError();
                        endif;
                    else:
                        print intval(2);
                        $itens = NULL;
                    endif;
                else:
                    $cria->ExeCreate("tb_sys006", ["id_entrada"=>$entrada,
                                                       "patrimonio"=>$texto->setTexto($txtPatrimonio),
                                                       "motivo"=>$texto->setTexto($txtMotivo),
                                                       "os_sti"=>$texto->setTexto($txtOs),
                                                       "observacao"=>$texto->setTexto($txtObservacoes),
                                                       "status"=>1,
                                                       "checklist"=>$texto->setTexto($txtChecklist),
                                                      ]);
                        if($cria->getResult()):
                            $itens = true;
                        else:
                            print $cria->getError();
                        endif;
                endif;
            endif; 
        else:
            print intval(3);
        endif;
    else:
        $sql->FullRead("SELECT id FROM tb_sys006 WHERE id_entrada = :ENT","ENT={$entrada}");
        if($sql->getRowCount() > 0):
            $itens = TRUE;
        else:
            $itens = null;
        endif;
    endif;
    
if(isset($itens)){?>
<table class="table-responsive-sm tabela-tab table-hover">
    <tr style="background-color: #EBEBE4;">
        <th class="text-center">O.S</th>
        <th class="text-center">Patrimonio</th>
        <th>Equipamento</th>
        <th>Localidade</th>
        <th class="text-center">Secretaria</th>
    </tr>
    <?php
        $sql->FullRead("SELECT 
                            C.descricao equipamento,
                            M.modelo,
                            F.nome_fabricante fabricante,
                            IE.patrimonio,
                            IE.os_sti os,
                            S.sigla,
                            L.local localidade
                        FROM
                            tb_sys004 EQ
                                JOIN
                            tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                                JOIN
                            tb_sys022 M ON id_modelo = EQ.modelo
                                JOIN
                            tb_sys003 C ON C.id = EQ.id_categoria
                                JOIN
                            tb_sys018 F ON F.id_fabricante = EQ.fabricante
                                JOIN
                            tb_sys008 L ON L.id = EQ.id_local
                                JOIN
                            tb_sys011 S ON S.id_secretaria = L.secretaria_id
                                AND IE.id_entrada = :ENT AND IE.status = :STS",
                        "ENT={$entrada}&STS=1");
        foreach ($sql->getResult() as $iten):
    ?>
    <tr class="text-capitalize">
        <td class="text-center"><?=$iten['os']?></td>
        <td class="text-center"><?=$iten['patrimonio']?></td>
        <td><?=$iten['equipamento'].' '.$iten['fabricante'].' '.$iten['modelo'];?></td>
        <td><?=$iten['localidade']?></td>
        <td class="text-uppercase text-center"><?=$iten['sigla']?></td>
    </tr>
    <? endforeach;?>
</table>
<?}