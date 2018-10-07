<?php
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';

$sql        = new Read();

$patrimonio = strtolower($patrimonio);

$sql->FullRead("SELECT id FROM tb_sys004 WHERE patrimonio = :PAT", "PAT={$patrimonio}");

if($sql->getRowCount() > 0):
    $sql->FullRead("SELECT c.descricao equipamento,
                            c.id id_categoria,
                            l.local localidade,
                            l.id id_local,
                            l.cr,
                            f.nome_fabricante fabricante,
                            f.id_fabricante,
                            m.modelo,
                            eq.modelo id_modelo,
                            eq.status,
                            eq.andar,
                            eq.sala,
                            eq.ip,
                                    eq.sala FROM tb_sys004 eq
                                    JOIN tb_sys003 c ON c.id = eq.id_categoria
                                    JOIN tb_sys022 m ON m.id_modelo = eq.modelo
                                    JOIN tb_sys008 l ON l.id = eq.id_local
                                    JOIN tb_sys018 f ON f.id_fabricante = eq.fabricante AND eq.patrimonio = :PAT ", "PAT={$patrimonio}");

    $loc = [30,31,32,33];

    if ($sql->getResult()):
        if ($sql->getResult()[0]['status'] == 'baixado'):
            print intval(4); 
        else:
            print_r(implode(",",$sql->getResult()[0]));
        endif;
    endif;
else:
    print intval(3);     
endif;

