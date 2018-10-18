<?php
   paginaSegura();
   $sql = new Read();
   $sql->ExeRead("tb_sys008 ORDER BY local");
?>
<div class="tabs">
    <ul>
        <li><a href="#edita-equipamento">Gerenciar Localidade</a></li>
    </ul>
    <div id="edita-equipamento">
        <input type="hidden" name="acao" value="pesquisa" />
        <div class="row">
            <div class="col-md form-inline">
                <label>Selecione</label>
                &nbsp;
                <select class="form-control" onchange="buscaLocalidade(this.value)">
                    <option selected value="">Selecione...</option>
                <? foreach ($sql->getResult() as $res):?>
                    <option value="<?=$res['id']?>" class="text-capitalize"><?=$res['local']?></option>
                <? endforeach;?>
                 </select>
                &nbsp;
                <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
            </div>
        </div>
    </div>
    <div class="dados-edita">
       
    </div>
</div>