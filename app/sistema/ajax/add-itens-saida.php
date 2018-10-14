<?php
require_once '../../config/config.inc.php';
require_once '../../funcoes/func.inc.php';
require_once '../../config/post.inc.php';

$sql  = new Read();
$cria = new Create();
$atu  = new Update();
$sql->FullRead("select T.nome,S.data from tb_sys001 T join tb_sys007 S ON S.id_tecnico = T.id and S.id = :ID", "ID={$saida}");
session_start();
?>
<div>
    <form id="add-itens-saida" class="form-cadastra" onsubmit="return false">
        <input type="hidden" id="txtNumSaida" name="saida" value="<?=$saida?>" />
        <div class="row">
            <div class="col form-inline">
                <label>Técnico</label>&nbsp;
                <input type="text" size="35" readonly="" class="text-capitalize form-control" value="<?=$sql->getResult()[0]['nome']?>"/>
            </div>
            <div class="col form-inline">
                <label>Data</label>&nbsp;
                <input type="text" size="35" readonly="" class="text-capitalize form-control" value="<?=date("d/m/Y",strtotime($sql->getResult()[0]['data']))?>"/>
            </div>
        </div>
        <hr />
        <div class="row">
             <div class="col form-inline">
                <label>Patrimonio/OS</label>
                <input type="text" name="patrimonio"  size="10" class="form-control" autofocus="" />
                &nbsp;
                <input type="submit" class="btn btn-primary" id="txtPat" onclick="addItemSaida()" value="Realizar Saída" />
            </div>
            <div class="col form-inline">
                <label>&nbsp;</label>
                <input type="submit" class="btn btn-primary" onclick="finalizaSaida(<?=$saida?>,'<?=$_SESSION['UserLogado']['email']?>','<?=$_SESSION['UserLogado']['nome']?>')" value="Finalizar Saída" />
                 &nbsp;
                <img src="./app/imagens/load.gif" class="form_load" alt="[CARREGANDO...]" title="CARREGANDO.." /> 
            </div>
        </div>
        <hr />
    </form>
</div>

<?php
//print_r($post);
if(isset($patrimonio)):
    if($patrimonio == 10):
       $msg = "informe um patrimonio e/ou ordem diferente de 10";
    else:
        $sql->FullRead("SELECT id,status,patrimonio FROM tb_sys006 WHERE patrimonio = :PAT ORDER BY id DESC limit 1","PAT=".$patrimonio."");
        if($sql->getRowCount() > 0 ):
            $status = $sql->getResult()[0]['status'];
        else:
            $sql->FullRead("SELECT id,status,patrimonio FROM tb_sys006 WHERE os_sti = :PAT ORDER BY id DESC limit 1","PAT=".$patrimonio."");
            if($sql->getRowCount() > 0 ):
                $status = $sql->getResult()[0]['status'];
            endif;
        endif;
        if($sql->getRowCount() > 0):
            switch ($status):
                case 1:
                    $msg = "EQUIPAMENTO AINDA NÃO FOI AVALIADO PELA BANCADA!";
                    break;
                case 2:
                    $msg = "NÃO FOI POSSIVEL REALIZAR A SAIDA DESSE EQUIPAMENTO!<code>STATUS (BLOQUEADO)!</code>";
                    break;
                case 3:
                    $msg = "NÃO CONSTA ENTRADA EM ABERTO PARA O PATRIMÔNIO/OS INFORMADO!";
                    break;
                case 4:
                    $cria->ExeCreate("tb_sys009",["id_saida"=>$saida,"data"=>date('Y-m-d'),"hora"=>date('H:i:s'),"id_item_entrada"=>$sql->getResult()[0]['id']]);
                    $atu->ExeUpdate("tb_sys006",["status"=>3],"WHERE id = :ID","ID={$sql->getResult()[0]['id']}");
                    unset($msg);
                    break;
                case 5:
                    $msg = "EQUIPAMENTO EM AGUARDO DE PEÇA NÃO PODE SER DADO BAIXA! POR FAVOR VERIFIQUE!";
                    break;
                case 6:
                    $msg = "EQUIPAMENTO EM GARANTIA NÃO PODE SER DADO BAIXA!";
                    break;
                case 7:
                    $dt = date('Y-m-d');
                    $hora = date('H:i:s');
                    $crud->insert('sys009 ', 'id_saida=?,data=?,hora=?,id_item_entrada=?', [$id_saida, $dt, $hora, $verificaEntrada->id]);
                    $crud->update('sys006 ', 'status=? WHERE id=? ', [3, $verificaEntrada->id]);
                    $crud->update('sys004 ', ' id_local =? WHERE patrimonio =?', [266, $parametro]);
                    break;
                default:
                    $msg = "VERIFIQUE O PATRIMONIO INFORMADO";
                    break;
            endswitch;
        else:
            $msg = "NÃO CONSTA REGISTRO DE ENTRADA EM ABERTO PARA O DADO INFORMADO!";
        endif;
    endif;
endif;

$sql->FullRead("SELECT * FROM tb_sys009 WHERE id_saida = :SAIDA", "SAIDA={$saida}");

if(isset($msg)):
  print "<div class=\"alert alert-warning text-primary text-center\" role=\"alert\">{$msg}</div>";
endif;

if($sql->getRowCount() > 0):?>

<table class="table-responsive-sm tabela-tab table-hover">
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">PATRIMÔNIO</th>
        <th class="text-center">ORDEM DE SERVIÇO</th>
        <th class="text-left">EQUIPAMENTO</th>
        <th class="text-left">LOCALIDADE</th>
    </tr>
<? $sql->FullRead('SELECT EQ.patrimonio,C.descricao equipamento,IE.os_sti,L.local,L.rua,F.nome_fabricante fabricante,M.modelo from tb_sys004 EQ
            JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
            JOIN tb_sys003 C ON C.id = EQ.id_categoria
            JOIN tb_sys008 L ON L.id = EQ.id_local
            JOIN tb_sys018 F ON F.id_fabricante = EQ.fabricante
            JOIN tb_sys022 M ON M.id_modelo = EQ.modelo
            JOIN tb_sys009 ISA ON ISA.id_item_entrada = IE.id
            JOIN tb_sys007 S ON S.id = ISA.id_saida AND  ISA.id_saida = :SAIDA',"SAIDA={$saida}");
$i = 0;
foreach ($sql->getResult() as $row)
    {?>
    <tr>
        <td class="text-center"><?=$i+=1;?></td>
        <td class="text-center text-uppercase"><?=$row['patrimonio'];?></td>
        <td class="text-center"><?=$row['os_sti'];?></td>
        <td class="text-capitalize"><?=$row['equipamento'].' '.$row['fabricante'].' '.$row['modelo'];?></td>
        <td class="text-capitalize"><?=$row['local'];?></td>
    </tr>
  <?}?>
</table>
<?php endif;?>
