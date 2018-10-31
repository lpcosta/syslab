<?php
    paginaSegura();
    $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#ag-peca">Relatório de Bancada</a></li>
    </ul>
    <div id="ag-peca" class="header-report">
        <form id="form-header-report-bancada" onsubmit="return false">
            <input type="hidden" name="acao" value="bancada" />
            <div class="row">
                <div class="col form-inline">
                    <label>Técnico</label>
                    <select name="id_tecnico" id="txtTecnico" style="width: 250px;">
                        <?php $sql->FullRead("SELECT id,nome FROM tb_sys001 WHERE situacao = :SIT AND tipo = :TIPO ORDER BY nome","SIT=".'l'."&TIPO=".'bancada'."");?>
                        <option selected value="t">Todos</option>
                        <?php foreach ($sql->getResult() as $res):
                        print "<option value=".$res['id'].">".ucfirst($res['nome'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col form-inline">
                    <label>Data Inicial</label>
                    <input type="text"  name="dt_inicial" id="txtDtIni" class="data form-control" />
                </div>
                <div class="col form-inline">
                    <label>Data Final</label>
                    <input type="text"  name="dt_final" id="txtDtFim" class="data form-control" />
                </div>
                <div class="col form-inline">
                    <input type="button" class="btn btn-primary gera-relatorio" value="Gerar Relatório" style="margin-right: 5px;" onclick="validaRelatorio('bancada','#form-header-report-bancada');" />
                    <input type="button" class="btn btn-primary gera-excel" value="Gerar Excel" onclick="geraExel('agpeca');" style="display: none; margin-right: 5px;" />
                    
                    <span style="width: 40px;"><img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /></span>
                    
                    <button type="button" class="btn btn-primary" onclick="imprime();">Imprimir</button>
                </div>
            </div>
        </form>
        <div id="printArea" class="relatorio printTable">
            <script type="text/javascript">
                google.charts.load("current", {packages: ["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                google.charts.setOnLoadCallback(graficoStatus);
                google.charts.setOnLoadCallback(graficoEquipamentos);
                
                /*graficos dos equipamentos*/
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                    ['','Tec.'],
                    <?
                    $mes = date('m');
                    /*$dt_ini = date('Y') . "-" . "$mes" . "-01";
                    $dt_fin = date('Y') . "-" . "$mes" . "-31";*/
                    $dt = new Datas();
                    $sql->FullRead("SELECT tecnico.nome tecnico,count(*) total FROM tb_sys010 avaliacao 
                                            JOIN tb_sys001 tecnico ON tecnico.id = avaliacao.id_tecnico_bancada 
                                        AND avaliacao.id_status != :STS AND avaliacao.data between :DTINI AND :DTFIM GROUP BY id_tecnico_bancada", "STS=3&DTINI="."{$dt->geraDatas()[0]}"."&DTFIM="."{$dt->geraDatas()[1]}"."");
                    $total = 0;
                    foreach ($sql->getResult() as $ava) {
                        /* Essa é a maneira correta de printer os array’s pois de qualquer outra maneira não irá printar */
                        print "['" . ucwords($ava['tecnico']) . "'," . $ava['total'] . "],";
                        $total += $ava['total'];
                    }
                    ?>]);
                    var options = {
                        /*title: 'Produtividade da Bancada ' + ' (' +<?= $total ?> + ' Avaliaçoes)',*/
                        is3D: true
                    };
                    /*var chart = new google.visualization.ColumnChart(document.getElementById('grafico-bancada'));*/
                    var chart = new google.visualization.ColumnChart(document.getElementById('grafico-bancada'));
                    chart.draw(data, options);
                    var chart = new google.visualization.PieChart(document.getElementById('grafico-bancada-pie'));
                    chart.draw(data, options);
                }
                
                function graficoStatus() {
                    var data = google.visualization.arrayToDataTable([
                    ['',''],
                    <?
                    $data = new Datas();
                    $sql->FullRead("SELECT S.descricao status, COUNT(*) total
                            FROM
                                tb_sys010 avaliacao 
                                JOIN 
                                tb_sys006 IE ON IE.id = avaliacao.id_item_entrada
                                    JOIN
                                tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio
                                    JOIN
                                tb_sys002 S ON S.id = avaliacao.id_status
                            AND avaliacao.data BETWEEN :DTINI AND :DTFIM
                            GROUP BY S.id ORDER BY S.id;", "DTINI="."{$data->geraDatas()[0]}"."&DTFIM="."{$data->geraDatas()[1]}"."");
                    
                    foreach ($sql->getResult() as $ava) {
                        print "['" . ucwords($ava['status']) . "'," . $ava['total'] . "],";
                    }
                    ?>]);
                    var options = {
                        is3D: true
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('grafico-bancada-status-pie'));
                    chart.draw(data, options);
                }
                
                function graficoEquipamentos() {
                    var data = google.visualization.arrayToDataTable([
                    ['',''],
                    <?
                    $datas = new Datas();
                    $sql->FullRead("SELECT C.descricao equipamento, COUNT(*) total
                            FROM
                                tb_sys010 avaliacao 
                                    JOIN
                                tb_sys006 IE ON IE.id = avaliacao.id_item_entrada
                                    JOIN
                                tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio
                                    JOIN
                                tb_sys003 C ON C.id = EQ.id_categoria
                            AND avaliacao.data BETWEEN :DTINI AND :DTFIM
                            GROUP BY C.id ORDER BY C.id;", "DTINI="."{$datas->geraDatas()[0]}"."&DTFIM="."{$datas->geraDatas()[1]}"."");
                    
                    foreach ($sql->getResult() as $ava) {
                        print "['" . ucwords($ava['equipamento']) . "'," . $ava['total'] . "],";
                    }
                    ?>]);
                    var options = {
                        is3D: true
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('grafico-bancada-equipamento-pie'));
                    chart.draw(data, options);
                }
            </script>
            <hr />
            <h2 class="text-primary">Produtividade da Bancada (<?=$total?> Avaliações)</h2>
            <div class="row">
                <div class="col">
                    <div id="grafico-bancada-pie" style="min-height: 400px;height: 100%; width: 98%; "></div>
                </div>
                <div class="col">
                    <div id="grafico-bancada" style="min-height: 400px;height: 100%; width: 98%;"></div>
                </div>
            </div>
            <h2 class="text-primary">Avaliações por Status</h2>
            <div class="row">
                <div class="col">
                    <div id="grafico-bancada-status-pie" style="height: 400px;"></div>
                </div>
            </div>
            <h2 class="text-primary">Avaliações por Equipamento</h2>
            <div class="row">
                <div class="col">
                    <div id="grafico-bancada-equipamento-pie" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>