<?php
   paginaSegura();
  $sql = new Read();
  $atu = new Update();
  
  
    function setAtualiza(array $entrada ){
        $sql = new Read();
        $atu = new Update();
        $sql->FullRead("SELECT id,id_local,andar,sala,id_categoria ,fabricante,modelo,ip FROM tb_sys004 WHERE patrimonio = :PAT", "PAT=360609");
        if($sql->getResult()):
                if($sql->getResult()[0]['id_categoria'] != $entrada['id_categoria']):
                    print "as categorias são diferente";
                endif;
        endif;
    }
    
    $dados =[  "fabricante"=>4,
                "modelo"=>25,
                "id_categoria"=>1,
                "id_local"=>2
            ];
    
    setAtualiza($dados);