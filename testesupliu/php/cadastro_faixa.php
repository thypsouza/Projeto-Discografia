<?php
    include_once('bancodedados.php');
 
    $numerofaixa = '';
    $nomefaixa = '';
    $duracaofaixa = '';
    $albumfaixa = '';
    $erros = [];

    if(isset($_POST['salvar'])){
       
        $numerofaixa = $_POST['numerofaixa'];
        $nomefaixa = $_POST['nomefaixa'];
        $duracaofaixa = $_POST['duracaofaixa'];
        $albumfaixa = $_POST['albumfaixa'];

        if($numerofaixa == "")
            $erros[] = "Número da Faixa";
        if($nomefaixa == "")
            $erros[] = "Nome da Faixa";
        if($duracaofaixa == "")
            $erros[] = "Duração da Faixa";
        if($albumfaixa == "")
            $erros[] = "Album da Faixa";



        if(empty($erros)){        
            if(!empty($_POST['editar_faixa'])){
                $query = "UPDATE faixa SET numero = '$numerofaixa' , nome='$nomefaixa',duracao='$duracaofaixa' , album_id='$albumfaixa' WHERE id =".$_POST['editar_faixa'];
            }else{
                $query = "INSERT INTO faixa (numero,nome ,duracao, album_id) values ('$numerofaixa','$nomefaixa','$duracaofaixa', '$albumfaixa')";
            }
                    
            $query_insercao = mysqli_query($conexao , $query);

            header('location: cadastro_faixa.php');
        
        }
    
        
    
    }

    if(isset($_GET['del_faixa'])){
        $del_query = "DELETE FROM faixa where id=".$_GET['del_faixa'];

        $delete_album = mysqli_query($conexao , $del_query);

        header('location:cadastro_faixa.php');
    }

    if(isset($_GET['edit_faixa'])){
        $query_edicao = "SELECT 
        numero ,nome , duracao, album_id 
        FROM faixa
        WHERE id=".$_GET['edit_faixa'];

        $faixa_data = mysqli_query($conexao , $query_edicao);
        $dados_faixa = mysqli_fetch_assoc($faixa_data);

        $numerofaixa = $dados_faixa['numero'];
        $nomefaixa = $dados_faixa['nome'];
        $duracaofaixa = $dados_faixa['duracao'];
        $albumfaixa = $dados_faixa['album_id'];


    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Faixas</title>
      <!-- Compiled and minified CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" href="../css/cadastro_album.css">
</head>
<body>
    <!-- <button data-target="mymodal" class="btn modal-trigger">Abrir</button> -->
    
    <div class="modal" id="mymodal">
        <div class="modal-content">
            <h4>Excluir Faixa</h4>
            <p>Deseja exluir Faixa ?</p>
        </div>

        <div class="modal-footer center-align">
            <a href="" class="btn green accent-2 modal-del">Sim</a>
            <a href="" class="btn red accent-2">Não</a>
        </div>
    </div>

    <h1 class="center-align">Cadastro de Faixas</h1>
    <form method="POST" action="cadastro_faixa.php">
        <div class="row container">
            <div class="col s12 m3 input-field">
                <input type="number" name="numerofaixa" value="<?= $numerofaixa ?>">
                <label>Número da Faixa</label>
            </div>
            <input type="hidden" name="editar_faixa" value="<?php if(isset($_GET['edit_faixa'])){ echo $_GET['edit_faixa'];}?>">
            <div class="col s12 m3 input-field">
                <input type="text" name="nomefaixa" value="<?= $nomefaixa ?>">
                <label>Nome da Faixa</label>
            </div>

            <div class="col s12 m3 input-field">
                <input type="text" name="duracaofaixa" value="<?= $duracaofaixa ?>">
                <label>Duração da Faixa</label>
            </div>

            <div class="input-field col m3 s12">
                <select name="albumfaixa">                  
                    <?php
                        $query_select_album = "SELECT * FROM album";
                        $retorno_albums = mysqli_query($conexao , $query_select_album);
                  
                        while($linhas_select = mysqli_fetch_assoc($retorno_albums)){?>                ?>
                                
                                <option value="<?= $linhas_select['id']?>"
                                <?= ($albumfaixa == $linhas_select['id']) ? 'selected': ''?>>
                                <?= $linhas_select['nome']?></option>
                    <?php }?>
                </select>
                <label>Selecione Album</label>
            </div>

            <div class="col s12 m12">
                <?php if(!isset($_GET['edit_faixa'])) {?>
                    <button type="submit" name="salvar" class="btn waves">Salvar</button>
                <?php }else {?> 
                 <button type="submit" name="salvar" class="btn deep-purple waves">Salvar Alterações</button>
                 <a href="cadastro_faixa.php" class="btn grey">Cancelar</a>
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
                    <th class="center-align">Numero</th>
                    <th class="center-align">Nome</th>
                    <th class="center-align">Duração</th>
                    <th class="center-align">Album</th>
                    <th class="center-align">Ações</th>
                </tr>

            <?php
                    $query_faixa = "SELECT faixa.id,
                    faixa.numero ,faixa.nome , faixa.duracao, album.nome 
                    as albumnome
                    FROM faixa
                    inner join album
                    on faixa.album_id = album.id";

                    $dados = mysqli_query($conexao , $query_faixa);

                    while($linhas = mysqli_fetch_assoc($dados)){?>
                        <tr>
                            <td class="center-align"><?= $linhas['numero']?></td>
                            <td class="center-align"><?= $linhas['nome'];?></td>
                            <td class="center-align"><?= $linhas['duracao'];?></td>
                            <td class="center-align"><?= $linhas['albumnome'];?></td>
                            <td class="center-align">
                                <a href="cadastro_faixa.php?edit_faixa=<?= $linhas['id']; ?>" class="btn blue">Editar</a>
                                <a href="#mymodal" class="btn red modal-trigger excluir" data-id-faixa="<?= $linhas['id']?>">Excluir</a>
                            </td>
                        </tr>
                    <?php }?>
            
            
            </table>
    </div>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="../js/cadastro_faixa.js"></script>

    
</body>
</html>