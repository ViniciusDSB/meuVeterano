<?php

$query= "SELECT file_id, file_path, content_type, subject, file_year, semester, professor_name
FROM contents ORDER BY content_date DESC LIMIT 12";

$mySqli= connectdb("home.php");
$result_list = $mySqli->query($query);
$mySqli->close();

$activeHomeLink = 'active';
$activeSearchLink = '';
$activeFaqLink = '';

$cardColorList = ['lista' => 'text-bg-primary', 'atividade' => 'text-bg-secondary', 'prova' => 'text-bg-dark', 'aula' => 'text-bg-success']

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>MeuVeterano - Home</title>
    <style>
        .card{
            transition: 0.3s;
        }
        .card:hover{
            transition: 0.1s;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="container-fluid" style="height: 100vh;">

        <?php include ("../templates/header.php"); ?>

        <div class="row row-cols-md-3" style="padding: 2%;">
            <?php foreach($result_list as $row) { 
                $card_config = "card mb-3 rounded-0 border border-0 ".strtr($row['content_type'], $cardColorList);
                $card_header = ucfirst($row['content_type']) ." de ". format_subject($row['subject']);
                $content_id = $row['file_id'];
                $card_title = remove_extension($row['file_path']);
                $period_type = $row['file_year']. "/" . $row['semester'] ." - ". pathinfo($row['file_path'], PATHINFO_EXTENSION);
                $professor_name =ucwords($row['professor_name']);
            ?>

            <div class="col">
            
                <div class=" <?php echo $card_config; ?>" style="min-width: 18rem;">    
                    <div class="card-header"> <?php echo $card_header; ?> </div>
                        <a style="text-decoration: none;" class="card-body" href="index.php?page=viewContent&id=<?php echo $content_id; ?>">
                            <h5 class="card-title"> <?php echo $card_title; ?> </h5>
                            <p class="card-text"> <?php echo $period_type; ?> </p>
                            <p class="card-text"> <?php echo  $professor_name; ?> </p>
                        </a>
                    </div> 
                </div>
            

            <?php }?>
        </div>  
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        

    </script>
</body>
</html>

