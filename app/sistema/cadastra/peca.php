<?php
   paginaSegura();
    if(GRUPO != 4):
       header("Location:".HOME."");
       exit();
   endif;
   $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#cad-peca">Cadastrar Peça</a></li>
    </ul>
    <div id="cad-peca">
        <h2 class="text-uppercase">Cadastro de Peça</h2>
        <form class="form-cadastra" id="cadastra-peca" onsubmit="return false;">
            <input type="hidden" name="acao" value="peca" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Peça</label>
                    <input type="text" name="descricao_peca" class="form-control" placeholder="Peça..." style="width:50%;" />
                </div>
                <div class="col-md form-inline">
                    <label>Equipamento</label>
                    <select name="categoria_id" class="text-capitalize form-control">
                        <?php $sql->ExeRead("tb_sys003"); ?>
                        <option selected value="">Selecione...</option>
                        <option selected value=0>Sem categoria</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".$res['descricao']."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md form-inline">
                    <label>Flag</label>
                    <select name="flag" >
                        <option selected value="">Selecione...</option>
                        <option value="0">Não Marcado</option>
                        <option value="1">Marcado</option>
                    </select>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md form-inline">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    &nbsp;&nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                </div>
                <div class="col-md form-inline">
                    <button type="button" class="btn btn-primary" onclick="history.back()">Cancelar</button>
                </div>
            </div>
            <hr />
        </form>
    </div>
</div>