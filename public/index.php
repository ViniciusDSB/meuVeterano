<?php
include("../global_functions.php");
include("../connect_db.php");

$publicPages = glob('*.php');
$pageToRender = isset($_GET['page']) ? $_GET['page'] : 0;
$page = $pageToRender.".php";
if( !in_array($page, $publicPages) ){
    header($_SERVER['SERVER_PROTOCOL']." 404 Not found");
    exit;
}


session_start();

$main_page = '?page=home';
$search_page = '?page=search';
$post_page = '?page=sendContent';
$faq_page = '?page=faq';

include("$page");
?>