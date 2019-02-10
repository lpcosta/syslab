<?php
    paginaSegura();
    $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#equipamento">Relatório de Equipamento </a></li>
    </ul>
        <div id="equipamento" class="header-report">
        <form id="form-header-report-equipamento" onsubmit="return false">
            <input type="hidden" name="acao" value="equipamento" />
            <div class="row">
                <div class="col form-inline">
                    <label>Tipo de Equipamento</label>
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
                    <!--<input type="text" id="txtCr" class="form-control" onblur="setaLocalidade(this.value);" placeholder="CR" onkeyup="if (event.keyCode == 13){$('#bsclocalidade').focus();}" style="width: 80px;"/>-->
                    <select id="txtLocalidade" name="localidade" class="text-capitalize form-control" style="width: calc(100% - 85px);" >
                        <option selected value="">Selecione...</option>                        
                        <?$sql->FullRead("SELECT id,local FROM tb_sys008 ORDER BY local");
                        foreach($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".$res['local']."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col form-inline">
                    <input type="button" class="btn btn-primary" value="Gerar Relatório" onclick="validaRelatorio('equipamento','#form-header-report-equipamento')" style="margin-right: 5px;">
                    
                    <span style="width: 38px;"><img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /></span>
                    
                    <button type="button" class="btn btn-primary" onclick="imprime();">Imprimir</button>
                </div>
            </div>
            <hr />
        </form>
    </div>
    <div id="printArea" class="relatorio printTable"> </div>
</div>