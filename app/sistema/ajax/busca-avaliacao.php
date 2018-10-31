<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();

$sql->ExeRead("tb_sys010 WHERE id ={$ID}");

if($sql->getResult()):?>
<form class="edita" onsubmit="return false;" >
    <input type="hidden" name="id" value="<?=$ID?>" />
    <input type="hidden" name="acao" value="avaliacao" />
    <hr />
    <div class="row">
        <div class="col form-inline">
            <span><b>Avaliação</b></span>
            &nbsp;
            <textarea  name="avaliacao"><?=$sql->getResult()[0]['avaliacao']?></textarea>
        </div>
    <?if($sql->getResult()[0]['id_status']==5):
        $sql->FullRead("SELECT C.id FROM
                            tb_sys010 A
                                JOIN
                            tb_sys006 IE ON IE.id = A.id_item_entrada
                                JOIN
                            tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio
                                JOIN
                            tb_sys003 C ON C.id = EQ.id_categoria AND IE.id = :ID limit 1","ID={$sql->getResult()[0]['id_item_entrada']}");
        $categoria = $sql->getResult()[0]['id'];
    
        ?>
        <div class="col form-inline">
            <label style="width: 60px;height: 25px;">Peça</label>
            <select name="peca_id" class="text-capitalize" style="width: calc(100% - 62px); ">
                <option value="">Selecione</option>                        
                <?$sql->FullRead("SELECT id_peca,descricao_peca FROM tb_sys015 WHERE categoria_id = :CATEG ORDER BY descricao_peca","CATEG={$categoria}");
                foreach($sql->getResult()as $peca):?>
                <option value="<?= $peca['id_peca'] ?>"><?= $peca['descricao_peca']; ?></option>
                <?endforeach;?>
            </select>
        </div>
    <?endif;?>
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