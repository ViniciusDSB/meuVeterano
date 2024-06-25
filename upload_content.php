<?php
session_start();
include("global_functions.php");
//funcao pra redirecionar pra upload.php e mostrar o stats de upload no lado cliente
function handle_upload_status($conn, $stmtm, $error_text){
    if($stmt){ $stmt->close(); }
    if($conn){ $conn->close(); }
    $_SESSION['data_validation_status'] = $error_text;
    header("Location: adm/index.php?page=upload");
    exit;
}

/*
Make this file become obj oriented
sesison_start();
global functons;
handle error messages();
checkdata();
restructureFiles(&$filePost);
db_connection
upload each one
update user data
*/


//checks data from the front end page and it's validation in the inputs, except the file input;
//if everithing is fine it returns the filePath wich depends on the given metadata;
function checkData(){

    $metadata = [];

    $subject = isset($_POST['subject'])? $_POST['subject'] : '';
    if($subject != '' && !file_exists("folder/$subject") ){
        handle_upload_status(0, 0, "Essa materia ($subject) não consta em nossos dados!");   
    }//regular users will upload content of subjects that are not on our database
    //in the new version make it check if the subject alredy exists;

    $professor_name = remove_diacritics( strtolower( $_POST['professor'] ) );

    $allowedTypes = ["lista", "atividade", "prova", "aula"];
    $content_type = isset($_POST['type']) ? $_POST['type'] : '';
    if(!in_array($content_type, $allowedTypes)){
        handle_upload_status(0, 0, "Tipo inválido!");
    }
    //instead of writing 2024 just get the current year;
    $file_year = isset($_POST['year']) ? $_POST['year'] : '';
    if($file_year <2019 || $file_year >2024){
        handle_upload_status(0, 0, "Ano invalido! Apenas permitido entre 2019 e 2024!");
    }

    $semester = isset($_POST['semester']) ? $_POST['semester'] : '';
    if($semester != 1 && $semester != 2){
        handle_upload_status(0, 0, "Semestre invalido. Apenas 1 ou 2!");
    }

    $file_path = "folder/$subject/$content_type"."s/$file_year/$semester/";
    if(!is_dir($file_path) ){
        handle_upload_status(0, 0, "Um ou mais dados estão inválidos!");
    }
    $metadata = compact('subject', 'professor_name', 'content_type', 'file_year', 'semester', 'file_path');
    return $metadata;
}

//!! IMPORTANTE ENTENDER DIREITO ESSA ESTRUTURA DOS ARRAYS COM CHAVES NOMEADAS!
//this is a function for rearrange the $_FILES[] array to a more friendly structure;
//Usage exemple: print 'File Name: ' . $file['name'];
//funtion from https://www.php.net/manual/en/features.file-upload.multiple.php
//Функция переформатирует массив поданных POST'ом файлов;
function restructureFiles(&$filePost){
    $isMulti = is_array($filePost['name']);
    $fileCount = $isMulti ? count($filePost['name']) : 1;
    $fileKeys = array_keys($filePost);

    $fileAry = [];

    for($i=0; $i < $fileCount; $i++){
        foreach($fileKeys as $key){
            if($isMulti){ 
                $fileAry[$i][$key] = $filePost[$key][$i]; 
            }else{
                $fileAry[$i][$key] = $filePost[$key];
            }
        }
    }
    return $fileAry;
}

$inputedFiles = restructureFiles($_FILES['fileInput']);
$fileData = checkData();


//Prpearing db statemaent;
include("connect_db.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mySqli = connectdb("uploadFIles.php", "adm/adm_error_page.php");
$stmtQuery = $mySqli->prepare("INSERT INTO  contents (file_id, file_path, subject, professor_name, content_type, extension, file_year, semester, content_date)
VALUES (?,?,?,?,?,?,?,?,?)" );

$uploadAmout = 0;

foreach($inputedFiles as $inputedFile){

    $finalFilePath = $fileData['file_path'] . basename($inputedFile['name']);
    echo $finalFilePath . "<br>";

    $allowedExtensions = ["pdf", "docx", "txt", "pptx"];
    $extension = pathinfo($finalFilePath, PATHINFO_EXTENSION);
    if(!in_array($extension, $allowedExtensions)){
        handle_upload_status($mySqli, $stmtQuery, "Tipo de arquivo nao permitido!");
    }

    //i think wecan use asynchronous function to do the move_file() and the database query
    if(!move_uploaded_file( $inputedFile['tmp_name'], $finalFilePath ) ){
        handle_upload_status($mySqli, $stmtQuery, "Problema ao tentar salvar " . basename($inputedFile['name']) . " :(");
    }

    $file_id = hash("md5", $finalFilePath);

    $current_date= new DateTime("America/Campo_Grande");
    $content_date = $current_date->format("Y-m-d H-i-s");

    $stmtQuery->bind_param("ssssssiis", $file_id, $finalFilePath, $fileData['subject'], $fileData['professor_name'], $fileData['content_type'], $extension, $fileData['file_year'], $fileData['semester'], $content_date);
    if(!$stmtQuery->execute()){
        handle_upload_status($mySqli, $stmtQuery, "Problema ao tentar salvar " . basename($inputedFile['name']) . " no banco :(");
    }//fazer ele subir todos exceto os com erro ao inves de parar tudo a partir do erro

    $uploadAmout = $uploadAmout + 1;

}

include("commonQueries.php");
updateAdminProfile('uploads_done', $uploadAmout, $_POST['admNick'], $mySqli);
handle_upload_status($mySqli, $stmtQuery, "Tudo certo, arquivo salvo!");

?>
