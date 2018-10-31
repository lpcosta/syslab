<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();
$combo  = new Read();
$sql->ExeRead("tb_sys001 WHERE id = {$id}");

?>
<hr />
<form class="edita" onsubmit="return false">
    <input type="hidden" name="id" id="txtIdTecnico" value="<?=$id?>">
    <input type="hidden" name="acao" value="usuario">
    <div class="row">
        <div class="col form-inline">
            <label>Nome</label>
            <input type="text" name="nome" class="text-capitalize editable" value="<?=$sql->getResult()[0]['nome']?>" disabled=""/>
        </div>
        <div class="col form-inline">
            <label>E-mail</label>
            <input type="email" name="email" class="editable" value="<?=$sql->getResult()[0]['email']?>" disabled=""/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Contato</label>
            <input type="tel" name="contato" class="contatoFixo text-capitalize editable" value="<?=$sql->getResult()[0]['contato']?>" disabled=""/>
        </div>
        <div class="col form-inline">
            <label>Celular</label>
            <input type="tel" name="celular" class="contatoMovel text-capitalize editable" value="<?=$sql->getResult()[0]['celular']?>" disabled=""/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Login</label>
            <input type="text" name="login" class="text-capitalize editable" maxlength="10" value="<?=$sql->getResult()[0]['login']?>" disabled=""/>
        </div>
        <div class="col form-inline">
            <label>Situação</label>
            <select  name="situacao" class="text-capitalize editable" disabled="">
                <option selected value="<?=$sql->getResult()[0]['situacao']?>"><?if($sql->getResult()[0]['situacao']=='l'){print "liberado";}else {print "bloqueado";}?></option>                        
                 <option value="l">Liberado</option>
                 <option value="b">Bloqueado</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Empresa</label>
            <select name="id_empresa" class="text-capitalize editable" disabled="">
                <?$combo->ExeRead("tb_sys012 WHERE idEmpresa = {$sql->getResult()[0]['id_empresa']}");?>
                <option selected value="<?=$sql->getResult()[0]['id_empresa']?>"><?=$combo->getResult()[0]['razaosocial']?></option>                        
                <?$combo->ExeRead("tb_sys012 ORDER BY razaosocial");
                foreach($combo->getResult() as $res):
                       print "<option value=".$res['idEmpresa'].">".$res['razaosocial']."</option>";
                endforeach;
                ?>
            </select>
        </div>
        <div class="col form-inline">
            <label>Grupo</label>
            <select name="grupo_id" class="text-capitalize editable" disabled="">
                <?$combo->ExeRead("tb_sys021 WHERE id_grupo = {$sql->getResult()[0]['grupo_id']}");?>
                <option selected value="<?=$sql->getResult()[0]['grupo_id']?>"><?=$combo->getResult()[0]['descricao']?></option>                        
                <?$combo->ExeRead("tb_sys021 ORDER BY descricao");
                foreach($combo->getResult() as $res):
                       print "<option value=".$res['id_grupo'].">".$res['descricao']."</option>";
                endforeach;
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Dt. Cadastro</label>
            <input type="text" value="<?=date('d/m/Y H:i:s', strtotime($sql->getResult()[0]['dt_cadastro']))?>" disabled="" />
        </div>
        <div class="col form-inline">
            <label>Tipo</label>
            <select  name="tipo" class="text-capitalize editable" disabled="">
                <option selected value="<?=$sql->getResult()[0]['tipo']?>"><?=$sql->getResult()[0]['tipo']?></option>                        
                 <option value="usuario">Usuário</option>
                 <option value="bancada">Bancada</option>
                 <option value="interno">Interno</option>
                 <option value="externo">Externo</option>
                 <option value="remoto">Remoto</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Último Login</label>
            <input type="text" value="<?=date('d/m/Y H:i:s', strtotime($sql->getResult()[0]['dt_ultimo_login']))?>" disabled="" />
        </div>
        <div class="col form-inline">
           
        </div>
    </div>
    <hr />
</form>
<script>
    $(".contatoFixo").mask("(99)9999-9999");
    $(".contatoMovel").mask("(99)99999-9999");
</script>