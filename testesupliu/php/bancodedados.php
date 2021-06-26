<?php

    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $bd = "testesupliu";
    
    $conexao = mysqli_connect($servidor , $usuario, $senha, $bd);

    if(!$conexao)
        echo "Erro de conexao ".mysqli_connect_error();
    // else
    //     echo "Conexão realizada com sucesso";
    // mysqli_close($conexao);

?>