<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>MeuVeterano - Upload</title>
    <style>
        #inputGroupFile02::-webkit-file-upload-button{
            height: 4rem;
            
        }
    </style>
</head>
<body>
    <div class="container-fluid" style="height: 100vh;">

        <?php include($headerPath); ?>

        <form class="row  text-light" id="uploadForm" style="height: 90%;" enctype="multipart/form-data" action="../upload_content.php" method="POST">
            <input type="hidden" name="admNick" value="<?php echo $admNick ?>">

            <div class="col-sm-6 bg-secondary" style="padding: 5%; height: 90vh; overflow: auto;">
                <h3 class="text-light">Arraste ou selecione um oumais arquivos</h3>
                <input style="height: 4rem; border: 1px solid #0d6efd;" class="form-control bg-dark text-light rounded-0" id="inputGroupFile02" name="fileInput[]" type="file" accept=".pdf, .docx, .pptx, .txt" multiple required>
                
                <table class="table table-striped" id="fileListTable"></table>
            </div>
            
            <div class="col-sm-6 bg-dark" id="metadata_inputs" style="padding: 5%;">
                <h3>Entre com os metadados do conteudo:</h3>
                
                <label class="form-label" for="tip">Matéria</label>
                <div class="input-group mb-3">
                    <select class="form-control bg-dark text-light" type="text" name="type" id="tip" placeholder="Tipo" required>
                        <option value="">Tipo de conteudo</option>
                        <option value="prova"> prova</option>
                        <option value="atividade">atividade</option>
                        <option value="lista">lista</option>
                        <option value="aula">aula (slides)</option>
                    </select>
                </div>

                <label class="form-label" for="dat">Ano/Semestre(1/2)</label>
                <div class="input-group mb-3">
                    <input class="form-control bg-dark text-light" name="year"id="dat" type="number" min="2019" max="2024" required>
                    <span class="input-group-text bg-dark text-light">/</span>
                    <input class="form-control bg-dark text-light" name="semester"type="number" min="1" max="2" required>
                </div>
                
                <label class="form-label text-light"for="subject_list">Materia</label>
                <div class="input-group mb-3">
                    <select class="form-control bg-dark text-light" id="subject_list" name="subject" id="mat" type="text" maxlenght="128" pattern="[A-Za-z]{128}" title="Titulo da materia com letras de a-zA-Z" required>
                        <option value="">Selecione a materia</option>
                        <?php $tree = dir("../folder");
                            while( false !==  ( $drct = $tree->read() )){
                                if($drct != "." && $drct !=".."){
                                    echo "<option value=$drct>$drct</option>";
                                }
                            }
                            $tree->close();
                        ?>
                    </select>
                </div>
                
                <label for="prof">Nome do professor(a)</label>
                <div class="input-group mb-3">
                    <input class="form-control bg-dark text-light" name="professor" id="prof" type="text" maxlegnth="64" title="Nome do professor referente ao conteudo em upload com letras de a-zA-Z" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-warning" type="submit">Salvar</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../uploadField.js"></script>
<?php echo handle_status_sessions('alert', 'data_validation_status'); ?>
</body>
</html>