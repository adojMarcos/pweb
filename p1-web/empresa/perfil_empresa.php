<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<h3 class="text-center">Atualizar informações</h3>

<?php
    session_start();

    require_once "../connection.php";

    $select_stmt = $db->prepare('SELECT * FROM empresa WHERE Id =:id'); 
    $select_stmt->bindParam(':id', $_SESSION["em_id"]);
    $select_stmt->execute(); 
    
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);


    if (isset($_REQUEST['btn_update'])) {
    
        $nome_up = $_REQUEST['txt_nome'];
        $endereco_up = $_REQUEST['txt_endereco'];
        $email_up = $_REQUEST['txt_email'];
        $tamanho_up = $_REQUEST['txt_tamanho'];

        if (empty($nome_up)) {
            $errorMsg="Digite um nome.";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt=$db->prepare('UPDATE empresa SET nome=:enome, endereco=:esob, email=:eem, tamanho=:eta WHERE Id=:id'); 
                    $update_stmt->bindParam(':enome', $nome_up);
                    $update_stmt->bindParam(':esob', $endereco_up);
                    $update_stmt->bindParam(':eem', $email_up);
                    $update_stmt->bindParam(':eta', $tamanho_up);
                    $update_stmt->bindParam(':id', $_SESSION["em_id"]);
                    
                    if ($update_stmt->execute()) {
                        $updateMsg="Record Update Successfully......."; 
                        header("refresh:1;empresa_home.php"); 
                    }
                } 
            } catch(PDOException $e) {
                echo $e->getMessage();
            } 
        } 
    }

    if(isset($errorMsg)){
?>
        <div class="alert alert-danger">
            <strong>ERROR <?php echo $errorMsg; ?></strong>
        </div>
    <?php
}
    if(isset($updateMsg)){
    ?>
        <div class="alert alert-success">
            <strong><?php echo $updateMsg; ?></strong>
        </div>
    <?php
    }
    ?>

<form action="" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-sm-3 control-label">Nome</label>
        <div class="col-sm-6">
            <input type="text" name="txt_nome" class="form-control" placeholder="Digite seu nome" value="<?php echo $row['Nome']; ?>"/>
        </div>
    </div>
        
    <div class="form-group">
        <label class="col-sm-3 control-label">Endereço</label>
        <div class="col-sm-6">
            <input type="text" name="txt_endereco" class="form-control" placeholder="Digite seu sobrenome" value="<?php echo $row['Endereco']; ?>" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Email</label>
        <div class="col-sm-6">
            <input type="email" name="txt_email" class="form-control" placeholder="Digite seu email" value="<?php echo $row['Email']; ?>" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Tamanho da Empresa</label>
        <div class="col-sm-6">
            <input type="text" name="txt_tamanho" class="form-control" placeholder="Digite seu telefone" value="<?php echo $row['Tamanho']; ?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <input type="submit"  name="btn_update" class="btn btn-warning" value="Salvar">
            <a href="./empresa_home.php" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
 </form>