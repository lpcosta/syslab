<?php
require_once './app/config/pagina-segura.php';

$sql = new Read();

$dtini = '2018-04-01'; 
$dtfim = '2018-04-30';
?>

<div class="tabs">
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="app/sistema/ajax/entregas.php">Entregas</a></li>
        <li><a href="app/sistema/ajax/agpeca.php">Aguardo de Peças</a></li>
        <li><a href="app/sistema/ajax/pendencias.php">Pendências</a></li>
        
       
    </ul>
    <div id="home">
        
            <div class="row">
                <div class="col-md">
                  <h3>Laboratorio</h3>
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
                        title: 'Totoal de Equipamentos' + ' ' + <?=$totalentradas?>+'',
                        is3D: true
                      };
                      var grafico_eqp = new google.visualization.PieChart(document.getElementById('piechart'));
                      grafico_eqp.draw(grafico, options);
                    }
                   
                </script>
                <div id="piechart" class="grafico-home" > </div> 
                </div>
                <div class="col-md ">
                   <h3>Entradas do Mês</h3>
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
                            AND E.data BETWEEN :dtini AND :dtfim GROUP BY C.id", "dtini=". $dtini ."&dtfim=". $dtfim ."");      
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
                            title: 'Total de Equipamentos ' +<?= $totalentradas; ?> + '',
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
                        chart.draw(grafico, options);
                    }
                    
                </script>
                <div id="piechart1" class="grafico-home"> </div> 
                </div>
                <div class="col-md">
                   <h3>Saídas do Mês</h3>
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
                                AND S.data BETWEEN :dtini AND :dtfim GROUP BY C.id", "dtini=". $dtini ."&dtfim=". $dtfim ."");      
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
                            title: 'Total de Equipamentos ' +<?= $totalentradas; ?> + '',
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                        chart.draw(grafico, options);
                    }
                    
                </script>
                <div id="piechart2" class="grafico-home" > </div> 
                </div>
            </div>
        
    </div>
</div>
<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(graficoTotalEquipamento);  
    google.charts.setOnLoadCallback(graficoSaidasMes);
    google.charts.setOnLoadCallback(graficoEntradasMes);
</script>