<?php
    include_once('php/bancodedados.php');
    
    $parametro = '';
    if(isset($_GET['busca'])){
        $parametro = $_GET['busca'];
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discografia Tião Carreiro e Pardinho</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container">
        <div class="alinhamento">
            <div class="col m3">
                <img src="fotos/logo.png" alt="logo">
            </div>

            <div class="col m4">
                <h2>Discografia</h2>
            </div>  
        </div>
      
        <div class="row p-10">
            <form method="GET">
                <div class="input-field col m10 input-border">
                    <input type="text" name="busca">
                    <label for="">Digite uma palavra chave</label>
                </div>
        
        
                <div class="col m2 right">
                    <button class="btn blue search-button">Procurar</button>
                </div>
            </form>
          
        </div>
   
        
      <table>
       
       <tbody>
            <?php 
                $sql = "SELECT 
                album.nome as nomealbum,
                album.ano as anoalbum,
                    GROUP_CONCAT(faixa.nome , '') AS faixas,
                    GROUP_CONCAT(faixa.duracao,'') AS duracao,
                    GROUP_CONCAT(faixa.numero,'') AS numero
                FROM album
                INNER JOIN faixa
                ON album.id = faixa.album_id
                where faixa.nome like '%$parametro%'
                GROUP BY album.id";

                $dados = mysqli_query($conexao , $sql);
                $table = '';

                while($linhas = mysqli_fetch_assoc($dados)){
                    $table .= "<tr>";
                        $nomealbum = $linhas['nomealbum'];
                        $anoalbum = $linhas['anoalbum'];
                        $faixas = explode(',',$linhas['faixas']);
                        $duracoes = explode(',',$linhas['duracao']);
                        $numeros  = explode(',',$linhas['numero']);

                        $table .= "<td><b>Album: $nomealbum ,$anoalbum </b></td>";

                        $table .= "
                            <tr>
                                <td>Numero</td>
                                <td>Faixa</td>
                                <td>Duração</td>
                            </tr>
                        ";  
                   
                        for($i = 0 ; $i<count($faixas);$i++){
                            $table .= "<tr>";
                                $numero = $numeros[$i];
                                $faixa = $faixas[$i];
                                $duracao = $duracoes[$i];

                                $table .= "<td>$numero</td>";
                                $table .= "<td>$faixa</td>";
                                $table .= "<td>$duracao</td>";
                            $table .= "</tr>";
                        }
                
                    $table .="</tr>";

                }

                echo $table;
            ?>
            
       
       </tbody>
       
      </table>

    </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="js/index.js"></script>
</body>
</html>