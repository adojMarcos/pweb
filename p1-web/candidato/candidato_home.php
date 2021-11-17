<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


<center>
    <h1>Candidato!!!</h1>
        
    <h3>
        <?php
            session_start();

            require_once "../connection.php";

            if (!isset($_SESSION['candidato_login'])) {
                header("location: ../index.php");  
            }

            if (isset($_SESSION['empresa_login'])) {
                header("location: ../employee/empresa_home.php"); 
            }
            
            if (isset($_SESSION['candidato_login'])) {
        ?>
                Bem vindo,
            <?php
                $select_stmt=$db->prepare('SELECT * FROM candidato WHERE UserId =:usid');
                $select_stmt->bindParam(':usid', $_SESSION["candidato_id"]);
                $select_stmt->execute();
                $row=$select_stmt->fetch(PDO::FETCH_ASSOC);
                
                $_SESSION["cd_id"]=$row["Id"]; 

                echo $row["Nome"];
            }
            ?>

        <h1>Dados do usuario</h1>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Sobrenome</th>
                    <th>Telefone</th>
                    <th>Experiência</th>
                </tr>
            </thead>
            <tbody>
                <?php
                ?>
                <tr>
                    <td><?php echo $row['Nome']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['Sobrenome']; ?></td>
                    <td><?php echo $row['Telefone']; ?></td>
                    <td><?php echo $row['Experiencia']; ?></td>  
                </tr>
                <?php
                ?>
            </tbody>
        </table> 
    </h3>
        <a href="../logout.php">Logout</a> ||
        <a href="vagas.php">Ver Vagas</a> ||
        <a href="candidaturas.php">Ver candidaturas</a> ||
        <a href="perfil_candidato.php">Editar perfil</a> ||
</center>