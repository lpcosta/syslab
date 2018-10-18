<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();

$sql->ExeRead("tb_sys010 WHERE id ={$ID}");

if($sql->getResult()):?>
<form class="edita" onsubmit="return false;" >
    <input type="hidden" name="id" value="<?=$ID?>"
    <hr />
    <div class="row">
        <div class="col form-inline">
            <span><b>Avaliação</b></span>
            &nbsp;
            <textarea  name="avaliacao"><?=$sql->getResult()[0]['avaliacao']?></textarea>
        </div>
        <div class="col form-inline">
            <span><b>Status</b></span>
            &nbsp;
            <select name="id_status" id="txtNovoStatus" class="text-capitalize" style="width: 100px;">
                <option value="">Status...</option>
                <?$sql->ExeRead("tb_sys002");
                foreach ($sql->getResult() as $res):?>
                    <option value="<?= $res['id'] ?>"><?=$res['descricao']?></option>
                <?endforeach;?>
            </select>
        </div>
        <div class="col form-inline">
            <button onclick="editaAvaliacao($('#txtNovoStatus').val())" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </div>
    <hr />
</form>

<?else:
 print "ERROR <code>".$sql->getError()."</code>";
endif;