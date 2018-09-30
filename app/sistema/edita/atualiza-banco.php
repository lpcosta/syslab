<?php
    paginaSegura();
    $sql = new Read();
    $ver = new Read();
    $cria = new Create();
    
    $sql->ExeRead("tb_sys015");
    $pecas = 0;
    
    
    /*foreach ($sql->getResult() as $peca):
        $ver->FullRead("select * from tb_sys027 WHERE codigo_peca = :PECA","PECA={$peca['id_peca']}");
        if($ver->getRowCount()==0):
            $cria->ExeCreate("tb_sys027", ["codigo_peca"=>$peca['id_peca'],"quantidade"=>$peca['qtde']]);
        $pecas ++;
        endif;
    endforeach;
    
    print "<h1><center>Pecas Adicionadas : {$pecas} </center></h1>";


  $atu = new Update();
  
    foreach ($sql->getResult() as $peca):
      $atu->ExeUpdate("tb_sys020", ["preco_peca"=>$peca['preco']], "WHERE peca_id = :PECA", "PECA={$peca['id_peca']}");
      print "Peça ".$peca['id_peca']." Preço ".$peca['preco']." Atualizado com sucesso"."<br />";
    endforeach;
     */