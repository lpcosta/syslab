<?php
    require_once './app/config/pagina-segura.php';
    
    $sql = new Read();

?>
<div class="tabs">
    <ul>
        <li><a href="#div1">Cadastrar</a></li>
        <li><a href="#div2">Cadastrados</a></li>
        
    </ul>
    <div id="div1">
        <h2>Cadastro de Equipamento</h2>
        <form action="javascript:void(0);" class="form-cadastra">
            <div class="row">
                <div class="col-md form-inline">
                    <label>equipamento</label>
                    <select class="form-control" id="txtEqpmt" onchange="setCadEquipamento(this.value)">
                        <?php $sql->ExeRead("tb_sys003"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".ucfirst($res['descricao'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                
                <div class="col-md form-inline">
                    <label>fabricante</label>
                    <select class="form-control" id="txtFab" onchange="getModelos(this.value);" onblur="getModelos(this.value);">
                        <?php $sql->FullRead("SELECT FAB.id_fabricante,FAB.nome_fabricante FROM tb_sys022 MDL JOIN tb_sys018 FAB ON FAB.id_fabricante = MDL.fabricante_id GROUP BY FAB.id_fabricante"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id_fabricante'].">".ucfirst($res['nome_fabricante'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md form-inline">
                   <label>modelo</label>
                   <select class="form-control" id="txtModelo" disabled="">
                       <option selected value="" class="cmbv_modelos">Selecione</option>
                   </select>
                </div>
                
                <div class="col-md form-inline">
                    <label>Série</label>
                    <input type="text" id="txtSerie" class="form-control" size="8" required="" placeholder="Nº de Série" />
                </div>
            </div>
            <div class="row">
                <div class="col-md form-inline">
                    <label>patrimônio</label>
                    <input type="text" id="txtPatrimonio" class="form-control" size="12" placeholder="Patrimônio..." />
                </div>
   
                <div class="col-md form-inline cmb-localidade">
                    <label>Localidade</label>
                   <select class="form-control" id="txtLocalidade">
                        <?php $sql->FullRead("SELECT id,local FROM tb_sys008 ORDER BY local"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".ucfirst($res['local'])."</option>";
                        endforeach;
                        ?>
                   </select>
                </div>
            </div>
            <div class="row opcao-cad-printer" >
                <div class="col-md form-inline">
                    <label>IP</label>
                    <input type="text" id="txtIp" class="form-control" size="12" placeholder="IP..." />
                </div>
                 <div class="col-md form-inline">
                   
                </div>
            </div>
            <div class="row opcao-cad-cpu" >
                <div class="col-md form-inline">
                    <label title="Sistema Operacional">S.O</label>
                    <select class="form-control" id="txtSo">
                        <?php $sql->ExeRead("tb_sys025"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".ucfirst($res['descricao_so'].' '.$res['versao_so'].' '.$res['arquitetura_so'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                 <div class="col-md form-inline">
                    <label title="Chave de Ativação">Chave</label>
                    <input type="text" id="txtKeySo" class="form-control m_key" size="25"placeholder="Chave de Ativação Windows" />
                </div>
            </div>
            <div class="row opcao-cad-cpu" >
                <div class="col-md form-inline">
                    <label title="Office">Office</label>
                    <select class="form-control" id="txtOffice">
                        <?php $sql->ExeRead("tb_sys026"); ?>
                        <option selected value="">Selecione...</option>
                        <?php foreach ($sql->getResult() as $res):
                            print "<option value=".$res['id'].">".ucfirst($res['descricao_office'].' '.$res['versao_office'].' '.$res['arquitetura_office'])."</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                 <div class="col-md form-inline">
                    <label title="Chave de Ativação do Office">Chave</label>
                    <input type="text" id="txtKeyOffice" class="form-control m_key" size="25"placeholder="Chave de Ativação Office" />
                </div>
            </div>
        </form>
    </div>
    <div id="div2">
        <h2>Equipamentos Cadastrados</h2>
        <!--
         <table class="table-responsive-sm tabela-tab table-hover">
             <tr class="text-uppercase" style="width: 60px;">
                <th colspan="2">Ação</th>
                <th class="text-center" style="width:80px;">Patrimônio</th>
                <th class="text-left">Equipamento</th>
                <th class="text-left">Localidade</th>
            </tr>
            <?php
            $sql->FullRead("SELECT 
                            EQP.id,
                            EQP.patrimonio,
                            EQP.serie,
                            FAB.nome_fabricante fabricante,
                            CAT.descricao equipamento,
                            LOC.local,
                            MDL.modelo
                        FROM
                            tb_sys004 EQP
                                JOIN
                            tb_sys003 CAT ON CAT.id = EQP.id_categoria
                                JOIN
                            tb_sys018 FAB ON FAB.id_fabricante = EQP.fabricante
                                JOIN
                            tb_sys008 LOC ON LOC.id = EQP.id_local
                                JOIN
                            tb_sys022 MDL ON MDL.id_modelo = EQP.modelo order by EQP.id limit 1000");
            foreach ($sql->getResult() as $res):
           ?>
            <tr class="text-uppercase">
                <td class="text-center" style="width: 25px; cursor: pointer;"><img src="./app/imagens/ico-alterar.png" /></td>
                <td class="text-center" style="width: 25px; cursor: pointer;"><img src="./app/imagens/ico-deleta.png" /></td>
                <td class="text-center"><?=$res['patrimonio']?></td>
                <td class="text-left"><?=$res['equipamento'].' '.$res['fabricante'].' '.$res['modelo']?></td>
                <td class="text-left"><?=$res['local']?></td>
            </tr>
            <?php endforeach ?>
         </table>-->
    </div>
</div>