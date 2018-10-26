<?php
//WSErro :: Exibe erros lançados :: Front
function WSErro($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}<span class=\"ajax_close\"></span></p>";

    if ($ErrDie):
        die;
    endif;
}

function mblower($texto) {
    return print strip_tags(trim(mb_strtolower($texto, 'UTF-8')));
}


//PHPErro :: personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "Erro na Linha: #{$ErrLine} :: {$ErrMsg}";
    echo "{$ErrFile}";
    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

function Valor($valor) {
       $verificaPonto = ".";
       if(strpos("[".$valor."]", "$verificaPonto")):
           $valor = str_replace('.','', $valor);
           $valor = str_replace(',','.', $valor);
           else:
             $valor = str_replace(',','.', $valor);   
       endif;

       return $valor;
}

function paginaSegura() {
    if(!isset($_SESSION['UserLogado'])):
        header("Location:".HOME."");
        exit();
    endif;
}


set_error_handler('PHPErro');
