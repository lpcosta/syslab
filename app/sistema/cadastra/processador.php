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
        <li><a href="#memoria">Gerenciamento de Memória Ram</a></li>
    </ul>
    <div id="memoria">
        <h2>Cadastrar</h2>
        <form class="form-cadastra" id="cadastra-processador" onsubmit="return false;">
            <input type="hidden" name="acao" value="processador" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Processador</label>
                    <input type="text" name="processador" class="form-control"/>
                </div>
                <div class="col-md form-inline">
                    <label>Geração</label>
                    <input type="number" name="geracao" class="form-control" style="width:80px;"/>
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
    <?$sql->ExeRead("tb_sys028");$i=1;foreach ($sql->getResult() as $proc):?>
        <form class="edita edita-proc-<?=$i?>" onsubmit="return false">
            <input type="hidden" name="acao" value="processador" />
            <input type="hidden" name="id" value="<?=$proc['id']?>" />
            <div class="row">
                <div class="col-md form-inline">
                    <label><b>Processador</b></label>
                    <input type="text" name="processador" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$proc['processador']?>"/>
                </div>
                <div class="col-md form-inline">
                    <label><b>Geração</b></label>
                    <input type="text" name="geracao" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$proc['geracao']?>" style="width: 80px;"/>
                    &nbsp;
                    <button type="button" class="btn btn-primary btn-edita-proc-<?=$i?>" onclick="liberaEdicaoProcessador(<?=$i?>)">Editar</button>
                    <button type="button" class="btn btn-primary btn-salva-proc-<?=$i?>" onclick="editaProcessador(<?=$i?>);" style="display:none;">Salvar</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-primary btn-deleta-proc-<?=$i?>" onclick="">Excluir</button>
                </div>
            </div>
        </form>
        <?$i++;endforeach;?>
    </div>
</div>