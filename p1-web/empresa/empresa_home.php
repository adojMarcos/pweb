<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


<center>
    <h1>Empresa!!!</h1> 
    <h3>
    <?php  
        require_once '../connection.php';

        session_start();

        if (!isset($_SESSION['empresa_login'])) {
            header("location: ../index.php");
        }

        if(isset($_SESSION['candidato_login'])) {
            header("location: ../candidato/candidato_home.php");
        }
            
        if (isset($_SESSION['empresa_login'])) {
    ?>
            Bem vindo,
            <?php
            $select_stmt=$db->prepare('SELECT * FROM empresa WHERE IdUser =:usid');
            $select_stmt->bindParam(':usid', $_SESSION["empresa_id"]);
            $select_stmt->execute();
            $row=$select_stmt->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION["em_id"]=$row["Id"]; 

            $test =  $_SESSION['em_id'];
            echo $test;
        }
            ?>
    </h3>

    <?php
        if (isset($errorMsg)) {
    ?>
            <div class="alert alert-danger">
                <strong>ERRADO ! <?php echo $errorMsg; ?></strong>
            </div>
            <?php
    }
            if(isset($insertMsg)){
            ?>
                <div class="alert alert-success">
                    <strong>SUCESSO ! <?php echo $insertMsg; ?></strong>
                </div>
            <?php
            }
            ?>
            
    <a href="./vagas.php">Ver vagas criadas</a>
    <a href="../logout.php">Logout</a> ||
    <a href="perfil_empresa.php">Editar Perfil</a> ||
    <a href="criar_vaga.php">Criar Vaga</a>
</center>