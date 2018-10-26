<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';
require_once '../../funcoes/func.inc.php';

$sql   = new Read();
$combo = new Read();
$sql->FullRead("SELECT * FROM tb_sys015 WHERE id_peca = :ID", "ID={$codigo}");

?>
<hr />
<form class="form-edita" onsubmit="return false">
    <input type="hidden" name="id_peca" id="txtIdPeca" value="<?=$codigo?>">
    <input type="hidden" name="acao" value="peca">
    <div class="row">
        <div class="col form-inline">
            <label>Peça</label>
            <input type="text" name="descricao_peca" class="text-capitalize editable" value="<?=$sql->getResult()[0]['descricao_peca']?>" disabled=""/>
        </div>
        <div class="col form-inline">
            <label>Categoria</label>
            <select name="categoria_id" class="text-capitalize editable" disabled="">
                <?if(!empty($sql->getResult()[0]['categoria_id'])){ $combo->ExeRead("tb_sys003 WHERE id = {$sql->getResult()[0]['categoria_id']}");?>
                <option selected value="<?=$sql->getResult()[0]['categoria_id']?>"><?=$combo->getResult()[0]['descricao']?></option>
                <?}else{?>
                <option selected value="">Selecione...</option>
                <?}?>
                <?php $combo->ExeRead("tb_sys003"); foreach ($combo->getResult() as $res):
                    print "<option value=".$res['id'].">".$res['descricao']."</option>";
                endforeach;
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Flag</label>
            <select name="flag" class="editable" disabled="">
                <option selected value="0">Não Marcado</option>
                <option value="1">Marcado</option>
            </select>
        </div>
        <div class="col form-inline">
            <label>R$ Referência</label>
            <input type="text" name="preco_refencia" class="editable" disabled="" value="<?=str_replace(".",",",$sql->getResult()[0]['preco_refencia'])?>"/>
        </div>
    </div>
</form>

