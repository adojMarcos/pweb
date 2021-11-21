<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<h2 class="text-center">Editar Vagas</h2>
<?php
    require_once "../connection.php";

    if (isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id']; 
            $select_stmt = $db->prepare('SELECT * FROM vaga WHERE Id =:id'); 
            $select_stmt->bindParam(':id',$id);
            $select_stmt->execute(); 
    
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $descricao_up = $_REQUEST['txt_descricao'];
        $salario_up = $_REQUEST['txt_salario'];
        $tipo_up = $_REQUEST['txt_tipo'];
        $experiencia_up = $_REQUEST['txt_experiencia'];
            try {
                if (!isset($errorMsg)) {
                    $update_stmt=$db->prepare('UPDATE vaga SET descricao=:vdescricao, salario=:vsalario, tipo=:vtipo, experiencia=:vexperiencia WHERE Id=:id'); 
                    $update_stmt->bindParam(':vdescricao', $descricao_up);
                    $update_stmt->bindParam(':vsalario', $salario_up);
                    $update_stmt->bindParam(':vtipo', $tipo_up);
                    $update_stmt->bindParam(':vexperiencia', $experiencia_up);
                    $update_stmt->bindParam(':id',$id);
        
                    if ($update_stmt->execute()) {
                        $updateMsg="Vaga atualizada com sucesso."; 
                        header("refresh:1;vagas.php"); 
                    }
                } 
            } catch(PDOException $e) {
                echo $e->getMessage();      
        } 
    }

    if (isset($errorMsg)) {
?>
        <div class="alert alert-danger">
            <strong><?php echo $errorMsg; ?></strong>
        </div>
<?php
    }
    if (isset($updateMsg)) {
?>
    <div class="alert alert-success">
        <strong><?php echo $updateMsg; ?></strong>
    </div>
<?php
    }
?>
<form method="post" class="form-horizontal"> 
    <div class="form-group">
        <label class="col-sm-3 control-label">Descrição</label>
        <div class="col-sm-6">
            <input type="text" name="txt_descricao" class="form-control" value="<?php echo $row['Descricao']; ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Salario</label>
        <div class="col-sm-6">
            <input type="text" name="txt_salario" class="form-control" value="<?php echo $row['Salario']; ?>">
        </div>
    </div>

    <div class="form-group">
              <label class="col-sm-3 control-label">Tipo da vaga</label>
              <div class="col-sm-6">
                     <select class="form-control" name="txt_tipo">
                            <option value="<?php echo $row['Tipo']; ?>" selected="selected"><?php echo $row['Tipo']; ?></option>
                            <option value="Remoto">Remoto</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Híbrido">Híbrido</option>
                     </select>
              </div>
       </div>

    <div class="form-group">
              <label class="col-sm-3 control-label">Expêriencia</label>
              <div class="col-sm-6">
                     <select class="form-control" name="txt_experiencia">
                            <option value="<?php echo $row['Experiencia']?>" selected="selected"><?php echo $row['Experiencia'] ?></option>
                            <option value="Junior">Junior</option>
                            <option value="Pleno">Pleno</option>
                            <option value="Senior">Senior</option>
                     </select>
              </div>
       </div>
        
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
            <a href="./vagas.php" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
</form>