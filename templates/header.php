<style>
    .nav-link{
        transition: 0.3s;
    }
    .nav-link:hover{
        color: white;
        transition: 0.3s;
        transform: scale(1.2);
    }
</style>
<div id="header" class="row" style="min-height: 10%;">
    <nav class="navbar navbar-expand-lg bg-primary bg-gradient" data-bs-theme="dark" style="padding-left: 5%;" id="navBar">
        <a class="navbar-brand mb-0 h1" href="">Meu Veterano</a>
    
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo $activeHomeLink ?>" href="<?php echo $main_page ?>">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activeSearchLink ?>" href="<?php echo $search_page ?>">Pesquisar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activeFaqLink ?>" href="<?php echo $faq_page ?>">Faq</a>
                </li>
                
                <?php if(isset($admNick)){ ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activeAdminhineLink ?>" href="index.php?page=adminhome">Admin Home</a>
                </li>
                <?php } ?>

            </ul>
        </div>
    </nav>
</div>
