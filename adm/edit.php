<?php

$file_id = isset($_POST['file_id']) ? $_POST['file_id'] : 0;
$mySqli = connectdb("edit.php");
$content = $mySqli->query("SELECT * FROM contents WHERE file_id = ".$file_id);

($content_type, $subject, $professor_name, $file_year, $semeste);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    <style>
        #answerKeyUploadDiv{
            display: none;
        }
    </style>

    <title>Editar conteudo</title>
</head>
<body>
    <div class="container_fluid">
        <?php include('../templates/header.php'); ?>

        <div class="row">

            <form action="../edit_content.php" method="POST" >

                <input type="hidden" name="admNick" value="<?php echo $admNick ?>">
                <input type="hidden" name="file_id" value="<?php echo $file_id; ?>">
                <div class="input-group mb-3">

                    <label class="form-label" for="tip">Materia</label>
                    <select class="form-control" type="text" name="type" id="tip" placeholder="Tipo">
                        <option value="<?php echo $content_type; ?>"><?php echo $content_type; ?></option>
                        <option value="prova"> prova</option>
                        <option value="atividade">atividade</option>
                        <option value="lista">lista</option>
                        <option value="aula">aula (slides)</option>
                    </select>

                    <label for="sbjct">Materia</label>
                    <input name="subject" type="text" id="sbjct" value="<?php echo $subject; ?>">

                    <label for="prof">Nome do professor(a)</label>
                    <input value="<?php echo $professor_name; ?>" class="form-control" name="professor" id="prof" type="text" maxlegnth="64">

                    <label class="form-label" for="dat">Ano/Semestre(1/2)</label>
                    <input class="form-control" name="year"id="dat" type="number" min="2019" max="2024" value="<?php echo $file_year; ?>">
                    <span class="input-group-text">/</span>
                    <input class="form-control" name="semester"type="number" min="1" max="2" value="<?php echo $semester; ?>">
                </div>

                <div id="answerKeyUploadDiv" >
                    <h3 class="">Adicione o gabarito</h3>
                    <input class="form-control rounded-0" id="inputGroupFile02" name="fileInput" type="file" accept=".pdf, .docx, .pptx, .txt">
                </div>

                <input id="addAnserKeyCheckBox" type="checkbox">
                <label for="addAnserKeyCheckBox">Adicionar gabarito</label>

                <button type="submit">Atualizar</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        answerKeyUploadDiv = document.getElementById("answerKeyUploadDiv");
        addAnserKeyCheckBox = document.getElementById("addAnserKeyCheckBox");

        addAnserKeyCheckBox.addEventListener('click', (event) => {
            if(answerKeyUploadDiv.style.display == "block"){
                answerKeyUploadDiv.style.display = "none";
            }else{
                answerKeyUploadDiv.style.display = "block";
            }
        })

        function showUploadDiv(){
            answerKeyUploadDiv.style.display = "block";
        }

    </script>
</body>
</html>