<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


<center>
 <h1>Candidato!!!</h1>
    
 <h3>
 <?php
  session_start();

  if(!isset($_SESSION['candidato_login'])) 
  {
   header("location: ../index.php");  
  }

  if(isset($_SESSION['employee_login'])) 
  {
   header("location: ../employee/employee_home.php"); 
  }

  if(isset($_SESSION['user_login'])) 
  {
   header("location: ../user/user_home.php");
  }
  
  if(isset($_SESSION['candidato_login']))
  {
  ?>
   Bem vindo,
  <?php
    $test = $_SESSION['candidato_id'];
   echo $test;
  }
  ?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>X</th>
            <th>Y</th>
            <th>Z</th>
            <th>D</th>
        </tr>
    </thead>
    <tbody>
 <?php
 require_once '../connection.php';

 $select_stmt=$db->prepare("SELECT * FROM user");
 $select_stmt->execute();
 while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
 {
 ?>
        <tr>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Id']; ?></td>
            <td><a href="edit.php?update_id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a></td>
            <td><a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a></td>
        </tr>
    <?php
 }
 ?>
   </tbody>
</table> 

 </h3>
  <a href="../logout.php">Logout</a>
</center>