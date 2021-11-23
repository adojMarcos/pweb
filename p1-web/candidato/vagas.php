<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<form method="post" class="form-horizontal">    
        <div class="form-group">
              <label class="col-sm-3 control-label">Filtrar</label>
              <div class="col-sm-2">
                     <select class="form-control" name="txt_habilidades">
                            <option value="0" selected="0">Escolha</option>";
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

              <div class="col-sm-3 col-sm-9 m-t-15">
                <input type="submit"  name="btn_search" class="btn btn-success " value="Procurar">
            </div>

       </div>
</form>

<h1 class="text-center">Vagas Disponiveis</h1>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>X</th>
            <th>Descrição</th>
            <th>Salario</th>
            <th>Expêriencia</th>
            <th>Tipo</th>
            <th>Habilidades</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
<?php
    session_start();

    require_once '../connection.php';

    if(isset($_REQUEST['btn_search']) && $_REQUEST['txt_habilidades'] != 0) {
        $habilidade = $_REQUEST['txt_habilidades'];
        echo $habilidade;
        $select_stmt=$db->prepare("SELECT v.Id, v.Descricao, v.Salario, v.Tipo, v.Experiencia FROM `vaga` as v
                                    inner join vaga_habilidade as vh 
                                    on v.Id = vh.IdVaga
                                    WHERE (:vhid IS NULL or vh.IdHabilidade = :vhid)");
        $select_stmt->bindParam(":vhid", $habilidade);

    } else {
        $select_stmt=$db->prepare("SELECT * FROM vaga");
    }

    $select_stmt->execute();

    while ($row=$select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <tr>
            <td><?php echo $row['Id'];?></td>
            <td><?php echo $row['Descricao'];?></td>
            <td><?php echo $row['Salario'];?></td>
            <td><?php echo $row['Experiencia'];?></td>
            <td><?php echo $row['Tipo'];?></td>
            <td><?php $selecth_stmt=$db->prepare("SELECT h.Nome
                                FROM habilidade as h
                                INNER JOIN vaga_habilidade as vh
                                    ON h.Id = vh.IdHabilidade
                                INNER JOIN vaga as v
                                    ON vh.IdVaga = v.Id
                                WHERE v.Id = :vid");
                        $selecth_stmt->bindParam(":vid", $row['Id']);
                        $selecth_stmt->execute();

                        while ($rowh=$selecth_stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo $rowh['Nome'];
                                echo ", ";
                        }

            ?></td>
            <td><a href="?vaga_id=<?php echo $row['Id'];?>" class="btn btn-primary">Candidatar</a></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table> 

<?php
    if (isset($_REQUEST['vaga_id'])) { 
        $id=$_REQUEST['vaga_id']; 
        $dia=date('d/m/y');

        $select_stmt=$db->prepare('SELECT id FROM candidato WHERE UserId =:usid');
        $select_stmt->bindParam(':usid', $_SESSION["candidato_id"]);
        $select_stmt->execute();
        $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

        $select_stmt=$db->prepare('INSERT INTO candidatura (IdCandidato, IdVaga, DataCriada) VALUES (:vidcan, :vid, :vdata)');
        $select_stmt->bindParam(':vidcan', $row["id"]);
        $select_stmt->bindParam(':vid', $id);
        $select_stmt->bindParam(':vdata', $dia);
        $select_stmt->execute();
        header("Location:vagas.php");

        $_SESSION["cd_id"]=$row["id"]; 
    }
?>

<a href="./candidato_home.php" class="btn btn-danger">Voltar</a>