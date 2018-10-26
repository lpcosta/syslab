<?php
    paginaSegura();
    $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#ag-peca">Relatório de Aguardo de Peça</a></li>
    </ul>
    <div id="ag-peca" class="header-report">
        <form id="form-header-report-agpeca" onsubmit="return false">
            <input type="hidden" name="acao" value="agpeca" />
            <div class="row">
                <div class="col form-inline">
                    <label>Equipamento</label>
                    <select class="form-control" id="txtEquipamento" name="categoria" onchange="$('.gera-relatorio').show();$('.gera-excel').hide();">
                        <?php $sql->ExeRead("tb_sys003"); ?>
                        <option selected value="">Selecione...</option>
                        <option value="0">Todos</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".ucfirst($res['descricao'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col form-inline">
                    <div class="cod-rel form-inline">
                        <label style="width: 80px;">Secretaria</label>
                        <select id="txtSecretaria" name="secretaria" class="text-capitalize form-control" style="width: calc(100% - 85px);" onchange="$('.gera-relatorio').show();$('.gera-excel').hide();">
                        <option selected value="">Selecione...</option>                        
                        <?$sql->ExeRead("tb_sys011 ORDER BY nome_secretaria");
                        foreach($sql->getResult() as $res):
                               print "<option value=".$res['id_secretaria'].">".$res['nome_secretaria']."</option>";
                        endforeach;
                        ?>
                        </select>
                    </div>
                </div>
                <div class="col form-inline">
                    <input type="button" class="btn btn-primary gera-relatorio" value="Gerar Relatório" style="margin-right: 5px;" onclick="validaRelatorio('agpeca','#form-header-report-agpeca');" />
                    <input type="button" class="btn btn-primary gera-excel" value="Gerar Excel" onclick="geraExel('agpeca');" style="display: none; margin-right: 5px;" />
                    
                    <span style="width: 40px;"><img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /></span>
                    
                    <button type="button" class="btn btn-primary" onclick="imprime();">Imprimir</button>
                
                </div>
            </div>
            <hr />
        </form>
        <div id="printArea" class="relatorio printTable">
            
        </div>
    </div>
</div>