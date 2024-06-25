<?php
$mySqli= connectdb("home.php");

$file_id = '';

if( isset($_POST['file_id']) ){
    $file_id = $_POST['file_id'];
}else if( isset($_GET['id']) ){
    $file_id = $_GET['id'];
}else{
    $gettedId = 0;
}

if($file_id == 0 || strlen($file_id) != 32){
    //verify where the visualization request came from to go back there
    Header("Location: index.php");
}
$query = "SELECT file_path FROM contents WHERE file_id = ?";
$mySqli = connectdb("view_doc.php", "handle_error.php");
$filePath = "../".single_result_query($mySqli, $query, $file_id);

$contentType = mime_content_type($filePath);
header("Content-Type: $contentType");
readfile($filePath);
exit;

?>
