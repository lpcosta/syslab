<?php
    paginaSegura();
    $sql = new Read();
    $sql2 = new Read();
    $sql3 = new Read();
    $cria = new Create();
    $dt=0;
    $sql->ExeRead("tb_sys028 where peca_id=61 ");
    $sql2->ExeRead("tb_sys020 where peca_id=61");
    print "Quantidade 1".$sql->getRowCount()."<br />";
    print "Quantidade 2".$sql2->getRowCount()."<br />";