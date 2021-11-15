<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<h1 class="text-center">Vagas Disponiveis</h1>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>X</th>
            <th>Y</th>
            <th>Z</th>
        </tr>
    </thead>
    <tbody>
 <?php
 session_start();

 $test = $_SESSION['candidato_id'];
   echo $test;

 require_once '../connection.php';

 $select_stmt=$db->prepare("SELECT * FROM vaga");
 $select_stmt->execute();
 while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
 {
 ?>
        <tr>
            <td><?php echo $row['Id']; ?></td>
            <td><?php echo $row['Descricao']; ?></td>
            <td><a href="edit.php?update_id=<?php echo $row['Id']; ?>" class="btn btn-primary">Candidatar</a></td>
        </tr>
    <?php
 }
 ?>
   </tbody>
</table> 

<a href="./candidato_home.php" class="btn btn-danger">Voltar</a>
