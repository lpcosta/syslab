<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../config/post.inc.php';
require_once '../../funcoes/func.inc.php';

$sql   = new Read();

$sql->FullRead("SELECT IE.id,
                        IE.patrimonio,
                        IE.motivo,
                        IE.os_sti,
                        IE.observacao,
                        S.descricao,
                        IE.status,
                        IE.checklist,
                        IE.local_uso
                FROM tb_sys006 IE JOIN tb_sys002 S ON S.id = IE.status AND IE.id_entrada = :ID","ID={$entrada}");
$i=1;
$combo = new Read();
?>
<?foreach ($sql->getResult() as $res):?>
    <form class="edita edita-entrada-<?=$i?>" onsubmit="return false">
        <input type="hidden" name="acao" value="entrada" />
        <input type="hidden" name="id" value="<?=$res['id']?>" />
        <div class="row">
            <div class="col form-inline">
                <label style="width:100%;">Patrimonio</label>
                <input type="text" name="patrimonio" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$res['patrimonio']?>" style="width:90px;"/>
            </div>
            <div class="col form-inline">
                <label style="width:100%;">OS</label>
                <input type="text" name="os_sti" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$res['os_sti']?>" style="width:80px;"/>
            </div>
            <div class="col form-inline">
                <label style="width:100%;">Motivo</label>
                <select name="motivo" class="form-control text-capitalize editable-<?=$i?>" disabled="" style="width:120px;">
                    <option selected value="<?=$res['motivo']?>"><?=$res['motivo']?></option>  
                    <optgroup label="Motivos Gerais">
                        <?$combo->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=0");
                        foreach ($combo->getResult() as $mg):?>
                            <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                        <?endforeach;?>
                    </optgroup>
                    <optgroup label="Computador">
                        <?$combo->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=2");
                        foreach ($combo->getResult() as $mg):?>
                            <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                        <?endforeach;?>
                    </optgroup>
                    <optgroup label="Estabilizador">
                        <?$combo->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=3");
                        foreach ($combo->getResult() as $mg):?>
                            <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                        <?endforeach;?>
                    </optgroup>
                    <optgroup label="Impressora">
                        <?$combo->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=1");
                        foreach ($combo->getResult() as $mg):?>
                            <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                        <?endforeach;?>
                    </optgroup>
                    <optgroup label="Monitor">
                        <?$combo->FullRead("SELECT motivo FROM tb_sys017 WHERE categoria = :CAT ORDER BY motivo", "CAT=4");
                        foreach ($combo->getResult() as $mg):?>
                            <option value="<?=$mg['motivo'];?>"><?=$mg['motivo'];?></option>
                        <?endforeach;?>
                    </optgroup>                            
                </select>
            </div>
            <div class="col form-inline">
                <label style="width:100%;">Status</label>
                <select name="status" class="form-control text-capitalize editable-<?=$i?>" disabled="" style="width:130px;">
                    <option value="<?=$res['status']?>"><?=$res['descricao']?></option>
                    <?$combo->ExeRead("tb_sys002");
                    foreach ($combo->getResult() as $sts):?>
                        <option value="<?= $sts['id'] ?>"><?=$sts['descricao']?></option>
                    <?endforeach;?>
                </select> 
            </div>
            <div class="col form-inline">
                <label style="width:100%;">Observação</label>
                <textarea name="observacao" wrap="hard" class="form-control text-capitalize editable-<?=$i?>" disabled="" style="height: 60px; resize: horizontal; width: 100%; min-width: 250px;"><?=$res['observacao']?></textarea>
            </div>
            <div class="col form-inline">
                <label style="width:100%;">CheckList</label>
                <input type="text" name="checklist" class="form-control text-uppercase editable-<?=$i?>" disabled="" value="<?=$res['checklist']?>" style="width:85px;"/>
            </div>
            <div class="col form-inline">
                <label style="width:100%;">local Uso</label>
                <select name="local_uso" class="form-control text-capitalize editable-<?=$i?>" disabled="">
                    <option selected value="<?=$res['local_uso']?>"><?=$res['local_uso']?></option>
                    <option value="rede laboratorio">Rede Laboratorio</option>
                    <option value="rede adm (AD)">Rede Adm (AD)</option>
                </select>
            </div>
            <div class="col form-inline">
                <button type="button" class="btn btn-primary btn-edita-<?=$i?>" onclick="liberaEdicao(<?=$i?>)" style="width:60px; padding-left: 5px;">Editar</button>
                <button type="button" class="btn btn-primary btn-salva-<?=$i?>" onclick="editaEntrada(<?=$i?>);" style="display:none;width:60px; padding-left: 5px;">Salvar</button>
                &nbsp;
                <button type="button" class="btn btn-primary btn-deleta-<?=$i?>" onclick="" style="width:60px; padding-left: 5px;">Excluir</button>
            </div>          
        </div>
    </form>
<?$i++;endforeach;?>
