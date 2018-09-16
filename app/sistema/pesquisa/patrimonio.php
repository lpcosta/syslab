<?php
require_once '../../config/autoload.inc.php';
require_once '../../funcoes/func.inc.php';
$sql = new Read();
extract(filter_input_array(INPUT_POST, FILTER_DEFAULT));
$patrimonio = strip_tags(trim($busca));

$sql->FullRead("SELECT 
    EQ.patrimonio,
    C.id id_equipamento,
    C.descricao equipamento,
    EQ.ip,
    EQ.id_local,
    EQ.andar,
    EQ.sala,
    EQ.status baixa,
    L.local,
    F.id_fabricante idFab,
    F.nome_fabricante fabricante,
    M.modelo
FROM
    tb_sys004 EQ
        JOIN
    tb_sys003 C ON C.id = EQ.id_categoria
        JOIN
    tb_sys018 F ON F.id_fabricante = EQ.fabricante
        JOIN
    tb_sys022 M ON M.id_modelo = EQ.modelo
        JOIN
    tb_sys008 L ON L.id = EQ.id_local
        AND EQ.patrimonio = :PAT", "PAT="."{$patrimonio}"."");

if($sql->getResult()):
?>

<div class="row">
    <div class="col-md form-inline">
        <label>Patrimonio:</label>
        <input type="text" class="form-control" disabled="" value="<?=$sql->getResult()[0]['patrimonio']?>"/>
    </div>
    <div class="col-md form-inline">
        <label>Equipamento:</label>
        <input type="text" class="form-control" disabled="" value="<?=$sql->getResult()[0]['equipamento']?>"/>
    </div>
    <div class="col-md form-inline">
        <label>Localidade:</label>
        <input type="text" class="form-control" disabled="" value="<?=$sql->getResult()[0]['local']?>"/>
    </div>
</div>
<?else:?>
<h1 class="text-center text-uppercase alert alert-warning" role="alert">nenhum registro encontrado! <br />para o patrimônio <?=$patrimonio?></h1>
<?php endif;?>
