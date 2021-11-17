<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<h1 class="text-center">Cadastro</h1>
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
                            <option value="" selected="selected"> - select role - </option>
                            <option value="candidato">Candidato</option>
                            <option value="empresa">Empresa</option>
                     </select>
              </div>
       </div>
       
       <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9 m-t-15">
                     <input type="submit"  name="btn_register" class="btn btn-primary " value="Register">
              </div>
       </div>
       
       <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9 m-t-15">
                     Já possui uma conta? <a href="index.php"><p class="text-info">Faça login</p></a>  
              </div>
       </div>
</form>

<?php
       require_once "connection.php";

       if (isset($_REQUEST['btn_register'])) {
              $email  = $_REQUEST['txt_email'];
              $password = $_REQUEST['txt_senha'];
              $role  = $_REQUEST['txt_role'];
       
              if (empty($email)){
                     $errorMsg[]="Informe um email"; 
              } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                     $errorMsg[]="Informe um email valido"; 
              } else if (empty($password)) {
                     $errorMsg[]="Informe uma senha"; 
              } else if (strlen($password) < 6) {
                     $errorMsg[] = "Senha deve ter ao menos 6 caracters"; 
              } else if (empty($role)) {
                     $errorMsg[]="Selecione uma role"; 
              } else { 
                     try { 
                            $select_stmt=$db->prepare("SELECT email FROM user WHERE email=:uemail"); 
                            $select_stmt->bindParam(":uemail",$email); 
                            $select_stmt->execute();
                            $row=$select_stmt->fetch(PDO::FETCH_ASSOC); 

                            if ($row["Email"]==$email) {
                                   $errorMsg[]="Email já cadastrado"; 
                            } else if (!isset($errorMsg)) {
                                   $insert_stmt=$db->prepare("INSERT INTO user(email,senha,role) VALUES(:uemail,:upassword,:urole)"); 
                                   $insert_stmt->bindParam(":uemail",$email);   
                                   $insert_stmt->bindParam(":upassword",$password);
                                   $insert_stmt->bindParam(":urole",$role);
              
                                   if ($insert_stmt->execute()) {
                                          if ($role == "candidato") {
                                                 $insert=$db->prepare("INSERT INTO candidato(UserId) VALUES(LAST_INSERT_ID())");
                                                 if ($insert->execute()) {
                                                        $registerMsg="Registrado com sucesso."; 
                                                 } 
                                          } else {
                                                 $insert=$db->prepare("INSERT INTO empresa(IdUser) VALUES(LAST_INSERT_ID())");
                                                 if($insert->execute()) {
                                                        $registerMsg="Registrado com sucesso.";
                                                 }
                                          }
                                          header("refresh:2;index.php"); 
                                   }
                            }
                     } catch(PDOException $e) {
                            echo $e->getMessage();
                     }
              }
       }
?>