<?php

require("../database/conexao.php");

switch ($_POST['acao']) {
    case 'inserir':

       
        $nomeArquivo = $_FILES["foto"]["name"];

        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

        $novoNome = md5(microtime()) . "." . $extensao;


        move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNome");

        break;
    
    default:

        break;
}