<?php

$searchResults = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $type =         (isset($_POST['type']) && $_POST['type'] != '')      ? $_POST['type']      : false;
    $year =         (isset($_POST['year']) && $_POST['year'] != '')      ? $_POST['year']      : false;
    $semester =     (isset($_POST['semester']) && $_POST['semester'] != '')  ? $_POST['semester']  : false;
    $subject =      (isset($_POST['subject']) && $_POST['subject']!= '')    ? $_POST['subject']   : false;
    $professor =    (isset($_POST['professor']) && $_POST['professor'] != '') ? $_POST['professor'] : false;

    $toBindParams = array();
    $searchValues = array();

    if( $type ){
        $toBindParams[] = "content_type = ?";
        $searchValues[] = $type;
    }
    if( $year ){
        $toBindParams[] = "file_year = ?";
        $searchValues[] = $year;
    }
    if( $semester ){
        $toBindParams[] = "semester = ?";
        $searchValues[] = $semester;
    }
    if( $subject ){
        $toBindParams[] = "subject = ?";
        $searchValues[] = $subject;
    }

    if( $professor ){
        $toBindParams[] = "professor_name = ?";
        $searchValues[] = $professor;
    }

    //check if any of these has a value, if do so then continue the code execution. else it returns a status end exit;
    $mySqli = connectdb("search_content.php");
    $searchQuery = "SELECT file_path, file_id, content_type, subject, file_year, semester, professor_name FROM contents";

    if( !empty($toBindParams) && !empty($searchValues)){
        $searchQuery .= " WHERE " . implode(" AND ", $toBindParams) . " ORDER BY file_path";
        $queryStmt = $mySqli->prepare($searchQuery);
        $queryStmt->bind_param( str_repeat('s', count($toBindParams)), ...$searchValues );
        $queryStmt->execute();
        $searchResults = $queryStmt->get_result(); //if empty return a status session;
        $queryStmt->close();
        $mySqli->close();
    }
}
?>