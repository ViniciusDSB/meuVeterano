<?php 

$mySqli = connectdb('adminhome.php');

$admDataQuery = "SELECT username, avatar_path, uploads_done, deletions_done, editions_done FROM admins WHERE user = ?";
$admDataStmt = $mySqli->prepare($admDataQuery);
$admDataStmt->bind_param('s', $admNick);
$admDataStmt->execute();
$admDataStmt->bind_result($adminName, $avatarPath, $uploads_done, $deletions_done, $editions_done);
$admDataStmt->fetch();
$admDataStmt->close();

$adminsCounter = single_result_query($mySqli, 'SELECT COUNT(*) FROM admins', false);
$contentCounter = single_result_query($mySqli, 'SELECT COUNT(*) FROM contents', false);
$listasCounter = single_result_query($mySqli, 'SELECT COUNT(*) FROM contents WHERE content_type = ?', 'lista');
$provasCounter = single_result_query($mySqli, 'SELECT COUNT(*) FROM contents WHERE content_type = ?', "prova");
$atividadesCounter = single_result_query($mySqli, 'SELECT COUNT(*) FROM contents WHERE content_type = ?',"atividade");
$aulasCounter = single_result_query($mySqli, 'SELECT COUNT(*) FROM contents WHERE content_type = ?', "aula");
$mySqli->close();

$folder = dir("../folder/");
$foldersCounter = 0;
while( false !==  $folder->read() ){
    $foldersCounter+=1;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Admnistração</title>

    <style>
        #main_content{
            background-image: url("https://wallpapercave.com/wp/wp7817994.jpg");
            background-size: cover;
            backgroung-repeat: no-repeat;
        }
        #content_row::before{
            filter: brightness(50%);
        }
        .anchorCard{
            text-decoration: none;
        }
        .card{
            opacity: 0.9;
            transition: 0.3s;
        }
        .card:hover{
            transition: 0.3s;
            opacity: 1;
            transform: scale(1.05);
            z-index: 10;
        }
    </style>
</head>
<body>
<div class="container-fluid" style="height: 100vh;">

    <?php include($headerPath); ?>
    <div id="main_content" class="row" style="max-height:90vh; overflow: auto; padding: 5%;">
        <div class="row"  id="content_row">
            <div class="col-sm-8">
                <div class="row-sm-8">
                    <div class="card mb-3 text-bg-primary">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?php echo '../'.$avatarPath ; ?>" class="img-fluid rounded-0" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo "Administrador: ". ucwords($adminName); ?></h5><br>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Historico do administrador:</p>
                                    <p class="card-text"><?php echo $uploads_done ?> - Uploads feitos</p>
                                    <p class="card-text"><?php echo $deletions_done ?> - Uploads deletados</p>
                                    <p class="card-text"><?php echo $editions_done ?> -  Edições feitas</p>
                                    <a class="card-subtitle mb-2 text-body-secondary" href="#">Editar perfil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                <div class="col">
                        <a class="anchorCard" href="#">
                            <div class="card mb-3 text-bg-warning">
                                <div class="card-body">
                                    <h5 class="card-title">Gerenciar pastas</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">criar e alterar</h6><br>
                                    <p class="card-text"><?php echo $foldersCounter ." Matérias/pastas" ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a class="anchorCard" href="#">
                            <div class="card mb-3 text-bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Novo administrador</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">adicionar</h6><br>
                                    <p class="card-text"><?php echo $adminsCounter; ?> Admistradores</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="row">
                    <a class="anchorCard" href="index.php?page=menage">
                        <div class="card mb-3 text-bg-dark">
                            <div class="card-body">
                                <h5 class="card-title">Gerenciar conteudo</h5>
                                <h6 class="card-subtitle mb-2 text-primary">menageFiles</h6><br>
                                <p class="card-text">
                                    <?php echo $listasCounter .' Listas disponíveis'; ?><br>
                                    <?php echo $provasCounter .' Provas disponíveis'; ?><br>
                                    <?php echo $atividadesCounter .' Atividades disponíveis'; ?><br>
                                    <?php echo $aulasCounter .' Aulas disponíveis' ?>
                                </p>
                            </div>
                        </div>  
                    </a>
                </div>
                <div class="row">
                    <a class="anchorCard" href="index.php?page=upload">
                        <div class="card mb-3 text-bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Adicionar conteudo</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">upload</h6><br>
                                <p class="card-text"><?php echo $contentCounter .' Upload feitos' ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let cards = document.getElementsByClassName('card');
    for (let i = 0; i < cards.length; i++) {
        cards[i].className = cards[i].className +' border border-0 rounded-0';
    }
</script>
</body>
</html>