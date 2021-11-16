<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<h3 class="text-center">Atualizar informações</h3>

<?php

session_start();

require_once "../connection.php";

  $select_stmt = $db->prepare('SELECT * FROM candidato WHERE Id =:id'); 
  $select_stmt->bindParam(':id', $_SESSION["cd_id"]);
  $select_stmt->execute(); 
 
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  extract($row);


if(isset($_REQUEST['btn_update']))
{
 
 $nome_up = $_REQUEST['txt_nome'];
 $sobrenome_up = $_REQUEST['txt_sobrenome'];
 $email_up = $_REQUEST['txt_email'];
 $telefone_up = $_REQUEST['txt_telefone'];
 $experiencia_up = $_REQUEST['txt_experiencia'];


 if(empty($nome_up)){
  $errorMsg="Digite um nome.";
 }
 else
 {
  try
  {
   if(!isset($errorMsg))
   {

    $update_stmt=$db->prepare('UPDATE candidato SET nome=:cnome, sobrenome=:csob, email=:cem, telefone=:ctel, experiencia=:cex WHERE Id=:id'); 
    $update_stmt->bindParam(':cnome', $nome_up);
    $update_stmt->bindParam(':csob', $sobrenome_up);
    $update_stmt->bindParam(':cem', $email_up);
    $update_stmt->bindParam(':ctel', $telefone_up);
    $update_stmt->bindParam(':cex', $experiencia_up);
    $update_stmt->bindParam(':id', $_SESSION["cd_id"]);
     
    if($update_stmt->execute())
    {
        $updateMsg="Record Update Successfully......."; 
        header("refresh:3;candidato_home.php"); 
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
        <strong>ERROR <?php echo $errorMsg; ?></strong>
    </div>
<?php
}
if(isset($updateMsg)){
?>
 <div class="alert alert-success">
  <strong><?php echo $updateMsg; ?></strong>
 </div>
<?php
}
?>

<form action="" method="post" class="form-horizontal">
<div class="form-group">
 <label class="col-sm-3 control-label">Nome</label>
 <div class="col-sm-6">
 <input type="text" name="txt_nome" class="form-control" placeholder="Digite seu nome" value="<?php echo $row['Nome']; ?>"/>
 </div>
 </div>
     
 <div class="form-group">
 <label class="col-sm-3 control-label">Sobrenome</label>
 <div class="col-sm-6">
 <input type="text" name="txt_sobrenome" class="form-control" placeholder="Digite seu sobrenome" value="<?php echo $row['Sobrenome']; ?>" />
 </div>
 </div>

 <div class="form-group">
 <label class="col-sm-3 control-label">Email</label>
 <div class="col-sm-6">
 <input type="email" name="txt_email" class="form-control" placeholder="Digite seu email" value="<?php echo $row['Email']; ?>" />
 </div>
 </div>

 <div class="form-group">
 <label class="col-sm-3 control-label">Telefone</label>
 <div class="col-sm-6">
 <input type="text" name="txt_telefone" class="form-control" placeholder="Digite seu telefone" value="<?php echo $row['Telefone']; ?>" />
 </div>
 </div>

 <div class="form-group">
 <label class="col-sm-3 control-label">Experiencia</label>
 <div class="col-sm-6">
 <input type="text" name="txt_experiencia" class="form-control" placeholder="Digite sua experiencia" value="<?php echo $row['Experiencia']; ?>" />
 </div>
 </div>

 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-9 m-t-15">
 <input type="submit"  name="btn_update" class="btn btn-warning" value="Salvar">
 <a href="./candidato_home.php" class="btn btn-danger">Cancelar</a>
 </div>
 </div>
 </form>