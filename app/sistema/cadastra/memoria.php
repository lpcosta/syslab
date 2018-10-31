<?php
   paginaSegura();
    if(GRUPO < 3):
       header("Location:".HOME."");
       exit();
   endif;
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#memoria">Gerenciamento de Memória Ram</a></li>
    </ul>
    <div id="memoria">
        <h2>Cadastrar</h2>
        <form class="form-cadastra" id="cadastra-memoria" onsubmit="return false;">
            <input type="hidden" name="acao" value="memoria" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Tipo</label>
                    <select name="tipo_memoria" class="form-control">
                        <option selected value="">Sel...</option>
                        <option value="ddr2">DDR2</option>
                        <option value="ddr3">DDR3</option>
                        <option value="ddr4">DDR4</option>
                    </select>
                </div>
                <div class="col-md form-inline">
                    <label>Capacidade</label>
                    <input type="text" name="capacidade" class="form-control" placeholder="xxgb" style="width: 90px;"/>
                </div>
                <div class="col-md form-inline">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    &nbsp;&nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                </div>
            </div>
            <hr />
        </form>
        <div class="row">
            <div class="col">
                <h2>Edita</h2>
            </div>
        </div>
    <?$sql->ExeRead("tb_sys029");$i=1;foreach ($sql->getResult() as $mem):?>
        <form class="edita edita-mem-<?=$i?>" onsubmit="return false">
            <input type="hidden" name="acao" value="memoria" />
            <input type="hidden" name="id" value="<?=$mem['id']?>" />
            <div class="row">
                <div class="col-md form-inline">
                    <label><b>Tipo</b></label>
                    <input type="text" name="tipo_memoria" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$mem['tipo_memoria']?>"/>
                </div>
                <div class="col-md form-inline">
                    <label><b>Capacidade</b></label>
                    <input type="text" name="capacidade" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$mem['capacidade']?>" style="width: 90px;"/>
                <?if(GRUPO == 4):?>
                    &nbsp;
                    <button type="button" class="btn btn-primary btn-edit-<?=$i?>" onclick="liberaEdicaoMemoria(<?=$i?>)">Editar</button>
                    <button type="button" class="btn btn-primary btn-salva-<?=$i?>" onclick="editaMemoria(<?=$i?>);" style="display:none;">Salvar</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-primary btn-deleta-<?=$i?>" onclick="">Excluir</button>
                <?endif;?>
                </div>
            </div>
        </form>
        <?$i++;endforeach;?>
    </div>
</div>