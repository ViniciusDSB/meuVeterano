<?php
$admNick = $_POST['admNick'];
$file_id = $_POST['file_id'];

$toBindParams = array();
$toBindValues = array();

if( isset($_POST['type']) && $_POST['type'] != '' ){
    $type = $_POST['type'];
    $toBindParams[] = "content_type = ?";
    $toBindValues[] = $type;
}
if(isset($_POST['year']) && $_POST['year'] != ''){
    $year = $_POST['year'];
    $toBindParams[] = "file_year = ?";
    $toBindValues[] = $year;
}
if(isset($_POST['semester']) && $_POST['semester'] != ''){
    $semester = $_POST['semester'];
    $toBindParams[] = "semester = ?";
    $toBindValues[] = $semester;
}
if(isset($_POST['subject']) && $_POST['subject']!= ''){
    $subject = $_POST['subject'];
    $toBindParams[] = "subject = ?";
    $toBindValues[] = $subject;
}
if(isset($_POST['professor']) && $_POST['professor'] != ''){
    $professor = $_POST['professor'];
    $toBindParams[] = "professor_name = ?";
    $toBindValues[] = $professor;
}

include("connect_db.php");
$mySqli = connectdb("connect_db.php");
$updateQuery = "UPDATE contents SET ";
$fileToUpdate = " WHERE file_id = '$file_id'";

if( !empty($toBindParams) && !empty($toBindValues)){

    $updateQuery .= implode(", ", $toBindParams) . $fileToUpdate;
    $queryStmt = $mySqli->prepare($updateQuery);
    $queryStmt->bind_param( str_repeat('s', count($toBindParams) ), ...$toBindValues);
    if($queryStmt->execute()){
        header("Location: adm/index.php?page=menage");
    }else{
        echo "deu bosta";
    }

}

?>