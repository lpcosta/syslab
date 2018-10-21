<?php
   paginaSegura();
   $sql = new Read();
   $sql->FullRead("SELECT T.id,
                          T.nome,
                          T.email,
                          T.contato,
                          T.celular,
                          T.login,
                          T.dt_cadastro,
                          T.dt_ultimo_login,
                          T.situacao,
                          T.tipo,
                          T.id_empresa,
                          T.grupo_id,
                          E.razaosocial,
                          G.descricao
                        FROM tb_sys001 T
                            JOIN tb_sys012 E ON E.idEmpresa = T.id_empresa
                            JOIN tb_sys021 G ON G.id_grupo = T.grupo_id ORDER BY nome");
?>
<div class="tabs">
    <ul>
        <li><a href="#users">Gerenciar Usuários</a></li>
    </ul>
    <div id="users">
        <div class="row">
            <div class="col form-inline">
                <label style="width: 65px;">Técnico</label>
                <input type="text" id="bsctecnico" onkeydown="autoCompletar(this,'usuario','usuario')" class="form-control text-uppercase" style="width: calc(100% - 70px);"/>
            </div>
            <div class="col form-inline">
                <div class="col form-inline">
                    <button type="button" class="btn btn-primary btn-acao-edita" onclick="liberaCamposEdicao()" style="margin: 0 auto;">Editar</button>
                    <button type="button" class="btn btn-primary btn-acao-salva" onclick="editaUsuario()"style="margin: 0 auto;display: none;">Salvar</button>
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
                    <th>Técnico</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th class="text-center">Contato</th>
                    <th>Empresa</th>
                    <th class="text-center">Grupo</th>
                </tr>
            <? foreach ($sql->getResult() as $res):?>
                <tr style="<?if($res['situacao']=='b'){print "background-color: #ccc;";}?>">
                    <td style="width: 40px;" class="text-center cursor-pointer" onclick="buscaUsuario(<?=$res['id']?>)"><?=$res['id']?></td>
                    <td class="text-capitalize"><?=$res['nome']?></td>
                    <td><?=$res['login']?></td>
                    <td><?=$res['email']?></td>
                    <td class="text-center"><?=$res['contato']?></td>
                    <td class="text-capitalize"><?=$res['razaosocial']?></td>
                    <td class="text-capitalize text-center"><?=$res['descricao']?></td>
                </tr>
                <?endforeach;?>
            </table>
        </div>
    </div>
</div>