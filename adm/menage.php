<?php include("../search_content.php"); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>MeuVeterano - Gerenciar</title>
</head>
<body>
    <div class="container-fluid" style="height: 100vh;">

        <?php include($headerPath); ?>

        <div class="row">
            <?php include("../templates/searchForm.php"); ?>

            <div class="col-sm-9 overflow-auto" style="height: 90vh; padding: 0;">
                <table class="table table-dark table-striped">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Materia-Perido</th>
                        <th scope="col">Professor(a)</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </thead>
                    <tbody class="table-group-divider table-hover">
                        <?php $rowCount = 0;
                        foreach($searchResults as $row) {  
                            $rowCount +=1;
                            $content_type = ucfirst($row['content_type']);
                            $file_title = remove_extension($row['file_path']);
                            $content_period = $row['file_year']."/".$row['semester'];
                            $subject = format_subject($row['subject']);
                            $professor_name = ucwords($row['professor_name']);
                            $content_extension = " ".pathinfo($row['file_path'], PATHINFO_EXTENSION);
                        ?>
                        <tr scope="row">
                            <td><?php echo $rowCount; ?></td>
                            <td><?php echo $content_type; ?></td>
                            <td><?php echo $file_title; ?></td>
                            <td><?php echo $subject . " - " . $content_period;?> </td>
                            <td><?php echo $professor_name ?></td>
                            <!-- o deleete deve ser um formulario de um botao, action vai pra um php que confirma o deletamento -->

                            <td>
                                <form action="../public/index.php?page=viewContent" method="POST">
                                    <input name="file_id" type="hidden" value="<?php echo $row['file_id']; ?>">
                                    <button class="btn btn-outline-info">Ver</button>
                                </form>
                            </td>
                            
                            <td>
                                <form action="index.php?page=edit" method="POST">
                                    <input name="file_id" type="hidden" value="<?php echo $row['file_id']; ?>">
                                    <button class="btn btn-outline-warning">Editar</button>
                                </form>
                            </td>

                            <td>
                                <form action="../delete_content.php" method="POST">
                                    <input name="admNick" type="hidden" value="<?php echo $admNick; ?>">
                                    <input name="file_id" type="hidden" value="<?php echo $row['file_id']; ?>">    
                                <button type="submit" class="btn btn-outline-danger">Deletar</button>
                                </form>
                            </td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo handle_status_sessions('alert', 'deletion_status'); ?>
    <?php echo handle_status_sessions('alert', 'edition_status'); ?>

</body>
</html>