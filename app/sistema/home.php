<?php
require_once './app/config/pagina-segura.php';
$sql = new Read();

?>

<div class="tabs">
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="app/sistema/ajax/entregas.php">Entregas</a></li>
        <li><a href="app/sistema/ajax/pendencias.php">Pendências</a></li>
        <li><a href="c_cep">Consulta CEP</a></li>
    </ul>
    <div id="home">
        
            <div class="row">
                <div class="col-md">
                  <h3>Laboratorio</h3>
                 
                </div>
                <div class="col-md ">
                   <h3>Entradas do Mês</h3>
                   
                </div>
                <div class="col-md">
                   <h3>Saídas do Mês</h3>
                   
                </div>
            </div>
        
    </div>
<!--    <div id="entregas">
        <h2>Entregas</h2>
        
    </div>
    <div id="c_cep">
        <h2>Consultar CEP</h2>
    </div>
    <div id="pendencias">
        <h2>Pendências</h2>
    </div>-->
</div>