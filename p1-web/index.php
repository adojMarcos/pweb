<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<h1 class="text-center">Login</h1>  
<form method="post" class="form-horizontal">
 
 <div class="form-group">
 <label class="col-sm-3 control-label">Email</label>
 <div class="col-sm-6">
 <input type="text" name="txt_email" class="form-control" placeholder="Digite seu email" />
 </div>
 </div>
     
 <div class="form-group">
 <label class="col-sm-3 control-label">Senha</label>
 <div class="col-sm-6">
 <input type="password" name="txt_senha" class="form-control" placeholder="Digite sua senha" />
 </div>
 </div>
     
 <div class="form-group">
 <label class="col-sm-3 control-label">Entrar como</label>
 <div class="col-sm-6">
  <select class="form-control" name="txt_role">
   <option value="" selected="selected"> - entrar como - </option>
   <option value="candidato">Candidato</option>
   <option value="empresa">Empresa</option>
  </select>
 </div>
 </div>
    
 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-9 m-t-15">
 <input type="submit" name="btn_login" class="btn btn-success" value="Login">
 </div>
 </div>
    
 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-9 m-t-15">
 Ainda não possui uma conta? <a href="register.php"><p class="text-info">Cadastre-se Agora</p></a>  
 </div>
 </div>
     
</form>



<?php
require_once 'connection.php';

session_start();

if(isset($_SESSION["candidato_login"])) 
{
 header("location: candidato/candidato_home.php"); 
}
if(isset($_SESSION["empresa_login"])) 
{
 header("location: empresa/empresa_home.php"); 
}


if(isset($_REQUEST['btn_login']))
{
 $email  =$_REQUEST["txt_email"]; 
 $password =$_REQUEST["txt_senha"];
 $role  =$_REQUEST["txt_role"];  
 $id = 0;
  
 if(empty($email)){      
  $errorMsg[]="Informe um email"; 
 }
 else if(empty($password)){
  $errorMsg[]="Informe uma senha"; 
 }
 else if(empty($role)){
  $errorMsg[]="Selecione uma role"; 
 }
 else if($email AND $password AND $role)
 {
  try
  {
   $select_stmt=$db->prepare("SELECT id,email,senha,role FROM user
          WHERE
          email=:uemail AND senha=:upassword AND role=:urole"); 
   $select_stmt->bindParam(":uemail",$email);
   $select_stmt->bindParam(":upassword",$password); 
   $select_stmt->bindParam(":urole",$role);
   $select_stmt->execute(); 
     
   while($row=$select_stmt->fetch(PDO::FETCH_ASSOC)) 
   {
    $dbId = $row["id"];
    $dbemail =$row["email"];
    $dbpassword =$row["senha"];  
    $dbrole  =$row["role"];
   }
   if($email!=null AND $password!=null AND $role!=null) 
   {
    if($select_stmt->rowCount()>0) 
    {
     if($email==$dbemail AND $password==$dbpassword AND $role==$dbrole)
     {
      switch($dbrole)  //role base user login start
      {
       case "candidato":
        $_SESSION["candidato_login"]=$email;  
        $_SESSION["candidato_id"]=$dbId;
        $loginMsg="Candidato... Logado com sucesso..."; 
        header("refresh:1;candidato/candidato_home.php"); 
        break;
        
       case "empresa":
        $_SESSION["empresa_login"]=$email; 
        $_SESSION["empresa_id"]=$dbId;   
        $loginMsg="empresa... Logado com sucesso...";  
        header("refresh:1;empresa/empresa_home.php");
        break;
        
       default:
        $errorMsg[]="email ou senha errados";
      }
     }
     else
     {
      $errorMsg[]="email ou senha errados";
     }
    }
    else
    {
     $errorMsg[]="email ou senha errados";
    }
   }
   else
   {
    $errorMsg[]="email ou senha errados";
   }
  }
  catch(PDOException $e)
  {
   $e->getMessage();
  }  
 }
 else
 {
  $errorMsg[]="email ou senha errados";
 }
}
?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>