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



        break;
    
    default:

        break;
}