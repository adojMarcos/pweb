<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

 <?php
    
    session_start();
?>

<h1 class="text-center">Vagas Criadas</h1>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Descrição</th>
            <th>Editar</th>
            <th>Deletar</th>
        </tr>
    </thead>
    <tbody>
 <?php
 require_once '../connection.php';

  $id =  $_SESSION['empresa_id'];

 $select_stmt=$db->prepare("SELECT * FROM vaga WHERE IdUser = :vid");
 $select_stmt->bindParam(':vid', $id);
 $select_stmt->execute();
 while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
 {
 ?>
        <tr>
            <td><?php echo $row['Id']; ?></td>
            <td><?php echo $row['Descricao']; ?></td>
            <td><a href="edit.php?update_id=<?php echo $row['Id']; ?>" class="btn btn-warning">Editar</a></td>
            <td><a href="?delete_id=<?php echo $row['Id']; ?>" class="btn btn-danger">Deletar</a></td>
        </tr>
    <?php
 }
 ?>

   </tbody>
</table> 

<?php
    if(isset($_REQUEST['delete_id']))
    {

     $id=$_REQUEST['delete_id']; 
      
     $select_stmt= $db->prepare('SELECT * FROM vaga WHERE id =:id');
     $select_stmt->bindParam(':id',$id);
     $select_stmt->execute();
     $row=$select_stmt->fetch(PDO::FETCH_ASSOC);
      
     
     $delete_stmt = $db->prepare('DELETE FROM vaga WHERE id =:id');
     $delete_stmt->bindParam(':id',$id);
     $delete_stmt->execute();
      
     header("Location:vagas.php");
    }
?>

<a href="./empresa_home.php" class="btn btn-danger">Voltar</a>
