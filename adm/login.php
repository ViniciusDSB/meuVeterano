<?php

$activeHomeLink = '';
$activeSearchLink = '';
$activeFaqLink = '';
$activeLoginLink = 'active';
$admNick = 'Faça login';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Administrator Login</title>

    <style>
        #login-image{
            height: 90vh;
            background-image: url("https://wallpapercave.com/wp/wp12519393.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>

</head>
<body>
    
<div class="container-fluid" style="height: 100vh;">

    <?php include($headerPath); ?>

    <div class="row">
        <div class="col-sm-6 bg-dark text-light">
            <div class="d-flex flex-row-reverse h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                
                <?php 
                    $pageToGo = isset($_GET['page']) ? $_GET['page'] : 'adminhome';
                ?>

                <form action="<?php echo 'index.php?page='.$pageToGo ?>" method="POST">

                    <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Coloque suas credenciais</h3>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example18">User</label>
                        <input type="text" name='admNick' id="form2Example18" class="form-control form-control-lg rounded-0" minlength="5" maxlength="32" requeired>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example28">Senha</label>
                        <input type="password" name='admPass' id="form2Example28" class="form-control form-control-lg rounded-0" minlengt="8" hrequired>
                    </div>

                    <div class="pt-1 mb-4">
                        <button class="btn btn-info btn-lg btn-block" type="submit">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="login-image" class="col-sm-6 px-0 d-none d-sm-block"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php echo handle_status_sessions('alert', 'login_status'); ?>
</body>
</html>