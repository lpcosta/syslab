<?php
   paginaSegura();
    $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#saida" id="txtSaida">Saída de Equipamento</a></li>
    </ul>
    <div id="saida">
        <form class="form-cadastra  entrada" id="form-cria-saida" onsubmit="return false;">
            <div class="row">
                <div class="col-md form-inline">
                    <label>Responsavel &nbsp;</label>
                    <input type="text" size="30" class="text-capitalize" readonly="" id="txtResp" name="responsavel" value="<?=$_SESSION['UserLogado']['nome']?>" />
                </div>
            
                <div class="col-md form-inline">
                    <label>Retirado Por </label>
                    <select onchange="checaSaidaEntrada(this.value);" id="chooseSaida" style="width: 115px;">
                        <option selected="" value="">Selecione...</option>
                        <option value="tecnico">Técnico</option>
                        <option value="funcionario">Funcionário</option>
                    </select>
                    &nbsp;&nbsp;
                    <select name="id_tecnico" id="txtTecnico" style="display: none; width: 250px;" onchange="verificaSaida('0')">
                        <?php $sql->FullRead("SELECT id,nome FROM tb_sys001 WHERE situacao ='l' ORDER BY nome"); ?>
                         <option selected value="">Selecione...</option>
                         <?php foreach ($sql->getResult() as $res):
                         print "<option value=".$res['id'].">".ucfirst($res['nome'])."</option>";
                         endforeach;
                        ?>
                    </select>
                    <span id="txtFunc" style="display: none; margin-top: -3px;">
                        <input type="text" size="5" name="doc_fun" placeholder="IF/RG.." />
                        <input type="text" name="nome_fun"   placeholder="Nome Completo..." />
                        <input type="button" value="ok" style="height: 25px; padding: 0; width: 30px; border: 1px solid #09f;" onclick="verificaSaida(<?=$_SESSION['UserLogado']['id']?>);" />
                    </span>
                </div>
            </div>
        </form>     
        <div id="itens-saida">
            
        </div>
    </div>
</div>
