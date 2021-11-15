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

 </h3>
  <a href="../logout.php">Logout</a> ||
  <a href="vagas.php">Ver Vagas</a>
</center>