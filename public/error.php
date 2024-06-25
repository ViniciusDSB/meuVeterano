<?php 

if(isset($_SESSION['client_err_msg'])){
    echo $_SESSION['client_err_msg'];
}else{
    header($_SERVER['SERVER_PROTOCOL']."404");
    exit;
}
?>