<?php

    session_start();


require("../database/conexao.php");

function validarCampos(){

    // ARRAY DAS MENSAGENS DE ERRO
    $erros = [];

    //vALIDAÇÃO DE DESCRIÇÃO
    if ($_POST["descricao"] == "" || !isset($_POST["descricao"])) {
        
        $erros[] = "O CAMPO DESCRIÇÃO É OBRIGATÓRIO";

    }


    //VALIDAÇÃO DE PESO
    if ($_POST["peso"] == "" || !isset($_POST["peso"])) {
        
        $erros[] = "O CAMPO PESO É OBRIGATÓRIO";

    } elseif (!is_numeric(str_replace(",", ".", $_POST["peso"]))){

        $erros[] = "O CAMPO PESO DEVE SER UM NUMERO";

    }

    //vALIDAÇÃO DE QUANTIDADE
    if ($_POST["quantidade"] == "" || !isset($_POST["quantidade"])) {
        
        $erros[] = "O CAMPO QUANTIDADE É OBRIGATÓRIO";

    } elseif (!is_numeric(str_replace(",", ".", $_POST["quantidade"]))){

        $erros[] = "O CAMPO QUANTIDADE DEVE SER UM NUMERO";

    }

    //vALIDAÇÃO DE COR
    if ($_POST["cor"] == "" || !isset($_POST["cor"])) {
        
        $erros[] = "O CAMPO COR É OBRIGATÓRIO";

    }


    //vALIDAÇÃO DE VALOR
    if ($_POST["valor"] == "" || !isset($_POST["valor"])) {
        
        $erros[] = "O CAMPO VALOR É OBRIGATÓRIO";

    } elseif (!is_numeric(str_replace(",", ".", $_POST["valor"]))){

        $erros[] = "O CAMPO VALOR DEVE SER UM NUMERO";

    }


    //vALIDAÇÃO DE DESCONTO
    if ($_POST["desconto"] == "" || !isset($_POST["desconto"])) {
        
        $erros[] = "O CAMPO DESCONTO É OBRIGATÓRIO";

    } elseif (!is_numeric(str_replace(",", ".", $_POST["desconto"]))){

        $erros[] = "O CAMPO DESCONTO DEVE SER UM NUMERO";

    }


    //vALIDAÇÃO DE CATEGORIA
    if ($_POST["categoria"] == "" || !isset($_POST["categoria"])) {
        
        $erros[] = "O CAMPO CATEGORIA É OBRIGATÓRIO";

    }

    //VALIDAÇÃO DA IMAGEM
    if ($_FILES["foto"]["error"] = !UPLOAD_ERR_NO_FILE) {

       $erros[] = "O ARQUIVO PRECISA DE UMA IMAGEM";

    } else{

        $imagemInfos = getimagesize($_FILES["foto"]["tmp"]);

        if ($_FILES["foto"]["size"] > 1024 * 1024 *2) {
        
         $erros[] = "ARQUIVO NÃO PODE SER MAIOR QUE 2MB";

        }

        $width = $imagemInfos[0];
        $height = $imagemInfos[1];

        if ($width != $height){
            $erros[] = "A IMAGEM PRECISA SER QUADRADA";
        }
    }

    return $erros;
}

switch ($_POST['acao']) {
    case 'inserir':

        $erros = validarCampos();

        if (count($erros) > 0) {
     
            $_SESSION["erros"] = $erros;

            header("location: novo/index.php");

            exit;
        }

       
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

        case 'deletar':

            $produtoId = $_POST['produtoId'];

            $sql = "SELECT imagem FROM tbl_produto WHERE id = $produtoId";

            $resultado = mysqli_query($conexao, $sql);

            $produto = mysqli_fetch_array($resultado);

            $sql = "DELETE FROM tbl_produto WHERE id = $produtoId";

            $resultado = mysqli_query($conexao, $sql);

            unlink("./fotos/" . $produto[0]);

            header('location: index.php');
        
            break;

    default:

        break;
}