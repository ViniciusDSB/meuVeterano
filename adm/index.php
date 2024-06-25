<?php
session_start();
include("../global_functions.php");
include("../connect_db.php");

function render($page){

    $main_page = '../public/index.php?page=home';
    $search_page = '../public/index.php?page=search';
    $faq_page = '../public/index.php?page=faq';
    $headerPath = "../templates/header.php";
    
    $admNick = isset($_COOKIE['admNick']) ? $_COOKIE['admNick'] : '';

    include("$page");
}

function setPage(){
    $publicPages = glob('*.php');
    $pageToRender = isset($_GET['page']) ? $_GET['page'] : 0;
    $page = $pageToRender.".php";
    if( !in_array($page, $publicPages) ){
        header($_SERVER['SERVER_PROTOCOL']."404 Not Found");
        exit;
    }else{
        render($page);
    }
}

function validateUser($admNickHash, $admHash){
    $getAdmin = "SELECT user_key FROM admins WHERE user = ?";
    $mySqli = connectdb("index.php");

    $stmt = $mySqli->prepare($getAdmin);
    $stmt->bind_param('s', $admNickHash);
    $stmt->execute();
    $stmt->bind_result($userKey);
    $stmt->fetch();
    $stmt->close();
    $mySqli->close();

    if($userKey == $admHash){

        $expireIn = time() + 24*60*60;
        
        setcookie('admNick', $admNickHash , $expireIn);
        setcookie('admHash', $admHash , $expireIn);

        setPage();
    }else{
        $_SESSION['login_status'] = 'Login invalido';
        render('login.php');
    }
}

function validateUserData($admNickHash, $admHash){
    $unwantedChars = ['-', '(', ')', '$', ','];
    $isUnvalidChar = false;

    foreach($unwantedChars as $unwantedChar){
        if(strpos($admNickHash, $unwantedChar)
        || strpos($admHash, $unwantedChar) ){
            $isUnvalidChar = true;
            break;
        }
    }
    if(strlen($admNickHash) != 32 || strlen($admHash) != 64){
        $_SESSION['login_status'] = 'Login invalido. User ou senha muito longo!';
        render('login.php');
    }else if($isUnvalidChar){
        $_SESSION['login_status'] = 'Login invalido. Caractere inválido';
        render('login.php');
    }else{
        validateUser($admNickHash, $admHash);
    }


}

if( isset($_POST['admNick']) && isset($_POST['admPass']) ){

    $admNickHash = hash('md5',  $_POST['admNick']);
    $admHash = hash('sha256', $_POST['admPass']);

    validateUserData($admNickHash, $admHash);

}else if(isset($_COOKIE['admNick']) && isset($_COOKIE['admHash'])){

    validateUserData($_COOKIE['admNick'], $_COOKIE['admHash']);
}else{
    render('login.php');
}
?>