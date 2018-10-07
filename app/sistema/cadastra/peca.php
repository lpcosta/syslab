<?php
   paginaSegura();
   $sql = new Read();
   if($_SESSION['UserLogado']['grupo_id'] != 4):
       header("location:".HOME."");
   endif;
?>
<div class="tabs">
    <ul>
        <li><a href="#cad-user">Cadastrar Peça</a></li>
    </ul>
    <div id="cad-user">
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