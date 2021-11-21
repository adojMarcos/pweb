<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<h2 class="text-center">Candidaturas</h2>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>X</th>
            <th>Desrição da Vaga</th>
            <th>Data Inscrito</th>
            <th>Z</th>
        </tr>
    </thead>
    <tbody>
 <?php
    session_start();

    require_once '../connection.php';

    $select_stmt=$db->prepare("SELECT can.*, v.Descricao FROM candidatura can
                                INNER JOIN Vaga v ON IdVaga = v.Id
                                WHERE IdCandidato = :usid");
    $select_stmt->bindParam(":usid", $_SESSION["cd_id"]);
    $select_stmt->execute();

    while ($row=$select_stmt->fetch(PDO::FETCH_ASSOC)) {
 ?>
        <tr>
            <td><?php echo $row['Id']; ?></td>
            <td><?php echo $row['Descricao']; ?></td>
            <td><?php echo $row['DataCriada']; ?></td>
            <td><a href="?deletar_id=<?php echo $row['Id']; ?>" class="btn btn-danger">Cancelar Candidatura</a></td>
        </tr>
    <?php
    }
    ?>
   </tbody>
</table> 

<?php
    if (isset($_REQUEST['deletar_id'])) {
        $id=$_REQUEST['deletar_id']; 
        
        $select_stmt= $db->prepare('SELECT * FROM candidatura WHERE id =:id');
        $select_stmt->bindParam(':id',$id);
        $select_stmt->execute();
        $row=$select_stmt->fetch(PDO::FETCH_ASSOC);
        
        $delete_stmt = $db->prepare('DELETE FROM candidatura WHERE id =:id');
        $delete_stmt->bindParam(':id',$id);
        $delete_stmt->execute();
        
        header("Location:candidaturas.php");
    }
?>

<a href="./candidato_home.php" class="btn btn-danger">Voltar</a>