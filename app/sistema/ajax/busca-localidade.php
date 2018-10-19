<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();
$combo  = new Read();
$sql->ExeRead("tb_sys008 WHERE id = {$id}");

?>
<form class="edita" onsubmit="return false"  style="width: 98%;">
    <input type="hidden" name="id" id="txtIdLocal" value="<?=$id?>">
    <div class="row">
        <div class="col form-inline">
            <label>Código</label>
            <input type="text" class="text-capitalize" value="<?=$id?>" disabled=""/>
        </div>
        <div class="col form-inline">
            <label>CR</label>
            <input type="text" name="cr" class="text-capitalize editable" value="<?=$sql->getResult()[0]['cr']?>" disabled=""/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Localidade</label>
            <input type="text" name="local" class="text-capitalize editable" value="<?=$sql->getResult()[0]['local']?>" disabled=""/>
        </div>
        <div class="col form-inline">
            <label>Endereço</label>
             <input type="text" name="rua" class="text-capitalize editable" value="<?=$sql->getResult()[0]['rua']?>" disabled=""/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>CEP</label>
            <input type="text" name="cep" class="text-capitalize editable" maxlength="10" value="<?=$sql->getResult()[0]['cep']?>" disabled=""/>
        </div>
        <div class="col form-inline">
            <label>Bairro</label>
             <input type="text" name="bairro" class="text-capitalize editable" value="<?=$sql->getResult()[0]['bairro']?>" disabled=""/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Região</label>
            <select id="txtLocalidade" name="regiao_id" class="text-capitalize editable" disabled="">
                <?$combo->ExeRead("tb_sys023 WHERE id_regiao = {$sql->getResult()[0]['regiao_id']}");?>
                <option selected value="<?=$sql->getResult()[0]['regiao_id']?>"><?=$combo->getResult()[0]['nome_regiao']?></option>                        
                <?$combo->ExeRead("tb_sys023 ORDER BY nome_regiao");
                foreach($combo->getResult() as $res):
                       print "<option value=".$res['id_regiao'].">".$res['nome_regiao']."</option>";
                endforeach;
                ?>
            </select>
        </div>
        <div class="col form-inline">
            <label>Secretaria</label>
            <select id="txtLocalidade" name="secretaria_id" class="text-capitalize editable" disabled="">
                <?$combo->ExeRead("tb_sys011 WHERE id_secretaria = {$sql->getResult()[0]['secretaria_id']}");?>
                <option selected value="<?=$sql->getResult()[0]['secretaria_id']?>"><?=$combo->getResult()[0]['nome_secretaria']?></option>                        
                <?$combo->ExeRead("tb_sys011 ORDER BY nome_secretaria");
                foreach($combo->getResult() as $res):
                       print "<option value=".$res['id_secretaria'].">".$res['nome_secretaria']."</option>";
                endforeach;
                ?>
            </select>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col form-inline">
            <button type="button" class="btn btn-primary btn-acao-edita" onclick="liberaCamposEdicao()" style="margin: 0 auto;">Editar</button>
            <button type="button" class="btn btn-primary btn-acao-salva" onclick="editaLocalidade(<?=$id?>)"style="margin: 0 auto;display: none;">Salvar</button>
            &nbsp;
            <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." />
        </div>
        <div class="col form-inline">
           <button type="button" class="btn btn-primary" onclick="window.location.reload();" style="margin: 0 auto;">Voltar</button>
        </div>
        <div class="col form-inline">
              <button type="button" class="btn btn-primary" style="margin: 0 auto;" <?if(GRUPO != 4){echo "disabled";}?> >Excluir</button>
        </div>
    </div>
</form>
