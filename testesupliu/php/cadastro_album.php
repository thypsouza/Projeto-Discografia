<?php
    include('bancodedados.php');
    $nomealbum = '';
    $anoalbum = '';
    $erros = [];

    if(isset($_POST['salvar'])){
       

        $nomealbum = $_POST['nomealbum'];
        $anoalbum = $_POST['anoalbum'];


        if($anoalbum == "")
            $erros[] = "Nome do Album";
        if($anoalbum == "")
            $erros[] = "Ano do Album";



        if(empty($erros)){        
            if(!empty($_POST['editar_album'])){
                $query = "UPDATE album SET nome = '$nomealbum' , ano='$anoalbum' WHERE ID =".$_POST['editar_album'];
            }else{
                $query = "INSERT INTO ALBUM (nome , ano) values ('$nomealbum','$anoalbum')";
            }
                    
            $query_insercao = mysqli_query($conexao , $query);

            header('location: cadastro_album.php');
        
        }
    
        
    
    }

    if(isset($_GET['del_album'])){
        $del_query = "DELETE FROM album where id=".$_GET['del_album'];

        $delete_album = mysqli_query($conexao , $del_query);

        header('location:cadastro_album.php');
    }

    if(isset($_GET['edit_album'])){
        $query_edicao = "SELECT * FROM album WHERE ID=".$_GET['edit_album'];
        $album_data = mysqli_query($conexao , $query_edicao);
        $dados_album = mysqli_fetch_assoc($album_data);
        $nomealbum = $dados_album['nome'];
        $anoalbum = $dados_album['ano'];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Albums</title>
      <!-- Compiled and minified CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" href="../css/cadastro_album.css">
</head>
<body>
    
    <div class="modal" id="mymodal">
        <div class="modal-content">
            <h4>Excluir Album</h4>
            <p>Deseja exluir Album ?</p>
        </div>

        <div class="modal-footer center-align">
            <a href="" class="btn green accent-2 modal-del">Sim</a>
            <a href="" class="btn red accent-2">Não</a>
        </div>
    </div>

    <h1 class="center-align">Cadastro de Albums</h1>
    <form method="POST" action="cadastro_album.php">
        <div class="row container">
            <div class="col s12 m8 input-field">
                <input type="text" name="nomealbum" value="<?= $nomealbum ?>">
                <label>Nome do Album</label>
            </div>
            <input type="hidden" name="editar_album" value="<?php if(isset($_GET['edit_album'])){ echo $_GET['edit_album'];}?>">
            <div class="col s12 m4 input-field">
                <input type="number" name="anoalbum" value="<?= $anoalbum ?>">
                <label>Ano do Album</label>
            </div>

            <div class="col s12 m8">
                <?php if(!isset($_GET['edit_album'])) {?>
                    <button type="submit" name="salvar" class="btn waves">Salvar</button>
                <?php }else {?> 
                 <button type="submit" name="salvar" class="btn deep-purple waves">Salvar Alterações</button>
                 <a href="cadastro_album.php" class="btn grey">Cancelar</a>
                <?php } ?>
            </div>
            
        </div>
        <?php
            
            if(!empty($erros)){
                echo "<p class='red-text text-accent center-align'> campo obrigatórios: </p>";
                foreach($erros as $erro){
                    echo "<p style='color:red' class='center-align'> $erro </p>";
                }
            }
        ?>
    </form>
    <?php
     
    ?>
    <div class="container">
        <table class="table-responsive">
                <tr>
                    <th class="center-align">Nome do Album</th>
                    <th class="center-align">Ano do Album</th>
                    <th class="center-align">Ações</th>
                </tr>

            <?php
                    $query_album = "SELECT * FROM album";

                    $dados = mysqli_query($conexao , $query_album);

                    while($linhas = mysqli_fetch_assoc($dados)){?>
                        <tr>
                            <td class="center-align"><?= $linhas['nome']?></td>
                            <td class="center-align"><?= $linhas['ano'];?></td>
                            <td class="center-align">
                                <a href="cadastro_album.php?edit_album=<?= $linhas['id']; ?>" class="btn blue">Editar</a>
                                <a href="#mymodal" class="btn red modal-trigger excluir" data-id-album="<?= $linhas['id']?>">Excluir</a>
                            </td>
                        </tr>
                    <?php }?>
            
            
            </table>
    </div>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="../js/cadastro_album.js"></script>

    
</body>
</html>