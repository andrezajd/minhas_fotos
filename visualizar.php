<?php

include("conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM fotos WHERE id = $id";

$resultado = mysqli_query($conexao, $sql);

$dados = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>

        body{
            font-family: Arial;
            text-align: center;
            background: #f2f2f2;
        }

        img{
            width: 600px;
            margin-top: 30px;
            border-radius: 20px;
        }

        a{
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: black;
            color: white;
            text-decoration: none;
            border-radius: 10px;
        }

    </style>

</head>
<body>

<h1><?php echo $dados['descricao']; ?></h1>

<img src="uploads/<?php echo $dados['imagem']; ?>">

<br>

<a href="index.php">Voltar</a>

</body>
</html>