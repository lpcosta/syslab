<?php
paginaSegura();
$sql = new Read();
$dt = new Datas();                 

$sql->FullRead("SELECT C.descricao equipamento,COUNT(*) total,C.id
                                FROM tb_sys003 C 
                                JOIN tb_sys004 EQ ON EQ.id_categoria = C.id
                                JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio AND IE.status != :STS GROUP BY C.id ORDER BY total desc","STS=3");
$equipamentos   = $sql->getResult();

$sql->FullRead("SELECT id FROM tb_sys006 WHERE status != :STS","STS=3"); //Total de equipamentos no lab
$totalEntradas  = $sql->getRowCount();

$sql->FullRead("SELECT C.descricao equipamento,C.id, count(*) total FROM tb_sys004 EQ
                                JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                                JOIN tb_sys003 C  ON C.id = EQ.id_categoria AND IE.status = :STS group by C.id order by total desc","STS=4");
$entregas = $sql->getResult(); 

$sql->FullRead("SELECT S.descricao, COUNT(*) total, S.id FROM tb_sys002 S JOIN tb_sys006 E ON E.status = S.id and E.status != :STS GROUP BY E.status order by S.descricao","STS=3");
$stsEquipamento = $sql->getResult();

?>
            
<div class="tabs">
    <ul>
        <li><a href="#home">Home</a></li>

    </ul>
    <div id="home">
        <div class="row">
            <div class="col-md">
                <table class="table-responsive-sm tabela-tab table-hover">
                    <tr class="text-primary">
                        <th class="text-uppercase text-center" colspan="2">equipamentos no laboratório</th>
                    </tr>
                    <tr class="text-capitalize">
                        <th>equipamento</th>
                        <th class="text-center">quantidade</th>
                    </tr>
                <? foreach ($equipamentos as $res):?>
                    <tr class="text-capitalize">
                        <td><?=$res['equipamento']?></td>
                        <td class="text-center"><?=$res['total']?></td>
                    </tr>
                <?endforeach;?>
                    <tr class="text-primary text-uppercase">
                        <th>Total</th>
                        <th class="text-center"><?=$totalEntradas;?></th>
                    </tr>
                </table>
            </div>
             <div class="col-md">
               <table class="table-responsive-sm tabela-tab table-hover">
                    <tr class="text-primary">
                        <th class="text-uppercase text-center" colspan="2">entregas</th>
                    </tr>
                    <tr class="text-capitalize">
                        <th>equipamento</th>
                        <th class="text-center">quantidade</th>
                    </tr>
                <?$totalEntregas = 0; foreach ($entregas as $res):?>
                    <tr class="text-capitalize">
                        <td><?=$res['equipamento']?></td>
                        <td class="text-center"><?=$res['total']?></td>
                    </tr>
                <?$totalEntregas += $res['total'];endforeach;?>
                    <tr class="text-primary text-uppercase" style="cursor:pointer;" onclick="location.href='index.php?pg=laboratorio#entrega';">
                        <th>Total</th>
                        <th class="text-center"><?=$totalEntregas?></th>
                    </tr>
                </table>
            </div>
             <div class="col-md">
                <table class="table-responsive-sm tabela-tab table-hover">
                    <tr class="text-primary">
                        <th class="text-uppercase text-center" colspan="2">status</th>
                    </tr>
                    <tr class="text-capitalize">
                        <th>equipamento</th>
                        <th class="text-center">quantidade</th>
                    </tr>
                <? foreach ($stsEquipamento as $res):?>
                    <tr class="text-capitalize">
                    <?if($res['id']==1){?>
                        <th class="text-primary text-uppercase" style="cursor:pointer;" onclick="location.href='index.php?pg=laboratorio#pendente';"><?=$res['descricao']?></th>
                        <th class="text-primary text-center" style="cursor:pointer;" onclick="location.href='index.php?pg=laboratorio#pendente';"><?=$res['total']?></th>
                    <?}else{?>
                        <td><?=$res['descricao']?></td>
                        <td class="text-center"><?=$res['total']?></td>
                    <?}?>
                    </tr>
                <?endforeach;?>
                </table>
            </div>
        </div>
        <h2 class="text-capitalize">laboratório</h2>
        <div class="row home-charts">
                <div class="col-md">
<!--          <h3>Laboratorio</h3>-->
                  <?php
                  
                   $sql->FullRead("SELECT 
                        C.descricao equipamento, COUNT(*) total
                    FROM
                        tb_sys003 C
                            JOIN
                        tb_sys004 EQ ON EQ.id_categoria = C.id
                            JOIN
                        tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                            AND IE.status != :S
                    GROUP BY C.id
                    ORDER BY total DESC", "S=3");
                   
                  ?>
                  <script>
                    function graficoTotalEquipamento() {
                      
                      var grafico = google.visualization.arrayToDataTable([
                        ['Lab', 'STI'],
                        <?
                        $totalentradas = 0;
                        foreach ($sql->getResult() as $row) {
                                print "['" . ucwords($row['equipamento']) . "'," . $row['total'] . "],";
                                $totalentradas += $row['total'];
                        }
                        ?>
                      ]);
                      var options = {
                        title: 'Equipamentos' + ' ' + <?=$totalentradas?>+'',
                        is3D: true
                      };
                      var grafico_eqp = new google.visualization.PieChart(document.getElementById('piechart'));
                      grafico_eqp.draw(grafico, options);
                    }
                   
                </script>
                <div id="piechart" class="grafico-home" > </div> 
                </div>
                <div class="col-md ">
<!--                  <h3>Entradas do Mês</h3>-->
                   <?php
                   
                   $sql->FullRead("SELECT 
                        C.descricao equipamento, COUNT(*) total
                    FROM
                        tb_sys004 EQ
                            JOIN
                        tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                            JOIN
                        tb_sys003 C ON C.id = EQ.id_categoria
                            JOIN
                        tb_sys005 E ON E.identrada = IE.id_entrada
                            AND E.data BETWEEN :dtini AND :dtfim GROUP BY C.id", "dtini=". $dt->geraDatas()[0] ."&dtfim=". $dt->geraDatas()[1] ."");      
                   ?>
                   <script>
                    function graficoEntradasMes() {
                       
                        var grafico = google.visualization.arrayToDataTable([
                        ['Lab', 'STI'],
                        <?
                           
                    $totalentradas = 0;
                    foreach ($sql->getResult() as $row) {
                       
                        print "['" . ucwords($row['equipamento']) . "'," . $row['total'] . "],";
                        $totalentradas += $row['total'];
                }
                ?>
                        ]);

                        var options = {
                            title: 'Entradas desse Mês ' +<?= $totalentradas; ?> + '',
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
                        chart.draw(grafico, options);
                    }
                    
                </script>
                <div id="piechart1" class="grafico-home"> </div> 
                </div>
                <div class="col-md">
<!--                   <h3>Saídas do Mês</h3>-->
                    <?php
                   
                   $sql->FullRead("SELECT 
                            C.descricao equipamento, COUNT(*) total
                        FROM
                            tb_sys004 EQ
                                JOIN
                            tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                                JOIN
                            tb_sys003 C ON C.id = EQ.id_categoria
                                JOIN
                            tb_sys009 SAIDA ON SAIDA.id_item_entrada = IE.id
                                JOIN
                            tb_sys007 S ON S.id = SAIDA.id_saida
                                AND S.data BETWEEN :dtini AND :dtfim GROUP BY C.id", "dtini=". $dt->geraDatas()[0] ."&dtfim=". $dt->geraDatas()[1] ."");      
                   ?>
                   <script>
                    function graficoSaidasMes() {
                      
                        var grafico = google.visualization.arrayToDataTable([
                        ['Lab', 'STI'],
                        <?
                           
                    $totalentradas = 0;
                    foreach ($sql->getResult() as $row) {
                       
                        print "['" . ucwords($row['equipamento']) . "'," . $row['total'] . "],";
                        $totalentradas += $row['total'];
                }
                ?>
                        ]);

                        var options = {
                            title: 'Saídas desse Mês ' +<?= $totalentradas; ?> + '',
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                        chart.draw(grafico, options);
                    }
                    
                </script>
                <div id="piechart2" class="grafico-home" > </div> 
                </div>
            </div>
    </div><!-- div home -->
   
</div><!-- div tabs-->
<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(graficoTotalEquipamento);  
    google.charts.setOnLoadCallback(graficoSaidasMes);
    google.charts.setOnLoadCallback(graficoEntradasMes);
</script>