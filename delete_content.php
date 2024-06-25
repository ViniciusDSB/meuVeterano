<?php 
include("commonQueries.php");
//Trycatch this shit!;
//also check if there a way to go to previous page with header;
session_start();
function handle_deletion_status($conn, $stmt, $msg){
    if($stmt){ $stmt->close(); }
    if($conn){ $conn->close(); }
    $_SESSION['deletion_status'] = $msg;
    header("Location: adm/index.php?page=menage");
    exit;
}
//maybe an async function can be useful here. it ways for the other function to work then it ends its processs;
function deleteFromDb($file_id, $admNick, $mySql){
    $delete = "DELETE FROM contents WHERE file_id = ?";
    $deleteStmt = $mySql->prepare($delete);
    $deleteStmt->bind_param('s', $file_id);
    if($deleteStmt->execute()){
        updateAdminProfile('deletions_done', 1, $admNick, $mySql);
        handle_deletion_status($mySqli, $deleteStmt, 'Conteudo deletado :)');
    }else{
        handle_deletion_status($mySqli, $deleteStmt, 'Problema ao tentar deletar do banco!');
    }
}
//chek if there a way of get the path and delete in a single query!;
function deleteFromFolder($file_id, $admNick, $mySql){
    $getFilePath = "SELECT file_path FROM contents WHERE file_id = ?";
    $filePathStmt = $mySql->prepare($getFilePath);
    $filePathStmt->bind_param('s', $file_id);
    $filePathStmt->execute();
    $filePathStmt->bind_result($filePath);
    $filePathStmt->fetch();
    if( file_exists($filePath) && unlink($filePath)){
        $filePathStmt->close();
        deleteFromDb($file_id, $admNick, $mySql);
    }else{
        handle_deletion_status($mySql, $admNick, $filePathStmt, 'Problema ao tentar deletar arquivo');
    }
}

include("connect_db.php");
$mySql = connectdb("delete_content.php");

if(isset($_POST['file_id'])
    && strlen($_POST['file_id']) == 32
    && isset($_POST['admNick'])){
    deleteFromFolder($_POST['file_id'], $_POST['admNick'], $mySql);
}else{
    handle_deletion_status($mySqli, 0, "ID não existe!");
}


?>