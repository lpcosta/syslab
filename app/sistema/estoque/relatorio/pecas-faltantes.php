<?php
   paginaSegura();
    if(GRUPO != 4):
       header("Location:".HOME."");
       exit();
   endif;
  $sql = new Read();
  $sql->FullRead("SELECT 
                P.descricao_peca peca,
                P.id_peca,
                E.preco_peca preco,
                E.quantidade,
                E.data,
                E.nf FROM tb_sys028 E JOIN tb_sys015 P ON P.id_peca = E.peca_id order by id_peca");
?>
<div class="tabs">
    <ul>
        <li><a href="#r-e-e">Relatório de Entrada de Peça </a></li>
    </ul>
    <div id="r-e-e" class="header-report">
        <form id="form-header-report" onsubmit="return false">
            <div class="row">
                <div class="col form-inline">
                    <label>Data Inicial</label>
                    <input type="text"  name="dt_inicial" id="txtDtIni" class="data form-control" />
                    &nbsp;
                    <label>Data Final</label>
                    <input type="text"  name="dt_final" id="txtDtFim" class="data form-control" />
                </div>
                <div class="col form-inline">
                    <input type="submit" class="btn btn-primary" value="Gerar Relatório">
                    &nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                    
                    <button type="button" class="btn btn-primary btnPrinter" style="display: none;" onclick="imprimi();">Imprimir</button>
                </div>
            </div>
            <hr />
        </form>
    </div>

    <div class="relatorio printTable">
        <table class="table-bordered">
                <tr class="text-uppercase">
                    <th class="text-center">código</th>
                    <th class="text-left">peça</th>
                    <th class="text-center">preço</th>
                    <th class="text-center">qtde.</th>
                    <th class="text-center">data</th>
                </tr>
                <? foreach ($sql->getResult() as $res):?>
                <tr>
                    <td class="text-center"><?=$res['id_peca']?></td>
                    <td class="text-capitalize"><?=$res['peca']?></td>
                    <td class="text-center">R$ <?=str_replace(".",",",$res['preco'])?></td>
                    <td class="text-center"><?=$res['quantidade']?></td>
                    <td><?=date("d/m/Y",strtotime($res['data']))?></td>
                </tr>
                <? endforeach;?>
            </table>
    </div>
</div>