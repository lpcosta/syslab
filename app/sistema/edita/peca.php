<?php
   paginaSegura();
    $sql = new Read();
if(isset($_GET)):
    extract($_GET);
endif;
    if(isset($id) && !empty($id)):
        $sql->FullRead("SELECT id_peca,descricao_peca,categoria_id FROM tb_sys015 WHERE id_peca = :ID", "ID={$id}");
        if($sql->getRowCount() > 0):
            $combo  = new Read();
        endif;
    endif;
?>
<div class="tabs">
    <ul>
        <li><a href="#edita-peca">Editar Peça</a></li>
    </ul>
    <?php if(!isset($id)):?>
    <div id="edita-peca">
        <form class="form-edita" id="form-edita-peca" onsubmit="return false;">
            <input type="hidden" name="acao" value="pesquisa" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Código da Peça &nbsp;</label>
                    <input type="text" name="id_peca" class="form-control" id="id_peca" required="" /> &nbsp;
                    <input type="submit" id="btn"  value="Editar"/>
                    &nbsp;&nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                </div>
            </div>
        </form>
     <?php elseif(isset($id) && $sql->getRowCount() > 0):?>
    <div class="dados-edita">
        <hr />
        <form class="form-cadastra entrada" id="edita-peca" onsubmit="return false" style="width: 98%;">
            <input type="hidden" name="acao" value="edita">
            <input type="hidden" name="id" value="<?=$id?>">
            <div class="row">
                <div class="col form-inline">
                    <label>Peça</label>
                    <input type="text" name="descricao_peca" class="text-capitalize" value="<?=$sql->getResult()[0]['descricao_peca']?>" style="width: 85%;" />
                </div>
                <div class="col form-inline">
                    <label>Categoria</label>
                    <select name="categoria_id" class="text-capitalize">
                    <option selected value="<?=$sql->getResult()[0]['categoria_id']?>">Selecione...</option>
                    <option selected value=0>Sem categoria</option>
                    <?php $sql->ExeRead("tb_sys003"); foreach ($sql->getResult() as $res):
                        print "<option value=".$res['id'].">".$res['descricao']."</option>";
                    endforeach;
                    ?>
                    </select>
                </div>
                <div class="col form-inline">
                    <label>Flag</label>
                    <select name="flag" >
                        <option selected="0">Não Marcado</option>
                        <option value="1">Marcado</option>
                    </select>
                </div>
            </div>
            <div class="row" >
                <div class="col form-inline">
                  
                </div>
                <div class="col form-inline">
                    <button type="submit" style="margin-right: 10px;">Salvar</button>
                    <button type="button" onclick="location.href='index.php?pg=edita/peca'">Voltar</button>
                </div>
            </div>
        </form>
    </div>
    <?endif;?>
    </div>
</div>