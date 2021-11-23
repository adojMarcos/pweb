<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<h2 class="text-center">Adicionar Habilidade</h2>
<form method="post" class="form-horizontal">    
        <div class="form-group">
            <label class="col-sm-3 control-label">Nome</label>
            <div class="col-sm-6">
                <input type="text" name="txt_habilidade" class="form-control" placeholder="Nome" />
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9 m-t-15">
                <input type="submit"  name="btn_insert" class="btn btn-success " value="Criar">
            </div>
        </div>
</form>

<?php

    require_once('./connection.php');

    if(isset($_REQUEST['btn_insert'])){

        $habilidade = $_REQUEST['txt_habilidade'];

        $insert_stmt=$db->prepare("INSERT INTO habilidade (Nome) VALUES (:hnome)");
        $insert_stmt->bindParam(":hnome", $habilidade);

        if($insert_stmt->execute()){
            $insertMsg="Sucesso"; 
        }

    }

    


?>