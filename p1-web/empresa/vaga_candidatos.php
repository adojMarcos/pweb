<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


<?php    
    session_start();
?>

<h1 class="text-center">Vagas Criadas</h1>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Sobrenome</th>
            <th>Telefone</th>
            <th>Experiência</th>
            <th>Recusar</th>
        </tr>
    </thead>
    <tbody>
 <?php
    require_once '../connection.php';

    $id =  $_SESSION['empresa_id'];

    $select_stmt=$db->prepare("SELECT c.Id, c.Nome, c.Sobrenome, c.Email, c.Telefone, c.Experiencia FROM `candidato` as c
                                inner join candidatura as ca
                                on c.Id = ca.IdCandidato
                                WHERE ca.IdVaga = :vid");
    $select_stmt->bindParam(':vid', $_REQUEST['vaga_id']);
    $select_stmt->execute();
    while ($row=$select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <tr>
            <td><?php echo $row['Nome']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Sobrenome']; ?></td>
            <td><?php echo $row['Telefone']; ?></td>
            <td><?php echo $row['Experiencia']; ?></td>
            <td><a href="?delete_id=<?php echo $row['Id']; ?>" class="btn btn-danger">Recusar</a></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table> 

<td><a href="vagas.php" class="btn btn-danger">Voltar</a></td>