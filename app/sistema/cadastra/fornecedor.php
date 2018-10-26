<?php
    paginaSegura();
    if(GRUPO != 4):
       header("Location:".HOME."");
       exit();
   endif;
    $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#cad-fornecdor">Cadastrar Fornecedor</a></li>
    </ul>
    <div id="cad-fornecdor">
        <h2 class="text-uppercase">novo Fornecedor</h2>
        <form class="form-cadastra" id="cadastra-fornecedor" onsubmit="return false;">
            <input type="hidden" name="acao" value="fornecedor" />
            <div class="row">
                <div class="col-md form-inline">
                    <label>Nome Fornecedor</label>
                    <input type="text"  name="nome_fornecedor" size="40" class="form-control" placeholder="Nome do Fornecedor..." />
                </div>
                <div class="col-md form-inline">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>    
                </div>
            </div>
            <hr />
        </form>
    </div>
</div>