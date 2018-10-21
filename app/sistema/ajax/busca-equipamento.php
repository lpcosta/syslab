<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();

$combo  = new Read();

$sql->ExeRead("tb_sys004 WHERE id = {$id}");

?>

<form class="edita" onsubmit="return false">
    <input type="hidden" id="txtCategoria" value="<?=$sql->getResult()[0]['id_categoria']?>">
    <input type="hidden" name="id" value="<?=$id?>">
    <input type="hidden" name="acao" value="equipamento">
    <div class="row">
        <div class="col form-inline">
            <label>Patrimônio</label>
            <input type="text" name="patrimonio" class="text-capitalize editable" disabled="" value="<?=$sql->getResult()[0]['patrimonio']?>" />
        </div>
        <div class="col form-inline">
            <label>Nº de Série</label>
            <input type="text" name="serie" class="text-capitalize editable" disabled="" value="<?=$sql->getResult()[0]['serie']?>" />
        </div>
        <div class="col form-inline">
            <label>Fabricante</label>
            <select name="fabricante" class="text-capitalize editable" disabled="" onchange="getModelos(this.value);" onblur="getModelos(this.value);">
                <? $combo->FullRead("SELECT nome_fabricante FROM tb_sys018 WHERE id_fabricante =:FAB", "FAB={$sql->getResult()[0]['fabricante']}") ?>
                <option selected value="<?=$sql->getResult()[0]['fabricante']?>"><?=$combo->getResult()[0]['nome_fabricante']?></option>
                <?php $combo->FullRead("SELECT FAB.id_fabricante,FAB.nome_fabricante FROM tb_sys022 MDL JOIN tb_sys018 FAB ON FAB.id_fabricante = MDL.fabricante_id GROUP BY FAB.id_fabricante ORDER BY FAB.nome_fabricante");
                foreach ($combo->getResult() as $res):
                    if($sql->getResult()[0]['fabricante'] == $res['id_fabricante']):
                        continue;
                    else:
                        print "<option value=".$res['id_fabricante'].">".$res['nome_fabricante']."</option>";
                    endif;
                endforeach;
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <label>Modelo</label>
            <? $combo->FullRead("SELECT modelo FROM tb_sys022 WHERE id_modelo =:MOD", "MOD={$sql->getResult()[0]['modelo']}") ?>
            <select class="text-capitalize editable" disabled="" id="txtModelo" name="modelo">
                <option selected value="<?=$sql->getResult()[0]['modelo']?>"class="cmbv_modelos"><?=$combo->getResult()[0]['modelo']?></option>
            <?php $combo->FullRead("SELECT * FROM tb_sys022 WHERE fabricante_id = :FAB","FAB={$sql->getResult()[0]['fabricante']}");
                foreach ($combo->getResult() as $res):
                    if($sql->getResult()[0]['modelo'] == $res['modelo']):
                        continue;
                    else:
                       print "<option value=".$res['id_modelo']."class='cmbv_modelos'>".$res['modelo']."</option>";
                    endif;
                endforeach;
            ?>
           </select>
        </div>
        <div class="col form-inline">
            <label>Equipamento</label>
            <? $combo->FullRead("SELECT descricao FROM tb_sys003 WHERE id =:ID", "ID={$sql->getResult()[0]['id_categoria']}") ?>
            <select class="text-capitalize editable" disabled="" id="txtEquipamento" name="id_categoria">
                <option selected value="<?=$sql->getResult()[0]['id_categoria']?>"><?=$combo->getResult()[0]['descricao']?></option>
             <?php $combo->FullRead("SELECT * FROM tb_sys003");
                foreach ($combo->getResult() as $res):
                    if($sql->getResult()[0]['id_categoria'] == $res['id']):
                        continue;
                    else:
                       print "<option value=".$res['id'].">".$res['descricao']."</option>";
                    endif;
                endforeach;
             ?>
            </select>
        </div>
        <div class="col form-inline">
            <label>Tipo</label>
            <select name="tipo" class="text-capitalize editable" disabled="">
                <option selected value="<?=$sql->getResult()[0]['tipo']?>">Selecione..</option>
                <option value="a">Ativo</option>
                <option value="b">Backup</option>

            </select>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
            <?$combo->FullRead("SELECT id,cr,local FROM tb_sys008 WHERE id = :LOCAL", "LOCAL={$sql->getResult()[0]['id_local']}");?>
            <label>Código/CR</label>
            <input type="text" id="txtCr" class="editable" disabled="" value="<?=$combo->getResult()[0]['cr']?>" onblur="setaLocalidade(this.value,true);" onkeyup="if (event.keyCode == 13){$('#txtAndar').focus();}" placeholder="CR"/>
        </div>
        <div class="col form-inline">
            <label>Localidade</label>
            <select id="txtLocalidade" name="id_local" onkeydown="if (event.keyCode === 13){$('#txtAndar').focus();}" onchange="$('#txtCr').val(this.value);" class="text-capitalize editable" disabled="" >
                <option selected value="<?=$sql->getResult()[0]['id_local']?>" class="localidade"><?=$combo->getResult()[0]['local']?></option>                        
                <?$combo->FullRead("SELECT id,local FROM tb_sys008 ORDER BY local");
                foreach($combo->getResult() as $res):
                    if($sql->getResult()[0]['id_local'] == $res['id']):
                        continue;
                    else:
                       print "<option value=".$res['id'].">".$res['local']."</option>";
                    endif;
                endforeach;
                ?>
            </select>
        </div>
        <div class="col form-inline">
            <label>Andar</label>
            <input type="text" name="andar" class="editable" disabled="" value="<?=$sql->getResult()[0]['andar']?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-inline">
           <label>Sala</label>
           <input type="text" name="sala" class="editable" disabled="" value="<?=$sql->getResult()[0]['sala']?>"/>
        </div>
        <div class="col form-inline">
            <label title="Sistema Operacional">S.O</label>
            <select class="text-capitalize editable-cpu" disabled="" id="txtSo" name="so_id" onchange="addChave('windows',this.value)">
                <?if(!empty($sql->getResult()[0]['so_id'])){ $combo->ExeRead("tb_sys025 WHERE id_so = {$sql->getResult()[0]['so_id']}");?>
                <option selected value="<?=$sql->getResult()[0]['so_id']?>"><?=$combo->getResult()[0]['descricao_so'].' '.$combo->getResult()[0]['versao_so'].' '.$combo->getResult()[0]['arquitetura_so']?></option>
                <?}else{?>
                <option selected value="">Selecione...</option>
                <?}?>
                <?php $combo->ExeRead("tb_sys025 ORDER BY descricao_so");
                foreach ($combo->getResult() as $res):
                    print "<option value=".$res['id_so'].">".$res['descricao_so'].' '.$res['versao_so'].'_'.$res['arquitetura_so']."</option>";
                endforeach;
                ?>
            </select>
        </div>
        <div class="col form-inline">
            <label>Key S.O</label>
            <input type="text" id="txtKeySo" disabled="" name="key_so" value="<?=$sql->getResult()[0]['key_so']?>" class="text-uppercase editable-cpu" placeholder="Chave de Ativação do Windows" />
        </div>

    </div>
    <div class="row">
         <div class="col form-inline">
            <label>IP</label>
            <input type="text" name="ip" id="txtIp" disabled="" class="editable-printer" value="<?=$sql->getResult()[0]['ip']?>"/>
        </div>
        <div class="col form-inline">
            <label title="pacote office">Office</label>
            <select class="text-capitalize editable-cpu" disabled="" id="txtOffice" name="office_id" onchange="addChave('office',this.value)">
                <?if(!empty($sql->getResult()[0]['office_id'])){ $combo->ExeRead("tb_sys026 WHERE id_office = {$sql->getResult()[0]['office_id']}");?>
                <option selected value="<?=$sql->getResult()[0]['office_id']?>"><?=$combo->getResult()[0]['descricao_office'].' '.$combo->getResult()[0]['versao_office'].' '.$combo->getResult()[0]['arquitetura_office']?></option>
                <?}else{?>
                <option selected value="">Selecione...</option>
                <?}?>
                <?php $combo->ExeRead("tb_sys026 ORDER BY descricao_office");
                foreach ($combo->getResult() as $res):
                    print "<option value=".$res['id_office'].">".$res['descricao_office'].' '.$res['versao_office'].'_'.$res['arquitetura_office']."</option>";
                endforeach;
                ?>
            </select>
        </div>
        <div class="col form-inline">
            <label>Key Office</label>
            <input type="text" id="txtKeyOffice" name="key_office" value="<?=$sql->getResult()[0]['key_office']?>" class="text-uppercase editable-cpu" disabled="" placeholder="Chave de Ativação do Office" maxlength="30" />
        </div>
    </div>
    <div class="row">
         <div class="col form-inline">
            <label>Memória Ram</label>
            <select name="memoria_ram" class="text-uppercase editable-cpu" disabled="">
                <option selected="" value="<?=$sql->getResult()[0]['memoria_ram']?>"><?=$sql->getResult()[0]['memoria_ram']?></option>
                <option value="1gb">1GB</option>
                <option value="2gb">2GB</option>
                <option value="3gb">3GB</option>
                <option value="4gb">4GB</option>
                <option value="6gb">6GB</option>
                <option value="8gb">8GB</option>
                <option value="16gb">16GB</option>
            </select>
        </div>
        <div class="col form-inline">
            <label>HD</label>
            <select name="hd" class="text-uppercase editable-cpu" disabled="">
                <option selected="" value="<?=$sql->getResult()[0]['hd']?>"><?=$sql->getResult()[0]['hd']?></option>
                <option value="80gb">80GB</option>
                <option value="160gb">160GB</option>
                <option value="320gb">320GB</option>
                <option value="480gb">480GB</option>
                <option value="500gb">500GB</option>
                <option value="720gb">720GB</option>
                <option value="1tb">1TB</option>
            </select>
        </div>
        <div class="col form-inline">
            <label>Anti Virus</label>
            <select name="anti_virus" class="editable-cpu" disabled="">
                <option selected value="<?=$sql->getResult()[0]['anti_virus']?>"><?=$sql->getResult()[0]['anti_virus']?></option>
                <option value="trend">Trend</option>
                <option value="avast">Avast</option>
                <option value="outro">outro</option>
            </select>
        </div>
    </div>
    <div class="row">
         <div class="col form-inline">
            <label>Tela</label>
            <input type="text" name="tela" value="<?=$sql->getResult()[0]['tela']?>" class="editable-monitor" disabled="" />
        </div>
        <div class="col form-inline">
            <label>Tipo Tela</label>
            <select name="tipo_tela" class="editable-monitor" disabled="">
                <option selected value="<?=$sql->getResult()[0]['tipo_tela']?>"><?=$sql->getResult()[0]['tipo_tela']?></option>
                <option value="normal">Normal</option>
                <option value="wide">WideScreen</option>
                <option value="super-wide">Super Wide-Screen</option>
            </select>
        </div>
        <div class="col form-inline">
            <label>VNC</label>
            <select name="vnc" class="editable-cpu" disabled="">
                <option selected value="<?=$sql->getResult()[0]['vnc']?>"><?=$sql->getResult()[0]['vnc']?></option>
                <option value="sim">Sim</option>
                <option value="nao">Não</option>
            </select>
        </div>
    </div>
    <div class="row">
         <div class="col form-inline">
            <label>V.A)</label>
            <input type="text" name="va" class="editable-estab" disabled="" value="<?=$sql->getResult()[0]['va']?>">
        </div>
        <div class="col form-inline">
            <label>Status</label>
            <select name="status" class="editable" disabled="">
                <option selected value="<?=$sql->getResult()[0]['status']?>"><?=$sql->getResult()[0]['status']?></option>
                <option value="ativo">ativo</option>
                <option value="baixado">baixado</option>
            </select>
        </div>
        <div class="col form-inline">
            
        </div>
    </div>
</form>
