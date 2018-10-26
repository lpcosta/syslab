<?php
   paginaSegura();
  $sql = new Read();
  $atu = new Update();
  
  
  /*atualizar os preços de referencia de acordo com o ultimo resgistrado*/
  /*
  $sql->ExeRead("tb_sys020");
  foreach ($sql->getResult() as $res):
      $atu->ExeUpdate("tb_sys015", ["preco_refencia"=>$res['preco_peca']], "WHERE id_peca = :ID", "ID={$res['peca_id']}");
      if($atu->getResult()):
           print "Peça ".$res['peca_id']." Atualizada !</br />";
      else:
          print $atu->getError();
      endif;
  endforeach;
*/
function random_color() {
    $letters = '0123456789ABCDEF';
    for($i = 0; $i < 6; $i++) {
        $index = rand(0,15);
       $letters[$i] = $index;
    }
    return substr($letters, 0, 6); // abcd$letters;
}
print $cor = random_color();