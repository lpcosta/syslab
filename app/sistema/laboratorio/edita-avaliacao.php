<?php
   paginaSegura();
if(isset($_GET['id'])):
    
    $getId    = filter_input_array(INPUT_GET,FILTER_DEFAULT);
    $setget   = array_map("strip_tags", $getId);
    $get      = array_map("trim", $setget);
extract($get);
unset($get['pg']);
$sql = new Read();
$sql->ExeRead("tb_sys010 WHERE id = {$id}");
$sql2 = new Read();
endif;
?>
<div class="tabs">
    <ul>
        <li><a href="#edita-avaliacao" id="txtSaida">Editar Avaliação</a></li>
    </ul>
    <?if($sql->getResult()):?>
    <div id="edita-avaliacao">
        <form class="edita" onsubmit="return false;">
            <input type="hidden" name="id" value="<?=$id?>" />
            <div class="row">
                <div class="col form-inline">
                    <label>Técnico</label>
                    <select name="id_tecnico_bancada" class="form-control text-capitalize" >
                         <?$sql2->FullRead("SELECT nome FROM tb_sys001 WHERE id = :ID","ID={$sql->getResult()[0]['id_tecnico_bancada']}");?>
                        <option selected value="<?=$sql->getResult()[0]['id_tecnico_bancada']?>"><?=$sql2->getResult()[0]['nome']?></option>
                        <?$sql2->FullRead("SELECT id,nome FROM tb_sys001 WHERE situacao ='l' ORDER BY nome"); ?>
                        <? foreach ($sql2->getResult() as $res):
                                print "<option value=".$res['id'].">".ucfirst($res['nome'])."</option>";
                            endforeach;
                        ?>
                    </select>
                </div>
                <div class="col form-inline">
                    <label>Status</label>
                    <select name="id_status" id="sts" class="form-control text-capitalize">
                         <? $sql2->FullRead("SELECT descricao FROM tb_sys002 WHERE id = :ID","ID={$sql->getResult()[0]['id_status']}"); ?>
                        <option selected value="<?=$sql->getResult()[0]['id_status']?>"><?=$sql2->getResult()[0]['descricao']?></option>
                        <? $sql2->FullRead("SELECT id,descricao FROM tb_sys002 ORDER BY descricao"); ?>
                        <? foreach ($sql2->getResult() as $res):
                                print "<option value=".$res['id'].">".ucfirst($res['descricao'])."</option>";
                            endforeach;
                        ?>
                    </select>
                </div>
                <div class="col form-inline">
                    <label>Avaliação</label>
                    <textarea name="avaliacao" ><?=$sql->getResult()[0]['avaliacao']?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col form-inline">
                    <button class="btn btn-primary" id="btnAtualizaEdicaoAvaliacao" onclick="window.location.reload();" style="display:none;">Atualizar</button>        
                </div>
                <div class="col form-inline">
                    <button class="btn btn-primary" onclick="editaAvaliacao($('#sts').val())">Salvar</button>
                </div>
            </div>
        </form>
    </div>
    <?endif;?>
</div>