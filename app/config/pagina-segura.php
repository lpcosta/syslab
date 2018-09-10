<?php
    require_once 'config.inc.php';
    if(!isset($_SESSION['UserLogado'])):
        header("Location:".HOME."");
    endif;


