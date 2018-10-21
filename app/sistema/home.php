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
        </div><!-- primeira linha -->
        <div class="row"><!-- segunda linha -->
            <div class="col-md">
                <script>
                    function graficoTotalEquipamento() {
                        var grafico = google.visualization.arrayToDataTable([
                          ['Lab', 'STI'],
                          <?
                          foreach ($equipamentos as $row) {
                                  print "['" . ucwords($row['equipamento']) . "'," . $row['total'] . "],";
                          }
                          ?>
                        ]);
                        var options = {
                          is3D: true
                        };
                        var graficoeqpmt = new google.visualization.PieChart(document.getElementById('graficoequipamentos'));
                        graficoeqpmt.draw(grafico, options);
                    }
                </script>
                <div id="graficoequipamentos" class="grafico-home" > </div> 
            </div>
            <div class="col-md">
                <script>
                    function graficoEntregas() {
                        var grafico = google.visualization.arrayToDataTable([
                            ['Lab', 'STI'],
                        <?
                            foreach ($entregas as $row) {
                                 print "['" . ucwords($row['equipamento']) . "'," . $row['total'] . "],";
                         }
                         ?>
                            ]);
                            var options = {
                                is3D: true
                            };
                            var graficoentrega = new google.visualization.PieChart(document.getElementById('graficoentregas'));
                            graficoentrega.draw(grafico, options);
                    }
                </script>
                <div id="graficoentregas" class="grafico-home"> </div>         
            </div>
            <div class="col-md">
                <script>
                    function graficoStatus() {
                        var grafico = google.visualization.arrayToDataTable([
                        ['Lab', 'STI'],
                        <?
                        foreach ($stsEquipamento as $row) {
                        print "['" . ucwords($row['descricao']) . "'," . $row['total'] . "],";
                        }
                        ?>
                        ]);
                        var options = {
                            is3D: true
                        };

                        var graficostatus = new google.visualization.PieChart(document.getElementById('graficostatus'));
                        graficostatus.draw(grafico, options);
                    }
                </script>
                <div id="graficostatus" class="grafico-home" > </div> 
            </div>
        </div><!-- segunda linha -->
    </div><!-- div home -->
   
</div><!-- div tabs-->
<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(graficoTotalEquipamento);  
    google.charts.setOnLoadCallback(graficoEntregas);
    google.charts.setOnLoadCallback(graficoStatus);
</script>