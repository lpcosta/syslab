<?php
   paginaSegura();
    $sql = new Read();
if(isset($_GET)):
    extract($_GET);
endif;
    if(isset($id) && !empty($id)):
        $sql->FullRead("SELECT * FROM tb_sys004 WHERE id = :ID", "ID={$id}");
        if($sql->getRowCount() > 0):
            $combo  = new Read();
        endif;
    endif;
?>
<div class="tabs">
    <ul>
        <li><a href="#edita-equipamento">Editar Equipamento</a></li>
    </ul>
    <?php if(!isset($id)):?>
    <div id="edita-equipamento">
      
        <form class="form-edita" id="form-edita-equipamento" onsubmit="return false;">
            <input type="hidden" name="acao" value="pesquisa" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Patrimônio &nbsp;</label>
                    <input type="text" name="patrimonio" class="form-control" id="patrimonio" /> &nbsp;
                    <input type="submit" id="btn"  value="Editar"/>
                    &nbsp;&nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
                </div>
            </div>
        </form>
    </div>
    
    <?php elseif(isset($id)):$categorias=[2,5,17,22,23,26];?>
    <div class="dados-edita">
         <hr />
         <form class="form-cadastra entrada" id="edita-equipamento" onsubmit="return false" style="width: 98%;">
                <input type="hidden" name="acao" value="edita">
                <input type="hidden" name="id" value="<?=$sql->getResult()[0]['id']?>">
                <div class="row">
                    <div class="col form-inline">
                        <label>Patrimônio</label>
                        <input type="text" name="patrimonio" class="text-capitalize" value="<?=$sql->getResult()[0]['patrimonio']?>" />
                    </div>
                    <div class="col form-inline">
                        <label>Nº de Série</label>
                        <input type="text" name="serie" class="text-capitalize" value="<?=$sql->getResult()[0]['serie']?>" />
                    </div>
                    <div class="col form-inline">
                        <label>Fabricante</label>
                        <select name="fabricante" class="text-capitalize" onchange="getModelos(this.value);" onblur="getModelos(this.value);">
                            <? $combo->FullRead("SELECT nome_fabricante FROM tb_sys018 WHERE id_fabricante =:FAB", "FAB={$sql->getResult()[0]['fabricante']}") ?>
                            <option selected value="<?=$sql->getResult()[0]['fabricante']?>"><?=$combo->getResult()[0]['nome_fabricante']?></option>
                            <?php $combo->FullRead("SELECT FAB.id_fabricante,FAB.nome_fabricante FROM tb_sys022 MDL JOIN tb_sys018 FAB ON FAB.id_fabricante = MDL.fabricante_id GROUP BY FAB.id_fabricante");
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
                        <select class="text-capitalize" id="txtModelo" name="modelo">
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
                        <select class="text-capitalize" id="txtEquipamento" name="id_categoria">
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
                        <select name="tipo" class="text-capitalize">
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
                        <input type="text" id="txtCr" value="<?=$combo->getResult()[0]['cr']?>" onblur="setaLocalidade(this.value);" onkeyup="if (event.keyCode == 13){$('#txtAndar').focus();}" placeholder="CR"/>
                    </div>
                    <div class="col form-inline">
                        <label>Localidade</label>
                        <select id="txtLocalidade" name="id_local" onkeydown="if (event.keyCode === 13){$('#txtAndar').focus();}" onchange="$('#txtCr').val(this.value);" class="text-capitalize" style="width: 280px;">
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
                        <input type="text" name="andar" value="<?=$sql->getResult()[0]['andar']?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col form-inline">
                       <label>Sala</label>
                       <input type="text" name="sala" value="<?=$sql->getResult()[0]['sala']?>"/>
                    </div>
                    <div class="col form-inline">
                        <label title="Sistema Operacional">S.O</label>
                        <select class="text-capitalize" id="txtSo" name="so_id" <?if(!in_array($sql->getResult()[0]['id_categoria'],$categorias)){print "disabled";}?>>
                            <option selected value="<?=$sql->getResult()[0]['so_id']?>">Selecione...</option>
                            <?php $combo->ExeRead("tb_sys025 ORDER BY descricao_so");
                            foreach ($combo->getResult() as $res):
                                 if($sql->getResult()[0]['so_id'] == $res['id_so']):
                                    continue;
                                else:
                                   print "<option value=".$res['id_so'].">".$res['descricao_so'].' '.$res['versao_so'].'_'.$res['arquitetura_so']."</option>";
                                endif;
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col form-inline">
                        <label>Key S.O</label>
                        <input type="text" id="txtKeySo" name="key_so" value="<?=$sql->getResult()[0]['key_so']?>" class="text-capitalize m_key " size="26" placeholder="Chave de Ativação do Windows" onkeyup="maskKey(this)" onkeypress="maskKey(this)" <?if(!in_array($sql->getResult()[0]['id_categoria'],$categorias)){print "disabled";}?> />
                    </div>
                    
                </div>
                <div class="row">
                     <div class="col form-inline">
                        <label>IP</label>
                        <input type="text" name="ip" id="txtIp" value="<?=$sql->getResult()[0]['ip']?>"/>
                    </div>
                    <div class="col form-inline">
                        <label title="pacote office">Office</label>
                        <select class="text-capitalize" id="txtOffice" name="office_id" <?if(!in_array($sql->getResult()[0]['id_categoria'],$categorias)){print "disabled";}?>>
                            <option selected value="<?=$sql->getResult()[0]['so_id']?>">Selecione...</option>
                            <?php $combo->ExeRead("tb_sys026 ORDER BY descricao_office");
                            foreach ($combo->getResult() as $res):
                                 if($sql->getResult()[0]['office_id'] == $res['id_office']):
                                    continue;
                                else:
                                   print "<option value=".$res['id_office'].">".$res['descricao_office'].' '.$res['versao_office'].'_'.$res['arquitetura_office']."</option>";
                                endif;
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col form-inline">
                        <label>Key Office</label>
                        <input type="text" id="txtKeyOffice" name="key_office" class="text-capitalize" size="26" placeholder="Chave de Ativação do Office" onkeyup="maskKey(this)" onkeypress="maskKey(this)" maxlength="30" <?if(!in_array($sql->getResult()[0]['id_categoria'],$categorias)){print "disabled";}?>/>
                    </div>
                </div>
                <div class="row">
                     <div class="col form-inline">
                        <label>Memória Ram</label>
                        <input type="text" name="memoria_ram" value="<?=$sql->getResult()[0]['memoria_ram']?>" <?if(!in_array($sql->getResult()[0]['id_categoria'],$categorias)){print "disabled";}?>/>
                    </div>
                    <div class="col form-inline">
                        <label>HD</label>
                        <input type="text" name="hd" value="<?=$sql->getResult()[0]['hd']?>" <?if(!in_array($sql->getResult()[0]['id_categoria'],$categorias)){print "disabled";}?>/>
                    </div>
                    <div class="col form-inline">
                        <label>Anti Virus</label>
                        <select name="anti_virus" <?if(!in_array($sql->getResult()[0]['id_categoria'],$categorias)){print "disabled";}?>>
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
                        <input type="text" name="tela" value="<?=$sql->getResult()[0]['tela']?>"/>
                    </div>
                    <div class="col form-inline">
                        <label>Tipo Tela</label>
                        <select name="tipo_tela">
                            <option selected value="<?=$sql->getResult()[0]['tipo_tela']?>"><?=$sql->getResult()[0]['tipo_tela']?></option>
                            <option value="normal">Normal</option>
                            <option value="wide">WideScreen</option>
                            <option value="super-wide">Super Wide-Screen</option>
                        </select>
                    </div>
                    <div class="col form-inline">
                        <label>VNC</label>
                        <select name="vnc" <?if(!in_array($sql->getResult()[0]['id_categoria'],$categorias)){print "disabled";}?>>
                            <option selected value="<?=$sql->getResult()[0]['vnc']?>"><?=$sql->getResult()[0]['vnc']?></option>
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                     <div class="col form-inline">
                        <label>V.A)</label>
                        <input type="text" name="va" value="<?=$sql->getResult()[0]['va']?>"/>
                    </div>
                    <div class="col form-inline">
                        <label>Status</label>
                        <select name="status">
                            <option selected value="<?=$sql->getResult()[0]['status']?>"><?=$sql->getResult()[0]['status']?></option>
                            <option value="ativo">ativo</option>
                            <option value="baixado">baixado</option>
                        </select>
                    </div>
                    <div class="col form-inline">
                        <button type="submit" style="margin-right: 10px;">Salvar</button>
                     
                        <button type="button" onclick="history.back();">Cancelar</button>
                    </div>
                </div>
            </form>
    </div>
    <?endif;?>
</div>