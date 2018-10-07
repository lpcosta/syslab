<?php
   paginaSegura();
    
    $sql = new Read();
    $sql->FullRead("SELECT * FROM tb_sys015 JOIN tb_sys027 ON id_peca = codigo_peca ORDER BY quantidade DESC");
    $pecas = new Read();
    $pecas->FullRead("select sum(quantidade)total from tb_sys027");
    
?>
<div class="tabs">
    <ul>
        <li><a href="#estoque">Estoque Lorac</a></li>
    </ul>
    <div id="estoque">
        <h2 class="text-uppercase"><?=$pecas->getResult()[0]['total'];?> Peças em Estoque</h2>
        <table style="width: 50%; margin: 0 auto;" class="table-hover">
            <tr>
                <th class="text-center">Ação</th>
                <th class="text-center">Código</th>
                <th>Peça</th>
                <th>Quantidade</th>
                <th class="text-center">Categoria</th>
            </tr>
            <?php foreach ($sql->getResult() as $peca):?>
            <tr class="text-capitalize">
                <td class="text-center">
                    <img src="./app/imagens/ico-deleta.png" alt="deleta" title="deletar" style="cursor: pointer;" />
                    <img src="./app/imagens/ico-alterar.png" alt="altera" title="alterar" style="cursor: pointer;" onclick="location.href='index.php?pg=edita/peca&id='+<?=$peca['id_peca']?>"/>
                </td>
                <td class="text-center"><?=$peca['id_peca']?></a></td>
                <td><?=$peca['descricao_peca']?></td>
                <td><?=$peca['quantidade']?></td>
                <td class="text-center"><?=$peca['categoria_id']?></td>
            </tr>
            <?php endforeach;?>
        </table>  
    </div>
</div>