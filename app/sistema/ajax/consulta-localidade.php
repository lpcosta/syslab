<?php
session_start();
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql    = new Read();

$combo  = new Read();

$sql->FullRead("SELECT 
                    L.id,
                    L.local,
                    L.rua,
                    L.cep,
                    L.bairro,
                    L.cr,
                    R.nome_regiao regiao,
                    S.sigla
                 FROM
                     tb_sys008 L
                         JOIN
                     tb_sys023 R ON R.id_regiao = L.regiao_id
                         JOIN
                     tb_sys011 S ON S.id_secretaria = L.secretaria_id AND L.id = :ID","ID={$id}");

if(!$sql->getResult()):
    $sql->FullRead("SELECT 
                    L.id,
                    L.local,
                    L.rua,
                    L.cep,
                    L.bairro,
                    L.cr,
                    R.nome_regiao regiao,
                    S.sigla
                 FROM
                     tb_sys008 L
                         JOIN
                     tb_sys023 R ON R.id_regiao = L.regiao_id
                         JOIN
                     tb_sys011 S ON S.id_secretaria = L.secretaria_id AND L.cr = :CR","CR={$id}");
endif;
if($sql->getResult()):
?>

<div class="accordion">
    <h3 class="text-uppercase"><?=$sql->getResult()[0]['local']?></h3>
    <div class="consulta">
        <div class="row">
            <div class="col form-inline">
                <label>Código</label>
                <input type="text" class="text-capitalize" value="<?=$sql->getResult()[0]['id']?>" disabled=""/>
            </div>
            <div class="col form-inline">
                <label>Endereço</label>
                <input type="text" class="text-capitalize  " value="<?=$sql->getResult()[0]['rua']?>" disabled=""/>
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label>CR</label>
                <input type="text" class="text-capitalize  " value="<?=$sql->getResult()[0]['cr']?>" disabled=""/>
            </div>
            <div class="col form-inline">
                <label>Bairro</label>
                <input type="text" class="text-capitalize  " value="<?=$sql->getResult()[0]['bairro']?>" disabled=""/>
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label>CEP</label>
                <input type="text" class="text-capitalize  " maxlength="10" value="<?=$sql->getResult()[0]['cep']?>" disabled=""/>
            </div>
            <div class="col form-inline">
                <label>Secretaria</label>
                <input type="text" class="text-uppercase" value="<?=$sql->getResult()[0]['sigla']?>" disabled=""/>
            </div>
        </div>
        <div class="row">
            <div class="col form-inline">
                <label>Região</label>
                <input type="text" class="text-capitalize  " value="<?=$sql->getResult()[0]['regiao']?>" disabled=""/>
            </div>
            <div class="col form-inline">
                <label>&nbsp;</label>
                
            </div>
        </div>
        <hr />
       <? $combo->FullRead("SELECT 
                                    C.descricao equipamento,
                                    count(*) total
                                FROM
                                    tb_sys004 EQ
                                        JOIN
                                    tb_sys003 C ON C.id = EQ.id_categoria
                                        JOIN
                                    tb_sys008 L ON L.id = EQ.id_local AND L.id = :ID group by C.id order by C.descricao","ID={$sql->getResult()[0]['id']}");
        ?>
        <div class="row">
            <? foreach ($combo->getResult() as $res):?>
                <div class="col">
                    <img src="./app/imagens/icons/<?=$res['equipamento']?>.PNG" style="float: left;" />
                    <h1 style="float: left;margin-top: 20px; margin-left: 5px;"><?=$res['total']?></h1>
                </div>
            <? endforeach;?>
        </div>
    </div>
        
    <h3>Section 2</h3>
    <div>
      
    </div>
    <h3>Section 3</h3>
    <div>
      
    </div>
</div>      
<?endif;?>
<script>
    $(document).ready(function(){
	$( ".accordion" ).accordion({
            collapsible: true
        });
    });
</script>