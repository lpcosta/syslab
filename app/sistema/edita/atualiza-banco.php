<?php
   paginaSegura();
  $sql = new Read();
  $atu = new Update();
  /*
  $sql->FullRead("SELECT S.id saida,S.data,T.nome from tb_sys007 S JOIN tb_sys001 T ON T.id = S.id_tecnico");
  
  foreach ($sql->getResult() as $res):
      $atu->ExeUpdate("tb_sys007", ["responsavel"=>$res['nome']], "WHERE id = :ID", "ID={$res['saida']}");
      if($atu->getResult()):
           print "Saida ".$res['saida']."Atualiza!</br />";
      else:
          print $atu->getError();
      endif;
  endforeach;
*/