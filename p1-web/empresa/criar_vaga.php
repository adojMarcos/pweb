<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<?php
        session_start();

        require_once '../connection.php';

        if (isset($_REQUEST['btn_insert'])) {
            $descricao = $_REQUEST['txt_descricao']; 
            $salario = $_REQUEST['txt_salario']; 
            $experiencia = $_REQUEST['txt_experiencia']; 
            $tipo = $_REQUEST['txt_remoto']; 
            $habilidades = $_REQUEST['txt_habilidades']; 

            try {
                if (!isset($errorMsg)) {
                $insert_stmt=$db->prepare('INSERT INTO vaga(descricao,IdEmpresa, IdUser, Salario, Experiencia, Tipo) VALUES(:vdescricao,:videm, :vid, :vsalario, :vexp, :vtipo)');      
                $insert_stmt->bindParam(':vdescricao',$descricao);
                $insert_stmt->bindParam(':vsalario',$salario);
                $insert_stmt->bindParam(':vexp',$experiencia);
                $insert_stmt->bindParam(':vtipo',$tipo);
                $insert_stmt->bindParam(':videm',$_SESSION['em_id']);
                $insert_stmt->bindParam(':vid', $_SESSION["empresa_id"]);   
                
                if ($insert_stmt->execute()) {
                $idVaga = $db->lastInsertId();
                foreach ($habilidades as $habilidade) {
                        $insert_vh=$db->prepare('INSERT INTO vaga_habilidade(IdVaga, IdHabilidade) VALUES (:vhidvaga, :vhidhab)');
                        $insert_vh->bindParam(':vhidvaga', $idVaga);
                        $insert_vh->bindParam(':vhidhab', $habilidade);

                        if($insert_vh->execute()){
                            $insertMsg="Sucesso"; 
                            header("refresh:1;empresa_home.php");
                            }
                        }                             
                    }
                }


            } catch(PDOException $e) {
                    echo $e->getMessage();
            }
            
        }
?>

<h2 class="text-center">Criar Vagas</h2>
<form method="post" class="form-horizontal">    
        <div class="form-group">
            <label class="col-sm-3 control-label">Descrição</label>
            <div class="col-sm-6">
                <input type="text" name="txt_descricao" class="form-control" placeholder="Descreva a vaga" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Salario</label>
            <div class="col-sm-6">
                <input type="text" name="txt_salario" class="form-control" placeholder="Informe o salario" />
            </div>
        </div>

        <div class="form-group">
              <label class="col-sm-3 control-label">Expêriencia</label>
              <div class="col-sm-6">
                     <select class="form-control" name="txt_experiencia">
                            <option value="" selected="selected">Escolha</option>
                            <option value="Junior">Junior</option>
                            <option value="Pleno">Pleno</option>
                            <option value="Senior">Senior</option>
                     </select>
              </div>
       </div>

       <div class="form-group">
              <label class="col-sm-3 control-label">Habilidades</label>
              <div class="col-sm-6">
                     <select class="form-control" multiple name="txt_habilidades[]">
                            <?php 
                                require_once '../connection.php';

                                $select=$db->prepare("SELECT * FROM habilidade");
                                $select->execute();
                                
                                while ($row=$select->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value=<?php echo $row['Id'] ?>><?php echo $row['Nome'] ?></option>";
                                <?php
                                }
                                ?>
                                
                            
                     </select>
              </div>
       </div>

       <div class="form-group">
              <label class="col-sm-3 control-label">Tipo da vaga</label>
              <div class="col-sm-6">
                     <select class="form-control" name="txt_remoto">
                            <option value="" selected="selected">Escolha o tipo</option>
                            <option value="Remoto">Remoto</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Híbrido">Híbrido</option>
                     </select>
              </div>
       </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9 m-t-15">
                <input type="submit"  name="btn_insert" class="btn btn-success " value="Criar">
                <a href="empresa_home.php" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
</form>

