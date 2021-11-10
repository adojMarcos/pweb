<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


<center>
 <h1>Empresa!!!</h1>
    
 <h3>
 <?php
    
 session_start();

 if(!isset($_SESSION['empresa_login'])) 
 {
  header("location: ../index.php");
 }

 if(isset($_SESSION['admin_login'])) 
 {
  header("location: ../admin/admin_home.php");
 }

 if(isset($_SESSION['user_login'])) 
 {
  header("location: ../user/user_home.php");
 }
    
 if(isset($_SESSION['empresa_login']))
 {
 ?>
  Bem vindo,
 <?php
  $test =  $_SESSION['empresa_id'];
  echo $test;
 }
 ?>
 </h3>

 <?php
if(isset($errorMsg)){
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
<form method="post" class="form-horizontal">
     
 <div class="form-group">
 <label class="col-sm-3 control-label">Descrição</label>
 <div class="col-sm-6">
 <input type="text" name="txt_descricao" class="form-control" placeholder="Descreva a vaga" />
 </div>
 </div>
      
 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-9 m-t-15">
 <input type="submit"  name="btn_insert" class="btn btn-success " value="Insert">
 <a href="index.php" class="btn btn-danger">Cancel</a>
 </div>
 </div>
     
</form>

<?php

require_once "../connection.php";

session_start();



if(isset($_REQUEST['btn_insert']))
{
 $descricao = $_REQUEST['txt_descricao']; 
  
 if(empty($descricao)){
  $errorMsg="Descreeva a vaga";
 }
 else
 {
  try
  {
   if(!isset($errorMsg))
   {
    $insert_stmt=$db->prepare('INSERT INTO vaga(descricao,IdEmpresa, IdUser) VALUES(:vdescricao,:videm, :vid)');      
    $insert_stmt->bindParam(':vdescricao',$descricao);
    $insert_stmt->bindParam(':videm',$_SESSION["candidato_id"]);
    $insert_stmt->bindParam(':vid',$test);   
     
    if($insert_stmt->execute())
    {
     $insertMsg="Sucesso........"; 
     header("refresh:3;index.php"); 
    }
   }
  }
  catch(PDOException $e)
  {
   echo $e->getMessage();
  }
 }
}

?>

<a href="../logout.php">Logout</a>
</center>