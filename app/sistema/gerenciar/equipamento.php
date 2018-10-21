<?php
   paginaSegura();
   $sql = new Read();
   $sql->FullRead("SELECT EQ.id,EQ.patrimonio,EQ.serie,C.descricao equipamento,F.nome_fabricante fabricante,M.modelo,L.local,L.cr,S.sigla
                    FROM tb_sys004 EQ
                    JOIN tb_sys003 C ON C.id = EQ.id_categoria
                    JOIN tb_sys018 F ON F.id_fabricante = EQ.fabricante
                    JOIN tb_sys022 M ON M.id_modelo = EQ.modelo
                    JOIN tb_sys008 L ON L.id = EQ.id_local
                    JOIN tb_sys011 S ON S.id_secretaria = L.secretaria_id AND EQ.status = :STS order by patrimonio DESC limit 25","STS=".'ativo'."");
?>
<div class="tabs">
    <ul>
        <li><a href="#edita">Gerenciar Equipamento</a></li>
    </ul>
    <div id="edita">
        <div class="row">
            <div class="col form-inline">
                <label style="width: 100px;">Patrimonio</label>
                <input type="text" id="bscpatrimonio" onkeydown="autoCompletar(this,'patrimonio','equipamento')" class="form-control" size="8"/>
                <label style="width: 50px;">Serie</label>
                <input type="text" id="bscserie" onkeydown="autoCompletar(this,'serie','equipamento')" class="form-control text-uppercase" size="15"/>
            </div>
            <div class="col form-inline">
                <div class="col form-inline">
                    <button type="button" class="btn btn-primary btn-acao-edita" onclick="liberaCamposEdicaoEquipamento()" style="margin: 0 auto;">Editar</button>
                    <button type="button" class="btn btn-primary btn-acao-salva" onclick="editaEquipamento()"style="margin: 0 auto;display: none;">Salvar</button>
                    &nbsp;
                    <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." />
                </div>
                <div class="col form-inline">
                    <button type="button" class="btn btn-primary" style="margin: 0 auto;" <?if(GRUPO != 4){echo "disabled";}?> >Excluir</button>
                </div>
                <div class="col form-inline">
                    <button type="button" class="btn btn-primary" onclick="window.location.reload();" style="margin: 0 auto;">Voltar</button>
                </div>
            </div>
        </div>
        <hr />
        <div class="dados-edita">
            <table class="tabela-tab table-bordered table-hover">
                <tr>
                    <th style="width: 40px;" class="text-center"><img src="./app/imagens/ico-alterar.png" alt="alterar" /></th>
                    <th class="text-center">Patrimonio</th>
                    <th>Nº de Serie</th>
                    <th>Equipamento</th>
                    <th class="text-center">CR</th>
                    <th>Localidade</th>
                    <th class="text-center">Secretaria</th>
                </tr>
            <? foreach ($sql->getResult() as $res):?>
                <tr>
                    <td style="width: 40px;" class="text-center cursor-pointer" onclick="buscaEquipamento(<?=$res['id']?>)"><?=$res['id']?></td>
                    <td class="text-center text-uppercase"><?=$res['patrimonio']?></td>
                    <td class="text-uppercase"><?=$res['serie']?></td>
                    <td class="text-capitalize"><?=$res['equipamento'].' '.$res['fabricante'].' '.$res['modelo']?></td>
                    <td class="text-center"><?=$res['cr']?></td>
                    <td class="text-capitalize"><?=$res['local']?></td>
                    <td class="text-uppercase text-center"><?=$res['sigla']?></td>
                </tr>
                <?endforeach;?>
            </table>
        </div>
    </div>
</div>