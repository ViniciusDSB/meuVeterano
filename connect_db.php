<?php

function handle_error($errorOrigin, $err){
    $_SESSION['client_err_msg'] = 'Estamos com problema ao nos conectar :(';
    $_SESSION['adm_err_log'] = "Origem: ". $errorOrigin ."<br> Codigo de erro ". $err->getCode() ." em ". $err->getFile()."<br> Erro: ".$err->getMessage();
    header("Location: index.php?page=error");
    exit;
}

function connectdb($calledBy){
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "veteranodb";
    try{
        $_SESSION['adm_err_log'] = '';
        $connection = new mysqli($host, $user, $password, $database);
        return $connection;
    }catch(Exception $err){
        handle_error($calledBy, $err);
    }
}
?>