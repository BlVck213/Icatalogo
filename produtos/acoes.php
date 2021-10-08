<?php

require("../database/conexao.php");

switch ($_POST['acao']) {
    case 'inserir':

       
        $nomeArquivo = $_FILES["foto"]["name"];

        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

        $novoNome = md5(microtime()) . "." . $extensao;


        move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNome");


        $descricao = $_POST["descricao"];
        $peso = $_POST["peso"];
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = $_POST["valor"];
        $desconto = $_POST["desconto"];
        $categoriaID = $_POST["categoria"];


        $sql = "INSERT INTO tbl_produto 
        (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem,categoria_id) 
        VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, $desconto, 
        '$novoNome', $categoriaID)";

        $resultado = mysqli_query($conexao, $sql);

        header('location: index.php');

        break;
    
    default:

        break;
}