<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<?php

require_once "../connection.php";

if(isset($_REQUEST['update_id']))
{
 try
 {
  $id = $_REQUEST['update_id']; 
  $select_stmt = $db->prepare('SELECT * FROM vaga WHERE Id =:id'); 
  $select_stmt->bindParam(':id',$id);
  $select_stmt->execute(); 
 
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  extract($row);
 }
 catch(PDOException $e)
 {
  $e->getMessage();
 }
}

if(isset($_REQUEST['btn_update']))
{
 
 $descricao_up = $_REQUEST['txt_descricao'];

 echo $descricao_up;
 echo $id;
  
 if(empty($descricao_up)){
  $errorMsg="Digite uma descrição.";
 }
 else
 {
  try
  {
   if(!isset($errorMsg))
   {
    $update_stmt=$db->prepare('UPDATE vaga SET descricao=:vdescricao WHERE Id=:id'); 
    $update_stmt->bindParam(':vdescricao', $descricao_up);
    $update_stmt->bindParam(':id',$id);
     
    if($update_stmt->execute())
    {
        echo $update_stmt->rowCount();   
     $updateMsg="Record Update Successfully......."; 
     header("refresh:3;vagas.php"); 
    }
   } 
  }
  catch(PDOException $e)
  {
   echo $e->getMessage();
  } 
 } 
}

if(isset($errorMsg)){
?>
    <div class="alert alert-danger">
        <strong>WRONG ! <?php echo $errorMsg; ?></strong>
    </div>
<?php
}
if(isset($updateMsg)){
?>
 <div class="alert alert-success">
  <strong>UPDATE ! <?php echo $updateMsg; ?></strong>
 </div>
<?php
}
?>
<form method="post" class="form-horizontal">
     
 <div class="form-group">
 <label class="col-sm-3 control-label">Descrição</label>
 <div class="col-sm-6">
 <input type="text" name="txt_descricao" class="form-control" value="<?php echo $row['Descricao']; ?>">
 </div>
 </div>
 </div>
      
 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-9 m-t-15">
 <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
 <a href="./vagas.php" class="btn btn-danger">Cancelar</a>
 </div>
 </div>
   

</form>


