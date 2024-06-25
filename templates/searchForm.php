<?php $tree = dir("../folder/"); ?>
<form enctype="multipart/form-data" method="POST" class="col-sm-3 bg-dark" style="padding: 2%;" >
    <div class="input-group mb-3">
        <select class="form-select" id="type_selector" type="text" name="type" placeholder="Tipo">
            <option value="">Selecione um tipo</option>
            <option value="prova"> Provas</option>
            <option value="atividade">Atividades</option>
            <option value="lista">Listas</option>
            <option value="aula">Aulas</option>
        </select>
    </div>
    
    <div class="input-group mb-3">
        <input class="form-control" name="year" placeholder="Ano" type="number"     min="2019" max="2024">
        <input class="form-control" name="semester"  placeholder="Semestre" type="number" min="1" max="2">
    </div>
    
    <div class="input-group mb-3">
        <select class="form-select" id="subject_list" name="subject" placeholder="MATERIA" type="text" maxlenght="128" pattern="[A-Za-z]{128}" title="Titulo da materia com letras de a-zA-Z">
            <option value="">Selecione uma materia</option>
            <?php
                while( false !==  ( $drct = $tree->read() )){
                    if($drct != "." && $drct !=".."){
                        echo "<option value=$drct>$drct</option>";
                    }
                }
                $tree->close();
            ?>
        </select>
    </div>
    
    <div class="input-group mb-3">
        <input class="form-control" name="professor" placeholder="Nome do(a) professor(a)" type="text" maxlegnth="64" title="Nome do professor referente ao conteudo em upload com letras de a-zA-Z">
    </div>
    
    <div class="d-grid gap-2">
        <button  class="btn btn-outline-primary" type="submit">Procurar</button>
    </div>
</form>